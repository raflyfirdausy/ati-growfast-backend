<?php

define("SESSION",                       "GROWFASTSESSION");
define("LOKASI_LOGO",                   "assets/img/ati_orange.svg");
define("GAMBAR_NOT_FOUND",              "assets/img/notfound.jpg");
define("LOKASI_PROFILE",                "assets/img/profile/");
define("LOKASI_ALAT_BARANG_GAMBAR",     "assets/img/alat_barang/gambar/");
define("LOKASI_ALAT_BARANG_PDF",        "assets/img/alat_barang/pdf/");

//!TODO : CHECK DIRECTORY IS EXIST OR NOT
$listDirectoryCheck  = [
    LOKASI_PROFILE,
    LOKASI_ALAT_BARANG_PDF,
    LOKASI_ALAT_BARANG_GAMBAR
];

foreach ($listDirectoryCheck as $list) {
    if (!file_exists($list)) {
        mkdir($list, 0777, TRUE);
    }
}


if (!function_exists("getApiKey")) {
    function getApiKey()
    {
        $CI = &get_instance();
        $api_key_variable = $CI->config->item('rest_key_name');
        $key_name   = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
        $apiKey     = $CI->input->server($key_name);
        return $apiKey;
    }
}


if (!function_exists("getUser")) {
    function getUser($kondisi, $removePassword = TRUE)
    {
        $CI         = &get_instance();
        $load       = $CI->load->model(["User_model" => "user"]);
        $_user      = $CI->user
            ->where($kondisi)
            ->with_instansi("fields:nama,no_telp,direktur")
            ->with_prov("fields:nama")
            ->with_kab("fields:nama")
            ->with_kec("fields:nama")
            ->with_kel("fields:nama")
            ->get();

        if (!$_user) {
            return FALSE;
        }

        if ($removePassword) {
            if (isset($_user["password"])) {
                unset($_user["password"]);
            }
        }

        return $_user;
    }
}

if (!function_exists("generateKodeAlatBarang")) {
    function generateKodeAlatBarang()
    {
        $CI         = &get_instance();
        $load       = $CI->load->model(["AlatBarang_model" => "alatBarang"]);

        $kode       = generator(5);
        $cekKode    = $CI->alatBarang->where(["kode" => $kode])->get();
        if ($cekKode) {
            return generateKodeAlatBarang();
        }
        return $kode;
    }
}
