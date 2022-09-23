<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lokasi_barang extends Admin_Controller {

    protected $form = array(
        'kode' => array(
            'label' => 'Kode',
            'rules' => 'trim|max_length[50]',
            'helper' => 'form_inputlabel'
        ),
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
        $this->load->model('lokasi_barang_model');
        if ($this->input->post('cancel-button'))
            redirect('master/lokasi_barang/index');
    }

    function index() {
        $this->template
                ->set_title('Lokasi Barang')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_layout('master')
                ->build('master/lokasi_barang-list');
    }
	
	function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['mst_lokasi_barang.status'] = 1;
        $this->datatables
                ->select("mst_lokasi_barang.id, 
                   mst_lokasi_barang.kode, mst_lokasi_barang.nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_lokasi_barang')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                        <a data-toggle="tooltip" title="Edit Registrasi" href="' . site_url('master/lokasi_barang/edit') . '/$1"><i class="icon-file-text2 text-success"></i></a> &nbsp;&nbsp;&nbsp;
                        <!-- a data-toggle="tooltip" title="Hapus Registrasi" data-button="delete" href="' . site_url('master/lokasi_barang/delete') . '/$1"><i class="icon-cancel-square text-danger"></i></a -->
                        </div>
                      </div>
        ', 'id');
        echo $this->datatables->generate();
    }
    
    function add()
    {
        $this->data['title'] = 'Input Lokasi Barang';
            $this->_updatedata();
    }

    function edit($id)
    {

        $this->data['title'] = 'Edit Lokasi Barang';
		 $this->_updatedata($id);
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $form = $this->form;

        if ($id > 0) {
            $row = $this->lokasi_barang_model->get_by_id((int) $id);
            $form['kode']['value'] = $row->kode;
            $form['nama']['value'] = $row->nama;
        }

        $this->form_validation->init($form);
        if ($this->form_validation->run()) {
            if ($id > 0) {
                $this->lokasi_barang_model->update($id, $this->form_validation->get_values());
                $this->template->set_flashdata('success', 'Lokasi Barang berhasil diupdate ');
            } else {
                $id = $this->lokasi_barang_model->insert($this->form_validation->get_values());
                $this->template->set_flashdata('success', 'Lokasi Barang berhasil ditambahkan ');
            }

            redirect('master/lokasi_barang');
        }

        $this->data['form'] = $this->form_validation;
        $this->template
                ->set_title('Lokasi Barang')
                ->set_layout('master')
                ->build('form', $this->data);
    }

    function delete($id) {
        $row = $this->lokasi_barang_model->get_by_id((int) $id);
        if($row){
            $this->lokasi_barang_model->update($id, array('status' => 0));
            $this->template->set_flashdata('success', 'Lokasi barang berhasil dihapus. ');
        }else{
            $this->template->set_flashdata('warning', 'Lokasi barang tidak ditemukan. ');
        }
        redirect('master/lokasi_barang');
    }

}