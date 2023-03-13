<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Kategori_model"  => "kategori"
        ]);

        $this->module           = "Kategori Wisata";
        $this->model            = $this->kategori;
        $this->modelView        = $this->kategori;
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

    public function index()
    {
        $data = [
            "FIELD_FORM"    => $this->_getFieldForm(),
            "title"         => $this->module
        ];
        $this->loadRFLView("master/wisata/kategori", $data);
    }

    private function _getFieldForm()
    {
        $field =  [
            [
                "col"               => 12,
                "type"              => "file",
                "accept"            => "image/*",
                "name"              => "icon",
                "label"             => "Icon Kategori",
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
                "label"             => "Nama Kategori",
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
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
        ];

        return $field;
    }

    public function create()
    {
        $this->form_validation->set_rules($this->configValidation);
        $run =  $this->form_validation->run();
        if (!$run) {
            $error = $this->form_validation->error_array();
            $message = validationError($error);
            echo json_encode([
                "code"      => 503,
                "message"   => $message
            ]);
            die;
        }

        foreach ($this->fieldForm as $form) {
            $ishideFromCreate   = isset($form["hideFromCreate"])    ? $form["hideFromCreate"]   : FALSE;

            if ($form["type"] != "file" && !$ishideFromCreate) {
                $data[$form["name"]] = $this->input->post($form["name"]);
            }

            if ($form["type"] == "password") {
                $data[$form["name"]] = md5($this->input->post($form["name"]));
            }
        }

        $formNameFile                     = "icon";
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
        $this->form_validation->set_rules($this->configValidation);
        $run =  $this->form_validation->run();
        if (!$run) {
            $error = $this->form_validation->error_array();
            $message = validationError($error);
            echo json_encode([
                "code"      => 503,
                "message"   => $message
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

        $formNameFile                     = "icon";
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

    public function delete()
    {
        $this->load->model(["Produk_model" => "produk"]);
        $id_data    = $this->input->post("id_data");

        //! CEK APAKAH KATEGORINYA DI PAKE
        $cek = $this->produk->where(["id_kategori" => $id_data])->get();
        if ($cek) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menghapus $this->module. Keterangan : Kategori masih digunakan pada produk"
            ]);
            die;
        }

        $delete     = $this->model->where(["id" => $id_data])->delete();
        if (!$delete) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menghapus $this->module"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data $this->module berhasil di hapus !"
        ]);
    }
}
