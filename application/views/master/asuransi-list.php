<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Asuransi</h5>
        <div class="header-elements">
			<a href="<?php echo site_url('master/asuransi/add') ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</a>
		</div>
    </div>
    <div class="card-body">
		<div class="table-responsive">
			<table id="tabel-asuransi" class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telp</th>
                        <th>Email</th>
                        <th>Kontak</th>
                        <th style="width: 80px;">&nbsp;</th>
                    </tr>
                </thead>
			</table>
		</div><!--end .table-responsive -->
	</div>
</div>

<?php $this->load->view('delete-modal'); ?>

<script>
    $(document).ready(function() {
        var dataTables = $("#tabel-asuransi").DataTable({
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
                "url": "<?php echo site_url('master/asuransi/datatables_sourcedata') ?>",
                "type": "POST"
            },
            "columns": [
                {"data": "nama"},
                {"data": "alamat"},
                {"data": "telepon"},
                {"data": "email"},
                {"data": "contact_person"},
                {"data": "link"}
            ],
            "aaSorting": [[0,'asc']]
        });

    });
</script>