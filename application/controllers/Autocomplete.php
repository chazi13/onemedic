<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Autocomplete extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pasien_model');
        $this->load->model('farmasi_model');
    }
    
    function pasien($param = array()) {
        $data = $this->pasien_model->autocomplete();
        if(empty($data)){
            $data = $this->pasien_model->autocomplete();
        }
        echo json_encode($data);
    }

    function farmasi($param = array()) {
        $data = $this->farmasi_model->autocomplete($param);
        echo json_encode($data);
    }


}