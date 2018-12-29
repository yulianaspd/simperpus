<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penulis extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_penulis');
	}

	public function index()
	{
		
	}

}
