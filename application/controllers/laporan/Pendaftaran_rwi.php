<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pendaftaran_rwi extends Admin_Controller {
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
                ->set_title('Laporan Pendaftaran Rawat Inap')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('laporan')
                ->build('laporan/pendaftaran_rwi-list', $this->data);
    }
    
    function datatables(){
            $this->load->library('datatables');
            $tglAwal = $this->input->post('tgl_awal');
            $tglAkhir = $this->input->post('tgl_akhir');
            $poli = $this->input->post('poli');
            $dokter = $this->input->post('dokter');
            
            $params = array(
                "created BETWEEN '".$tglAwal."' AND '".$tglAkhir."' " => null,
            );
            if($poli > 0)
                $params['poli_id_asal'] = $poli;
            
            if($dokter > 0)
                $params['dokter_dpjp_id'] = $dokter;
            
            $this->datatables
               ->select('pdf_pasien_rawat_inap.no_reg, pdf_pasien_rawat_inap.no_mr, pdf_pasien_rawat_inap.nama, pdf_pasien_rawat_inap.alamat, pdf_pasien_rawat_inap.poli_nama_asal, dokter_dpjp_nama AS dokter', FALSE)
               ->where($params)
               ->from('pdf_pasien_rawat_inap');
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