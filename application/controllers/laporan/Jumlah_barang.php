<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jumlah_barang extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('jenis_barang_model');
        $this->load->model('kondisi_barang_model');
    }
    
    public function index($jenis=0, $kondisi=0){
        $this->data['optionsJenisBarang'] = $this->jenis_barang_model->drop_options_tree();
        $this->data['optionsKondisiBarang'] = $this->kondisi_barang_model->get_dropdown_array('nama', 'id');
        $this->data['jenis'] = $jenis;
        $this->data['kondisi'] = $kondisi;
        $this->data['jenisBarang'] = $this->jenis_barang_model->get_all_by_params();
        $this->template
                ->set_title('Laporan Jumlah Barang')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('lap_aset')
                ->build('laporan/jumlah_barang', $this->data);
    }
    
    public function download_excel(){
    }
}    