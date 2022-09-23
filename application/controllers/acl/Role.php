<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ACL Role management controller
 *
 * @package App
 * @category Controller
 * @author Ardi Soebrata
 */
class Role extends Admin_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('form_validation'));
        $this->load->model('acl/role_model');
        $this->load->language('acl');

        $this->acl->build();
        $this->load->vars(array(
            'acl' => $this->acl,
            'role_tree' => $this->role_model->get_tree()
        ));
        $this->template
                ->set_css(bower_url('jstree/dist/themes/default/style.min.css'))
                ->set_js(bower_url('jstree/dist/jstree.min.js'));
    }

    public function index()
    {
        $this->template->set_title(lang('role_page_name'))
                ->build('acl/role-tree');
    }

    public function add()
    {
        $this->_updatedata();
    }

    public function edit($role_id)
    {
        $this->_updatedata($role_id);
    }

    public function _updatedata($id = 0)
    {
        $post_id = $this->input->post("id");
        if (is_numeric($post_id) && $post_id > 0) {
            $id = $post_id;
        }

        // Setup form validation
        $this->load->library('form_validation');
        $validation_rules = $this->role_model->validation_rules;

        if ($id > 0) {
            $role = $this->role_model->get_by_id($id);
            $this->form_validation->set_default($role);

            $validation_rules['name']['rules'] .= '[' . $id . ']';
        }

        $this->form_validation->init($validation_rules);

        // Run form validation
        if ($this->form_validation->run()) {
            $values = $this->form_validation->get_values();

            if ($id > 0) {
                $this->role_model->update($id, $values);   // Update role
                $this->template->set_flashdata('success', lang('role_updated'));
            } else {
                $this->role_model->update(null, $values);	// Add role
                $this->template->set_flashdata('success', lang('role_added'));
            }
            redirect($this->controller_uri);
        }

        // Load resource view
        $this->template->set_title(lang('role_page_name'))
                ->build('acl/role-tree', array('form' => $this->form_validation));
    }

    public function delete($role_id)
    {
        if (!is_numeric($role_id) || $role_id < 1) {
            $this->_send_message_redirect('error', lang('role_cannot_be_found'));
        }

        $this->data['role'] = $this->role_model->get_by_id($role_id);

        if ($this->data['role']) {
            $this->role_model->delete($role_id);
            $this->template->set_flashdata('notify', lang('role_deleted'));
            redirect($this->controller_uri);
        } else {
            $this->_send_message_redirect('error', lang('role_cannot_be_found'));
        }
    }

    /**
     * Check if a role name exist
     *
     * @access public
     * @param string
     * @return bool
     */
    public function role_name_check($role_name, $not_role_id = 0)
    {
        if ($this->role_model->get_by_name($role_name, $not_role_id)) {
            $this->form_validation->set_message('role_name_check', lang('role_name_taken'));
            return false;
        } else {
            return true;
        }
    }

    public function _send_message_redirect($type, $message)
    {
        $this->template->set_flashdata($type, $message);
        redirect($this->controller_uri);
    }
}
