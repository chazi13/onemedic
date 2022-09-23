<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Unit_medis_fungsional extends Admin_Controller {

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
        $this->load->model('unit_medis_fungsional_model');
        if ($this->input->post('cancel-button'))
            redirect('master/unit_medis_fungsional/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->unit_medis_fungsional_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/unit_medis_fungsional-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_unit_medis_fungsional')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/unit_medis_fungsional/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/unit_medis_fungsional/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit Unit Medis Fungsional';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input Unit Medis Fungsional';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $unit_medis_fungsionalForm = $this->form;

        if ($id > 0) {
            $rowunit_medis_fungsional = $this->unit_medis_fungsional_model->get_by_id((int) $id);
            $unit_medis_fungsionalForm['nama']['value'] = $rowunit_medis_fungsional->nama;
        }

        $this->form_validation->init($unit_medis_fungsionalForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->unit_medis_fungsional_model->update($id, $data);
                $this->template->set_flashdata('success', 'Unit Medis Fungsional  berhasil diupdate ');
            } else {
                $id = $this->unit_medis_fungsional_model->insert($data);
                $this->template->set_flashdata('success', 'Unit Medis Fungsional  ditambah');
            }

            redirect('master/unit_medis_fungsional');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->unit_medis_fungsional_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Unit Medis Fungsional  berhasil dihapus ');
        redirect('master/unit_medis_fungsional');
    }
}