<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Asuransi extends Admin_Controller {

    protected $form = array(
        // 'kode' => array(
        //     'label' => 'Kode',
        //     'rules' => 'trim|required|max_length[3]|callback_unique_kode',
        //     'helper' => 'form_inputlabel'
        // ),
		'nama' => array(
            'label' => 'Nama',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'alamat' => array(
            'label' => 'Alamat',
            'rules' => 'trim|max_length[255]',
            'helper' => 'form_inputlabel'
        ),
        'telepon' => array(
            'label' => 'Telepon',
            'rules' => 'trim|max_length[50]',
            'helper' => 'form_inputlabel'
        ),
        'fax' => array(
            'label' => 'Fax',
            'rules' => 'trim|max_length[50]',
            'helper' => 'form_inputlabel'
        ),
        'email' => array(
            'label' => 'Email',
            'rules' => 'trim|max_length[50]',
            'helper' => 'form_inputlabel'
        ),
        'contact_person' => array(
            'label' => 'Contact Person',
            'rules' => 'trim|max_length[12]',
            'helper' => 'form_inputlabel'
        ),
        'contact_person_telepon' => array(
            'label' => 'Contact Person Telepon',
            'rules' => 'trim|max_length[12]',
            'helper' => 'form_inputlabel'
        ),
        'kabupaten_kota' => array(
            'label' => 'Kabupaten/Kota',
            'rules' => 'trim|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->model('asuransi_model');
        if ($this->input->post('cancel-button'))
            redirect('master/asuransi/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->asuransi_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/asuransi-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama, alamat, telepon, email, contact_person", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_asuransi')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/asuransi/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/asuransi/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit Asuransi';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input Asuransi';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $asuransiForm = $this->form;

        if ($id > 0) {
            $rowasuransi = $this->asuransi_model->get_by_id((int) $id);
            $asuransiForm['nama']['value'] = $rowasuransi->nama;
        }

        $this->form_validation->init($asuransiForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->asuransi_model->update($id, $data);
                $this->template->set_flashdata('success', 'Asuransi  berhasil diupdate ');
            } else {
                $id = $this->asuransi_model->insert($data);
                $this->template->set_flashdata('success', 'Asuransi berhasil ditambahkan');
            }

            redirect('master/asuransi');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->asuransi_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Asuransi  berhasil dihapus ');
        redirect('master/asuransi');
    }
}