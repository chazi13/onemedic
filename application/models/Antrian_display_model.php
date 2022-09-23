<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Antrian_display_model extends MY_Model {

    protected $table = 'antrian_display';

    function __construct() {
        
    }

    function get_all($params = array()) {
        return $this->db->where($params)
                        ->get($this->table)->result();
    }
    function get_by_dokter($dokterId) {
        return $this->db->where(array('dokter_id' => $dokterId))
                        ->get($this->table)->row();
    }

    function delete_by_grup($grup) {
        $this->db->query("DELETE FROM ".$this->table." WHERE grup = '". $grup ."'");
    }
}