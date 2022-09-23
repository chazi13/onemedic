<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kelurahan_model extends MY_Model {

    protected $table = 'mst_kelurahan';

    function drop_options($params = array()) {
        $query = $this->db->select('id, nama')
                ->where($params)
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