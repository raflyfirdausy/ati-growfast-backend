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
                "accept"            => "applicatoin/pdf",
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

    public function index(){
        $data = [
            "FIELD_FORM"    => $this->_getFieldForm(),
            "title"         => $this->module
        ];
        $this->loadRFLView($this->RFL_data["RFL_MASTER"], $data);
    }
}
