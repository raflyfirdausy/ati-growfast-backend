<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->input->post())) {
            $inputFromJson = file_get_contents('php://input');
            $_POST = json_decode($inputFromJson, TRUE);
        }

        $this->load->model([
            "User_model"        => "user",
            "Wilayah_model"     => "wilayah"
        ]);
    }

    public function index_get()
    {
        $_user          = $this->getUser();
        $_user["foto"]  = base_url(LOKASI_PROFILE) . (($_user["foto"] != null) ? $_user["foto"] : "default.jpg");
        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "OK",
            "data"          => $_user
        ], REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $config = [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required',
            ],
        ];

        $load   = $this->form_validation->set_rules($config);
        $run    = $this->form_validation->run();
        if (!$run) {
            $error  = $this->form_validation->error_array();
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_BAD_REQUEST,
                "message"       => validationError($error),
            ], REST_Controller::HTTP_OK);
        }

        $username       = $this->input->post("username");
        $password       = $this->input->post("password");
        $_user          = getUser([
            "username"  => $username,
            "password"  => md5($password)
        ]);

        if (!$_user) {
            return $this->response([
                "status"       => true,
                "code"         => REST_Controller::HTTP_NOT_FOUND,
                "message"      => "Username atau password yang kamu masukan salah. Silahkan coba lagi",
                "data"         => NULL
            ], REST_Controller::HTTP_OK);
        }
        
        $_user["foto"]  = base_url(LOKASI_PROFILE) . (($_user["foto"] != null) ? $_user["foto"] : "default.jpg");

        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "OK",
            "data"          => $_user
        ], REST_Controller::HTTP_OK);
    }

    public function profile_post()
    {
        $_user          = $this->getUser();

        $config         = [
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'jenis_kelamin',
                'label' => 'Jenis Kelamin',
                'rules' => 'required|trim|in_list[LAKI-LAKI,PEREMPUAN]',
                'errors' => [
                    'in_list' => 'Kolom {field} harus berisi salah satu dari {param}'
                ]
            ],
            [
                'field' => 'no_telp',
                'label' => 'No Telephone',
                'rules' => 'trim|required|numeric|min_length[10]|max_length[14]'
            ],
            [
                'field' => 'id_prov',
                'label' => 'Provinsi',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'id_kab',
                'label' => 'Kabupaten',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'id_kel',
                'label' => 'Desa / Kelurahan',
                'rules' => 'trim|required',
            ],
        ];
        $load           = $this->form_validation->set_rules($config);
        $run            = $this->form_validation->run();
        if (!$run) {
            $error      = $this->form_validation->error_array();
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_BAD_REQUEST,
                "message"       => validationError($error),
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        $nama           = $this->input->post("nama");
        $jenis_kelamin  = $this->input->post("jenis_kelamin");
        $no_telp        = $this->input->post("no_telp");
        $id_prov        = $this->input->post("id_prov");
        $id_kab         = $this->input->post("id_kab");
        $id_kec         = $this->input->post("id_kec");
        $id_kel         = $this->input->post("id_kel");
        $alamat         = $this->input->post("alamat");
        $rt             = $this->input->post("rt");
        $rw             = $this->input->post("rw");

        $this->checkWilayah($id_prov,   "Provinsi");
        $this->checkWilayah($id_kab,    "Kabupaten");
        $this->checkWilayah($id_kec,    "Kecamatan");
        $this->checkWilayah($id_kel,    "Desa / Kelurahan");

        $dataUpdate     = [
            "nama"              => $nama,
            "jenis_kelamin"     => $jenis_kelamin,
            "no_telp"           => $no_telp,
            "id_prov"           => $id_prov,
            "id_kab"            => $id_kab,
            "id_kec"            => $id_kec,
            "id_kel"            => $id_kel,
            "alamat"            => $alamat,
            "rt"                => $rt,
            "rw"                => $rw
        ];
        $update         = $this->user->where([$this->user->primary_key => $_user[$this->user->primary_key]])->update($dataUpdate);
        if (!$update) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                "message"       => "Terjadi kesalahan saat mengubah data profile. (Kode : R500);",
                "data"          => NULL, "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "Data profile berhasil di ubah",
            "data"          => getUser([$this->user->primary_key => getApiKey()])
        ], REST_Controller::HTTP_OK);
    }

    public function foto_post()
    {
        $_user          = $this->getUser();
        $configUpload   = [
            "upload_path"       => LOKASI_PROFILE,
            "allowed_types"     => "jpg|jpeg|png",
            "max_size"          => 1024 * 5,    //? 5MB
            "encrypt_name"      => TRUE,
            "remove_space"      => TRUE,
            "overwrite"         => TRUE,
        ];

        if (!file_exists($configUpload['upload_path'])) {
            mkdir($configUpload['upload_path'], 0777, TRUE);
        }

        $this->upload->initialize($configUpload);

        $formNameFile           = "foto";
        if (empty($_FILES[$formNameFile]["name"])) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_BAD_REQUEST,
                "message"       => "Foto tidak boleh kosong!",
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        $upload                 = $this->upload->do_upload($formNameFile);
        if (!$upload) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_BAD_REQUEST,
                "message"       => "Terjadi kesalahan saat mengubah foto profile. Keterangan : " . $this->upload->display_errors("", ""),
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        $dataUpload             = $this->upload->data();
        $data[$formNameFile]    = $dataUpload["file_name"];

        $update                 = $this->user->where([$this->user->primary_key => $_user[$this->user->primary_key]])->update($data);
        if (!$update) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                "message"       => "Terjadi kesalahan saat mengubah foto. (Kode : R500)",
            ], REST_Controller::HTTP_OK);
        }

        if (!empty($_user["foto"]) && file_exists(LOKASI_PROFILE . $_user["foto"])) {
            $foto = LOKASI_PROFILE . $_user["foto"];
            if (file_exists($foto)) {
                unlink($foto);
            }
        }

        $_user          = $this->getUser();
        $_user["foto"]  = base_url(LOKASI_PROFILE) . (($_user["foto"] != null) ? $_user["foto"] : "default.jpg");
        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "Data profile berhasil di ubah",
            "data"          => $_user
        ], REST_Controller::HTTP_OK);
    }

    public function foto_delete()
    {
        $_user                  = $this->getUser();
        $update                 = $this->user->where([$this->user->primary_key => $_user[$this->user->primary_key]])->update(["foto" => NULL]);
        if (!$update) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                "message"       => "Terjadi kesalahan saat mengubah foto. (Kode : R500)",
            ], REST_Controller::HTTP_OK);
        }

        if (!empty($_user["foto"]) && file_exists(LOKASI_PROFILE . $_user["foto"])) {
            unlink(LOKASI_PROFILE . $_user["foto"]);
        }

        $_user          = $this->getUser();
        $_user["foto"]  = base_url(LOKASI_PROFILE) . (($_user["foto"] != null) ? $_user["foto"] : "default.jpg");
        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "Data profile berhasil di hapus",
            "data"          => $_user
        ], REST_Controller::HTTP_OK);
    }

    public function password_post()
    {
        $_user          = $this->getUser(FALSE);
        $config = [
            [
                'field' => 'password_lama',
                'label' => 'Password Lama',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'password_baru',
                'label' => 'Password Baru',
                'rules' => 'required|trim|min_length[8]',
            ],
            [
                'field' => 'konfirmasi_password',
                'label' => 'Konfirmasi Password',
                'rules' => 'required|trim|matches[password_baru]',
            ],
        ];

        $load   = $this->form_validation->set_rules($config);
        $run    = $this->form_validation->run();
        if (!$run) {
            $error  = $this->form_validation->error_array();
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_BAD_REQUEST,
                "message"       => validationError($error),
            ], REST_Controller::HTTP_OK);
        }

        $passwordLama       = md5($this->input->post("password_lama"));
        $passwordBaru       = md5($this->input->post("password_baru"));

        if ($_user["password"] !== $passwordLama) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_BAD_REQUEST,
                "message"       => "Password lama yang kamu masukan salah ! Silahkan coba lagi.",
            ], REST_Controller::HTTP_OK);
        }

        $update             = $this->user->where([$this->user->primary_key => $_user[$this->user->primary_key]])->update(["password" => $passwordBaru]);
        if (!$update) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                "message"       => "Terjadi kesalahan saat mengubah password. (Kode : R500)",
            ], REST_Controller::HTTP_OK);
        }

        return $this->response([
            "status"        => true,
            "code"          => REST_Controller::HTTP_OK,
            "message"       => "Password Berhasil Diubah",
        ], REST_Controller::HTTP_OK);
    }

    //!=================================

    private function checkWilayah($kode, $nama)
    {
        $cek = $this->wilayah->where(["kode" => $kode])->get();
        if (!$cek) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_OK,
                "message"       => "Kode $kode untuk nama $nama tidak ditemukan. Silahkan coba lagi",
                "data"          => NULL,
            ], REST_Controller::HTTP_OK);
        }
    }

    private function getUser($removePassword = FALSE)
    {
        $_user = getUser([$this->user->primary_key => getApiKey()], $removePassword);
        if (!$_user) {
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_NOT_FOUND,
                "message"       => "Data profile tidak ditemukan!",
                "data"          => NULL
            ], REST_Controller::HTTP_OK);
        }

        return $_user;
    }
}
