<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->input->post())) {
            $inputFromJson = file_get_contents('php://input');
            $_POST = json_decode($inputFromJson, TRUE);
        }
    }

    public function index_post()
    {
        return $this->response([
            "status"       => true,
            "code"         => REST_Controller::HTTP_OK,
            "message"      => [
                md5(uniqid()),
                md5(uniqid()),
                md5(uniqid()),
            ],
        ], REST_Controller::HTTP_OK);
    }
}
