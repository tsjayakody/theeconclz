<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_controller extends CI_Controller {

    public function index() {
        $this->load->view('pages/content');
    }
}
