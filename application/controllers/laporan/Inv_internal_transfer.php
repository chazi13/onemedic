<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inv_internal_transfer extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('apotek_model');
    }
    
    public function index(){
        
        $tglAwal    = $this->input->post('tgl_awal');
        $tglAkhir   = $this->input->post('tgl_akhir');
        $apotekIdDari      = $this->input->post('apotek_id_dari');
        $apotekIdKe        = $this->input->post('apotek_id_ke');
        $params['inv_apotek_stok_farmasi.status'] = 1;
        
        if(empty($tglAwal)){
            $tglAwal = date("Y-m-d", strtotime("-1 month"));
        }
        if(empty($tglAkhir)){
            $tglAkhir = date("Y-m-d");
        }
        
        $params["inv_apotek_stok_farmasi.created::DATE BETWEEN '".$tglAwal."' AND '".$tglAkhir."'"] = NULL;
        
        if(!empty($apotekIdDari)){
            $params["inv_apotek_stok_farmasi.apotek_id"] = $apotekIdDari;
        }
        if(!empty($apotekIdKe)){
            $params["inv_apotek_stok_farmasi.apotek_id"] = $apotekIdKe;
        }
        
        $this->data['tglAwal']  = $tglAwal;
        $this->data['tglAkhir'] = $tglAkhir;
        $this->data['optionsApotekDari'] = $this->apotek_model->get_dropdown_array('nama', 'id');
        $this->data['optionsApotekKe'] = $this->apotek_model->get_dropdown_array('nama', 'id');
        $this->data['apotekIdDari'] = $apotekIdDari;
        $this->data['apotekIdKe'] = $apotekIdKe;
        $this->template
                ->set_title('Laporan Mutasi Stok / Buku Besar')
                ->set_css('theme-default/libs/bootstrap-datepicker/datepicker3')
                ->set_js('libs/bootstrap-datepicker/bootstrap-datepicker', true)
                ->set_js('libs/bootstrap-datepicker/locales/bootstrap-datepicker.id', true)
                ->build('laporan/inv_internal_transfer-list', $this->data);
    }

    public function datatables(){
        return true;
    }
    
    public function download_excel(){
        return false;
    }
}    