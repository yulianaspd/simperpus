<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(
			'm_auth',
			'm_buku',
			'm_kategori',
			'm_penulis',
			'm_penerbit'
		);
	}

	public function index()
	{
		if( $this->m_auth->loggedIn() ){
			$data['title'] 	= 'Buku';
			$data['icon'] 	= 'fa fa-book';
			$data['buku']	= $this->m_buku->get_data()->result();

			$this->load->view('layout/header', $data);
			$this->load->view('buku/index', $data);
			$this->load->view('layout/footer');
		}else{
			$this->load->view('v_login');
		}
	}

	public function show($id){

	}

	public function create(){
		$data['title']		= 'Input files';
		$data['icon']		= 'fa fa-list';
		$data['kategori'] 	= $this->m_kategori->getData()->result();
		$data['penulis']	= $this->m_penulis->getData()->result();
		$data['penerbit']	= $this->m_penerbit->getData()->result();

		$this->load->view('layout/header', $data);
		$this->load->view('buku/create', $data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$this->form_validation->set_rules('isbn','ISBN','required');
		$this->form_validation->set_rules('penulis_id','Penulis_id','required');
		$this->form_validation->set_rules('penerbit_id','Penerbit_id','required');
		$this->form_validation->set_rules('kategori_id','Kategori_id','required');
		$this->form_validation->set_rules('judul','Judul','required');
		$this->form_validation->set_rules('halaman','Halaman','required');
		$this->form_validation->set_rules('tanggal_terbit','Tanggal_terbit','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
			$isbn			= $this->input->post('isbn');
			$penulis_id		= $this->input->post('penulis_id');
			$penerbit_id	= $this->input->post('penerbit_id');
			$kategori_id	= $this->input->post('kategori_id');
			$judul			= $this->input->post('judul');
			$halaman		= $this->input->post('halaman');
			$tanggal_terbit	= $this->input->post('tanggal_terbit');

			$data = array(
				'isbn'		=> $isbn,
				'penulis_id' => $penulis_id,
				'penerbit_id' => $penerbit_id,
				'kategori_id' => $kategori_id,
				'judul'		=> $judul,
				'halaman'	=> $halaman,
				'tanggal_terbit' => $tanggal_terbit
			);
			$this->m_buku->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data tersimpan. </div>');
			redirect('buku/create');
		}else{
			redirect('buku/create');
		}
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['title']		= 'Input files';
		$data['icon']		= 'fa fa-list';
		$data['kategori'] 	= $this->m_kategori->getData()->result();
		$data['penulis']	= $this->m_penulis->getData()->result();
		$data['penerbit']	= $this->m_penerbit->getData()->result();
		$data['buku']		= $this->m_buku->getEdit($where)->result();

		$this->load->view('layout/header', $data);
		$this->load->view('buku/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		$this->form_validation->set_rules('isbn','ISBN','required');
		$this->form_validation->set_rules('penulis_id','Penulis_id','required');
		$this->form_validation->set_rules('penerbit_id','Penerbit_id','required');
		$this->form_validation->set_rules('kategori_id','Kategori_id','required');
		$this->form_validation->set_rules('judul','Judul','required');
		$this->form_validation->set_rules('halaman','Halaman','required');
		$this->form_validation->set_rules('tanggal_terbit','Tanggal_terbit','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
			$id    			= $this->input->post('id');
			$isbn			= $this->input->post('isbn');
			$penulis_id		= $this->input->post('penulis_id');
			$penerbit_id	= $this->input->post('penerbit_id');
			$kategori_id	= $this->input->post('kategori_id');
			$judul			= $this->input->post('judul');
			$halaman		= $this->input->post('halaman');
			$tanggal_terbit	= $this->input->post('tanggal_terbit');

			$data = array(
				'isbn'		=> $isbn,
				'penulis_id' => $penulis_id,
				'penerbit_id' => $penerbit_id,
				'kategori_id' => $kategori_id,
				'judul'		=> $judul,
				'halaman'	=> $halaman,
				'tanggal_terbit' => $tanggal_terbit
			);

			$where = array(
				'id' => $id
			);
			$this->m_buku->updateData($where,$data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success!  Data berhasil update. </div>');
			redirect('buku/edit');
		}else{
			redirect('buku/edit');
		}
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_buku->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data berhasil dihapus </div>');
			redirect('buku/index');
		redirect('buku/index');
	}

}
