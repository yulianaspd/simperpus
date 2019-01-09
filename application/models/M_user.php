<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

	public function get_data(){
		return $this->db->get('user');
	}

	public function store_data($data){
		$this->db->insert('user', $data);
	}

	public function get_edit($where){
		return $this->db->get_where('user', $where);
	}

	public function update_data($where, $data){
		$this->db->where($where);
		$this->db->update('user', $data);
	}

	public function delete_data($where){
		$this->db->where($where);
		$this->db->delete('user');
	}
}
