<?php

class InstansiView_model extends Custom_model
{
    public $table                   = 'v_instansi';
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
