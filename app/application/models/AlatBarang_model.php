<?php

class AlatBarang_model extends Custom_model
{
    public $table                   = 'm_alat_barang';
    public $primary_key             = 'id';
    public $uuid                    = TRUE;
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();
    }
}
