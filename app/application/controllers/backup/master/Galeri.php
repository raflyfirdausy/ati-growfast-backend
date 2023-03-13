<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Galeri extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Galery_model"          => "galery",
        ]);


        $this->module           = "Galeri Wisata";
        $this->model            = $this->galery;
        $this->modelView        = $this->galery;
        $this->fieldForm        = $this->_getFieldForm();

        $configUpload['allowed_types']    = 'jpg|jpeg|png';
        $configUpload['max_size']         = 1024 * 5; //? 5MB
        $configUpload['remove_space']     = TRUE;
        $configUpload['overwrite']        = TRUE;
        $configUpload['encrypt_name']     = TRUE;
        $configUpload['upload_path']      = LOKASI_GALERY;
        if (!file_exists($configUpload['upload_path'])) {
            mkdir($configUpload['upload_path'], 0777, TRUE);
        }
        $this->configUpload     = $configUpload;
    }

    private function _getFieldForm()
    {
        $fields = [
            [
                "col"               => 12,
                "type"              => "file",
                "accept"            => "image/*",
                "name"              => "gambar",
                "label"             => "Gambar",
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 12,
                "type"              => "textarea",
                "name"              => "caption",
                "label"             => "Caption",
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
        ];
        return $fields;
    }


    public function index()
    {
        $data = [
            "FIELD_FORM"    => $this->_getFieldForm(),
            "title"         => $this->module
        ];
        $this->loadRFLView("master/galeri/galeri", $data);
    }

    public function create()
    {
        foreach ($this->fieldForm as $form) {
            $ishideFromCreate   = isset($form["hideFromCreate"])    ? $form["hideFromCreate"]   : FALSE;

            if ($form["type"] != "file" && !$ishideFromCreate) {
                $data[$form["name"]] = $this->input->post($form["name"]);
            }

            if ($form["type"] == "password") {
                $data[$form["name"]] = md5($this->input->post($form["name"]));
            }
        }

        $formNameFile                     = "gambar";
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

        $dataUpdate = [];
        foreach ($this->fieldForm as $form) {
            $isHideFromUpdate   = isset($form["hideFromEdit"])    ? $form["hideFromEdit"]   : FALSE;
            if ($form["type"] != "file" && !$isHideFromUpdate) {
                $dataUpdate[$form["name"]] = $this->input->post($form["name"]);
            }
        }

        $formNameFile                     = "gambar";
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

        $cekData    = $this->model->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data $this->module tidak ditemukan"
            ]);
            die;
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
}
