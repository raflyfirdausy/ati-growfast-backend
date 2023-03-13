<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homepage extends CI_Controller
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
        $galery             = $this->galery->order_by("id", "RANDOM")->limit(5)->get_all()      ?: [];
        $rekomendasiWisata  = $this->vProduk->order_by("id", "RANDOM")->limit(10)->get_all()    ?: [];
        $wisataLainnya      = $this->vProduk->order_by("id", "RANDOM")->limit(3)->get_all()     ?: [];
        $kategoriWisata     = $this->kategori->order_by("id", "RANDOM")->get_all()              ?: [];

        $i = 0;
        foreach ($rekomendasiWisata as $rw) {
            $rekomendasiWisata[$i]["gambar"] = $this->produkGambar->fields(["gambar"])->where(["id_produk" => $rw["id"]])->order_by("id", "RANDOM")->get_all() ?: [];
            $i++;
        }

        $i = 0;
        foreach ($wisataLainnya as $wl) {
            $wisataLainnya[$i]["gambar"] = $this->produkGambar->fields(["gambar"])->where(["id_produk" => $wl["id"]])->order_by("id", "RANDOM")->get_all() ?: [];
            $i++;
        }

        $i = 0;
        foreach ($kategoriWisata as $ks) {
            $kategoriWisata[$i]["total"] = $this->vProduk->where(["id_kategori" => $ks["id"]])->count_rows();
            $i++;
        }

        $data   = [
            "galery"                => $galery,
            "rekomendasiWisata"     => $rekomendasiWisata,
            "wisataLainnya"         => $wisataLainnya,
            "kategoriWisata"        => $kategoriWisata
        ];

        $this->load->view("homepage/homepage", $data);
    }

    private function generate()
    {
        $kode   = generator(5);
        $cek    = $this->transaksi->where(["kode_booking" => $kode])->get();
        if ($cek) {
            return $this->generate();
        }
        return $kode;
    }

    public function booking_proses()
    {
        $id_data        = $this->input->post("id_data");
        $tanggal        = $this->input->post("tanggal");
        $nama           = $this->input->post("nama");
        $nohp           = $this->input->post("nohp");
        $email          = $this->input->post("email");
        $alamat         = $this->input->post("alamat");

        $produk = $this->vProduk->where(["id" => $id_data])->as_array()->get();
        if (!$produk) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat melakukan proses booking. Keterangan : Data Wisata tidak ditemukan !"
            ]);
            die;
        }

        $kodeBooking            = $this->generate();
        $dataInsert             = [
            "id_produk"             => $produk["id"],
            "kode_booking"          => $kodeBooking,
            "tanggal"               => $tanggal,
            "produk_nama"           => $produk["nama"],
            "produk_harga"          => $produk["harga"],
            "nama"                  => $nama,
            "nohp"                  => $nohp,
            "email"                 => $email,
            "alamat"                => $alamat,
            "pembayaran_status"     => STATUS_BELUM,
        ];

        $insert = $this->transaksi->insert($dataInsert);
        if (!$insert) {
            echo json_encode([
                "code"      => 403,
                "message"   => "Terjadi kesalahan saat melakukan proses booking. (403)"
            ]);
            die;
        }

        echo json_encode([
            "code"          => 200,
            "kode_booking"  => $kodeBooking,
            "message"       => "Berhasil melakukan proses booking wisata " . $produk["nama"] . " untuk tanggal " . $tanggal . ". dengan kode Booking: " . $kodeBooking . " Silahkan catat Kode booking anda"
        ]);
    }
}
