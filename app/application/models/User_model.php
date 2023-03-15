<?php

class User_model extends Custom_model
{
    public $table                   = 'm_user';
    public $primary_key             = 'uuid';
    public $uuid                    = TRUE;
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();

        $this->has_one['prov'] = array(
            'foreign_model'     => 'Wilayah_model',
            'foreign_table'     => 'wilayah',
            'foreign_key'       => 'kode',
            'local_key'         => 'id_prov'
        );

        $this->has_one['kab'] = array(
            'foreign_model'     => 'Wilayah_model',
            'foreign_table'     => 'wilayah',
            'foreign_key'       => 'kode',
            'local_key'         => 'id_kab'
        );

        $this->has_one['kec'] = array(
            'foreign_model'     => 'Wilayah_model',
            'foreign_table'     => 'wilayah',
            'foreign_key'       => 'kode',
            'local_key'         => 'id_kec'
        );

        $this->has_one['kel'] = array(
            'foreign_model'     => 'Wilayah_model',
            'foreign_table'     => 'wilayah',
            'foreign_key'       => 'kode',
            'local_key'         => 'id_kel'
        );

        $this->has_one['instansi'] = array(
            'foreign_model'     => 'Instansi_model',
            'foreign_table'     => 'm_instansi',
            'foreign_key'       => 'uuid',
            'local_key'         => 'uuid_instansi'
        );
    }
}
