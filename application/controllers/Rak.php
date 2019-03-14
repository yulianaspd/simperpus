<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rak extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(['m_auth','m_rak']);
		$this->load->helper('url');
		if(!$this->m_auth->loggedIn()){
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] 	= 'Rak';
		$data['icon'] 	= 'fa fa-list';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('rak/index', $data);
		$this->load->view('layout/footer');	
	}

	public function ajaxGetIndex(){
		$list = $this->m_rak->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->kode;
            $row[] = "<a href='".base_url('rak/edit/'.$value->id) ."' class='btn btn-warning'><i class='fa fa-pencil-square-o'></i></a> 
            		&nbsp&nbsp 
            		<a class='btn btn-danger btn-delete' data-toggle='modal'
                            data-target='#modal-delete-data'
                            data-href='". base_url('rak/delete/'.$value->id)."''
                            data-id=\"".$value->id."\"
                            data-nama=\"".$value->kode."\"
                            href='#'><i class='fa fa-fw fa-trash-o'></i></a>";
 
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
			$kode = $this->input->post('kode');
			$data = array(
				'kode'	=> $kode
			);
			$this->m_rak->storeData($data);
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
