<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Poli_tindakan_model extends MY_Model {

    protected $table = 'mst_poli_tindakan';

    function get_list($base_url = '', $offset = 0, $limit = 0) {
        return $this->db->order_by('kode, nama', 'asc')->get_where($this->table, array('status' => 1))->result();
    }

    function get_all_by_poli($poliId) {
        $query = $this->db
                ->where(array('poli_id' => $poliId))
                ->get($this->table);
        $result = $query->result();
        return $result;
    }
    
    function get_all_root_by_poli($poliId) {
        $query = $this->db
                ->where(array( 'length(mst_poli_tindakan.kode)' => 2 , 'poli_id' => $poliId))
                ->get($this->table);
        $result = $query->result();
        return $result;
    }
    
    function get_all_by_poli_by_root($poliId,$kodeRoot,$lengthKode) {
        $query = $this->db
                ->where(array( "mst_poli_tindakan.kode LIKE '".$kodeRoot."%'" => null , "length(mst_poli_tindakan.kode)" => $lengthKode , "poli_id" => $poliId))
                ->get($this->table);
        $result = $query->result();
        return $result;
    }
    
    function get_by_poli_by_kode($poliId,$kode) {
        $query = $this->db
                ->where(array( 'mst_poli_tindakan.kode' => $kode , 'poli_id' => $poliId))
                ->get($this->table);
        $result = $query->row();
        return $result;
    }

    function drop_options() {
        $query = $this->db->select('id, nama')
                ->order_by('kode', 'ASC')
                ->get($this->table);
        $result = $query->result();
        $options[''] = '';
        foreach ($result as $item) {
            $options[$item->id] = $item->nama;
        }
        return $options;
    }

    function autocomplete($poliId) {

        $query = $this->db->select('id, nama')
                ->where('poli_id', $poliId)
                ->like('upper(nama)', strtoupper($_GET['term']))
                ->order_by('nama', 'ASC')
                ->get($this->table);

        $result = $query->result();
        $arrData = array();
        foreach ($result as $row) {
            $arrData[] = array('id' => $row->id, 'value' => $row->nama);
        }

        return $arrData;
    }
    
    function delete_by_poli_id($poliId) {
        return $this->db->delete($this->table, array('poli_id' => $poliId));
    }

}
