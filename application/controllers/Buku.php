<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model([
			'm_auth',
			'm_buku',
			'm_kategori',
			'm_penulis',
			'm_penerbit'
		]);
		if(!$this->m_auth->loggedIn()){
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] 	= 'Buku';
		$data['icon'] 	= 'fa fa-book';
		$data['uri']	= $this->uri->segment(1);

		$this->load->view('layout/header', $data);
		$this->load->view('buku/index', $data);
		$this->load->view('layout/footer');
	}

	public function ajaxGetIndex(){
		$list = $this->m_buku->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach($list as $value){
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->isbn;
			$row[] = $value->judul;
			$row[] = $value->halaman;
			$row[] = $value->kategori;
			$row[] = "
					&nbsp&nbsp 
            		<a class='btn btn-primary btn-show' data-toggle='modal'
                    data-target='#modal-detail-buku'
                    data-id=\"".$value->id."\"
                    data-isbn=\"".$value->isbn."\"
                    data-judul=\"".$value->judul."\"
                    data-halaman=\"".$value->halaman."\"
                    data-kategori=\"".$value->kategori."\"
                    data-penulis=\"".$value->penulis."\"
                    data-penerbit=\"".$value->penerbit."\"
                    href='#'><i class='fa fa-fw fa-eye'></i></a>
                    &nbsp&nbsp 
					<a href='".base_url('buku/edit/'.$value->id) ."' class='btn btn-warning'><i class='fa fa-pencil-square-o'></i></a> 
            		&nbsp&nbsp 
            		<a class='btn btn-danger btn-delete' data-toggle='modal'
                    data-target='#modal-delete-data'
                    data-href='". base_url('buku/delete/'.$value->id)."''
                    data-id=\"".$value->id."\"
                    data-nama=\"".$value->judul."\"
                    href='#'><i class='fa fa-fw fa-trash-o'></i></a>";

            $data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_buku->count_all(),
            "recordsFiltered" => $this->m_buku->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function show($id){

	}

	public function create(){
		$data['parent_title'] = 'Buku';
		$data['title']		= 'Input Buku';
		$data['icon']		= 'fa fa-book';
		$data['uri'] = $this->uri->segment(1);
		$data['kategori'] 	= $this->m_kategori->getData()->result();
		$data['penulis']	= $this->m_penulis->getData()->result();
		$data['penerbit']	= $this->m_penerbit->getData()->result();

		$this->load->view('layout/header', $data);
		$this->load->view('buku/create', $data);
		$this->load->view('layout/footer');
	}

	public function store(){
		$this->form_validation->set_rules('isbn','ISBN','required');
		$this->form_validation->set_rules('penulis_id','Penulis','required');
		$this->form_validation->set_rules('penerbit_id','Penerbit','required');
		$this->form_validation->set_rules('kategori_id','Kategori','required');
		$this->form_validation->set_rules('judul','Judul','required');
		$this->form_validation->set_rules('halaman','Halaman','required');
		// $this->form_validation->set_rules('tanggal_terbit','Tanggal_terbit','required');
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');

		if($this->form_validation->run() == TRUE){
			$isbn			= $this->input->post('isbn');
			$penulis_id		= $this->input->post('penulis_id');
			$penerbit_id	= $this->input->post('penerbit_id');
			$kategori_id	= $this->input->post('kategori_id');
			$judul			= $this->input->post('judul');
			$halaman		= $this->input->post('halaman');
			// $tanggal_terbit	= $this->input->post('tanggal_terbit');

			$data = array(
				'isbn'		=> $isbn,
				'penulis_id' => $penulis_id,
				'penerbit_id' => $penerbit_id,
				'kategori_id' => $kategori_id,
				'judul'		=> $judul,
				'halaman'	=> $halaman
				// 'tanggal_terbit' => $tanggal_terbit
			);
			$this->m_buku->storeData($data);
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data tersimpan. </div>');
			redirect('buku/index');
		}else{
			form_error('isbn') != '' ? $data['isbn_value'] = '' : $data['isbn_value'] = set_value('isbn');
			form_error('judul') != '' ? $data['judul_value'] = '' :  $data['judul_value'] = set_value('judul');
			form_error('halaman') != '' ? $data['halaman_value'] = '' :  $data['halaman_value'] = set_value('halaman');

			$this->session->set_flashdata(
				array(
					'isbn' => form_error('isbn'),
					'kategori_id' => form_error('kategori_id'),
					'penulis_id' => form_error('penulis_id'),
					'penerbit_id' => form_error('penerbit_id'),
					'judul' => form_error('judul'),
					'halaman' => form_error('halaman')
				)
			);
			$this->session->set_flashdata($data);
			redirect('buku/create');
		}
	}

	public function edit($id){
		$where = array(
			'id' => $id
		);
		$data['parent_title'] = 'Buku';
		$data['title']		= 'Edit Buku';
		$data['icon']		= 'fa fa-book';
		$data['uri']		= $this->uri->segment(1);
		$data['kategori'] 	= $this->m_kategori->getData()->result();
		$data['penulis']	= $this->m_penulis->getData()->result();
		$data['penerbit']	= $this->m_penerbit->getData()->result();
		$data['data_buku']	= $this->m_buku->getEdit($where)->result();

		$this->load->view('layout/header', $data);
		$this->load->view('buku/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update(){	
		$id    			= $this->input->post('id');
		$isbn			= $this->input->post('isbn');
		$penulis_id		= $this->input->post('penulis_id');
		$penerbit_id	= $this->input->post('penerbit_id');
		$kategori_id	= $this->input->post('kategori_id');
		$judul			= $this->input->post('judul');
		$halaman		= $this->input->post('halaman');
		//$tanggal_terbit	= $this->input->post('tanggal_terbit');

		$data = array(
			'isbn'		=> $isbn,
			'penulis_id' => $penulis_id,
			'penerbit_id' => $penerbit_id,
			'kategori_id' => $kategori_id,
			'judul'		=> $judul,
			'halaman'	=> $halaman
			//'tanggal_terbit' => $tanggal_terbit
		);

		$where = array(
			'id' => $id
		);
		$this->m_buku->updateData($where,$data);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data berhasil update. </div>');
		redirect('buku/index');
	}

	public function delete($id){
		$where = array(
			'id' => $id
		);
		$this->m_buku->deleteData($where);
		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data terhapus. </div>');
		redirect('buku/index');
	}

}
