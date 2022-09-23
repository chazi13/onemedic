<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inv_retur_supplier extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('supplier_model');
    }
    
    public function index(){
        
        $tglAwal    = $this->input->post('tgl_awal');
        $tglAkhir   = $this->input->post('tgl_akhir');
        $supplierId = $this->input->post('supplier_id');
        $params['inv_apotek_stok_farmasi.status'] = 1;
        
        if(empty($tglAwal)){
            $tglAwal = date("Y-m-d", strtotime("-1 month"));
        }
        if(empty($tglAkhir)){
            $tglAkhir = date("Y-m-d");
        }
        
        $params["created::DATE BETWEEN '".$tglAwal."' AND '".$tglAkhir."'"] = NULL;

        if(!empty($supplierId)){
            $params["supplier_id"] = $supplierId;
        }
        
        $this->data['tglAwal']  = $tglAwal;
        $this->data['tglAkhir'] = $tglAkhir;
        $this->data['optionsSupplier'] = $this->supplier_model->get_dropdown_array('nama', 'id');
        $this->data['supplierId'] = $supplierId;
        $this->template
                ->set_title('Laporan Retur PBF')
                ->set_css('theme-default/libs/bootstrap-datepicker/datepicker3')
                ->set_js('libs/bootstrap-datepicker/bootstrap-datepicker', true)
                ->set_js('libs/bootstrap-datepicker/locales/bootstrap-datepicker.id', true)
                ->set_layout('laporan')
                ->build('laporan/inv_retur_supplier-list', $this->data);
    }

    public function datatables(){
        return true;
    }
    
    public function download_excel(){
        return false;
    }
}    