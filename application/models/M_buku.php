<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_buku extends CI_Model {

	public function getData(){
		return $this->db->get('buku');
	}

	public function getKategori(){
		return $this->db->get('kategori');
	}

	public function getPenulis(){
		return $this->db->get('penulis');
	}

	public function getPenerbit(){
		return $this->db->get('penerbit');
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
