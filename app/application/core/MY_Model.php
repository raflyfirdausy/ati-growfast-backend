<?php

class MY_Model extends CI_Model
{
    public $userData = null;
    public function __construct()
    {
        parent::__construct();
        // $ses = $this->session->userdata(SESSION);
    }

    public function where_between($field, $min, $max)
    {
        $this->_database->where("$field BETWEEN '$min' AND '$max'");
        return $this;
    }
}
