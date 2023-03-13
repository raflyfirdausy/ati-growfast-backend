<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists("env")){
    function env($key = ""){
        return isset($_ENV[$key]) ? $_ENV[$key] : NULL;
    }
}

if (!function_exists('validationError')) {
    function validationError($error)
    {
        $message = implode('<br>', array_map(
            function ($v, $k) {
                if (is_array($v)) {
                    return $k . '[]=' . implode('&' . $k . '[]=', $v);
                } else {
                    return $k . ' : ' . $v;
                }
            },
            $error,
            array_keys($error)
        ));

        return $message;
    }
}

if (!function_exists('get_external_ip')) {
    function get_external_ip()
    {
        // Batasi waktu mencoba
        $options = stream_context_create(array(
            'http' =>
            array(
                'timeout' => 2 //2 seconds
            )
        ));
        $externalContent = file_get_contents('http://checkip.dyndns.com/', false, $options);
        preg_match('/\b(?:\d{1,3}\.){3}\d{1,3}\b/', $externalContent, $m);
        $externalIp = $m[0];
        return $externalIp;
    }
}

if (!function_exists('ej')) {
    function ej($x)
    {
        echo json_encode($x);
    }
}

if (!function_exists('d')) {
    function d($x)
    {
        return die(json_encode($x));
    }
}

if (!function_exists('debuging')) {
    function debuging($x)
    {
        echo "<pre>";
        print_r($x);
        echo "</pre>";
        exit;
    }
}

if (!function_exists('currency')) {
    function currency($x)
    {
        return number_format($x, 0, ',', '.');
    }
}

//FUNCTION INI BELUM BERJALAN DENGAN BAIK
if (!function_exists('e')) {
    function e($data)
    {
        return isset($data) ? $data : "";
    }
}

if (!function_exists('generator')) {
    function generator($length = 7)
    {
        return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
}

if (!function_exists('replace_lower')) {
    function replace_lower($string = "")
    {
        preg_replace("/[^A-Za-z0-9]/", "_", strtolower($string));
    }
}

if (!function_exists('ce')) {
    function ce($string = "")
    {
        return ucwords(strtolower($string));
    }
}

if (!function_exists('sc')) {
    function sc($string = "")
    {
        return ucfirst(strtolower($string));
    }
}

if (!function_exists("set")) {
    function set(&$string)
    {
        return isset($string) ? $string : FALSE;
    }
}

if (!function_exists('tanggal_tampil')) {
    function tanggal_tampil($tanggal = "")
    {
        $originalDate = $tanggal;
        $newDate = date("m/d/Y", strtotime($originalDate));
        return $newDate;
    }
}

if (!function_exists('insert_tanggal')) {
    function insert_tanggal($tanggal = "")
    {
        $newDate = date("Y-m-d", strtotime($tanggal));
        return $newDate;
    }
}

if (!function_exists('alphanumspace')) {
    function alphanumspace($string = "")
    {
        return preg_replace("/[^a-zA-Z0-9 ]+/", "", remove_duplicate_space($string));
    }
}

if (!function_exists('alphanum')) {
    function alphanum($string = "")
    {
        return preg_replace("/[^a-zA-Z0-9_]+/", "", remove_duplicate_space($string));
    }
}

if (!function_exists("remove_duplicate_space")) {
    function remove_duplicate_space($string = "")
    {
        return preg_replace('/\s+/', ' ', $string);
    }
}

if (!function_exists("dash")) {
    function dash($string = "")
    {
        return str_replace(" ", "-", $string);
    }
}

if (!function_exists("slug")) {
    function slug($string = "")
    {
        return strtolower(dash(remove_duplicate_space(alphanumspace($string))));
    }
}

if (!function_exists("remove_line_break")) {
    function remove_line_break($string = "")
    {
        return preg_replace("/\r|\n/", "", $string);
    }
}

if (!function_exists("validasi_input_artikel")) {
    function validasi_input_artikel($string = "")
    {
        return str_replace("'", "", remove_line_break($string));
    }
}

if (!function_exists('send_wa')) {
    function send_wa($payload = [])
    {
        $token          = "2c5a8d814a2bc664b8aafb0f57646d68";
        $number         = isset($payload["number"])         ? $payload["number"]        : "";
        $jenis          = "SIMPUS_APP";                                                           //! GANTI JENISNYA SESUAI JENIS PENGIRIMIAN, TERSERAH APAPUN, HURUF BESAR SEMUA TANPA SPASI
        $message        = isset($payload["message"])        ? $payload["message"]       : "";       //! GANTI MESSAGE NYA
        $lampiran       = isset($payload["lampiran"])       ? $payload["lampiran"]      : "";       //! CONTOH SEPERTI INI
        $nama_lampiran  = isset($payload["nama_lampiran"])  ? $payload["nama_lampiran"] : "";       //! CONTOH SEPERTI INI

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL             =>  "http://10.10.16.195:9969/kirim?" .
                "token=" .          urlencode($token) .
                "&number=" .        urlencode($number) .
                "&message=" .       urlencode($message) .
                "&jenis=" .         urlencode($jenis) .
                "&lampiran=" .      (!empty($lampiran) ? urlencode($lampiran) : "") .
                "&nama_lampiran=" . (!empty($nama_lampiran) ? urlencode($nama_lampiran) : ""),
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 5,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'GET',
            CURLOPT_CONNECTTIMEOUT  => 2,

        ));

        $response           = curl_exec($curl);

        curl_close($curl);
        return json_encode(json_decode($response), JSON_PRETTY_PRINT);
    }
}


