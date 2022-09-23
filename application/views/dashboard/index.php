<!-- Main charts -->
<div class="row">
    <div class="col-xl-8">

        <!-- Kunjungan Hari Ini -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Kunjungan Hari Ini</h6>
            </div>

            <div class="card-body py-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <a href="#" class="btn bg-transparent border-teal text-teal rounded-round border-2 btn-icon mr-3">
                                <i class="icon-plus3"></i>
                            </a>
                            <div>
                                <div class="font-weight-semibold">Pasien Baru</div>
                                <span class="text-muted">120 pasien</span>
                            </div>
                        </div>
                        <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                    </div>

                    <div class="col-sm-4">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <a href="#" class="btn bg-transparent border-warning-400 text-warning-400 rounded-round border-2 btn-icon mr-3">
                                <i class="icon-spinner11"></i>
                            </a>
                            <div>
                                <div class="font-weight-semibold">Pasien Lama</div>
                                <span class="text-muted">130 pasien</span>
                            </div>
                        </div>
                        <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                    </div>

                    <div class="col-sm-4">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <a href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon mr-3">
                                <i class="icon-people"></i>
                            </a>
                            <div>
                                <div class="font-weight-semibold">Total</div>
                                <span class="text-muted"><span class="badge badge-mark border-success mr-2"></span> 250 pasien</span>
                            </div>
                        </div>
                        <div class="w-75 mx-auto mb-3" id="total-online"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="chart-container">
                    <div class="chart has-fixed-height" id="echart-bar"></div>
                </div>
               </div>
            </div>

            
        </div>
        <!-- /Kunjungan Hari Ini -->

    </div>

    <div class="col-xl-4">

        <!-- Sales stats -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Dokter Praktek</h6>
                <div class="header-elements">
                    <select class="form-control" id="select_date" data-fouc>
                        <option value="val1">June, 29 - July, 5</option>
                        <option value="val2">June, 22 - June 28</option>
                        <option value="val3" selected>June, 15 - June, 21</option>
                        <option value="val4">June, 8 - June, 14</option>
                    </select>
                </div>
            </div>

            <div class="card-body py-0">
                <div class="row">
                    <div class="dropdown-content-body dropdown-scrollable">
                        <ul class="media-list">
                            <li class="media">
                                <div class="mr-3 position-relative">
                                    <img src="<?php echo base_url()?>assets/img/doctor-icon.png" width="36" height="36" class="rounded-circle" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">dr. Andri</span>
                                            <span class="text-muted float-right font-size-sm">08:00 - 10:00</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">Poliklinik Umum</span>
                                </div>
                            </li>
                            <li class="media">
                                <div class="mr-3 position-relative">
                                    <img src="<?php echo base_url()?>assets/img/doctor-icon.png" width="36" height="36" class="rounded-circle" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">dr. Yuli</span>
                                            <span class="text-muted float-right font-size-sm">08:00 - 10:00</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">Poliklinik Anak</span>
                                </div>
                            </li>
                            <li class="media">
                                <div class="mr-3 position-relative">
                                    <img src="<?php echo base_url()?>assets/img/doctor-icon.png" width="36" height="36" class="rounded-circle" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">dr. Santi</span>
                                            <span class="text-muted float-right font-size-sm">08:00 - 10:00</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">Poliklinik Gigi dan Mulut</span>
                                </div>
                            </li>
                            <li class="media">
                                <div class="mr-3 position-relative">
                                    <img src="<?php echo base_url()?>assets/img/doctor-icon.png" width="36" height="36" class="rounded-circle" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">dr. Januari</span>
                                            <span class="text-muted float-right font-size-sm">08:00 - 10:00</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">Poliklinik Jantung</span>
                                </div>
                            </li>
                            <li class="media">
                                <div class="mr-3 position-relative">
                                    <img src="<?php echo base_url()?>assets/img/doctor-icon.png" width="36" height="36" class="rounded-circle" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">dr. Maman</span>
                                            <span class="text-muted float-right font-size-sm">08:00 - 10:00</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">Poliklinik Paru</span>
                                </div>
                            </li>
                            <li class="media">
                                <div class="mr-3 position-relative">
                                    <img src="<?php echo base_url()?>assets/img/doctor-icon.png" width="36" height="36" class="rounded-circle" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">dr. Samantha</span>
                                            <span class="text-muted float-right font-size-sm">08:00 - 10:00</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">Poliklinik Kulit dan Kelamin</span>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="chart mb-2" id="app_sales"></div>
            <div class="chart" id="monthly-sales-stats"></div>
        </div>
        <!-- /sales stats -->

    </div>
</div>
<!-- /main charts -->
<script>

getBarGraph();

function getBarGraph(data){
    var dom = document.getElementById('echart-bar');
    var myChart = echarts.init(dom);
    var option = {
        title: {
            // text: 'World Population'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
            type: 'shadow'
            }
        },
        legend: {},
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'value',
            boundaryGap: [0, 0.01]
        },
        yAxis: {
            type: 'category',
            data: ['P. Umum', 'P. THT', 'P. Jantung', 'P. Mata', 'P. Anak', 'P. Gigi dan Mulut']
        },
        series: [
            {
            // name: '2011',
            type: 'bar',
            data: [112, 80, 45, 52, 57, 25],
            itemStyle: {color: 'green'},
            },
            // {
            // name: '2012',
            // type: 'bar',
            // data: [19325, 23438, 31000, 121594, 134141, 681807]
            // }
        ]
        };
    myChart.setOption(option);

}
</script>