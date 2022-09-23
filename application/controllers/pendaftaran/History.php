<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class History extends Admin_Controller {

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
        
        $this->load->library('form_validation');
        
        $this->load->model('tipe_pasien_model');
        $this->load->model('pegawai_model');
        $this->load->model('poli_model');
        $this->load->model('provinsi_model');
        $this->load->model('kabupaten_model');
        $this->load->model('kecamatan_model');
        $this->load->model('kelurahan_model');
        $this->load->model('pasien_model');
        $this->load->model('rujukan_model');
        $this->load->model('perusahaan_model');
        $this->load->model('asuransi_model');
        $this->load->model('penanggung_model');
        $this->load->model('pendaftaran_model');
    }

    function index() {
        $this->load->library('utility');
        $this->load->helper('form');
        $this->load->model('alasan_pembatalan_registrasi_model');
        $optionsAlasanPembatalan = array();
        $rowsAlasanPembatalan = $this->alasan_pembatalan_registrasi_model->get_all();
        if(!empty($rowsAlasanPembatalan)):
            foreach ($rowsAlasanPembatalan as $rowAlasan):
                $optionsAlasanPembatalan[$rowAlasan->uraian] = $rowAlasan->uraian;
            endforeach;
        endif;
        $optionsShiftJamKerja = array(); 
        $optionsShiftJamKerja = array_merge(array('' => '(Kosong)'), $this->config->item('shift_jam_kerja')); 
        $this->data['optionsAlasanPembatalan'] = $optionsAlasanPembatalan;
        $this->data['optionsTipePasien'] = $this->tipe_pasien_model->get_dropdown_array('nama', 'id');
        $this->data['optionsShiftJamKerja'] = $optionsShiftJamKerja;
        $this->data['optionsDokter'] = $this->pegawai_model->dokter_drop_options();
        $this->data['optionsPoli'] = $this->poli_model->get_dropdown_array('nama', 'id');
        $this->template
                ->set_title('History Pendaftaran Pasien')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('pendaftaran')
                ->build('pendaftaran/pendaftaran-list', $this->data);
    }

    function datatables() {
        $tglAwal = $this->input->post('tanggal_awal');
        $tglAkhir = $this->input->post('tanggal_akhir');
        $shift = $this->input->post('shift_jam_kerja');
        $tipePasienId = $this->input->post('tipe_pasien_id');
        $poliId = $this->input->post('poli_id');
        $dokterId = $this->input->post('dokter_id');
        $params['pdf_pasien.status'] = 1;
        if(empty($tglAwal)){
            $tglAwal = date('Y-m-d');
        }
        if(empty($tglAkhir)){
            $tglAkhir = date('Y-m-d');
        }
        
        $params["pdf_pasien.created::DATE BETWEEN '".$tglAwal."' AND '".$tglAkhir."'"] = NULL;
        
        if($shift != ''){
            $shiftTmp = explode('-', $shift);
            $jamAwalShift = $shiftTmp[0].':00';
            $jamAkhirShift = $shiftTmp[1].':00';
            $params["pdf_pasien.created::TIME BETWEEN '".$jamAwalShift."' AND '".$jamAkhirShift."'"] = NULL;
        }
        
        if($poliId > 0){
            $params['pdf_pasien.poli_id'] = $poliId;
        }
        if($tipePasienId > 0){
            $params['pdf_pasien.tipe_pasien_id'] = $tipePasienId;
        }
        if($dokterId > 0){
            $params['pdf_pasien.dokter_id'] = $dokterId;
        }
        $this->load->library('datatables');
        $this->datatables
                ->select('pdf_pasien.id, '
                        . 'mst_pasien.id AS pasien_id, '
                        . 'pdf_pasien.no_reg, '
                        . 'mst_pasien.nama, '
                        . 'pdf_pasien.alamat, '
                        . 'mst_poli.nama AS poliklinik, '
                        . 'mst_pegawai.nama  AS dokter', FALSE)
                ->where($params, FALSE, FALSE)
                ->join('mst_poli', 'mst_poli.id = pdf_pasien.poli_id')
                ->join('mst_pegawai', 'mst_pegawai.id = pdf_pasien.dokter_id')
                ->from('pdf_pasien')
                ->add_column('link', '
                                <a data-toggle="tooltip" title="Kartu Pasien" data-button="dialog-kartu" href="' . site_url('pendaftaran/info/kartu_pasien') . '/$2"><i class="icon-credit-card text-info"></i></a>
                                <a data-toggle="tooltip" title="Form Pemeriksaan" data-button="dialog-form-pemeriksaan" href="' . site_url('pendaftaran/info/form_pemeriksaan') . '/$1"><i class="icon-folder text-warning"></i></a>
                                <a data-toggle="tooltip" title="Edit Registrasi" href="' . site_url('pendaftaran/history/edit') . '/$1"><i class="icon-file-text2 text-success"></i></a>
                                <a data-toggle="tooltip" title="Hapus Registrasi" data-button="batal" href="' . site_url('pendaftaran/history/delete') . '/$1"><i class="icon-cancel-square text-danger"></i></a>', 'id, pasien_id');
        $this->datatables->join('mst_pasien', 'mst_pasien.no_mr = pdf_pasien.no_mr');
        echo $this->datatables->generate();
    }
    function history_download() {
        $tglAwal = $this->input->post('tanggal_awal');
        $tglAkhir = $this->input->post('tanggal_akhir');
        $shift = $this->input->post('shift_jam_kerja');
        $tipePasienId = $this->input->post('tipe_pasien_id');
        $poliId = $this->input->post('poli_id');
        $dokterId = $this->input->post('dokter_id');
        $params['pdf_pasien.status'] = 1;
        if(empty($tglAwal)){
            $tglAwal = date('Y-m-d');
        }
        if(empty($tglAkhir)){
            $tglAkhir = date('Y-m-d');
        }
        
        $params["pdf_pasien.created::DATE BETWEEN '".$tglAwal."' AND '".$tglAkhir."'"] = NULL;
        
        if($shift != ''){
            $shiftTmp = explode('-', $shift);
            $jamAwalShift = $shiftTmp[0].':00';
            $jamAkhirShift = $shiftTmp[1].':00';
            $params["pdf_pasien.created::TIME BETWEEN '".$jamAwalShift."' AND '".$jamAkhirShift."'"] = NULL;
        }
        
        if($poliId > 0){
            $params['pdf_pasien.poli_id'] = $poliId;
        }
        if($tipePasienId > 0){
            $params['pdf_pasien.tipe_pasien_id'] = $tipePasienId;
        }
        if($dokterId > 0){
            $params['pdf_pasien.dokter_id'] = $dokterId;
        }
        $rows = $this->db
                ->select('pdf_pasien.id, '
                        . 'mst_pasien.id AS pasien_id, '
                        . 'pdf_pasien.no_reg, '
                        . 'mst_pasien.nama, '
                        . 'pdf_pasien.alamat, '
                        . 'mst_poli.nama AS poliklinik, '
                        . 'mst_pegawai.nama  AS dokter', FALSE)
                ->where($params, FALSE, FALSE)
                ->join('mst_poli', 'mst_poli.id = pdf_pasien.poli_id')
                ->join('mst_pegawai', 'mst_pegawai.id = pdf_pasien.dokter_id')
                ->join('mst_pasien', 'mst_pasien.no_mr = pdf_pasien.no_mr')
                ->get('pdf_pasien')
                ->result();
    }

    function edit($id=0){
        $this->load->library('utility');
        $pendaftaran = $this->pendaftaran_model->get_by_id($id);
        if($pendaftaran){
            $form = $this->form;
            $form['id']['value'] = '';
            $form['pasien_alamat']['rules'] = 'trim';
            $form['pasien_agama']['options'] = $this->config->item('agama');
            $form['pasien_kewarganegaraan']['options'] = $this->config->item('kewarganegaraan');
            $form['pasien_jenis_kelamin']['options'] = $this->config->item('jenis_kelamin');
            $form['pdf_status_perkawinan']['options'] = $this->config->item('status_pernikahan');
            $form['pdf_pendidikan_terakhir']['options'] = $this->config->item('pendidikan');
            $form['pdf_pekerjaan']['options'] = $this->config->item('pekerjaan');
            $form['pasien_provinsi_id']['options'] = $this->provinsi_model->get_dropdown_array('nama', 'id');
            $form['pasien_provinsi_id']['value'] = $this->config->item('provinsi_id');
            $form['pdf_jenis_kedatangan']['options'] = $this->config->item('jenis_kedatangan');
            $form['pdf_rujukan_dari_id']['options'] = $this->rujukan_model->get_dropdown_array('nama', 'id');
            $form['pasien_tipe_pasien_id']['options'] = $this->tipe_pasien_model->get_dropdown_array('nama', 'id');
            $form['pdf_asuransi_id']['options'] = $this->asuransi_model->get_dropdown_array('nama', 'id');
            $form['pdf_perusahaan_id']['options'] = $this->perusahaan_model->get_dropdown_array('nama', 'id');
            $form['pdf_poli_id']['options'] = $this->poli_model->get_dropdown_array('nama', 'id');
            $form['pdf_dokter_dpjp_id']['options'] = $this->pegawai_model->dokter_drop_options();
            $form['pdf_penanggung_id']['options'] = $this->penanggung_model->get_dropdown_array('nama', 'id');
            $form['pdf_kontak_jenis_identitas']['options'] = $this->config->item('jenis_identitas');

            $this->data['provinsi_id']  = $this->config->item('provinsi_id');
            $this->data['kabupaten_id'] = $this->config->item('kabupaten_id');
            $this->data['kecamatan_id'] = $this->config->item('kecamatan_id');
            $this->data['kelurahan_id'] = $this->config->item('kelurahan_id');
            
            $pasien = $this->pasien_model->get_by_params(array('no_mr' => $pendaftaran->no_mr));

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

            if($pasien):
                $this->data['pasien'] = $pasien;
                $this->data['pendaftaran'] = $pendaftaran;
                // set value by pasien data
                foreach($pasien as $key => $val){
                    $form['pasien_'.$key]['value'] = $val;
                }
                // set value by pendaftaran data
                foreach($pendaftaran as $keyPdf => $valPdf){
                    $form['pdf_'.$keyPdf]['value'] = $valPdf;
                }
                
                $this->data['provinsi_id'] = $pasien->provinsi_id;
                $this->data['kabupaten_id'] = $pasien->kabupaten_id;
                $this->data['kecamatan_id'] = $pasien->kecamatan_id;
                $this->data['kelurahan_id'] = $pasien->kelurahan_id;
            endif;

            $this->form_validation->init($form);
            if ($this->form_validation->run()) {
                $pendaftaran    = $this->_do_update_pendaftaran($id);
                redirect('pendaftaran/history');
            }

            $this->data['form'] = $this->form_validation;
            $this->template
                    ->set_title('Edit Pendaftaran')
                    ->set_js('plugins/select2/js/select2')
                    ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                    ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                    ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                    ->set_layout('pendaftaran')
                    ->build('pendaftaran/form-pendaftaran_edit', $this->data);

        }else{
            redirect('pendaftaran/history');
        }
    }

    function _do_update_pendaftaran($id){
        $this->load->library('form_validation');
        $form = $this->form;
        
        $this->form_validation->init($form);
        if ($this->form_validation->run()) {
            $data = $this->form_validation->get_values();
            $pendaftaran = array();
            // echo '<pre>';
            // var_dump($data);
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
                    $pendaftaran['tipe_pasien_id']      = $data['pasien_tipe_pasien_id'];
                    $pendaftaran['tipe_pasien_nama']    = $tipePasien->nama;
                    $pendaftaran['jenis_identitas']     = $data['pdf_kontak_jenis_identitas'];
                    $pendaftaran['no_identitas']        = !empty($data['pasien_no_identitas']) ? $data['pasien_no_identitas'] : '';
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
            
            $this->pendaftaran_model->update($id,$pendaftaran);
        }
    }
}
