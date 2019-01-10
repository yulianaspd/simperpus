<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_buku extends CI_Model {

	public function getData(){
		return $this->db->get('buku');
	}

	public function storeData($data){
		$this->db->insert('buku', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('buku', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('buku', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('buku');
	}
}
