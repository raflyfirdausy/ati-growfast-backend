<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
    }

    public function run()
    {
        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo json_encode([
                "message"   => "Migrations running successfully",
                "data"      => $this->migration->find_migrations()
            ]);
        }
    }
}
