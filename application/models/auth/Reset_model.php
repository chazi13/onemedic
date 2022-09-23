<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Reset Model
 * 
 * @package App
 * @category Model
 * @author Ardi Soebrata
 */
class Reset_model extends MY_Model 
{
	protected $table = 'auth_reset';
	public $form_rules = array(
        'token' => array(
			'label' => 'token',
			'rules' => 'trim', 
            'helper' => 'form_hidden'
        ),	
		'password' => array(
			'label' => 'lang:password',
			'rules' => 'trim|required|matches[confirm-password]',
			'helper' => 'form_passwordlabel',
			'value' => ''
		),
		'confirm-password' => array(
			'label' => 'lang:confirm_password',
			'rules' => 'trim|required',
			'helper' => 'form_passwordlabel',
			'value' => ''
		),
    );

	function __construct()
	{
		parent::__construct();
		$this->ci = & get_instance();
    }
    
    /**
     * Generate a new token
     */
    public function generate_token()
    {
        return bin2hex(random_bytes(14));
    }

	/**
	 * Insert data to database
	 * 
	 * @param array $data
	 * @return boolean
	 */
	public function insert($data)
	{
		$data['created'] = date('Y-m-d H:i:s');
		return parent::insert($data);
	}
	
	/**
	 * Get data by token
	 * 
	 * @param string $token
	 * @return object reset
	 */
	function get_by_token($token)
	{
		$this->db->select($this->table . '.*');
		$query = $this->db->get_where($this->table, array($this->table . '.token' => $token));
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
	}
}
