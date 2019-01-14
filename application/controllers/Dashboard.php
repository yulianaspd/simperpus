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
        	$data['title'] = 'Dashboard';
        	$data['dashboard'] ='';
        	$data['uri']	= $this->uri->segment(1);
			$this->load->view('layout/header', $data);
			$this->load->view('v_dashboard', $data);  
			$this->load->view('layout/footer');       
        }else{
            redirect(base_url("auth"));
        }
	}

}
