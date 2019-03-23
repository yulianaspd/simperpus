<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(['m_auth','m_dashboard']);
		$this->load->library('user_agent');
		if(!$this->m_auth->loggedIn()){
			redirect('auth');
		}
	}

	public function index()
	{
    	$data['title']	= 'Dashboard';
    	$data['icon']	= 'fa fa-dashboard';
    	$data['uri']	= $this->uri->segment(1);
    	
    	$data['total_anggota_aktif'] 	= $this->m_dashboard->totalAnggota();
    	$data['total_judul_buku'] 		= $this->m_dashboard->totalBuku();
    	$data['total_pinjam_hari_ini'] 	= $this->m_dashboard->totalPinjam();
    	$data['total_kembali_hari_ini'] = $this->m_dashboard->totalKembali();
		
		$data['nama_petugas']	= $this->session->userdata('nama_lengkap');
		$data['jenis_kelamin']	= $this->session->userdata('jenis_kelamin');
		$data['jabatan']		= 'Administrator';

		if ($this->agent->is_mobile('iphone'))
		{
		    $perangkat = 'iPhone';
		}
		elseif ($this->agent->is_mobile())
		{
		 	$perangkat = 'Mobile Phone';
		}
		else
		{
		    $perangkat = 'Komputer / Laptop';
		}

		$data['ip']			= $this->input->ip_address();
		$data['perangkat']	= $perangkat;
		$data['os']			= $this->agent->platform();
		$data['browser']	= $this->agent->browser().' - '.$this->agent->version();

		$chart_minggu_ini = $this->m_dashboard->chartMingguIni()->result();
		foreach ($chart_minggu_ini as $key => $value) {
			$arr_chart_minggu_ini[] = array(
              'tanggal'  	=> $value->tanggal_pinjam,
              'total'  		=> $value->total
            );
		}

		$data['chart_minggu_ini'] = json_encode($arr_chart_minggu_ini);

		$this->load->view('layout/header', $data);
		$this->load->view('v_dashboard', $data);  
		$this->load->view('layout/footer');       
	}

}
