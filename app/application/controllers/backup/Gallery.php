<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gallery extends CI_Controller
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
        $galery             = $this->galery->order_by("id", "RANDOM")->limit(50)->get_all()      ?: [];

        $data   = [
            "galery"                => $galery,
        ];

        $this->load->view("homepage/gallery", $data);
    }
}
