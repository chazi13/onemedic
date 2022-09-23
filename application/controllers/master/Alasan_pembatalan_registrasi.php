<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Alasan_pembatalan_registrasi extends Admin_Controller {

    protected $form = array(
        'uraian' => array(
            'label' => 'Uraian',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->model('alasan_pembatalan_registrasi_model');
        if ($this->input->post('cancel-button'))
            redirect('master/alasan_pembatalan_registrasi/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->alasan_pembatalan_registrasi_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/alasan_pembatalan_registrasi-list', $this->data);
    }

    function edit($id) {
        $this->data['title'] = 'Edit Alasan Pembatalan Registrasi';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input Alasan Pembatalan Registrasi';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $kondisiForm = $this->form;

        if ($id > 0) {
            $rowKondisi = $this->alasan_pembatalan_registrasi_model->get_by_id((int) $id);
            $kondisiForm['uraian']['value'] = $rowKondisi->uraian;
        }

        $this->form_validation->init($kondisiForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->alasan_pembatalan_registrasi_model->update($id, $data);
                $this->template->set_flashdata('success', 'Alasan Pembatalan Registrasi berhasil diupdate ');
            } else {
                $id = $this->alasan_pembatalan_registrasi_model->insert($data);
                $this->template->set_flashdata('success', 'Kondisi b barangerhasil ditambah');
            }

            redirect('master/alasan_pembatalan_registrasi');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->alasan_pembatalan_registrasi_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Alasan Pembatalan Registrasi berhasil dihapus ');
        redirect('master/alasan_pembatalan_registrasi');
    }
}