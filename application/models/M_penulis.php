<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penulis extends CI_Model {

	public function get_data(){
		return $this->db->get('penulis');
	}

	public function store_data($data){
		$this->db->insert('penulis', $data);
	}

	public function get_edit($where){
		return $this->db->get_where('penulis', $where);
	}

	public function update_data($where, $data){
		$this->db->where($where);
		$this->db->update('penulis', $data);
	}

	public function delete_data($where){
		$this->db->where($where);
		$this->db->delete('penulis');
	}
}
