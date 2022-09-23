<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipe_pasien_model extends MY_Model {
    protected $table    = 'mst_tipe_pasien';
    
    function get_list_view($base_url = '', $offset = 0, $limit = 0) { 
        // If base_url is empty, list all data.
        if (empty($base_url))
            return $this->db->get_where($this->table, array('status ' => 1 ))->result();
        else {
            $this->load->library('pagination');

            // Set pagination limit
            if (empty($limit)) {
                if ($this->input->get('page_limit'))
                    $limit = (int) $this->input->get('page_limit');
                else
                    $limit = $this->config->item('rows_limit');
            }

            // Set pagination offset
            if (empty($offset)) {
                if ($this->pagination->page_query_string)
                    $offset = (int) $this->input->get($this->pagination->query_string_segment);
                else {
                    $offset = $this->uri->segment(4);
                    if ($this->pagination->use_page_numbers && ($offset > 0))
                        $offset = ($offset - 1) * $limit;
                }
            }

            // Set base_url, 
            if ($this->pagination->page_query_string) {
                $last_char = substr($base_url, -1, 1);
                if ($last_char == '/')
                    $base_url .= '?';
                elseif ($last_char != '?')
                    $base_url .= '/?';
            }

            // Get number of rows
            $this->db->where(array('status' => 1));
            $row_counts = $this->db->count_all_results($this->table);

            // Create pagination
            $config['base_url'] = $base_url;
            $config['total_rows'] = $row_counts;
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);

            // Execute query
            $query = $this->db->where(array('status' => 1 ))->get($this->table, $limit, $offset);
            return $query->result();
        }
    }

    function autocomplete() {

        $query = $this->db->select('id, nama')
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

}