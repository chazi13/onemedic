<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penanggung_model extends MY_Model {

    protected $table = 'mst_penanggung';

    function __construct() {
        
    }
    function get_list($base_url = '', $offset = 0, $limit = 0) {
        return $this->db->order_by('nama', 'asc')
                ->get_where($this->table, array('status' => 1))
                ->result();
    }
}