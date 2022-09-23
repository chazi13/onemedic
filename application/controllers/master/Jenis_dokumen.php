<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_dokumen extends Admin_Controller {

    protected $form = array(
        // 'kode' => array(
        //     'label' => 'Kode',
        //     'rules' => 'trim|required|max_length[50]|callback_unique_kode',
        //     'helper' => 'form_inputlabel'
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
        $this->load->model('jenis_dokumen_model');
        if ($this->input->post('cancel-button'))
            redirect('master/jenis_dokumen/index');
    }

    function index() {
        $this->template
                ->set_title('Jenis Dokumen')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_layout('master')
                ->build('master/jenis_dokumen-list');
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['mst_jenis_dokumen.status'] = 1;
        $this->datatables
                ->select("id, nama", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_jenis_dokumen')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                            <a data-toggle="tooltip" title="Edit Data" href="' . site_url('master/jenis_dokumen/edit') . '/$1"><i class="icon-file-text2 text-success"></i></a> &nbsp;&nbsp;&nbsp;
                            <!-- a data-toggle="tooltip" title="Hapus Data" data-button="delete" href="' . site_url('master/jenis_dokumen/delete') . '/$1"><i class="icon-cancel-square text-danger"></i></a -->
                        </div>
                      </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function add() {
        $this->data['title'] = 'Input Jenis Dokumen';
        $this->_updatedata();
    }

    function edit($id) {
        $this->data['title'] = 'Edit Jenis Dokumen';
        $this->_updatedata($id);
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $form = $this->form;

        if ($id > 0) {
            // $form['kode']['rules'] = "trim|required|max_length[50]|callback_unique_kode[$id]";
            
            $row = $this->jenis_dokumen_model->get_by_id((int) $id);
            $form['nama']['value'] = $row->nama;
        }

        $this->form_validation->init($form);
        if ($this->form_validation->run()) {
            $data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->jenis_dokumen_model->update($id, $data);
                $this->template->set_flashdata('success', 'Jenis Dokumen berhasil diupdate.');
            } else {
                $jnBid = $this->jenis_dokumen_model->insert($data);
                $this->template->set_flashdata('success', 'Jenis Dokumen berhasil ditambahkan.');
            }

            redirect('master/jenis_dokumen');
        }

        $this->data['id'] = $id;
        $this->data['form'] = $this->form_validation;
        $this->template
            ->set_title('Form Jenis Dokumen')
            ->set_layout('master')
            ->build('form',$this->data);
    }

    function delete($id) {
        $row = $this->jenis_dokumen_model->get_by_id((int) $id);
        if($row){
            $this->jenis_dokumen_model->update($id, array('status' => 0));
            $this->template->set_flashdata('success', 'Jenis Dokumen berhasil dihapus');
        }else{
            $this->template->set_flashdata('warning', 'Jenis Dokumen tidak ditemukan. ');
        }
        redirect('master/jenis_dokumen');
    }

    function unique_kode($value, $id = 0) {
        if ($this->jenis_dokumen_model->is_kode_unique($value, $id))
            return TRUE;
        else {
            $this->form_validation->set_message('unique_kode', 'Kode sudah tercatat');
            return FALSE;
        }
    }

}
