<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Reset controller.
 *
 * @package App
 * @category Controller
 * @author Ardi Soebrata
 */
class Reset extends MY_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->model("auth/reset_model");
    }
    
    public function new()
    {
        $email = $this->input->post('email');

        $user = $this->user_model->get_by_email($email);
        if ($user) {
            $token = $this->reset_model->generate_token();

            // Save to db
            $this->reset_model->insert(array(
                'email' => $email,
                'token' => $token,
            ));

            // Send email
            $this->load->library('email');

            $this->email->from($this->config->item('mail_sender'), $this->config->item('mail_from'));
            $this->email->to($email);

            $this->email->subject('Reset Password');

            $message = $this->template->set_layout('email_html')->build($this->module_uri . 'reset-email-html', array('token' => $token), TRUE);
            $message_alt = $this->template->set_layout('email_text')->build($this->module_uri . 'reset-email-text', array('token' => $token), TRUE);
            
            $this->email->message($message);
			$this->email->set_alt_message($message_alt);
			$this->email->set_mailtype("html");
            $this->email->send();

            $this->template->set_flashdata('success', lang('reset_email_send'));
        } else {
            $this->template->set_flashdata('error', lang('reset_email_not_found'));
        }
        redirect($this->module_uri . 'login');
    }

    public function confirm($token = null)
    {
        $this->load->helper('form');
        if (empty($token)) {
            $token = $this->input->get_post('token');
        }
        $reset = $this->reset_model->get_by_token($token);
        if ($reset) {
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('rpassword');
            if (!empty($password) && ($password == $confirm_password)) {
                $user = $this->user_model->get_by_email($reset->email);
                if ($user) {
					$data = array(
						'password' => $password,
					);
					if ($user->status = User_model::STATUS_INVITED) {
						$data['status'] = User_model::STATUS_ACTIVE;
					}
                    $this->user_model->update($user->id, $data);
                    $this->reset_model->delete($reset->id);
                    $this->template->set_flashdata('success', lang('reset_password_success'));
                    redirect($this->module_uri . 'login');
                } else {
                    $this->template->add_message('error', lang('reset_email_not_found'));
                    $token = '';
                }
            }
        } else {
            $this->template->add_message('error', lang('reset_token_not_found'));
            $token = '';
        }
        
        $this->template->set_layout('clean')
            ->build($this->module_uri . 'reset-password', array(
                'token' => $token
            ));
    }
}
