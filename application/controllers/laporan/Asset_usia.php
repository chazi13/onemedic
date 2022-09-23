<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Asset_usia extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('jenis_barang_model');
        $this->load->model('lokasi_barang_model');
        $this->load->model('kondisi_barang_model');
    }
    
    public function index(){
        $this->data['optionsJenisBarang'] = $this->jenis_barang_model->drop_options_tree();
        $this->data['optionsLokasiBarang'] = $this->lokasi_barang_model->get_dropdown_array('nama', 'id');
        $this->data['optionsKondisiBarang'] = $this->kondisi_barang_model->get_dropdown_array('nama', 'id');
        $this->template
                ->set_title('Laporan Usia Aset/Barang')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_layout('lap_aset')
                ->build('laporan/asset_usia', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        
        $params['asset_inventarisasi.status']   = 1;
        $unitId = $this->input->post('unit_id');
        $jenisBarangId = $this->input->post('jenis_barang_id');
        $lokasiBarangId = $this->input->post('lokasi_barang_id');
        $kondisiBarangId = $this->input->post('kondisi_barang_id');
        $usiaDari = $this->input->post('usia_dari');
        $usiaKe = $this->input->post('usia_ke');

        if ($jenisBarangId > 0) {
            $jenisBarang = $this->jenis_barang_model->get_by_params(array('id' => $jenisBarangId));
            $params["asset_inventarisasi.jenis_barang_kode LIKE '".$jenisBarang->kode."%'"] = null;
        }
        if ($lokasiBarangId > 0) {
            $params['asset_inventarisasi.lokasi_barang_id'] = $lokasiBarangId;
        }
        if ($kondisiBarangId > 0) {
            $params['asset_inventarisasi.kondisi_barang_id'] = $kondisiBarangId;
        }
        if ($unitId > 0) {
            $params['asset_inventarisasi.unit_id'] = $unitId;
        }else{
            $params['asset_inventarisasi.unit_id'] = $this->session->userdata('unit_id');
        }
        if(($usiaDari != '0') || ($usiaKe != '0')){
            $params["date_part('year', AGE(NOW()::DATE, tanggal_perolehan)) >= ".$usiaDari." AND date_part('year', AGE(NOW()::DATE, tanggal_perolehan)) <= ".$usiaKe] = null;
        }

        $this->datatables
                ->select("kode, nama, merk_nama, tipe_nama, tanggal_perolehan, AGE(NOW()::DATE, tanggal_perolehan) AS usia", FALSE)
                ->from('asset_inventarisasi')
                ->where($params, FALSE);
        echo $this->datatables->generate();
    }
    
    public function download_excel(){
    }
}    