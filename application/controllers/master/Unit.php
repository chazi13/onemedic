<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Unit extends Admin_Controller {

    protected $form = array(
        'kode' => array(
            'label' => 'Kode',
            'rules' => 'trim|required|max_length[20]',
            'helper' => 'form_inputlabel'
        ),
        'nama' => array(
            'label' => 'Nama',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'alamat' => array(
            'label' => 'Alamat',
            'rules' => 'trim|required|max_length[250]',
            'helper' => 'form_inputlabel'
        ),
        'telepon' => array(
            'label' => 'Telepon',
            'rules' => 'trim|required|max_length[50]',
            'helper' => 'form_inputlabel'
        ),
        'fax' => array(
            'label' => 'Fax',
            'rules' => 'trim|required|max_length[50]',
            'helper' => 'form_inputlabel'
        ),
        'email' => array(
            'label' => 'Email',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'kabupaten_kota' => array(
            'label' => 'Kab. / Kota',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->model('unit_model');
        if ($this->input->post('cancel-button'))
            redirect('master/unit/index');
    }

	function index() {
        $params = array();
        $this->data['rowsData'] = $this->unit_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/unit-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params = array();
        $this->datatables
                ->select("id, nama, alamat, email", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_unit')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/unit/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/unit/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit unit';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input unit';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $unitForm = $this->form;

        if ($id > 0) {
            $rowunit = $this->unit_model->get_by_id((int) $id);
            $unitForm['nama']['value'] = $rowunit->nama;
        }

        $this->form_validation->init($unitForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->unit_model->update($id, $data);
                $this->template->set_flashdata('success', 'unit  berhasil diupdate ');
            } else {
                $id = $this->unit_model->insert($data);
                $this->template->set_flashdata('success', 'unit  ditambah');
            }

            redirect('master/unit');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->unit_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'unit  berhasil dihapus ');
        redirect('master/unit');
    }
}