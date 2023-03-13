<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tentang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Galery_model"          => "galery",
            "ProdukView_model"      => "vProduk",
            "ProdukGambar_model"    => "produkGambar",
            "Kategori_model"        => "kategori"
        ]);
    }

    public function index()
    {
        $data   = [
            "title" => "Tentang Ayunda Tour"
        ];

        $this->load->view("homepage/tentang", $data);
    }
}
