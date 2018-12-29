<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerbit extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_penerbit');
	}

	public function index()
	{
		
	}

}
