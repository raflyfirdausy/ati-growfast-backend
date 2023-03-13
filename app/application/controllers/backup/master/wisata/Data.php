<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Produk_model"      => "produk",
            "ProdukView_model"  => "vProduk"
        ]);

        $this->module           = "Data Wisata";
        $this->model            = $this->produk;
        $this->modelView        = $this->vProduk;
        $this->fieldForm        = $this->_getFieldForm();

        $this->configValidation     = [
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'required|trim',
            ],
        ];

        $configUpload['allowed_types']    = 'jpg|jpeg|png';
        $configUpload['max_size']         = 1024 * 5; //? 5MB
        $configUpload['remove_space']     = TRUE;
        $configUpload['overwrite']        = TRUE;
        $configUpload['encrypt_name']     = TRUE;
        $configUpload['upload_path']      = LOKASI_ICON_KATEGORI;
        if (!file_exists($configUpload['upload_path'])) {
            mkdir($configUpload['upload_path'], 0777, TRUE);
        }
        $this->configUpload     = $configUpload;
    }

    private function _getFieldForm()
    {
        $this->load->model(["Kategori_model" => "kategori"]);
        $kategori   = $this->kategori->fields(["id as value", "nama as label"])->order_by("nama", "ASC")->get_all() ?: [];


        $field =  [
            [
                "col"               => 12,
                "type"              => "text",
                "name"              => "total_gambar",
                "label"             => "Total Foto Wisata",
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => true,
                "hideFromCreate"    => true,
            ],
            [
                "col"               => 12,
                "type"              => "select",
                "name"              => "id_kategori",
                "name_alias"        => "kategori_nama",
                "label"             => "Kategori Wisata",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => FALSE,               //! Set true if chaining
                    "to"            => NULL,                //! Set name of target chaining
                    "serverSide"    => FALSE,                //! Set true if server side
                    "data"          => $kategori        //! Set array if server side and url if not client side
                ]
            ],
            [
                "col"               => 12,
                "type"              => "text",
                "name"              => "nama",
                "label"             => "Nama Wisata",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "harga",
                "label"             => "Harga Wisata",
                "numberOnly"        => true,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "durasi",
                "label"             => "Durasi Wisata",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "lokasi",
                "label"             => "Lokasi",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "total_destinasi",
                "label"             => "Total Destinasi",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 12,
                "type"              => "textarea",
                "name"              => "keterangan",
                "label"             => "Keterangan",
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => true,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
        ];

        return $field;
    }

    public function create()
    {
        header('Content-Type: application/json');

        $data = [];
        foreach ($this->fieldForm as $form) {
            if ($form["name"] != "total_gambar") {
                $data[$form["name"]] = $this->input->post($form["name"]);
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

    public function index()
    {
        $data = [
            "FIELD_FORM"    => $this->_getFieldForm(),
            "title"         => $this->module
        ];
        $this->loadRFLView("master/wisata/data", $data);
    }
}
