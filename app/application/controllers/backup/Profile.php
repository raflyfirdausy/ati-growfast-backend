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
        // d($data);
        $this->loadRFLView("profile/index", $data);
    }

    public function ubahProfile()
    {
        $id_data        =  $this->session->userdata(SESSION)["id"];
        $username       = $this->input->post("username");
        $nama           = $this->input->post("nama");
        $password       = $this->input->post("password");
        $nohp           = $this->input->post("nohp");
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
                'field' => 'nohp',
                'label' => 'No HP',
                'rules' => 'required|trim|numeric|min_length[10]|max_length[13]'
            ],
            [
                'field' => 'jenis_kelamin',
                'label' => 'Jenis Kelamin',
                'rules' => 'trim'
            ],
        ];

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $dataSimpan = [
                "username"          => $username,
                "password"          => md5($password),
                "nama"              => $nama,
                "nohp"              => $nohp,
                "jenis_kelamin"     => $jenis_kelamin,
            ];

            if (empty($password)) {
                unset($dataSimpan["password"]);
            }

            $simpan = $this->user->update($dataSimpan, $id_data);
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

    private function _uploadImage()
    {
        $configFile['upload_path']      = LOKASI_FOTO_AKUN;
        $configFile['allowed_types']    = 'jpeg|jpg|png';
        $configFile['remove_space']     = TRUE;
        $configFile['overwrite']        = TRUE;
        $configFile['encrypt_name']     = TRUE;
        $configFile['max_size']         = 1024 * 5;
        $this->load->library('upload', $configFile);
        $this->upload->initialize($configFile);
        if (!file_exists(LOKASI_FOTO_AKUN)) {
            mkdir(LOKASI_FOTO_AKUN, 0777, TRUE);
        }

        if ($this->upload->do_upload('foto')) {
            return $this->upload->data("file_name");
        }
    }

    public function ubahPassword()
    {
        $password_lama              = $this->input->post("password_lama", true);
        $password_baru              = $this->input->post("password_baru", true);
        $konfirmasi_password_baru   = $this->input->post("konfirmasi_password_baru", true);

        $akun = $this->akun
            ->fields("id, password")
            ->get($this->userData['id']);
        if (md5($password_lama) != $akun['password']) {
            d_error([
                "message"   => "Password lama tidak sesuai!",
                "data"      => []
            ]);
        }

        $config = [
            [
                'field' => 'password_lama',
                'label' => 'Password Lama',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'password_baru',
                'label' => 'Password Baru',
                'rules' => 'required|trim|min_length[6]'
            ],
            [
                'field' => 'konfirmasi_password_baru',
                'label' => 'Konfirmasi Password Baru',
                'rules' => 'required|trim|min_length[6]'
            ],
        ];

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            if (md5($password_baru) != md5($konfirmasi_password_baru)) {
                d_error([
                    "message"   => "Konfirmasi password baru tidak sama!",
                    "data"      => []
                ]);
            }

            if (md5($password_baru) == md5($password_lama)) {
                d_error([
                    "message"   => "Password baru harus berbeda dengan password lama!",
                    "data"      => []
                ]);
            }
            $simpan = $this->akun->update([
                "password"          => md5($password_baru),
            ], $this->userData['id']);
            if ($simpan) {
                d_success([
                    "message"   => "Berhasil mengubah password!",
                    "data"      => []
                ]);
            } else {
                d_error([
                    "message"   => "Gagal mengubah password! Silahkan coba lagi",
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
