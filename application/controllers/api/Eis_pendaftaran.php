<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Eis_pendaftaran extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function pasien_per_periode_get()
    { 
        $tglAwal = $this->get('tanggal_awal');
        $tglAkhir = $this->get('tanggal_akhir');
        $poliId = $this->get('poli_id');
        $dokterId = $this->get('dokter_id');
        

        $pid = 1;

        if ($pid <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_OK); // BAD_REQUEST (400) being the HTTP response code
        }else{
            $params = "created >= '".$tglAwal."' AND created <= '".$tglAkhir."'";
            if($poliId){
                $params .= " AND poli_id = ".$poliId;
            }
            if($dokterId){
                $params .= " AND dokter_id = ".$dokterId;
            }
            $rows  = $this->db->query("SELECT COUNT(id) AS jumlah, poli_nama FROM pdf_pasien WHERE $params GROUP BY poli_nama ORDER BY poli_nama ASC")->result();

            if (!empty($rows))
            {
                $arrLabel = array();
                foreach($rows as $row){
                    $arrLabel[] = $row->poli_nama;
                }
                $arrValue = array();
                foreach($rows as $row){
                    $arrValue[] = $row->jumlah;
                }

                $this->set_response([
                    'data' => array('key' => $arrLabel, 'val' => $arrValue),
                    'status' => TRUE,
                    'message' => 'Success'
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'data' => FALSE,
                    'status' => FALSE,
                    'message' => 'Data could not be found'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }

        }
    }

    public function pasien_per_bulan_get()
    { 
        $tahun = $this->get('tahun');
        $bulan = $this->get('bulan');

        $pid = 1;

        if ($pid <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_OK); // BAD_REQUEST (400) being the HTTP response code
        }else{
            $params = "date_part('year', created) = '".$tahun."' AND date_part('month', created)= '".$bulan."'";
            $rows  = $this->db->query("SELECT COUNT(id) AS jumlah, poli_nama FROM pdf_pasien WHERE $params GROUP BY poli_nama ORDER BY poli_nama ASC")->result();

            if (!empty($rows))
            {
                $arrLabel = array();
                foreach($rows as $row){
                    $arrLabel[] = $row->poli_nama;
                }
                $arrValue = array();
                foreach($rows as $row){
                    $arrValue[] = $row->jumlah;
                }

                $this->set_response([
                    'data' => array('key' => $arrLabel, 'val' => $arrValue),
                    'status' => TRUE,
                    'message' => 'Success'
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'data' => FALSE,
                    'status' => FALSE,
                    'message' => 'Data could not be found'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }

        }
    }

    public function pasien_per_bulan_tahun_per_poli_get()
    { 
        $this->load->library('utility');
        $bulanAwal = $this->get('bulan_awal');
        $tahunAwal = $this->get('tahun_awal');
        $bulanAkhir = $this->get('bulan_akhir');
        $tahunAkhir = $this->get('tahun_akhir');
        

        $pid = 1;

        if ($pid <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_OK); // BAD_REQUEST (400) being the HTTP response code
        }else{
            $pTglAwal = '01-'.$bulanAwal.'-'.$tahunAwal;
            $pTglAkhir = '01-'.$bulanAkhir.'-'.$tahunAkhir;
            $params = " created BETWEEN '".$pTglAwal."' AND '".$pTglAkhir."'";
            if($this->get('poli_id') > 0){
                $params .= ' AND poli_id = '.$this->get('poli_id');
            }
            $rows  = $this->db->query("SELECT COUNT(id) AS jumlah, date_part('month', created) AS bulan, date_part('year', created) AS tahun  FROM pdf_pasien WHERE $params GROUP BY date_part('month', created),date_part('year', created) ORDER BY date_part('year', created),date_part('month', created)")->result();

            if (!empty($rows))
            {
                $arrLabel = array();
                foreach($rows as $row){
                    $arrLabel[] = $this->utility->bulan_singkat($row->bulan).' '.$row->tahun;
                }
                $arrValue = array();
                foreach($rows as $row){
                    $arrValue[] = $row->jumlah;
                }

                $this->set_response([
                    'data' => array('key' => $arrLabel, 'val' => $arrValue),
                    'status' => TRUE,
                    'message' => 'Success'
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'data' => FALSE,
                    'status' => FALSE,
                    'message' => 'Data could not be found'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }

        }
    }

}
