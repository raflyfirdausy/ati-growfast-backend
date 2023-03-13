<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RFL_Controller extends Sampah_Controller
{
    public $module;
    public $model;
    public $modelView;
    public $fieldForm;
    public $RFL_data;
    public $pathUrl;
    public $enableAddButton = TRUE;
    public $kondisiGetData = [];

    public $userData;
    public $_session;

    public function __construct()
    {
        parent::__construct();
        $directory              = $this->router->directory;
        $class                  = $this->router->class;
        $this->pathUrl          = $directory . $class;

        $this->RFL_data    = [
            "RFL_MODAL"         => "template/RFL_modal",
            "RFL_TABLE"         => "template/RFL_table",
            "RFL_MASTER"        => "template/RFL_master",

            "URL_GET_DATA"      => base_url("$this->pathUrl/get_data/"),     //! WAJIB ADA
            "URL_CREATE_DATA"   => base_url("$this->pathUrl/create/"),       //! WAJIB ADA
            "URL_UPDATE_DATA"   => base_url("$this->pathUrl/update/"),       //! WAJIB ADA
            "URL_DELETE_DATA"   => base_url("$this->pathUrl/delete/"),       //! WAJIB ADA                
            "URL_DETAIL_DATA"   => base_url("$this->pathUrl/get/"),          //! WAJIB ADA 

            "ENABLE_ADD_BUTTON" => $this->enableAddButton
        ];
        
        $this->_session = $this->session->userdata(SESSION);
    }

    protected function loadRFLView($view = NULL, $local_data = array(), $asData = FALSE)
    {
        $data = array_merge($this->RFL_data, $local_data);
        $this->loadViewBack($view, $data, $asData);
    }

    public function get_data()
    {
        header('Content-Type: application/json');
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

    protected function _filterDataTable($model)
    {
        $inputKolom     = $this->input->post("columns");
        $index          = 2; //! 0 = Nomer | 1 = Aksi
        foreach ($this->fieldForm as $form) {
            $isHideFromTable = isset($form["hideFromTable"]) ? $form["hideFromTable"] : FALSE;
            if (!$isHideFromTable) {
                if (isset($inputKolom) && !empty($inputKolom[$index]["search"]["value"])) {
                    if (!isset($form["name_alias"])) {
                        $name = $form["name"];
                        $model = $model->where("LOWER($name)", "LIKE", strtolower($inputKolom[$index]["search"]["value"]));
                    } else {
                        $name = $form["name_alias"];
                        $model = $model->where("LOWER($name)", "LIKE", strtolower($inputKolom[$index]["search"]["value"]));
                    }
                }
                $index++;
            }
        }

        if (isset($inputKolom) && !empty($inputKolom[$index]["search"]["value"])) {
            $name = "created_at";
            $model = $model->where("LOWER($name)", "LIKE", strtolower($inputKolom[$index]["search"]["value"]));
        }

        return $model;
    }

    public function create()
    {
        header('Content-Type: application/json');

        $data = [];
        foreach ($this->fieldForm as $form) {
            $data[$form["name"]] = $this->input->post($form["name"]);
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

    public function delete()
    {
        header('Content-Type: application/json');
        $id_data    = $this->input->post("id_data");
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

    public function get($id = NULL)
    {
        header('Content-Type: application/json');
        $data = $this->modelView->where(["id" => $id])->get();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data $this->module tidak ditemukan "
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data $this->module ditemukan",
            "data"      => $data
        ]);
    }

    public function update()
    {
        header('Content-Type: application/json');

        $dataUpdate = [];
        foreach ($this->fieldForm as $form) {
            $dataUpdate[$form["name"]] = $this->input->post($form["name"]);
        }

        $id_data    = $this->input->post("id_data");
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
