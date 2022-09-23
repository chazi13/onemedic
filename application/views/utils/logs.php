<?php echo messages(); ?>
<div class="row">
	<div class="col-xl-12">
		<div class="m-portlet m-portlet--mobile m-portlet--rounded">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="fa fa-laptop-code"></i>
						</span>
						<h3 class="m-portlet__head-text">
							<?php echo $panel_title ?>
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<?php echo form_dropdown('log_files', $log_files, $selected_log, 'class="form-control select2" style="min-width: 200px"'); ?>
				</div>
			</div>
			<div class="m-portlet__body">
				<table id="logs" class="table table-bordered table-striped">
					<thead>
						<tr>
							<?php foreach ($setting['columns'] as $index => $column): ?>
								<th<?php echo ($setting['widths'][$index] > 0) ? ' style="width: ' . $setting['widths'][$index] . 'px"' : ''; ?>><?php echo lang($column); ?></th>
								<?php if ($column == 'username'): ?>
									<th><?php echo lang('full_name'); ?></th>
								<?php endif; ?>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($rows as $row): ?>
							<tr>
								<?php foreach ($setting['columns'] as $column): ?>
									<td><?php echo $row[$column]; ?></td>
									<?php if ($column == 'username'): ?>
										<td><?php echo $row['full_name']; ?></td>
									<?php endif; ?>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
