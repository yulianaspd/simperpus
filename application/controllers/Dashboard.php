<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Login');
	}

	public function index()
	{
		 if($this->Login->loggedIn())
        {
            $this->load->view("v_dashboard");         
        }else{
            redirect(base_url("auth"));
        }
	}

}
