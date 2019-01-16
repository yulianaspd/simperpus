<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_anggota extends CI_Model {

	var $table = 'anggota'; //nama tabel dari database
	var $column_order = array(null, 'kode','no_identitas','jenis_identitas','nama_lengkap','nama_panggilan','alamat','telepon','foto'); //field yang ada di table user
	var $column_search = array('kode','no_identitas','jenis_identitas','nama_lengkap','nama_panggilan','alamat','telepon','foto'); //field yang diizin untuk pencarian 
	var $order = array('id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
//=========================================================
	public function getData(){
		return $this->db->get('anggota');
	}

	public function showData($id){
		$this->db->select('*'); 
		$this->db->from('kategori');
		$this->db->where('id', $id);
		
		return $query = $this->db->get();
	}

	public function storeData($data){
		$this->db->insert('anggota', $data);
	}

	public function getEdit($where){
		return $this->db->get_where('anggota', $where);
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('anggota', $data);
	}

	public function deleteData($where){
		$this->db->where($where);
		$this->db->delete('anggota');
	}
}
