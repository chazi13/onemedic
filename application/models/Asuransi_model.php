<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Asuransi_model extends MY_Model {

    protected $table = 'mst_asuransi';
    
    function get_list($base_url = '', $offset = 0, $limit = 0) {
            return $this->db->order_by('nama', 'asc')->get_where($this->table, array('status' => 1))->result();
    }
    
	function is_kode_unique($kode, $id = 0)
	{
		$this->db->where('kode', $kode);
		if ($id > 0)
			$this->db->where('id <>', $id);
		$query = $this->db->get($this->table);
		return ($query->num_rows() == 0);
	}
	
	function autocomplete($params = array()) {

        $query = $this->db->select('mst_asuransi.id,
                                    mst_asuransi.nama'
                )
                ->where($params)
                ->like('upper(mst_asuransi.nama)', strtoupper($_GET['term']))
                ->order_by('mst_asuransi.nama', 'ASC')
                ->get_where($this->table, array($this->table . '.status' => 1));

        $result = $query->result();
        if (!empty($result)) {
            foreach ($result as $row) {
                $arrData[] = array('id' => $row->id, 'value' => $row->nama);
            }
        } else {
            $arrData[] = array('id' => 0, 'value' => 'Asuransi tidak ditemukan');
        }

        return $arrData;
    }

}