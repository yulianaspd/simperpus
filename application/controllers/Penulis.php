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
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
			$nama	= $this->input->post('name');
			$data = array(
				'nama'	=> $nama
			);
			$this->m_penulis->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data tersimpan. </div>');
			redirect('penulis/create');
		}else{
			redirect('penulis/create');
		}
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
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
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
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil update. </div>');
			redirect('penulis/edit');
		}else{
			redirect('penulis/edit');
		}
		
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_penulis->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil dihapus </div>');
			redirect('penulis/index');
		redirect('penulis/index');
	}

}
