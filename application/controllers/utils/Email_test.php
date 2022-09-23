<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_test extends Admin_Controller
{
	public function index()
	{
		if ($this->input->post('run') == 'Test Email')
		{
			$this->load->library('email');
			
			// Send email to requester.
			$this->email->from($this->config->item('mail_sender'), $this->config->item('mail_from'));
			$this->email->to($this->input->post('email')); 
			$this->email->subject('Email Test');
			
			$message = $this->template->set_layout('email_html')->build('utils/email_test/email-test-html', array(), TRUE);
			$message_alt = $this->template->set_layout('email_text')->build('utils/email_test/email-test-text', array(), TRUE);
			
			$this->email->message($message);
			$this->email->set_alt_message($message_alt);
			$this->email->set_mailtype("html");
			$this->email->send(FALSE);
			
			$this->load->vars('message', $this->email->print_debugger());
		}
		
		$this->load->helper('form');
		$this->template
				->set_layout('admin')
				->build('utils/email_test/index');
	}
}
