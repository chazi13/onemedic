<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Farmasi extends Admin_Controller {

    protected $form = array(
        'kategori_farmasi_id' => array(
            'label' => 'Kategori',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'produsen_id' => array(
            'label' => 'Produsen/Pinsiple',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'nama' => array(
            'label' => 'Nama',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'satuan_id' => array(
            'label' => 'Satuan (satuan jual)',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'is_formularium' => array(
            'label' => 'Formularium',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'kelompok_farmasi_id' => array(
            'label' => 'Kelompok Farmasi',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'jenis_farmasi_id' => array(
            'label' => 'Generik / Paten',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'farmakologi_id' => array(
            'label' => 'Farmakologi',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'bentuk_sedian_farmasi_id' => array(
            'label' => 'Bentuk Sediaan',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'zat_aktif_farmasi_id' => array(
            'label' => 'Zat Aktif',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        
        'harga_dasar' => array(
            'label' => 'Harga Dasar',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'hna' => array(
            'label' => 'Harga Dasar + Ppn',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'status' => array(
            'label' => 'Actiive / Non Active',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->model('bentuk_sediaan_model');
        $this->load->model('zat_aktif_model');
        $this->load->model('farmakologi_model');
        $this->load->model('produsen_model');
        $this->load->model('kategori_farmasi_model');
        $this->load->model('jenis_farmasi_model');
        $this->load->model('kelompok_farmasi_model');
        $this->load->model('farmasi_model');
        $this->load->model('satuan_model');
        if ($this->input->post('cancel-button'))
            redirect('master/farmasi/index');
    }

	function index() {
        $params['status'] = 1;
        $this->data['rowsData'] = $this->farmasi_model->get_all_by_params($params);
        $this->template
                ->set_title('Master Farmasi')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/farmasi-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params = array();
        $this->datatables
                ->select("mst_farmasi.id, mst_farmasi.nama, mst_farmasi.harga_dasar, mst_farmasi.hna, mst_farmasi.status, mst_satuan.nama AS satuan", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_farmasi')
                ->join('mst_satuan', 'mst_satuan.id = mst_farmasi.satuan_id','LEFT')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/farmasi/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/farmasi/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                    </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['title'] = 'Edit farmasi';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['title'] = 'Input farmasi';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $farmasiForm = $this->form;
        $farmasiForm['kategori_farmasi_id']['options'] = $this->kategori_farmasi_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');
        $farmasiForm['produsen_id']['options'] = $this->produsen_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');
        $farmasiForm['satuan_id']['options'] = $this->satuan_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');
        $farmasiForm['is_formularium']['options'] = array('1' => 'YA', '0' => 'TIDAK');
        $farmasiForm['kelompok_farmasi_id']['options'] = $this->kelompok_farmasi_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');
        $farmasiForm['jenis_farmasi_id']['options'] = $this->jenis_farmasi_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');
        $farmasiForm['farmakologi_id']['options'] = $this->farmakologi_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');
        $farmasiForm['bentuk_sedian_farmasi_id']['options'] = $this->bentuk_sediaan_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');
        $farmasiForm['zat_aktif_farmasi_id']['options'] = $this->zat_aktif_model->get_dropdown_array('nama', 'id', 'status', '1', 'nama', 'ASC');
        $farmasiForm['status']['options'] = array('1' => 'AKTIF', '0' => 'TIDAK AKTIF');

        if ($id > 0) {
            $rowfarmasi = $this->farmasi_model->get_by_id((int) $id);
            $farmasiForm['nama']['value'] = $rowfarmasi->nama;
        }

        $this->form_validation->init($farmasiForm);
        if ($this->form_validation->run()) {
			$data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->farmasi_model->update($id, $data);
                $this->template->set_flashdata('success', 'farmasi  berhasil diupdate ');
            } else {
                $id = $this->farmasi_model->insert($data);
                $this->template->set_flashdata('success', 'farmasi  ditambah');
            }

            redirect('master/farmasi');
        }
        $this->data['form'] = $this->form_validation;
        $this->template
                ->build('form', $this->data);
    }

    function delete($id) {
        $this->farmasi_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'farmasi  berhasil dihapus ');
        redirect('master/farmasi');
    }
}