<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Check_kode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Galery_model"          => "galery",
            "ProdukView_model"      => "vProduk",
            "ProdukGambar_model"    => "produkGambar",
            "Kategori_model"        => "kategori",
            "Transaksi_model"       => "transaksi"
        ]);
    }

    public function index()
    {
        $data = [
            "title" => "Check Kode"
        ];
        $this->load->view("homepage/check", $data);
    }

    public function detail($kode = NULL)
    {
        $detail = $this->transaksi->where(["kode_booking" => $kode])->get();

        $found  = false;
        $produk = NULL;
        $gambar = NULL;
        if ($detail) {
            $produk = $this->vProduk->where(["id" => $detail["id_produk"]])->get();
            if ($produk) {
                $gambar = $this->produkGambar->where(["id_produk" => $produk["id"]])->order_by("id", "RANDOM")->get();
            }
            $found = true;
        }
        $data = [
            "title"     => "Detail Booking",
            "detail"    => $detail,
            "produk"    => $produk,
            "gambar"    => $gambar
        ];

        if ($found) {

            $this->load->view("homepage/check_detail", $data);
        } else {
            $this->session->set_flashdata('gagal', 'Silahkan masukan kode booking dengan benar, dan coba lagi !');
            $this->load->view("homepage/check", $data);
        }
    }

    public function batal($kode = NULL)
    {
        if (!empty($kode)) {
            $cek = $this->transaksi->where(["kode_booking" => $kode])->get();
            if ($cek && $cek["pembayaran_status"] === STATUS_BELUM) {
                $this->transaksi->where(["kode_booking" => $kode])->update(["pembayaran_status" => STATUS_BATAL]);
                redirect("check-kode/detail/" . $kode);
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}
