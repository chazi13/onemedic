<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Login controller.
 *
 * @package App
 * @category Controller
 * @author Ardi Soebrata
 */
class Login extends MY_Controller
{
    public function index()
    {
        // user is already logged in
        if ($this->auth->loggedin()) {
			$this->redirect();
        }

        $this->load->language('auth');
        $email = $this->input->post('email', false);
        $password = $this->input->post('password', false);
        $remember = $this->input->post('remember') ? true : false;
        $redirect = $this->input->get_post('redirect');

        // form submitted
        if ($email && $password) {
            // get user from database
            $user = $this->user_model->get_by_email($email);
            if ($user) {
                $this->_logging_in($user, $redirect, $remember);
                if($user->apotek_id){
                    $newdata = array('apotek_id'  => $user->apotek_id);
                    $this->session->set_userdata($newdata);
                }
            } else {
                $this->template->add_message('error', lang('login_attempt_failed'));
            }
        }

        $data = array();
        if ($email) {
            $data['email'] = $email;
        }
        if ($remember) {
            $data['remember'] = $remember;
        }

        // show login form
        $this->load->helper('form');
        $this->template->set_layout('clean')
            ->build($this->module_uri . 'login', $data);
    }

    public function google() 
    {
		$redirect = $this->input->get_post('redirect');

        $client = new Google_Client();
        $client->setClientId($this->config->item('google_client_id'));
        $client->setClientSecret($this->config->item('google_client_secret'));
        $client->setRedirectUri(site_url($this->config->item('google_redirect_url')));
        $client->setAccessType("offline");        // offline access
        $client->setIncludeGrantedScopes(true);   // incremental auth
        $client->addScope('profile');
        $client->addScope('email');
		$client->setState($redirect);

        $code = $this->input->get('code');
        $error = $this->input->get('error');

        if (empty($code) && empty($error)) {
            redirect($client->createAuthUrl());
        } elseif (!empty($code)) {
            $token = $client->authenticate($code);
            if (isset($token['error'])) {
                $this->template->set_flashdata('error', '<h3>' . $token['error'] . '</h3>' . $token['error_description']);
            } else {
                $client->setAccessToken($token);
				$payload = $client->verifyIdToken();
				$redirect = $this->input->get('state');
                if (isset($payload['email'])) {
                    if (isset($payload['picture'])) {
                        $this->session->set_userdata('picture', $payload['picture']);
                    }
                    $user = $this->user_model->get_by_email($payload['email']);
                    if ($user) {
                        $this->_logging_in($user, $redirect);
                    } else {
                        $this->template->set_flashdata('error', lang('user_email_not_found'));
                    } 
                } else {
                    $this->template->set_flashdata('error', lang('google_email_not_found'));
                }
            }
        } elseif (!empty($error)) {
            $this->template->set_flashdata('error', $error);
        }
        redirect($this->controller_uri);
    }

    private function _logging_in($user, $redirect = false, $remember = false)
    {
		// Check if user active.
		if ($user->status != 'active') {
			$this->template->set_flashdata('error', lang('user_not_active'));
		} else {
			// mark user as logged in
            $this->auth->login($user->id, $remember);
            // add session user data
            $this->session->set_userdata('unit_id', $user->unit_id);
            $this->session->set_userdata('apotek_id', $user->apotek_id);

            $userdatalogin['user_name'] = $user->email;
            $userdatalogin['login_at'] = date('Y-m-d H:i:s');
            $userdatalogin['ip_address'] = $this->input->ip_address();
            $this->db->insert('user_login_log', $userdatalogin);
            
			$this->redirect($user, $redirect);
		}
	}
	
	private function redirect($user = null, $redirect = null)
	{
		if (!empty($redirect)) {
			redirect($redirect);
		}

		if (!empty($this->session->userdata('client_id')) || !empty($user->client_id)) {
			redirect('client/dashboard');
		} elseif (!empty($this->session->userdata('branch_id')) || !empty($user->branch_id)){
			redirect('branch/dashboard');
		}else{
            redirect($this->config->item('dashboard_uri', 'template'));
        }
	}
}
