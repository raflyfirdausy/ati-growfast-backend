<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alat_barang extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "AlatBarang_model"      => "alatBarang",
        ]);


        $this->module           = "Alat dan Barang";
        $this->model            = $this->alatBarang;
        $this->modelView        = $this->alatBarang;
        $this->fieldForm        = $this->_getFieldForm();

        $configUpload['allowed_types']    = 'jpg|jpeg|png';
        $configUpload['max_size']         = 1024 * 5; //? 5MB
        $configUpload['remove_space']     = TRUE;
        $configUpload['overwrite']        = TRUE;
        $configUpload['encrypt_name']     = TRUE;
        $configUpload['upload_path']      = LOKASI_ALAT_BARANG_GAMBAR;
        if (!file_exists($configUpload['upload_path'])) {
            mkdir($configUpload['upload_path'], 0777, TRUE);
        }
        $this->configUpload     = $configUpload;
    }

    private function _getFieldForm()
    {
        return [
            [
                "col"               => 6,
                "type"              => "file",
                "accept"            => "image/*",
                "name"              => "gambar",
                "label"             => "Gambar alat / barang",
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "file",
                "accept"            => "application/pdf",
                "name"              => "pdf_pemakaian",
                "label"             => "Cara pemakaian (Pdf)",
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 12,
                "type"              => "text",
                "name"              => "nama",
                "label"             => "Nama alat / barang",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "jenis",
                "name_alias"        => "jenis",
                "label"             => "Jenis",
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
                        [
                            "value" => "ALAT",
                            "label" => "ALAT",
                        ],
                        [
                            "value" => "BARANG",
                            "label" => "BARANG",
                        ]
                    ]
                ]
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "harga",
                "label"             => "Harga",
                "numberOnly"        => true,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 12,
                "type"              => "textarea",
                "name"              => "deskripsi",
                "label"             => "Deskripsi",
                "numberOnly"        => true,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
        ];
    }

    public function index()
    {
        $data = [
            "FIELD_FORM"    => $this->_getFieldForm(),
            "title"         => $this->module
        ];
        $this->loadRFLView("master/alat_barang/data_alat_barang", $data);
    }

    public function create()
    {
        foreach ($this->fieldForm as $form) {
            $ishideFromCreate   = isset($form["hideFromCreate"])    ? $form["hideFromCreate"]   : FALSE;
            if ($form["type"] != "file" && !$ishideFromCreate) {
                $data[$form["name"]] = $this->input->post($form["name"]);
            }
        }

        $formNameFile                     = "gambar";
        if (!empty($_FILES[$formNameFile]["name"])) {
            $configUploadGambar = $this->configUpload;
            $this->upload->initialize($configUploadGambar);
            $upload     = $this->upload->do_upload($formNameFile);
            if ($upload) {
                $dataUpload             = $this->upload->data();
                $data[$formNameFile]    = $dataUpload["file_name"];
            } else {
                echo json_encode([
                    "code"      => 503,
                    "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan gambar : " . $this->upload->display_errors("", "")
                ]);
                die;
            }
        }

        $formNameFile                   = "pdf_pemakaian";
        if (!empty($_FILES[$formNameFile]["name"])) {
            $configUploadPdf = $this->configUpload;
            $configUploadPdf["allowed_types"]   = "pdf";
            $configUploadPdf["upload_path"]     = LOKASI_ALAT_BARANG_PDF;
            $this->upload->initialize($configUploadPdf);
            $upload     = $this->upload->do_upload($formNameFile);
            if ($upload) {
                $dataUpload             = $this->upload->data();
                $data[$formNameFile]    = $dataUpload["file_name"];
            } else {
                echo json_encode([
                    "code"      => 503,
                    "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan pdf : " . $this->upload->display_errors("", "")
                ]);
                die;
            }
        }

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
        $id_data    = $this->input->post("id_data");
        $cekData    = $this->model->where([$this->model->primary_key => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data $this->module tidak ditemukan"
            ]);
            die;
        }

        $dataUpdate = [];
        foreach ($this->fieldForm as $form) {
            $isHideFromUpdate   = isset($form["hideFromEdit"])    ? $form["hideFromEdit"]   : FALSE;
            if ($form["type"] != "file" && !$isHideFromUpdate) {
                $dataUpdate[$form["name"]] = $this->input->post($form["name"]);
            }
        }

        $formNameFile                     = "gambar";
        if (!empty($_FILES[$formNameFile]["name"])) {
            $configUploadGambar = $this->configUpload;
            $this->upload->initialize($configUploadGambar);
            $upload     = $this->upload->do_upload($formNameFile);
            if ($upload) {
                $dataUpload                     = $this->upload->data();
                $dataUpdate[$formNameFile]      = $dataUpload["file_name"];

                if (!empty($cekData["gambar"]) && file_exists(LOKASI_ALAT_BARANG_GAMBAR . $cekData["gambar"])) {
                    $file = LOKASI_ALAT_BARANG_GAMBAR . $cekData["gambar"];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            } else {
                echo json_encode([
                    "code"      => 503,
                    "message"   => "Terjadi kesalahan saat memperbaharui data $this->module. Keterangan gambar : " . $this->upload->display_errors("", "")
                ]);
                die;
            }
        }

        $formNameFile                   = "pdf_pemakaian";
        if (!empty($_FILES[$formNameFile]["name"])) {
            $configUploadPdf = $this->configUpload;
            $configUploadPdf["allowed_types"]   = "pdf";
            $configUploadPdf["upload_path"]     = LOKASI_ALAT_BARANG_PDF;
            $this->upload->initialize($configUploadPdf);
            $upload     = $this->upload->do_upload($formNameFile);
            if ($upload) {
                $dataUpload                     = $this->upload->data();
                $dataUpdate[$formNameFile]      = $dataUpload["file_name"];

                if (!empty($cekData["pdf_pemakaian"]) && file_exists(LOKASI_ALAT_BARANG_PDF . $cekData["pdf_pemakaian"])) {
                    $file = LOKASI_ALAT_BARANG_PDF . $cekData["pdf_pemakaian"];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            } else {
                echo json_encode([
                    "code"      => 503,
                    "message"   => "Terjadi kesalahan saat memperbaharui data $this->module. Keterangan pdf : " . $this->upload->display_errors("", "")
                ]);
                die;
            }
        }

        $update = $this->model->where([$this->model->primary_key => $cekData[$this->model->primary_key]])->update($dataUpdate);
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
}
