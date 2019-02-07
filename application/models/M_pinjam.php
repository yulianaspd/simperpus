<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pinjam extends CI_Model {

	public function getData(){
	}

	public function showData($kode){
		$this->db->select('*');
		$this->db->from('pinjam');
		$this->db->where('kode_pinjam', $kode);
		$query = $this->db->get();

		return $query->result();
	}

	public function storeData($data){
		$this->db->insert('pinjam', $data);
		return TRUE;
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
