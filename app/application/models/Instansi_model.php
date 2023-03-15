<?php

class Instansi_model extends Custom_model
{
    public $table                   = 'm_instansi';
    public $primary_key             = 'uuid';
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();
    }
}
