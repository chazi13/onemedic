<?php echo messages(); ?>
<div class="row">
	<div class="col-md-5">
		<div class="card">
			<div class="card-header header-elements-inline"">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="fa fa-user-check"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Rules
						</h3>
					</div>
				</div>
			</div>
			<div id="role-tree"  class="card-body">
				<?php
					function display_tree($tree, $acl, $cu, $curr_id = 0)
					{
						foreach ($tree as $node) {
							$jstree_opt = '"icon" : "icon-user", "opened" : true';
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
						<?php display_tree($role_tree, $acl, $controller_uri, (isset($role->id) ? $role->id : 0)); ?>
					</ul>
			</div>
		</div>
	</div>
	<?php if (isset($role)): ?>
	<div class="col-md-7">
		<?php echo form_open_multipart(uri_string(), array('class' => '', 'id' => 'role-form', 'name' => 'role-form')); ?>
			<div class="card">
				<div class="card-header header-elements-inline">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<span class="m-portlet__head-icon">
								<i class="fa fa-user-check"></i>
							</span>
							<h3 class="m-portlet__head-text">
								Rules
							</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<?php echo form_hidden(array('id' => set_value('id', isset($role->id) ? $role->id : ''))); ?>
					<div class="form-group row">
						<label class="col-form-label col-md-4">Nama</label>
						<div class=" col-md-8">
							<a href="<?php echo site_url('acl/role/edit/' . $role->id) ?>"><?php echo $role->name ?></a>
						</div>
					</div>
					<?php
					$parents_value = '';
					if (isset($role->parents) && count($role->parents) > 0) {
						foreach ($role->parents as $index => $parent) {
							$parents_value .= '<a href="' . site_url($controller_uri . 'edit/' . $parent->parent) . '" style="display: block; padding: 0 0 .5em 0;">';
							$parents_value .= '<i class="fa fa-user-lock"></i>&nbsp;';
							$parents_value .= $parent->parent_name;
							$parents_value .= '</a>';
						}
					} else {
						$parents_value = '-';
					}
					?>
					<?php echo form_uneditablelabel('role_parents', lang('role_parents'), $parents_value); ?>
				</div>
			</div>
			<div class="card">
				<div class="card-header header-elements-inline">
					<h6 class="card-title">Resource</h6>
					<div class="header-elements">
						<button type="submit" class="btn btn-primary btn-sm" name="save-btn" value="save" title="<?php echo lang('resource_add_title'); ?>">
							<?php echo lang('save'); ?>
						</button>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-bordered table-hover" id="table_resources">
						<thead>
							<tr>
								<th>Resource</th>
								<th style="width: 5em; text-align: center;">Access</th>
								<!--th style="width: 5em; text-align: center;"><?php echo lang('rule_allow'); ?></th>
								<th style="width: 5em; text-align: center;"><?php echo lang('rule_deny'); ?></th>
								<th style="width: 5em; text-align: center;"><?php echo lang('rule_inherited'); ?></th-->
							</tr>
						</thead>
						<tbody>
							<tr class="tr-filter">
								<td>
									<span id="resource-filter-reset" class="fa fa-times"></span>
									<input type="text" class="form-control" placeholder="Search" id="resource-filter" />
								</td>
								<td colspan="3">
									<select id="resource-access-filter" class="form-control">
										<option value="">(All)</option>
										<option value="alpha-primary">Allow</option>
										<option value="danger">Deny</option>
									</select>
								</td>
							</tr>
							<?php
							function display_resource($role, $tree, $values, $acl, $sep, $iParent)
							{
								$i = 0;
								foreach ($tree as $node):
									$i++;

								$checkname = 'rule_resource[' . $node['id'] . ']';
								$value = '';
								if (isset($values[$node['id']])) {
									$value = $values[$node['id']]->access;
								}

								if ($value == 'allow') {
									$acl->removeAllow($role, $node['name']);
								} elseif ($value == 'deny') {
									$acl->removeDeny($role, $node['name']);
								}

								$default_value = $acl->isAllowed($role, $node['name']) ? 'allow' : 'deny';

								$tr_class = '';
								if ($default_value == 'allow') {
									$tr_class = 'alpha-primary';
								} elseif ($default_value == 'deny') {
									$tr_class = 'danger';
								}
								if ($value == 'allow') {
									$tr_class = 'alpha-primary';
								} elseif ($value == 'deny') {
									$tr_class = 'danger';
								} ?>
							<tr class="<?php echo $tr_class ?>">
								<?php
								$icon = 'icon-question3';
								switch ($node['type']) {
									case 'module':
										$icon = 'icon-folder-open';
										break;
									case 'controller':
										$icon = 'icon-file-empty';
										break;
									case 'action':
										$icon = 'icon-cog3';
										break;
								} ?>
								<td class="resource-column" style="max-width: 200px; overflow-x: auto;">
									<?php echo $sep ?><i class="fa <?php echo $icon ?>"></i>&nbsp;&nbsp;<?php echo $node['name'] ?>
								</td>
								<td>
									<div class="checkbox checkbox-switchery">
										<label>
											<input type="checkbox" class="switchery" id="allow<?php echo $iParent.'_'.$i?>" name="<?php echo $checkname ?>" value="allow" <?php echo set_radio($checkname, 'allow', ($value == 'allow')); ?> >
										</label>
									</div>
								</td>
								<!--td>
									<span class="m-switch m-switch--sm m-switch--icon deny">
										<label>
											<input type="radio" id="deny<?php echo $iParent.'_'.$i?>" name="<?php echo $checkname ?>" value="deny" <?php echo set_radio($checkname, 'deny', ($value == 'deny')); ?> />
											<span></span>
										</label>
									</span>
								</td>
								<td>
									<span class="m-switch m-switch--sm m-switch--icon <?php echo $default_value ?>">
										<label>
											<input type="radio" name="<?php echo $checkname ?>" value="" <?php echo set_radio($checkname, '', ($value == '')); ?> />
											<span></span>
										</label>
									</span>
								</td-->
							</tr>
							<?php
									if (isset($node['children'])) {
										display_resource($role, $node['children'], $values, $acl, $sep . '&nbsp;&nbsp;&nbsp;&nbsp;', $iParent.'_'.$i);
									}
								endforeach;
							}
							$sep = '';
							display_resource($role->name, $resources, $rules, $acl->acl, $sep, '');
							?>
						</tbody>
					</table>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
	<?php endif; ?>
</div>

<style>
.table th {
    background-color: #e8e8e8;
}
.table > tbody > .tr-filter > td {
	padding: 5px;
	background-color: #e8e8e8;
	position: relative;
}
#resource-filter-reset {
	position: absolute;
	top: 16px;
	right: 16px;
	cursor: pointer;
}
.m-form .m-form__group {
	padding-top: 0;
	padding-bottom: 0;
}
tr.success {
	background-color: #34bfa3;
	color: #fff;
	opacity: 0.5;
}
.table-hover tbody tr:hover {
	background-color: #f7f8fa;
	color: #575962;
}
.table-hover tbody tr.success:hover {
	background-color: #dcf5f0;
	opacity: 0.5;
}

.m-switch label {
	margin-bottom: 0;
}
.m-switch.m-switch--icon.allow input ~ span:after {
	content: '\f17b';
}
.m-switch.allow input:checked ~ span:after {
	background-color: #34bfa3;
}
.m-switch.m-switch--icon.deny input ~ span:after {
	content: '';
}
.m-switch.deny input:checked ~ span:after {
	background-color: #f4516c;
}
</style>
<script>
$(document).ready(function() {
	$('#role-tree').jstree({
		"plugins" : ["wholerow"]
	});
	// handle link clicks in tree nodes(support target="_blank" as well)
	$('#role-tree').on('select_node.jstree', function(e,data) {
		var link = $('#' + data.selected).find('a');
		if (link.attr("href") != "#" && link.attr("href") != "javascript:;" && link.attr("href") != "") {
			if (link.attr("target") == "_blank") {
				link.attr("href").target = "_blank";
			}
			document.location.href = link.attr("href");
			return false;
		}
	});
	$('#table_resources').on('change', 'input[type="radio"]', function(){
		var $tr = $(this).parents('tr');
		var $check_radio = $tr.find(':checked');

		$tr.removeClass('success').removeClass('danger');
		if ($check_radio.parents().hasClass('allow'))
			$tr.addClass('success');
		else
			$tr.addClass('danger');
    });
	$('#resource-filter').on('keyup', function() {
		filter_resource();
	});
	$('#resource-filter-reset').on('click', function() {
		$('#resource-filter').val('').trigger('keyup');
	});
	$('#resource-access-filter').on('change', function() {
		filter_resource();
	});
});

function filter_resource() {
	var search = $('#resource-filter').val();
	var access = $('#resource-access-filter').val();

	$('.resource-column').each(function() {
		var $row = $(this).parent('tr');
		var resource = $(this).text();

		if (resource.search(new RegExp(search, "i")) < 0 || (access !== '' && !$row.hasClass(access))) {
			$row.hide();
		} else {
			$row.show();
		}
	});
}
</script>
