<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reservasi_jadwal_dokter_model extends MY_Model {

    protected $table = 'pdf_reservasi_jadwal_dokter';

    function __construct() {
        
    }
    
    function delete_by_dokter($dokterId) {
        $this->db->query('DELETE FROM '.$this->table.' WHERE dokter_id = '. $dokterId);
    }
    
}