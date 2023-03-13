<?php

class MY_Model extends CI_Model
{
    public $userData = null;
    public function __construct()
    {
        parent::__construct();
        // $ses = $this->session->userdata(SESSION);
    }

    //ADD BY UJI BAGUS PAMBUDI 26 JANUARI 2022 10.12 WIB
    public function where_between($field, $min, $max)
    {
        $this->_database->where("$field BETWEEN '$min' AND '$max'");
        // $this->_database->where("$field BETWEEN CAST($min AS TEXT)::double precision AND CAST($max AS TEXT)::double precision");
        return $this;
    }
}
