<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model([
			'm_auth',
			'm_user'
		]);
		if(!$this->m_auth->loggedIn()){
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] = 'User';
		$data['icon']  = 'fa fa-unlock-alt';
		$data['uri']	= $this->uri->segment(1);

		$this->load->view('layout/header', $data);
		$this->load->view('user/index');	
		$this->load->view('layout/footer');
	}

	public function ajaxGetIndex(){
		$list = $this->m_user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
        	if($value->status == 1){
        		$status = 'ADMINISTRATOR';
        	}else{
        		$status = 'OPERATOR';
        	}
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->nama_lengkap.'<br>( '.$value->panggilan.' )';
            $row[] = $value->alamat.'<br>'.$value->email.'<br>'.$value->telepon;
            $row[] = $status;
            $row[] = "<a href='".base_url('user/edit/'.$value->id) ."' class='btn btn-warning'><i class='fa fa-pencil-square-o'></i></a> 
            		&nbsp&nbsp 
            		<a class='btn btn-danger btn-delete' data-toggle='modal'
                            data-target='#modal-delete-data'
                            data-href='". base_url('user/delete/'.$value->id)."''
                            data-id=\"".$value->id."\"
                            data-nama=\"".$value->panggilan."\"
                            href='#'><i class='fa fa-fw fa-trash-o'></i></a>";
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_user->count_all(),
            "recordsFiltered" => $this->m_user->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function show($id){

	}

	public function create(){
		$data['parent_title'] = 'User';
		$data['title']		= 'Input User';
		$data['icon']		= 'fa fa-unlock-alt';
		$data['uri']		= $this->uri->segment(1);
		$data['status']		= array(
								'1' => 'Administrator', 
								'0' => 'Operator' 
								);
		$this->load->view('layout/header', $data);
		$this->load->view('user/create', $data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$this->form_validation->set_rules('nama_lengkap','Nama Lengkap','required');
		$this->form_validation->set_rules('panggilan','Panggilan','required');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('telepon','Telepon','required');
		$this->form_validation->set_rules('status','Status','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->form_validation->run() == TRUE){
			$nama_lengkap 	= $this->input->post('nama_lengkap');
			$panggilan 		= $this->input->post('panggilan');
			$alamat 		= $this->input->post('alamat');
			$email 			= $this->input->post('email');
			$telepon 		= $this->input->post('telepon');
			$status 		= $this->input->post('status');
			$data = array(
				'nama_lengkap'	=> $nama_lengkap,
				'panggilan'		=> $panggilan,
				'alamat'		=> $alamat,
				'email'			=> $email,
				'password'		=> md5('simperpus12345'),
				'telepon'		=> $telepon,
				'status'		=> $status
			);
			$this->m_user->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data Tersimpan. </div>');
			redirect('user/index');
		}else{
			form_error('nama_lengkap') != '' ? $data['nama_lengkap_value'] = '' : $data['nama_lengkap_value'] = set_value('nama_lengkap');
			form_error('panggilan') != '' ? $data['panggilan_value'] = '' :  $data['panggilan_value'] = set_value('panggilan');
			form_error('alamat') != '' ? $data['alamat_value'] = '' :  $data['alamat_value'] = set_value('alamat');
			form_error('email') != '' ? $data['email_value'] = '' :  $data['email_value'] = set_value('email');
			form_error('telepon') != '' ? $data['telepon_value'] = '' :  $data['telepon_value'] = set_value('telepon');
			$this->session->set_flashdata(
				array(
					'form_nama_lengkap' => form_error('nama_lengkap'),
					'form_panggilan' 	=> form_error('panggilan'),
					'form_alamat' 		=> form_error('alamat'),
					'form_email' 		=> form_error('email'),
					'form_telepon' 		=> form_error('telepon'),
					'form_status' 		=> form_error('status')
				)
			);
			$this->session->set_flashdata($data);
			redirect('user/create');
		}
		
	}

	public function edit($id){
		$data['parent_title'] = 'User';
		$data['title']		= 'Edit User';
		$data['icon']		= 'fa fa-unlock-alt';
		$data['uri']		= $this->uri->segment(1);
		$data['status']		= array(
								'1' => 'Administrator', 
								'0' => 'Operator' 
								);
		$where = array (
			'id'	=> $id,
		);
		$data['user'] 	= $this->m_user->getEdit($where)->result();

		$this->load->view('layout/header', $data);
		$this->load->view('user/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		
		$id				= $this->input->post('id');
		$nama_lengkap 	= $this->input->post('nama_lengkap');
		$panggilan 		= $this->input->post('panggilan');
		$alamat 		= $this->input->post('alamat');
		$email 			= $this->input->post('email');
		$telepon 		= $this->input->post('telepon');
		$status 		= $this->input->post('status');
		$data = array(
			'nama_lengkap'	=> $nama_lengkap,
			'panggilan'		=> $panggilan,
			'alamat'		=> $alamat,
			'email'			=> $email,
			'telepon'		=> $telepon,
			'status'		=> $status,
			'updated_at'	=> date('Y-m-d H:i:s')
		);

		$where = array(
			'id'	=> $id
		);

		$this->m_user->updateData($where,$data);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data berhasil update. </div>');
		redirect('user/index');
	}

	public function delete($id){
		$where = array(
			'id'	=> $id
		);
		$this->m_user->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data terhapus. </div>');
		redirect('user/index');
	}


}
