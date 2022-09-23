<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User management controller.
 *
 * @package App
 * @category Controller
 * @author Ardi Soebrata
 */
class User extends Admin_Controller
{
	/**
	 * Setup controller properties.
	 */
	function __construct()
	{
		parent::__construct();

		$this->load->language('auth');
		$this->load->model('unit_model');

		$this->title = 'Users';
		$this->icon = 'la la-user';

		// $this->load->vars('icon', $this->icon);
		// $this->load->vars('title', $this->title);
	}

	/**
	 * Display User list.
	 */
	function index()
	{
		$this->template
				->set_title('Users')
				->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
				->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
				->set_js('plugins/select2/js/select2')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
				->build('auth/index');
	}

	public function datatable() 
	{
		echo $this->user_model->datatable();
	}

	/**
	 * Edit User
	 *
	 * @param integer $id
	 */
	function edit($id)
	{
		$this->_updatedata($id);
	}

	/**
	 * Add a new User.
	 */
	function add()
	{
		$this->_updatedata();
	}

	/**
	 * Update profile.
	 */
	function profile()
	{
		$this->load->library('form_validation');
		$user_form = $this->user_model->form_rules;
		$id = $this->auth->userid();

		// Update rules for update data
		$user_form['email']['rules']	= "trim|required|max_length[255]|valid_email|callback_unique_email[$id]";
		$user_form['password']['rules']	= "trim|matches[confirm-password]";
		$user_form['confirm-password']['rules']	= "trim";

		// Add language options
		$languages = $this->config->item('languages', 'template');
		foreach($languages as $code => $language)
			$user_form['lang']['options'][$code] = $language['name'];

		// Add role options
		$role_tree = $this->role_model->get_tree();
		$user_form['role_id']['options'] = array('' => '(' . lang('none') . ')') + $this->role_model->generate_options($role_tree);
		
		$this->form_validation->init($user_form);
		// Set default value for update data
		$user = $this->user_model->get_by_id($id);
		$this->form_validation->set_default($user);
		if ($this->form_validation->run())
		{
			$this->user_model->update($id, $this->form_validation->get_values());
			$this->do_upload_photo($id);
			$this->template->add_message('info', lang('user_updated'));
			$this->data['redirect'] = 'auth/user/profile';
		}

		$user = $this->user_model->get_by_id($id);
		$this->template->build($this->module_uri . '/profile', array(
			'form' => $this->form_validation,
			'fullname' => trim($user->full_name),
			'email' => $user->email
		));
	}

	/**
	 * Update user data
	 *
	 * @param int $id
	 */
	function _updatedata($id = 0)
	{
		$this->load->library('form_validation');
		$user_form = $this->user_model->form_rules;
		$user_form['unit_id']['options'] = $this->unit_model->get_dropdown_array('nama', 'id');

		// Update rules for update data
		if ($id > 0)
		{
			$user_form['email']['rules']	= "trim|required|max_length[255]|valid_email|callback_unique_email[$id]";
			$user_form['password']['rules']	= "trim|matches[confirm-password]";
			$user_form['confirm-password']['rules']	= "trim";
		}

		// Add language options
		$languages = $this->config->item('languages', 'template');
		foreach($languages as $code => $language)
			$user_form['lang']['options'][$code] = $language['name'];

		// Add role options
		$role_tree = $this->role_model->get_tree();
		$user_form['role_id']['options'] = array('' => '(' . lang('none') . ')') + $this->role_model->generate_options($role_tree);

		$this->form_validation->init($user_form);

		// Set default value for update data
		if ($id > 0) {
			$user = $this->user_model->get_by_id($id);
			unset($user->password);
			
			$this->form_validation->set_default($user);
		}

		if ($this->form_validation->run())
		{
			$values = $this->form_validation->get_values();
			unset($values['userfile']);
			if ($id > 0)
			{
				$this->user_model->update($id, $values);
				$this->template->set_flashdata('info', lang('user_updated'));
			}
			else
			{
				$this->user_model->insert($values);
				$this->template->set_flashdata('info', lang('user_added'));
			}

			if (isset($this->data['redirect']))
				redirect($this->data['redirect']);
			else
				redirect($this->controller_uri);
		}

		$this->data['form'] = $this->form_validation;
		$this->template->build($this->module_uri . 'user-form', $this->data);
	}

	/**
	 * Delete a User
	 *
	 * @param integer $id
	 */
	function delete($id)
	{
		$user = $this->user_model->get_by_id($id);
		if ($user)
			$this->user_model->delete($id);

		redirect($this->controller_uri);
	}

	/**
	 * Validation callback function to check whether the email is unique
	 *
	 * @param string $value Email to check
	 * @param int $id Don't check if the email has this ID
	 * @return boolean
	 */
	function unique_email($value, $id = 0)
	{
		if ($this->user_model->is_email_unique($value, $id))
			return TRUE;
		else
		{
			$this->form_validation->set_message('unique_email', lang('already_taken'));
			return FALSE;
		}
	}

	function do_upload_photo($id) {
        $config['upload_path'] = 'assets/uploads/avatars/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 0;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
		$this->upload->initialize($config);
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
        } else {
            $arr_image = array('upload_data' => $this->upload->data());
            $img = $arr_image["upload_data"]["file_name"];
            if ($id > 0) {
                $this->user_model->update($id, array('avatar' => $img));
            } else {
                
            }
		}
    }

}

/* End of file user.php */
/* Location: ./application/modules/auth/controllers/user.php */
