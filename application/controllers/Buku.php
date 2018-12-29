<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_buku');
	}

	public function index()
	{
		if( $this->Login->loggedIn() ){
			redirect(base_url("dashboard"));
		}else{
			$this->load->view('v_login');
		}
	}

}
