<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apotek extends Admin_Controller {

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
        $this->load->model('apotek_model');
        if ($this->input->post('cancel-button'))
            redirect('master/apotek/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->apotek_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/apotek-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_apotek')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/apotek/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/apotek/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit Apotek';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input Apotek';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $apotekForm = $this->form;

        if ($id > 0) {
            $rowapotek = $this->apotek_model->get_by_id((int) $id);
            $apotekForm['nama']['value'] = $rowapotek->nama;
        }

        $this->form_validation->init($apotekForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->apotek_model->update($id, $data);
                $this->template->set_flashdata('success', 'Apotek  berhasil diupdate ');
            } else {
                $id = $this->apotek_model->insert($data);
                $this->template->set_flashdata('success', 'Apotek berhasil ditambahkan');
            }

            redirect('master/apotek');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->apotek_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Apotek  berhasil dihapus ');
        redirect('master/apotek');
    }
}