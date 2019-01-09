<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penulis extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_penulis');
	}

	public function index()
	{
		$data['title']	= 'Penulis';
		$data['icon']	= 'fa fa-list';
		$data['kategori'] = $this->m_penulis->get_data()->result();
		$this->load->view('penulis/index', $data);
	}

	public function show($id){

	}

	public function create(){
		$data['title']	= 'Input Penulis';
		$data['icon']	= 'fa fa-list';
		$this->load->view('penulis/create', $data);
	}

	public function store(){
		$nama	= $this->input->post('name');
		$data = array(
			'nama'	=> $nama
		);
		$this->m_penulis->store_data($data);
		redirect('penulis/index');
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['title'] = 'Edit Penulis';
		$data['icon'] = 'fa fa-list';
		$data['edit_data'] = $this->m_penulis->get_edit($where)->result();
		$this->load->view('penulis/edit', $data);
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

		$this->m_penulis->update_data($where,$data);
		redirect('penulis/index');
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_penulis->delete_data($where);
		redirect('kategori/index');
	}

}
