<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_buku extends CI_Model {

	public function get_data(){
		return $this->db->get('buku');
	}

	public function get_kategori(){
		return $this->db->get('kategori');
	}

	public function get_penulis(){
		return $this->db->get('penulis');
	}

	public function get_penerbit(){
		return $this->db->get('penerbit');
	}

	public function store_data($data){
		$this->db->insert('buku', $data);
	}

	public function get_edit($where){
		return $this->db->get_where('buku', $where);
	}

	public function update_data($where, $data){
		$this->db->where($where);
		$this->db->update('buku', $data);
	}

	public function delete_data($where){
		$this->db->where($where);
		$this->db->delete('buku');
	}
}
