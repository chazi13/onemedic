<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends Admin_Controller {

    protected $form = array(
        'pasien_id' => array(
            'helper' => 'form_hidden'
        ),
        'pasien_no_mr' => array(
            'label' => 'No MR',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pasien_tipe_pasien_id' => array(
            'label' => 'Tipe Pasien',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'pasien_nama' => array(
            'label' => 'Nama Lengkap',
            'rules' => 'required|trim',
            'helper' => 'form_inputlabel'
        ),
        'pasien_jenis_kelamin' => array(
            'label' => 'Jenis Kelamin',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pasien_tempat_lahir' => array(
            'label' => 'Tempat Lahir',
            'rules' => 'trim|required',
            'helper' => 'form_inputlabel'
        ),
        'pasien_tanggal_lahir' => array(
            'label' => 'Tanggal Lahir',
            'rules' => 'trim|required',
            'helper' => 'form_hidden'
        ),
        'pasien_golongan_darah' => array(
            'label' => 'Golongan Darah',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pasien_no_identitas' => array(
            'label' => 'Nomor KTP/SIM/KTA',
            'rules' => 'trim|required',
            'helper' => 'form_inputlabel'
        ),
        'pasien_agama' => array(
            'label' => 'Agama',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pasien_kewarganegaraan' => array(
            'label' => 'Kewarganegaraan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pasien_negara' => array(
            'label' => 'Negara',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pdf_pendidikan_terakhir' => array(
            'label' => 'Pendidikan Terakhir',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pdf_pekerjaan' => array(
            'label' => 'Pekerjaan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pdf_pekerjaan_nama_tempat' => array(
            'label' => 'Instansi/Kesatuan',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pdf_pekerjaan_nip' => array(
            'label' => 'NIP',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pdf_pekerjaan_golongan' => array(
            'label' => 'Pangkat/Golongan',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pdf_status_perkawinan' => array(
            'label' => 'Status Perkawinan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pasien_alamat' => array(
            'label' => 'Alamat',
            'rules' => 'required|trim',
            'helper' => 'form_inputlabel'
        ),
        'pasien_alamat_daerah' => array(
            'label' => 'Kota/Daerah',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pasien_email' => array(
            'label' => 'Email',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pasien_nama_ayah' => array(
            'label' => 'Nama Ayah',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pasien_nama_ibu' => array(
            'label' => 'Nama Ibu',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pasien_pekerjaan_orang_tua' => array(
            'label' => 'Pekerjaan Orang Tua',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pasien_provinsi_id' => array(
            'label' => 'Provinsi',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pasien_kabupaten_id' => array(
            'label' => 'Kabupaten/Kota',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pasien_kecamatan_id' => array(
            'label' => 'Kecamatan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pasien_kelurahan_id' => array(
            'label' => 'Kelurahan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pasien_telepon' => array(
            'label' => 'Telepon/HP',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pdf_kontak_nama' => array(
            'label' => 'Nama',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pdf_kontak_alamat' => array(
            'label' => 'Alamat',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pdf_kontak_telepon' => array(
            'label' => 'Telepon',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pdf_kontak_kota' => array(
            'label' => 'Kota',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pdf_kontak_jenis_identitas' => array(
            'label' => 'Jenis Identitas',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pdf_kontak_no_identitas' => array(
            'label' => 'Nomor Identitas',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pdf_dokter_id' => array(
            'label' => 'Dokter Pemeriksa',
            'rules' => 'required|trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pdf_dokter_dpjp_id' => array(
            'label' => 'Dokter DPJP',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pdf_asuransi_id' => array(
            'label' => 'Nama Penjamin',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pdf_perusahaan_id' => array(
            'label' => 'Perusahaan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel',
            'extra' => array('disabled' => 'disabled')
        ),
        'pdf_no_surat_jaminan' => array(
            'label' => 'No. Surat Penjamin',
            'rules' => 'trim',
            'helper' => 'form_inputlabel',
            'extra' => array('disabled' => 'disabled')
        ),
        'pdf_no_kartu' => array(
            'label' => 'Nomor Kartu',
            'rules' => 'trim',
            'helper' => 'form_inputlabel',
            'extra' => array('disabled' => 'disabled')
        ),
        'pdf_tanggal_surat_jaminan' => array(
            'label' => 'Tgl. Surat Jaminan',
            'rules' => 'trim',
            'helper' => 'form_inputlabel',
            'extra' => array('disabled' => 'disabled', 'autocomplete' => 'off')
        ),
        'pdf_poli_id' => array(
            'label' => 'Poliklinik',
            'rules' => 'required|trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pdf_jenis_kedatangan' => array(
            'label' => 'Jenis Kedatangan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'pdf_rujukan_dari_id' => array(
            'label' => 'Instansi Perujuk',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel',
            'extra' => array('disabled' => 'disabled')
        ),
        'pdf_rujukan_nama' => array(
            'label' => 'Petugas Perujuk',
            'rules' => 'trim',
            'helper' => 'form_inputlabel',
            'extra' => array('disabled' => 'disabled')
        ),
        'pdf_rujukan_tanggal' => array(
            'label' => 'Tanggal Rujukan',
            'rules' => 'trim',
            'helper' => 'form_inputlabel',
            'extra' => array('disabled' => 'disabled', 'autocomplete' => 'off')
        ),
        'pdf_penanggung_id' => array(
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
        $this->load->model('provinsi_model');
        $this->load->model('kabupaten_model');
        $this->load->model('kecamatan_model');
        $this->load->model('kelurahan_model');
        $this->load->model('pasien_model');
        $this->load->model('rujukan_model');
        $this->load->model('tipe_pasien_model');
        $this->load->model('pegawai_model');
        $this->load->model('perusahaan_model');
        $this->load->model('poli_model');
        $this->load->model('asuransi_model');
        $this->load->model('penanggung_model');
        $this->load->model('pendaftaran_model');
        $this->load->model('reservasi_model');
        // $this->load->model('pelayanan/pasien_rwj_model');
        if ($this->input->post('cancel-button'))
            redirect('pendaftaran');
    }

    function index($noMR = '', $reservasiId = '') {
        $this->load->library('form_validation');
        
        $form = $this->form;
        // SET DEFAULT VALUE OF FORM
        $form['id']['value'] = '';
        $form['pasien_no_mr']['value'] = '[ Auto ]';
        $form['pasien_jenis_kelamin']['options'] = $this->config->item('jenis_kelamin');
        $form['pasien_golongan_darah']['options'] = $this->config->item('golongan_darah');
        $form['pasien_agama']['options'] = $this->config->item('agama');
        $form['pasien_kewarganegaraan']['options'] = $this->config->item('kewarganegaraan');
        $form['pasien_negara']['value'] = 'INDONESIA';
        $form['pdf_pendidikan_terakhir']['options'] = $this->config->item('pendidikan');
        $form['pdf_status_perkawinan']['options'] = $this->config->item('status_pernikahan');
        $form['pdf_pekerjaan']['options'] = $this->config->item('pekerjaan');
        $form['pasien_provinsi_id']['options'] = $this->provinsi_model->get_dropdown_array('nama', 'id');
        $form['pasien_provinsi_id']['value'] = 32;
        $form['pdf_jenis_kedatangan']['options'] = $this->config->item('jenis_kedatangan');
        $form['pdf_rujukan_dari_id']['options'] = $this->rujukan_model->get_dropdown_array('nama', 'id');
        $form['pasien_tipe_pasien_id']['options'] = $this->tipe_pasien_model->get_dropdown_array('nama', 'id');
        $form['pdf_asuransi_id']['options'] = $this->asuransi_model->get_dropdown_array('nama', 'id');
        $form['pdf_perusahaan_id']['options'] = $this->perusahaan_model->get_dropdown_array('nama', 'id');
        $form['pdf_poli_id']['options'] = $this->poli_model->get_dropdown_array('nama', 'id');
        $form['pdf_dokter_dpjp_id']['options'] = $this->pegawai_model->dokter_drop_options();
        $form['pdf_penanggung_id']['options'] = $this->penanggung_model->get_dropdown_array('nama', 'id');
        $form['pdf_kontak_jenis_identitas']['options'] = $this->config->item('jenis_identitas');

        $this->data['pasien_lahir_tanggal'] = 0;
        $this->data['pasien_lahir_bulan'] = 0;
        $this->data['pasien_lahir_tahun'] = 0;
        $this->data['pasien_umur_tahun'] = 0;
        $this->data['pasien_umur_bulan'] = 0;
        $this->data['pasien_umur_hari'] = 0;
        $this->data['provinsi_id'] = $this->config->item('provinsi_id');
        $this->data['kabupaten_id'] = $this->config->item('kabupaten_id');
        $this->data['kecamatan_id'] = $this->config->item('kecamatan_id');
        $this->data['kelurahan_id'] = $this->config->item('kelurahan_id');

        // get data reservasi
        $reservasi = $this->reservasi_model->get_by_id($reservasiId);
        if($reservasi){
            $form['pdf_poli_id']['value'] = $reservasi->poli_id;
            $this->data['dokter_id'] = $reservasi->dokter_id;
        }
        
        // cak pasien by no mr
        $pasien = $this->pasien_model->get_by_params(array('no_mr' => $noMR));
        if($pasien){
            $form['pasien_id']['value'] = $pasien->id;
            $form['pasien_no_mr']['value'] = $pasien->no_mr;
            $form['pasien_tipe_pasien_id']['value'] = $pasien->tipe_pasien_id;
            $form['pasien_nama']['value'] = $pasien->nama;
            $form['pasien_jenis_kelamin']['value'] = $pasien->jenis_kelamin;
            $form['pasien_tempat_lahir']['value'] = $pasien->tempat_lahir;
            $form['pasien_tanggal_lahir']['value'] = $pasien->tanggal_lahir;
            $form['pasien_agama']['value'] = $pasien->agama;
            $form['pasien_no_identitas']['value'] = $pasien->no_identitas;
            $form['pasien_alamat']['value'] = $pasien->alamat;
            $form['pasien_alamat_daerah']['value'] = $pasien->alamat_daerah;
            $form['pasien_golongan_darah']['value'] = $pasien->golongan_darah;
            $form['pasien_kewarganegaraan']['value'] = $pasien->kewarganegaraan;
            $form['pasien_negara']['value'] = $pasien->negara;
            $form['pdf_status_perkawinan']['value'] = $pasien->status_perkawinan;
            $form['pdf_pendidikan_terakhir']['value'] = $pasien->pendidikan_terakhir;
            $form['pdf_pekerjaan']['value'] = $pasien->pekerjaan;
            $form['pdf_pekerjaan_nama_tempat']['value'] = $pasien->pekerjaan_nama_tempat;
            $form['pdf_pekerjaan_nip']['value'] = $pasien->pekerjaan_nip;
            $form['pdf_pekerjaan_golongan']['value'] = $pasien->pekerjaan_golongan;
            $form['pasien_email']['value'] = $pasien->email;
            $form['pasien_telepon']['value'] = $pasien->email;
            $form['pasien_nama_ayah']['value'] = $pasien->nama_ayah;
            $form['pasien_nama_ibu']['value'] = $pasien->nama_ibu;
            $form['pasien_pekerjaan_orang_tua']['value'] = $pasien->pekerjaan_orang_tua;
            $form['pasien_provinsi_id']['value'] = $pasien->provinsi_id;

            $arrTglLahir = explode('-', $pasien->tanggal_lahir);
            $tglLahir = !(empty($arrTglLahir[2])) ? $arrTglLahir[2] : 0 ;
            $blnLahir = !(empty($arrTglLahir[1])) ? $arrTglLahir[1] : 0 ;
            $thnLahir = !(empty($arrTglLahir[0])) ? $arrTglLahir[0] : 0 ;

            $this->data['pasien_lahir_tanggal'] = $tglLahir;
            $this->data['pasien_lahir_bulan'] = $blnLahir;
            $this->data['pasien_lahir_tahun'] = $thnLahir;
            $this->data['pasien_umur_tahun'] = 0;
            $this->data['pasien_umur_bulan'] = 0;
            $this->data['pasien_umur_hari'] = 0;
            $this->data['provinsi_id'] = $pasien->provinsi_id;
            $this->data['kabupaten_id'] = $pasien->kabupaten_id;
            $this->data['kecamatan_id'] = $pasien->kecamatan_id;
            $this->data['kelurahan_id'] = $pasien->kelurahan_id;
        }

        $this->form_validation->init($form);
        
        if ($this->form_validation->run()) {
            $pasien         = $this->_do_insert_pasien();
            $pendaftaran    = $this->_do_insert_pendaftaran($pasien);
            redirect('pendaftaran/info/view/'.$pendaftaran->id);
        }

        $this->data['form'] = $this->form_validation;
        $this->template
                ->set_title('Pendaftaran Pasien')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('pendaftaran')
                ->build('pendaftaran/home', $this->data);
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
