<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gambar extends RFL_Controller
{
    public $id;
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "ProdukGambar_model"        => "produkGambar",
            "Produk_model"              => "produk"
        ]);

        $this->module           = "Foto Wisata";
        $this->model            = $this->produkGambar;
        $this->modelView        = $this->produkGambar;
        $this->fieldForm        = $this->_getFieldForm();

        $configUpload['allowed_types']    = 'jpg|jpeg|png';
        $configUpload['max_size']         = 1024 * 5; //? 5MB
        $configUpload['remove_space']     = TRUE;
        $configUpload['overwrite']        = TRUE;
        $configUpload['encrypt_name']     = TRUE;
        $configUpload['upload_path']      = LOKASI_GAMBAR;
        if (!file_exists($configUpload['upload_path'])) {
            mkdir($configUpload['upload_path'], 0777, TRUE);
        }
        $this->configUpload     = $configUpload;
    }

    private function _getFieldForm()
    {
        $field =  [
            [
                "col"               => 12,
                "type"              => "file",
                "accept"            => "image/*",
                "name"              => "gambar",
                "label"             => "Foto Wisata",
                "numberOnly"        => false,
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
                "numberOnly"        => false,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
        ];

        return $field;
    }



    public function index($id = NULL)
    {
        $this->load->model("Produk_model", "produk");
        $cek = $this->produk->where(["id" => $id])->as_array()->get();
        if (!$cek) {
            redirect("master/wisata/data");
        }

        $this->kondisiGetData   = [
            "id_produk" => $cek["id"]
        ];

        $data = [
            "FIELD_FORM"        => $this->_getFieldForm(),
            "title"             => $this->module . " " . $cek["nama"],

            "URL_GET_DATA"      => base_url("$this->pathUrl/get_data_foto/$id"),     //! WAJIB ADA
            "URL_CREATE_DATA"   => base_url("$this->pathUrl/create/$id"),       //! WAJIB ADA            
        ];
        $this->loadRFLView("master/wisata/gambar", $data);
    }

    public function get_data_foto($id)
    {
        header('Content-Type: application/json');

        $this->kondisiGetData = ["id_produk" => $id];
        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->_filterDataTable($this->modelView)->where($this->kondisiGetData)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->_filterDataTable($this->modelView)->where($this->kondisiGetData)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->modelView->where($this->kondisiGetData)->count_rows() ?: 0;

        echo json_encode([
            "draw"              => $this->input->post("draw", TRUE),
            "data"              => $data,
            "recordsFiltered"   => $dataFilter,
            "recordsTotal"      => $dataCountAll,
        ]);
    }

    public function create($id = NULL)
    {
        $cek = $this->produk->where(["id" => $id])->as_array()->get();
        if (!$cek) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan foto. Keterangan : Data wisata tidak ditemukan"
            ]);
            die;
        }

        foreach ($this->fieldForm as $form) {
            $ishideFromCreate   = isset($form["hideFromCreate"])    ? $form["hideFromCreate"]   : FALSE;
            if ($form["type"] != "file" && !$ishideFromCreate) {
                $data[$form["name"]] = $this->input->post($form["name"]);
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
        $data["id_produk"] = $cek["id"];
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
