<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kategori extends CI_Model {

	public function get_data(){
		return $this->db->get('kategori');
	}

	public function get_rak(){
		return $this->db->get('rak');
	}

	public function store_data($data){
		$this->db->insert('katgeori', $data);
	}

	public function get_edit($where){
		return $this->db->get_where('kategori', $where);
	}

	public function update_data($where, $data){
		$this->db->where($where);
		$this->db->update('kategori', $data);
	}

	public function delete_data($where){
		$this->db->where($where);
		$this->db->delete('kategori');
	}
}
