<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rak extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(['m_auth','m_rak']);
	}

	public function index()
	{
		if( $this->m_auth->loggedIn() ){
			$data['title'] 	= 'Rak';
			$data['icon'] 	= 'fa fa-list';
			$data['rak']	= $this->m_rak->getData()->result();

			$this->load->view('layout/header', $data);
			$this->load->view('rak/index', $data);
			$this->load->view('layout/footer');
		}else{
			$this->load->view('v_login');
		}
	}

	public function show($id){

	}

	public function create(){
		$data['title']	= 'Input Rak';
		$data['icon']	= 'fa fa-list';

		$this->load->view('layout/header', $data);
		$this->load->view('rak/create', $data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$kode = $this->input->post('kode');
		$data = array(
			'kode'	=> $kode;
		);
		$this->m_rak->storeData($data);
		redirect('rak/index');
	}

	public function edit($id){
		$where = array (
			'id'	=> $id;
		);
		$data['title'] = 'Edit Kategori';
		$data['icon'] = 'fa fa-list';
		$data['edit_rak'] = $this->m_rak->getEdit($where)->result();

		$this->load->view('layout/header', $data);
		$this->load->view('rak/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		$id 	= $this->input->post('id');
		$kode	= $this->input->post('kode');
		$updated_at = date('Y-m-d H:i:s');

		$data = array(
			'kode'			=> $kode,
			'updated_at'	=> $updated_at
		);

		$where = array(
			'id'	=> $id
		);

		$this->m_rak->updateData($where,$data);
		redirect('rak/index');
	}

	public function delete($id){
		$where = array(
			'id'	=> $id;
		);
		$this->m_rak->deleteData($where);
		redirect('rak/index');
	}


}
