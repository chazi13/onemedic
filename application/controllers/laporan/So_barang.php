<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class So_barang extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('asset_stock_opname_model');
    }
    
    public function index( $tanggal = ''){
        $tanggal = ($tanggal) ?  $tanggal : date('Y-m-d') ;
        $this->data['tanggal'] = $tanggal;

        if ($tanggal != 0){
            $params['tanggal_stock_opname'] = $tanggal;
        }

        $rows = $this->db
                ->select('barang_kode, barang_nama, kondisi_nama, catatan', FALSE)
                ->get_where('asset_stock_opname', $params)
                ->result();

        $this->data['rows'] = $rows;
        $this->template
                ->set_title('Laporan Stok Opname Barang')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('lap_aset')
                ->build('laporan/so_barang', $this->data);
    }
    
    public function download_excel(){
    }
}    