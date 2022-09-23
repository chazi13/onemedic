<?php if (isset($form)) {
    $role = $form->get_default();
} ?>
<?php echo messages(); ?>
<div class="row">
	<div class="col-md-5">
        <div class="card">
            <div class="card-header header-elements-inline">
				<h6 class="card-title">Roles</h6>
				<div class="header-elements">
					<?php if ($acl->is_allowed($controller_uri . 'add')): ?>
						<a href="<?php echo site_url($controller_uri . 'add') ?>" class="btn bg-teal-400 btn-labeled btn-labeled-left btn-sm" title="<?php echo lang('role_add_title'); ?>">
							<b><i class="icon-plus3"></i></b><?php echo lang('add') ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

            <div class="card-body">
                <div id="role-tree" class="m-portlet__body">
                    <?php
                    function display_tree($tree, $acl, $curr_id = 0)
                    {
                        foreach ($tree as $node) {
                            $jstree_opt = '"icon" : "icon-user", "opened" : true';
                            if ($curr_id == $node['id']) {
                                echo '<li data-jstree=\'{ ' . $jstree_opt . ', "selected" : true }\'><strong>';
                            } else {
                                echo '<li data-jstree=\'{ ' . $jstree_opt . ' }\'>';
                            }
                            if ($acl->is_allowed('acl/role/edit')) {
                                echo '<a href="' . site_url('acl/role/edit/' . $node['id']) . '" class="users">';
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
                                display_tree($node['children'], $acl, $curr_id);
                                echo '</ul>';
                            }
                            echo '</li>';
                        }
                    }
                    ?>
                    <ul>
                        <?php display_tree($role_tree, $acl, (isset($role->id) ? $role->id : 0)); ?>
                    </ul>
                </div>
            </div>
        </div>
	</div>
    <?php if (isset($form)): ?>
	<div class="col-md-7">
	    <div class="card">
            <?php echo form_open_multipart(uri_string(), array('class' => '', 'id' => 'role-form', 'name' => 'role-form')); ?>
                <div class="card-header header-elements-inline">
                    <h6 class="card-title">Role</h6>
                </div>
                <div class="card-body">
                    <?php echo $form->fields(array('id', 'name')) ?>
                    <?php
                    function generate_options($tree, $sep = '')
                    {
                        $result = array();
                        foreach ($tree as $node) {
                            $result[$node['id']] = $sep . $node['name'];
                            if (isset($node['children'])) {
                                $result = $result + generate_options($node['children'], $sep . '&nbsp;&nbsp;');
                            }
                        }
                        return $result;
                    }
                    $parents = array(0 => '(' . lang('none') . ')') + generate_options($role_tree);
                    if (isset($role->id) && isset($parents[$role->id])) {
                        unset($parents[$role->id]);
                    }

                    $isLabelEchoed = false;
                    if (isset($role->parents)) {
                        foreach ($role->parents as $index => $parent) {
                            echo '<div class="form-group  row">';
                            if (! $isLabelEchoed) {
                                echo form_label(lang('role_parents'), 'parents[' . $index . ']', array('class' => 'col-form-label col-md-4'));
                                $isLabelEchoed = true;
                            } else {
                                echo form_label('', 'parents[' . $index . ']', array('class' => 'col-form-label col-md-4'));
                            }
                            echo '<div class="col-md-8">';
                            echo form_dropdown(
                                'parents[' . $index . ']',
                                $parents,
                                set_value('parents[' . $index . ']', $parent->parent),
                                'class="form-control"'
                            );
                            echo '</div></div>';
                        }
                    }
                    echo '<div class="form-group  row">';
                    if (! $isLabelEchoed) {
                        echo form_label(lang('role_parents'), 'parents[]', array('class' => 'col-form-label col-md-4'));
                        $isLabelEchoed = true;
                    } else {
                        echo form_label('', 'parents[]', array('class' => 'col-form-label col-md-4'));
                    }
                    echo '<div class="col-md-8">';
                    echo form_dropdown('parents[]', $parents, 0, 'class="form-control"');
                    echo '</div></div>';
                    ?>
                
                    <div class="text-right">
                        
                        <?php
                        if ($acl->is_allowed('acl/role/edit')) {
                            echo form_button(array(
                                'type' => 'submit',
                                'name' => 'save-btn',
                                'value' => 'save',
                                'content' => '<i class="fa fa-save"></i> ' . lang('save'),
                                'class' => 'btn btn-primary btn-sm"'
                            ));
                        }
                        ?>
                        <?php
                        if (isset($role->id) && $acl->is_allowed('acl/role/delete')) {
                            $delete_url = site_url('acl/role/delete/' . $role->id);
                            echo '<a href="' . $delete_url . '" class="btn btn-danger btn-sm pull-right" title="' . lang('delete') . '" data-button="delete"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
                        }
                        ?>
                        <a href="<?php echo site_url('acl/role'); ?>" class="btn btn-default btn-sm">
                            <i class="fa fa-repeat"></i>
                            <?php echo lang('cancel') ?>
                        </a>

                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
	</div>
	<?php endif; ?>
</div>

<?php $this->load->view('delete-modal'); ?>

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
});
</script>
