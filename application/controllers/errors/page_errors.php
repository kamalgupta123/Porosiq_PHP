<?php

session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page_Errors extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function error_404() {
     
        $this->output->set_status_header('404');
        //$data['content'] = 'error_404'; // View name 
        $this->load->view('errors/html/error_404', $data); //loading in my template 
    }

}

?> 