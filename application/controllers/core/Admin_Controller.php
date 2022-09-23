<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Controller for authenticate controllers.
 *
 * @package CI-Beam
 * @category Controller
 * @author Ardi Soebrata
 */
class Admin_Controller extends MY_Controller
{
	protected $apotek_id;

	public function __construct()
	{
		parent::__construct();

		// Redirect unlogged users to login page.
		if (!$this->auth->loggedin()) {
			redirect('auth/login');
		}

		if ($this->session->userdata('apotek_id') > 0) {
			$this->apotek_id = $this->session->userdata('apotek_id');
		}

		$allowed = $this->acl->is_allowed($this->uri->uri_string());
		if (!$allowed) show_error(lang('error_401'), 401, lang('error_401_title'));

		$this->template->set_layout('admin');
		$this->load->vars('sidebar_toggle_state', $this->input->cookie('sidebar_toggle_state', TRUE));
	}
}
