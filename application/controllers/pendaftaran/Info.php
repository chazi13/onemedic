<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Info extends Admin_Controller {

    protected $form = array(
        'id' => array(
            'helper' => 'form_hidden'
        ),
        'no_mr' => array(
            'label' => 'No MR',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'nama' => array(
            'label' => 'Nama Lengkap',
            'rules' => 'required|trim',
            'helper' => 'form_inputlabel'
        ),
        'jenis_kelamin' => array(
            'label' => 'Jenis Kelamin',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel',
        ),
        'tempat_lahir' => array(
            'label' => 'Tempat Lahir',
            'rules' => 'trim|required',
            'helper' => 'form_inputlabel'
        ),
        'tanggal_lahir' => array(
            'label' => 'Tanggal Lahir',
            'rules' => 'trim|required',
            'helper' => 'form_hidden'
        ),
        'golongan_darah' => array(
            'label' => 'Golongan Darah',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'no_identitas' => array(
            'label' => 'Nomor KTP/SIM/KTA',
            'rules' => 'trim|required',
            'helper' => 'form_inputlabel'
        ),
        'agama' => array(
            'label' => 'Agama',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'kewarganegaraan' => array(
            'label' => 'Kewarganegaraan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'negara' => array(
            'label' => 'Negara',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'alamat' => array(
            'label' => 'Alamat',
            'rules' => 'required|trim',
            'helper' => 'form_inputlabel'
        ),
        'alamat_daerah' => array(
            'label' => 'Kota/Daerah',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'email' => array(
            'label' => 'Email',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'nama_ayah' => array(
            'label' => 'Nama Ayah',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'nama_ibu' => array(
            'label' => 'Nama Ibu',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        ),
        'pekerjaan_orang_tua' => array(
            'label' => 'Pekerjaan Orang Tua',
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
        'kelurahan_id' => array(
            'label' => 'Kelurahan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'telepon' => array(
            'label' => 'Telepon/HP',
            'rules' => 'trim',
            'helper' => 'form_inputlabel'
        )
    ); 

    function __construct() {
        parent::__construct();

        // $this->load->model('aplikasi_lama/v3_pendaftaran_model');
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
        // $this->load->model('pelayanan/pasien_rwj_model');
    }

    function view($id){
        $pendaftaran = $this->pendaftaran_model->get_by_id($id);
        $this->data['pendaftaran'] = $pendaftaran;
        $this->data['pasien'] = $this->pasien_model->get_by_params(array('no_mr' => $pendaftaran->no_mr));
        $this->template
                ->set_title('View Pendaftaran Pasien')
                ->set_layout('pendaftaran')
                ->build('pendaftaran/pendaftaran-view', $this->data);
    }

    function kartu_pasien($id) 
    {
        $this->load->library('utility');
        $this->load->model('auth/user_model');
        $this->load->model('unit_model');
        $user = $this->user_model->get_by_id($this->session->userdata('auth_user'));
        $unit = $this->unit_model->get_by_id(1);

        $this->data['user'] = $user;
        $this->data['unit'] = $unit;

        $pasien = $this->pasien_model->get_by_id((int) $id);
        $this->data['rowData'] = $pasien;

        $date = date_create($this->data['rowData']->created);
        $this->data['rowData']->created = date_format($date, 'y') . ' ' . $this->utility->bulan(date_format($date, 'm')) . ' ' . date_format($date, 'Y');
        $this->load->view('pendaftaran/kartu_pasien', $this->data);
    }
    
    function form_pemeriksaan($id) {

        $this->load->library('utility');
        $this->load->model('auth/user_model');
        $this->load->model('unit_model');
        $user = $this->user_model->get_by_id($this->session->userdata('auth_user'));
        $unit = $this->unit_model->get_by_id(1);

        $this->data['user'] = $user;
        $this->data['unit'] = $unit;

        $this->data['rowData'] = $this->pendaftaran_model->get_by_id((int) $id);
        $date = date_create($this->data['rowData']->created);
        $this->data['rowData']->created = date_format($date, 'y') . ' ' . $this->utility->bulan(date_format($date, 'm')) . ' ' . date_format($date, 'Y');
        $this->load->view('pendaftaran/form-pemeriksaan', $this->data);
    }

    function cari(){
        $this->load->library('utility');
        $key = strtolower($this->input->post('search-pasien'));
        $rows = null;
        if($key){
            $rows = $this->pasien_model->get_all_by_params(array("LOWER(no_mr) LIKE '%".$key."%' OR LOWER(nama) LIKE '%".$key."%' OR LOWER(alamat) LIKE '%".$key."%' " => null ));
        }
        $this->data['rows'] = $rows;

        if (!$this->input->is_ajax_request()) {
            $this->template
                ->set_layout('pendaftaran')
                ->build('pendaftaran/cari', $this->data);
        }else{
            if($rows and (count($rows) == 1)){
                redirect('pendaftaran/info/pasien/'.$rows[0]->no_mr);
                // $this->pasien($rows[0]->no_mr);
                // $pasien = $this->pasien_model->get_by_params(array('no_mr' => $rows[0]->no_mr));
                // $history = $this->pendaftaran_model->get_all_by_params(array('no_mr' => $rows->no_mr));
                // $this->load->library('form_validation');
                // $form = $this->form;
                // $this->form_validation->init($form);
                // $this->form_validation->set_default($pasien);
                // if ($this->form_validation->run())
                // {
                //     // // $this->user_model->update($id, $this->form_validation->get_values());
                //     // $this->template->add_message('info', lang('user_updated'));
                // }
                // $this->load->view('pendaftaran/pasien-profile',array('pasien' => $pasien, 'history' => $history, 'form' => $this->form_validation));
            }else{
                $this->load->view('pendaftaran/cari', $this->data);
            }
        }
    }

    function pasien($noMr = '') {
        if($noMr !== ''){
            $pasien = $this->pasien_model->get_by_params(array('no_mr' => $noMr));
            if($pasien){
                $history = $this->pendaftaran_model->get_all_by_params(array('no_mr' => $noMr));
                $this->load->library('form_validation');
                $form = $this->form;
                $form['jenis_kelamin']['options'] = $this->config->item('jenis_kelamin');
                $form['golongan_darah']['options'] = $this->config->item('golongan_darah');
                $form['agama']['options'] = $this->config->item('agama');
                $form['kewarganegaraan']['options'] = $this->config->item('kewarganegaraan');
                $form['negara']['value'] = 'INDONESIA';
                $this->form_validation->init($form);
                $this->form_validation->set_default($pasien);
                if ($this->form_validation->run())
                {
                    $this->pasien_model->update($pasien->id, $this->form_validation->get_values());
                    $this->template->add_message('info', lang('user_updated'));
                    redirect('pendaftaran/info/pasien/'.$noMr);
                }
                if (!$this->input->is_ajax_request()) {
                    $this->template
                        ->set_title('Profile Pasien')
                        ->set_layout('pendaftaran')
                        ->build('pendaftaran/pasien-profile',array('pasien' => $pasien, 'history' => $history, 'form' => $this->form_validation));
                }else{
                    $this->load->view('pendaftaran/pasien-profile',array('pasien' => $pasien, 'history' => $history, 'form' => $this->form_validation));
                }
            }else{
                $this->template->add_message('info', 'Pasien tidak ditemukan.');
                redirect('pendaftaran/info/pasien');
            }
        }else{
            $this->template
                ->set_title('Data Pasien')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_layout('pendaftaran')
                ->build('pendaftaran/pasien-list');
        }
        
    }

    function pasien_datatables_source(){
        $this->load->library('datatables');
        $this->datatables
           ->select('id, no_mr, nama, alamat, nama_ayah, nama_ibu', FALSE)
           ->where('status', 1)
           ->from('mst_pasien');
        echo $this->datatables->generate();
    }


}
