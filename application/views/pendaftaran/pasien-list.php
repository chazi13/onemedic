<?php echo messages(); ?>
<div class="card">
    <div class="card-header">
        <h5><?php echo $template['title']?></h5>
    </div>
    <div class="card-body">
        <table class="table " id="MyDataTables">
            <thead>
                <tr>
                    <th style="width: 110px;">Nomor MR</th>
                    <th style="width: 220px;">Nama </th>
                    <th>Alamat</th>
                    <th style="width: 190px;">Nama Ayah / Ibu</th>
                </tr>
            </thead>
        </table>
    </div>
</div><!--end .row -->
<div id="load-dialog"></div>
<!-- END CONTENT -->
<script>

    $(document).ready(function() {
        var dataTables = $("#MyDataTables").DataTable({
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
                "url": "<?php echo site_url('pendaftaran/info/pasien_datatables_source') ?>",
                "type": "POST",
                "data": function(d) {
                    d.tanggal_awal = $('#tanggal_awal').val();
                    d.tanggal_akhir = $('#tanggal_akhir').val();
                }
            },
            "columns": [
                {"data": "no_mr",
                    "render": function ( data, type, row ) {
                        return '<a href="<?php echo site_url("pendaftaran/info/pasien/") ?>'+row['no_mr']+'" >'+ row['no_mr'] +'</a>';
                    } 
                },
                {"data": "nama"},
                {"data": "alamat"},
                { "data": "nama_ayah",
                    "render": function ( data, type, row ) {
                        var nama_ayah = '';
                        var nama_ibu = '';
                        if(row['nama_ibu'] !== null ){
                            nama_ibu = ' / '+ row['nama_ibu'] ;
                        }
                        if(row['nama_ayah'] !== null ){
                            nama_ayah =  row['nama_ayah'] ;
                        }
                        return nama_ayah +' '+ nama_ibu +'';
                    } 
                }
            ],
            "columnDefs": [
                { "orderable": false, "targets": 3 }
            ]
        });

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth: true,
            width: 'auto'
        });
        
        $('#filter-button').on('click', function() {
            dataTables.draw();
        });
        
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

    });
</script>

