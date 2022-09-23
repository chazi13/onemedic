<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class asset_stock_opname extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('asset_stock_opname_model');
        $this->load->model('lokasi_barang_model');
        $this->load->model('kondisi_barang_model');
    }
    
    public function index(){
        $optionsTahun = array();
        for($i=2021;$i<=date('Y');$i++){
            $optionsTahun[$i] = $i;
        }
        $optionsBulan = array();
        for($i=1;$i<=12;$i++){
            $optionsBulan[$i] = $this->utility->bulan($i);
        }

        $this->data['optionsTahun'] = $optionsTahun;
        $this->data['optionsBulan'] = $optionsBulan;
        $this->data['optionsLokasiBarang'] = $this->lokasi_barang_model->get_dropdown_array('nama', 'id');
        $this->data['optionsKondisiBarang'] = $this->kondisi_barang_model->get_dropdown_array('nama', 'id', null, null, 'kode', 'asc');
        $this->template
                ->set_title('Laporan Stok Opname Barang')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('lap_aset')
                ->build('laporan/asset_stock_opname', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        
        $unitId = $this->input->post('unit_id');
        $lokasiBarangId = $this->input->post('lokasi_barang_id');
        $kondisiBarangId = $this->input->post('kondisi_barang_id');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');

        $params['EXTRACT(YEAR FROM tanggal_stock_opname) = '] = $tahun;
        $params['EXTRACT(MONTH FROM tanggal_stock_opname) = '] = $bulan;

        if ($lokasiBarangId > 0) {
            $params['lokasi_barang_id'] = $lokasiBarangId;
        }
        if ($kondisiBarangId > 0) {
            $params['kondisi_id'] = $kondisiBarangId;
        }
        if ($unitId > 0) {
            $params['unit_id'] = $unitId;
        }else{
            $params['unit_id'] = $this->session->userdata('unit_id');
        }

        $this->datatables
                ->select("kondisi_nama, tanggal_stock_opname, barang_kode, barang_nama, catatan, lokasi_barang_nama", FALSE)
                ->from('asset_stock_opname')
                ->where($params, FALSE);
        echo $this->datatables->generate();
    }
    
    public function download_excel(){
    }
}    