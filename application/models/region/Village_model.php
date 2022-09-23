<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @package App
 * @category Model
 * @author Yusoof Mohammad
 */

class Village_model extends MY_Model
{
    public $table = 'reg_village';
	public $form_rules = array(
		'id' => array(
			'label' => 'lang:code',
			'rules' => 'trim|required|exact_length[10]|numeric|callback_unique_id',
			'helper' => 'form_inputlabel',
		),
        'district_id' => array(
			'label' => 'District ID',
			'rules' => 'trim|required', 
            'helper' => 'form_hidden'
        ),
		'name' => array(
			'label' => 'Nama',
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
        
		$this->load->model('region/province_model');
		$province_table = $this->province_model->table;
        $this->load->model('region/regency_model');
        $regency_table = $this->regency_model->table;
        $this->load->model('region/district_model');
        $district_table = $this->district_model->table;

		$the_db->select("$this->table.id, 
				$this->table.name, 
				$this->table.district_id,
				$district_table.name AS district_name, 
                $district_table.regency_id,
                $regency_table.name AS regency_name, 
                $regency_table.province_id,
                $province_table.name AS province_name, 
				$this->table.created_by, 
				$this->table.created, 
				$this->table.updated_by, 
				$this->table.updated, 
				u_user.full_name, 
			")
			->join("$district_table", "$district_table.id = $this->table.district_id", "left")
            ->join("$regency_table", "$regency_table.id = $district_table.regency_id", "left")
            ->join("$province_table", "$province_table.id = $regency_table.province_id", "left")
			->join("auth_users c_user", "c_user.id = $this->table.created_by", "left")
			->join("auth_users u_user", "u_user.id = $this->table.updated_by", "left");
	}

	public function datatable($district_id)
	{
		$this->prep_query($this->datatables);
        $this->datatables->from($this->table)
            ->where("$this->table.district_id", $district_id);
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
