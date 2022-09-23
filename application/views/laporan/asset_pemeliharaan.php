<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-body">
        <form method="post" action="" id="filter" class="form-horizontal"> 
            <input type="hidden" name="tgl_awal" id="tgl_awal"  value="<?php echo $tgl_awal; ?>" />
            <input type="hidden" name="tgl_akhir" id="tgl_akhir"  value="<?php echo $tgl_akhir;?>" />
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Golongan</label>
                        <div class="col-md-8">
                            <?php echo form_dropdown('jenis_barang_id', $optionsJenisBarang, '', 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-form-label col-md-3">Lokasi</label>
                        <div class="col-md-9">
                        <?php echo form_dropdown('lokasi_barang_id', $optionsLokasiBarang, '', 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="form-group row">
                        <label for="usia_dari" class="col-lg-3 control-label">Periode</label>
                        <div class="col-lg-8">
                            <div class="input-group">
                                <input type="text" name="tgl_awal" id="tgl_awal_show" value="<?php echo $this->utility->mysql_to_tanggal($tgl_awal) ; ?>"  class="form-control text-right" />
                                <span class="input-group-append">
                                    <button class="btn btn-light" type="button">s.d</button>
                                </span>
                                <input type="text" name="tgl_akhir" id="tgl_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal($tgl_akhir) ; ?>"  class="form-control text-right" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <table class="display table table-bordered table-striped" id="lap-pemeliharaan">
            <thead>
                <tr>
                    <th style="width:170px;">Tgl. Pemeliharaan</th>
                    <th style="width:140px;">Kode</th>
                    <th>Nama</th>
                    <th style="width:110px;">Kondisi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        
        $('select').select2();

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

        var dataTables = $("#lap-pemeliharaan").DataTable({
            "processing": true,
            "serverSide": true,
            "dom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                "search": '<span>Filter:</span> _INPUT_',
                "searchPlaceholder": 'Type to filter...',
                "lengthMenu": '<span>Show:</span> _MENU_',
                "paginate": { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
            "searching": false,
            "paging": false,
            "info": false,
            "ajax": {
                "url": "<?php echo site_url('laporan/asset_pemeliharaan/datatables_sourcedata') ?>",
                "type": "POST",
                "data": function(d) {
                    d.jenis_barang_id = $('select[name="jenis_barang_id"]').val();
                    d.lokasi_barang_id = $('select[name="lokasi_barang_id"]').val();
                    d.tgl_awal = $('input[name="tgl_awal"]').val();
                    d.tgl_akhir = $('input[name="tgl_akhir"]').val();
                }
            },
            "columns": [
                {
                    "data": "tanggal_pemeliharaan",
                    "render": function (data, type, row, meta) {
                        return moment(data).isValid() ? moment(data).lang("id").format('DD MMMM YYYY') : data;
                    },
                    "searchable": false,
                    "className": "text-right"
                },
                {"data": "barang_kode"},
                {"data": "barang_nama"},
                {"data": "kondisi_nama"},
                {"data": "catatan"}
            ]

        });

        $('select[name="unit_id"], select[name="jenis_barang_id"], select[name="lokasi_barang_id"], input[name="tgl_awal"], input[name="tgl_akhir"]').on('change', function() {
            dataTables.draw();
        });
    });
</script>