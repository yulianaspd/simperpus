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
		$data['icon']	= 'fa fa-user';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('penulis/index', $data);
		$this->load->view('layout/footer');
	}

	public function ajaxGetIndex(){
		$list = $this->m_penulis->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->nama_lengkap;
            $row[] = "<a href='".base_url('rak/edit/'.$value->id) ."' class='btn btn-warning'><i class='fa fa-pencil-square-o'></i></a> 
            		&nbsp&nbsp 
            		<a class='btn btn-danger btn-delete' data-toggle='modal'
                            data-target='#modal-delete-data'
                            data-href='". base_url('rak/delete/'.$value->id)."''
                            data-id=\"".$value->id."\"
                            data-nama=\"".$value->nama_lengkap."\"
                            href='#'><i class='fa fa-fw fa-trash-o'></i></a>";
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_penulis->count_all(),
            "recordsFiltered" => $this->m_penulis->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function show($id){

	}

	public function create(){
		$data['title']	= 'Input Penulis';
		$data['icon']	= 'fa fa-list';

		$this->load->view('layout/header', $data);
		$this->load->view('penulis/create', $data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
			$nama	= $this->input->post('name');
			$data = array(
				'nama'	=> $nama
			);
			$this->m_penulis->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data tersimpan. </div>');
			redirect('penulis/create');
		}else{
			redirect('penulis/create');
		}
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['title'] = 'Edit Penulis';
		$data['icon'] = 'fa fa-list';
		$data['edit_data'] = $this->m_penulis->getEdit($where)->result();

		$this->load->view('layout/header', $data);
		$this->load->view('penulis/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
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

			$this->m_penulis->updateData($where,$data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil update. </div>');
			redirect('penulis/edit');
		}else{
			redirect('penulis/edit');
		}
		
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_penulis->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil dihapus </div>');
			redirect('penulis/index');
		redirect('penulis/index');
	}

}
