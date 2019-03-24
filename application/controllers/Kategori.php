<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model(['m_auth','m_kategori','m_rak']);
		if(!$this->m_auth->loggedIn()){
			redirect('auth');
		}else if($this->session->userdata('hak_akses') != 1){
			show_404();
		}
	}

	public function index()
	{
		$data['title'] = 'Kategori';
		$data['icon'] = 'fa fa-bookmark';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header',$data);
		$this->load->view('kategori/index', $data);
		$this->load->view('layout/footer');	
	}

	public function ajaxGetIndex(){
		$list = $this->m_kategori->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $value) {
			$no++;
			$row = array();
		    $row[] = $no;
		    $row[] = $value->nama;
		    $row[] = $value->kode;
		    $row[] = "<a href='".base_url('kategori/edit/'.$value->id) ."' class='btn btn-warning'><i class='fa fa-pencil-square-o'></i></a> 
            		&nbsp&nbsp 
            		<a class='btn btn-danger btn-delete' data-toggle='modal'
                    data-target='#modal-delete-data'
                    data-href='". base_url('kategori/delete/'.$value->id)."''
                    data-id=\"".$value->id."\"
                    data-nama=\"".$value->nama."\"
                    href='#'><i class='fa fa-fw fa-trash-o'></i></a>";
 
            $data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_kategori->count_all(),
            "recordsFiltered" => $this->m_kategori->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function show($id){			
	
	}

	public function create(){
		$data['parent_title'] = 'Kategori';
		$data['title'] = 'Input Kategori';
		$data['icon'] = 'fa fa-bookmark';
		$data['uri'] = $this->uri->segment(1);
		$data['rak'] = $this->m_rak->getData()->result();

		$this->load->view('layout/header', $data);
		$this->load->view('kategori/create', $data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$this->form_validation->set_rules('rak_id','Rak ID','required');
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->form_validation->run() == TRUE){
			$rak_id = $this->input->post('rak_id');
			$nama 	= $this->input->post('nama');
			$data = array (
				'rak_id' => $rak_id,
				'nama'	 => $nama
			);
			$this->m_kategori->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data Tersimpan. </div>');
			redirect('kategori/index');
		}else{
			$this->session->set_flashdata(
				array(
					'rak_id' => form_error('rak_id'),
					'nama' => form_error('nama')
				)
			);
			redirect('kategori/create');
		}
	}

	public function edit($id){
		$where = array('id' => $id);
		$data['parent_title'] = 'Kategori';
		$data['title'] = 'Edit Kategori';
		$data['icon'] = 'fa fa-bookmark';
		$data['uri']	= $this->uri->segment(1);
		$data['raks'] = $this->m_rak->getData()->result();
		$data['kategori'] = $this->m_kategori->getEdit($where)->result();

		$this->load->view('layout/header',$data);
		$this->load->view('kategori/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){
		$id 	= $this->input->post('id');
		$rak_id = $this->input->post('rak_id');
		$nama	= $this->input->post('nama');
		$updated_at = date('Y-m-d H:i:s');

		$data = array(
			'rak_id'		=> $rak_id,
			'nama'			=> $nama,
			'updated_at' 	=> $updated_at
		);

		$where = array(
			'id'	=> $id
		);

		$this->m_kategori->updateData($where,$data);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data Berhasil Update. </div>');
		redirect('kategori/index');
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_kategori->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data Terhapus. </div>');
		redirect('kategori/index');		
	}

}
