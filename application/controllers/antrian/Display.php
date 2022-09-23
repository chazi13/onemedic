<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Display extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('antrian_display_model');
    }

    function index($group = '') {
        $rowsDokterDisplay = $this->antrian_display_model->get_all_by_params(array('grup' => $group));
        $this->data['rowsDokterDisplay'] = $rowsDokterDisplay;
        $this->template
                ->set_js('eocjs-newsticker', true)
                ->set_css('eocjs-newsticker')
                ->set_layout('clean')
                ->build('antrian/display', $this->data);
    }
    
    function _do_insert_pasien(){
        $this->load->library('form_validation');
        $form = $this->form;
        $form['pasien_no_mr']['rules'] = 'trim'; // validasi nya ga usah required karena pasien baru berarti MR baru dibuat
        
        $this->form_validation->init($form);
        if ($this->form_validation->run()) {
            $data = $this->form_validation->get_values();
            
            $pasien = array();
            $pendaftaran = array();
            foreach ($data as $key => $value) {
                if( substr($key, 0, 3) != 'pdf'){
                    (!empty($data['pasien_provinsi_id']))  ? $pProvinsi  = $data['pasien_provinsi_id']  : $pProvinsi = 0;
                    (!empty($data['pasien_kabupaten_id'])) ? $pKabupaten = $data['pasien_kabupaten_id'] : $pKabupaten = 0;
                    (!empty($data['pasien_kecamatan_id'])) ? $pKecamatan = $data['pasien_kecamatan_id'] : $pKecamatan = 0;
                    (!empty($data['pasien_kelurahan_id'])) ? $pKelurahan = $data['pasien_kelurahan_id'] : $pKelurahan = 0;

                    $provinsi = $this->provinsi_model->get_by_id($pProvinsi);
                    $kabupaten = $this->kabupaten_model->get_by_id($pKabupaten);
                    $kecamatan = $this->kecamatan_model->get_by_id($pKecamatan);
                    $kelurahan = $this->kelurahan_model->get_by_id($pKelurahan);

                    (!empty($provinsi))  ? $provinsiNama  = $provinsi->nama  : $provinsiNama = '';
                    (!empty($kabupaten))  ? $kabupateniNama  = $kabupaten->nama  : $kabupateniNama = '';
                    (!empty($kecamatan))  ? $kecamatanNama  = $kecamatan->nama  : $kecamatanNama = '';
                    (!empty($kelurahan))  ? $kelurahanNama  = $kelurahan->nama  : $kelurahanNama = '';

                    $pasien[substr($key, 7)] = $value;
                    $pasien['pekerjaan'] = $data['pdf_pekerjaan'];
                    $pasien['pekerjaan_nama_tempat'] = !empty($data['pdf_pekerjaan_nama_tempat']) ? $data['pdf_pekerjaan_nama_tempat'] : '';
                    $pasien['pekerjaan_nip'] = !empty($data['pdf_pekerjaan_nip']) ? $data['pdf_pekerjaan_nip'] : '';
                    $pasien['pekerjaan_golongan'] = !empty($data['pdf_pekerjaan_golongan']) ? $data['pdf_pekerjaan_golongan'] : '';
                    $pasien['status_perkawinan'] = !empty($data['pdf_status_perkawinan']) ? $data['pdf_status_perkawinan'] : '';
                    $pasien['pendidikan_terakhir'] = !empty($data['pdf_pendidikan_terakhir']) ? $data['pdf_pendidikan_terakhir'] : '';
                    $pasien['provinsi_id'] = $pProvinsi;
                    $pasien['provinsi_nama'] = $provinsiNama;
                    $pasien['kabupaten_id'] = $pKabupaten;
                    $pasien['kabupaten_nama'] = $kabupateniNama;
                    $pasien['kecamatan_id'] = $pKecamatan;
                    $pasien['kecamatan_nama'] = $kecamatanNama;
                    $pasien['kelurahan_id'] = $pKelurahan;
                    $pasien['kelurahan_nama'] = $kelurahanNama;
                    $pasien['keluarga_dekat_nama'] = !empty($data['pdf_kontak_nama']) ? $data['pdf_kontak_nama'] : '';
                    $pasien['keluarga_dekat_alamat'] = !empty($data['pdf_kontak_alamat']) ? $data['pdf_kontak_alamat'] : '';
                    $pasien['keluarga_dekat_telepon'] = !empty($data['pdf_kontak_telepon']) ? $data['pdf_kontak_telepon'] : '';
                    $pasien['keluarga_dekat_kota'] = !empty($data['pdf_kontak_kota']) ? $data['pdf_kontak_kota'] : '';

                    if(!empty($data['pdf_asuransi_id']) && ($data['pdf_asuransi_id'] == $this->config->item('asuransi_bpjs_id')) ){
                        $pasien['bpjs_no_peserta'] = $data['pdf_no_kartu'];
                    }
                }
            }
            
            $poli_id = (isset($pendaftaran['poli_id'])) ? $pendaftaran['poli_id'] : NULL;
            
            if($this->input->post('id') != ''){
                $pasien_id = $this->input->post('id');
                $this->pasien_model->update($pasien_id, array_filter($pasien));
            }else{
                $pasien['no_mr'] = $this->pasien_model->create_no_mr();
                $pasien_id = $this->pasien_model->insert(array_filter($pasien));
            }
            
            $pasien = $this->pasien_model->get_by_id($pasien_id);
            
            return $pasien;
        }
    }
    
    function _do_insert_pendaftaran($pasien){
        $this->load->library('form_validation');
        $form = $this->form;
        $form['pasien_no_mr']['rules'] = 'trim'; // validasi nya ga usaha required karena pasien baru berarti MR baru dibuat
        
        $this->form_validation->init($form);
        if ($this->form_validation->run()) {
            $data = $this->form_validation->get_values();
            $pendaftaran = array();
            foreach ($data as $key => $value) {
                if( substr($key, 0, 3) == 'pdf'){
                    (!empty($data['pasien_provinsi_id']))  ? $pProvinsi  = $data['pasien_provinsi_id']  : $pProvinsi = 0;
                    (!empty($data['pasien_kabupaten_id'])) ? $pKabupaten = $data['pasien_kabupaten_id'] : $pKabupaten = 0;
                    (!empty($data['pasien_kecamatan_id'])) ? $pKecamatan = $data['pasien_kecamatan_id'] : $pKecamatan = 0;
                    (!empty($data['pasien_kelurahan_id'])) ? $pKelurahan = $data['pasien_kelurahan_id'] : $pKelurahan = 0;

                    $provinsi = $this->provinsi_model->get_by_id($pProvinsi);
                    $kabupaten = $this->kabupaten_model->get_by_id($pKabupaten);
                    $kecamatan = $this->kecamatan_model->get_by_id($pKecamatan);
                    $kelurahan = $this->kelurahan_model->get_by_id($pKelurahan);

                    (!empty($provinsi))  ? $provinsiNama  = $provinsi->nama  : $provinsiNama = '';
                    (!empty($kabupaten))  ? $kabupateniNama  = $kabupaten->nama  : $kabupateniNama = '';
                    (!empty($kecamatan))  ? $kecamatanNama  = $kecamatan->nama  : $kecamatanNama = '';
                    (!empty($kelurahan))  ? $kelurahanNama  = $kelurahan->nama  : $kelurahanNama = '';
                
                    $pendaftaran[substr($key, 4)] = $value;
                    
                    if(!empty($data['pdf_dokter_id'])){
                        $dokter = $this->pegawai_model->get_by_id($data['pdf_dokter_id']);
                        $pendaftaran['dokter_nama'] = !empty($dokter) ? $dokter->nama : '-';
                    }
                    
                    if(!empty($data['pdf_dokter_dpjp_id'])){
                        $dokterDPJP = $this->pegawai_model->get_by_id($data['pdf_dokter_dpjp_id']);
                        $pendaftaran['dokter_dpjp_nama'] = !empty($dokterDPJP) ? $dokterDPJP->nama : '-';
                    }

                    if(!empty($data['pdf_poli_id'])){
                        $poli = $this->poli_model->get_by_id($data['pdf_poli_id']);
                        $pendaftaran['poli_nama'] = $poli->nama;
                    }
                    
                    $tipePasien = $this->tipe_pasien_model->get_by_id($data['pasien_tipe_pasien_id']);
                    $pendaftaran['tipe_pasien_id']      = (int)$data['pasien_tipe_pasien_id'];
                    $pendaftaran['tipe_pasien_nama']    = $tipePasien->nama;
                    
                    $pendaftaran['no_antrian']          = $this->pendaftaran_model->create_no_antrian($data['pdf_poli_id']);
                    $pendaftaran['no_reg']              = $this->pendaftaran_model->create_no_registrasi();
                    
                    $pendaftaran['jenis_identitas']     = $data['pdf_kontak_jenis_identitas'];
                    $pendaftaran['no_identitas']        = !empty($data['pasien_no_identitas']) ? $data['pasien_no_identitas'] : '';
                    $pendaftaran['nama']                = !empty($data['pasien_nama']) ? $data['pasien_nama'] : '';
                    $pendaftaran['alamat']              = !empty($data['pasien_alamat']) ? $data['pasien_alamat'] : '';      
                    $pendaftaran['alamat_daerah']       = !empty($data['pasien_alamat_daerah']) ? $data['pasien_alamat_daerah'] : '';      
                    $pendaftaran['telepon']             = !empty($data['pasien_telepon']) ? $data['pasien_telepon'] : '';
                    $pendaftaran['umur_tahun']          = $this->input->post('pasien_umur_tahun');
                    $pendaftaran['umur_bulan']          = $this->input->post('pasien_umur_bulan');
                    $pendaftaran['umur_hari']           = $this->input->post('pasien_umur_hari');
                    $pendaftaran['provinsi_id']         = $pProvinsi;
                    $pendaftaran['provinsi_nama']       = $provinsiNama;
                    $pendaftaran['kabupaten_id']        = $pKabupaten;
                    $pendaftaran['kabupaten_nama']      = $kabupateniNama;
                    $pendaftaran['kecamatan_id']        = $pKecamatan;
                    $pendaftaran['kecamatan_nama']      = $kecamatanNama;
                    $pendaftaran['kelurahan_id']        = $pKelurahan;
                    $pendaftaran['kelurahan_nama']      = $kelurahanNama;
                    
                    if(!empty($data['pdf_rujukan_dari_id'])){
                        $rujukan = $this->rujukan_model->get_by_id($data['pdf_rujukan_dari_id']);
                        $pendaftaran['rujukan_dari'] = $rujukan->nama;
                    }
                    
                    if(!empty($data['pdf_perusahaan_id'])){
                        $perusahaan = $this->perusahaan_model->get_by_id($data['pdf_perusahaan_id']);
                        $pendaftaran['perusahaan_nama'] = $perusahaan->nama;
                    }
                    
                    if(!empty($data['pdf_asuransi_id'])){
                        $asuransi = $this->asuransi_model->get_by_id($data['pdf_asuransi_id']);
                        $pendaftaran['asuransi_nama'] = $asuransi->nama;
                    }
                    
                    if(!empty($pendaftaran['rujukan_tanggal'])){
                        $arrTglRujukan = explode('-', $pendaftaran['rujukan_tanggal']);
                        $pendaftaran['rujukan_tanggal'] = $arrTglRujukan[2].'-'.$arrTglRujukan[1].'-'.$arrTglRujukan[0];
                    }
                    if(!empty($pendaftaran['tanggal_surat_jaminan'])){
                        $arrTglSuratJaminan = explode('-', $pendaftaran['tanggal_surat_jaminan']);
                        $pendaftaran['tanggal_surat_jaminan'] = $arrTglSuratJaminan[2].'-'.$arrTglSuratJaminan[1].'-'.$arrTglSuratJaminan[0];
                    }
                    
                    unset($pendaftaran['jenis_kedatangan']);
                }
            }
            
            $poli_id = (isset($pendaftaran['poli_id'])) ? $pendaftaran['poli_id'] : NULL;

            $pendaftaran['no_mr']               = $pasien->no_mr;
            $pendaftaran_id = $this->pendaftaran_model->insert(array_filter($pendaftaran));
            
            $result = $this->pendaftaran_model->get_by_id($pendaftaran_id);
            
            return $result;

        }
    }

    function cari(){
        $key = strtolower($this->input->post('key_search'));
        $rows = null;
        if($key){
            $rows = $this->pasien_model->get_all_by_params(array("LOWER(no_mr) LIKE '%".$key."%' OR LOWER(nama) LIKE '%".$key."%' OR LOWER(alamat) LIKE '%".$key."%' " => null ));
        }
        $this->data['rows'] = $rows;
        $this->template
                ->set_js('../bower_components/select2/dist/js/select2')
                ->set_js('../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker')
                ->set_js('../bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min')
                ->set_css('../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3')
                ->set_css('../bower_components/select2/dist/css/select2')
                ->set_layout('pendaftaran')
                ->build('pendaftaran/cari', $this->data);
    }

    function _insert_rs00008($pendaftaran){
        // INSERT rs00008
        $rowRS08_seq = $this->db->query("SELECT * FROM rs00008_seq")->row();
        $nextValRS08_seq = $rowRS08_seq->last_value+1;
        $rowRS08_seq_group = $this->db->query("SELECT * FROM rs00008_seq_group")->row();
        $currentValRS08_seq_group = $rowRS08_seq_group->last_value;
        
        $transForm = $this->db->query("SELECT comment FROM rs00001 WHERE tt = 'LYN' AND tc = '". str_pad($pendaftaran['poli_id'], 3, '0', STR_PAD_LEFT)."'")->row();
        !empty($transForm->comment) ? $strTransForm = $transForm->comment :  $strTransForm =  '-';
        
        $arrDataRS08 = array();
        $arrDataRS08['id'] = $nextValRS08_seq; 
        $arrDataRS08['trans_type'] = "LTM"; 
        $arrDataRS08['trans_form'] = $strTransForm; 
        $arrDataRS08['trans_group'] = $currentValRS08_seq_group; 
        $arrDataRS08['tanggal_trans'] = date('Y-m-d'); 
        $arrDataRS08['tanggal_entry'] = date('Y-m-d'); 
        $arrDataRS08['waktu_entry'] = date('H:i:s'); 
        $arrDataRS08['no_reg'] = $pendaftaran['no_reg']; 
        
        ($pendaftaran['jenis_kunjungan'] == "BARU") ? $strItemId = '11132' : $strItemId = '11131';
        $arrDataRS08['item_id'] = $strItemId; 
        
        $hargaVal = $this->db->query("select harga from rs00034 where id = '".$arrDataRS08['item_id']."'")->row();
        !empty($hargaVal->harga) ? $harga = $hargaVal->harga :  $harga =  0;
        
        $arrDataRS08['qty'] = 1; 
        $arrDataRS08['harga'] = $harga; 
        $arrDataRS08['tagihan'] = $harga; 
        $arrDataRS08['pembayaran'] = 0; 
        !empty($pendaftaran['rujukan_dari_id']) ? $penjaminVal = $arrDataRS08['tagihan'] : $penjaminVal = 0; 
        $arrDataRS08['dibayar_penjamin'] = $penjaminVal; 
        $arrDataRS08['no_kwitansi'] = $pendaftaran['dokter_id'];
        
        $user = $this->user_model->get_by_id($this->session->userdata('auth_user'));
        $arrDataRS08['user_id'] = $user->first_name; 
        $arrDataRS08['persen'] = 0;
        $arrDataRS08['diskon'] = 0;
        $this->db->insert('rs00008', $arrDataRS08);
        $this->db->query('ALTER SEQUENCE rs00008_seq RESTART WITH '.((int)$nextValRS08_seq+1));
        
        $arrDataRS08['poli_id'] =  str_pad($pendaftaran['poli_id'], 3, '0', STR_PAD_LEFT);
        $this->_insert_rs00005($arrDataRS08);
    }
    
    function _insert_rs00005($arrDataRS08){
        $rowRS05_seq = $this->db->query("SELECT * FROM kasir_seq")->row();
        $nextValRS05_seq = $rowRS05_seq->last_value+1;
        $arrDataRS05['id'] = $nextValRS05_seq;
        $arrDataRS05['reg'] = $arrDataRS08['no_reg'];
        $arrDataRS05['tgl_entry'] = date('Y-m-d');
        $arrDataRS05['kasir'] = 'RJL';
        $arrDataRS05['is_obat'] = 'N';
        $arrDataRS05['is_karcis'] = 'N';
        $arrDataRS05['layanan'] = $arrDataRS08['poli_id'];
        $arrDataRS05['jumlah'] = $arrDataRS08['tagihan'];
        $arrDataRS05['is_bayar'] = 'N';
        $user = $this->user_model->get_by_id($this->session->userdata('auth_user'));
        $arrDataRS05['user_id'] = $user->first_name; 
        $this->db->insert('rs00005', $arrDataRS05);
        $this->db->query('ALTER SEQUENCE kasir_seq RESTART WITH '.($nextValRS05_seq+1));
        
        $rowRS05_seq = $this->db->query("SELECT * FROM kasir_seq")->row();
        $nextValRS05_seq = $rowRS05_seq->last_value+1;
        $arrDataRS05['id'] = $nextValRS05_seq;
        $arrDataRS05['kasir'] = 'ASK';
        $arrDataRS05['layanan'] = 0;
        $arrDataRS05['jumlah'] = 0;
        $arrDataRS05['is_bayar'] = 'Y';
        $this->db->insert('rs00005', $arrDataRS05);
        $this->db->query('ALTER SEQUENCE kasir_seq RESTART WITH '.($nextValRS05_seq+1));
        
        $rowRS05_seq = $this->db->query("SELECT * FROM kasir_seq")->row();
        $nextValRS05_seq = $rowRS05_seq->last_value+1;
        $arrDataRS05['id'] = $nextValRS05_seq;
        $arrDataRS05['kasir'] = 'POT';
        $this->db->insert('rs00005', $arrDataRS05);
        $this->db->query('ALTER SEQUENCE kasir_seq RESTART WITH '.($nextValRS05_seq+1));
        
    }
    
    function get_dokter_poli(){// ambil data dokter berdasarkan poli, klo blom dimaping get all aja
        $poliId = $this->input->post('poli_id');
        $dokterPerPoli = $this->pegawai_model->get_dokter(array('poli_id' => $poliId));
        if(empty($dokterPerPoli)){
            $dokterPerPoli = $this->pegawai_model->get_dokter();
        }
        $ddDokter = array();
        foreach ($dokterPerPoli as $dokter){
            $ddDokter['"'.$dokter->id.'"'] = $dokter->nama;
        }
        
        header('Content-Type: application/json');
        echo json_encode($ddDokter,true);
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
