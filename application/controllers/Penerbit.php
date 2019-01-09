<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerbit extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_penerbit');
	}

	public function index()
	{
		$data['title']	= 'Penerbit';
		$data['icon']	= 'fa fa-list';
		$data['penerbit'] = $this->m_penerbit->get_data()->result();
		$this->load->view('penerbit/index', $data);
	}

	public function show($id){

	}

	public function create(){
		$data['title'] = 'Input Penerbit';
		$data['icon'] = 'fa fa-list';
		$this->load->view('penerrbit/index',$data);
	}

	public function store(){
		$nama	= $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$email	= $this->input->post('email');
		$telepon = $this->input->post('telepon');

		$data = array(
			'nama'		=> $nama,
			'alamat' 	=> $alamat,
			'email'  	=> $email,
			'telepon'	=> $telepon
		);
		$this->m_penerbit->store_data($data);
		redirect('penerbit/index');
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['title'] = 'Edit Penerbit';
		$data['icon'] = 'fa fa-list';
		$data['edit_data'] = $this->m_penerbit->get_edit($where)->result();
		$this->load->view('penerbit/edit', $data); 
	}

	public function update(){
		$id 	= $this->input->post('id');
		$nama	= $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$email	= $this->input->post('email');
		$telepon = $this->input->post('telepon');
		$updated_at	= date('Y-m-d H:i:s');

		$data = array(
			'nama'		=> $nama,
			'alamat' 	=> $alamat,
			'email'  	=> $email,
			'telepon'	=> $telepon
			'updated_at' => $updated_at
		);

		$where = array(
			'id'	=> $id
		);

		$this->m_penerbit->update_data($where, $data);
		redirect('penerbit/index');
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_penerbit->delete_data($where);
		redirect('penerbit/index');
	}

}
