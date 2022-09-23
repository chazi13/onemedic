<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Base Model
 *
 * @package CI-Beam
 * @category Model
 * @author Ardi Soebrata
 *
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Input $input
 * @property Datatables $datatables
 *
 */
class MY_Model extends CI_Model
{
    protected $table;
    protected $id_field = 'id';
    protected $ci;

    function __construct()
    {
        parent::__construct();
        $this->ci = &get_instance();
    }

    /**
     * Insert data to table
     *
     * @param array $data
     * @return mixed The insert ID number when performing inserts.
     */
    public function insert($data)
    {
        unset($data[$this->id_field]);

        if ($this->db->field_exists('unit_id', $this->table) && !isset($data['unit_id'])) {
            $data['unit_id'] = $this->session->userdata('unit_id');
        }
        if ($this->db->field_exists('created', $this->table) && !isset($data['created'])) {
            $data['created'] = date('Y-m-d H:i:s');
        }
        if ($this->db->field_exists('created_by', $this->table) && !isset($data['created_by'])) {
            $data['created_by'] = $this->auth->userid();
		}
        if ($this->db->field_exists('updated', $this->table) && !isset($data['updated'])) {
            $data['updated'] = date('Y-m-d H:i:s');
        }
        if ($this->db->field_exists('updated_by', $this->table) && !isset($data['updated_by'])) {
			$data['updated_by'] = $this->auth->userid();
        }

        $this->db->insert($this->table, $data);

        if ($this->db->field_exists('id', $this->table)) {
            return $this->db->insert_id();
        }
        return true;
    }

    /**
     * Update data to table
     *
     * @param mixed $id
     * @param array $data
     */
    public function update($id, $data)
    {
        unset($data[$this->id_field]);

        if ($this->db->field_exists('updated', $this->table) && !isset($data['updated'])) {
            $data['updated'] = date('Y-m-d H:i:s');
        }
        if ($this->db->field_exists('updated_by', $this->table) && !isset($data['updated_by'])) {
            $data['updated_by'] = $this->auth->userid();
        }
        return $this->db->update($this->table, $data, array($this->id_field => $id));
    }

    /**
     * Soft delete data from table if deleted field exists in table.
     *
     * @param mixed $id
     * @return boolean
     */
    public function delete($id)
    {
        if ($this->db->field_exists('deleted', $this->table)) {
            $data = array('deleted' => date('Y-m-d H:i:s'));

            if ($this->db->field_exists('deleted_by', $this->table) && !isset($data['deleted_by'])) {
                $data['deleted_by'] = $this->auth->userid();
            }

            $this->db->update($this->table, $data, array($this->id_field => $id));
        } else {
            $this->force_delete($id);
        }
    }

    /**
     * Hard delete data from table
     * 
     * @param mixed $id
     * @return boolean
     */
    public function force_delete($id)
    {
        return $this->db->delete($this->table, array($this->id_field => $id));
    }

    /**
     * Prepare default query
     * 
     * Set select and joins here as default query.
     * 
     * @param object $the_db Codeigniter Database object or Datatables object. Default: CodeIgniter Database object.
     */
    public function prep_query($the_db = null)
    {
        if (empty($the_db))
            $the_db = $this->db;

        if ($the_db->field_exists('deleted', $this->table)) {
            $the_db->where($this->table . '.deleted IS NULL');
        }
    }

    /**
     * Get all data from table.
     * 
     * @return array|boolean array of results or false if no data found.
     */
	public function get_all($is_array = false)
	{
        $this->prep_query();
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            if ($is_array) {
                return $query->result_array();
            } else {
                return $query->result();
            }
        } else {
            return false;
        }
    }
    
    /**
     * Get all data from table by array params
     * 
     * @return array|boolean array of results or false if no data found.
     */
	public function get_all_by_params($params = array(), $field_sort = null, $sort_type = null, $is_array = false)
	{
        $this->prep_query();
        $query = $this->db
                        ->order_by($field_sort, $sort_type)
                        ->get_where($this->table, $params);
        if ($query->num_rows() > 0) {
            if ($is_array) {
                return $query->result_array();
            } else {
                return $query->result();
            }
        } else {
            return false;
        }
	}

    /**
     * Get data by field name and value.
     * 
     * @param string $field_name Name of the field.
     * @param mixed $field_value Value of the field.
     * @param boolean $is_array Whether to return result as array or object. Default: false (return as array of objects).
     * @param object $the_db Codeigniter Database object or Datatables object. Default: CodeIgniter Database object.
     * @return array|boolean array of results or false if no data found.
     */
    function get_by($field_name, $field_value, $is_array = false, $the_db = null)
    {
        $this->prep_query($the_db);
        $this->db->where($field_name, $field_value);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            if ($is_array) {
                return $query->result_array();
            } else {
                return $query->result();
            }
        } else {
            return false;
        }
    }

    /**
     * Get data by id
     *
     * @param mixed $id
     * @param boolean $is_array Whether to return result as an association array or an object. Default: false (return as an object).
     * @return object|boolean the record or false if not found.
     */
    public function get_by_id($id, $is_array = false)
    {
		return $this->get_by_params($this->table . '.' . $this->id_field . '=' . $id, $is_array);
    }

    /**
     * Get data by uid
     *
     * @param mixed $uid
     * @param boolean $is_array Whether to return result as an association array or an object. Default: false (return as an object).
     * @return object|boolean the record or false if not found.
     */
    public function get_by_uid($uid, $is_array = false)
    {
		return $this->get_by_params(array($this->table . '.uid' => $uid), $is_array);
    }
    
    /**
     * Get data by params
     *
     * @param mixed $params = array()
     * @param boolean $is_array Whether to return result as an association array or an object. Default: false (return as an object).
     * @return object|boolean the record or false if not found.
     */
    public function get_by_params($params = array(), $is_array = false)
    {
        $this->prep_query();
        $this->db->where($params);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            if ($is_array) {
                return $query->row_array();
            } else {
                return $query->row();
            }
        } else {
            return false;
        }
    }

    /**
     * Create an array of key => values for dropdown array.
     * 
     * @param string $display_field Name of the field to display as text in dropdown.
     * @param string|null $id_field Name of the field to assign as key in dropdown. Default to value in id_field property.
     * @param string|null $filter_field Name of the field to filter the result if speciefied.
     * @param mixed|null $filter_value Value of filter if specified.
     * @return array Array of key => value.
     */
    public function get_dropdown_array($display_field, $id_field = '', $filter_field = null, $filter_value = null, $sort_field = null, $sort_type = 'ASC')
    {
		$rows = false;
		$this->prep_query();
        if (!empty($filter_field)) {
			$this->db->where(array($filter_field => $filter_value));
        }
        if (!empty($sort_field)) {
			$this->db->order_by($sort_field, $sort_type);
        }else{
            $this->db->order_by($display_field, 'ASC');
        }
		$rows = $this->db->get($this->table)->result();

        if (empty($id_field)) {
            $id_field = $this->id_field;
		}
		
        $result = array('' => '(' . lang('none') . ')');
        if ($rows) {
            foreach ($rows as $row) {
                $result[$row->{$id_field}] = $row->{$display_field};
            }
		}
        return $result;
    }
}
