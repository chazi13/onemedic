<?php echo messages(); ?>

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><?php echo lang('user') ?></h5>
        <div class="header-elements">
            <?php if ($this->acl->is_allowed($controller_uri . '/add')) : ?>
				<a href="<?php echo site_url($controller_uri . '/add') ?>" class="btn bg-teal-400 btn-labeled btn-labeled-left btn-sm" title="<?php echo lang('add') ?>">
                    <b><i class="icon-plus3"></i></b><?php echo lang('add') ?>
				</a>
			<?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <table class="table " id="dataTable_user">
            <thead>
				<tr>
					<th><?php echo lang('email'); ?></th>
					<th><?php echo lang('fullname'); ?></th>
					<th>Role</th>
					<th><?php echo lang('registered'); ?></th>
                    <th>Unit</th>
					<th style="width: 15px;"></th>
				</tr>
            </thead>
        </table>
    </div>
</div><!--end .row -->
<div id="load-dialog"></div>
<!-- END CONTENT -->
<script>

    $(document).ready(function() {
        var dataTables = $("#dataTable_user").DataTable({
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
                "url": "<?php echo site_url($controller_uri . '/datatable'); ?>",
                "type": "POST",
                "data": function(d) {
                    d.tanggal_awal = $('#tanggal_awal').val();
                    d.tanggal_akhir = $('#tanggal_akhir').val();
                }
            },
            "columns": [
				{ 
					"data": "email",
					"render": function(data, type, row, meta) {
						return '<a href="<?php echo site_url($controller_uri . 'edit/') ?>' + row.id + '">' + data + '</a>';
					}
				},
				{ "data": "full_name" },
				{ "data": "role" },
				{ 
					"data": "registered",
					"render": function(data, type, row, meta) {
						if (type === 'display') {
							if (moment(data).isValid()) {
								return '<span class="time" title="' + moment(data).format('DD MMMM YYYY HH:mm:ss') + '">' + moment(data).fromNow() + '</span>';
							}
						}
						return data;
					}
				},
                { "data": "unit_nama" },
				{ 
					"data": "id",
					"orderable": false,
					"render": function(data, type, row, meta) {
						return '<a href="<?php echo site_url($controller_uri . '/delete') ?>/' + row.id + '" title="<?php echo lang('delete') ?>" data-button="delete" class="text-danger"><i class="icon-trash"></i></a>';
					}
				}
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

<?php $this->load->view('delete-modal'); ?>