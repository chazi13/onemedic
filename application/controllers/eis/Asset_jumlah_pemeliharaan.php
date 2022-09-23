<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Asset_jumlah_pemeliharaan extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('utility');
        $this->load->model('jenis_barang_model');
        $this->load->model('unit_model');
    }
    
    public function index($jenis=0, $kondisi=0){
        $this->data['optionsJenisBarang'] = $this->jenis_barang_model->drop_options_tree();
        $this->data['optionsUnit'] = $this->unit_model->get_dropdown_array('nama', 'id', null, null, 'nama', 'asc');
        $this->template
                ->set_title('Grafik Jumlah Pemeliharan ')
                ->set_js('plugins/tables/datatables/dataTables.min')
                ->set_js('plugins/select2/js/select2')
                ->set_layout('lap_aset')
                ->build('eis/asset_jumlah_pemeliharaan', $this->data);
    }

    function sourcedata() {
        // get -12 month
        $bulanIni = date('Y-m');
        $bulanLalu = date('Y-m', strtotime('-3 months', strtotime($bulanIni))); 
        $kodeUnit = '';
        $unitId = $this->input->post('unit_id');
        if($unitId > 0){
            $unit = $this->unit_model->get_by_id($unitId);
            $kodeUnit = (int) $unit->kode;
        }

        $kodeJenisBarang = '';
        $jenisBarangId = $this->input->post('jenis_barang_id');
        if ($jenisBarangId > 0) {
            $jenisBarang = $this->jenis_barang_model->get_by_id($jenisBarangId);
            $kodeJenisBarang = $jenisBarang->kode;
        }
        $kodeFilter = $kodeUnit.$kodeJenisBarang;
        if($kodeFilter != ''){
            $kodeFilter = " AND barang_kode LIKE '".$kodeFilter."%'";
        }
        
        $rows = $this->db->query("
                    SELECT
                        SUBSTRING(tanggal_pemeliharaan::TEXT,1,7) AS bulan,
                        COUNT(id) AS jumlah
                    FROM
                        asset_pemeliharaan
                    WHERE status = '1' " . $kodeFilter . " AND tanggal_pemeliharaan >= '".$bulanLalu."-01'
                    GROUP BY tanggal_pemeliharaan
                    ORDER BY
                    tanggal_pemeliharaan ASC
            ")->result();
        $arrLabels = array();
        $arrValues = array();
        if($rows){
            foreach($rows as $row){
                $arrLabels[] = $row->bulan;
                $arrValues[] = $row->jumlah;
            }
        }

        header("Content-Type: application/json; charset=UTF-8");
        $data = array(
            'title' => 'Grafik Pemeliharaan Aset Dari Tanggal 01-'.date('m-Y', strtotime('-12 months', strtotime($bulanIni))).' s/d '.date('Y-m-d'),
            'labels' => $arrLabels,
            'values' => $arrValues,
        );
        echo json_encode($data);
    }
    
}    