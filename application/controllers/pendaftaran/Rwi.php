<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rwi extends Admin_Controller {

    protected $form = array(
        'pasien_id' => array(
            'helper' => 'form_hidden'
        ),
        'pendaftaran_rwj_id' => array(
            'helper' => 'form_hidden'
        ),

        // Kontak atau penanggungjawab
        'kontak_nama' => array(
            'label' => 'Nama',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'kontak_alamat' => array(
            'label' => 'Alamat',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'kontak_telepon' => array(
            'label' => 'Telepon',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'kontak_kota' => array(
            'label' => 'Kota',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'kontak_jenis_identitas' => array(
            'label' => 'Jenis Identitas',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'kontak_no_identitas' => array(
            'label' => 'Nomor Identitas',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        
        // tempat perawatan
        'ruangan_id' => array(
            'label' => 'Ruangan',
            'rules' => 'required|trim',
            'helper' => 'form_dropdownlabel'
        ),
        'kamar_id' => array(
            'label' => 'Kamar',
            'rules' => 'required|trim',
            'helper' => 'form_dropdownlabel'
        ),
        'bed_id' => array(
            'label' => 'Bed',
            'rules' => 'required|trim',
            'helper' => 'form_dropdownlabel'
        ),
        'tanggal_masuk' => array(
            'label' => 'Tgl. Masuk',
            'rules' => 'trim',
            'helper' => 'form_inputlabel',
            'extra' => array('autocomplete' => 'off')
        ),
        'jam_masuk' => array(
            'label' => 'Jam Masuk',
            'rules' => 'trim',
            'helper' => 'form_inputlabel',
            'extra' => array('autocomplete' => 'off')
        ),
        'dokter_dpjp_id' => array(
            'label' => 'Dokter DPJP',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),




        'asuransi_id' => array(
            'label' => 'Nama Penjamin',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'no_kartu' => array(
            'label' => 'Nomor Kartu',
            'rules' => 'trim',
            'helper' => 'form_inputlabel',
            'extra' => array('autocomplete' => 'off')
        ),
        'penanggung_id' => array(
            'label' => 'Penanggung',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->model('pasien_model');
        $this->load->model('pegawai_model');
        $this->load->model('perusahaan_model');
        $this->load->model('ruangan_model');
        $this->load->model('kamar_model');
        $this->load->model('bed_model');
        $this->load->model('asuransi_model');
        $this->load->model('penanggung_model');
        $this->load->model('pendaftaran_model');
        $this->load->model('pendaftaran_rawat_inap_model');
        $this->load->model('pasien_rwi_akomodasi_model');
        if ($this->input->post('cancel-button'))
            redirect('pendaftaran/rwi');
    }

    function index(){
        $params = array('status_layanan' => 2); // arrnya harus diisi dari status akhir pasien dari rj
        $this->data['rows'] = $this->pendaftaran_model->get_all_by_params($params);
        $this->template
                ->set_title('Pendaftaran Pasien Rawat Inap')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('pendaftaran')
                ->build('pendaftaran/rwi', $this->data);
    }

    function add($regID = 0) {
        $pendaftaran = $this->pendaftaran_model->get_by_id($regID);
        $pasien = $this->pasien_model->get_by_params(array('no_mr' => $pendaftaran->no_mr));
        $this->load->library('form_validation');
        $form = $this->form;
        // SET DEFAULT VALUE OF FORM
        $form['id']['value'] = '';
        $form['pendaftaran_rwj_id']['value'] = $pendaftaran->id;
        $form['asuransi_id']['options'] = $this->asuransi_model->get_dropdown_array('nama', 'id');
        $form['ruangan_id']['options'] = $this->ruangan_model->get_dropdown_array('nama', 'id');
        $form['dokter_dpjp_id']['options'] = $this->pegawai_model->dokter_drop_options();
        $form['penanggung_id']['options'] = $this->penanggung_model->get_dropdown_array('nama', 'id');
        $form['kontak_jenis_identitas']['options'] = $this->config->item('jenis_identitas');

        $this->form_validation->init($form);
        
        if ($this->form_validation->run()) {
            $pendaftaranRWI    = $this->_do_insert_pendaftaran($pendaftaran);
            redirect('pendaftaran/rwi/view/'.$pendaftaranRWI->id);
        }

        $this->data['pasien'] = $pasien;
        $this->data['form'] = $this->form_validation;
        $this->template
                ->set_js('jquery.mask')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('pendaftaran')
                ->build('pendaftaran/rwi-form', $this->data);
    }
    
    function _do_insert_pendaftaran($pendaftaran){
        $this->load->library('form_validation');
        $form = $this->form;
        
        $this->form_validation->init($form);
        if ($this->form_validation->run()) {
            
            $data = $this->form_validation->get_values();
            $data['pendaftaran_rwj_id'] = $pendaftaran->id;
            $data['no_reg'] = $pendaftaran->no_reg;
            $data['no_mr'] = $pendaftaran->no_mr;
            $data['nama_awalan'] = $pendaftaran->nama_awalan;
            $data['nama'] = $pendaftaran->nama;
            $data['alamat'] = $pendaftaran->alamat;
            $data['alamat_daerah'] = $pendaftaran->alamat_daerah;
            $data['umur_tahun'] = $pendaftaran->umur_tahun;
            $data['umur_bulan'] = $pendaftaran->umur_bulan;
            $data['umur_hari'] = $pendaftaran->umur_hari;
            $data['jenis_identitas'] = $pendaftaran->jenis_identitas;
            $data['no_identitas'] = $pendaftaran->no_identitas;
            $data['poli_id_asal'] = $pendaftaran->poli_id;
            $data['poli_nama_asal'] = $pendaftaran->poli_nama;
                
            if(!empty($data['penanggung_id'])){
                $penanggung = $this->penanggung_model->get_by_id($data['penanggung_id']);
                $data['penanggung_nama'] = !empty($penanggung) ? $penanggung->nama : '-';
            }
            if(!empty($data['dokter_dpjp_id'])){
                $dokterDPJP = $this->pegawai_model->get_by_id($data['dokter_dpjp_id']);
                $data['dokter_dpjp_nama'] = !empty($dokterDPJP) ? $dokterDPJP->nama : '-';
            }
            if(!empty($data['ruangan_id'])){
                $ruangan = $this->ruangan_model->get_by_id($data['ruangan_id']);
                $data['ruangan_nama'] = $ruangan->nama;
            }
            if(!empty($data['kamar_id'])){
                $kamar = $this->kamar_model->get_by_id($data['kamar_id']);
                $data['kamar_nama'] = $kamar->nama;
            }
            if(!empty($data['bed_id'])){
                $bed = $this->bed_model->get_by_id($data['bed_id']);
                $data['bed_nama'] = !empty($bed) ? $bed->nama : '-';
            }
            
            if(!empty($data['asuransi_id'])){
                $asuransi = $this->asuransi_model->get_by_id($data['asuransi_id']);
                $data['asuransi_nama'] = $asuransi->nama;
            }
        
            $id = $this->pendaftaran_rawat_inap_model->insert(array_filter($data));

            $dataAkomodasi['pendaftaran_rawat_inap_id'] = $id;
            $dataAkomodasi['tanggal_check_in'] = $data['tanggal_masuk'];
            $dataAkomodasi['jam_check_in'] = $data['jam_masuk'];
            $dataAkomodasi['ruangan_id'] = $data['ruangan_id'];
            $dataAkomodasi['ruangan_nama'] = $data['ruangan_nama'];
            $dataAkomodasi['kamar_id'] = $data['kamar_id'];
            $dataAkomodasi['kamar_nama'] = $data['kamar_nama'];
            $dataAkomodasi['bed_id'] = $data['bed_id'];
            $dataAkomodasi['bed_nama'] = $data['bed_nama'];
            $this->pasien_rwi_akomodasi_model->insert($dataAkomodasi);

            $this->pendaftaran_model->update($pendaftaran->id, array('status_layanan' => 3 )); // status layanan dalam perawatan

            $result = $this->pendaftaran_rawat_inap_model->get_by_id($id);

            return $result;
        }
    }

    function view($id){
        $pendaftaranRWI = $this->pendaftaran_rawat_inap_model->get_by_id($id);
        $this->data['pendaftaranRWI'] = $pendaftaranRWI;
        $this->data['pasien'] = $this->pasien_model->get_by_params(array('no_mr' => $pendaftaranRWI->no_mr));
        $this->template
        ->set_layout('pendaftaran')
        ->build('pendaftaran/rwi-surat_pengantar', $this->data);
    }
    
    function get_kamar(){
        $ruanganId = $this->input->post('ruangan_id');
        $rows = $this->kamar_model->get_all_by_params(array('ruangan_id' => $ruanganId));
        $arrKamar = array();
        $arrKamar[''] = '(Kosong)';
        if($rows){
            foreach ($rows as $row){
                $arrKamar['"'.$row->id.'"'] = $row->nama;
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($arrKamar,true);
    }
    
    function get_bed(){
        $kamarId = $this->input->post('kamar_id');
        $rows = $this->bed_model->get_all_by_params(array('kamar_id' => $kamarId));
        $arrBed = array();
        $arrBed[''] = '(Kosong)';
        if($rows){
            foreach ($rows as $row){
                $arrBed['"'.$row->id.'"'] = $row->nama;
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($arrBed,true);
    }
    
    
    function search_bpjs(){
        $params = $this->input->post('search_param');
        $this->_get_data_bpjs($params);
    }

    function _get_data_bpjs($params) {
        //Testing ID
        $consID = "1000";
        //$consSecret = "3987";
        $consSecret = "7789";

        // Computes the timestamp
        date_default_timezone_set('UTC');
        $timestamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', $consID . "&" . $timestamp, $consSecret, true);
        $encodedSignature = base64_encode($signature);
        //$encodedSignature = urlencode($encodedSignature);
        // Build Request
        $request = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/Peserta/peserta/'.$params);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($request, CURLOPT_HTTPHEADER, array(
            'Accept: application/json;charset=utf-8',
            'X-Cons-id: ' . $consID,
            'X-Timestamp: ' . $timestamp,
            'X-Signature: ' . $encodedSignature
        ));
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        // Send Request
        $result = curl_exec($request);
        
        
        $arrResult = json_decode($result, true);
        
        $arrPeserta =  $arrResult["response"];
        
        // check nomor kartu bpjs di tabel pasien
        $pasienId   = 0;
        $pasienNoMR = '0000000000';
        $arrResult = json_decode($result, true);

        if(is_array($arrResult['response']['peserta'])){
            $pasien = $this->db->select('id, no_mr')->get_where('mst_pasien', array('bpjs_no_peserta' => $arrResult['response']['peserta']['noKartu']))->row();
            if($pasien){
               $pasienId    = $pasien->id; 
               $pasienNoMR  = $pasien->no_mr; 
            }
        }
        $arrPeserta['pasien_id'] = $pasienId;
        $arrPeserta['pasien_no_mr'] = $pasienNoMR;
        header('Content-Type: application/json');
        echo json_encode($arrPeserta);
    }
}
