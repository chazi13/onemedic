<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inv_mutasi_stok extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('apotek_model');
    }
    
    public function index(){
        
        $tglAwal    = $this->input->post('tgl_awal');
        $tglAkhir   = $this->input->post('tgl_akhir');
        $apotekId      = $this->input->post('apotek_id');
        $params['inv_apotek_stok_farmasi.status'] = 1;
        
        if(empty($tglAwal)){
            $tglAwal = date("Y-m-d", strtotime("-1 month"));
        }
        if(empty($tglAkhir)){
            $tglAkhir = date("Y-m-d");
        }
        
        $params["inv_apotek_stok_farmasi.created::DATE BETWEEN '".$tglAwal."' AND '".$tglAkhir."'"] = NULL;
        
        if(!empty($apotek)){
            $params["inv_apotek_stok_farmasi.apotek_id"] = $apotek;
        }
        
        $this->data['tglAwal']  = $tglAwal;
        $this->data['tglAkhir'] = $tglAkhir;
        $this->data['optionsApotek'] = $this->apotek_model->get_dropdown_array('nama', 'id');
        $this->data['apotekId'] = $apotekId;
        $this->template
                ->set_title('Laporan Mutasi Stok / Buku Besar')
                ->set_css('theme-default/libs/bootstrap-datepicker/datepicker3')
                ->set_js('libs/bootstrap-datepicker/bootstrap-datepicker', true)
                ->set_js('libs/bootstrap-datepicker/locales/bootstrap-datepicker.id', true)
                ->build('laporan/inv_mutasi_stok-list', $this->data);
    }

    public function datatables(){
        return true;
    }
    
    public function download_excel(){
        return false;
    }
}    