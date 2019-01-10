<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penulis extends CI_Model {

	public function getData(){
		return $this->db->get('penulis');
	}

	public function storeData($data){
		$this->db->insert('penulis', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('penulis', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('penulis', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('penulis');
	}
}
