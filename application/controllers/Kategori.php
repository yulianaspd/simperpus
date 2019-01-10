<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model([
			'm_kategori',
			'm_rak',
			'm_auth'
		]);
	}

	public function index()
	{
		if( $this->m_auth->loggedIn() ){

			$data['title'] = 'Kategori';
			$data['icon'] = 'fa fa-list';
			$data['kategori'] = $this->m_kategori->getData()->result();

			$this->load->view('layout/header',$data);
			$this->load->view('kategori/index', $data);
			$this->load->view('kategori/footer');	

		}else{
			$this->load->view('v_login');
		}
	}

	public function show(){
		
	}

	public function create(){
		$data['title'] = 'Input Kategori';
		$data['icon'] = 'fa fa-list';
		$data['rak'] = $this->m_rak->getData()->result();

		$this->load->view('layout/header', $data);
		$this->load->view('kategori/create', $data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$this->form_validation->set_rules('rak_id','Rak ID','required');
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
			$rak_id = $this->input->post('rak_id');
			$nama 	= $this->input->post('nama');
			$data = array (
				'rak_id' => $rak_id,
				'nama'	 => $nama
			);
			$this->m_kategori->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data tersimpan. </div>');
			redirect('kategori/create');
		}else{
			redirect('kategori/create');
		}
	}

	public function edit($id){
		$where = array('id' => $id);
		$data['title'] = 'Edit Kategori';
		$data['icon'] = 'fa fa-list';
		$data['rak'] = $this->m_rak->getData()->result();
		$data['edit_data'] = $this->m_kategori->getEdit($where)->result();

		$this->load->view('layout/header',$data);
		$this->load->view('kategori/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		$this->form_validation->set_rules('rak_id','Rak ID','required');
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
			$id 	= $this->input->post('id');
			$rak_id = $this->input->post('rak_id');
			$nama	= $this->input->post('nama');
			$updated_at = date('Y-m-d H:i:s');

			$data = array(
				'rak_id'		=> $rak_id,
				'nama'			=> $nama,
				'updated_at' 	=> $updated_at
			);

			$where = array(
				'id'	=> $id
			);

			$this->m_kategori->updateData($where,$data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil update. </div>');
			redirect('kategori/edit');
		}else{
			redirect('kategori/edit');
		}
	}

	public function delete($id){
		$where = array(
			'id' => $id;
		);
		$this->m_kategori->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil dihapus </div>');
			redirect('kategori/index');
		redirect('kategori/index');		
	}

}
