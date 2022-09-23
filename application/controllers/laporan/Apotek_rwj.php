<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Apotek_rwj extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('poli_model');
    }

    public function index(){
        $tglAwal = date("Y-m-d", strtotime("-1 month"));
        $tglAkhir = date("Y-m-d");
        
        $this->data['tglAwal']  = $tglAwal;
        $this->data['tglAkhir'] = $tglAkhir;
        $this->data['optionsShift'] = array_merge(array('' => '( Kosong )'), $this->config->item('shift_jam_kerja') );
        $this->data['optionsPoli'] = $this->poli_model->get_dropdown_array('nama', 'id');
        $this->template
                ->set_title('Laporan Penjualan Apotek Rawat Jalan')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('laporan')
                ->build('laporan/apotek_rwj-list', $this->data);
    }


    function datatables(){
        $this->load->library('datatables');
        $tglAwal = $this->input->post('tanggal_awal');
        $tglAkhir = $this->input->post('tanggal_akhir');
        $poliId = $this->input->post('poli_id');
        
        $params = array(
            "ksr_rawat_jalan.created BETWEEN '".$tglAwal."' AND '".$tglAkhir."' " => null,
        );
        if(!empty($shift)){
            $arrShift = explode('-', $shift);
            $params["ksr_rawat_jalan.created::TIME BETWEEN '".$arrShift[0].":00' AND '".$arrShift[1].":00'"] = NULL;
        }
        if(!empty($poliId)){
            $params["ksr_rawat_jalan.poli_id"] = $poliId;
        }
        
        $this->datatables
           ->select('ksr_rawat_jalan.created::DATE AS tanggal,'
           . 'ksr_rawat_jalan.no_reg, '
           . 'ksr_rawat_jalan.nama, '
           . 'apt_rawat_jalan.no_resep, '
           . 'apt_rawat_jalan_item.item_nama, '
           . 'apt_rawat_jalan_item.banyaknya, '
           . 'apt_rawat_jalan_item.satuan_nama, '
           . 'apt_rawat_jalan_item.hna', FALSE)
           ->where($params, FALSE, FALSE)
           ->join('apt_rawat_jalan', 'apt_rawat_jalan.pendaftaran_id = ksr_rawat_jalan.pendaftaran_id')
           ->join('apt_rawat_jalan_item', 'apt_rawat_jalan_item.apotek_rawat_jalan_id = apt_rawat_jalan.id')
           ->from('ksr_rawat_jalan');
        echo $this->datatables->generate();
    }
    
    public function download_excel(){
        return false;
    }
}    