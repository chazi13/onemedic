<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Izin_dokter extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('reservasi_izin_dokter_model');
        $this->load->model('reservasi_jadwal_dokter_model');
    }

    function index() {
        $rowsDokter = $this->data['rowsDokter'] = $this->reservasi_jadwal_dokter_model->get_all_by_params(array());
        $this->data['rowsDokter'] = $rowsDokter;
            
        if($this->input->post()){
            $dokterId = $this->input->post('dokter_id');
            $dokter = $this->reservasi_jadwal_dokter_model->get_by_params(array('dokter_id' => $dokterId));
            !empty($dokter) ? $dokterNama = $dokter->dokter_nama : $dokterNama = '';
            
            $tglMulaiTmp = $this->input->post('tgl_mulai_izin');
            $tglAkhirTmp = $this->input->post('tgl_akhir_izin');
            $srrTglMulai = explode('-',$tglMulaiTmp);
            $srrTglAkhir = explode('-',$tglAkhirTmp);
            $data['dokter_id'] = $this->input->post('dokter_id');
            $data['dokter_nama'] = $dokterNama;
            $data['tgl_mulai_izin'] = $srrTglMulai[2].'-'.$srrTglMulai[1].'-'.$srrTglMulai[0];
            $data['tgl_akhir_izin'] = $srrTglAkhir[2].'-'.$srrTglAkhir[1].'-'.$srrTglAkhir[0];
            $this->reservasi_izin_dokter_model->insert($data);
            $this->template->set_flashdata('success', 'Izin/Cuti Dokter berhasil disimpan ');
            redirect('reservasi/izin_dokter');
        }
        $this->data['rowsDokterIzin'] = $this->reservasi_izin_dokter_model->get_all_by_params(array('status' => 1));
        $this->template
                ->set_title('Izin Dokter')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('pendaftaran')
                ->build('reservasi/izin_dokter', $this->data);
    }
    function delete($id){
        $row = $this->reservasi_izin_dokter_model->get_by_id($id);
        if($row->status == 1){
            $this->reservasi_izin_dokter_model->update($id, array('status' => 0));
            $this->template->set_flashdata('success', 'Izin/Cuti Dokter berhasil dihapus ');
            redirect('reservasi/izin_dokter');
        }else{
            redirect('reservasi/izin_dokter');
        }
    }

}
