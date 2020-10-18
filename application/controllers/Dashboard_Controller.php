<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_controller extends CI_Controller {


    public function index(){
        $this->load->view('pages/dashboard');
    }
}
