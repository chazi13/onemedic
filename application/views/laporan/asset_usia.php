<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5><?php echo $template['title'] ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="" id="filter" class="form-horizontal"> 
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
                <div class="col-md-3">
                    <div class="form-group row">
                        <label class="col-form-label col-md-3">Kondisi</label>
                        <div class="col-md-9">
                        <?php echo form_dropdown('kondisi_barang_id', $optionsKondisiBarang, '', 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="form-group row">
                        <label for="usia_dari" class="col-lg-3 control-label">Range Usia</label>
                        <div class="col-lg-8">
                            <div class="input-group">
                                <?php 
                                $optionsUsia = array('0' => '0 Tahun','1' => '1 Tahun', '2' => '2 Tahun', '3' => '3 Tahun', '4' => '4 Tahun','5' => '5 Tahun');
                                echo form_dropdown('usia_dari', $optionsUsia, '', 'class="form-control"'); 
                                ?>
                                <span class="input-group-append">
                                    <button class="btn btn-light" type="button">s.d</button>
                                </span>
                                <?php 
                                echo form_dropdown('usia_ke', $optionsUsia, '', 'class="form-control"'); 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <table class="display table table-bordered table-striped" id="lap-usia-asset">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Tgl. Perolehan</th>
                    <th>Usia</th>
                </tr>
            </thead>
        </table>
    </div>
</div><!--end .row -->
<script>
    $(document).ready(function() {
        
        $('select').select2();

        var dataTables = $("#lap-usia-asset").DataTable({
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
                "url": "<?php echo site_url('laporan/asset_usia/datatables_sourcedata') ?>",
                "type": "POST",
                "data": function(d) {
                    d.jenis_barang_id = $('select[name="jenis_barang_id"]').val();
                    d.lokasi_barang_id = $('select[name="lokasi_barang_id"]').val();
                    d.kondisi_barang_id = $('select[name="kondisi_barang_id"]').val();
                    d.usia_dari = $('select[name="usia_dari"]').val();
                    d.usia_ke = $('select[name="usia_ke"]').val();
                    d.unit_id = $('select[name="unit_id"]').val();
                }
            },
            "columns": [
                {"data": "kode"},
                {"data": "nama"},
                {"data": "merk_nama"},
                {"data": "tipe_nama"},
                {
                    "data": "tanggal_perolehan",
                    "render": function (data, type, row, meta) {
                        return moment(data).isValid() ? moment(data).lang("id").format('DD MMMM YYYY') : data;
                    },
                    "searchable": false,
                    "className": "text-right"
                },
                {
                    "data": "usia",
                    "render": function (data, type, row, meta) {
                            return data;
                    },
                    "className": "text-right"
                }
            ]

        });

        $('select[name="unit_id"], select[name="jenis_barang_id"], select[name="lokasi_barang_id"], select[name="kondisi_barang_id"], select[name="usia_ke"]').on('change', function() {
            dataTables.draw();
        });
    });
</script>
