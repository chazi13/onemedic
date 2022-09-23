<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class setup_poliklinik extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('poli_model');
        $this->load->model('reservasi_poli_model');
    }

    
    function index() {
        if($this->input->post()){
            $this->reservasi_poli_model->delete_all();
            $arrPoli = $this->input->post('poli_id');
            foreach($arrPoli as $key => $val):
                // get poliklinik 
                $poli = $this->poli_model->get_by_id($val);
                !empty($poli) ? $poliNama = $poli->nama : $poliNama = '';
                $arrData['poli_id']     = $val;
                $arrData['poli_nama']   = $poliNama;
                $this->reservasi_poli_model->insert($arrData);
            endforeach;
            $this->template->set_flashdata('success', 'Akses Poliklinik untuk reservasi berhasil disimpan ');
            redirect('reservasi/setup_poliklinik');
        }
        $this->data['rowsPoli'] = $this->poli_model->get_all_by_params(array('status' => 1));
        $this->data['rowsPoliReservasi'] = $this->reservasi_poli_model->get_all();
        $this->template
                ->set_title('Setup Poliklinik Reservasi')
                ->set_layout('pendaftaran')
                ->set_layout('pendaftaran')
                ->build('reservasi/setup_poliklinik', $this->data);
    }

}
