<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pinjamDetail extends CI_Model {

	public function getData(){
	}

	public function showPinjamId($id){
		$this->db->distinct();
		$this->db->select('id');
		$this->db->from('pinjam');
		$this->db->where('id', $id);
		$query = $this->db->get();

		return $query;
	}


	public function storeData($data){
		$this->db->insert('pinjam_detail', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('pinjam_detail', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('pinjam_detail', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('pinjam_detail');
	}
}
