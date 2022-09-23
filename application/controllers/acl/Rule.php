<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ACL Rule management controller
 *
 * @package App
 * @category Controller
 * @author Ardi Soebrata
 */
class Rule extends Admin_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('form_validation'));
        $this->load->model('acl/role_model');
        $this->load->model('acl/rule_model');
        $this->load->language('acl');

        $this->acl->build();
        $this->load->vars(array(
            'acl' => $this->acl,
            'role_tree' => $this->role_model->get_tree()
        ));
		$this->template
				->set_css(bower_url('jstree/dist/themes/default/style.min.css'))
				->set_js(bower_url('jstree/dist/jstree.min.js'))
				->set_css(bower_url('iCheck/skins/all.css'))
				->set_js(bower_url('iCheck/icheck.min.js'));
    }

    public function index()
    {
        $this->template->set_title(lang('rule_page_name'))
                ->build('acl/rule-tree');
    }

    public function edit($role_id)
    {
        $this->acl->build();
        $acl = $this->acl;
        $this->data['acl'] =  $acl;
        if (!is_numeric($role_id) || $role_id < 1) {
            $this->_send_message_redirect('error', lang('role_cannot_be_found'));
        }

        $this->load->model('acl/resource_model');
        $this->data['resources'] = $this->resource_model->get_tree();
        $this->data['role'] = $this->role_model->get_by_id($role_id);
        if ($this->data['role']) {
            if ($this->input->post('save-btn')) {
                // Get attributes from posts.
                $attributes = array();
                $fields = array(
                    'id',
                    'rule_resource'
                );
                foreach ($fields as $field) {
                    if ($this->input->post($field)) {
                        $attributes[$field] = $this->input->post($field);
                    }
                }

                if (isset($attributes['id'])) {
                    $this->rule_model->update($attributes['id'], $attributes);			// Update rules
                    $this->template->set_flashdata('success', lang('rule_updated'));
                    redirect($this->controller_uri . '/edit/' . $role_id);
                }
            }

            $rules = $this->rule_model->get_by_id($role_id);

            $this->load->library('Beam/Acl');
            $this->acl->build();
            $this->data['acl'] = $this->acl;

            $this->data['rules'] = array();
            foreach ($rules as $rule) {
                $this->data['rules'][$rule->resource_id] = $rule;
            }

            // Load view
            $this->template->set_title(lang('role_page_name'))
                    ->build('acl/rule-tree', $this->data);
        } else {
            $this->_send_message_redirect('error', lang('role_cannot_be_found'));
        }
    }

    public function _send_message_redirect($type, $message)
    {
        $this->template->set_flashdata($type, $message);
        redirect($this->controller_uri);
    }
}
