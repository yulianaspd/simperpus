<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rak extends CI_Model {
	
	// fungsi untuk datatabel serverside
	var $table = 'rak';
	var $column_order = array(null,'kode');
	var $column_search = array(null,'kode');
	var $order = array('id' => 'asc');

	private function getDatatablesQuery(){
		$this->db->from($this->table);
		$i = 0;
		foreach ($this->column_search as $item) {
			if($_POST['search']['value']){
				
				if($i === 0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i){
					$this->db->group_end();
				}
			}
			$i++;
		}

		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order['order']['0']['column'], $_POST['order']['0']['dir']);
		}else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function getDatatables(){
		$this->getDatatablesQuery();
		if($_POST['length'] != -1){
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
	}

	function countFiltered(){
		$this->getDatatablesQuery();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function countAll(){
		$this->db->select("*");  
		$this->db->from($this->table);
		$query = $this->db->get();
		return $query;
	}
	//======================================================================

	public function getData(){
		return $this->db->get('rak');
	}

	public function storeData($data){
		$this->db->insert('rak', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('rak', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('rak', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('rak');
	}		
}
