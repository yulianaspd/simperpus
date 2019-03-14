<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_user','m_auth');
	}

	public function index()
	{
		if( $this->m_auth->loggedIn() ){
			redirect(base_url("dashboard"));
		}else{
			$this->load->view('v_login');
		}
	}

	public function login(){
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_message('required','harus di isi');

		if($this->form_validation->run() == TRUE){
			$email = $this->input->post('email', TRUE);
			$password = MD5($this->input->post('password',TRUE));
			$where = array(
				'email' => $email,
				'password' => $password
			);
			$checking = $this->m_auth->checkLogin('user', $where);
			
			if($checking != FALSE){
				foreach($checking as $data){
					$session_data = array(
						'id'			=> $data->id,
						'panggilan'		=> $data->panggilan,
						'jenis_kelamin' => $data->jenis_kelamin,
						'email' 		=> $data->email,
						'status' 		=> $data->status 
					);
					$this->session->set_userdata($session_data);
					redirect(base_url("dashboard/index"));
				}
			}else{
				$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Username / Password Salah ! </div>');
				redirect('auth/index');
				// $this->load->view('v_login');
			}
		}else{
			$this->load->view('v_login');
		}
	}


	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url('auth'));
	}

}
