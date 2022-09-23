<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kamar extends Admin_Controller {

    protected $form = array(
        'ruangan_id' => array(
            'helper' => 'form_hidden'
        ),
        'nama' => array(
            'label' => 'Nama',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'klasifikasi_tarif_id' => array(
            'label' => 'Klasifikasi Tarif',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'tarif' => array(
            'label' => 'Tarif/Harga',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'apotek_id' => array(
            'label' => 'Apetek/Depo',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->library('utility');
        $this->load->model('ruangan_model');
        $this->load->model('klasifikasi_tarif_model');
        $this->load->model('apotek_model');
        $this->load->model('kamar_model');
        if ($this->input->post('cancel-button'))
            redirect('master/kamar/index/'.$this->input->post('ruangan_id'));
    }

	function index($ruanganId=0) {
        $this->data['ruangan'] = $this->ruangan_model->get_by_id($ruanganId);
        
        //$this->data['rowsData'] = $this->kamar_model->get_all();
        $this->data['rowsData'] = $this->kamar_model->get_all_by_params(array('ruangan_id'=>$ruanganId, 'status' => 1));
        $this->template
                ->set_css('theme-default/libs/DataTables/jquery.dataTables')
                ->set_css('theme-default/libs/DataTables/extensions/dataTables.colVis')
                ->set_css('theme-default/libs/DataTables/extensions/dataTables.tableTools')
                ->set_js('libs/DataTables/jquery.dataTables.min')
                ->set_js('libs/DataTables/extensions/ColVis/js/dataTables.colVis.min', true)
                ->set_js('libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min', true)
                ->build('master/kamar-list',$this->data);
    }

    function edit($ruanganId,$id) {
        $ruangan = $this->ruangan_model->get_by_id($ruanganId);
        $this->data['title'] = 'Edit Kamar  Ruangan '.$ruangan->nama;
        $this->_updatedata($ruanganId,$id);
    }

    function add($ruanganId) {
        $ruangan = $this->ruangan_model->get_by_id($ruanganId);
        $this->data['title'] = 'Input Kamar Ruangan '.$ruangan->nama;
        $this->_updatedata($ruanganId);
    }

    function _updatedata($ruanganId, $id = 0) {
        $this->load->library('form_validation');
        $ruangan = $this->ruangan_model->get_by_id($ruanganId);
        $kamarForm = $this->form;
        $kamarForm['ruangan_id']['value'] = $ruanganId;
        $kamarForm['klasifikasi_tarif_id']['options'] = $this->klasifikasi_tarif_model->get_dropdown_array('nama', 'id');
        $kamarForm['apotek_id']['options'] = $this->apotek_model->get_dropdown_array('nama', 'id');

        if ($id > 0) {
            $rowKamar = $this->kamar_model->get_by_id((int) $id);
            $kamarForm['nama']['value'] = $rowKamar->nama;
            $kamarForm['klasifikasi_tarif_id']['value'] = $rowKamar->klasifikasi_tarif_id;
            $kamarForm['tarif']['value'] = $rowKamar->tarif;
            $kamarForm['apotek_id']['value'] = $rowKamar->apotek_id;
        }

        $this->form_validation->init($kamarForm);
        if ($this->form_validation->run()) {
            $data = $this->form_validation->get_values();
            $data['ruangan_id'] = $this->input->post('ruangan_id');
            if ($id > 0) {
                $this->kamar_model->update($id, $data );
                $this->template->set_flashdata('success', 'Kamar ruangan '.$ruangan->nama.' berhasil diupdate ');
            } else {
                $kamar_id = $this->kamar_model->insert($data);
                $this->template->set_flashdata('success', 'Kamar ruangan '.$ruangan->nama.' berhasil ditambah');
            }

            redirect('master/kamar/index/'.$ruangan->id);
        }
        $this->data['ruangan'] = $ruangan;
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form',$this->data);
    }

    function delete($id) {
        $this->kamar_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Kamar berhasil dihapus ');
        redirect('master/kamar');
    }
    
    function do_upload_photo($id) {
        $uid = $this->barang_model->get_uid_by_id($id);
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 0;
        $config['file_name'] = $uid.'.png';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
        } else {
            $arr_image = array('upload_data' => $this->upload->data());
            $img = $arr_image["upload_data"]["file_name"];
        }
    }

}