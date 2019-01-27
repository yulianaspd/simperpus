<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_user');
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
						'id'		=> $data->id,
						'nama'		=> $data->nama,
						'email' 	=> $data->email,
						'password' 	=> $data->password 
					);
					$this->session->set_userdata($session_data);
					redirect(base_url("dashboard"));
				}
			}else{
				$data['error'] = 'username / password salah';
				$this->load->view('v_dashboard',$data);
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
