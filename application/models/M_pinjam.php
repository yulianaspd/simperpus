<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pinjam extends CI_Model {

	public function getData(){
	}

	public function getShow($id){
		return $this->db->get_where('pinjam', $where);
	}

	public function storeData($data){
		$this->db->insert('pinjam', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('pinjam', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('pinjam', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('pinjam');
	}
}
