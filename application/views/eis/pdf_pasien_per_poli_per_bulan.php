<?php echo messages(); ?>
<div class="card">
    <div class="card-header">
        <h5><?php echo $template['title'] ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="" id="filter-pasien">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-form-label col-md-3">Poliklinik</label>
                        <div class="col-md-9">
                            <?php echo form_dropdown('poli_id', $optionsPoli, 0, 'id="poli_id" class="form-control" '); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-form-label col-md-3">Periode</label>
                        <div class="col-md-5">
                            <?php echo form_dropdown('bulan_awal', $optionsBulan, date('m'), 'class="form-control"'); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo form_dropdown('tahun_awal', $optionsTahun, date('Y'), 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">s.d</label>
                        <div class="col-md-5">
                            <?php echo form_dropdown('bulan_akhir', $optionsBulan, date('m'), 'class="form-control"'); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo form_dropdown('tahun_akhir', $optionsTahun, date('Y'), 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
    <div class="row">
        <div class="chart-container">
        <div class="chart has-fixed-height" id="eis-pdf" style="height:600px;"></div>
    </div>
</div><!--end .row -->

<script>
    $(document).ready(function() {
        var colors = ["#fd7f6f", "#7eb0d5", "#b2e061", "#bd7ebe", "#ffb55a", "#ffee65", "#beb9db", "#fdcce5", "#8bd3c7"];

        let poliId = $('#poli_id').val();
        let bulanAwal = $('select[name="bulan_awal"]').val();
        let tahunAwal = $('select[name="tahun_awal"]').val();
        let bulanAkhir = $('select[name="bulan_akhir"]').val();
        let tahunAkhir = $('select[name="tahun_akhir"]').val();

        var chart = echarts.init(document.getElementById('eis-pdf'));

        chart.showLoading();

        var params = '?bulan_awal='+bulanAwal+'&tahun_awal='+tahunAwal+'&bulan_akhir='+bulanAkhir+'&tahun_akhir='+tahunAkhir+'&poli_id='+poliId;

        $.getJSON('<?php echo site_url()?>/api/eis_pendaftaran/pasien_per_bulan_tahun_per_poli'+params, function (json_data) {
            var data = json_data.data.val;

            let category = [];
            let seriesData = [];
            if(data){
                let seriesData = data.map((item, index) => {
                    console.log(item);
                    category.push(item);
                    return {
                        value: item,
                        itemStyle: {
                            color: colors[index % colors.length]
                        }
                    }
                });
            }
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
                        // mark : {show: true},
                        // dataView : {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        // restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                legend: {
                    data:['Growth', 'Budget 2011', 'Budget 2012'],
                    itemGap: 5
                },
                grid: {
                    top: '2%',
                    left: '5%',
                    right: '10%',
                    containLabel: true
                },
                xAxis: [
                    {
                        type : 'category',
                        data : json_data.data.key,
						axisLabel: {
							show: true,
							interval: 0,
						  },
						  axisTick: {
							show: true,
							interval: 0
						  }
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
                        data: seriesData
                    }
                ]
            };

            chart.setOption(option);

        });

        function reload_chart(){
            let poliId = $('#poli_id').val();
            let bulanAwal = $('select[name="bulan_awal"]').val();
            let tahunAwal = $('select[name="tahun_awal"]').val();
            let bulanAkhir = $('select[name="bulan_akhir"]').val();
            let tahunAkhir = $('select[name="tahun_akhir"]').val();
            
            chart.showLoading();

            var params = '?bulan_awal='+bulanAwal+'&tahun_awal='+tahunAwal+'&bulan_akhir='+bulanAkhir+'&tahun_akhir='+tahunAkhir+'&poli_id='+poliId;

            $.get('<?php echo site_url()?>/api/eis_pendaftaran/pasien_per_bulan_tahun_per_poli'+params).done(function(json_data) {
                chart.hideLoading();

                // can be any length
                var data = json_data.data.val;

                let category = [];

                let seriesData = data.map((item, index) => {
                    category.push(item);
                    return {
                        value: item,
                        itemStyle: {
                            color: colors[index % colors.length]
                        }
                    }
                });

                chart.setOption({
                    xAxis: {
                        type : 'category',
                        data : json_data.data.key
                    },
                    series: [
                        {
                            name: 'Jumlah Pasien',
                            type: 'bar',
                            data: seriesData
                        }
                    ]
                });
            });
        }

        
        $('select').on('change', function(){
            reload_chart();
        });

    });
</script>
