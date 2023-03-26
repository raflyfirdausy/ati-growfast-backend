<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Petugas extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "User_model"        => "user",
            "UserView_model"    => "vUser"
        ]);


        $this->module           = "User Petugas";
        $this->model            = $this->user;
        $this->modelView        = $this->vUser;
        $this->fieldForm        = $this->_getFieldForm();
        $this->kondisiGetData   = ["role" => PETUGAS];
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
                "col"               => 6,
                "type"              => "hidden",
                "name"              => "role",
                "label"             => "",
                "value"             => PETUGAS,
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "username",
                "label"             => "Username",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "nama",
                "label"             => "Nama",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 12,
                "type"              => "password",
                "name"              => "password",
                "label"             => "Password",
                "note_edit"         => "Kosongi jika tidak ingin mengubah password",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => true,
                "hideFromEdit"      => true,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "jenis_kelamin",
                "name_alias"        => "jenis_kelamin",
                "label"             => "Jenis Kelamin",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => FALSE,               //! Set true if chaining
                    "to"            => NULL,                //! Set name of target chaining
                    "serverSide"    => FALSE,                //! Set true if server side
                    "data"          => [
                        [
                            "value" => "LAKI-LAKI",
                            "label" => "LAKI-LAKI",
                        ],
                        [
                            "value" => "PEREMPUAN",
                            "label" => "PEREMPUAN",
                        ]
                    ]
                ]
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "no_telp",
                "label"             => "No Telp Petugas",
                "numberOnly"        => true,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "id_prov",
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
                "name"              => "id_kab",
                "name_alias"        => "kab_nama",
                "label"             => "Kabupaten",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => TRUE,                //! Set true if chaining
                    "to"            => "id_prov",           //! Set name of target chaining
                    "reset"         => ["kec", "kel"],
                    "serverSide"    => TRUE,                //! Set true if server side
                    "data"          => base_url($this->pathUrl . "/findKabupaten/")       //! Set array if server side and url if not client side
                ],
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "id_kec",
                "name_alias"        => "kec_nama",
                "label"             => "Kecamatan",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => TRUE,                //! Set true if chaining
                    "to"            => "id_kab",           //! Set name of target chaining
                    "reset"         => ["kel"],
                    "serverSide"    => TRUE,                //! Set true if server side
                    "data"          => base_url($this->pathUrl . "/findKecamatan/")       //! Set array if server side and url if not client side
                ],
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "id_kel",
                "name_alias"        => "kel_nama",
                "label"             => "Desa / Kelurahan",
                "numberOnly"        => false,
                "required"          => true,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
                "options"       => [
                    "chain"         => TRUE,                //! Set true if chaining
                    "to"            => "id_kec",           //! Set name of target chaining
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
                "col"               => 6,
                "type"              => "textarea",
                "name"              => "alamat",
                "label"             => "Alamat Detail",
                "numberOnly"        => true,
                "required"          => false,
                "hideFromTable"     => false,
                "hideFromEdit"      => false,
                "hideFromCreate"    => false,
            ],
            [
                "col"               => 6,
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
            "title"         => $this->module,
            "URL_RESET"     => base_url("$this->pathUrl/reset/")
        ];
        $this->loadRFLView("master/user/petugas", $data);
    }

    public function reset()
    {
        $id_reset               = $this->input->post("id_reset");
        $password               = $this->input->post("password_baru");

        $config = [
            [
                'field' => 'id_reset',
                'label' => 'ID Reset',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'password_baru',
                'label' => 'Password Baru',
                'rules' => 'trim|required|min_length[8]',
            ],
            [
                'field' => 'konfirmasi_password',
                'label' => 'Konfirmasi password',
                'rules' => 'trim|required|matches[password_baru]',
            ],
        ];

        $load   = $this->form_validation->set_rules($config);
        $run    = $this->form_validation->run();
        if (!$run) {
            $error  = $this->form_validation->error_array();
            echo json_encode([
                "code"      => 503,
                "message"   => validationError($error)
            ]);
            die;
        }

        $cek    = $this->model->where([$this->model->primary_key => $id_reset])->get();
        if (!$cek) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Data tidak ditemukan!"
            ]);
            die;
        }

        $update = $this->model
            ->where([$this->model->primary_key => $cek[$this->model->primary_key]])
            ->update(["password" => md5($password)]);

        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mereset password"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Berhasil melakukan reset password $this->module"
        ]);
        die;
    }

    public function create()
    {
        header('Content-Type: application/json');

        $data = [];
        foreach ($this->fieldForm as $form) {
            $data[$form["name"]] = $this->input->post($form["name"]);
        }

        //TODO : CEK USERNAME
        $cekusername = $this->model->where(["username" => $data["username"]])->get();
        if ($cekusername) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan data $this->module. Keterangan : Username sudah digunakan. Silahkan gunakan username yang lain"
            ]);
            die;
        }

        $data["password"]   = md5($data["password"]);

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
}
