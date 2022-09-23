<?php echo messages(); ?>
<div class="card">
    <div class="card-header">
        <h5><?php echo $template['title'] ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="" id="filter-pasien">
            <div class="row">
                <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Tanggal Daftar</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?php echo date("Y-m-d",strtotime("-1 week")) ?>" class="form-control">
                                        <input type="text" id="tanggal_awal_show" value="<?php echo $this->utility->mysql_to_tanggal(date("Y-m-d",strtotime("-1 week"))) ?>" class="form-control text-right">
                                    </div> _
                                    <div class="col-md-5">
                                        <input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?php echo date('Y-m-d') ?>" class="form-control">
                                        <input type="text" id="tanggal_akhir_show" value="<?php echo $this->utility->mysql_to_tanggal(date("Y-m-d")) ?>" class="form-control text-right">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Shift</label>
                            <div class="col-md-7">
                                <?php echo form_dropdown('shift_jam_kerja', $optionsShiftJamKerja, '', 'id="shift_jam_kerja" class="form-control" '); ?>
                            </div>
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Tipe Pasien</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('tipe_pasien_id', $optionsTipePasien, 0, 'id="tipe_pasien_id" class="form-control" '); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Dokter</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('dokter_id', $optionsDokter, 0, 'id="dokter_id" class="form-control" '); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Poliklinik</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('poli_id', $optionsPoli, 0, 'id="poli_id" class="form-control" '); ?>
                            </div>
                        </div>
                </div>
            </div>
        </form>
        <table class="display table table-bordered table-striped" id="dynamic-table-ajax-source">
            <thead>
                <tr>
                    <th>id</th>
                    <th>pasien_id</th>
                    <th style="width: 105px;">No. Registrasi</th>
                    <th style="width: 180px;">Nama Pasien</th>
                    <th>Alamat</th>
                    <th style="width: 190px;">Poliklinik</th>
                    <th style="width: 210px;">Dokter</th>
                    <th style="width: 140px;">&nbsp;</th>
                </tr>
            </thead>
        </table>
    </div>
</div><!--end .row -->
<div id="load-dialog"></div>

<script>
    $(document).ready(function() {
        
        $('#shift_jam_kerja, #tipe_pasien_id, #dokter_id, #poli_id').select2();

        $('#tanggal_awal_show').datepicker({
            language: 'id',
            format: 'dd MM yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            $('#tanggal_awal').val(e.format('yyyy-mm-dd'));
            dataTables.draw();
        });
        $('#tanggal_akhir_show').datepicker({
            language: 'id',
            format: 'dd MM yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            $('#tanggal_akhir').val(e.format('yyyy-mm-dd'));
            dataTables.draw();
        });
        $('select[name="shift_jam_kerja"], select[name="tipe_pasien_id"], select[name="dokter_id"], select[name="poli_id"]').on('change', function(){
            dataTables.draw();
        });

        var dataTables = $("#dynamic-table-ajax-source").DataTable({
            "processing": true,
            "serverSide": true,
            "dom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                "search": '<span>Filter:</span> _INPUT_',
                "searchPlaceholder": 'Type to filter...',
                "lengthMenu": '<span>Show:</span> _MENU_',
                "paginate": { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
            "ajax": {
                "url": "<?php echo site_url('pendaftaran/history/datatables') ?>",
                "type": "POST",
                "data": function(d) {
                    d.tanggal_awal = $('#tanggal_awal').val();
                    d.tanggal_akhir = $('#tanggal_akhir').val();
                    d.shift_jam_kerja = $('#shift_jam_kerja').val();
                    d.tipe_pasien_id = $('#tipe_pasien_id').val();
                    d.dokter_id = $('#dokter_id').val();
                    d.poli_id = $('#poli_id').val();
                }
            },
            "columns": [
                {"data": "id", "searchable": false, "bVisible": false},
                {"data": "pasien_id", "searchable": false, "bVisible": false},
                {"data": "no_reg"},
                {"data": "nama"},
                {"data": "alamat"},
                {"data": "poliklinik"},
                {"data": "dokter"},
                {"data": "link"}
            ]

        });

        // $('#filter-button').on('click', function() {
        //     dataTables.draw();
        // });
        
        // $('#download-button').on('click', function() {
        //     var url = '<?php echo site_url("pendaftaran/history_download")?>';
        //     var dataForm = $( "form#filter-pasien" ).serializeArray();
        //     dataForm.push( {name:'action', value:'download'} );
        //     $.ajax({
        //         url: url,
        //         type: "POST",
        //         data: dataForm,
        //         async: true,
        //         success: function (response) {
        //         },
        //         error: function () {}
        //     }); 
        // });
        

        $('table').on("click", "[data-button=dialog-kartu]", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#load-dialog').load(url);
        });

        $('table').on("click", "[data-button=dialog-form-pemeriksaan]", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#load-dialog').load(url);
        });

        $('table').on("click", "[data-button=batal]", function(e) {
            $.getJSON("<?php echo site_url('pendaftaran/get_data_json/290') ?>", function(data) {
                $('p#pendaftaran-no_reg').text(': ' + data.no_reg);
                $('p#pendaftaran-nama').text(': ' + data.nama);
                $('p#pendaftaran-alamat').text(': ' + data.alamat);
                $('p#pendaftaran-poli').text(': ' + data.poli_nama);
            });
            $('#batal-modal-continue').attr('href', $(this).attr('href'));
            $('#batal-modal-continue').on('click', function(e) {
                var url = $(this).attr('href');
                var alasanPembatalan = $('select[name="alasan_pembatalan"]').val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {alasan: alasanPembatalan},
                    success: function() {
                        $('#batal-modal').modal('toggle');
                        dataTables.draw();
                    }
                });
            });
            $('#batal-modal').modal('show');
            e.preventDefault();
        });
    });
</script>

