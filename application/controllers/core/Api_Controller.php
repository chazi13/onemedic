<?php
use function GuzzleHttp\json_encode;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Controller for API controllers.
 *
 * @package CI-Beam
 * @category Controller
 * @author Ardi Soebrata
 */
class Api_Controller extends MY_Controller
{
	protected $user_data;
	protected $method;
	protected $post_body;

	public function __construct()
	{
		parent::__construct();
		$this->post_body = file_get_contents('php://input');
		$id_token = $this->input->post('idToken');
		$auth = $this->input->get_request_header('Auth');

		if ($id_token || $auth) {
			$user = null;
			if ($id_token) {
				$client = new Google_Client(['client_id' => $this->config->item('google_client_id')]);  // Specify the CLIENT_ID of the app that accesses the backend
				$payload = null;
				try {
					$payload = $client->verifyIdToken($id_token);
				} catch (UnexpectedValueException $e) {
					$this->show_error(lang('invalid_id_token'));
				}
				if ($payload) {
					if (isset($payload['email'])) {
						$user = $this->user_model->get_by_email($payload['email']);
					} else {
						$this->show_error(lang('google_email_not_found'));
					}
				} else {
					$this->show_error(lang('invalid_id_token'));
				}
			} elseif ($auth) {
				$user = $this->user_model->get_by_uid($auth);
			}

			if ($user) {
				$this->user_data = array(
					'id'			=> $user->id,
					'full_name'		=> trim($user->full_name), 
					'email'			=> $user->email,
					'lang'			=> $user->lang,
					'role_id'		=> $user->role_id,
					'role_name'		=> $user->role_name,
					'client_id'		=> $user->client_id,
					'client_name'	=> $user->client_name,
					'branch_id'		=> $user->branch_id,
					'branch_name'	=> $user->branch_name
				);
				$allowed = $this->acl->is_allowed($this->uri->uri_string(), $this->user_data['role_name']);
				if (!$allowed) $this->show_error(lang('error_401'));
			} else {
				$this->show_error(lang('user_email_not_found'));
			}
		} else {
			// Display errors if User is not logged in.
			if (!$this->auth->loggedin()) {
				show_error(lang('error_401'), 401, lang('error_401_title'));
			}

			$allowed = $this->acl->is_allowed($this->uri->uri_string());
			if (!$allowed) show_error(lang('error_401'), 401, lang('error_401_title'));

			// Get user_data from session
			$this->user_data = $this->session->userdata();
		}

		$this->method = $this->input->method(false);
	}

	protected function show_error($message)
	{
		$this->output->set_content_type('application/json');
		echo json_encode(array(
			'status' => 'error',
			'message' => $message
		));
		die();
	}
	
	protected function encode_json($data)
	{
		$this->output->set_content_type('application/json')
		->set_output(json_encode($data));
	}
}
