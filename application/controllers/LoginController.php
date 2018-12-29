<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Login');
	}

	public function index()
	{
		if( $this->Login->loggedIn() ){
			redirect(base_url("DashboardController"));
		}else{
			$this->load->view('v_login');
		}
	}

	public function loginAction(){
		
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
				$checking = $this->Login->checkLogin('user', $where);
				
				if($checking != FALSE){
					foreach($checking as $data){
						$session_data = array(
							'nama'	=> $data->nama,
							'email' => $data->email,
							'password' => $data->password 
						);
						$this->session->set_userdata($session_data);
						redirect(base_url("DashboardController"));
					}
				}else{
					$data['error'] = 'username / password salah';
					$this->load->view('v_dashboard',$data);
				}
			}else{
				$this->load->view('v_login');
			}

		// $email		= $this->input->post('email');
		// $password	= $this->input->post('password');
		// $where = array (
		// 	'email' => $email,
		// 	'password' => $password
		// );
		// $cek = $this->Login->cekLogin("user", $where)->num_rows();
		// if($cek > 0){
		// 	$data_session = array(
		// 		'status' => "logged in"
		// 	);
		// 	$this->session->set_userdata($data_session);
		// 	redirect(base_url("AdminController"));
		// }else{
		// 	echo "Username dan password salah";
		// }
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url('logincontroller'));
	}

}
