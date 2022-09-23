<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group_display extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('poli_model');
        $this->load->model('reservasi_jadwal_dokter_model');
        $this->load->model('antrian_display_model');
        if($this->input->post('cancel-button')){
            redirect('antrian/group_display');
        }
    }

    function index() {
        $this->data['rows'] = $this->antrian_display_model->get_all();
        $this->template
        ->build('antrian/group_display-index', $this->data);
    }
    
    function add(){
        $this->_updatedata();
    }
    
    function edit($grup) {
        $this->_updatedata($grup);
    }
    
    function _updatedata($grup = 0) {
        if($this->input->post()){
            // delete dahulu, karena tidak ada edit
            $this->antrian_display_model->delete_by_grup($grup);

            $arrDokter = $this->input->post('dokter_id');
            foreach($arrDokter as $key => $val):
                // jadwal 
                $jadwal = $this->db->query("SELECT poli_id, poli_nama, dokter_nama FROM pdf_reservasi_jadwal_dokter WHERE dokter_id = '".$val."'")->row();
                if($jadwal) {
                    $dokterNama = $jadwal->dokter_nama;
                    $poliId = $jadwal->poli_id;
                    $poliNama = $jadwal->poli_nama;

                    $arrData['poli_id']     = $poliId;
                    $arrData['poli_nama']   = $poliNama;
                    $arrData['dokter_id']     = $val;
                    $arrData['dokter_nama']   = $dokterNama;
                    $arrData['grup']   = $grup;
                    $this->antrian_display_model->insert($arrData);
                }
            endforeach;
            $this->template->set_flashdata('success', 'Grup display antrian berhasil disimpan ');
            redirect('antrian/group_display');
        }
        $this->data['grup'] = $grup;
        $this->data['rowsDokterPoli'] = $this->db->query("SELECT DISTINCT poli_id, poli_nama, dokter_id, dokter_nama FROM pdf_reservasi_jadwal_dokter ORDER BY poli_nama, dokter_nama ASC")->result();
        // $this->data['rowsDisplay'] = $this->antrian_display_model->get_all(array('grup' => "$grup"));
        $this->template
                ->set_js('plugins/forms/styling/uniform.min')
                ->set_js('plugins/forms/styling/switchery.min')
                ->set_js('plugins/forms/styling/switch.min')
                ->set_js('plugins/forms/form_checkboxes_radios')
                ->build('antrian/group_display-form', $this->data);
    }

}
