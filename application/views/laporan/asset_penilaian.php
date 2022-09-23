<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5><?php echo $template['title'] ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="" id="filter-pasien">
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
        </form>
        <table class="display table table-bordered table-striped" id="lap-daftar-asset">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Tgl. Penilaian</th>
                    <th>Harga</th>
                </tr>
            </thead>
        </table>
    </div>
</div><!--end .row -->
<?php $this->load->view('delete-modal')?>
<script>
    $(document).ready(function() {
        
        $('select[name="jenis_barang_id"], select[name="lokasi_barang_id"], select[name="kondisi_barang_id"]').select2();

        var dataTables = $("#lap-daftar-asset").DataTable({
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
                "url": "<?php echo site_url('laporan/asset_penilaian/datatables_sourcedata') ?>",
                "type": "POST",
                "data": function(d) {
                    d.jenis_barang_id = $('select[name="jenis_barang_id"]').val();
                    d.lokasi_barang_id = $('select[name="lokasi_barang_id"]').val();
                    d.unit_id = $('select[name="unit_id"]').val();
                }
            },
            "columns": [
                {"data": "kode"},
                {"data": "nama"},
                {"data": "merk_nama"},
                {"data": "tipe_nama"},
                {
                    "data": "tanggal_penilaian",
                    "render": function (data, type, row, meta) {
                        return moment(data).isValid() ? moment(data).lang("id").format('DD MMMM YYYY') : data;
                    },
                    "searchable": false,
                    "className": "text-right"
                },
                {
                    "data": "harga_penilaian",
                    "render": function (data, type, row, meta) {
                        if(data){
                            return data.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }else{
                            return '0';
                        }
                    },
                    "className": "text-right"
                }
            ]

        });

        $('select[name="unit_id"], select[name="jenis_barang_id"], select[name="lokasi_barang_id"], select[name="kondisi_barang_id"]').on('change', function() {
            dataTables.draw();
        });
    });
</script>
