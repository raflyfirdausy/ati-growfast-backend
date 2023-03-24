<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Wilayah extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->input->post())) {
            $inputFromJson = file_get_contents('php://input');
            $_POST = json_decode($inputFromJson, TRUE);
        }

        $this->load->model([
            "Wilayah_model"    => "wilayah"
        ]);
    }

    public function provinsi_get()
    {
        $kondisi["LENGTH(kode)"]    = 2; //? KODE PROVINSI itu pasti 2 digit
        $_wilayah = $this->wilayah
            ->fields(["kode", "nama"])
            ->where($kondisi)
            ->order_by("nama", "ASC")
            ->get_all();

        if (!$_wilayah) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_NOT_FOUND,
                "message"       => "Data provinsi tidak ditemukan!",
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "OK",
            "data"          => $_wilayah
        ], REST_Controller::HTTP_OK);
    }

    public function kabupaten_get()
    {
        $kode_provinsi              = $this->input->get("kode_provinsi");

        if (!$kode_provinsi) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_PRECONDITION_FAILED,
                "message"       => "Kode provinsi tidak boleh kosong",
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }



        $kondisi["LENGTH(kode)"]                = 5;                //? KODE PROVINSI itu pasti 5 digit
        $kondisi["SUBSTRING(kode, 1, 2) ="]       = $kode_provinsi;
        $_wilayah       = $this->wilayah
            ->fields(["kode", "nama"])
            ->where($kondisi)
            ->order_by("nama", "ASC")
            ->get_all();


        if (!$_wilayah) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_NOT_FOUND,
                "message"       => "Data kabupaten tidak ditemukan!",
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "OK",
            "data"          => $_wilayah
        ], REST_Controller::HTTP_OK);
    }

    public function kecamatan_get()
    {
        $kode_kabupaten     = $this->input->get("kode_kabupaten");

        if (!$kode_kabupaten) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_PRECONDITION_FAILED,
                "message"       => "Kode kabupaten tidak boleh kosong",
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        $kondisi["LENGTH(kode)"]                = 8;                //? KODE PROVINSI itu pasti 5 digit
        $kondisi["SUBSTRING(kode, 1, 5) ="]     = $kode_kabupaten;
        $_wilayah       = $this->wilayah
            ->fields(["kode", "nama"])
            ->where($kondisi)
            ->order_by("nama", "ASC")
            ->get_all();


        if (!$_wilayah) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_NOT_FOUND,
                "message"       => "Data Kecamatan tidak ditemukan!",
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "OK",
            "data"          => $_wilayah
        ], REST_Controller::HTTP_OK);
    }

    public function kelurahan_get()
    {
        $kode_kecamatan     = $this->input->get("kode_kecamatan");

        if (!$kode_kecamatan) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_PRECONDITION_FAILED,
                "message"       => "Kode kecamatan tidak boleh kosong",
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        $kondisi["LENGTH(kode)"]                = 13;                //? KODE PROVINSI itu pasti 5 digit
        $kondisi["SUBSTRING(kode, 1, 8) ="]     = $kode_kecamatan;
        $_wilayah       = $this->wilayah
            ->fields(["kode", "nama"])
            ->where($kondisi)
            ->order_by("nama", "ASC")
            ->get_all();


        if (!$_wilayah) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_NOT_FOUND,
                "message"       => "Data Desa / Kelurahan tidak ditemukan!",
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "OK",
            "data"          => $_wilayah
        ], REST_Controller::HTTP_OK);
    }
}
