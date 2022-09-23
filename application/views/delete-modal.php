<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('confirmation'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo lang('are_you_sure'); ?>
			</div>
			<div class="modal-footer">
				<a id="delete-modal-continue" href="#" class="btn btn-danger"><?php echo lang('delete'); ?></a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang('cancel') ?></button>
			</div>
		</div>
	</div>
</div>

<script>
$('body').on('click', '[data-button=delete]', function(e) {
	$('#delete-modal-continue').attr('href', $(this).attr('href'));
	$('#delete-modal').modal('show');
	e.preventDefault();
});
</script>
