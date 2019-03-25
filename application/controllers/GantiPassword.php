<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GantiPassword extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(['m_auth','m_gantiPassword']);
		if(!$this->m_auth->loggedIn()){
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] 	= 'Ganti Password';
		$data['icon'] 	= 'fa fa-key';
		$data['uri']	= $this->uri->segment(1);
		$this->load->view('layout/header', $data);
		$this->load->view('ganti-password/index', $data);
		$this->load->view('layout/footer');
	}

	public function updatePassword(){
		$id 			= $this->session->userdata('id');
		$password_lama	= $this->input->post('password_lama');
		$password_baru 	= $this->input->post('password_baru');
		$password_konfirmasi = $this->input->post('password_konfirmasi');

		$where = array(
				'id'	=> $id
			);
		
		$where_check = array(
				'id'		=> $id,
				'password' 	=> md5($password_lama) 
			);

		$data = array(
				'password' 	=> md5($password_konfirmasi)
			);

		$check_pass = $this->m_gantiPassword->checkPassword($where_check);
		if( $check_pass != FALSE ){
			if( strlen($password_baru) < 6 && strlen($password_konfirmasi) < 6 ) {
				$this->session->set_flashdata('notif', '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Input Password Minimal 6 Karakter ! </div>');
					redirect('gantiPassword/index');	
			}else{	
				if($password_baru != $password_konfirmasi){
					$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Password Baru & Konfirmasi Tidak Cocok ! </div>');
					redirect('gantiPassword/index');	
				}else{
					$this->m_gantiPassword->updatePassword($where,$data);		
					$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Success! Password Berhasil Update </div>');
					redirect('gantiPassword/index');	
				}
			}

		}else{
			$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Password Lama Salah ! </div>');
			redirect('gantiPassword/index');	
		}
	}

}
