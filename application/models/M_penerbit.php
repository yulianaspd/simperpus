<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penerbit extends CI_Model {

	public function get_data(){
		return $this->db->get('penerbit');
	}

	public function store_data($data){
		$this->db->insert('penerbit', $data);
	}

	public function get_edit($where){
		return $this->db->get_where('penerbit', $where);
	}

	public function update_data($where, $data){
		$this->db->where($where);
		$this->db->update('penerbit', $data);
	}

	public function delete_data($where){
		$this->db->where($where);
		$this->db->delete('penerbit');
	}
}
