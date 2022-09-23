<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Apotek_pemakaian_obat_per_dokter extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('poli_model');
        $this->load->model('pegawai_model');
    }
    
    public function index(){
        $tglAwal = date("Y-m-d", strtotime("-1 month"));
        $tglAkhir = date("Y-m-d");
        $dokterId      = $this->input->post('pegawai_id');
        
        $this->data['tglAwal']  = $tglAwal;
        $this->data['tglAkhir'] = $tglAkhir;
        $this->data['optionsDokter'] = $this->pegawai_model->dokter_drop_options();
        $this->template
                ->set_title('Laporan Pemakai Obat Per Dokter')                
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('laporan')
                ->build('laporan/apotek_pemakaian_obat_per_dokter-list', $this->data);
    }

    function datatables(){
        $this->load->library('datatables');
        $tglAwal = $this->input->post('tanggal_awal');
        $tglAkhir = $this->input->post('tanggal_akhir');
        $dokterId = $this->input->post('dokter_id');
        
        $params = array(
            "ksr_rawat_jalan.created BETWEEN '".$tglAwal."' AND '".$tglAkhir."' " => null,
        );
        if(!empty($poliId)){
            $params["ksr_rawat_jalan.dokter_id"] = $dokterId;
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