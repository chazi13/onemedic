<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bed extends Admin_Controller {

    protected $form = array(
        'kamar_id' => array(
            'helper' => 'form_hidden'
        ),
        'nama' => array(
            'label' => 'Nama',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->model('ruangan_model');
        $this->load->model('kamar_model');
        $this->load->model('bed_model');
        if ($this->input->post('cancel-button'))
            redirect('master/bed/index/'.$this->input->post('kamar_id'));
    }

	function index($kamarId) {
        $kamar = $this->kamar_model->get_by_id($kamarId);
        $this->data['ruangan'] = $this->ruangan_model->get_by_id($kamar->ruangan_id);
        $this->data['kamar'] = $kamar;
        $this->data['rowsData'] = $this->bed_model->get_all_by_params(array('kamar_id'=>$kamarId));
        $this->template
                ->build('master/bed-list', $this->data);
    }

    function edit($kamarId,$id) {
        $this->data['title'] = 'Edit Bed ';
        $this->_updatedata($kamarId,$id);
    }

    function add($kamarId) {
        $this->data['title'] = 'Input Bed ';
        $this->_updatedata($kamarId);
    }

    function _updatedata($kamarId, $id = 0) {
        $this->load->library('form_validation');
        $ruangan = $this->ruangan_model->get_by_id($kamarId);
        $bedForm = $this->form;
        $bedForm['kamar_id']['value'] = $kamarId;

        if ($id > 0) {
            $rowBed = $this->bed_model->get_by_id((int) $id);
            $bedForm['nama']['value'] = $rowBed->nama;
        }

        $this->form_validation->init($bedForm);
        if ($this->form_validation->run()) {
            $data = $this->form_validation->get_values();
            $data['kamar_id'] = $this->input->post('kamar_id');
            if ($id > 0) {
                $this->bed_model->update($id, $data );
                $this->template->set_flashdata('success', 'Bed ruangan '.$ruangan->nama.' berhasil diupdate ');
            } else {
                $bed_id = $this->bed_model->insert($data);
                $this->template->set_flashdata('success', 'Bed ruangan '.$ruangan->nama.' berhasil ditambah');
            }

            redirect('master/bed/index/'.$kamarId);
        }
        $this->data['ruangan'] = $ruangan;
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form',$this->data);
    }

    function delete($kamarId, $id) {
        $this->bed_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Bed berhasil dihapus ');
        redirect('master/bed/index/'.$kamarId);
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