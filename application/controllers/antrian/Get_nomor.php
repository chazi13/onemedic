<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Get_nomor extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('reservasi_jadwal_dokter_model');
        $this->load->model('antrian_display_model');
    }

    function index() {
        $hariIni = date('Y-m-d');
        // $hariIni = '2021-07-19';
        // cek dulu import nomor antrian untuk hari ini apa sudah dilakukan? jika belum, import dulu.
        $cek = $this->db->get_where('antrian_import_reservasi', array('tanggal_import' => $hariIni))->row();
        if(empty($cek)){
            $this->db->query("INSERT INTO antrian_import_reservasi VALUES ('".$hariIni."' )");
            $this->db->query("INSERT INTO antrian_pendaftaran  SELECT tanggal_kunjungan, pdf_reservasi.no_antrian, '', pdf_reservasi.poli_id, pdf_reservasi.dokter_id, 0, '".date('Y-m-d H:i:s')."'  FROM pdf_reservasi  WHERE  pdf_reservasi.tanggal_kunjungan = '".$hariIni."' ");
        }
        $arrDay = array(
            'Monday' => '1',
            'Tuesday' => '2',
            'Wednesday' => '3',
            'Thursday' => '4',
            'Friday' => '5',
            'Saturday' => '6',
            'Sunday' => '7'
        );
		$tglBesok = date('Y-m-d', strtotime("+1 day"));
        $nameOfDay = date('l', strtotime(date('Y-m-d')));
        $noFieldHariIni =  $arrDay[$nameOfDay];
        $fieldHariIni = 'hari_'.$noFieldHariIni;

        $rowsPoli = $this->db->query("SELECT DISTINCT grup, poli_id, poli_nama, dokter_id, dokter_nama FROM antrian_grup_pendaftaran WHERE status = '1' ORDER BY poli_nama, dokter_nama ASC")->result();
        // $this->data['rowsDokter'] = $this->db->query("SELECT DISTINCT grup, pdf_reservasi_jadwal_dokter.poli_id, pdf_reservasi_jadwal_dokter.poli_nama, pdf_reservasi_jadwal_dokter.dokter_id, pdf_reservasi_jadwal_dokter.dokter_nama FROM pdf_reservasi_jadwal_dokter
        // JOIN antrian_grup_pendaftaran ON antrian_grup_pendaftaran.poli_id = pdf_reservasi_jadwal_dokter.poli_id
        // WHERE ".$fieldHariIni." IS NOT NULL ORDER BY poli_nama, dokter_nama ASC")->result();
        $this->data['rowsDokter'] = $this->db->query("SELECT DISTINCT poli_id, poli_nama, dokter_id, dokter_nama FROM pdf_reservasi_jadwal_dokter ORDER BY poli_nama, dokter_nama ASC")->result();
        
        $this->template
        ->set_layout('clean')
        ->set_js('libs/jquery-printElement/jquery.printElement')
        ->build('antrian/get_nomor-index', $this->data);
    }
    
    function create() {
        if($this->input->post()){
            $arrData  = array();
            // get kode poliklinik
            $poli = $this->db->select('kode')->get_where('antrian_kode_poli', array('poli_id' => $this->input->post('poli_id') ))->row();
            // get last nomor antrian
            $row = $this->db->select('MAX(no_antrian) AS max_nomor')->get_where('antrian_pendaftaran', array('tanggal_antrian' => date('Y-m-d'), 'dokter_id' => $this->input->post('dokter_id') ))->row();
            $maxNo = 0;
            $nextNo = 1;
            if($row){
                $maxNo = (int)$row->max_nomor;
                $nextNo = $maxNo+1;
            }
            $arrData['no_antrian']      = $nextNo;
            $arrData['grup']            = $this->input->post('grup');
            $arrData['dokter_id']       = $this->input->post('dokter_id');
            $arrData['poli_id']         = $this->input->post('poli_id');
            $arrData['status_panggil']  = 0;
            $arrData['tanggal_antrian'] = date('Y-m-d');
            $arrData['created_date']    = date('Y-m-d H:i:s');
            // do insert
            $this->db->insert('antrian_pendaftaran',$arrData);
        }
    }

}
