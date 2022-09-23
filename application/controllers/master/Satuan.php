<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Satuan extends Admin_Controller {

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
        $this->load->model('satuan_model');
        if ($this->input->post('cancel-button'))
            redirect('master/satuan/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->satuan_model->get_all_by_params($params);
        $this->template
                ->set_title('Satuan')
                ->set_layout('master')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/satuan-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_satuan')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/satuan/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/satuan/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit satuan';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input satuan';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $satuanForm = $this->form;

        if ($id > 0) {
            $rowsatuan = $this->satuan_model->get_by_id((int) $id);
            $satuanForm['nama']['value'] = $rowsatuan->nama;
        }

        $this->form_validation->init($satuanForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->satuan_model->update($id, $data);
                $this->template->set_flashdata('success', 'Satuan berhasil diupdate ');
            } else {
                $id = $this->satuan_model->insert($data);
                $this->template->set_flashdata('success', 'Satuan berhasil ditambah');
            }

            redirect('master/satuan');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->set_title('Satuan')
                ->set_layout('master')
                ->build('form', $this->data);
    }

    function delete($id) {
        $row = $this->satuan_model->get_by_id((int) $id);
        if($row){
            $this->satuan_model->update($id, array('status' => 0));
            $this->template->set_flashdata('success', 'Satuan berhasil dihapus. ');
        }else{
            $this->template->set_flashdata('warning', 'Satuan tidak ditemukan. ');
        }
        redirect('master/satuan');
    }

}