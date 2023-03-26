<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instansi extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Instansi_model"            => "instansi",
            "InstansiView_model"        => "vInstansi",
        ]);


        $this->module           = "Instansi";
        $this->model            = $this->instansi;
        $this->modelView        = $this->vInstansi;
        $this->fieldForm        = $this->_getFieldForm();
    }

    private function _getFieldForm()
    {
        $kondisi["LENGTH(kode)"]                    = 2;                //? KODE PROVINSI itu pasti 5 digit        
        $_wilayah       = $this->wilayah
            ->fields(["kode as value", "nama label"])
            ->where($kondisi)
            ->order_by("nama", "ASC")
            ->get_all();

        return [
            [
                "col"               => 12,
                "type"              => "text",
                "name"              => "nama",
                "label"             => "Nama instansi / Rumah Sakit",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "no_telp",
                "label"             => "No Telp Instansi",
                "numberOnly"        => true,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "direktur",
                "label"             => "Pemilik instansi",
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "prov",
                "name_alias"        => "prov_nama",
                "label"             => "Provinsi",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => FALSE,               //! Set true if chaining
                    "to"            => NULL,                //! Set name of target chaining
                    "reset"         => ["kab", "kec", "kel"],
                    "serverSide"    => FALSE,                //! Set true if server side
                    "data"          => $_wilayah       //! Set array if server side and url if not client side
                ],
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "kab",
                "name_alias"        => "kab_nama",
                "label"             => "Kabupaten",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => TRUE,                //! Set true if chaining
                    "to"            => "prov",           //! Set name of target chaining
                    "reset"         => ["kec", "kel"],
                    "serverSide"    => TRUE,                //! Set true if server side
                    "data"          => base_url($this->pathUrl . "/findKabupaten/")       //! Set array if server side and url if not client side
                ],
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "kec",
                "name_alias"        => "kec_nama",
                "label"             => "Kecamatan",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => TRUE,                //! Set true if chaining
                    "to"            => "kab",           //! Set name of target chaining
                    "reset"         => ["kel"],
                    "serverSide"    => TRUE,                //! Set true if server side
                    "data"          => base_url($this->pathUrl . "/findKecamatan/")       //! Set array if server side and url if not client side
                ],
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "kel",
                "name_alias"        => "kel_nama",
                "label"             => "Desa / Kelurahan",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => TRUE,                //! Set true if chaining
                    "to"            => "kec",           //! Set name of target chaining
                    "reset"         => [],
                    "serverSide"    => TRUE,                //! Set true if server side
                    "data"          => base_url($this->pathUrl . "/findKelurahan/")       //! Set array if server side and url if not client side
                ],
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "rt",
                "label"             => "RT",
                "numberOnly"        => true,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "rw",
                "label"             => "RW",
                "numberOnly"        => true,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 12,
                "type"              => "textarea",
                "name"              => "keterangan",
                "label"             => "Keterangan",
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
        $this->loadRFLView("master/instansi/data_instansi", $data);
    }
}
