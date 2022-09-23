<?php echo messages(); ?>
<div class="card">
    <div class="card-header">
        <h5><?php echo $template['title'] ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="" id="filter-pasien">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group row">
                        <label class="col-form-label col-md-3">Tahun</label>
                        <div class="col-md-6">
                            <?php echo form_dropdown('tahun', $optionsTahun, date('Y'), 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-form-label col-md-3">Bulan</label>
                        <div class="col-md-8">
                            <?php echo form_dropdown('bulan', $optionsBulan, date('m'), 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="chart-container">
        <div class="chart has-fixed-height" id="eis-pdf"></div>
    </div>
</div><!--end .row -->

<script>
    $(document).ready(function() {
        let tahun = $('select[name="tahun"]').val();
        let bulan = $('select[name="bulan"]').val();

        var chart = echarts.init(document.getElementById('eis-pdf'));

        chart.showLoading();

        var params = '?tahun='+tahun+'&bulan='+bulan;

        $.getJSON('https://onemedic.co.id/demo/pendaftaran/api/eis_pendaftaran/pasien_per_bulan'+params, function (json_data) {
            chart.hideLoading();
            option = {
                tooltip : {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow',
                        label: {
                            show: true
                        }
                    }
                },
                toolbox: {
                    show : true,
                    feature : {
                        magicType: {show: true, type: ['line', 'bar']},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                legend: {
                    data:['Growth', 'Budget 2011', 'Budget 2012'],
                    itemGap: 5
                },
                grid: {
                    top: '12%',
                    left: '10%',
                    right: '10%',
                    containLabel: true
                },
                xAxis: [
                    {
                        type : 'category',
                        data : json_data.data.key
                    }
                ],
                yAxis: [
                    {
                        type : 'value',
                        name : 'Jumlah'
                    }
                ],
                series : [
                    {
                        name: 'Jumlah Pasien',
                        type: 'bar',
                        data: json_data.data.val
                    }
                ]
            };

            chart.setOption(option);

        });

        function reload_chart(){
            let tahun = $('select[name="tahun"]').val();
            let bulan = $('select[name="bulan"]').val();
            
            chart.showLoading();

            var params = '?tahun='+tahun+'&bulan='+bulan;

            $.get('https://onemedic.co.id/demo/pendaftaran/api/eis_pendaftaran/pasien_per_bulan'+params).done(function(json_data) {
                chart.hideLoading();
                chart.setOption({
                    xAxis: {
                        type : 'category',
                        data : json_data.data.key
                    },
                    series: [
                        {
                            name: 'Jumlah Pasien Per Bulan',
                            type: 'bar',
                            data: json_data.data.val
                        }
                    ]
                });
            });
        }

        
        $('select[name="tahun"], select[name="bulan"]').on('change', function(){
            reload_chart();
        });

    });
</script>

