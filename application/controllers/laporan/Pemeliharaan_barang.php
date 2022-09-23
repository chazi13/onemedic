<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pemeliharaan_barang extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('jenis_barang_model');
        $this->load->model('pemeliharaan_model');
    }
    
    public function index( $tglAwal = '', $tglAkhir = '', $jenis = 0 ){
        $tglAwalVal = ($tglAwal) ?  $tglAwal : date('Y-m-d') ;
        $tglAkhirVal = ($tglAkhir) ?  $tglAkhir : date('Y-m-d') ;
        $this->data['tgl_awal'] = $tglAwalVal;
        $this->data['tgl_akhir'] = $tglAkhirVal;
        $this->data['optionsJenisBarang'] = $this->jenis_barang_model->drop_options_tree();
        $this->data['jenis'] = $jenis;

        $params = array(
            "tanggal_pemeliharaan BETWEEN '".$tglAwalVal."' AND '".$tglAkhirVal."' " => null,
        );
        if ($jenis != 0){
            $params['jenis_barang_id'] = $jenis;
        }

        $rows = $this->db
                ->select('tanggal_pemeliharaan, barang_kode, barang_nama, asset_inventarisasi.kondisi_nama, asset_pemeliharaan.catatan', FALSE)
                ->join('asset_inventarisasi', 'asset_inventarisasi.id = asset_pemeliharaan.barang_id')
                ->get_where('asset_pemeliharaan', $params)
                ->result();

        $this->data['rows'] = $rows;
        $this->template
                ->set_title('Laporan Pemeliharaan Barang')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('lap_aset')
                ->build('laporan/pemeliharaan_barang', $this->data);
    }
    
    public function download_excel(){
    }
}    