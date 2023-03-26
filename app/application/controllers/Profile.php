<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            "User_model"    => "user"
        ]);
    }

    public function index()
    {
        $data = [
            "title"         => "Profile",
            "profile"       => $this->user->where(["id" => $this->session->userdata(SESSION)["id"]])->get()
        ];
        $this->loadRFLView("profile/data_profile", $data);
    }

    public function ubahProfile()
    {
        $id_data        = $this->session->userdata(SESSION)["id"];
        $username       = $this->input->post("username");
        $nama           = $this->input->post("nama");
        $password       = $this->input->post("password");
        $no_telp        = $this->input->post("no_telp");
        $jenis_kelamin  = $this->input->post("jenis_kelamin");

        $config = [
            [
                'field' => 'username',
                'label' => 'username',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim',
            ],
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'no_telp',
                'label' => 'No Telp',
                'rules' => 'required|trim|numeric|min_length[10]|max_length[13]'
            ],
            [
                'field' => 'jenis_kelamin',
                'label' => 'Jenis Kelamin',
                'rules' => 'trim'
            ],
        ];

        //TODO : CEK
        $cek            = $this->user->where(["id" => $id_data])->get();
        if (!$cek) {
            d_error([
                "message"   => "Gagal mengubah data profil! Profile tidak ditemukan",
                "data"      => []
            ]);
        }

        if($cek["username"] != $username){
            //TODO : CEK USERNAME
            $cekUsername = $this->user->where(["username" => $username, "id !=" => $cek["id"]])->get();
            if($cekUsername){
                d_error([
                    "message"   => "Username sudah terdaftar pada akun lain. Silahkan gunakan username yang lain",
                    "data"      => []
                ]);
            }
        }

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $dataSimpan = [
                "username"          => $username,
                "password"          => md5($password),
                "nama"              => $nama,
                "no_telp"           => $no_telp,
                "jenis_kelamin"     => $jenis_kelamin,
            ];

            if (empty($password)) {
                unset($dataSimpan["password"]);
            }

            $simpan = $this->user->where([$this->user->primary_key => $id_data])->update($dataSimpan);
            if ($simpan) {
                d_success([
                    "message"   => "Berhasil mengubah data profil!",
                    "data"      => []
                ]);
            } else {
                d_error([
                    "message"   => "Gagal mengubah data profil! Silahkan coba lagi",
                    "data"      => []
                ]);
            }
        } else {
            d_error([
                "message"   => $this->form_validation->error_array(),
                "data"      => []
            ]);
        }
    }
}
