<?php echo messages(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5><?php echo $template['title'] ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="" id="filter-pasien">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Unit</label>
                        <div class="col-md-8">
                            <?php echo form_dropdown('unit_id', $optionsUnit, '', 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Golongan</label>
                        <div class="col-md-8">
                            <?php echo form_dropdown('jenis_barang_id', $optionsJenisBarang, '', 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Chart data colors -->
        <div class="panel panel-flat">
            <div class="panel-body chart-area">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
        <!-- /chart data colors -->
    </div>
</div><!--end .row -->
<?php $this->load->view('delete-modal')?>
<script>
    $(document).ready(function() {
        
        $('select[name="jenis_barang_id"], select[name="unit_id"]').select2();

        create_chart();
        
        function create_chart(){
            $('div.chart-area').block();
            var unitId = $('select[name="unit_id"]').val();
            var jenisBarangId = $('select[name="jenis_barang_id"]').val();
            $.ajax({
                    url: "<?php echo site_url('eis/asset_jumlah/sourcedata')?>",
                    method: "POST",
                    data: { unit_id: unitId, jenis_barang_id: jenisBarangId},
                    success: function(data) {
                        $('.chart-area').empty();
                        $('.chart-area').html('<canvas id="myChart" width="400" height="400"></canvas>');
  
                        var ctx = $('#myChart');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                datasets: [{
                                    label: data.title,
                                    data: data.values,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                        $('div.chart-area').unblock();
                    }
            });
        }

        $('select[name="jenis_barang_id"], select[name="unit_id"]').on('change', function() {
            create_chart();
        });
    });
</script>
