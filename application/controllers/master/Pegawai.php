<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pegawai extends Admin_Controller {

    protected $form = array(
        'jabatan_id' => array(
            'label' => 'Jabatan Struktural',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel',
        ),
        'jabatan_medis_fungsional_id' => array(
            'label' => 'Jabatan Medis Fungsional',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel',
        ),
		'nip' => array(
            'label' => 'NIP',
            'rules' => 'trim|required|max_length[50]',
            'helper' => 'form_inputlabel'
        ),
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
        'jenis_kelamin' => array(
            'label' => 'Jenis Kelamin',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'tempat_lahir' => array(
            'label' => 'Tempat Lahir',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'tanggal_lahir_show' => array(
            'label' => 'Tanggal Lahir',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
         'agama' => array(
            'label' => 'Agama',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),

        'status_perkawinan' => array(
            'label' => 'Status Kawin',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel',
        ),
         'kabupaten_kota' => array(
            'label' => 'Kabupaten/Kota',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'telepon' => array(
            'label' => 'Telepon',
            'rules' => 'trim|required|max_length[50]',
            'helper' => 'form_inputlabel'
        ),
        'tanggal_lahir' => array(
            'helper' => 'form_hidden'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->library('utility');
        $this->load->model('pegawai_model');
        $this->load->model('jabatan_model');
        $this->load->model('jabatan_medis_fungsional_model');
        $this->load->model('unit_medis_fungsional_model');
        if ($this->input->post('cancel-button'))
            redirect('master/pegawai/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->pegawai_model->get_all_by_params($params);
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/pegawai-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['status'] = 1;
        $this->datatables
                ->select("id, nip, nama, alamat, telepon", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_pegawai')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/pegawai/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/pegawai/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit pegawai';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input pegawai';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $pegawaiForm = $this->form;
        $optionsJabatan = $this->jabatan_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');
        $pegawaiForm['jabatan_id']['options'] = $optionsJabatan;
        $optionsFungsional = $this->jabatan_medis_fungsional_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');
        $pegawaiForm['jabatan_medis_fungsional_id']['options'] = $optionsFungsional;
		
        $pegawaiForm['agama']['options'] = $this->config->item('agama');
        $pegawaiForm['status_perkawinan']['options'] = $this->config->item('status_pernikahan');
        $pegawaiForm['jenis_kelamin']['options'] = $this->config->item('jenis_kelamin');

        if ($id > 0) {
            $rowPegawai = $this->pegawai_model->get_by_id((int) $id);
            $pegawaiForm['nip']['value'] = $rowPegawai->nip;
            $pegawaiForm['nama']['value'] = $rowPegawai->nama;
            $pegawaiForm['tempat_lahir']['value'] = $rowPegawai->tempat_lahir;
            $pegawaiForm['tanggal_lahir_show']['value'] = $this->utility->mysql_to_tanggal($rowPegawai->tanggal_lahir);
            $pegawaiForm['tanggal_lahir']['value'] = $rowPegawai->tanggal_lahir;
            $pegawaiForm['agama']['value'] = $rowPegawai->agama;
            $pegawaiForm['jenis_kelamin']['value'] = $rowPegawai->jenis_kelamin;
            $pegawaiForm['status_perkawinan']['value'] = $rowPegawai->status_perkawinan;
            $pegawaiForm['alamat']['value'] = $rowPegawai->alamat;
            $pegawaiForm['kabupaten_kota']['value'] = $rowPegawai->kabupaten_kota;
            $pegawaiForm['telepon']['value'] = $rowPegawai->telepon;
            $pegawaiForm['jabatan_id']['value'] = $rowPegawai->jabatan_id;
            $pegawaiForm['jabatan_medis_fungsional_id']['value'] = $rowPegawai->jabatan_medis_fungsional_id;
        }

        $this->form_validation->init($pegawaiForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->pegawai_model->update($id, $data);
                $this->template->set_flashdata('success', 'pegawai  berhasil diupdate ');
            } else {
                $id = $this->pegawai_model->insert($data);
                $this->template->set_flashdata('success', 'pegawai  ditambah');
            }

            redirect('master/pegawai');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->pegawai_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'pegawai  berhasil dihapus ');
        redirect('master/pegawai');
    }
}