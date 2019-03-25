<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_gantiPassword extends CI_Model {

	public function checkPassword($where_check){
		$this->db->select('password');
		$this->db->from('user');
		$this->db->where($where_check);
		$query = $this->db->get();

		if($query->num_rows() == 0){
			return FALSE;
		}else{
			return $query->result();
		}
	}

	public function updatePassword($where, $data){
		$this->db->where($where);
		$this->db->update('user', $data);
	}

}
