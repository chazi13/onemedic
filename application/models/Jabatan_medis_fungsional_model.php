<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jabatan_medis_fungsional_model extends MY_Model {

    protected $table = 'mst_jabatan_medis_fungsional';

    function __construct() {
        
    }
	
	function drop_options_by_unMedFunId($unMedFunId) {
        $query = $this->db->select('id, nama')
				->where(array('unit_id' => $this->session->userdata('unit_id')))
				->where(array('mst_jabatan_medis_fungsional.unit_medis_fungsional_id' => $unMedFunId))
                ->order_by('nama', 'ASC')
                ->get($this->table);
        $result = $query->result();
        $options[''] = '';
        foreach ($result as $item) {
            $options[$item->id] = $item->nama;
        }
        return $options;
    }

}