if (!function_exists('template_send_wa')) {
    function template_send_wa($data = [])
    {
        // $send_message = "*Notifikasi WhatsApp SIMPUS*\n\n";
        $send_message = isset($data["message"]) ? $data["message"] : "\n";
        $send_message .= "Terima Kasih.\n\n";
        $send_message .= "_Pesan ini dikirim oleh WhatsApp BOT Dinas Komunikasi dan Informatika Kabupaten Banyumas_";
        $payload = [
            "number"    => isset($data["number"]) ? $data["number"] : "",
            "message"   => $send_message,
        ];
        return json_decode(send_wa($payload));
    }
}



// if (!function_exists('penyebut')) {
//     function penyebut($nilai)
//     {
//         $nilai = abs($nilai);
//         $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
//         $temp = "";
//         if ($nilai < 12) {
//             $temp = " " . $huruf[$nilai];
//         } else if ($nilai < 20) {
//             $temp = ce(penyebut($nilai - 10)) . " belas";
//         } else if ($nilai < 100) {
//             $temp = ce(penyebut($nilai / 10)) . " puluh" . penyebut($nilai % 10);
//         } else if ($nilai < 200) {
//             $temp = " seratus" . penyebut($nilai - 100);
//         } else if ($nilai < 1000) {
//             $temp = ce(penyebut($nilai / 100)) . " ratus" . penyebut($nilai % 100);
//         } else if ($nilai < 2000) {
//             $temp = " seribu" . penyebut($nilai - 1000);
//         } else if ($nilai < 1000000) {
//             $temp = ce(penyebut($nilai / 1000)) . " ribu" . penyebut($nilai % 1000);
//         } else if ($nilai < 1000000000) {
//             $temp = ce(penyebut($nilai / 1000000)) . " juta" . penyebut($nilai % 1000000);
//         } else if ($nilai < 1000000000000) {
//             $temp = ce(penyebut($nilai / 1000000000)) . " milyar" . penyebut(fmod($nilai, 1000000000));
//         } else if ($nilai < 1000000000000000) {
//             $temp = ce(penyebut($nilai / 1000000000000)) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
//         }
//         return $temp;
//     }
// }

