<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjam extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(
			[
				'm_pinjam',
				'm_pinjamDetail',
				'm_buku',
				'm_anggota',
			]
		);
		$this->load->helper('url');
	}

	public function index()
	{
		$data['title'] 	= 'Pinjam Buku';
		$data['icon'] 	= 'fa fa-shopping-cart';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('pinjam/index', $data);
		$this->load->view('layout/footer');
	}
        

	public function show($id){

	}

	public function create(){
		$data['parent_title'] = 'Rak';
		$data['title']	= 'Input Rak';
		$data['icon']	= 'fa fa-tasks';
		$data['uri']	= $this->uri->segment(1);

		$this->load->view('layout/header', $data);
		$this->load->view('rak/create', $data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$this->form_validation->set_rules('kode','Kode','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->form_validation->run() == TRUE){

			$time 		 	= time().rand(0,32);
			$kode_pinjam 	= base_convert($time, 10, 16); 
			$user_id 		= $this->session->userdata('id');
			$anggota_id 	= $this->input->post('anggota_id');
			$tanggal_pinjam = date('Y-m-d');
			$qty			= 1;
			$total_denda 	= 0;

			$data_pinjam = array(
				'kode_pinjam'	=> $kode_pinjam,
				'user_id'		=> $user_id,
				'anggota_id'	=> $anggota_id,
				'tanggal_pinjam'=> $tanggal_pinjam,
				'qty'			=> $qty,
				'total_denda'	=> $total_denda
			);
			$this->m_rak->storeData($data);

			$pinjam_id = $this->m_pinjam->get_show($where_kode_pinjam);

			foreach( $buku as $index => $value){
				$data_detail = array(
					'kode_pinjam' 		=> $kode_pinjam,
					'buku_id' 			=> $value,
					'jml_perpanjangan' 	=> 0,
					'jatuh_tempo'		=> $jatuh_tempo,
					'status'			=> 1,
					'tanggal_kembali' 	=> $tanggal_kembali,
					'denda'				=> 0
				);

				$this->m_pinjamDetail->storedata($data_detail);
			}

			$where_kode_pinjam array(
				'kode'	=> $kode_pinjam
			);

			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data berhasil update. </div>');
			redirect('rak/index');
		}else{
			$this->session->set_flashdata('form_kode', form_error('kode'));
			redirect('rak/create');
		}
		
	}

	public function edit($id){
		$where = array (
			'id'	=> $id,
		);
		$data['parent_title'] = 'Rak';
		$data['title'] = 'Edit Rak';
		$data['icon'] = 'fa fa-tasks';
		$data['rak'] = $this->m_rak->getEdit($where)->result();
		$data['uri']	= $this->uri->segment(1);

		$this->load->view('layout/header', $data);
		$this->load->view('rak/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		
		$id	= $this->input->post('id');
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
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data berhasil update. </div>');
		redirect('rak/index');
	}

	public function delete($id){
		$where = array(
			'id'	=> $id
		);
		$this->m_rak->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data terhapus. </div>');
		redirect('rak/index');
	}


}
