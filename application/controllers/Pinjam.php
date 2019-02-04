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

	public function scanInputTemp(){
		$isbn 	= $this->input->post('isbn');
		$buku 	= $this->m_buku->showData($isbn);

		if($buku == []){

			$result_temp = array(
				'keterangan' => "NOK",
				'error' 	 => "Buku tidak ditemukan" 
			);
			echo json_encode($result_temp);

		}else{

			$result_buku = $buku[0];
			$buku_id	= $result_buku->id;
			$isbn		= $result_buku->isbn;
			$judul 		= $result_buku->judul;
			
			$where_buku_id = array(
				'buku_id' => $buku_id
			);

			$data = array(
				'buku_id' => $buku_id,
				'isbn'	  => $isbn,
				'judul'	  => $judul
			);

			$check_buku_id = $this->m_pinjamTemp->cekBukuId($where_buku_id);
			if($check_buku_id != FALSE){

				$this->m_pinjamTemp->storeData($data);
				$result_temp = array(
					'keterangan' => "OK",
					'msg' 	 	 => "Buku bberhasil input"
				);
				echo json_encode($result_temp);

			}else{

				$result_temp = array(
					'keterangan' => "NOK",
					'error' 	 => "Buku sudah input" 
				);
				echo json_encode($result_temp);			
			}
		}
	}

	public function ajaxPinjamTemp(){
		$list = $this->m_pinjamTemp->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach($list as $value){
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->id;
			$row[] = $value->judul;
			$row[] = "
            		<a class='btn btn-danger delete-temp'
                    data-href='". base_url('pinjam/deleteTemp/'.$value->id)."''
                    href='#'><i class='fa fa-fw fa-trash-o'></i></a>";

            $data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_pinjamTemp->count_all(),
            "recordsFiltered" => $this->m_pinjamTemp->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}


	public function deleteTemp($id){
		$where = array(
			'id'	=> $id
		);
		$this->m_pinjamTemp->deleteData($where);
		$data = array(
			'keterangan' => "OK"
		);
		echo json_encode($data);
	}


	public function store(){
		// $this->form_validation->set_rules('kode','Kode','required');
		// $this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');
	
		// if($this->form_validation->run() == TRUE){

			$time 		 	= time().rand(0,32);
			$kode_pinjam 	= base_convert($time, 10, 16); 
			$user_id 		= $this->input->post('user_id');
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
			
			$store_pinjam = $this->m_pinjam->storeData($data_pinjam);
			

			if($store_pinjam == TRUE){
				$show_pinjam = $this->m_pinjam->showData($kode_pinjam);
				// $buku_id 		= $this->input->post('buku_id');
				// foreach( $buku_id as $index => $value){
				// 	$data_detail_pinjam = array(
				// 		'pinjam_id' 		=> $show_pinjam[0]->id,
				// 		'buku_id' 			=> $value,
				// 		'jml_perpanjangan' 	=> 0,
				// 		'jatuh_tempo'		=> date('Y-m-d'),
				// 		'status'			=> 1,
				// 		'tanggal_kembali' 	=> date('Y-m-d'),
				// 		'denda'				=> 0
				// 	);
				// 	$this->m_pinjamDetail->storedata($data_detail_pinjam);
					$result = array(
						'keterangan' 	 => "OK",
						'result_pinjam'	 => $show_pinjam[0],
					);
					echo json_encode($result);
				//}	
			}else{
				$result = array(
					'keterangan' => "NOK",
					'error'		 => "input pinjam error",
				);
				echo json_encode($result);
			}
			// $where_kode_pinjam = array(
			// 	'kode'	=> $kode_pinjam
			// );

		// 	$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Success! Data berhasil update. </div>');
		// 	redirect('rak/index');
		// }else{
		// 	$this->session->set_flashdata('form_kode', form_error('kode'));
		// 	redirect('rak/create');
		// }
	}

	public function storeDetail(){
		$arrayBuku = array();
		$pinjam_id	= $this->input->post('pinjam_id');
		$buku_id   	= $this->input->post('buku_id');
		
		$array_buku = json_decode($buku_id,true);
		$data_detail_pinjam = array();
		// foreach($array_buku as $value) { 
			$data_detail_pinjam = array(
					'pinjam_id' 		=> $pinjam_id,
					'buku_id' 			=> $array_buku[0],
					'jml_perpanjangan' 	=> 0,
					'jatuh_tempo'		=> date('Y-m-d'),
					'status'			=> 1,
					'tanggal_kembali' 	=> date('Y-m-d'),
					'denda'				=> 0
				);
			$this->m_pinjamDetail->storeData($data_detail_pinjam);
		//}

		
		$result = array(
			'keterangan' => "OK",
			'data'		 => $array_buku,
		);
		echo json_encode($result);
		
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
