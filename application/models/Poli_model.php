<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Poli_model extends MY_Model {

    protected $table = 'mst_poli';

    function get_list($base_url = '', $offset = 0, $limit = 0) {
        return $this->db->order_by('kode, nama', 'asc')->get_where($this->table, array('status' => 1))->result();
    }
	
	function autocomplete() {

        $query = $this->db->select('id, nama')
                ->like('upper(nama)', strtoupper($_GET['term']))
                ->order_by('nama', 'ASC')
                ->get($this->table);

        $result = $query->result();

        foreach ($result as $row) {
            $arrData[] = array('id' => $row->id, 'value' => $row->nama);
        }

        return $arrData;
    }

}