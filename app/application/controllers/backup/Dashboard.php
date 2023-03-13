<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends APP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Galery_model"      => "galery",
            "Kategori_model"    => "kategori",
            "Produk_model"      => "produk",
            "Transaksi_model"   => "transaksi"
        ]);
    }

    public function index()
    {

        $view           = "dashboard/admin";
        $data = [
            "page_title"        => "Dashboard Admin",
            "total_kategori"    => $this->kategori->count_rows(),
            "galery_total"      => $this->galery->count_rows(),
            "produk_total"      => $this->produk->count_rows(),
            "transaksi_total"   => [
                "semua"         => $this->transaksi->count_rows(),
                "belum"         => $this->transaksi->where(["pembayaran_status" => STATUS_BELUM])->count_rows(),
                "sudah"         => $this->transaksi->where(["pembayaran_status" => STATUS_SUDAH])->count_rows(),
                "tolak"         => $this->transaksi->where(["pembayaran_status" => STATUS_TOLAK])->count_rows(),
                "batal"         => $this->transaksi->where(["pembayaran_status" => STATUS_BATAL])->count_rows(),
            ]
        ];
        $this->loadViewBack($view, $data);
    }
}
