<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Home extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->input->post())) {
            $inputFromJson = file_get_contents('php://input');
            $_POST = json_decode($inputFromJson, TRUE);
        }
    }

    public function index_get()
    {
        return $this->response([
            "status"       => true,
            "code"         => REST_Controller::HTTP_OK,
            "message"      => "RAFLY WAS HERE !!",
        ], REST_Controller::HTTP_OK);
    }
}
