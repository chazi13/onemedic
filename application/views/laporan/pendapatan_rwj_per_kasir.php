<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><?php echo $template['title']?></h5>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="post" action="" id="filter-pasien">
            <input type="hidden" name="tgl_awal" id="tgl_awal" value="<?php echo $tgl_awal?>" />
            <input type="hidden" name="tgl_akhir" id="tgl_akhir" value="<?php echo $tgl_akhir?>" />
            <div class="form-group row">
                <label class="col-lg-1 control-label">Tanggal</label>
                <div class="col-lg-5">
                    <div class="input-group">
                        <input type="text" name="tgl_awal_show" id="tgl_awal_show" value="<?php echo $this->utility->mysql_to_tanggal($tgl_awal)?>"  class="form-control text-right" />
                        <span class="input-group-append">
                            <button class="btn btn-light" type="button">s.d</button>
                        </span>
                        <input type="text" name="tgl_akhir_show" id="tgl_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal($tgl_akhir)?>"  class="form-control text-right" />
                    </div>
                </div>
                <label class="col-lg-1 control-label">User</label>
                <div class="col-lg-4">
                    <?php echo form_dropdown('user_id', $optionUser, '', 'id="user_id" class="form-control"'); ?>
                </div>
            </div>
        </form>
        <hr/>
        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="report-table">
                <thead>
                    <tr>
                        <td>No. Registrasi</td>
                        <td>No. MR</td>
                        <td>Nama</td>
                        <td>Alamat</td>
                        <td>Poliklinik</td>
                        <td>Dokter</td>
                        <td>Tagihan</td>
                        <td>Penjamin</td>
                        <td>Selisih</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(function() {
        $("#tgl_awal_show").datepicker({
            language: 'id',
            autoclose: true,
            format: 'dd MM yyyy'
        }).on("changeDate", function(e) {
            var tglAwal = e.format('yyyy-mm-dd');
            $('#tgl_awal').val(tglAwal);
        });
        $("#tgl_akhir_show").datepicker({
            language: 'id',
            autoclose: true,
            format: 'dd MM yyyy'
        }).on("changeDate", function(e) {
            var tglAkhir = e.format('yyyy-mm-dd');
            $('#tgl_akhir').val(tglAkhir);
        });
        
        var dataTables = $('#report-table').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "dom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                        "bDestroy": true,
                        "ajax": {
                            'type': 'POST',
                            'url': '<?php echo site_url("laporan/pendapatan_rwj_per_kasir/datatables")?>',
                            'data': function(params)  {
                                    params.tgl_awal = $('#tgl_awal').val();
                                    params.tgl_akhir = $('#tgl_akhir').val();
                                    params.user_id = $('#user_id').val();
                                
                            }
                        }
                    });
        
        $("#tgl_awal_show, #tgl_akhir_show, #user_id").on('change', function() {
            dataTables.ajax.reload();
        });
        
    });
</script>
