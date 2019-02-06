<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kembali extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(
			[
				'm_kembali'
				'm_pinjam',
				'm_pinjamDetail',
				'm_buku',
				'm_anggota'
			]
		);
		$this->load->helper('url');
	}

	public function index()
	{
		$data['title'] 	= 'Transaksi Kembali';
		$data['icon'] 	= 'fa  fa-download';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('kembali/index', $data);
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
	

	// public function ajaxPinjamTemp(){
	// 	$list = $this->m_pinjamTemp->get_datatables();
	// 	$data = array();
	// 	$no = $_POST['start'];
	// 	foreach($list as $value){
	// 		$no++;
	// 		$row = array();
	// 		$row[] = $no;
	// 		$row[] = $value->buku_id;
	// 		$row[] = $value->judul;
	// 		$row[] = "
 //            		<a class='btn btn-danger delete-temp'
 //                    data-href='". base_url('pinjam/deleteTemp/'.$value->id)."''
 //                    href='#'><i class='fa fa-fw fa-trash-o'></i></a>";

 //            $data[] = $row;
	// 	}
	// 	$output = array(
 //            "draw" => $_POST['draw'],
 //            "recordsTotal" => $this->m_pinjamTemp->count_all(),
 //            "recordsFiltered" => $this->m_pinjamTemp->count_filtered(),
 //            "data" => $data,
 //        );
 //        //output dalam format JSON
 //        echo json_encode($output);
	// }
	
}




	


	

	

	
	


}
