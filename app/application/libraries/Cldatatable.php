<?php

/*
 * By : Johan Aji Setiawan
 * website : http://masjo.com
 * email : johanajisetiawan1118@gmail.com
 *
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Cldatatable
{

    protected $CI;
    // variabel untuk tabel
    protected $tabel;
    // variabel untuk kolom yang di select
    protected $kolom;
    // variabel untuk join tabel
    protected $tabel_join = array();
    // variabel untuk kolom yang di filter
    protected $kolom_cari;
    // variabel untuk blacklist kolom pencarian
    protected $blacklist_kolom_cari;
    // variabel pencarian per kolom
    protected $cari_kolom_where = array();
    // variabel pencarian per kolom
    protected $cari_kolom_like = array();
    // variabel pencarian per kolom between
    protected $cari_kolom_between = array();
    // variabel penyaringan data awal
    protected $filter_dasar;
    // variabel untuk pengurutan / ordering
    protected $urutan_kolom;
    // variabel untuk menampung kolom tambahan
    protected $kolom_tambah = array();
    // variabel untuk menampung hasil query
    protected $rs_data = array();

    public function __construct($parameter = null)
    {
        // Assign the CodeIgniter super-object
        $this->CI = &get_instance();

        if (!empty($parameter)) {
            $this->tabel = isset($parameter['tabel']) ? $parameter['tabel'] : '';
            $this->kolom = isset($parameter['kolom']) ? $parameter['kolom'] : '';
            $this->kolom_cari = isset($parameter['kolom_cari']) ? $parameter['kolom_cari'] : '';
        }
    }

    public function set_tabel($tabel = NULL)
    {
        $this->tabel = $tabel;
        return $this;
    }

    /*
     * Fungsi untuk menentukan kolom mana saja yang akan di pilih / ditampilkan
     */

    public function set_kolom($kolom = NULL)
    {
        $this->kolom = $kolom;
        return $this;
    }

    /*
     * Fungsi untuk join antar tabel
     */

    public function join_tabel($tabel = null, $kolom_id = null, $type = '')
    {
        if (!empty($tabel) && !empty($kolom_id)) {
            $val['tabel'] = $tabel;
            $val['kolom_id'] = $kolom_id;
            $val['type'] = $type;
            $this->tabel_join[] = $val;
        }
        return $this;
    }

    /*
     * Fungsi untuk menentukan kolom yang digunakan pencarian
     */

    public function set_kolom_cari($kolom_cari = NULL)
    {
        $this->kolom_cari = $kolom_cari;
        return $this;
    }

    /*
     * Fungsi untuk menentukan pencarian per kolom where
     */

    public function cari_perkolom_where($kolom = NULL, $val = NULL)
    {
        if (!empty($kolom)) {
            $this->cari_kolom_where[$kolom] = $val;
        }
        return $this;
    }

    /*
     * Fungsi untuk menentukan pencarian per kolom like
     */

    public function cari_perkolom_like($kolom = NULL, $var = NULL, $type = NULL)
    {
        if (!empty($kolom) && !empty($var)) {
            $val['kolom'] = $kolom;
            $val['value'] = $var;
            $val['type'] = $type;
            $this->cari_kolom_like[] = $val;
        }
        return $this;
    }

    /*
     * Fungsi untuk menentukan pencarian per kolom between
     */

    public function cari_perkolom_between($first_date = NULL, $kolom = NULL, $second_date = NULL)
    {
        if (!empty($first_date) && !empty($kolom) && !empty($second_date)) {
            $val['first_date'] = $first_date;
            $val['kolom'] = $kolom;
            $val['second_date'] = $second_date;
            $this->cari_kolom_between[] = $val;
        }
        return $this;
    }

    /*
     * Fungsi untuk menentukan filter dasar
     */

    public function saring_data($kolom = NULL, $val = NULL)
    {
        if (!is_null($kolom) && !is_null($val)) {
            $this->filter_dasar[$kolom] = $val;
        }
        if (!is_null($kolom) && is_null($val)) {
            $this->filter_dasar = $kolom;
        }
        return $this;
    }

    /*
     * Fungsi untuk menambah kolom 
     */

    public function tambah_kolom($nama_kolom = NULL, $isi_kolom = NULL)
    {
        $this->kolom_tambah[$nama_kolom] = $isi_kolom;
        return $this;
    }

    /*
     * Fungsi untuk mengabaikan kolom yang digunakan untuk pencarian
     */

    public function abaikan_kolom_cari($nama_kolom = NULL)
    {
        $this->blacklist_kolom_cari = $nama_kolom;
        return $this;
    }

    /*
     * Fungsi untuk mengabaikan kolom yang digunakan untuk pencarian
     */

    public function urutkan($nama_kolom = NULL, $pengurutan = 'ASC')
    {
        $this->urutan_kolom[$nama_kolom] = $pengurutan;
        return $this;
    }

    protected function _get_data()
    {

        if (empty($this->tabel))
            return FALSE;

        $parameter = array(
            'kolom_select' => $this->kolom,
            'kolom_cari' => $this->_get_kolom_cari(),
            'tabel' => $this->tabel,
            'join_tabel' => $this->tabel_join
        );
        //        $this->rs_data = $this->CI->m_cldatatable->get_datatable($parameter);
        $this->rs_data = $this->_get_data_datatable($parameter);
    }

    /*
     * Fungsi untuk memanipulasi nilai berdasarkan nama kolom yang di select
     * Parameter yang digunakan kolom dan fungsi
     * 
     * fungsi menggunakan unnamed function
     */

    public function modif_data($kolom = null, $funct = null)
    {
        if (empty($this->rs_data))
            $this->_get_data();
        foreach ($this->rs_data['data'] as $i => $vdata) {
            $this->rs_data['data'][$i][$kolom] = $funct($vdata);
        }
        return $this;
    }

    public function get_datatable()
    {

        if (empty($this->rs_data))
            $this->_get_data();
        // nomor
        $no = $this->CI->input->post('start') + 1;
        $lskolom = isset($this->rs_data['data'][0]) ? array_keys($this->rs_data['data'][0]) : array();
        foreach ($this->rs_data['data'] as $idata => $vdata) {
            $arraykol = array();
            // tambah kolom nomor
            $arraykol['no'] = $no++ . '.';
            // loop data
            foreach ($lskolom as $ivkol => $vkol) {
                $arraykol[$vkol] = isset($vdata[$vkol]) ? $vdata[$vkol] : '';
                ${$ivkol} = $vdata[$vkol];
            }

            // cek jika ada kolom tambahan sekaligus memparsing variabel sesuai nama kolom
            foreach ($this->kolom_tambah as $itambahkol => $vtambahkolom) {
                $arraykol[$itambahkol] = $this->_parse_var($vtambahkolom, $lskolom, $vdata);
            }
            $this->rs_data['data'][$idata] = $arraykol;
        }
        return json_encode($this->rs_data);
    }

    protected function _get_kolom_cari()
    {

        // jika tidak ada kolom blacklist dan kolom cari tidak diisi
        // maka otomatis kolom yang dipilih akan menjadi target kolom pencarian
        if (empty($this->blacklist_kolom_cari) && empty($this->kolom_cari))
            return $this->kolom;

        $blacklist = (!empty($this->blacklist_kolom_cari)) ? explode(',', str_replace(' ', '', $this->blacklist_kolom_cari)) : array();
        $kolom = explode(',', str_replace(' ', '', $this->kolom));
        $kolom_cari = (!empty($this->kolom_cari)) ? explode(',', str_replace(' ', '', $this->kolom_cari)) : array();

        // jika kolom cari kosong maka kolom yang dipilih dikurangi kolom blacklist
        if (empty($kolom_cari))
            return array_diff($kolom, $blacklist);

        return array_diff($kolom_cari, $blacklist);
    }

    protected function _parse_var($vtambahkolom = NULL, $data = NULL, $vdata = NULL)
    {
        // membuat variabel baru dengan nama kolom
        foreach ($data as $ivkol => $vkol) {
            ${$vkol} = $vdata[$vkol];
        }

        // mencari variable
        preg_match_all('/\{{(.*?)\}}/', $vtambahkolom, $match);

        // konversi variabel
        foreach ($match[0] as $i => $vmatch) {
            $vtambahkolom = str_replace($vmatch, ${$match[1][$i]}, $vtambahkolom);
        }
        return $vtambahkolom;
    }

    protected function _cek_pencarian_perkolom()
    {
        foreach ($this->CI->input->post('columns') as $vcols) {
            if ($vcols['searchable'] == 'true' && $vcols['search']['value'] != '' && !array_key_exists($vcols['data'], $this->kolom_tambah))
                $this->cari_perkolom_like($vcols['data'], $vcols['search']['value'], 'both');
        }
    }

    protected function _get_data_datatable($parameter)
    {
        if (empty($parameter))
            return FALSE;
        $db = $this->CI->load->database('', TRUE);

        // cek pencarian perkolom
        $this->_cek_pencarian_perkolom();
        // select data
        $db->select($parameter['kolom_select'])->from($parameter['tabel']);

        // join tabel jika ada
        if (!empty($parameter['join_tabel'])) {
            if (is_array($parameter['join_tabel'])) {
                foreach ($parameter['join_tabel'] as $vjoin) {
                    $db->join($vjoin['tabel'], $vjoin['kolom_id'], $vjoin['type']);
                }
            }
        }

        // jika hanya menggunakan kolom tertentu pada keseluruhan data
        if (!empty($this->filter_dasar)) {
            $db->group_start();
            $db->where($this->filter_dasar);
            $db->group_end();
        }

        $option['recordsTotal'] = $db->count_all_results('', FALSE);

        // jika ada pencarian per kolom
        if (!empty($this->cari_kolom_where) || !empty($this->cari_kolom_like) || !empty($this->cari_kolom_between)) {
            $db->group_start();
            if (!empty($this->cari_kolom_where))
                $db->where($this->cari_kolom_where);

            if (!empty($this->cari_kolom_like)) {
                foreach ($this->cari_kolom_like as $vlike) {
                    $db->like($vlike['kolom'], $vlike['value'], $vlike['type']);
                }
            }

            if (!empty($this->cari_kolom_between)) {
                foreach ($this->cari_kolom_between as $vbetween) {
                    // $db->like($vlike['kolom'], $vlike['value'], $vlike['type']);

                    $db->where($vbetween['kolom'] . ' >= ', $vbetween['first_date']);
                    $db->where($vbetween['kolom'] . ' <=', $vbetween['second_date']);
                }
            }

            $db->group_end();
        }

        // jika kolom pencarian diisi
        $cari = $this->CI->input->post('search')['value'] != '' ? $this->CI->input->post('search')['value'] : '';

        // jika kolom cari ada
        if (!empty($cari) && !empty($parameter['kolom_cari'])) {
            // get list colomn
            $lskolom = (!is_array($parameter['kolom_cari'])) ? explode(',', $parameter['kolom_cari']) : $parameter['kolom_cari'];
            $db->group_start();
            foreach ($lskolom as $vkolom) {
                $db->or_like($vkolom, $cari, 'both');
            }
            $db->group_end();
        }
        // hitung data setelah filter
        $option['recordsFiltered'] = $db->count_all_results('', FALSE);

        // ordering
        if (!empty($this->urutan_kolom)) {
            foreach ($this->urutan_kolom as $ko => $vkorder) {
                $db->order_by($ko, $vkorder);
            }
        }

        // order
        if ($this->CI->input->post('order') !== NULL) {
            // deteksi nama kolom yang di urutkan
            foreach ($this->CI->input->post('order') as $vorder) {
                $db->order_by($this->CI->input->post('columns')[$vorder['column']]['data'], $vorder['dir']);
            }
        }

        // limit data
        if ($this->CI->input->post('length') > -1)
            $db->limit($this->CI->input->post('length', TRUE), $this->CI->input->post('start', TRUE));
        $option['draw'] = $this->CI->input->post('draw');
        $option['data'] = $db->get()->result_array();
        return $option;
    }
}
