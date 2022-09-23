<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdf_pasien_per_periode extends Admin_Controller {


    function __construct() {
        parent::__construct();
        
        $this->load->library('form_validation');
        
        $this->load->model('pegawai_model');
        $this->load->model('poli_model');
        $this->load->model('pendaftaran_model');
    }

    function index() {
        $this->load->library('utility');
        $this->data[] = '';
        $this->template
                ->set_title('EIS - Jumlah Pendaftaran Pasien Per Periode')
                ->set_js('plugins/visualization/echarts/echarts.min', false)
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('pendaftaran')
                ->build('eis/pdf_pasien_per_periode', $this->data);
    }
}
