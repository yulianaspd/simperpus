<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rak extends CI_Model {

	public function get_data(){
		return $this->db->get('rak');
	}

	public function store_data($data){
		$this->db->insert('rak', $data);
	}

	public function get_edit($where){
		return $this->db->get_where('rak', $where);
	}

	public function update_data($where, $data){
		$this->db->where($where);
		$this->db->update('rak', $data);
	}

	public function delete_data($where){
		$this->db->where($where);
		$this->db->delete('rak');
	}
}
