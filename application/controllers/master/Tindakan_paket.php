<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tindakan_paket extends Admin_Controller {

    protected $form = array(
        'nama' => array(
            'label' => 'Nama Paket',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel',
        ),
        'tarif' => array(
            'label' => 'Tarif/Harga',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel',
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->model('tindakan_model');
        $this->load->model('tindakan_paket_model');
        $this->load->model('tindakan_paket_item_model');
        if ($this->input->post('cancel-button'))
            redirect('master/tindakan_paket/index');
    }

    function index() {
        $this->data['paket'] = $this->tindakan_paket_model->get_all_by_params(array('status' => 1));
        $this->template
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->build('master/tindakan_paket-list', $this->data);
    }
	
    function datatables_sourcedata() {
        $this->load->library('datatables');
        $this->datatables
                ->select("id, nama, tarif", FALSE)
                ->from('mst_tindakan_paket')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="text-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/tindakan_paket/edit') . '/$1" style="margin-left: 5px;"><i class="icon-pencil5"></i></a>
                          <a class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/tindakan_paket/delete') . '/$1" style="margin-left: 5px;"><i class="icon-trash"></i></a>
                        </div>
                      </div>
        ', 'id');
        echo $this->datatables->generate();
    }

    function edit($id)
    {
        $this->data['form_title'] = 'Edit Tindakan Paket';
        $this->_updatedata($id);
    }

    function add()
    {
        $this->data['form_title'] = 'Input Tindakan Paket';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');
        $form = $this->form;
        $insertedTindakan = $this->tindakan_paket_item_model->get_all_by_params(array('tindakan_paket_id' => $id));
        if ($id > 0) {
            $row = $this->tindakan_paket_model->get_by_id((int) $id);
            $form['nama']['value'] = $row->nama;
            $form['tarif']['value'] = $row->tarif;
        }

        $this->form_validation->init($form);
        if ($this->form_validation->run()) {
            $data = $this->form_validation->get_values();
            if ($id > 0) {
                $this->tindakan_paket_model->update($id, $data);
                $this->template->set_flashdata('success', 'Tindakan Paket berhasil diupdate ');
            } else {
                $id = $this->tindakan_paket_model->insert($data);
                $this->template->set_flashdata('success', 'Tindakan Paket berhasil ditambahkan ');
            }
            $this->_update_item($id);
            
            redirect('master/tindakan_paket');
        }

        $this->data['insertedTindakan'] = $insertedTindakan;
        $this->data['form'] = $this->form_validation;
        $this->template
                ->set_js('plugins/extensions/jquery_ui/full.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->build('master/tindakan_paket-form', $this->data);
    }
    
    function _update_item($paketId){
        $this->db->update('mst_tindakan_paket_item', array('status' => 0), "tindakan_paket_id = ".$paketId);
        $arrDataIdPost = $this->input->post('tindakan_id');
        $arrDataNamaPost = $this->input->post('tindakan_nama');
        $arrDataBanyaknyaPost = $this->input->post('banyaknya');
        $arrData = array();
        foreach ($arrDataNamaPost as $key => $val){
            if(!empty($val)){
                $tindakanId = $arrDataIdPost[$key];
                $rowTindakan = $this->tindakan_model->get_by_id($tindakanId); 
                $data['tindakan_paket_id'] = $paketId;
                $data['tindakan_id'] = $tindakanId;
                $data['tindakan_kode'] = $rowTindakan->kode;
                $data['tindakan_nama'] = $rowTindakan->nama;
                $data['banyaknya'] = $arrDataBanyaknyaPost[$key];
                $this->tindakan_paket_item_model->insert($data);
            }
        }    
    }
    
    function delete($id) {
        $this->tindakan_paket_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'perusahaan berhasil dihapus ');
        redirect('master/tindakan_paket');
    }

}