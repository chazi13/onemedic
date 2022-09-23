<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Apotek_rwi extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('ruangan_model');
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
        
        if(!empty($ruangan)){
            $params["ksr_rawat_jalan.poli_id"] = $ruangan;
        }
        if(!empty($shift)){
            $arrShift = explode('-', $shift);
            $params["ksr_rawat_jalan.created_date::TIME BETWEEN '".$arrShift[0].":00' AND '".$arrShift[1].":00'"] = NULL;
        }
        
        $this->data['tglAwal']  = $tglAwal;
        $this->data['tglAkhir'] = $tglAkhir;
        $this->data['optionsRuangan'] = $this->ruangan_model->get_dropdown_array('nama', 'id');
        $this->template
                ->set_title('Laporan Apotek Rawat Inap')                
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('laporan')
                ->build('laporan/apotek_rwi-list', $this->data);
    }
    
    public function download_excel(){
        return false;
    }
}    