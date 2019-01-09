<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rak extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_rak');
	}

	public function index()
	{
		$data['title'] 	= 'Rak';
		$data['icon'] 	= 'fa fa-list';
		$data['rak']	= $this->m_rak->get_data()->result();
		$this->load->view('rak/index', $data);
	}

	public function show($id){

	}

	public function create(){
		$data['title']	= 'Input Rak';
		$data['icon']	= 'fa fa-list';
		$this->load->view('rak/create', $data);
	}

	public function store(){
		$kode = $this->input->post('kode');
		$data = array(
			'kode'	=> $kode;
		);
		$this->m_rak->store_data($data);
		redirect('rak/index');
	}

	public function edit($id){
		$where = array (
			'id'	=> $id;
		);
		$data['title'] = 'Edit Kategori';
		$data['icon'] = 'fa fa-list';
		$data['edit_rak'] = $this->m_rak->get_edit($where)->result();
		$this->load->view('rak/edit', $data);
	}

	public function update(){
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

		$this->m_rak->update_data($where,$data);
		redirect('rak/index');
	}

	public function delete($id){
		$where = array(
			'id'	=> $id;
		);
		$this->m_rak->delete_data($where);
		redirect('rak/index');
	}


}
