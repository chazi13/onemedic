<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @package App
 * @category Model
 * @author Yusoof Mohammad
 */

class Province_model extends MY_Model
{
	public $table = 'reg_province';
	public $form_rules = array(
		'id' => array(
			'label' => 'lang:code',
			'rules' => 'trim|required|exact_length[2]|numeric|callback_unique_id',
			'helper' => 'form_inputlabel',
		),
		'name' => array(
			'label' => 'lang:name',
			'rules' => 'trim|required',
			'helper' => 'form_inputlabel',
		),
	);

	public function insert($data)
	{
		$data['created'] = date('Y-m-d H:i:s');
		$data['created_by'] = $this->auth->userid();
		
		$this->db->insert($this->table, $data);

		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$data['updated'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->auth->userid();
        return $this->db->update($this->table, $data, array($this->id_field => $id));
	}

	public function prep_query($the_db = null)
	{
		parent::prep_query($the_db);

		if (empty($the_db))
			$the_db = $this->db;

		$the_db->select("$this->table.id, 
				$this->table.name, 
				$this->table.created_by, 
				$this->table.created, 
				$this->table.updated_by, 
				$this->table.updated, 
				u_user.full_name, 
			")
			->join("auth_users c_user", "c_user.id = $this->table.created_by", "left", false)
			->join("auth_users u_user", "u_user.id = $this->table.updated_by", "left", false);
	}

	public function datatable()
	{
		$this->prep_query($this->datatables);
		$this->datatables->from($this->table);
		return $this->datatables->generate();
	}

	/**
	 * Check if id is available
	 * 
	 * @param string $username
	 * @param int $id
	 * @return boolean
	 */
	function is_id_unique($id, $current_id = null)
	{
		$this->db->where('id', $id);
		if (!empty($current_id)) {
			$this->db->where('id !=', $current_id);
		}
		$query = $this->db->get($this->table);
		return ($query->num_rows() == 0);
	}
}
