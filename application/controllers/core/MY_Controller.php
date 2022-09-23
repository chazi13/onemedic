<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base controller for public controllers.
 *
 * @package CI-Beam
 * @category Controller
 * @author Ardi Soebrata
 *
 * @property CI_Config $config
 * @property CI_Loader $load
 * @property CI_URI $uri
 * @property MY_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Table $table
 * @property CI_Session $session
 * @property CI_FTP $ftp
 * @property CI_Pagination $pagination
 *
 * @property Auth $auth
 * @property Acl $acl
 * @property Template $template
 * @property User_model $user_model
 * @property Role_model $role_model
 *
 */
class MY_Controller extends CI_Controller 
{
	/**
     * The name of the file that will be used for logging. Set to
     * FALSE to disable logging.
     *
     * @var string
     */
	protected $_log = FALSE;
	protected $upload_path = 'assets/uploads/';
    protected $uploaded_file = "";
	protected $module_uri;
	protected $controller_uri;
	protected $method_uri;
	protected $model;
	protected $title;
	protected $icon;
	
    /**
     * The timestamp format used for logging. Keep empty to use setting from config.
     *
     * @link    http://www.php.net/manual/en/function.date.php
     * @var     string
     */
	protected $_date_format = '';
	
	public function __construct()
	{
		parent::__construct();

		// Setup current router uris.
		$this->module_uri = $this->router->fetch_directory();
		$this->controller_uri = $this->module_uri . $this->router->fetch_class() . '/';
		$this->method_uri = $this->controller_uri . $this->router->fetch_method() . '/';

		$this->load->vars(array(
			'module_uri' => $this->module_uri,
			'controller_uri' => $this->controller_uri,
			'method_uri' => $this->method_uri
		));

		\Firebase\JWT\JWT::$leeway = 10;

		// Redirect unlogged users to login page.
		if ($this->auth->loggedin()) {
			// Get current user id.
			$id = $this->auth->userid();
			
			// Get user from database
			$user = $this->user_model->get_by_id($id);
			$user_data = array(
				'id'			=> $user->id,
				'full_name'		=> trim($user->full_name), 
				'email'			=> $user->email,
				'lang'			=> $user->lang,
				'role_id'		=> $user->role_id,
				'role_name'		=> $user->role_name
			);
			
			$this->load->vars('auth_user', $user_data);
			$this->session->set_userdata($user_data);
		} else {
			$this->session->set_userdata('role_name', 'Guest');
		}

		// Check ACL
		$this->acl->build();

		// Setting up language.
		$languages = (array) $this->config->item('languages', 'template');
		// Lang has already been set and is stored in a session
		$lang = $this->session->userdata('lang');
		// No Lang. Lets try some browser detection then
		if (empty($lang) and !empty( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) and !empty($languages)) {
			// explode languages into array
			$accept_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

			log_message('debug', 'Checking browser languages: '.implode(', ', $accept_langs));

			// Check them all, until we find a match
			foreach ($accept_langs as $lang) {
				// Turn en-gb into en
				$lang = substr($lang, 0, 2);

				// Check its in the array. If so, break the loop, we have one!
				if(in_array($lang, array_keys($languages))) {
					break;
				}
			}
		}
		// If no language has been worked out - or it is not supported - use the default (first language)
		if (empty($lang) or !in_array($lang, array_keys($languages))) {
			reset($languages);
			$lang = key($languages);
		}
		$this->load->vars('lang', $lang);
		$this->config->set_item('language', $languages[$lang]['folder']);
		$this->load->language('application');

		// Set redirect
		$this->load->vars('redirect', urldecode($this->input->get_post('redirect')));
	}

    /**
     * Writes a message to the log file.
     *
     * @param  string  $message  The message to write
     * @param  string  $type     The type of log message (e.g. INFO, DEBUG, ERROR, etc.)
     */
    public function log($message, $type = 'INFO')
    {
        if ($this->_log) {
            // Set the log file path
            $log_path = $this->config->item('log_path');
            if (!$log_path) {
                $log_path = APPPATH . 'logs/';
            }
            if (!is_dir($log_path) or ! is_really_writable($log_path)) {
                return false;
            }

            // Set the name of the log file
            $filename = $log_path . $this->_log . '-' . date('Y-m-d') . '.php';

            if (!file_exists($filename)) {
                // Create the log file
                file_put_contents($filename, "<" . "?php defined('BASEPATH') OR exit('No direct script access allowed'); ?" . ">\n\n");

                // Allow anyone to write to log files
                chmod($filename, 0666);
            }

            $date_fmt = $this->_date_format;
            if (!$date_fmt) {
                $date_fmt = $this->config->item('log_date_format');
            }
            if (!$date_fmt) {
                $date_fmt = 'Y-m-d H:i:s';
            }

            // Write the message into the log file
            // Format: type - time --> message
            file_put_contents($filename, $type . ' - ' . date($date_fmt) . ' --> ' . $message . PHP_EOL, FILE_APPEND);
        }
    }
}

include_once(APPPATH . '/core/Admin_Controller.php');
include_once(APPPATH . '/core/Api_Controller.php');
