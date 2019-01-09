<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_user');
	}

	public function index()
	{
		$data['title'] = 'User';
		$data['icon']  = 'fa fa-users';
		$data['user']  = $this->m_user->get_data()->result();
		$this->load->view('user/index');	
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

		$this->m_user->store_data($data);
		redirect('user/index');
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['title'] = 'Edit User';
		$data['icon'] = 'fa fa-list';
		$data['edit_data'] = $this->m_user->get_edit($where)->result();
		$this->load->view('user/edit', $data);
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

		$this->m_user->update_data($where, $data);
		redirect('user/index');
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_user->delete_data($where);
		redirect('user/index');
	}

}
