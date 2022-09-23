<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jabatan_medis_fungsional extends Admin_Controller {

    protected $form = array(
        'kategori_jabatan_medis' => array(
            'label' => 'Kategori Jabatan Medis',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
		// 'unit_medis_fungsional_id' => array(
        //     'label' => 'Unit Medis Fungsional',
        //     'rules' => 'trim|required',
        //     'helper' => 'form_dropdownlabel',
        // ),
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
        $this->load->model('jabatan_medis_fungsional_model');
        if ($this->input->post('cancel-button'))
            redirect('master/jabatan_medis_fungsional/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->jabatan_medis_fungsional_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/jabatan_medis_fungsional-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nama, kategori_jabatan_medis", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_jabatan_medis_fungsional')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/jabatan_medis_fungsional/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/jabatan_medis_fungsional/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit jabatan_medis_fungsional';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input jabatan_medis_fungsional';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $jabatanMedisFungsionalForm = $this->form;
        $jabatanMedisFungsionalForm['kategori_jabatan_medis']['options'] = $this->config->item('kategori_jabatan_medis');
		// $optionsFungsional = $this->unit_medis_fungsional_model->drop_options();
        // $jabatanMedisFungsionalForm['unit_medis_fungsional_id']['options'] = $optionsFungsional;

        if ($id > 0) {
            $rowJabatanMedisFungsional = $this->jabatan_medis_fungsional_model->get_by_id((int) $id);
            $jabatanMedisFungsionalForm['nama']['rules'] = "trim|required|max_length[150]";
            $jabatanMedisFungsionalForm['nama']['value'] = $rowJabatanMedisFungsional->nama;
            $jabatanMedisFungsionalForm['kategori_jabatan_medis']['rules'] = "trim|required";
            $jabatanMedisFungsionalForm['kategori_jabatan_medis']['value'] = $rowJabatanMedisFungsional->kategori_jabatan_medis;
			// $jabatanMedisFungsionalForm['unit_medis_fungsional_id']['rules'] = "trim|required";
            // $jabatanMedisFungsionalForm['unit_medis_fungsional_id']['value'] = $rowJabatanMedisFungsional->unit_medis_fungsional_id;
        }

        $this->form_validation->init($jabatanMedisFungsionalForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->jabatan_medis_fungsional_model->update($id, $data);
                $this->template->set_flashdata('success', 'jabatan_medis_fungsional  berhasil diupdate ');
            } else {
                $id = $this->jabatan_medis_fungsional_model->insert($data);
                $this->template->set_flashdata('success', 'jabatan_medis_fungsional  ditambah');
            }

            redirect('master/jabatan_medis_fungsional');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->jabatan_medis_fungsional_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'jabatan_medis_fungsional  berhasil dihapus ');
        redirect('master/jabatan_medis_fungsional');
    }
}