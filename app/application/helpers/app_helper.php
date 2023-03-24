<?php

define("SESSION",               "GROWFASTSESSION");
define("LOKASI_PROFILE",        "assets/img/profile/");


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