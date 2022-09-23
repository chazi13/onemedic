<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pendaftaran_konsul_model extends MY_Model {

    protected $table = 'pdf_pasien_konsul';

    function get_all_by_poli_to_insert_layanan($poli = null) {
        if($poli > 0){
            $this->db->where($this->table.".ke_poli_id", $poli);
        }
        $query = $this->db
                ->distinct()
                ->where(array( $this->table.'.status' => '1' , $this->table.'.status_layanan' => '0'))
                ->get($this->table);
        return $query->result();
    }

}