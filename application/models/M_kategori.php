<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kategori extends CI_Model {

	public function getData(){
		$this->db->select('*'); 
		$this->db->from('kategori');
		$this->db->join('rak', 'rak.id = kategori.rak_id');
		$query = $this->db->get();

		return $query;
	}

	public function getShow($id){
		
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
