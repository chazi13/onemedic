
<?php if (isset($form)) {
    $resource = $form->get_default();
} ?>
<?php echo messages(); ?>
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header header-elements-inline">
				<h6 class="card-title">Resources</h6>
				<div class="header-elements">
					<?php if ($acl->is_allowed($controller_uri . 'add')): ?>
						<a href="<?php echo site_url($controller_uri . 'add') ?>" class="btn bg-teal-400 btn-labeled btn-labeled-left btn-sm" title="<?php echo lang('resource_add_title'); ?>">
							<b><i class="icon-plus3"></i></b><?php echo lang('add') ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="card-body">
				<div id="resource-tree" class="m-portlet__body">
					<?php
					function display_tree($tree, $acl, $cu, $curr_id = 0)
					{
						foreach ($tree as $node) {
							$jstree_opt = '"opened" : true, ';
							switch ($node['type']) {
								case 'module':
									$jstree_opt .= '"icon" : "icon-folder-open3"';
									break;
								case 'controller':
									$jstree_opt .= '"icon" : "icon-file-empty"';
									break;
								case 'action':
									$jstree_opt .= '"icon" : "icon-cog3"';
									break;
								default:
									$jstree_opt .= '"icon" : "icon-question3"';
									break;
							}
							if ($curr_id == $node['id']) {
								echo '<li data-jstree=\'{ ' . $jstree_opt . ', "selected" : true }\'><strong>';
							} else {
								echo '<li data-jstree=\'{ ' . $jstree_opt . ' }\'>';
							}
							if ($acl->is_allowed($cu . 'edit')) {
								echo '<a href="' . site_url($cu . 'edit/' . $node['id']) . '">';
								echo $node['name'];
								echo '</a>';
							} else {
								echo $node['name'];
							}
							if ($curr_id == $node['id']) {
								echo '</strong>';
							}
							if (isset($node['children'])) {
								echo '<ul>';
								display_tree($node['children'], $acl, $cu, $curr_id);
								echo '</ul>';
							}
							echo '</li>';
						}
					}
					?>
					<ul>
						<?php display_tree($resource_tree, $acl, $controller_uri, (isset($resource->id) ? $resource->id : 0)); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<?php if (isset($form)): ?>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header header-elements-inline">
				<h6 class="card-title">Resources</h6>
			</div>
			
			<div class="card-body">
				<?php echo form_open_multipart(uri_string(), array('class' => '', 'id' => 'resource-form', 'name' => 'resource-form')); ?>
					<?php echo $form->fields(array('id', 'name', 'type')) ?>
					<div class="form-group row">
						<?php echo form_label(lang('resource_parent'), 'parent', array('class' => 'col-form-label col-md-4')); ?>
						<div class="col-md-8">
						<?php
						function generate_options($tree, $sep = '')
						{
							$result = array();
							foreach ($tree as $node) {
								$result[$node['id']] = $sep . $node['type'] . '&nbsp;' . $node['name'];
								if (isset($node['children'])) {
									$result = $result + generate_options($node['children'], $sep . '&nbsp;&nbsp;&nbsp;&nbsp;');
								}
							}
							return $result;
						}
						$parents = array(0 => '(' . lang('resource_parent_none') . ')') + generate_options($resource_tree);
						if (isset($resource->id) && isset($parents[$resource->id])) {
							unset($parents[$resource->id]);
						}

						echo form_dropdown(
							'parent',
							$parents,
							set_value('parent', isset($resource->parent) ? $resource->parent : 0),
							'id="parent" class="form-control"'
						);
						?>
						</div>
					</div>
					<div class="text-right">
						<?php
						if ($acl->is_allowed($controller_uri . 'edit')) {
							echo form_button(array(
								'type' => 'submit',
								'name' => 'save_task',
								'value' => 'save',
								'content' =>  lang('save'),
								'class' => 'btn btn-primary btn-sm'
							));
						}
						?>
						<?php
						if (isset($resource->id) && $acl->is_allowed($controller_uri . 'delete')) {
							$delete_url = site_url($controller_uri . 'delete/' . $resource->id);
							echo '<a href="' . $delete_url . '" class="btn btn-danger pull-right btn-sm" title="' . lang('delete') . '" data-button="delete">' . lang('delete') . '</a>';
						}
						?>
						<a href="<?php echo site_url($controller_uri); ?>" class="btn btn-default btn-sm">
							<?php echo lang('cancel') ?>
						</a>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>

<?php $this->load->view('delete-modal'); ?>

<script>
	$(document).ready(function() {
		$('#resource-tree').jstree({
			"plugins" : ["wholerow"]
		});
	  // handle link clicks in tree nodes(support target="_blank" as well)
	  $('#resource-tree').on('select_node.jstree', function(e,data) {
	      var link = $('#' + data.selected).find('a');
	      if (link.attr("href") != "#" && link.attr("href") != "javascript:;" && link.attr("href") != "") {
	          if (link.attr("target") == "_blank") {
	              link.attr("href").target = "_blank";
	          }
	          document.location.href = link.attr("href");
	          return false;
	      }
	  });
		$('#type').select2({
			minimumResultsForSearch: 20,
			escapeMarkup: function (markup) { return markup; },
			templateResult: function(row) {
				return render_type(row.text);
			},
			templateSelection: function(row) {
				return render_type(row.text);
			}
		});
		$('#parent').select2({
			minimumResultsForSearch: 20,
			escapeMarkup: function (markup) { return markup; },
			templateResult: function(row) {
				return render_parent(row.text);
			},
			templateSelection: function(row) {
				return render_parent(row.text);
			}
		});
	});

	function render_type(text) {
		switch (text) {
			case 'Module':
				return '<i class="fa fa-folder-open"></i>&nbsp;&nbsp;' + text;
				break;
			case 'Controller':
				return '<i class="fa fa-file-alt"></i>&nbsp;&nbsp;' + text;
				break;
			case 'Action':
				return '<i class="fa fa-cog"></i>&nbsp;&nbsp;' + text;
				break;
			default:
				return '<i class="fa fa-question"></i>&nbsp;&nbsp;' + text;
				break;
		}
	}

	function render_parent(text) {
		return text.replace('module', '<i class="fa fa-folder-open"></i>&nbsp;')
				.replace('controller', '<i class="fa fa-file-alt"></i>&nbsp;')
				.replace('action', '<i class="fa fa-cog"></i>&nbsp;')
				.replace('other', '<i class="fa fa-question"></i>&nbsp;');
	}
</script>
