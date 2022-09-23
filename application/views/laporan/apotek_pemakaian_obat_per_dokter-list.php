<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><?php echo $template['title']; ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="">
            <input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?php echo $tglAwal; ?>" />
            <input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?php echo $tglAkhir; ?>" />
            <div class="col-lg-12">
                <div class="form-group row">
                    <label class="col-lg-1 control-label">Tanggal</label>
                    <div class="col-lg-5">
                        <div class="input-group">
                            <input type="text" name="tanggal_awal_show" id="tanggal_awal_show" value="<?php echo $this->utility->mysql_to_tanggal(date("Y-m-d",strtotime("-1 month")))?>"  class="form-control text-right" />
                            <span class="input-group-append">
                                <button class="btn btn-light" type="button">s.d</button>
                            </span>
                            <input type="text" name="tanggal_akhir_show" id="tanggal_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal(date('Y-m-d'))?>"  class="form-control text-right" />
                        </div>
                    </div>
                    <label class="col-lg-1 control-label">Dokter</label>
                    <div class="col-lg-4">
                        <?php echo form_dropdown('dokter_id', $optionsDokter, '', ' id="dokter_id" class="form-control"'); ?>
                    </div>
                </div>
            </div>
        </form>
        <hr/>
        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="report-table">
                <thead>
                    <tr>
                        <td class="text-center" >No.</td>
                        <td class="text-center" >Nama Obat</td>
                        <td class="text-center" >Satuan</td>
                        <td class="text-center" >Jumlah</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
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
                            'url': '<?php echo site_url("laporan/apotek_pemakaian_obat_per_dokter/datatables")?>',
                            'data': function(params)  {
                                    params.tanggal_awal = $('#tanggal_awal').val();
                                    params.tanggal_akhir = $('#tanggal_akhir').val();
                                    params.dokter_id = $('#dokter_id').val();
                            }
                        }
                    });
        
        $("#tanggal_awal_show, #tanggal_akhir_show, #dokter_id").on('change', function() {
            dataTables.ajax.reload();
        });
        
    });
</script>
