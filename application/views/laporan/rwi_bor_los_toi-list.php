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
                <label class="col-lg-2 control-label">Tanggal</label>
                <div class="col-lg-5">
                    <div class="input-group">
                        <input type="text" name="tanggal_awal_show" id="tanggal_awal_show" value="<?php echo $this->utility->mysql_to_tanggal($tglAwal)?>"  class="form-control text-right" />
                        <span class="input-group-append">
                            <button class="btn btn-light" type="button">s.d</button>
                        </span>
                        <input type="text" name="tanggal_akhir_show" id="tanggal_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal($tglAkhir)?>"  class="form-control text-right" />
                    </div>
                </div>
            </div>
        </form>
        <hr/>
        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="report-table">
                <thead>
                    <tr>
                        <th style="width: 15px;" rowspan="2">NO</th>
                        <th rowspan="2">BANGSAL</th>
                        <th rowspan="2">JML T.T x JML HARI</th>
                        <th rowspan="2">PASIEN AWAL</th>
                        <th rowspan="2">PASIEN MASUK</th>
                        <th rowspan="2">TOTAL (4+5)</th>
                        <th rowspan="2">TTL PASIEN KLR HIDUP</th>
                        <th colspan="3">PASIEN MENINGGAL</th>
                        <th rowspan="2">TTL PASIEN KLR HIDUP & MATI (7+8)</th>
                        <th rowspan="2">JML LD</th>
                        <th rowspan="2">PASIEN SISA</th>
                        <th rowspan="2">JML HP</th>
                        <th rowspan="2">PASIEN MSK & KLR PD HR YG SM</th>
                        <th rowspan="2">BOR</th>
                        <th rowspan="2">LOS</th>
                        <th rowspan="2">TOI</th>
                        <th rowspan="2">BTO</th>
                        <th rowspan="2">NDR</th>
                        <th rowspan="2">GDR</th>
                    </tr>
                    <tr>
                        <td>TOTAL</td>
                        <td>< 48 JAM</td>
                        <td>> 48 JAM</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6"></td>
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
                            'url': '<?php echo site_url("laporan/rwi_bor_los_toi/datatables")?>',
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
