<?php

class Wilayah_model extends Custom_model
{
    public $table                   = 'wilayah';
    public $primary_key             = 'kode';
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();
    }
}
