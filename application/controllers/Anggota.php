<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(['m_auth','m_anggota']);
		if(!$this->m_auth->loggedIn()){
			redirect('auth');
		}else if($this->session->userdata('hak_akses') != 1){
			show_404();
		}
	}

	public function index()
	{
		$data['title'] 	 = 'Anggota';
		$data['icon'] 	 = 'fa fa-users';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('anggota/index', $data);
		$this->load->view('layout/footer');
	}

	public function ajaxGetIndex(){
		$list = $this->m_anggota->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach($list as $value){
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<b>'.$value->kode.'</b>';
			$row[] = $value->nama_lengkap.' ('.$value->nama_panggilan.')<br>'.$value->telepon;
			$row[] = $value->jenis_identitas.'<br>'.$value->no_identitas;
			$row[] = $value->alamat;
			 $row[] = "<a href='".base_url('anggota/edit/'.$value->id) ."' class='btn btn-warning'><i class='fa fa-pencil-square-o'></i></a> 
            		&nbsp&nbsp 
            		<a class='btn btn-danger btn-delete' data-toggle='modal'
                    data-target='#modal-delete-data'
                    data-href='". base_url('anggota/delete/'.$value->id)."''
                    data-id=\"".$value->id."\"
                    data-nama=\"".$value->nama_panggilan."\"
                    href='#'><i class='fa fa-fw fa-trash-o'></i></a>";
            $data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_anggota->count_all(),
            "recordsFiltered" => $this->m_anggota->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function show($id){

	}

	public function create(){
		$data['parent_title']	= 'Anggota';
		$data['title']	= 'Input Anggota';
		$data['icon']	= 'fa fa-users';
		$data['uri']	= $this->uri->segment(1);
		$data['jenis'] = array(
			'1' => 'KTP',
			'2' => 'SIM',
			'3' => 'Kartu Pelajar / Mahasiswa',
			'4' => 'Lainya'

		);
		$this->load->view('layout/header', $data);
		$this->load->view('anggota/create');
		$this->load->view('layout/footer');
	}

	public function store(){
		$this->form_validation->set_rules('no_identitas','No Identitas','required');
		$this->form_validation->set_rules('jenis_identitas','Jenis identitas','required');
		$this->form_validation->set_rules('no_identitas','No identitas','required');
		$this->form_validation->set_rules('nama_lengkap','Nama Lengkap','required');
		$this->form_validation->set_rules('nama_panggilan','Nama Panggilan','required');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('telepon','Telepon','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->form_validation->run() == TRUE){
			//membuat kode acak berdasarkan waktu
			$time = time().rand(0,32);
			$kode = base_convert($time, 10, 32); 

			$kode			= $kode;
			$jenis_identitas = $this->input->post('jenis_identitas');
			$no_identitas 	= $this->input->post('no_identitas');
			$nama_lengkap	= $this->input->post('nama_lengkap');
			$nama_panggilan	= $this->input->post('nama_panggilan');
			$alamat			= $this->input->post('alamat');
			$telepon		= $this->input->post('telepon');
			
			$data = array(
					'kode'			 	=> $kode,
					'jenis_identitas' 	=> $jenis_identitas,
					'no_identitas'		=> $no_identitas,
					'nama_lengkap' 		=> $nama_lengkap,
					'nama_panggilan' 	=> $nama_panggilan,
					'alamat'			=> $alamat,
					'telepon'			=> $telepon,
					'status'			=> 1
				);
			
			$this->m_anggota->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data Tersimpan. </div>');
			redirect('anggota/index');
		}else{
			form_error('jenis_identitas') != '' ? $data['jenis_identitas_value'] = '' : $data['jenis_identitas_value'] = set_value('jenis_identitas');
			form_error('no_jenis_identitas') != '' ? $data['no_identitas_value'] = '' : $data['no_identitas_value'] = set_value('no_identitas');
			form_error('nama_lengkap') != '' ? $data['nama_lengkap_value'] = '' : $data['nama_lengkap_value'] = set_value('nama_lengkap');
			form_error('nama_panggilan') != '' ? $data['nama_panggilan_value'] = '' :  $data['nama_panggilan_value'] = set_value('nama_panggilan');
			form_error('alamat') != '' ? $data['alamat_value'] = '' :  $data['alamat_value'] = set_value('alamat');
			form_error('telepon') != '' ? $data['telepon_value'] = '' :  $data['telepon_value'] = set_value('telepon');

			$this->session->set_flashdata(
				array(
					'jenis_identitas' => form_error('jenis_identitas'),
					'no_identitas'	=> form_error('no_identitas'),
					'nama_lengkap'	=> form_error('nama_lengkap'),
					'nama_panggilan' => form_error('nama_panggilan'),
					'alamat'		=> form_error('alamat'),
					'telepon' 		=> form_error('telepon')
				)
			);
			$this->session->set_flashdata($data);
			redirect('anggota/create');
		}
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		
		$data['jenis'] = array(
			'1' => 'KTP',
			'2' => 'SIM',
			'3' => 'Kartu Pelajar / Mahasiswa',
			'4' => 'Lainya'

		);

		$data['parent_title']	= 'Anggota';
		$data['title']	= 'Edit Anggota';
		$data['icon']	= 'fa fa-users';
		$data['uri']	= $this->uri->segment(1);
		$data['anggota'] = $this->m_anggota->getEdit($where)->result();

		$this->load->view('layout/header', $data);
		$this->load->view('anggota/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		$id 			= $this->input->post('id');
		$jenis_identitas = $this->input->post('jenis_identitas');
		$no_identitas = $this->input->post('no_identitas');
		$nama_lengkap	= $this->input->post('nama_lengkap');
		$nama_panggilan	= $this->input->post('nama_panggilan');
		$alamat			= $this->input->post('alamat');
		$telepon		= $this->input->post('telepon');

		$where = array(
				'id'	=> $id
			);

		$data = array(
				'jenis_identitas' 	=> $jenis_identitas,
				'no_identitas' 		=> $no_identitas,
				'nama_lengkap' 		=> $nama_lengkap,
				'nama_panggilan' 	=> $nama_panggilan,
				'alamat'			=> $alamat,
				'telepon'			=> $telepon
			);
		
		$this->m_anggota->updateData($where, $data);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data Berhasil Update. </div>');
		redirect('anggota/index');
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_anggota->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data Terhapus. </div>');
		redirect('anggota/index');
	}

}
