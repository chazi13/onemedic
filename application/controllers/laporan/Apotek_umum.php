<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Apotek_umum extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
    }
    
    public function index(){
        $tglAwal = date("Y-m-d", strtotime("-1 month"));
        $tglAkhir = date("Y-m-d");
        
        $this->data['tglAwal']  = $tglAwal;
        $this->data['tglAkhir'] = $tglAkhir;
        $this->data['optionsShift'] = array_merge(array('' => '( Kosong )'), $this->config->item('shift_jam_kerja') );
        $this->template
                ->set_title('Laporan Penjualan Apotek Umum')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_js('plugins/bootstrap-datepicker/js/bootstrap-datepicker')
                ->set_js('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min')
                ->set_css('../js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3')
                ->set_layout('laporan')
                ->build('laporan/apotek_umum-list', $this->data);
    }

    function datatables(){
        $this->load->library('datatables');
        $tglAwal = $this->input->post('tanggal_awal');
        $tglAkhir = $this->input->post('tanggal_akhir');
        
        $params = array(
            "ksr_umum_penjualan.created BETWEEN '".$tglAwal."' AND '".$tglAkhir."' " => null,
        );
        if(!empty($shift)){
            $arrShift = explode('-', $shift);
            $params["ksr_umum_penjualan.created::TIME BETWEEN '".$arrShift[0].":00' AND '".$arrShift[1].":00'"] = NULL;
        }
        
        $this->datatables
           ->select('ksr_umum_penjualan.id,'
           . 'ksr_umum_penjualan.created::DATE AS tanggal, '
           . 'ksr_umum_penjualan.no_reg, '
           . 'ksr_umum_penjualan.nama, '
           . 'ksr_umum_penjualan.asal_resep, '
           . 'ksr_umum_penjualan.total_tagihan,'
           . 'mst_kartu_bayar.nama AS cara_bayar,'
           . 'ksr_umum_penjualan_item.item_nama,'
           . 'ksr_umum_penjualan_item.banyaknya,'
           . 'ksr_umum_penjualan_item.satuan_nama', FALSE)
           ->where($params, FALSE, FALSE)
           ->join('mst_kartu_bayar', 'mst_kartu_bayar.id = ksr_umum_penjualan.id_kartu_bayar', 'LEFT')
            ->join('ksr_umum_penjualan_item', 'ksr_umum_penjualan_item.ksr_umum_penjualan_id = ksr_umum_penjualan.id')
           ->from('ksr_umum_penjualan');
        echo $this->datatables->generate();
    }
    
    public function download_excel(){
        return false;
    }
}    