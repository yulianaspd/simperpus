<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(['m_auth','m_user']);
	}

	public function index()
	{
		if( $this->m_auth->loggedIn() ){
			$data['title'] = 'User';
			$data['icon']  = 'fa fa-users';
			$data['user']  = $this->m_user->getData()->result();

			$this->load->view('layout/header', $data);
			$this->load->view('user/index');	
			$this->load->view('layout/footer');
		}else{
			$this->load->view('v_login');
		}
	}

	public function show($id){

	}

	public function create(){
		$data['title'] = 'Input User';
		$data['icon']  = 'fa fa-users';
		$this->load->view('user/create', $data);
	}

	public function store(){
		$nama 		= $this->input->post('nama');
		$email		= $this->input->post('email');
		$password	= md5($this->input->post('password'));
		$level		= $this->input->post('level');
		
		$data = array(
			'nama'		= $nama,
			'email'		= $email,
			'password'  = $password,
			'level'		= $level
		);

		$this->m_user->storeData($data);
		redirect('user/index');
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['title'] = 'Edit User';
		$data['icon'] = 'fa fa-list';
		$data['edit_data'] = $this->m_user->getEdit($where)->result();

		$this->load->view('layout/header', $data);
		$this->load->view('user/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		$id 		= $this->input->post('id');
		$nama 		= $this->input->post('nama');
		$email		= $this->input->post('email');
		$password	= md5($this->input->post('password'));
		$level		= $this->input->post('level');
		$updated_at	= date('Y-m-d H:i:s');

		$data = array(
			'nama'		= $nama,
			'email'		= $email,
			'password'  = $password,
			'level'		= $level,
			'updated_at' => $updated_at
		);

		$where = array(
			'id' => $id
		);

		$this->m_user->updateData($where, $data);
		redirect('user/index');
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_user->deleteData($where);
		redirect('user/index');
	}

}
