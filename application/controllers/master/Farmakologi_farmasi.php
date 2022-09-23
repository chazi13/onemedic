<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Farmakologi_farmasi extends Admin_Controller {

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
        $this->load->model('farmakologi_model');
        if ($this->input->post('cancel-button'))
            redirect('master/farmakologi_farmasi/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->farmakologi_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/farmakologi_farmasi-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_farmakologi')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/farmakologi_farmasi/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/farmakologi_farmasi/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit Farmakologi Farmasi';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input Farmakologi Farmasi';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $farmakologi_farmasiForm = $this->form;

        if ($id > 0) {
            $rowfarmakologi_farmasi = $this->farmakologi_model->get_by_id((int) $id);
            $farmakologi_farmasiForm['nama']['value'] = $rowfarmakologi_farmasi->nama;
        }

        $this->form_validation->init($farmakologi_farmasiForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->farmakologi_model->update($id, $data);
                $this->template->set_flashdata('success', 'Farmakologi Farmasi  berhasil diupdate ');
            } else {
                $id = $this->farmakologi_model->insert($data);
                $this->template->set_flashdata('success', 'Farmakologi Farmasi  ditambah');
            }

            redirect('master/farmakologi_farmasi');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->farmakologi_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Farmakologi Farmasi  berhasil dihapus ');
        redirect('master/farmakologi_farmasi');
    }
}