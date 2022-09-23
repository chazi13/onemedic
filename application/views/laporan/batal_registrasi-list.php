<!-- BEGIN CONTENT-->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><?php echo $template['title']?></h5>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="post" action="" id="filter-pasien">
            <div class="col-lg-7">
                <div class="form-group row">
                    <label for="pasien_nama" class="col-lg-3 control-label">Tanggal Daftar</label>
                    <div class="col-lg-8">
                        <div class="input-group">
                            <input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?php echo date("Y-m-d",strtotime("-1 month")) ?>" class="form-control">
                            <input type="text" id="tanggal_awal_show" value="<?php echo $this->utility->mysql_to_tanggal(date("Y-m-d",strtotime("-1 month"))) ?>" class="form-control text-right">
                            <span class="input-group-append">
                                <button class="btn btn-light" type="button">s.d</button>
                            </span>
                            <input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?php echo date('Y-m-d') ?>" class="form-control">
                            <input type="text" id="tanggal_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal(date("Y-m-d")) ?>" class="form-control text-right">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr/>
        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="report-table">
                <thead>
                    <tr>
                        <th style="width: 115px;">Nomor Registrasi</th>
                        <th style="width: 180px;">Nama Pasien</th>
                        <th>Alamat</th>
                        <th style="width: 170px;">Poliklinik</th>
                        <th style="width: 150px;">Dokter</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
                
<script>

    $(document).ready(function() {
        
        $('#tanggal_awal_show').datepicker({
            language: 'id',
            format: 'dd MM yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            $('#tanggal_awal').val(e.format('yyyy-mm-dd'));
        });
        $('#tanggal_akhir_show').datepicker({
            language: 'id',
            format: 'dd MM yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            $('#tanggal_akhir').val(e.format('yyyy-mm-dd'));
        });
        
        var dataTables = $("#report-table").DataTable({
            "processing": true,
            "serverSide": true,
            "dom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "ajax": {
                "url": "<?php echo site_url('laporan/batal_registrasi/datatables') ?>",
                "type": "POST",
                "data": function(d) {
                    d.tanggal_awal = $('#tanggal_awal').val();
                    d.tanggal_akhir = $('#tanggal_akhir').val();
                }
            },
            "columns": [
                {"data": "no_reg"},
                {"data": "nama"},
                {"data": "alamat"},
                {"data": "poliklinik"},
                {"data": "dokter"}
            ]

        });

        $("#tgl_awal_show, #tgl_akhir_show").on('change', function() {
            dataTables.ajax.reload();
        });
        
    });
</script>

