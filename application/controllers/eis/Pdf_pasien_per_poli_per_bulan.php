<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdf_pasien_per_poli_per_bulan extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->library('form_validation');
        
        $this->load->model('pegawai_model');
        $this->load->model('poli_model');
        $this->load->model('pendaftaran_model');
    }

    function index() {
        $this->load->library('utility');
        $this->data['optionsPoli'] = $this->poli_model->get_dropdown_array('nama', 'id');
        for($iBulan=1;$iBulan<=12;$iBulan++){
            $arrBulan[$iBulan] = $this->utility->bulan($iBulan);
        }
        for($iTahun=2017;$iTahun<=date('Y');$iTahun++){
            $arrTahun[$iTahun] = $iTahun;
        }
        $this->data['optionsBulan'] = $arrBulan;
        $this->data['optionsTahun'] = $arrTahun;
        $this->template
                ->set_title('EIS - Jumlah Pendaftaran Pasien Per Poliklinik per Periode Bulan Tahun ')
                ->set_js('plugins/visualization/echarts/echarts.min', false)
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('pendaftaran')
                ->build('eis/pdf_pasien_per_poli_per_bulan', $this->data);
    }
}