<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rwi_pendapatan extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('tipe_pasien_model');
        $this->load->model('poli_model');
    }
    
    public function index(){
        
        /// BLOM JADI
        $tglAwal    = $this->input->post('tanggal_awal');
        $tglAkhir   = $this->input->post('tanggal_akhir');
        $ruangan      = $this->input->post('ruangan_id');
        $shift      = $this->input->post('shift');
        $params['ksr_rawat_jalan.status'] = 1;
        
        if(empty($tglAwal)){
            $tglAwal = date("Y-m-d", strtotime("-1 month"));
        }
        if(empty($tglAkhir)){
            $tglAkhir = date("Y-m-d");
        }
        
        $params["ksr_rawat_jalan.created_date::DATE BETWEEN '".$tglAwal."' AND '".$tglAkhir."'"] = NULL;
        
        
        $this->data['tglAwal']  = $tglAwal;
        $this->data['tglAkhir'] = $tglAkhir;
        $this->data['optionPoli'] = $this->poli_model->get_dropdown_array('nama', 'id');
        $this->data['optionTipePasien'] = $this->tipe_pasien_model->get_dropdown_array('nama', 'id');
        $this->template
                ->set_title('Laporan Pendapatan Pasien Rawat Inap')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->build('laporan/rwi_pendapatan-list', $this->data);
    }
    
    public function download_excel(){
        return false;
    }
}    