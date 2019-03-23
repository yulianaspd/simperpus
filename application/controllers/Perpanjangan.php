<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Perpanjangan extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(
			[
				'm_auth',
				'm_perpanjangan',
				'm_pinjam',
				'm_pinjamDetail',
				'm_buku',
				'm_anggota'
			]
		);
		$this->load->helper('url');
		if(!$this->m_auth->loggedIn()){
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] 	= 'Perpanjang';
		$data['icon'] 	= 'fa fa-exchange';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('perpanjangan/index', $data);
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
					'anggota'	 => $anggota[0] 
				);
				echo json_encode($result);	
			}	
		}
	}

	public function ajaxGetPinjam(){
		$anggota_id = $this->input->post('anggota_id');
		$list 		= $this->m_perpanjangan->get_datatables($anggota_id);
		$data 		= array();
		$no 		= $_POST['start'];
		$today 		= date("Y-m-d");
  		
		foreach($list as $value){
			$jatuh_tempo_awal = date('Y-m-d',strtotime($value->jatuh_tempo));
			$date_convert 	  = str_replace('-', '/', $jatuh_tempo_awal);
			$jatuh_tempo_berikutnya = date('Y-m-d',strtotime($date_convert . "+2 days"));
			
			$time1 		= new DateTime($today);
  			$time2 		= new DateTime($value->jatuh_tempo);
  			$resultTime = date_diff($time1,$time2);
			$date_diff 	= (strtotime($today) - strtotime($value->jatuh_tempo))/86400;
			
			if($date_diff <= 0){
				
				if($value->jml_perpanjangan >= 2){
					
					$checklist = '<medium><span class="label label-danger"><i class="fa fa-times"></i></span></medium>';
					$info_tanggal_pinjam_perpanjangan = '<i style="color:red;">Tidak dapat diperpanjang lebih dari 2X</i>';
			 		$info_jatuh_tempo_berikutnya = '<b style="color:red;">-</b>';

				}else if($value->jml_perpanjangan < 2){
					
					$checklist = '<div class="checkbox">
				                <label>
				                  <input type="checkbox" class="icheckbox_flat-blue" name="pinjam_detail_id" value="'.$value->id.'">
				                </label>
				             </div>';
					$info_tanggal_pinjam_perpanjangan ='<i><b>Jml perpanjangan</b><i> <br> '.$value->jml_perpanjangan;
			 		$info_jatuh_tempo_berikutnya = date('d-M-Y',strtotime($jatuh_tempo_berikutnya));

				}

			}else if($date_diff > 0 ){
				$checklist = '<medium><span class="label label-danger"><i class="fa fa-times"></i></span></medium>';
				$info_tanggal_pinjam_perpanjangan = '<i style="color:red;">Tidak dapat diperpanjang <br>
			 		Sudah melebihi tanggal jatuh tempo</i>';
			 	$info_jatuh_tempo_berikutnya = '<b style="color:red;">-</b>';	 
			}
			
			$no++;
			$row = array();
			$row[] = $checklist;
			$row[] = $no;
			$row[] = $value->judul;
			$row[] = $info_tanggal_pinjam_perpanjangan; 
			$row[] = date('d-M-Y',strtotime($value->jatuh_tempo));
			$row[] = $info_jatuh_tempo_berikutnya;
		    $row[] = $value->id;
		    $row[] = $value->buku_id;

            $data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_perpanjangan->count_all($anggota_id),
            "recordsFiltered" => $this->m_perpanjangan->count_filtered($anggota_id),
            "data" => $data
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function prosesPerpanjangan(){
		$req_perpanjangan = $this->input->post('req_perpanjangan');
		
		foreach ($req_perpanjangan as $value) {
			//update tabel pinjam_detail
			$where_id = array(
				'id'	=> $value[0]
			);
			//ambil data jumlah perpanjangan
			$dt = $this->m_perpanjangan->getJmlPerpanjangan($value[0])->result();
			//looping update jumlah_perpanjangan & jatuh_tempo 
			$data_update_pinjam_detail = array(
				'jml_perpanjangan'  => ($dt[0]->jml_perpanjangan + 1),
				'jatuh_tempo'	=> date('Y-m-d', strtotime($value[3]))
			);
			$this->m_perpanjangan->updateData($where_id,$data_update_pinjam_detail);

			//looping input tabel history perpanjangan
			$data_input_history = array(
				'pinjam_detail_id'		=> $value[0],
				'buku_id'				=> $value[1],
				'user_id'				=> $this->session->userdata('id'),
				'jatuh_tempo_awal'		=> date('Y-m-d', strtotime($value[2])),
				'jatuh_tempo_berikutnya' => date('Y-m-d', strtotime($value[3])),
				'updated_at'			=> date('Y-m-d H:i:s')
			);
			$this->m_perpanjangan->storeData($data_input_history); 	
		}


		$result = array(
			'keterangan' => "OK",
			'msg'		 => "Transaksi Sukses"
		);
		echo json_encode($result);
	}

}
