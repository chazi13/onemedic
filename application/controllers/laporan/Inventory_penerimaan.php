<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Inventory_penerimaan extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('supplier_model');
        // $this->load->model('lokasi_barang_model');
        // $this->load->model('kondisi_barang_model');
        // $this->load->model('pemeliharaan_model');
    }

    public function index(){
        $this->data['tgl_awal'] = date('Y-m-d');
        $this->data['tgl_akhir'] = date('Y-m-d');
        $this->data['tanggal_awal_top'] = date('Y-m-d');
        $this->data['tanggal_akhir_top'] = date('Y-m-d');
        $this->data['supplierId'] = 0;
        $this->data['optionsSupplier'] = $this->supplier_model->get_dropdown_array('nama', 'id');
        // $this->data['optionsJenisBarang'] = $this->jenis_barang_model->drop_options_tree();
        // $this->data['optionsLokasiBarang'] = $this->lokasi_barang_model->get_dropdown_array('nama', 'id');
        // $this->data['optionsKondisiBarang'] = $this->kondisi_barang_model->get_dropdown_array('nama', 'id');
        $this->template
                ->set_title('Laporan Penerimaan Barang Farmasi')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('lap_aset')
                ->build('laporan/inventory/penerimaan-list', $this->data);
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        
        $params['status']   = 1;
        // $unitId = $this->input->post('unit_id');
        $jenisBarangId = $this->input->post('jenis_barang_id');
        $lokasiBarangId = $this->input->post('lokasi_barang_id');
        $tglAwal = $this->input->post('tgl_awal');
        $tglAkhir = $this->input->post('tgl_akhir');

        if ($jenisBarangId > 0) {
            $jenisBarang = $this->jenis_barang_model->get_by_params(array('id' => $jenisBarangId));
            $params["jenis_barang_kode LIKE '".$jenisBarang->kode."%'"] = null;
        }
        if ($lokasiBarangId > 0) {
            $params['lokasi_barang_id'] = $lokasiBarangId;
        }
        // if ($unitId > 0) {
        //     $params['unit_id'] = $unitId;
        // }else{
        //     $params['unit_id'] = $this->session->userdata('unit_id');
        // }
        if(($tglAwal != '') || ($tglAkhir != '')){
            $params["tanggal_pemeliharaan BETWEEN '".$tglAwal."' AND '".$tglAkhir."' "] = null;
        }

        $this->datatables
                ->select("tanggal_pemeliharaan, barang_kode, barang_nama, kondisi_nama, catatan", FALSE)
                ->from('asset_pemeliharaan')
                ->where($params, FALSE);
        echo $this->datatables->generate();
    }

    public function download_excel(){
    }
}    


// class Inventory_penerimaan extends Admin_Controller {
//     function __construct() {
//         parent::__construct();
//         $this->load->helper('form');
//         $this->load->library('utility');
//         $this->load->model('unit_model');
//         $this->load->model('auth/user_model');
//     }
    
//     public function index(){
//         $this->template
//                 ->set_css('theme-default/libs/bootstrap-datepicker/datepicker3')
//                 ->set_css('theme-default/libs/DataTables/jquery.dataTables')
//                 ->set_css('theme-default/libs/DataTables/extensions/dataTables.colVis')
//                 ->set_css('theme-default/libs/DataTables/extensions/dataTables.tableTools')
//                 ->set_js('libs/DataTables/jquery.dataTables.min')
//                 ->set_js('libs/DataTables/extensions/ColVis/js/dataTables.colVis.min', true)
//                 ->set_js('libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min', true)
//                 ->set_js('libs/bootstrap-datepicker/bootstrap-datepicker', true)
//                 ->build('inventory/penerimaan-list');
//     }
    
//     function datatables(){
//         }
    
//     public function download_excel(){
//     }
// }    
// /* End of file laporan_kunjungan_pasien.php */
// /* Location: ./application/modules/laporan/controllers/laporan_kunjungan_pasien.php */