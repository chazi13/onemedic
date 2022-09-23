<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pendapatan_rwj_per_kasir extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('unit_model');
        $this->load->model('auth/user_model');
        $this->load->model('tipe_pasien_model');
        $this->load->model('pegawai_model');
        $this->load->model('poli_model');
    }
    
    public function index(){
        $tgl_awal  = date('Y-m-d');
        $tgl_akhir = date('Y-m-d');
        $this->data['optionUser'] = $this->user_model->get_dropdown_array('full_name', 'id');
        
        $this->data['tgl_awal'] = $tgl_awal;
        $this->data['tgl_akhir'] = $tgl_akhir;
        
        $this->template
                ->set_title('Laporan Pendapatan Rawat Jalan Per Kasir')
                ->set_js('plugins/tables/datatables/datatables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('laporan')
                ->build('laporan/pendapatan_rwj_per_kasir',$this->data);
    }
    
    function datatables(){
            $this->load->library('datatables');
            $tglAwal = $this->input->post('tgl_awal');
            $tglAkhir = $this->input->post('tgl_akhir');
            $user = $this->input->post('user_id');
            
            $params = array(
                "created BETWEEN '".$tglAwal."' AND '".$tglAkhir."' " => null,
            );
            if($user > 0)
                $params['created_by'] = $user;
            
            $this->datatables
               ->select('no_reg, no_mr, nama, alamat, poli_nama, dokter_nama, total_tagihan, total_penjamin, total_selisih', FALSE)
               ->where($params)
               ->from('ksr_rawat_jalan');
            echo $this->datatables->generate();
    }
    
    public function download_excel($tglAwal, $tglAkhir, $poliId){
        
        $user = $this->user_model->get_by_id($this->session->userdata('auth_user'));

        $this->data['user'] = $user;
        
        $params = array("tgl_awal between '{$tglAwal}' and '{$tglAkhir}'" => NULL, "poli_id" => $poliId);
        echo "<pre>";
        echo var_dump($this->db->last_query());
        echo "</pre>";

        $this->data['tgl_awal']     = $tglAwal;
        $this->data['tgl_akhir']    = $tglAkhir;
        $this->data['poli_id']      = $poliId;
        $this->data['rowsData']     = $data;
        
        $this->load->view('laporan/laporan_kunjungan_pasien-xls', $this->data);
    }
}    