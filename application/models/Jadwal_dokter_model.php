<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jadwal_dokter_model extends MY_Model {

    protected $table = 'pdf_jadwal_dokter';

    function __construct() {
        
    }
    
    function delete_all() {
        $this->db->query('DELETE FROM '.$this->table);
    }
}