<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class MY_Controller extends CI_Controller
{
    public $global_data;
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance(); //MENGGANTI $this

        $CI->global_data = [
            "app_name"          => $_ENV["APP_NAME"],
            "app_complete_name" => $_ENV["APP_ALIAS_NAME"],
            "CI"                => $CI,
            "_session"          => $CI->session->userdata(SESSION),
            "title"             => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "module_name"       => $this->router->fetch_class(),
            "SidebarType"       => "full", // You can change it full / mini-sidebar / iconbar / overlay
        ];
    }

    public function loadView($view = NULL, $local_data = array(), $asData = FALSE)
    {
        $data = array_merge($this->global_data, $local_data);
        return $this->load->view($view, $data, $asData);
    }
}
