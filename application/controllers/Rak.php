<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rak extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_rak');
		$this->load->helper('url');
	}

	public function index()
	{
		$uri = $this->uri;
		$data['title'] 	= 'Rak';
		$data['icon'] 	= 'fa fa-list';
		// $data['rak']	= $this->m_rak->getData()->result();
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('rak/index', $data);
		$this->load->view('layout/footer');
	}

	public function ajaxGetIndex(){
		$list = $this->m_rak->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->kode;
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_rak->count_all(),
            "recordsFiltered" => $this->m_rak->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function show($id){

	}

	public function create(){
		$data['title']	= 'Input Rak';
		$data['icon']	= 'fa fa-list';
		$data['uri']	= $this->uri->segment(1);
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
				'kode'	=> $kode
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
			'id'	=> $id,
		);
		$data['title'] = 'Edit Kategori';
		$data['icon'] = 'fa fa-list';
		$data['edit_rak'] = $this->m_rak->getEdit($where)->result();
		$data['uri']	= $this->uri->segment(1);
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
			'id'	=> $id
		);
		$this->m_rak->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil dihapus </div>');
			redirect('buku/index');
		redirect('rak/index');
	}


}
