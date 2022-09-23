<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reservasi_izin_dokter_model extends MY_Model {

    protected $table = 'pdf_reservasi_izin_dokter';

    function __construct() {
        
    }
//    function list_all_poli(){
//        $rows = $this->db->query("select tc as id, tdesc as nama from rs00001 where tt = 'LYN'  ORDER BY tdesc ASC")->result();
//        return $rows;
//    }
//    
//    function delete_all() {
//        $this->db->query('DELETE FROM '.$this->table);
//    }
//    function drop_options($params = array() ) {
//        $query = $this->db->select('poli_id, poli_nama')
//                ->where($params)
//                ->order_by('poli_nama', 'ASC')
//                ->get($this->table);
//        $result = $query->result();
//        $options[''] = '';
//        foreach ($result as $item) {
//            $options[$item->poli_id] = $item->poli_nama;
//        }
//        return $options;
//    }
}