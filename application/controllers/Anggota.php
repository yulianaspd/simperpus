<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_anggota');
	}

	public function index()
	{
		$data['title'] 	 = 'Anggota';
		$data['icon'] 	 = 'fa fa-users';
		$data['uri']	= $this->uri->segment(1);
		$data['anggota'] = $this->m_anggota->get_data()->result();
		$this->load->view('layout/header', $data);
		$this->load->view('anggota/index', $data);
		$this->load->view('layout/footer');
	}

	private function uploadFoto(){
		$config['upload_path']	='./upload/foto/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['file_name']	 = $this->kode;
		$config['overwrite']	 = true;
		$config['max_size']		 = 3024;

		$this->load->library('upload', $config);

		if($this->upload->do_upload('image')){
			return $this->upload->data("file_name");
		}

		return "default.jpg";
	}

	public function show($id){

	}

	public function create(){
		$data['title']		= 'Input files';
		$data['icon']		= 'fa fa-users';
		$data['uri']	= $this->uri->segment(1);

		$this->load->view('layout/header', $data);
		$this->load->view('kategori/create');
		$this->load->view('layout/footer');
	}

	public function store(){
		$this->form_validation->set_rules('no_identitas','No Identitas','required');
		$this->form_validation->set_rules('jenis_identitas','Jenis identitas','required');
		$this->form_validation->set_rules('nama_lengkap','Nama Lengkap','required');
		$this->form_validation->set_rules('nama_panggilan','Nama Panggilan','required');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('telepon','Telepon','required');
		$this->form_validation->set_rules('foto','Foto','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->validation->run() == TRUE){
			//membuat kode acak berdasarkan waktu
			$time = time().rand(0,32);
			$kode = base_convert($time, 10, 32); 

			$kode			= $kode;
			$jenis_identitas = $this->input->post('jenis_identitas');
			$nama_lengkap	= $this->input->post('nama_lengkap');
			$nama_panggilan	= $this->input->post('nama_panggilan');
			$alamat			= $this->input->post('alamat');
			$telepon		= $this->input->post('telepon');
			$foto 			= $this->uploadFoto();
			
			$data = array(
					'kode'			 	=> $kode,
					'jenis_identitas' 	=> $jenis_identitas,
					'nama_lengkap' 		=> $nama_lengkap,
					'nama_panggilan' 	=> $nama_panggilan,
					'alamat'			=> $alamat,
					'telepon'			=> $telepon,
					'foto'				=> $foto
				);
			
			$this->m_anggota->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data tersimpan. </div>');
			redirect('anggota/create');
		}else{
			redirect('anggota/create');
		}
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['title']	= 'Edit Anggota';
		$data['icon']	= 'fa fa-users';
		$data['uri']	= $this->uri->segment(1);
		$data['anggota'] = $this->m_anggota->getEdit($where)->result();

		$this->load->view('layout/header', $data);
		$this->load->view('anggota/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		$this->form_validation->set_rules('id','ID','required');
		$this->form_validation->set_rules('kode','Kode','required');
		$this->form_validation->set_rules('no_identitas','No Identitas','required');
		$this->form_validation->set_rules('jenis_identitas','Jenis identitas','required');
		$this->form_validation->set_rules('nama_lengkap','Nama Lengkap','required');
		$this->form_validation->set_rules('nama_panggilan','Nama Panggilan','required');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('telepon','Telepon','required');
		$this->form_validation->set_rules('foto','Foto','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');
		//konfigurasi upload
		$config['upload_path']	 = 'uploads/foto-anggota/';
		$config['allowed_types'] = 'jpeg|jpg|png';
		$config['max_size']		 = 3024;
		$this->load->library('upload', $config);

		if($this->validation->run() == TRUE){
			$id 			= $this->input->post('id');
			$kode			= $this->input->post('kode');
			$jenis_identitas = $this->input->post('jenis_identitas');
			$nama_lengkap	= $this->input->post('nama_lengkap');
			$nama_panggilan	= $this->input->post('nama_panggilan');
			$alamat			= $this->input->post('alamat');
			$telepon		= $this->input->post('telepon');

			$anggota = $this->m_anggota->showData($id);

			$data = array(
					'kode'			 	=> $kode,
					'jenis_identitas' 	=> $jenis_identitas,
					'nama_lengkap' 		=> $nama_lengkap,
					'nama_panggilan' 	=> $nama_panggilan,
					'alamat'			=> $alamat,
					'telepon'			=> $telepon
				);
			
			if(){

			}

			if($this->upload->do_upload('foto')){
				//upload foto ke directory
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
				$data_foto = array( 'foto' => $file_name );
			}else{
				$data['error_msg'] = $this->upload->display_errors();
				redirect('anggota/create', $data);
			}

			$this->m_anggota->storeData(array_merge($data, $data_foto));
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! Data tersimpan. </div>');
			redirect('anggota/create');
			
		}else{

			redirect('anggota/create');
			
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
