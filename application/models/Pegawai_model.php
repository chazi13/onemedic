<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pegawai_model extends MY_Model {

    protected $table = 'mst_pegawai';

    function get_list($base_url = '', $offset = 0, $limit = 0) {
        return $this->db->order_by('nama', 'asc')->get_where($this->table, array('status' => 1))->result();
    }
    
    function autocomplete() {

        $query = $this->db->select('id, nama')
                ->where(array('status' => '1'))
                ->like('upper(nama)', strtoupper($_GET['term']))
                ->order_by('nama', 'ASC')
                ->get($this->table);

        $result = $query->result();

        foreach ($result as $row) {
            $arrData[] = array('id' => $row->id, 'value' => $row->nama);
        }

        return $arrData;
    }

    function autocomplete_dokter() {
        $kategori_jabatan_medis = $this->config->item('kategori_jabatan_medis');
        $join_table = 'mst_jabatan_medis_fungsional';

        $this->db->select("{$this->table}.*");
        $this->db->where(array($this->table . '.status' => '1'));
        $this->db->like("upper({$this->table}.nama)", strtoupper($_GET['term']));
        $this->db->join($join_table, "{$join_table}.id = {$this->table}.jabatan_medis_fungsional_id", 'LEFT');
        $query = $this->db->get_where($this->table, array($join_table . '.' . 'kategori_jabatan_medis' => $kategori_jabatan_medis['DOKTER']));
        $result = $query->result();

        foreach ($result as $row) {
            $arrData[] = array('id' => $row->id, 'value' => $row->nama);
        }

        return $arrData;
    }

    function dokter_drop_options() {
        $kategori_jabatan_medis = $this->config->item('kategori_jabatan_medis');
        $join_table = 'mst_jabatan_medis_fungsional';

        $this->db->select("{$this->table}.id, {$this->table}.nama");
        $this->db->join($join_table, "{$join_table}.id = {$this->table}.jabatan_medis_fungsional_id", 'LEFT');
        $this->db->order_by("{$this->table}.nama", 'ASC');
        $query = $this->db->get_where($this->table, array($join_table . '.' . 'kategori_jabatan_medis' => $kategori_jabatan_medis['DOKTER']));
        $result = $query->result();
        $options = array('' => '(' . lang('none') . ')');
        foreach ($result as $item) {
            $options[$item->id] = $item->nama;
        }
        return $options;
    }

    function get_dokter($params = array()) {
        $kategori_jabatan_medis = $this->config->item('kategori_jabatan_medis');
        
        $params['mst_jabatan_medis_fungsional.kategori_jabatan_medis'] = $kategori_jabatan_medis['DOKTER'];
        
        $this->db->select(" DISTINCT {$this->table}.*", FALSE);
        $this->db->join('mst_jabatan_medis_fungsional', "mst_jabatan_medis_fungsional.id = {$this->table}.jabatan_medis_fungsional_id", 'LEFT');
        $this->db->join('mst_poli_pegawai', "mst_poli_pegawai.pegawai_id = {$this->table}.id", 'LEFT');
        $this->db->order_by($this->table.'.nama', 'ASC');
        $query = $this->db->get_where($this->table, $params);
        return $query->result();
    }
    
    function get_kepala_farmasi($jabatanKepalaFarmasiId = 2) {
        return $this->db->get_where($this->table, array('jabatan_id' => $jabatanKepalaFarmasiId) )->row();
    }

}