<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Status_akhir_pasien extends Admin_Controller {

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
        $this->load->model('status_akhir_pasien_model');
        if ($this->input->post('cancel-button'))
            redirect('master/status_akhir_pasien/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->status_akhir_pasien_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/status_akhir_pasien-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_status_akhir_pasien')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/status_akhir_pasien/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/status_akhir_pasien/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit status_akhir_pasien';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input status_akhir_pasien';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $status_akhir_pasienForm = $this->form;

        if ($id > 0) {
            $rowstatus_akhir_pasien = $this->status_akhir_pasien_model->get_by_id((int) $id);
            $status_akhir_pasienForm['nama']['value'] = $rowstatus_akhir_pasien->nama;
        }

        $this->form_validation->init($status_akhir_pasienForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->status_akhir_pasien_model->update($id, $data);
                $this->template->set_flashdata('success', 'status_akhir_pasien  berhasil diupdate ');
            } else {
                $id = $this->status_akhir_pasien_model->insert($data);
                $this->template->set_flashdata('success', 'status_akhir_pasien  ditambah');
            }

            redirect('master/status_akhir_pasien');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->status_akhir_pasien_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'status_akhir_pasien  berhasil dihapus ');
        redirect('master/status_akhir_pasien');
    }
}