<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class APP_Controller extends MY_Controller
{
    public $userData;
    public function __construct()
    {
        parent::__construct();

        //TODO : INI DISINI LEBIH BAIK DI KASIH VALIDASI SUDAH LOGIN APA BELUM GITU GITU
        if (!$this->session->has_userdata(SESSION)) {
            redirect(base_url("auth"));
        }       

        $params  = [
            "role"  => $this->session->userdata(SESSION)["role"]
        ];
        $this->load->library("Menu", $params);
    }

    protected function loadViewBack($view = NULL, $local_data = array(), $asData = FALSE)
    {
        if (!file_exists(APPPATH . "views/$view" . ".php")) {
            die("ga ada template " . APPPATH . "views/$view");
            // show_404();
        }
        $this->loadView("template/header", $local_data, $asData);
        $this->loadView("template/sidebar", $local_data, $asData);
        $this->loadView($view, $local_data, $asData);
        $this->loadView("template/footer", $local_data, $asData);
    }
}
