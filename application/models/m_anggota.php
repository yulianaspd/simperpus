<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_anggota extends CI_Model {

	public function getData(){
		return $this->db->get('anggota');
	}

	public function showData($id){
		$this->db->select('*'); 
		$this->db->from('kategori');
		$this->db->where('id', $id);
		
		return $query = $this->db->get();
	}

	public function storeData($data){
		$this->db->insert('anggota', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('anggota', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('anggota', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('anggota');
	}
}
