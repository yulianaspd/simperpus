<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerbit extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(['m_auth','m_penerbit']);
		if(!$this->m_auth->loggedIn()){
			redirect('auth');
		}
	}

	public function index()
	{
		
		$data['title']	= 'Penerbit';
		$data['icon']	= 'fa fa-copyright';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('penerbit/index', $data);
		$this->load->view('layout/footer');
	}

	public function ajaxGetIndex(){
		$list = $this->m_penerbit->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach($list as $value){
			$no++;
			$row = array();
			$row[] =  $no;
			$row[] = $value->nama;
			$row[] = $value->alamat;
			$row[] = $value->telepon;
			$row[] = $value->email;
			$row[] = "<a href='".base_url('penerbit/edit/'.$value->id) ."' class='btn btn-warning'><i class='fa fa-pencil-square-o'></i></a> 
            		&nbsp&nbsp 
            		<a class='btn btn-danger btn-delete' data-toggle='modal'
                            data-target='#modal-delete-data'
                            data-href='". base_url('penerbit/delete/'.$value->id)."''
                            data-id=\"".$value->id."\"
                            data-nama=\"".$value->nama."\"
                            href='#'><i class='fa fa-fw fa-trash-o'></i></a>";
 
            $data[] = $row;
		}
		 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_penerbit->count_all(),
            "recordsFiltered" => $this->m_penerbit->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function show($id){

	}

	public function create(){
		$data['parent_title'] = 'Penerbit';
		$data['title'] = 'Input Penerbit';
		$data['icon'] = 'fa fa-list';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('penerbit/create',$data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('telepon','Telepon','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->form_validation->run() == TRUE){
			$nama	= $this->input->post('nama');
			$alamat = $this->input->post('alamat');
			$telepon = $this->input->post('telepon');
			$email	= $this->input->post('email');

			$data = array(
				'nama'		=> $nama,
				'alamat' 	=> $alamat,
				'telepon'	=> $telepon,
				'email'  	=> $email
			);
			$this->m_penerbit->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data Tersimpan. </div>');
			redirect('penerbit/index');
		}else{
			$this->session->set_flashdata(
				array(
					'nama' => form_error('nama'),
					'alamat' => form_error('alamat'),
					'telepon' => form_error('telepon')
				)
			);
			redirect('penerbit/create');
		}

		
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['parent_title'] = 'Penerbit';
		$data['title'] = 'Edit Penerbit';
		$data['icon'] = 'fa fa-list';
		$data['penerbits'] = $this->m_penerbit->getEdit($where)->result();
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('penerbit/edit', $data);
		$this->load->view('layout/footer'); 
	}

	public function update(){
		$id 	= $this->input->post('id');
		$nama	= $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$telepon = $this->input->post('telepon');
		$email	= $this->input->post('email');
		$updated_at	= date('Y-m-d H:i:s');

		$data = array(
			'nama'		=> $nama,
			'alamat' 	=> $alamat,
			'email'  	=> $email,
			'telepon'	=> $telepon,
			'email'		=> $email,
			'updated_at' => $updated_at
		);

		$where = array(
			'id'	=> $id
		);

		$this->m_penerbit->updateData($where, $data);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data Berhasil Update. </div>');
		redirect('penerbit/index');
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_penerbit->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data Terhapus. </div>');
		redirect('penerbit/index');
	}

}
