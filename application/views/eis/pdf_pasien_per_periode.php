<?php echo messages(); ?>
<div class="card">
    <div class="card-header">
        <h5><?php echo $template['title'] ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="" id="filter-pasien">
            <div class="row">
                <div class="col-md-7">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Tanggal Daftar</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?php echo date("Y-m-d",strtotime("-1 week")) ?>" class="form-control">
                                        <input type="text" id="tanggal_awal_show" value="<?php echo $this->utility->mysql_to_tanggal(date("Y-m-d",strtotime("-1 week"))) ?>" class="form-control text-right">
                                    </div> _
                                    <div class="col-md-5">
                                        <input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?php echo date('Y-m-d') ?>" class="form-control">
                                        <input type="text" id="tanggal_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal(date("Y-m-d")) ?>" class="form-control text-right">
                                    </div>
                                </div>
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
        let tglAwal = $('#tanggal_awal').val();
        let tglAkhir = $('#tanggal_akhir').val();

        var chart = echarts.init(document.getElementById('eis-pdf'));

        chart.showLoading();

        var params = '?tanggal_awal='+tglAwal+'&tanggal_akhir='+tglAkhir;

        $.getJSON('https://onemedic.co.id/demo/pendaftaran/api/eis_pendaftaran/pasien_per_periode'+params, function (json_data) {
            chart.hideLoading();
            // console.log(JSON.parse(JSON.stringify(json_data.data)));
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
            let tglAwal = $('#tanggal_awal').val();
            let tglAkhir = $('#tanggal_akhir').val();
            
            chart.showLoading();

            var params = '?tanggal_awal='+tglAwal+'&tanggal_akhir='+tglAkhir;

            $.get('https://onemedic.co.id/demo/pendaftaran/api/eis_pendaftaran/pasien_per_periode'+params).done(function(json_data) {
                chart.hideLoading();
                chart.setOption({
                    xAxis: {
                        type : 'category',
                        data : json_data.data.key
                    },
                    series: [
                        {
                            name: 'Jumlah Pasien Per Periode',
                            type: 'bar',
                            data: json_data.data.val
                        }
                    ]
                });
            });
        }

        
        $('select[name="dokter_id"], select[name="poli_id"]').on('change', function(){
            reload_chart();
        });
        $('#tanggal_awal_show').datepicker({
            language: 'id',
            format: 'dd MM yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            $('#tanggal_awal').val(e.format('yyyy-mm-dd'));
            reload_chart();
        });
        $('#tanggal_akhir_show').datepicker({
            language: 'id',
            format: 'dd MM yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            $('#tanggal_akhir').val(e.format('yyyy-mm-dd'));

            reload_chart();
        });




    });
</script>

