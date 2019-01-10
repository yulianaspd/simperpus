<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rak extends CI_Model {

	public function getData(){
		return $this->db->get('rak');
	}

	public function storeData($data){
		$this->db->insert('rak', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('rak', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('rak', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('rak');
	}
}
