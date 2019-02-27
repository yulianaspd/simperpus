<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kembali extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(
			[
				'm_kembali',
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
		$data['title'] 	= 'Kembali';
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
					'anggota'	 => $anggota[0] 
				);
				echo json_encode($result);	
			}	
		}
	}

	public function ajaxGetPinjam(){
		$anggota_id = $this->input->post('anggota_id');
		$list 		= $this->m_kembali->get_datatables($anggota_id);
		$data 		= array();
		$no 		= $_POST['start'];
		$today 		= date("Y-m-d");
		$terlambat;
		$denda = 0;
		$total_denda = 0;
		
  		
		foreach($list as $value){
			$time1 = new DateTime($value->jatuh_tempo);
  			$time2 = new DateTime($today);
  			$resultTime = date_diff($time1, $time2);
			$date_diff = (strtotime($today) - strtotime($value->jatuh_tempo))/86400;
			if($date_diff > 0){
				$terlambat = '<div style="color:red">'.$date_diff." hari</div>";
				$denda = 1000*$date_diff;
			}else{
				$terlambat = "-";
				$denda ;
			}
			
			$no++;
			$row = array();
			$row[] = '
		              <div class="checkbox">
		                <label>
		                  <input type="checkbox" class="icheckbox_flat-blue" name="pinjam_detail_id" value="'.$value->id.'">
		                </label>
		              </div>';
			$row[] = $no;
			$row[] = $value->judul;
			$row[] = $value->tanggal_pinjam;
			$row[] = $value->jatuh_tempo;
			$row[] = $terlambat." Hari";
			$row[] = number_format($denda);
		    $row[] = $value->id;
		    $row[] = $value->pinjam_id;

            $data[] = $row;
            $total_denda += $denda;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_kembali->count_all($anggota_id),
            "recordsFiltered" => $this->m_kembali->count_filtered($anggota_id),
            "data" => $data,
            "total_denda" => $total_denda,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function prosesKembali(){
		$denda = $this->input->post('denda');
		$pinjam_id = $this->input->post('pinjam_id');
		$total_denda = $this->input->post('total_denda');

		//update tabel pinjam_detail field status,tanggal_kembali,denda
		foreach($denda as $value){
			$where = array(
				'id'	=> $value[0]
			);
			
			$data_detail = array(
				'status' 		  => 0,
				'tanggal_kembali' => date('Y-m-d H:i:s'),
				'denda'			  => $value[1],
				'updated_at' 	  => date('Y-m-d H:i:s')	
			);
			$this->m_pinjamDetail->updateData($where, $data_detail);
		}
		
		//update tabel pinjam field total_denda
		foreach($pinjam_id[0] as $val_pinjam_id){
			$res = $this->m_kembali->sumTotalDendaById($val_pinjam_id);
			$where_pinjam_id = array(
				'id'	=> $val_pinjam_id
			);

			$data_pinjam_id = array(
				'total_denda' 	=> $res->total_denda,
				'updated_at'	=> date('Y-m-d H:i:s'),
			);

			$this->m_pinjam->updateData($where_pinjam_id, $data_pinjam_id);
		}

		$result = array(
			'keterangan' => "OK",
			'msg'		 => "Transaksi Sukses",
		);
		echo json_encode($result);
	}

}
