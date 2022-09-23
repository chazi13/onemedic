<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bentuk_sediaan extends Admin_Controller {

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
        $this->load->model('bentuk_sediaan_model');
        if ($this->input->post('cancel-button'))
            redirect('master/bentuk_sediaan/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->bentuk_sediaan_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/bentuk_sediaan-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_bentuk_sediaan')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/bentuk_sediaan/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/bentuk_sediaan/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit Bentuk Sediaan';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input Bentuk Sediaan';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $bentuk_sediaanForm = $this->form;

        if ($id > 0) {
            $rowbentuk_sediaan = $this->bentuk_sediaan_model->get_by_id((int) $id);
            $bentuk_sediaanForm['nama']['value'] = $rowbentuk_sediaan->nama;
        }

        $this->form_validation->init($bentuk_sediaanForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->bentuk_sediaan_model->update($id, $data);
                $this->template->set_flashdata('success', 'Bentuk Sediaan  berhasil diupdate ');
            } else {
                $id = $this->bentuk_sediaan_model->insert($data);
                $this->template->set_flashdata('success', 'Bentuk Sediaan berhasil ditambahkan');
            }

            redirect('master/bentuk_sediaan');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->bentuk_sediaan_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Bentuk Sediaan  berhasil dihapus ');
        redirect('master/bentuk_sediaan');
    }
}