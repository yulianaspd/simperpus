<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_auth','m_dashboard');
	}

	public function index()
	{
		if($this->m_auth->loggedIn())
        {
			$this->load->view('layout/header');
			$this->load->view('v_dashboard');  
			$this->load->view('layout/footer');       
        }else{
            redirect(base_url("auth"));
        }
	}

}
