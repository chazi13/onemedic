<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * User Model
 * 
 * @package App
 * @category Model
 * @author Ardi Soebrata
 */
class User_model extends MY_Model
{
	const STATUS_ACTIVE = 'active';
	const STATUS_DISABLE = 'disable';
	const STATUS_INVITED = 'invited';

	protected $table = 'auth_users';
	protected $role_table = 'acl_roles';
	public $form_rules = array(
		'full_name' => array(
			'label' => 'lang:fullname',
			'rules' => 'trim|max_length[255]',
			'helper' => 'form_inputlabel'
		),
		'id' => array(
			'helper' => 'form_hidden'
		),
		'email' => array(
			'label' => 'lang:email',
			'rules' => 'trim|required|max_length[255]|valid_email|callback_unique_email',
			'helper' => 'form_emaillabel'
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
		'role_id' => array(
			'label' => 'lang:Role',
			'rules' => 'trim|required',
			'helper' => 'form_dropdownlabel'
		),
		'unit_id' => array(
			'label' => 'lang:Unit',
			'rules' => 'trim|required',
			'helper' => 'form_dropdownlabel'
		),
		'lang' => array(
			'label' => 'lang:language',
			'rules' => 'trim',
			'helper' => 'form_dropdownlabel'
		),
		'userfile' => array(
			'label' => 'lang:photo',
			'rules' => 'trim',
			'helper' => 'form_filelabel'
		)
	);

	function __construct()
	{
		parent::__construct();
		$this->ci->load->library('PasswordHash', array('iteration_count_log2' => 8, 'portable_hashes' => false));
	}

	/**
	 * Insert data to User Model
	 * 
	 * @param array $data
	 * @return boolean
	 */
	public function insert($data)
	{
		$data['registered'] = date('Y-m-d H:i:s');
		return parent::insert($this->prep_data($data));
	}

	/**
	 * Update data to User Model
	 * 
	 * @param int $id
	 * @param array $data
	 * @return boolean
	 */
	public function update($id, $data)
	{
		return parent::update($id, $this->prep_data($data));
	}

	/**
	 * Prepare input data
	 * 
	 * @param array $data
	 * @return array
	 */
	private function prep_data($data)
	{
		// Remove confirm-password field
		unset($data['confirm-password']);

		// Hash password field if not empty
		if (isset($data['password'])) {
			if (strlen(trim($data['password'])) > 0)
				$data['password'] = $this->ci->passwordhash->HashPassword($data['password']);
			else
				unset($data['password']);
		}
		return $data;
	}

	/**
	 * Compare user input password to stored hash
	 * 
	 * @param string $password
	 * @param string $userpass
	 * @return boolean
	 */
	public function check_password($password, $userpass)
	{
		// check password
		return $this->ci->passwordhash->CheckPassword($password, $userpass);
	}

	/**
	 * Get user by id
	 * 
	 * @param int $id
	 * @param boolean $is_array
	 * @return array|boolean
	 */
	function get_by_id($id, $is_array = false)
	{
		return $this->get_by_params(array("$this->table.id" => $id), $is_array);
	}

	/**
	 * Get user by email
	 * 
	 * @param string $email
	 * @param boolean $is_array
	 * @return object user|boolean
	 */
	function get_by_email($email, $is_array = false)
	{
		return $this->get_by_params(array("$this->table.email" => $email), $is_array);
	}

	/**
	 * Get user by uid
	 * 
	 * @param string $uid
	 * @param boolean $is_array
	 * @return object user|boolean
	 */
	function get_by_uid($uid, $is_array = false)
	{
		return $this->get_by_params(array("$this->table.uid" => $uid), $is_array);
	}

	/**
	 * Get user by params
	 * 
	 * @param array $params
	 * @param boolean $is_array
	 * @return object user|boolean
	 */
	function get_by_params($params = array(), $is_array = false) 
	{
		$this->db->select("$this->table.*, $this->role_table.name AS role_name")
			->join($this->role_table, $this->role_table . '.id = ' . $this->table . '.role_id', 'left');
		return parent::get_by_params($params, $is_array);
	}

	/**
	 * Check if email is available
	 * 
	 * @param string $email
	 * @param int $id
	 * @return boolean
	 */
	function is_email_unique($email, $id = 0)
	{
		$this->db->where('email', $email);
		if ($id > 0)
			$this->db->where($this->id_field . ' <>', $id);
		$query = $this->db->get($this->table);
		return ($query->num_rows() == 0);
	}

	/**
	 * Get datatable format list
	 * 
	 * @return string
	 */
	function datatable()
	{
		$this->datatables->select("$this->table.*, acl_roles.name AS role, mst_unit.nama as unit_nama")
			->join('acl_roles', "acl_roles.id = $this->table.role_id", 'left')
			->join('mst_unit', "mst_unit.id = $this->table.unit_id", 'left')
			->from($this->table);
		return $this->datatables->generate();
	}
}
