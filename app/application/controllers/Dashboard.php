<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends APP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([]);
    }

    public function index()
    {

        $view           = "dashboard/admin";
        $data = [];
        $this->loadViewBack($view, $data);
    }
}
