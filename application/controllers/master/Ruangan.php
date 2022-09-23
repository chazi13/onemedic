<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ruangan extends Admin_Controller {

    protected $form = array(
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
        if ($this->input->post('cancel-button'))
            redirect('master/ruangan/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->ruangan_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/ruangan-list', $this->data);
    }

    function edit($id) {
        $this->data['form_title'] = 'Edit Ruangan';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['form_title'] = 'Input Ruangan';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $ruanganForm = $this->form;

        if ($id > 0) {
            $rowRuangan = $this->ruangan_model->get_by_id((int) $id);
            $ruanganForm['nama']['value'] = $rowRuangan->nama;
        }

        $this->form_validation->init($ruanganForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->ruangan_model->update($id, $data);
                $this->template->set_flashdata('success', 'Ruangan berhasil diupdate ');
            } else {
                $ruangan_id = $this->ruangan_model->insert($data);
                $this->template->set_flashdata('success', 'Ruangan berhasil ditambah');
            }

            redirect('master/ruangan');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('master/ruangan-form', $this->data);
    }

    function delete($id) {
        $this->ruangan_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Ruangan berhasil dihapus ');
        redirect('master/ruangan');
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