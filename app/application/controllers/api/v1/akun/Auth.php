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

        $this->load->model([
            "User_model"    => "user"
        ]);
    }

    function uuidv4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    private function getUser($kondisi)
    {
        $_user      = $this->user
            ->where($kondisi)
            ->with_instansi("fields:nama,no_telp,direktur")
            ->with_prov("fields:nama")
            ->with_kab("fields:nama")
            ->with_kec("fields:nama")
            ->with_kel("fields:nama")
            ->get();

        if (!$_user) {
            return FALSE;
        }
        if (isset($_user["password"])) {
            unset($_user["password"]);
        }

        return $_user;
    }

    public function index_get()
    {
        $_user = $this->getUser(["uuid" => getApiKey()]);
        if (!$_user) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_NOT_FOUND,
                "message"       => "Data profile tidak ditemukan!",
                "data"          => getApiKey()
            ], REST_Controller::HTTP_OK);
        }

        if (isset($_user["password"])) {
            unset($_user["password"]);
        }

        $_user["foto"] = base_url(LOKASI_PROFILE) . (($_user["foto"] != null) ? $_user["foto"] : "default.jpg");
        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "OK",
            "data"          => $_user
        ], REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $config = [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required',
            ],
        ];

        $this->form_validation->set_rules($config);
        $run    = $this->form_validation->run();

        if (!$run) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_PRECONDITION_FAILED,
                "message"       => "Terjadi kesalahan. Keterangan : " . validationError($this->form_validation->error_array()),
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        $username       = $this->input->post("username");
        $password       = $this->input->post("password");
        $_user = $this->getUser([
            "username"  => $username,
            "password"  => md5($password)
        ]);

        if (!$_user) {
            return $this->response([
                "status"       => true,
                "code"         => REST_Controller::HTTP_NOT_FOUND,
                "message"      => "Username atau password yang kamu masukan salah. Silahkan coba lagi",
                "data"         => NULL
            ], REST_Controller::HTTP_OK);
        }

        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "OK",
            "data"          => $_user
        ], REST_Controller::HTTP_OK);
    }
}
