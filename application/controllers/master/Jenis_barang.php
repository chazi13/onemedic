<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_barang extends Admin_Controller {

    protected $form = array(
        'parent_id' => array(
            'label' => 'Parent',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'kode' => array(
            'label' => 'Kode',
            'rules' => 'trim|required|max_length[50]|callback_unique_kode',
            'helper' => 'form_inputlabel'
        ),
        'nama' => array(
            'label' => 'Nama',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'nilai_penyusutan_per_tahun' => array(
            'label' => 'Nilai Penyusutan per Tahun (%)',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->model('jenis_barang_model');
        if ($this->input->post('cancel-button'))
            redirect('master/jenis_barang/index');
    }

    function index() {
        $this->template
                ->set_title('Jenis Barang')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_layout('master')
                ->build('master/jenis-barang-list');
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['mst_jenis_barang.status'] = 1;
        $this->datatables
                ->select("mst_jenis_barang.id, 
                   mst_jenis_barang.kode, 
                   mst_jenis_barang.nama, mst_jenis_barang.nilai_penyusutan_per_tahun", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_jenis_barang')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                            <a data-toggle="tooltip" title="Edit Data" href="' . site_url('master/jenis_barang/edit') . '/$1"><i class="icon-file-text2 text-success"></i></a> &nbsp;&nbsp;&nbsp;
                            <!-- a data-toggle="tooltip" title="Hapus Data" data-button="delete" href="' . site_url('master/jenis_barang/delete') . '/$1"><i class="icon-cancel-square text-danger"></i></a -->
                        </div>
                      </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function add() {
        $this->data['title'] = 'Input Golongan Barang';
        $this->_updatedata();
    }

    function edit($id) {
        $this->data['title'] = 'Input Golongan Barang';
        $this->_updatedata($id);
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $form = $this->form;
        $optionsRoot = $this->jenis_barang_model->drop_options_root();
//        $optionsParent = array_merge(array('0' => 'root'),$optionsRoot) ;
        $form['parent_id']['options'] = $optionsRoot;

        if ($id > 0) {
            $form['kode']['rules'] = "trim|required|max_length[50]|callback_unique_kode[$id]";
            
            $rowJenisBarang = $this->jenis_barang_model->get_by_id((int) $id);
            $form['nilai_penyusutan_per_tahun']['value'] = $rowJenisBarang->nilai_penyusutan_per_tahun;
            $form['parent_id']['value'] = $rowJenisBarang->parent_id;
            $form['kode']['value'] = $rowJenisBarang->kode;
            $form['nama']['value'] = $rowJenisBarang->nama;
        }

        $this->form_validation->init($form);
        if ($this->form_validation->run()) {
            $data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->jenis_barang_model->update($id, $data);
                $this->template->set_flashdata('success', 'Golongan barang berhasil diupdate ');
            } else {
                $jnBid = $this->jenis_barang_model->insert($data);
                $this->template->set_flashdata('success', 'Golongan barang berhasil ditambahkan');
            }

            redirect('master/jenis_barang');
        }

        $this->data['id'] = $id;
        $this->data['form'] = $this->form_validation;
        $this->template
                ->set_title('Jenis Barang')
                ->set_layout('master')
                ->build('form',$this->data);
    }

    function delete($id) {
        $this->jenis_barang_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Golongan barang berhasil dihapus');
        redirect('master/jenis_barang');
    }
    
    function unique_kode($value, $id = 0) {
        if ($this->jenis_barang_model->is_kode_unique($value, $id))
            return TRUE;
        else {
            $this->form_validation->set_message('unique_kode', 'Kode sudah tercatat');
            return FALSE;
        }
    }

}
