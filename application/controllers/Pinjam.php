<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjam extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(
			[
				'm_pinjam',
				'm_pinjamDetail',
				'm_pinjamTemp',
				'm_buku',
				'm_anggota'
			]
		);
		$this->load->helper('url');
	}

	public function index()
	{
		$data['title'] 	= 'P';
		$data['icon'] 	= 'fa fa-shopping-cart';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('pinjam/index', $data);
		$this->load->view('layout/footer');
	}
        

	public function showAnggota(){
		$kode = $this->input->post('kode');
		$anggota = $this->m_anggota->showData($kode);

		if($anggota == []){
			$error = array(
				'keterangan' => "NOK",
				'error' 	 => "Kode anggota tidak ditemukan" 
			);
			echo json_encode($error);
		}else{
			if($anggota[0]->status == 0){
				$error = array(
					'keterangan' => "NOK",
					'error' 	 => "Status anggota tidak aktif" 
				);
				echo json_encode($error);
			}else{
				$result = array(
					'keterangan' => "OK",
					'anggota'		 => $anggota[0] 
				);
				echo json_encode($result);	
			}	
		}

	}

	public function showBuku($isbn){
		$buku 	 = $this->m_buku->showData($isbn)->result();
		$result = $buku[0];
		echo json_encode($buku); 
	}


	public function ajaxGetIndex(){
		$list = $this->m_pinjamTemp->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach($list as $value){
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->judul;
			$row[] = "
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

			$where_kode_pinjam = array(
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
