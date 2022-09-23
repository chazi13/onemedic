<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Merk extends Admin_Controller {

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
        $this->load->model('merk_model');
        if ($this->input->post('cancel-button'))
            redirect('master/merk/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->merk_model->get_all_by_params($params);
        $this->template
                ->set_title('Merk Barang')
                ->set_layout('master')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/merk-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_merk')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/merk/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/merk/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit Merk Barang';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input Merk Barang';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $merkForm = $this->form;

        if ($id > 0) {
            $rowmerk = $this->merk_model->get_by_id((int) $id);
            $merkForm['nama']['value'] = $rowmerk->nama;
        }

        $this->form_validation->init($merkForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->merk_model->update($id, $data);
                $this->template->set_flashdata('success', 'Merk barang berhasil diupdate ');
            } else {
                $id = $this->merk_model->insert($data);
                $this->template->set_flashdata('success', 'Merk barang berhasil ditambah');
            }

            redirect('master/merk');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->set_title('Merk Barang')
                ->set_layout('master')
                ->build('form', $this->data);
    }

    function delete($id) {
        $row = $this->merk_model->get_by_id((int) $id);
        if($row){
            $this->merk_model->update($id, array('status' => 0));
            $this->template->set_flashdata('success', 'Merk barang berhasil dihapus. ');
        }else{
            $this->template->set_flashdata('warning', 'Merk barang tidak ditemukan. ');
        }
        redirect('master/merk');
    }

}