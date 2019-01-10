<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerbit extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(['m_penerbit','m_auth']);
	}

	public function index()
	{
		if( $this->m_auth->loggedIn() ){
			$data['title']	= 'Penerbit';
			$data['icon']	= 'fa fa-list';
			$data['penerbit'] = $this->m_penerbit->getData()->result();

			$this->load->view('layout/header', $data);
			$this->load->view('penerbit/index', $data);
			$this->load->view('layout/footer');
		}else{
			$this->load->view('v_login');
		}
	}

	public function show($id){

	}

	public function create(){
		$data['title'] = 'Input Penerbit';
		$data['icon'] = 'fa fa-list';

		$this->load->view('layout/header', $data);
		$this->load->view('penerbit/index',$data);
		$this->load->view('layout/footer');
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
		$this->m_penerbit->storeData($data);
		redirect('penerbit/index');
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['title'] = 'Edit Penerbit';
		$data['icon'] = 'fa fa-list';
		$data['edit_data'] = $this->m_penerbit->getEdit($where)->result();

		$this->load->view('layout/header', $data);
		$this->load->view('penerbit/edit', $data);
		$this->load->view('layout/footer'); 
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

		$this->m_penerbit->updateData($where, $data);
		redirect('penerbit/index');
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_penerbit->deleteData($where);
		redirect('penerbit/index');
	}

}
