<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penulis extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(['m_auth','m_penulis']);
	}

	public function index()
	{
		if( $this->m_auth->loggedIn() ){
			$data['title']	= 'Penulis';
			$data['icon']	= 'fa fa-list';
			$data['penulis'] = $this->m_penulis->getData()->result();

			$this->load->view('layout/header', $data);
			$this->load->view('penulis/index', $data);
			$this->load->view('layout/footer');
		}else{
			$this->load->view('v_login');
		}
	}

	public function show($id){

	}

	public function create(){
		$data['title']	= 'Input Penulis';
		$data['icon']	= 'fa fa-list';

		$this->load->view('layout/header', $data);
		$this->load->view('penulis/create', $data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$nama	= $this->input->post('name');
		$data = array(
			'nama'	=> $nama
		);
		$this->m_penulis->storeData($data);
		redirect('penulis/index');
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['title'] = 'Edit Penulis';
		$data['icon'] = 'fa fa-list';
		$data['edit_data'] = $this->m_penulis->getEdit($where)->result();

		$this->load->view('layout/header', $data);
		$this->load->view('penulis/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		$id 	= $this->input->post('id');
		$name 	= $this->input->post('nama');
		$updated_at	= date('Y-m-d H:i:s');

		$data = array(
			'nama'		 => $nama,
			'updated_at' => $updated_at
		);

		$where = array(
			'id'	=> $id
		);

		$this->m_penulis->updateData($where,$data);
		redirect('penulis/index');
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_penulis->deleteData($where);
		redirect('kategori/index');
	}

}
