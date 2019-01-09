<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_kategori');
	}

	public function index()
	{
		$data['title'] = 'Kategori';
		$data['icon'] = 'fa fa-list';
		$data['kategori'] = $this->m_kategori->get_data()->result();
		$this->load->view('kategori/index', $data);
	}

	public function show(){

	}

	public function create(){
		$data['title'] = 'Input Kategori';
		$data['icon'] = 'fa fa-list';
		$data['rak'] = $this->m_kategori->get_rak()->result();
		$this->load->view('kategori/create', $data);
	}

	public function store(){
		$rak_id = $this->input->post('rak_id');
		$nama 	= $this->input->post('nama');
		$data = array (
			'rak_id' => $rak_id,
			'nama'	 => $nama
		);

		$this->m_kategori->store_data($data);
		redirect('kategori/index');
	}

	public function edit($id){
		$where = array('id' => $id);
		$data['title'] = 'Edit Kategori';
		$data['icon'] = 'fa fa-list';
		$data['rak'] = $this->m_kategori->get_rak()->result();
		$data['edit_data'] = $this->m_kategori->get_edit($where)->result();
		$this->load->view('kategori/edit', $data);
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

		$this->m_kategori->update_data($where,$data);
		redirect('kategori/index');

	}

	public function delete($id){
		$where = array(
			'id' => $id;
		);
		$this->m_kategori->delete_data($where);
		redirect('kategori/index');		
	}

}
