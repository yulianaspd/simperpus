<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

	public function getData(){
		return $this->db->get('user');
	}

	public function storeData($data){
		$this->db->insert('user', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('user', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('user', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('user');
	}
}
