<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kondisi_barang extends Admin_Controller {

    protected $form = array(
        'kode' => array(
            'label' => 'Kode',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
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
        $this->load->model('kondisi_barang_model');
        if ($this->input->post('cancel-button'))
            redirect('master/kondisi_barang/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->kondisi_barang_model->get_all_by_params($params);
        $this->template
                ->set_title('Lokasi Barang')
                ->set_layout('master')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/kondisi_barang-list', $this->data);
    }

    function edit($id) {
        $this->data['title'] = 'Edit Kondisi Barang';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input Kondisi Barang';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $kondisiForm = $this->form;

        if ($id > 0) {
            $rowKondisi = $this->kondisi_barang_model->get_by_id((int) $id);
            $kondisiForm['kode']['value'] = $rowKondisi->kode;
            $kondisiForm['nama']['value'] = $rowKondisi->nama;
        }

        $this->form_validation->init($kondisiForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->kondisi_barang_model->update($id, $data);
                $this->template->set_flashdata('success', 'Kondisi barang berhasil diupdate ');
            } else {
                $id = $this->kondisi_barang_model->insert($data);
                $this->template->set_flashdata('success', 'Kondisi b barangerhasil ditambah');
            }

            redirect('master/kondisi_barang');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->set_title('Lokasi Barang')
                ->set_layout('master')
                ->build('form', $this->data);
    }

    function delete($id) {
        $row = $this->kondisi_barang_model->get_by_id((int) $id);
        if($row){
            $this->kondisi_barang_model->update($id, array('status' => 0));
            $this->template->set_flashdata('success', 'Kondisi barang berhasil dihapus. ');
        }else{
            $this->template->set_flashdata('warning', 'Kondisi barang tidak ditemukan. ');
        }
        redirect('master/kondisi_barang');
    }
}