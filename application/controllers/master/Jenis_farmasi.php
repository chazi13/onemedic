<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_farmasi extends Admin_Controller {

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
        $this->load->model('jenis_farmasi_model');
        if ($this->input->post('cancel-button'))
            redirect('master/jenis_farmasi/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->jenis_farmasi_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/jenis_farmasi-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_jenis_farmasi')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/jenis_farmasi/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/jenis_farmasi/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit Jenis Farmasi';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input Jenis Farmasi';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $jenis_farmasiForm = $this->form;

        if ($id > 0) {
            $rowjenis_farmasi = $this->jenis_farmasi_model->get_by_id((int) $id);
            $jenis_farmasiForm['nama']['value'] = $rowjenis_farmasi->nama;
        }

        $this->form_validation->init($jenis_farmasiForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->jenis_farmasi_model->update($id, $data);
                $this->template->set_flashdata('success', 'Jenis Farmasi  berhasil diupdate ');
            } else {
                $id = $this->jenis_farmasi_model->insert($data);
                $this->template->set_flashdata('success', 'Jenis Farmasi  ditambah');
            }

            redirect('master/jenis_farmasi');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->jenis_farmasi_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Jenis Farmasi  berhasil dihapus ');
        redirect('master/jenis_farmasi');
    }
}