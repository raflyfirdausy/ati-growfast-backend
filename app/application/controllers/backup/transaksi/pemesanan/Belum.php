<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Belum extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Transaksi_model"           => "transaksi",
            "Produk_model"              => "produk"
        ]);


        $this->module           = "Semua Transaksi";
        $this->model            = $this->transaksi;
        $this->modelView        = $this->transaksi;
        $this->fieldForm        = $this->_getFieldForm();

        $configUpload['allowed_types']    = 'jpg|jpeg|png';
        $configUpload['max_size']         = 1024 * 5; //? 5MB
        $configUpload['remove_space']     = TRUE;
        $configUpload['overwrite']        = TRUE;
        $configUpload['encrypt_name']     = TRUE;
        $configUpload['upload_path']      = LOKASI_BUKTI;
        if (!file_exists($configUpload['upload_path'])) {
            mkdir($configUpload['upload_path'], 0777, TRUE);
        }
        $this->configUpload     = $configUpload;
        $this->formNameFile     = "pembayaran_bukti";

        $this->kondisiGetData   = [
            "pembayaran_status" => STATUS_BELUM
        ];
    }

    private function _getFieldForm()
    {
        $produk = $this->produk->fields(["id as value", "nama as label"])->as_array()->get_all() ?: [];

        $field =  [
            [
                "col"               => 12,
                "type"              => "text",
                "name"              => "kode_booking",
                "label"             => "Kode Booking",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => true,
                "hideFromCreate"    => true,
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "id_produk",
                "name_alias"        => "produk_nama",
                "label"             => "Nama Wisata",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => FALSE,               //! Set true if chaining
                    "to"            => NULL,                //! Set name of target chaining
                    "serverSide"    => FALSE,                //! Set true if server side
                    "data"          => $produk          //! Set array if server side and url if not client side
                ]
            ],
            [
                "col"               => 6,
                "type"              => "date",
                "name"              => "tanggal",
                "label"             => "Tanggal Booking",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 12,
                "type"              => "text",
                "name"              => "produk_harga",
                "label"             => "Harga",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => true,
                "hideFromCreate"    => true,
            ],
            [
                "col"               => 12,
                "type"              => "text",
                "name"              => "nama",
                "label"             => "Nama Pemesan",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "nohp",
                "label"             => "Nomor Handphone",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "email",
                "name"              => "email",
                "label"             => "Email Pemesan",
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 12,
                "type"              => "textarea",
                "name"              => "alamat",
                "label"             => "Alamat Pemesan",
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 12,
                "type"              => "select",
                "name"              => "pembayaran_status",
                "name_alias"        => "pembayaran_status",
                "label"             => "Status Pembayaran",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => FALSE,               //! Set true if chaining
                    "to"            => NULL,                //! Set name of target chaining
                    "serverSide"    => FALSE,                //! Set true if server side
                    "data"          => [
                        ["value" => STATUS_BELUM, "label"       => "BELUM BAYAR"],
                        ["value" => STATUS_SUDAH, "label"       => "SUDAH BAYAR"],
                        ["value" => STATUS_TOLAK, "label"       => "TOLAK PEMESANAN"],
                    ]
                ]
            ],
            [
                "col"               => 12,
                "type"              => "file",
                "accept"            => "image/*",
                "name"              => "pembayaran_bukti",
                "label"             => "Bukti Pembayaran",
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
        ];

        return $field;
    }

    public function index()
    {
        $data = [
            "FIELD_FORM"            => $this->_getFieldForm(),
            "title"                 => $this->module,
            "ENABLE_ADD_BUTTON"     => FALSE
        ];
        $this->loadRFLView("transaksi/pemesanan/semua", $data);
    }

    public function create()
    {
        foreach ($this->fieldForm as $form) {
            $ishideFromCreate   = isset($form["hideFromCreate"])    ? $form["hideFromCreate"]   : FALSE;
            if ($form["type"] != "file" && !$ishideFromCreate) {
                $data[$form["name"]] = $this->input->post($form["name"]);
            }
        }

        $formNameFile                     = $this->formNameFile;
        if (!empty($_FILES[$formNameFile]["name"])) {
            $this->upload->initialize($this->configUpload);
            $upload     = $this->upload->do_upload($formNameFile);
            if ($upload) {
                $dataUpload             = $this->upload->data();
                $data[$formNameFile]    = $dataUpload["file_name"];
            } else {
                echo json_encode([
                    "code"      => 503,
                    "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : " . $this->upload->display_errors("", "")
                ]);
                die;
            }
        }
        $produk = $this->produk->where(["id" => $this->input->post("id_produk")])->as_array()->get();
        if (!$produk) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : Data Wisata tidak ditemukan !"
            ]);
            die;
        }
        $data["kode_booking"]   = $this->generate();
        $data["produk_nama"]    = $produk["nama"];
        $data["produk_harga"]   = $produk["harga"];

        $insert = $this->model->insert($data);
        if (!$insert) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan data $this->module"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Berhasil menambahkan data " . ucwords($this->module)
        ]);
    }

    public function update()
    {
        header('Content-Type: application/json');

        $id_data    = $this->input->post("id_data");
        $cekData    = $this->model->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data $this->module tidak ditemukan"
            ]);
            die;
        }

        $dataUpdate = [];
        foreach ($this->fieldForm as $form) {
            $isHideFromEdit   = isset($form["hideFromEdit"])    ? $form["hideFromEdit"]   : FALSE;
            if ($form["type"] != "file" && !$isHideFromEdit) {
                $dataUpdate[$form["name"]] = $this->input->post($form["name"]);
            }
        }

        $formNameFile                     = $this->formNameFile;
        if (!empty($_FILES[$formNameFile]["name"])) {
            $this->upload->initialize($this->configUpload);
            $upload     = $this->upload->do_upload($formNameFile);
            if ($upload) {
                $dataUpload                     = $this->upload->data();
                $dataUpdate[$formNameFile]      = $dataUpload["file_name"];
            } else {
                echo json_encode([
                    "code"      => 503,
                    "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : " . $this->upload->display_errors("", "")
                ]);
                die;
            }
        }

        $update = $this->model->where(["id" => $cekData["id"]])->update($dataUpdate);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengedit " . ucwords($this->module)
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   =>  ucwords($this->module) . " berhasil di ubah !"
        ]);
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
}
