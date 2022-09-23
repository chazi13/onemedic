<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reservasi_poli_model extends MY_Model {

    protected $table = 'pdf_reservasi_poli';

    function __construct() {
        
    }
    
    function delete_all() {
        $this->db->query('DELETE FROM '.$this->table);
    }
}