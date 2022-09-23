<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Poli extends Admin_Controller {

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
        $this->load->model('poli_model');
        if ($this->input->post('cancel-button'))
            redirect('master/poli/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->poli_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/poli-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_poli')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/poli/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/poli/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit poli';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input poli';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $poliForm = $this->form;

        if ($id > 0) {
            $rowpoli = $this->poli_model->get_by_id((int) $id);
            $poliForm['nama']['value'] = $rowpoli->nama;
        }

        $this->form_validation->init($poliForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->poli_model->update($id, $data);
                $this->template->set_flashdata('success', 'poli  berhasil diupdate ');
            } else {
                $id = $this->poli_model->insert($data);
                $this->template->set_flashdata('success', 'poli  ditambah');
            }

            redirect('master/poli');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->poli_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'poli  berhasil dihapus ');
        redirect('master/poli');
    }
}