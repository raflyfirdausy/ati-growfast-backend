<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model([
        //     "User_model"    => "user"
        // ]);
    }

    public function index()
    {
        redirect(base_url("auth/login"));
    }

    public function login()
    {
        if ($this->session->has_userdata(SESSION)) {
            redirect(base_url("dashboard"));
        }

        $data = [
            "URL_LOGIN" => base_url("auth/login-proses"),
        ];
        $this->loadView('auth/login', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url("auth"));
    }


    public function login_proses()
    {
        $username   = $this->input->post('username');
        $password   = md5($this->input->post('password'));

        $cekAkun  = $this->user->where(["LOWER(username)"   => strtolower($username)])->get();

        if ($cekAkun) {
            if ($password == $cekAkun['password']) {
                $this->session->set_userdata(SESSION, $cekAkun);
                redirect("dashboard");
            } else {
                $this->session->set_flashdata("gagal", "Password yang anda masukan tidak sesuai!");
                redirect(base_url("auth/login"));
            }
        } else {
            $this->session->set_flashdata("gagal", "Username yang anda masukan tidak sesuai!");
            redirect(base_url("auth/login"));
        }
    }

    public function cek()
    {
        phpinfo();
        die;
    }
}
