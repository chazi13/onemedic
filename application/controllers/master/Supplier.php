<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier extends Admin_Controller {

    protected $form = array(
        'nama' => array(
            'label' => 'Nama',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'alamat' => array(
            'label' => 'Alamat',
            'rules' => 'trim|required|max_length[255]',
            'helper' => 'form_inputlabel'
        ),
        'kode_pos' => array(
            'label' => 'Kode Pos',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'kota' => array(
            'label' => 'Kota',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'telepon' => array(
            'label' => 'Telepon',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'no_pabk' => array(
            'label' => 'Nomor PABK',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->model('supplier_model');
        if ($this->input->post('cancel-button'))
            redirect('master/supplier/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->supplier_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/supplier-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama, alamat, telepon, kode_pos, kota", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_supplier')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/supplier/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/supplier/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit supplier';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input supplier';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $supplierForm = $this->form;

        if ($id > 0) {
            $rowsupplier = $this->supplier_model->get_by_id((int) $id);
            $supplierForm['nama']['value'] = $rowsupplier->nama;
            $supplierForm['alamat']['value'] = $rowsupplier->alamat;
            $supplierForm['telepon']['value'] = $rowsupplier->telepon;
            $supplierForm['kode_pos']['value'] = $rowsupplier->kode_pos;
            $supplierForm['kota']['value'] = $rowsupplier->kota;
            $supplierForm['no_pabk']['value'] = $rowsupplier->no_pabk;
        }

        $this->form_validation->init($supplierForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->supplier_model->update($id, $data);
                $this->template->set_flashdata('success', 'supplier  berhasil diupdate ');
            } else {
                $id = $this->supplier_model->insert($data);
                $this->template->set_flashdata('success', 'supplier  ditambah');
            }

            redirect('master/supplier');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->supplier_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'supplier  berhasil dihapus ');
        redirect('master/supplier');
    }
}