<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><?php echo $template['title']?></h5>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="post" action="" id="filter-pasien">
            <input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?php echo $tglAwal?>" />
            <input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?php echo $tglAkhir?>" />
            <div class="form-group row">
                <label class="col-lg-1 control-label">Tanggal</label>
                <div class="col-lg-4">
                    <div class="input-group">
                        <input type="text" name="tanggal_awal_show" id="tanggal_awal_show" value="<?php echo $this->utility->mysql_to_tanggal($tglAwal)?>"  class="form-control text-right" />
                        <span class="input-group-append">
                            <button class="btn btn-light" type="button">s.d</button>
                        </span>
                        <input type="text" name="tanggal_akhir_show" id="tanggal_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal($tglAkhir)?>"  class="form-control text-right" />
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-1 control-label">Poliklinik</label>
                <div class="col-lg-3">
                    <?php echo form_dropdown('poli', $optionPoli, '', 'id="poli" class="form-control"'); ?>
                </div>
                <label class="col-lg-1 control-label">Tipe Pasien</label>
                <div class="col-lg-3">
                    <?php echo form_dropdown('poli', $optionTipePasien, '', 'id="poli" class="form-control"'); ?>
                </div>
            </div>
        </form>
        <hr/>
        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="report-table">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 25px;">No.</th>
                        <th rowspan="2" style="width: 75px;">No. Reg</th>
                        <th rowspan="2" style="width: 75px;">MR</th>
                        <th rowspan="2" style="width: 180px;">Nama Pasien</th>
                        <th rowspan="2">Poliklinik Asal</th>
                        <th colspan="5" class="text-center">Perawatan</th>
                        <th rowspan="5" class="text-center">Total</th>
                    </tr>
                    <tr>
                        <th style="width: 90px;">Administrasi</th>
                        <th style="width: 90px;">Layanan</th>
                        <th style="width: 50px;">Akomodasi</th>
                        <th style="width: 150px;">Obat</th>
                        <th style="width: 110px;">BHP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="11"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(function() {
        $("#tanggal_awal_show").datepicker({
            language: 'id',
            autoclose: true,
            format: 'dd MM yyyy'
        }).on("changeDate", function(e) {
            var tglAwal = e.format('yyyy-mm-dd');
            $('#tanggal_awal').val(tglAwal);
        });
        $("#tanggal_akhir_show").datepicker({
            language: 'id',
            autoclose: true,
            format: 'dd MM yyyy'
        }).on("changeDate", function(e) {
            var tglAkhir = e.format('yyyy-mm-dd');
            $('#tanggal_akhir').val(tglAkhir);
        });
        
        var dataTables = $('#report-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "dom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                        "bDestroy": true,
                        "ajax": {
                            'type': 'POST',
                            'url': '<?php echo site_url("laporan/rwi_pendapatan/datatables")?>',
                            'data': function(params)  {
                                    params.tanggal_awal = $('#tanggal_awal').val();
                                    params.tanggal_akhir = $('#tanggal_akhir').val();
                            }
                        }
                    });
        
        $("#tanggal_awal_show, #tanggal_akhir_show").on('change', function() {
            dataTables.ajax.reload();
        });
        
    });
</script>
