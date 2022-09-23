<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rwi_pasien_pulang extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
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
        $this->template
                ->set_title('Laporan Pasien Pulang Rawat Inap')
                ->set_css('theme-default/libs/bootstrap-datepicker/datepicker3')
                ->set_js('libs/bootstrap-datepicker/bootstrap-datepicker', true)
                ->set_js('libs/bootstrap-datepicker/locales/bootstrap-datepicker.id', true)
                ->build('laporan/rwi_pasien_pulang-list', $this->data);
    }
    
    public function download_excel(){
        return false;
    }
}    