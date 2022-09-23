<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan extends Admin_Controller {


    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('encryption');
        $this->load->language('welcome');
		if ($this->input->post('cancel-button'))
            redirect('reservasi/index');
    }

    public function index()
    {
        $tglAwal = date('d/m/Y');
        $tglAkhir = date('d/m/Y');
        $tglAwalParam = date('Y-m-d');
        $tglAkhirParam = date('Y-m-d');
        if($this->input->post('tanggal_awal')){
            $tglAwal = $this->input->post('tanggal_awal');
            $arrTglAwal =  explode('/',$this->input->post('tanggal_awal'));
            $tglAwalParam = $arrTglAwal[2].'-'.$arrTglAwal[1].'-'.$arrTglAwal[0];
        }
        if($this->input->post('tanggal_akhir')){
            $tglAkhir = $this->input->post('tanggal_akhir');
            $arrTglAkhir =  explode('/',$this->input->post('tanggal_akhir'));
            $tglAkhirParam = $arrTglAkhir[2].'-'.$arrTglAkhir[1].'-'.$arrTglAkhir[0];
        }

        $tipePasien = '';
        $addStrParams = '';
        if($this->input->post('tipe_pasien')){
            $addStrParams = " AND tipe_pasien  = '".$this->input->post('tipe_pasien')."' ";
            $tipePasien = $this->input->post('tipe_pasien');
        }

        $rows = $this->db->query("SELECT poli_nama, dokter_nama, COUNT(id) AS jumlah  
                                    FROM pdf_reservasi 
                                    WHERE tanggal_kunjungan >= '".$tglAwalParam."' AND tanggal_kunjungan <= '".$tglAkhirParam."' $addStrParams
                                    GROUP BY poli_nama, dokter_nama 
                                    ORDER BY poli_nama, dokter_nama ASC")
                            ->result();
        $this->data['rows'] = $rows;
        $this->data['tglAwal'] = $tglAwal;
        $this->data['tglAkhir'] = $tglAkhir;
        $this->data['tipePasien'] = $tipePasien;
        $this->template
            ->set_title('Laporan Jumlah Pasien Reservasi')
            ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
            ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
            ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
            ->set_layout('pendaftaran')
            ->build('reservasi/laporan', $this->data);
    }
}