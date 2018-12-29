<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rak extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_rak');
	}

	public function index()
	{
		
	}

}
