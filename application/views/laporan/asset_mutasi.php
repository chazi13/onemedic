<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-body">
            <form class="form-horizontal" method="post" action="" id="filter-laporan">
                <input type="hidden" name="tgl_awal" id="tgl_awal" value="<?php echo $tgl_awal?>" />
                <input type="hidden" name="tgl_akhir" id="tgl_akhir" value="<?php echo $tgl_akhir?>" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-lg-3 control-label">Jenis Barang</label>
                            <div class="col-lg-7">
                            <?php echo form_dropdown('jenis_barang_id', $optionsJenisBarang, '', 'class="form-control"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-lg-2 control-label">Periode</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="text" name="tgl_awal_show" id="tgl_awal_show" value="<?php echo $this->utility->mysql_to_tanggal($tgl_awal)?>"  class="form-control text-right" />
                                    <span class="input-group-append">
                                        <button class="btn btn-light" type="button">s.d</button>
                                    </span>
                                    <input type="text" name="tgl_akhir_show" id="tgl_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal($tgl_akhir)?>"  class="form-control text-right" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-lg-3 control-label">Dari Lokasi</label>
                            <div class="col-lg-7">
                            <?php echo form_dropdown('lokasi_barang_id_dari', $optionsLokasiBarang, '', 'class="form-control"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-lg-3 control-label">Ke Lokasi</label>
                            <div class="col-lg-7">
                            <?php echo form_dropdown('lokasi_barang_id_ke', $optionsLokasiBarang, '', 'class="form-control"'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <table class="display table table-bordered table-striped" id="lap-mutasi-asset">
                <thead>
                    <tr>
                        <th style="width:150px;">Tgl. Mutasi</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Dari</th>
                        <th>Ke</th>
                    </tr>
                </thead>
            </table>
    </div>
</div>


<script>
    $(function() {
        
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

        var dataTables = $("#lap-mutasi-asset").DataTable({
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
                "url": "<?php echo site_url('laporan/asset_mutasi/datatables_sourcedata') ?>",
                "type": "POST",
                "data": function(d) {
                    d.jenis_barang_id = $('select[name="jenis_barang_id"]').val();
                    d.lokasi_barang_id_dari = $('select[name="lokasi_barang_id_dari"]').val();
                    d.lokasi_barang_id_ke = $('select[name="lokasi_barang_id_ke"]').val();
                    d.tgl_awal = $('input[name="tgl_awal"]').val();
                    d.tgl_akhir = $('input[name="tgl_akhir"]').val();
                    // d.unit_id = $('select[name="unit_id"]').val();
                }
            },
            "columns": [
                {
                    "data": "tanggal_mutasi",
                    "render": function (data, type, row, meta) {
                        return moment(data).isValid() ? moment(data).lang("id").format('DD MMMM YYYY') : data;
                    },
                    "searchable": false,
                    "className": "text-right"
                },
                {"data": "barang_kode"},
                {"data": "barang_nama"},
                {"data": "lokasi_barang_nama_dari"},
                {"data": "lokasi_barang_nama_ke"}
            ]

        });

        $('select[name="unit_id"], select[name="jenis_barang_id"], select[name="lokasi_barang_id_dari"], select[name="lokasi_barang_id_ke"], input[name="tgl_awal_show"], input[name="tgl_akhir_show"]').on('change', function() {
            dataTables.draw();
        });
    });
</script>
