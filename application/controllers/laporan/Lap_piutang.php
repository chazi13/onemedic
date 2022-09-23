<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lap_piutang extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('unit_model');
        $this->load->model('auth/user_model');
        
    }
    
    public function index(){
        $this->template
                ->set_css('theme-default/libs/bootstrap-datepicker/datepicker3')
                ->set_css('theme-default/libs/DataTables/jquery.dataTables')
                ->set_css('theme-default/libs/DataTables/extensions/dataTables.colVis')
                ->set_css('theme-default/libs/DataTables/extensions/dataTables.tableTools')
                ->set_js('libs/DataTables/jquery.dataTables.min')
                ->set_js('libs/DataTables/extensions/ColVis/js/dataTables.colVis.min', true)
                ->set_js('libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min', true)
                ->set_js('libs/bootstrap-datepicker/bootstrap-datepicker', true)
                ->build('laporan/lap_piutang-list');
    }
    
    function datatables(){
        }
    
    public function download_excel(){
    }
}    
/* End of file laporan_kunjungan_pasien.php */
/* Location: ./application/modules/laporan/controllers/laporan_kunjungan_pasien.php */