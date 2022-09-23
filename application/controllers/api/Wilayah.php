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
class Wilayah extends REST_Controller {

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

    public function kabupaten_get()
    { 
        $pid = $this->input->get('pid');

        if ($pid <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_OK); // BAD_REQUEST (400) being the HTTP response code
        }else{

            $kabupaten  = $this->db->order_by('nama','asc')->get_where('mst_kabupaten',array('provinsi_id' => $pid))->result_array();

            if (!empty($kabupaten))
            {
                $this->set_response([
                    'data' => $kabupaten,
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

    public function kecamatan_get()
    { 
        $pid = $this->input->get('pid');

        if ($pid <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_OK); // BAD_REQUEST (400) being the HTTP response code
        }else{

            $kecamatan  = $this->db->order_by('nama','asc')->get_where('mst_kecamatan',array('kabupaten_id' => $pid))->result_array();

            if (!empty($kecamatan))
            {
                $this->set_response([
                    'data' => $kecamatan,
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

    public function kelurahan_get()
    { 
        $pid = $this->input->get('pid');

        if ($pid <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_OK); // BAD_REQUEST (400) being the HTTP response code
        }else{

            $kelurahan  = $this->db->order_by('nama','asc')->get_where('mst_kelurahan',array('kecamatan_id' => $pid))->result_array();

            if (!empty($kelurahan))
            {
                $this->set_response([
                    'data' => $kelurahan,
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
