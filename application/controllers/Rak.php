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
		$this->form_validation->set_rules('kode','Kode','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
			$kode = $this->input->post('kode');
			$data = array(
				'kode'	=> $kode;
			);
			$this->m_rak->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil update. </div>');
			redirect('rak/create');
		}else{
			redirect('rak/create');
		}
		
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
		$this->form_validation->set_rules('kode','Kode','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
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
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil update. </div>');
			redirect('rak/edit');
		}else{
			redirect('rak/edit');
		}
	}

	public function delete($id){
		$where = array(
			'id'	=> $id;
		);
		$this->m_rak->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil dihapus </div>');
			redirect('buku/index');
		redirect('rak/index');
	}


}
