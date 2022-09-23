<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends Admin_Controller {

    protected $form = array(
        'reservasi_id' => array(
            'helper' => 'form_hidden'
        ),
        'alamat' => array(
            'label' => 'Alamat',
            'rules' => 'trim|required',
            'helper' => 'form_inputlabel'
        ),
        'telepon' => array(
            'label' => 'Telepon',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'provinsi_id' => array(
            'label' => 'Provinsi',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'kabupaten_id' => array(
            'label' => 'Kabupaten/Kota',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'kecamatan_id' => array(
            'label' => 'Kecamatan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'suku_bangsa' => array(
            'label' => 'Suku Bangsa',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'bahasa' => array(
            'label' => 'Bahasa',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'no_identitas' => array(
            'label' => 'Nomor KTP/SIM/KTA',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'email' => array(
            'label' => 'Email',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'poli' => array(
            'label' => 'Pelayanan/Poliklinik',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'dokter_id' => array(
            'label' => 'Dokter',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'rujukan' => array(
            'label' => 'Jenis Kunjungan ',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'rujukan_rs_id' => array(
            'label' => 'Unit Perujuk ',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'rujukan_dokter' => array(
            'label' => 'Nama Perujuk ',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'id_penanggung' => array(
            'label' => 'Penanggung ',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'nm_penanggung' => array(
            'label' => 'Nama Penanggung ',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'group_penjamin' => array(
            'label' => 'Group Penjamin ',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'id_penjamin' => array(
            'label' => 'Tipe Pasien',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'tipe' => array(
            'label' => 'Asuransi',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'keterangan' => array(
            'label' => 'Keterangan',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'nama_perusahaan' => array(
            'label' => 'Perusahaan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'nik' => array(
            'label' => 'NIK',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'posisi_dalam_perusahaan' => array(
            'label' => 'Posisi Dalam Perusahaan',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'no_asuransi' => array(
            'label' => 'No. Asuransi',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'no_peserta_jaminan' => array(
            'label' => 'No. Polis',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
    );

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('encryption');
        $this->load->language('welcome');
        $this->load->model('reservasi_model');
		if ($this->input->post('cancel-button'))
            redirect('reservasi');
    }

    public function index()
    {
        $params = array();
        $this->data['rows'] = $this->reservasi_model->get_all_by_params($params);
        $this->template
            ->set_title('Reservasi Pasien Hari Ini')
            ->set_layout('pendaftaran')
            ->build('reservasi/index', $this->data);
    }
    
    public function hari_ini()
    {
        $rows = $this->db->query("SELECT kode, no_mr, nama, poli_nama, dokter_nama, tipe_pasien FROM pdf_reservasi WHERE created_date::DATE = '".date('Y-m-d')."' AND status = 1 ORDER BY created_date DESC ")->result();

        $this->data['rows'] = $rows;
        $this->template
            ->set_css('theme-default/libs/wizard/wizard')
            ->set_css('theme-default/libs/select2/select2')
            ->set_js('libs/wizard/jquery.bootstrap.wizard.min')
            ->set_js('libs/select2/select2.min')
            ->set_layout('pendaftaran')
            ->build('reservasi/hari_ini', $this->data);
    }
    
    function konfirmasi($reservasiId=0){

        $this->load->library('form_validation');
        $reservasi = $this->db->query('SELECT * FROM pdf_reservasi WHERE id = '.$reservasiId)->row();
        if(empty($reservasi) || $reservasi->status == '2'){
            $this->template->set_flashdata('warning', 'Data tidak ditemukan. ');
            redirect('reservasi');
        }
        $this->data['reservasi'] = $reservasi;
        
        $pasien = $this->db->query("SELECT * FROM rs00002 WHERE mr_no = '".$reservasi->no_mr."'")->row();

        $this->data['pasien'] = $pasien;
        
        $form = $this->form;
        $form['reservasi_id']['value'] = $reservasiId;
        $form['alamat']['value'] = $reservasi->alamat;
        $form['telepon']['value'] = $reservasi->telepon;

        $sukuBangsa = $this->db->query("SELECT tc, tdesc FROM rs00001 WHERE tt = 'SKB' AND tc != '000' ORDER BY tdesc ASC ")->result();
        $optionsSukuBangsa = array();
        if($sukuBangsa){
            foreach($sukuBangsa as $rowSukuBangsa){
                $optionsSukuBangsa[$rowSukuBangsa->tc] = $rowSukuBangsa->tdesc;
            }
        }
        $form['suku_bangsa']['options'] =  array('000' => '') + $optionsSukuBangsa;
        if(!empty($pasien->suku_bangsa)){
            $form['suku_bangsa']['value'] = $pasien->suku_bangsa;
        }

        $bahasa = $this->db->query("SELECT tc, tdesc FROM rs00001 WHERE tt = 'BHS' AND tc != '000' ORDER BY tdesc ASC ")->result();
        $optionsBahasa = array();
        if($bahasa){
            foreach($bahasa as $rowBahasa){
                $optionsBahasa[$rowBahasa->tc] = $rowBahasa->tdesc;
            }
        }
        $form['bahasa']['options'] =  array('000' => '') + $optionsBahasa;
        if(!empty($pasien->bahasa)){
            $form['bahasa']['value'] = $pasien->bahasa;
        }

        $poli = $this->db->query("SELECT tc, tdesc FROM rs00001 WHERE tt = 'LYN' AND (tc != '000' AND tc != '100' AND tc != '172'  AND tc != '201'  AND tc != '208'  AND tc != '212' AND tc != '202') ORDER BY tdesc ASC ")->result();
        $optionsPoli = array();
        if($poli){
            foreach($poli as $rowPoli){
                $optionsPoli[$rowPoli->tc] = $rowPoli->tdesc;
            }
        }
        $form['poli']['options'] = array('000' => '') + $optionsPoli;
        $form['poli']['value'] = $reservasi->poli_id;

        $form['rujukan']['options'] = array( 'N' => 'NON RUJUKAN', 'Y' => 'RUJUKAN');

        $dokter = $this->db->query("SELECT rs00017.id, UPPER(rs00017.nama) as nama FROM rs00017 JOIN rs00018 ON rs00018.id = rs00017.jabatan_medis_fungsional_id  WHERE rs00018.unit_medis_fungsional_id = '001' AND rs00017.status NOT IN ('klr') ORDER BY rs00017.nama ASC ")->result();
        $optionsDokter = array();
        if($dokter){
            foreach($dokter as $rowDokter){
                $optionsDokter[$rowDokter->id] = $rowDokter->nama;
            }
        }
        $form['dokter_id']['options'] = array('000' => '') + $optionsDokter;
        $form['dokter_id']['value'] = $reservasi->dokter_id;

        $unitPerujuk = $this->db->query("SELECT tc, tdesc FROM rs00001 WHERE tt = 'RUJ' AND tc != '000' ORDER BY tdesc ASC ")->result();
        $optionsPerujuk = array();
        if($unitPerujuk){
            foreach($unitPerujuk as $rowPerujuk){
                $optionsPerujuk[$rowPerujuk->tc] = $rowPerujuk->tdesc;
            }
        }
        $form['rujukan_rs_id']['options'] = array('000' => '') + $optionsPerujuk;

        $penanggung = $this->db->query("SELECT tc, tdesc FROM rs00001 WHERE tt = 'PEN' AND tc != '000' ORDER BY tdesc ASC ")->result();
        $optionsPenanggung = array();
        if($penanggung){
            foreach($penanggung as $rowPenanggung){
                $optionsPenanggung[$rowPenanggung->tc] = $rowPenanggung->tdesc;
            }
        }
        $form['id_penanggung']['options'] = array('000' => '') + $optionsPenanggung;

        $groupPenjamin = $this->db->query("SELECT tc, tdesc FROM rs00001 WHERE tt = 'GPJ' AND tc != '000' ORDER BY tdesc ASC ")->result();
        $optionsGroupPenjamin = array();
        if($groupPenjamin){
            foreach($groupPenjamin as $rowGroupPenjamin){
                $optionsGroupPenjamin[$rowGroupPenjamin->tc] = $rowGroupPenjamin->tdesc;
            }
        }
        $form['group_penjamin']['options'] = array('000' => '') + $optionsGroupPenjamin;

        $tipePasien = $this->db->query("SELECT tc, tdesc FROM rs00001 WHERE tt = 'PJN' AND tc != '000' ORDER BY tdesc ASC ")->result();
        $optionsTipePasien = array();
        if($tipePasien){
            foreach($tipePasien as $rowTipePasien){
                $optionsTipePasien[$rowTipePasien->tc] = $rowTipePasien->tdesc;
            }
        }
        $form['id_penjamin']['options'] = array('000' => '') + $optionsTipePasien;

        $asuransi = $this->db->query("SELECT tc, tdesc, comment FROM rs00001 WHERE tt = 'JEP' AND tc != '000' AND tc != '001' ORDER BY comment ASC ")->result();
        $optionsAsuransi = array();
        if($asuransi){
            foreach($asuransi as $rowAsuransi){
                $optionsAsuransi[$rowAsuransi->tc] = $rowAsuransi->comment;
            }
        }
        $form['tipe']['options'] = array('000' => '') + $optionsAsuransi;
        
        $optionsPerusahaan = array();
        if($asuransi){
            foreach($asuransi as $rowPerusahaan){
                $optionsPerusahaan[$rowPerusahaan->tc] = $rowPerusahaan->tdesc;
            }
        }
        $form['nama_perusahaan']['options'] = array('000' => '') + $optionsPerusahaan;
        
        $provinsi = $this->db->query("SELECT id_prov as id, nama_prov as nama FROM add_prov ORDER BY nama_prov ASC ")->result();
        $optionsProvinsi = array();
        if($provinsi){
            foreach($provinsi as $rowProvinsi){
                $optionsProvinsi[$rowProvinsi->id] = $rowProvinsi->nama;
            }
        }
        $form['provinsi_id']['options'] = array('0' => '') + $optionsProvinsi;
        if(!empty($pasien->id_prov)){
            $form['provinsi_id']['value'] = $pasien->id_prov;
        }

        if(!empty($pasien->no_ktp)){
        $form['no_identitas']['value'] = $pasien->no_ktp;
        }

        $form['email']['value'] = $reservasi->email;

        if($reservasi->tipe_pasien == 'UMUM'){
            $form['group_penjamin']['value'] = '001';
            $form['id_penjamin']['value'] = '001';
        }

        if(!empty($pasien->id_prov)){
            $this->data['provinsi_id'] = $pasien->id_prov;
            if($pasien->id_kabkot){
                $this->data['kabupaten_id'] = $pasien->id_kabkot;
            }else{
                $this->data['kabupaten_id'] = 0;
            }
            if($pasien->id_kec){
                $this->data['kecamatan_id'] = $pasien->id_kec;
            }else{
                $this->data['kecamatan_id'] = 0;
            }
        }else{
            $this->data['provinsi_id'] = 0;
            $this->data['kabupaten_id'] = 0;
            $this->data['kecamatan_id'] = 0;
        }

        $this->form_validation->init($form);
        if ($this->form_validation->run()) {
            $jenisKunjungan = 'BARU';
            if(!empty($pasien)){
                $jenisKunjungan = 'LAMA';
            }

            $values = $this->form_validation->get_values();

            $dataPasien['id_prov']              = $values['provinsi_id'];
            $dataPasien['id_kabkot']            = $values['kabupaten_id'];
            $dataPasien['id_kec']               = $values['kecamatan_id'];
            $dataPasien['alm_tetap']            = $values['alamat'];
            $dataPasien['tlp_tetap']            = $values['telepon'];
            $dataPasien['suku_bangsa']          = $values['suku_bangsa'];
            $dataPasien['bahasa']               = $values['bahasa'];
            $dataPasien['umur']                 = $this->input->post('umur_tahun');
            $dataPasien['nrp_nip']              = $values['no_identitas'];
            $dataPasien['email']                = $values['email'];

            // set array data pasien
            if($jenisKunjungan == 'BARU'){
                $rowRS02_seq = $this->db->query("SELECT * FROM rs00002_seq")->row();
                $nextValRS02_seq = $rowRS02_seq->last_value+1;
                $dataPasien['mr_no']        = $nextValRS02_seq;
                $dataPasien['nama']         = $reservasi->nama;
                $dataPasien['tmp_lahir']    = $reservasi->tempat_lahir;
                $dataPasien['tgl_lahir']    = $reservasi->tanggal_lahir;

                $this->db->insert('rs00002', $dataPasien);
                $this->db->query('ALTER SEQUENCE rs00002_seq RESTART WITH '.$nextValRS02_seq);
            }else{
                $this->db->update('rs00002', $dataPasien, array('mr_no' => $reservasi->no_mr ));
                $dataPasien['mr_no'] =  $reservasi->no_mr;
            }          
            
            $values['id'] = $this->_set_id_rs00006();

            $values['mr_no'] = $dataPasien['mr_no'];
            $values['rawat_inap'] = 'Y';

            $dokter = $this->db->get_where('rs00017', array('id' => $values['dokter_id']) )->row();
            $values['diagnosa_sementara'] = $dokter->nama;

            $values['is_bayar']             = 'N';
            $values['status']         = '';
            $values['status_bayar']         = '-';
            $values['status_akhir_pasien']  = '-';
            $values['jml_bayar_akhir']      = '0';
            $values['tgl_keluar']           = date('Y-m-d');
            $values['jenis_kedatangan_id']  = '003';
            $values['is_karcis']            = 'Y';
            $values['is_baru']              = 'N';
            $values['periksa']              = 'N';
            $values['is_out']               = 'N';
            $values['status_apotek']        = '0';
            $values['id_dokter']            = $values['dokter_id'];
            $values['id_prov']              = $values['provinsi_id'];
            $values['id_kabkot']            = $values['kabupaten_id'];
            $values['id_kec']               = $values['kecamatan_id'];

            unset($values['reservasi_id']);
            unset($values['alamat']);
            unset($values['telepon']);
            unset($values['suku_bangsa']);
            unset($values['bahasa']);
            unset($values['no_identitas']);
            unset($values['email']);
            unset($values['dokter_id']);
            unset($values['group_penjamin']);
            unset($values['provinsi_id']);
            unset($values['kabupaten_id']);
            unset($values['kecamatan_id']);
            unset($values['keterangan']);

            // INSERT tabel pendaftaran
            $this->db->insert('rs00006', $values);

            // Insert His User 
            $dataHis['id_history']      = "nextval('rshistory_user_seq')"; 
            $dataHis['tanggal_entry']   = 'CURRENT_DATE';
            $dataHis['waktu_entry']     = 'CURRENT_TIME';
            $dataHis['trans_form']      = "'PENDAFTARAN OL'";
            $dataHis['item_id']         = "'".$values['id']."'";
            $dataHis['keterangan']      = "'Pendaftaran pasien lama dari pendataran online'";
            $this->db->insert('history_user', $dataHis, false);

            //============= START INSERT ADMINISTRASI ================
            $this->_do_insert_adm($values['id']);
            
            // Update status reservasi
            $this->db->update('pdf_reservasi', 
                                array( 'no_reg' => $values['id'],  'status' => 4), 
                                array('id' => $this->input->post('reservasi_id'))
                            );

            redirect('reservasi/view/'.$this->input->post('reservasi_id'));

        }else{

            echo  validation_errors();
        }

        $this->data['form'] = $this->form_validation;
        $this->template
                ->set_js('libs/select2/select2')
                ->set_js('libs/bootstrap-datepicker/bootstrap-datepicker')
                ->set_js('libs/bootstrap-datepicker/locales/bootstrap-datepicker.id')
                ->set_css('theme-default/libs/bootstrap-datepicker/datepicker3')
                ->set_css('theme-default/libs/select2/select2')
                ->set_css('theme-default/libs/jquery-ui/jquery-ui-theme')
                ->set_layout('pendaftaran')
                ->build('konfirmasi');
    } 

    function view($resepasiId){
        $reservasi = $this->db->get_where('pdf_reservasi', array('id' => $resepasiId))->row();
        if($reservasi){
            $reg_count = $this->getFromTable("SELECT count(mr_no) FROM rs00006 WHERE mr_no = (SELECT mr_no FROM rs00006 WHERE id = '".$reservasi->no_reg."') and id <= '".$reservasi->no_reg."'");
            $this->data['reg_count'] = $reg_count;
            $this->data['no_reg'] = $reservasi->no_reg;
            $this->template
                ->set_layout('pendaftaran')
                ->build('view');
        }else{
            $this->template->set_flashdata('warning', 'Data tidak ditemukan. ');
            redirect('reservasi');
        }

    }

    function cetak_label($no_reg = ''){
        $this->load->view('cetak_label', array());
    } 

    function cetak_pengantar(){
        $no_reg =  $this->input->get('rg');
        $this->load->view('cetak_pengantar', array('no_reg' => $no_reg));
    } 

    function _set_id_rs00006(){
        $tanggal_akhir = $this->db->query("select tanggal_reg from rs00006 ORDER BY tanggal_reg desc limit 1")->row();
        $bulan_akhir =  substr($tanggal_akhir->tanggal_reg,-5,2);
        $hari =  date('d');
        $bulan =  date('m');
        $tahun = substr(date('Y'),-2);
        //cek tanggal = 01 atau cek pergantian bulan
        if($bulan != $bulan_akhir){
            $no_reg_baru = (string) "0001".$bulan.$tahun;
        }else{//jika menambah no_reg
            $id_max = $this->db->query("select max(rs00006_id) as max_id from rs00006")->row();
            $no_reg_akhir2 = $this->db->query("select substring(id,1,4) as id from rs00006 where rs00006_id='".$id_max->max_id."' ORDER BY oid desc, tanggal_reg desc limit 1")->row();
            $no_reg_akhir3 = (int) $no_reg_akhir2->id + 1;
            $panjang_no_reg= strlen($no_reg_akhir3);
            switch($panjang_no_reg){
                case 1 : $no_reg_baru = (string) "000".$no_reg_akhir3.$bulan.$tahun;
                        break;
                case 2 : $no_reg_baru = (string) "00".$no_reg_akhir3.$bulan.$tahun;
                        break;
                case 3 : $no_reg_baru = (string) "0".$no_reg_akhir3.$bulan.$tahun;
                        break;
                default: $no_reg_baru = (string) $no_reg_akhir3.$bulan.$tahun;
                        break;
            }
        }
        return $no_reg_baru;
    }

    function getFromTable($sql){
        // $sql = "select tc_poli from rs00001 where tt = 'JEP' and tc = '002'";
        $result = $this->db->query($sql)->row_array();
        $fieldTmp = $this->db->query($sql)->field_data();
        $field = $fieldTmp[0]->name;
        return $result[$field];
    }
    
    function _do_insert_adm($noReg){
        $klinik     = $this->input->post('poli');
        $tipe       = $this->input->post('tipe');
        $item_id    = '000';

        $trans_form = $this->getFromTable("select comment from rs00001 where tt = 'LYN' and tc = '$klinik'");
        $is_new = 'N';
        $tctipe = $this->getFromTable("select tc_tipe from rs00001 where tt = 'JEP' and tc = '$tipe'");

        if($tctipe =='001' or $tctipe =='002'){ // Jika auransi yang dipilih umum/INTI PRIMA
            if($is_new == 'N'){
                if($klinik == '100'){
                    $item_id = '283';	
                }else{
                    $item_id = '283';
                }
                $harga = $this->getFromTable("select harga from rs00034 where id = '".$item_id."'");
            }elseif($is_new == 'Y'){
                if($klinik == '100'){
                    $item_id = '282';	
                }else{
                    $item_id = '282';
                }
                $harga = $this->getFromTable("select harga from rs00034 where id = '".$item_id."'");
            }
        }else{
            if($klinik == '100'){
                $item_id = '284';	
            }else{
                $item_id = '284';
            }
            $harga = $this->getFromTable("select harga from rs00034 where id = '".$item_id."'");    
        }
        $dokter='0';
        
        $jasaadmin = $this->getFromTable("select jasa_admin from rs00034 where id = '".$item_id."'");
        $jasapelayanan = $this->getFromTable("select jasa_pelayanan from rs00034 where id = '".$item_id."'");
        if($tipe !='001'){
           $dibayarpenjamin = $harga;
           $jasaadmin_dp = $jasaadmin;
           $jasapelayanan_dp = $jasapelayanan;
        }else{
           $dibayarpenjamin = 0.00;
           $jasaadmin_dp = 0.00;
           $jasapelayanan_dp = 0.00;
        }
        
        if($klinik !='210'){// 210 = PERINATOLOGI,
            
            $SQLAdm8= "insert into rs00008 (id, trans_type, trans_form, trans_group, tanggal_trans,
            tanggal_entry, waktu_entry, no_reg, item_id, qty, harga, tagihan, pembayaran, no_kwitansi,user_id, persen, diskon,jasa_admin,jasa_pelayanan,dibayar_penjamin,jasa_admin_dp,jasa_pelayanan_dp) values ( nextval('rs00008_seq'), 'LTM', '".$trans_form."', (SELECT last_value FROM rs00008_seq_group), CURRENT_DATE, CURRENT_DATE, CURRENT_TIME, '$noReg', '" . $item_id . "','1','" . $harga . "','" . $harga . "', '0', '0','pdf_ol', '0','0','".$jasaadmin."','".$jasapelayanan."','".$dibayarpenjamin."','".$jasaadmin_dp."','".$jasapelayanan_dp."')";
            $this->db->query($SQLAdm8);
            
            $SQLAdm5= "INSERT INTO rs00005 (id ,  reg,  tgl_entry ,  kasir ,  is_obat ,  is_karcis,  layanan,  jumlah ,  is_bayar,  user_id, trans_group ) 
                        VALUES( nextval('kasir_seq'), '".$noReg."', CURRENT_DATE, 'RJL', 'N', 'N', '".$klinik."', '".$harga."', 'N','pdf_ol', (SELECT last_value FROM rs00008_seq_group) )";
            $this->db->query($SQLAdm5);
        }
       
        //***************************************************************************************************
        $id_dokter = $this->input->post('dokter_id');
        if($klinik !='203'){ //Pengecualian LAB
            if($klinik !='204'){ //Pengecualian Radiologi
                if($klinik !='210'){ //Pengecualian Perinatologi
                    if($id_dokter > '0' && $id_dokter !='593'){
                        /*Deteksi Group Tenaga Kesehatan*/
                        $tenkes   = $this->getFromTable("select b.tenaga_kesehatan from rs00017 a
                                    left join rs00018 b on b.id=a.jabatan_medis_fungsional_id
                                    where a.id = '$id_dokter'");
                        if($klinik=='100' or $klinik=='214'){ // 100 = IGD, 214 = Klinik Umum Hari Libur
                            /*Baca Setingan Item Id Tarif*/
                            $itemPem  = $this->getFromTable("select tc_tipe from rs00001 where tt = 'TKS' and tc = '$tenkes'");	
                        }else{
                            if($id_dokter =='592'){
                                /*Baca Setingan Item Id Tarif*/
                                $itemPem  = $this->getFromTable("select tc_poli from rs00001 where tt = 'TKS' and tc = '006'");
                            }else{
                                /*Jika Tipe BPJS 09 JAN 2018 18:33*/
                                if($tctipe == '002'){
                                    if($klinik=='205'){
                                        $itemPem  ='2613';
                                    } else {
                                        $itemPem  ='2591';
                                    }
                                } else {/*Selain BPJS*/
                                    /*Baca Setingan Item Id Tarif*/
                                    $itemPem  = $this->getFromTable("select tc_poli from rs00001 where tt = 'TKS' and tc = '$tenkes'");
                                }
                            }
                        }
                        /*Baca Harga Tarif sesuai Settingan*/
                        $hargaPem = $this->getFromTable("select harga from rs00034 where id = '".$itemPem."'");
                        $jasaDokter = $this->getFromTable("select jasa_dokter from rs00034 where id = '".$itemPem."'");
                        $jasaSarana = $this->getFromTable("select jasa_rs from rs00034 where id = '".$itemPem."'");
                        
                        if($tipe !='001'){
                            $dibayarpenjamin  = $hargaPem;
                            $jasaDokter_dp    = $jasaDokter;
                            $jasaSarana_dp    = $jasaSarana;
                        }else{
                            $dibayarpenjamin  = 0.00;
                            $jasaDokter_dp    = 0.00;
                            $jasaSarana_dp    = 0.00;
                        }
                        
                        /*Insert Pemeriksaan Dokter*/
                        $SQLPem8= "INSERT INTO rs00008 (id, trans_type, trans_form, trans_group, tanggal_trans, tanggal_entry, waktu_entry, no_reg, item_id, qty, harga, tagihan, pembayaran, no_kwitansi,user_id, persen, diskon, jasa_dokter,ip_addr,dibayar_penjamin,jasa_dokter_dp, jasa_rs, jasa_rs_dp) 
                                    VALUES ( nextval('rs00008_seq'), 'LTM', '".$trans_form."', nextval('rs00008_seq_group'), CURRENT_DATE, CURRENT_DATE, CURRENT_TIME, '".$noReg."', '" . $itemPem . "','1','" . $hargaPem . "','" . $hargaPem . "', '0', '".$id_dokter."','pdf_ol', '0','0', '".$jasaDokter."', '000.000.000.000','".$dibayarpenjamin."','".$jasaDokter_dp."','".$jasaSarana."','".$jasaSarana_dp."' )";
                        $this->db->query($SQLPem8);
                        
                        $SQLPem5= "INSERT INTO rs00005 (id ,  reg,  tgl_entry ,  kasir ,  is_obat ,  is_karcis,  layanan,  jumlah ,  is_bayar, user_id, trans_group ) 
                                    VALUES( nextval('kasir_seq'), '".$noReg."',CURRENT_DATE, 'RJL', 'N', 'N', '".$klinik."', '".$hargaPem."', 'N','pdf_ol', nextval('rs00008_seq_group') )";
                        $this->db->query($SQLPem5);
                    }
                }
            }
        }
        
        /*Jasa Pelayanan Rs*/
        if($id_dokter > '0' && ($id_dokter =='592' || $id_dokter =='593')){ // Jika Bidan / Fisioterapis
        
            $itemJars = '2135';
                
            $hargaJars = $this->getFromTable("select harga from rs00034 where id = '".$itemJars."'");
            
            $jasapelJars = $this->getFromTable("select jasa_pelayanan from rs00034 where id = '".$itemJars."'");
            
            if($tipe !='001'){
                $dibayarpenjamin = $hargaJars;
                $jasapelayanan_dp = $jasapelayanan;
            }else{
                $dibayarpenjamin = 0.00;
                $jasapelayanan_dp = 0.00;
            }
            $SQLJars8= "INSERT INTO rs00008 (id, trans_type, trans_form, trans_group, tanggal_trans, tanggal_entry, waktu_entry, no_reg, item_id, qty, harga, tagihan, pembayaran, no_kwitansi,user_id, persen, diskon, jasa_pelayanan, ip_addr, dibayar_penjamin,jasa_pelayanan_dp) 
                        VALUES ( nextval('rs00008_seq'), 'LTM', '".$trans_form."', (SELECT last_value FROM rs00008_seq_group) , CURRENT_DATE, CURRENT_DATE, CURRENT_TIME, '".$noReg."', '" . $itemJars . "','1','" . $hargaJars . "','" . $hargaJars . "', '0', '".$dokter."','pdf_ol', '0','0','".$jasapelJars."','000.000.000.000','".$dibayarpenjamin."','".$jasapelayanan_dp."')";
            $this->db->query($SQLJars8);
            
            $SQLJars5= "INSERT INTO rs00005 (id , reg, tgl_entry, kasir, is_obat, is_karcis, layanan, jumlah, is_bayar, user_id, trans_group ) 
                        VALUES( nextval('kasir_seq'), '".$noReg."',CURRENT_DATE, 'RJL', 'N', 'N', '".$klinik."', '".$hargaJars."', 'N','pdf_ol', (SELECT last_value FROM rs00008_seq_group))";
            $this->db->query($SQLJars5);
        }
        
        $this->db->query("insert into rs00005 values( nextval('kasir_seq'), '$noReg', CURRENT_DATE, 'ASK', 'N', 'N', 0, 0, 'Y')");
        $this->db->query("insert into rs00005 values( nextval('kasir_seq'),'$noReg',CURRENT_DATE,'POT','N','N',0,0,'Y')");
        
        if ($_POST["poli"] == "214"){
            $SQLhlr="update rs00006 set poli='101' where id='$noReg' and poli='214'";
            $this->db->query($SQLhlr);
            
            $SQLhlr8="update rs00008 set trans_form='p_umum' where no_reg='$noReg' and trans_type='LTM'";
            $this->db->query($SQLhlr8);
            
            $SQLhlr5="update rs00005 set layanan='101' where reg='$noReg' and kasir='RJL'";
            $this->db->query($SQLhlr5);
        }
        
    }

	
	function delete($id){
		$row = $this->db->get_where('pdf_reservasi', array('id' => $id))->row();
		if(!empty($row)){
			$this->db->update('pdf_reservasi', array('status' => 0), array('id' => $id));
			redirect('reservasi');
		}
    }

    function cek_bpjs(){
        $noKartu = $this->input->post('no');
        $this->_get_data_bpjs($noKartu);
    }

    function _get_data_bpjs($noKartu) {
        //Testing ID
        $consID = "3378";
        //$consSecret = "3987";
        $consSecret = "0hH768796F";

        // Computes the timestamp
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', $consID."&".$timestamp, $consSecret, true);
        $encodedSignature = base64_encode($signature);
        //$encodedSignature = urlencode($encodedSignature);
        // Build Request
        //string(105) "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Peserta/nokartu/0001478586813/tglSEP/2019-04-04"
        $request = curl_init('https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Peserta/nokartu/'.$noKartu.'/tglSEP/'.date('Y-m-d'));
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

    public function history(){
        $this->load->model('reservasi_jadwal_dokter_model');
        $rowsDokter = $this->data['rowsDokter'] = $this->reservasi_jadwal_dokter_model->list_all_dokter();
        $optionsDokter = array();
        $optionsDokter['0'] = '';
        foreach ($rowsDokter as $dokter) {
            if($dokter->nama != '-'){
                $optionsDokter[$dokter->id] = $dokter->nama;
            }
        }

        $poli = $this->db->query("SELECT tc, tdesc FROM rs00001 WHERE tt = 'LYN' AND (tc != '000' AND tc != '100' AND tc != '172'  AND tc != '201'  AND tc != '208'  AND tc != '212' AND tc != '202') ORDER BY tdesc ASC ")->result();
        $optionsPoli = array();
        $optionsPoli['000'] = '';
        if($poli){
            foreach($poli as $rowPoli){
                if($rowPoli->tdesc != '-'){
                    $optionsPoli[$rowPoli->tc] = $rowPoli->tdesc;
                }
            }
        }
        
        $this->data['optionsPoli'] = $optionsPoli;
        $this->data['optionsDokter'] = $optionsDokter;
        $this->template
            ->set_css('theme-default/libs/bootstrap-datepicker/datepicker3')
            ->set_css('theme-default/libs/bootstrap-colorpicker/bootstrap-colorpicker')
            ->set_css('theme-default/libs/DataTables/jquery.dataTables')
            ->set_css('theme-default/libs/DataTables/extensions/dataTables.colVis')
            ->set_css('theme-default/libs/DataTables/extensions/dataTables.tableTools')
            ->set_js('libs/DataTables/jquery.dataTables.min')
            ->set_js('libs/DataTables/extensions/ColVis/js/dataTables.colVis.min')
            ->set_js('libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min')
            ->set_js('libs/bootstrap-datepicker/bootstrap-datepicker')
            ->set_js('libs/bootstrap-colorpicker/bootstrap-colorpicker.min')
            ->set_layout('pendaftaran')
            ->build('reservasi/history', $this->data);
    }

    function datatables_source(){
        // $params['status'] = 1;
        $params = array();
        if((int)$this->input->post('poli_id') > 0){
            $params['poli_id'] = $this->input->post('poli_id');
        }
        if((int)$this->input->post('dokter_id') > 0){
            $params['dokter_id'] = $this->input->post('dokter_id');
        }
        if(!empty($this->input->post('tgl_kunjungan'))){
            $arrTglKunjungan = explode('/', $this->input->post('tgl_kunjungan'));
            $params['tanggal_kunjungan'] = $arrTglKunjungan[2].'-'.$arrTglKunjungan[1].'-'.$arrTglKunjungan[0];
        }
            $this->load->library('datatables');
            $this->datatables
            ->select('id, tanggal_kunjungan, kode, no_mr, nama, alamat, telepon, tipe_pasien, poli_nama, dokter_nama', FALSE)
            ->where($params)
            ->from('pdf_reservasi');
            echo $this->datatables->generate();
    }
    
    public function send_mail()
    {
        $this->load->library('email');

        $config['protocol'] = 'mail';
        $config['smtp_host'] = 'mail.rsuelisabethpwt.com';
        $config['smtp_port'] = 143;
        $config['smtp_user'] = 'informasi@rsuelisabethpwt.com';
        $config['smtp_pass'] = 'rahasiaRSE40';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['mailtype'] = "html";
        $config['charset'] = "utf-8";
        $config['wordwrap'] = TRUE;
        // $config['protocol'] = 'smtp';
        // $config['smtp_host'] = 'smtp.mailtrap.io';
        // $config['smtp_port'] = 2525;
        // $config['smtp_user'] = '54469740581ae3';
        // $config['smtp_pass'] = '3948d29039d4ac';
        // $config['crlf'] = "\r\n";
        // $config['newline'] = "\r\n";

        $this->email->initialize($config);
        $this->email->from('informasi@rsuelisabethpwt.com', 'Informasi');
        $this->email->to('dediahmadwadi@gmail.com');

        // $data = $this->db->get_where('pdf_reservasi', array('id' => $this->input->post('id')) );
        // $mesg = $this->load->view('message_confirm',$data,true);
        $mesg = 'Hallo';


        $this->email->subject('Email Test');
        $this->email->message($mesg);

        $this->email->send();
    }

    function sms(){
        $username = 'demo_akun';
        $password = 'elpia2018';
        $text = rawurlencode('Terimakasih, sudah melakukan pendaftaran secara online, kode Booking : 23GHY5');
        $gsm = '+6281322322946';
        $url = 'http://appelpiamessenger.com/api/v3/sendsms/plain?user=' . $username . '&password=' . $password . '&SMSText=' . $text .'&GSM=' . $gsm;
        $opt = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        );
        $curl = curl_init();
        curl_setopt_array($curl, $opt);
        $resp = curl_exec($curl);
        if (!$resp) {
        die('Error: "' . curl_error($curl) . '" - Code: ' .
        curl_errno($curl));
        } else {
        echo $resp;
        }
        curl_close($curl);
    }

    function _update_no_urut_daftar($date){
        $rowsPraktek = $this->db->query("SELECT DISTINCT poli_id, poli_nama, dokter_praktek_mulai FROM pdf_reservasi WHERE created_date::DATE = '".$date."' ORDER BY poli_nama, dokter_praktek_mulai ASC")->result();
        if($rowsPraktek){
            foreach($rowsPraktek as $rowPraktek){
                $rowsPasien = $this->db->query("SELECT id FROM pdf_reservasi WHERE poli_id = ".$rowPraktek->poli_id." AND dokter_praktek_mulai = '".$rowPraktek->dokter_praktek_mulai."' AND created_date::DATE = '".$date."' ORDER BY poli_nama, dokter_praktek_mulai, created_date ASC")->result();
                if($rowsPasien){
                    $i = 1; 
                    foreach($rowsPasien as $row){
                            $this->db->query("UPDATE pdf_reservasi SET no_urut_daftar = ".$i." WHERE id = ".$row->id);
                        $i++;
                    }
                }
            }
        }
    }
}