// if (!function_exists('terbilang')) {
//     function terbilang($nilai)
//     {
//         if ($nilai < 0) {
//             $hasil = "minus " . trim(penyebut($nilai));
//         } else {
//             $hasil = trim(penyebut($nilai));
//         }
//         return $hasil;
//     }
// }

if (!function_exists('back')) {
    function back()
    {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        } else {
            return base_url();
        }
        // return base_url();
    }
}



if (!function_exists("d_success")) {
    function d_success($data)
    {
        d([
            "code"      => 200,
            "message"   => $data["message"],
            "data"      => $data["data"],
        ]);
    }
}


if (!function_exists("d_error")) {
    function d_error($data)
    {
        d([
            "code"      => 201,
            "message"   => $data["message"],
            "data"      => $data["data"],
        ]);
    }
}

if (!function_exists('Rupiah')) {
    function Rupiah($nil = 0)
    {
        $nil = $nil + 0;
        if (($nil * 100) % 100 == 0) {
            $nil = $nil . ".00";
        } elseif (($nil * 100) % 10 == 0) {
            $nil = $nil . "0";
        }
        $nil = str_replace('.', ',', $nil);
        $str1 = $nil;
        $str2 = "";
        $dot = "";
        $str = strrev($str1);
        $arr = str_split($str, 3);
        $i = 0;
        foreach ($arr as $str) {
            $str2 = $str2 . $dot . $str;
            if (strlen($str) == 3 and $i > 0) $dot = '.';
            $i++;
        }
        $rp = strrev($str2);
        if ($rp != "" and $rp > 0) {
            return "Rp $rp";
        } else {
            return "Rp 0,00";
        }
    }
}

if (!function_exists('Rupiah2')) {
    function Rupiah2($nil = 0)
    {
        $nil = $nil + 0;
        if (($nil * 100) % 100 == 0) {
            $nil = $nil . ".00";
        } elseif (($nil * 100) % 10 == 0) {
            $nil = $nil . "0";
        }
        $nil = str_replace('.', ',', $nil);
        $str1 = $nil;
        $str2 = "";
        $dot = "";
        $str = strrev($str1);
        $arr = str_split($str, 3);
        $i = 0;
        foreach ($arr as $str) {
            $str2 = $str2 . $dot . $str;
            if (strlen($str) == 3 and $i > 0) $dot = '.';
            $i++;
        }
        $rp = strrev($str2);
        if ($rp != "" and $rp > 0) {
            return "Rp.$rp";
        } else {
            return "-";
        }
    }
}

if (!function_exists('Rupiah3')) {
    function Rupiah3($nil = 0)
    {
        $nil = $nil + 0;
        if (($nil * 100) % 100 == 0) {
            $nil = $nil . ".00";
        } elseif (($nil * 100) % 10 == 0) {
            $nil = $nil . "0";
        }
        $nil = str_replace('.', ',', $nil);
        $str1 = $nil;
        $str2 = "";
        $dot = "";
        $str = strrev($str1);
        $arr = str_split($str, 3);
        $i = 0;
        foreach ($arr as $str) {
            $str2 = $str2 . $dot . $str;
            if (strlen($str) == 3 and $i > 0) $dot = '.';
            $i++;
        }
        $rp = strrev($str2);
        if ($rp != 0) {
            return "$rp";
        } else {
            return "-";
        }
    }
}

if (!function_exists('to_rupiah')) {
    function to_rupiah($inp = '')
    {
        $outp = str_replace('.', '', $inp);
        $outp = str_replace(',', '.', $outp);
        return $outp;
    }
}


if (!function_exists('template_nice_admin')) {
    function template_nice_admin($path = "")
    {
        return base_url("assets/nice_admin/$path");
    }
}

if (!function_exists('asset_ng')) {
    function asset_ng($path = "")
    {
        return base_url("assets/next_generation/$path");
    }
}
