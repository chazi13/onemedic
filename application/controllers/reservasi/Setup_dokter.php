<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setup_dokter extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('pegawai_model');
        $this->load->model('poli_model');
        $this->load->model('reservasi_poli_model');
        $this->load->model('reservasi_jadwal_dokter_model');
    }

    function index($dokterId = 0) {
        $this->_updatedata($dokterId);
    }
    
    function _updatedata($dokterId = 0) {
        if($this->input->post('dokter_id')){
            $dokterId = $this->input->post('dokter_id');
            // get dokter 
            $dokter = $this->pegawai_model->get_by_id($dokterId);
            !empty($dokter) ? $dokterNama = $dokter->nama : $dokterNama = '';
            
            $this->reservasi_jadwal_dokter_model->delete_by_dokter($dokterId);
            for($i=1; $i<=3;$i++):
                if($this->input->post('poli_id_'.$i)):
                    $poliId = $this->input->post('poli_id_'.$i);
                    // get poliklinik 
                    $poli = $this->poli_model->get_by_id($poliId);
                    !empty($poli) ? $poliNama = $poli->nama : $poliNama = '';

                    $arrData['dokter_id'] = $dokterId;
                    $arrData['dokter_nama'] = $dokterNama;
                    $arrData['poli_id'] = $poliId;
                    $arrData['poli_nama'] = $poliNama;
                    for($n=1;$n<=7;$n++):
                        if($this->input->post($n.'_'.$i)){
                            $arrData['hari_'.$n] = $this->input->post($n.'_'.$i);
                            $arrData['start_num_reg_ol_'.$n] = !empty($this->input->post('start_num_reg_ol_'.$n.'_'.$i)) ? $this->input->post('start_num_reg_ol_'.$n.'_'.$i) : 0; 
                            $arrData['max_reg_ol_'.$n] = !empty($this->input->post('max_reg_ol_'.$n.'_'.$i)) ? $this->input->post('max_reg_ol_'.$n.'_'.$i) : 0; 
                            $arrData['max_reg_ol_bpjs_'.$n] = !empty($this->input->post('max_reg_ol_bpjs_'.$n.'_'.$i)) ? $this->input->post('max_reg_ol_bpjs_'.$n.'_'.$i) : 0; 

                        }
                    endfor;
                    $this->reservasi_jadwal_dokter_model->insert($arrData);
                    $arrData = array();
                endif;
            endfor;
            $this->template->set_flashdata('success', 'Jadwal prektek dokter berhasil disimpan ');
            redirect('reservasi/setup_dokter');
        }
        $this->data['dokterId'] = $dokterId;
        $this->data['rowsDokter'] = $this->pegawai_model->get_dokter();
        $this->data['rowsPoli'] = $this->reservasi_poli_model->get_all_by_params();
        $this->data['rowsPraktek'] = $this->reservasi_jadwal_dokter_model->get_all_by_params(array('dokter_id' => $dokterId));
        $this->template
                ->set_title('Setup Jadwal Dokter')
                ->set_js('plugins/inputmask/jquery.inputmask.bundle.min', true)
                ->set_layout('pendaftaran')
                ->build('reservasi/setup_dokter', $this->data);
    }

    function delete($id)
    {
        $this->reservasi_jadwal_dokter_model->delete($id);
        $this->template->set_flashdata('success', 'Jadwal prektek dokter berhasil dihapus ');
        redirect('reservasi/setup_dokter');
    }


}
