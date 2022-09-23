<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pendapatan_rwj extends Admin_Controller {
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
        $this->data['optionPoli'] = $this->poli_model->get_dropdown_array('nama', 'id');
        $this->data['optionDokter'] = $this->pegawai_model->get_dropdown_array('nama', 'id');
        $this->data['optionTipePasien'] = $this->tipe_pasien_model->get_dropdown_array('nama', 'id');
        
        $this->data['tgl_awal'] = $tgl_awal;
        $this->data['tgl_akhir'] = $tgl_akhir;
        
        $this->template
                ->set_title('Laporan Pendapatan Rawat Jalan')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('laporan')
                ->build('laporan/pendapatan_rwj',$this->data);
    }
    
    function datatables(){
            $this->load->library('datatables');
            $tglAwal = $this->input->post('tgl_awal');
            $tglAkhir = $this->input->post('tgl_akhir');
            $poli = $this->input->post('poli');
            $dokter = $this->input->post('dokter');
            $tipePasien = $this->input->post('tipe_pasien');
            
            $params = array(
                "pdf_pasien.created BETWEEN '".$tglAwal."' AND '".$tglAkhir."' " => null,
            );
            if($poli > 0)
                $params['pdf_pasien.poli_id'] = $poli;
            
            if($dokter > 0)
                $params['pdf_pasien.dokter_id'] = $dokter;
            
            if($tipePasien > 0)
                $params['pdf_pasien.tipe_pasien_id'] = $tipePasien;
            
            $this->datatables
               ->select('pdf_pasien.no_reg, pdf_pasien.no_mr, mst_pasien.nama, pdf_pasien.alamat, poli_nama as poliklinik, dokter_nama, mst_tipe_pasien.nama as tipe_pasien', FALSE)
               ->where($params)
               ->join('mst_tipe_pasien', 'mst_tipe_pasien.id = pdf_pasien.tipe_pasien_id')
               ->from('pdf_pasien');
            $this->datatables->join('mst_pasien', 'mst_pasien.no_mr = pdf_pasien.no_mr');
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