<!-- BEGIN CONTENT-->
<?php echo messages(); ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Rekening Bank</h5>
        <div class="header-elements">
			<a href="<?php echo site_url('master/rekening_bank/add') ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</a>
		</div>
    </div>
    <div class="card-body">
		<div class="table-responsive">
			<table id="tabel-rekening_bank" class="table">
                <thead>
                    <tr>
                        <th>Bank</th>
                        <th>No. Rekening</th>
                        <th>Atas Nama</th>
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
        var dataTables = $("#tabel-rekening_bank").DataTable({
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
                "url": "<?php echo site_url('master/rekening_bank/datatables_sourcedata') ?>",
                "type": "POST"
            },
            "columns": [
                {"data": "nama"},
                {"data": "nomor_rekening"},
                {"data": "atas_nama"},
                {"data": "link"}
            ],
            "aaSorting": [[0,'asc']]
        });

    });
</script>