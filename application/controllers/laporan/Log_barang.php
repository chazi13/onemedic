<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log_barang extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('jenis_barang_model');
        $this->load->model('lokasi_barang_model');
        $this->load->model('mutasi_model');
    }
    
    public function index( $tglAwal = '', $tglAkhir = '', $jenis = 0, $lokasiDari = 0, $lokasiKe = 0 ){
        $tglAwalVal = ($tglAwal) ?  $tglAwal : date('Y-m-d') ;
        $tglAkhirVal = ($tglAkhir) ?  $tglAkhir : date('Y-m-d') ;
        $this->data['tgl_awal'] = $tglAwalVal;
        $this->data['tgl_akhir'] = $tglAkhirVal;
        $this->data['optionsJenisBarang'] = $this->jenis_barang_model->drop_options_tree();
        $this->data['jenis'] = $jenis;
        $this->data['optionsLokasiBarang'] = $this->lokasi_barang_model->get_dropdown_array('nama', 'id');
        $this->data['lokasiDari'] = $lokasiDari;
        $this->data['lokasiKe'] = $lokasiKe;

        $params = array(
            "tanggal_mutasi BETWEEN '".$tglAwalVal."' AND '".$tglAkhirVal."' " => null,
        );
        if ($jenis != 0){
            $params['jenis_barang_id'] = $jenis;
        }
        if ($lokasiDari > 0){
            $params['lokasi_barang_id_dari'] = $lokasiDari;
        }
        if ($lokasiKe > 0){
            $params['lokasi_barang_id_ke'] = $lokasiKe;
        }
        

        $rows = $this->db
                ->select('tanggal_mutasi, barang_kode, barang_nama, asset_inventarisasi.kondisi_nama, lokasi_barang_nama_dari, lokasi_barang_nama_ke', FALSE)
                ->join('asset_inventarisasi', 'asset_inventarisasi.id = asset_mutasi.barang_id')
                ->get_where('asset_mutasi', $params)
                ->result();

        $this->data['rows'] = $rows;
        $this->template
                ->set_title('Laporan Mutasi Barang')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('lap_aset')
                ->build('laporan/Log_barang', $this->data);
    }
    
    public function download_excel(){
    }
}    