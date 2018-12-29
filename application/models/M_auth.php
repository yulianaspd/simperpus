<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

	public function loggedIn(){
		return $this->session->userdata('email');
	}

	public function checkLogin($table,$where)
	{
		$query = $this->db->get_where($table, $where);
		if($query->num_rows() == 0){
			return FALSE;
		}else{
			return $query->result();
		}
	}

}
