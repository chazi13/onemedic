<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rekening_bank extends Admin_Controller {

    protected $form = array(
        'bank_id' => array(
            'label' => 'Bank',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
		'nomor_rekening' => array(
            'label' => 'No. Rekening',
            'rules' => 'trim|required|max_length[50]',
            'helper' => 'form_inputlabel'
        ),
		'atas_nama' => array(
            'label' => 'An. Nama',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->model('bank_model');
        $this->load->model('rekening_bank_model');
        if ($this->input->post('cancel-button'))
            redirect('master/rekening_bank/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->rekening_bank_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/rekening_bank-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['mst_rekening_bank.status'] = 1;
        $this->datatables
                ->select("mst_bank.nama, mst_rekening_bank.id, mst_rekening_bank.nomor_rekening, mst_rekening_bank.atas_nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_rekening_bank')
                ->join('mst_bank','mst_bank.id = mst_rekening_bank.bank_id')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/rekening_bank/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/rekening_bank/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit Rekening Bank';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input Rekening Bank';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $rekening_bankForm = $this->form;
        $rekening_bankForm['bank_id']['options'] = $this->bank_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');

        if ($id > 0) {
            $rowrekening_bank = $this->rekening_bank_model->get_by_id((int) $id);
            $rekening_bankForm['bank_id']['value'] = $rowrekening_bank->bank_id;
            $rekening_bankForm['nomor_rekening']['value'] = $rowrekening_bank->nomor_rekening;
            $rekening_bankForm['atas_nama']['value'] = $rowrekening_bank->atas_nama;
        }

        $this->form_validation->init($rekening_bankForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->rekening_bank_model->update($id, $data);
                $this->template->set_flashdata('success', 'Rekening Bank  berhasil diupdate ');
            } else {
                $id = $this->rekening_bank_model->insert($data);
                $this->template->set_flashdata('success', 'Rekening Bank berhasil ditambahkan');
            }

            redirect('master/rekening_bank');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->rekening_bank_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Rekening Bank  berhasil dihapus ');
        redirect('master/rekening_bank');
    }
}