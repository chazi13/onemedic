<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penerimaan_item_model extends MY_Model {

    protected $table = 'inv_apotek_penerimaan_farmasi_item';

    function get_by_penerimaan_farmasi_id($penerimaanId) {
        $query = $this->db->select($this->table . '.id,' .
                        $this->table . '.apotek_penerimaan_farmasi_id,' .
                        $this->table . '.item_id,' .
                        $this->table . '.no_batch,' .
                        $this->table . '.tanggal_exp,' .
                        $this->table . '.banyaknya,' .
                        $this->table . '.satuan_konversi_id,' .
                        $this->table . '.diskon_per, ' .
                        $this->table . '.diskon_rp, ' .
                        $this->table . '.diskon_per_pasien, ' .
                        $this->table . '.diskon_rp_pasien, ' .                        
                        $this->table . '.harga,' .
                        $this->table . '.ppn,' .
                        $this->table . '.jumlah,' .
                        $this->table . '.satuan_id, 
                        inv_apotek_penerimaan_farmasi.apotek_id,    
			mst_satuan.nama AS satuan, mst_farmasi.nama')
                ->join('mst_satuan', 'mst_satuan.id = inv_apotek_penerimaan_farmasi_item.satuan_id')
                ->join('inv_apotek_penerimaan_farmasi', 'inv_apotek_penerimaan_farmasi.id = ' . $this->table . '.apotek_penerimaan_farmasi_id')
                ->join('mst_farmasi', 'mst_farmasi.id = inv_apotek_penerimaan_farmasi_item.item_id')
                ->order_by('mst_farmasi.nama', 'ASC')
                ->get_where($this->table, array('apotek_penerimaan_farmasi_id' => $penerimaanId, $this->table . '.status' => 1));
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return FALSE;
    }

    function get_by_penerimaan_by_purchasing_id_and_item_id($perchasingId, $itemId) {
        $query = $this->db->select($this->table . '.id,' .
                        $this->table . '.apotek_penerimaan_farmasi_id,' .
                        $this->table . '.item_id,' .
                        $this->table . '.no_batch,' .
                        $this->table . '.tanggal_exp,' .
                        $this->table . '.banyaknya,' .
                        $this->table . '.satuan_konversi_id,' .
                        $this->table . '.diskon_per, ' .
                        $this->table . '.diskon_rp, ' .
                        $this->table . '.diskon_per_pasien, ' .
                        $this->table . '.diskon_rp_pasien, ' .                        
                        $this->table . '.harga,' .
                        $this->table . '.jumlah,' .
                        $this->table . '.satuan_id, 
                        inv_apotek_penerimaan_farmasi.apotek_id,    
			mst_satuan.nama AS satuan, mst_farmasi.nama')
                ->join('mst_satuan', 'mst_satuan.id = inv_apotek_penerimaan_farmasi_item.satuan_id')
                ->join('inv_apotek_penerimaan_farmasi', 'inv_apotek_penerimaan_farmasi.id = ' . $this->table . '.apotek_penerimaan_farmasi_id')
                ->join('mst_farmasi', 'mst_farmasi.id = inv_apotek_penerimaan_farmasi_item.item_id')
                ->order_by('mst_farmasi.nama', 'ASC')
                ->get_where($this->table, array('inv_apotek_penerimaan_farmasi.purchasing_id' => $perchasingId, 'item_id' => $itemId, $this->table . '.status' => 1));
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return FALSE;
    }

    function get_by_penerimaan_farmasi_id_and_item_id($penerimaanId, $itemId) {
        $query = $this->db->select($this->table . '.id,' .
                        $this->table . '.apotek_penerimaan_farmasi_id,' .
                        $this->table . '.item_id,' .
                        $this->table . '.banyaknya,' .
                        $this->table . '.satuan_konversi_id,' .
                        $this->table . '.harga,' .
                        $this->table . '.satuan_id, 
                        inv_apotek_penerimaan_farmasi.apotek_id,    
			mst_satuan.nama AS satuan, mst_farmasi.nama')
                ->join('mst_satuan', 'mst_satuan.id = inv_apotek_penerimaan_farmasi_item.satuan_id')
                ->join('inv_apotek_penerimaan_farmasi', 'inv_apotek_penerimaan_farmasi.id = ' . $this->table . '.apotek_penerimaan_farmasi_id')
                ->join('mst_farmasi', 'mst_farmasi.id = inv_apotek_penerimaan_farmasi_item.item_id')
                ->order_by('mst_farmasi.nama', 'ASC')
                ->get_where($this->table, array('apotek_penerimaan_farmasi_id' => $penerimaanId, 'item_id' => $itemId, $this->table . '.status' => 1));
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return FALSE;
    }

    function get_sum_qty_by_penerimaan_and_item($penerimaanId, $itemId) {
        $query = $this->db->select('SUM(' . $this->table . '.banyaknya) AS jumlah ')
                ->get_where($this->table, array('apotek_penerimaan_farmasi_id' => $penerimaanId, 'item_id' => $itemId));
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return FALSE;
    }

    function get_harga_by_penerimaan_and_item($penerimaanId, $itemId) {
        $query = $this->db->select('harga')
                ->get_where($this->table, array('apotek_penerimaan_farmasi_id' => $penerimaanId, 'item_id' => $itemId));
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return FALSE;
    }

    function delete_by_apotek_penerimaan_farmasi_id($apotekPenerimaanFarmasiId) {
        return $this->db->delete($this->table, array('apotek_penerimaan_farmasi_id' => $apotekPenerimaanFarmasiId));
    }
    
    function get_last_harga($params = array()){
        $hargaBeli = 0; 
        $row = $this->db->select($this->table . '.harga')
                ->join('inv_apotek_penerimaan_farmasi', 'inv_apotek_penerimaan_farmasi.id = '.$this->table.'.apotek_penerimaan_farmasi_id')
                 ->order_by('inv_apotek_penerimaan_farmasi.tanggal_penerimaan', 'DESC')
                ->get_where($this->table, $params)->row();
        if (!empty($row)){
            $hargaBeli = $row->harga;
        }else{
            $hargaBeli = 0;
        }
        return $hargaBeli;
    }

    function get_last_used_konversi_satuan_by_item($itemId){
        $query = $this->db->select($this->table . '.satuan_konversi_id, mst_satuan.nama AS satuan_besar, mst_konversi_satuan.jumlah_konversi, A.nama AS satuan_kecil')  
                ->join('mst_konversi_satuan', 'mst_konversi_satuan.id = ' . $this->table . '.satuan_konversi_id', false)
                ->join('mst_satuan', 'mst_satuan.id = mst_konversi_satuan.satuan_besar_id', false)
                ->join('mst_satuan AS "A"', 'A.id = mst_konversi_satuan.satuan_kecil_id', false)
                ->order_by($this->table.'.created_date','DESC')
                ->get_where($this->table, array($this->table.'.item_id' => $itemId, $this->table.'.status' => 1));
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return FALSE;
    }
}