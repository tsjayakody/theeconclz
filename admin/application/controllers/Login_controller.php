<?php
class Login_controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
        if (isset($_SESSION['user_data'])) { // if client already loggedin
            redirect('/dashbord');
        } 
    }

    public function index() {
        $this->load->view('login');
    }
}