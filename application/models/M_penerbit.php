<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penerbit extends CI_Model {

	public function getData(){
		return $this->db->get('penerbit');
	}

	public function storeData($data){
		$this->db->insert('penerbit', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('penerbit', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('penerbit', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('penerbit');
	}
}
