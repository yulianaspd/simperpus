<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(['m_kategori','m_auth']);
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
		$data['rak'] = $this->m_kategori->getRak()->result();

		$this->load->view('layout/header', $data);
		$this->load->view('kategori/create', $data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$rak_id = $this->input->post('rak_id');
		$nama 	= $this->input->post('nama');
		$data = array (
			'rak_id' => $rak_id,
			'nama'	 => $nama
		);

		$this->m_kategori->storeData($data);
		redirect('kategori/index');
	}

	public function edit($id){
		$where = array('id' => $id);
		$data['title'] = 'Edit Kategori';
		$data['icon'] = 'fa fa-list';
		$data['rak'] = $this->m_kategori->getRak()->result();
		$data['edit_data'] = $this->m_kategori->getEdit($where)->result();

		$this->load->view('layout/header',$data);
		$this->load->view('kategori/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
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
		redirect('kategori/index');

	}

	public function delete($id){
		$where = array(
			'id' => $id;
		);
		$this->m_kategori->deleteData($where);
		redirect('kategori/index');		
	}

}
