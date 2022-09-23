<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Batal_registrasi extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
    }
    
    public function index(){
        $this->template
                ->set_title('Laporan Batal Registrasi')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('laporan')
                ->build('laporan/batal_registrasi-list');
    }
    
    function datatables(){
        $tglAwal = $this->input->post('tanggal_awal');
        $tglAkhir = $this->input->post('tanggal_akhir');
        $params['status'] = 0;
        if(empty($tglAwal)){
            $tglAwal = date('Y-m-d');
        }
        if(empty($tglAkhir)){
            $tglAkhir = date('Y-m-d');
        }
        
        $params["created BETWEEN '".$tglAwal."' AND '".$tglAkhir."'"] = NULL;
        
        $this->load->library('datatables');
        $this->datatables
                ->select('no_reg, nama, alamat, poli_nama, dokter_nama')
                ->where($params)
                ->from('pdf_pasien');
        echo $this->datatables->generate();
    }
    
    public function download_excel(){
    }
}    