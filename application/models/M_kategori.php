<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kategori extends CI_Model {

	public function getData(){
		return $this->db->get('kategori');
	}

	public function storeData($data){
		$this->db->insert('katgeori', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('kategori', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('kategori', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('kategori');
	}
}
