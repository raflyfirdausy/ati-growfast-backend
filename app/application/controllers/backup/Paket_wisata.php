<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paket_wisata extends CI_Controller
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

        $rekomendasiWisata  = $this->vProduk->order_by("id", "RANDOM")->get_all()    ?: [];
        $i = 0;
        foreach ($rekomendasiWisata as $rw) {
            $rekomendasiWisata[$i]["gambar"] = $this->produkGambar->fields(["gambar"])->where(["id_produk" => $rw["id"]])->order_by("id", "RANDOM")->get_all() ?: [];
            $i++;
        }

        $data   = [
            "galery"                => $galery,
            "rekomendasiWisata"     => $rekomendasiWisata,
        ];

        $this->load->view("homepage/paket_wisata", $data);
    }

    public function detail($id = NULL)
    {
        $detail = $this->vProduk->where(["id" => $id])->get();
        if (!$detail) {
            redirect("paket-wisata");
        }

        $gambar             = $this->produkGambar->where(["id_produk" => $detail["id"]])->get_all();
        $wisataLainnya      = $this->vProduk->order_by("id", "RANDOM")->limit(3)->get_all()     ?: [];

        $i = 0;
        foreach ($wisataLainnya as $wl) {
            $wisataLainnya[$i]["gambar"] = $this->produkGambar->fields(["gambar"])->where(["id_produk" => $wl["id"]])->order_by("id", "RANDOM")->get_all() ?: [];
            $i++;
        }

        $data = [
            "detail"    => $detail,
            "gambar"    => $gambar,
            "wisataLainnya"         => $wisataLainnya,
        ];

        // d($data);

        $this->load->view("homepage/detail", $data);
    }
}
