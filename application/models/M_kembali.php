<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kembali extends CI_Model {

	var $table = 'pinjam'; //nama tabel dari database
	var $column_order = array(null,'isbn', 'judul', 'halaman', 'kategori.nama'); //field yang ada di table user
	var $column_search = array('isbn', 'judul', 'halaman', 'kategori.nama'); //field yang diizin untuk pencarian 
	var $order = array('buku.id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($kode_anggota)
	{
		
		//$this->db->from($this->table);
		$this->db->select([
					'pinjam.id',
					'pinjam.kode_pinjam',
					'anggota.kode',
					'anggota.nama_lengkap',
					'pinjam.tanggal_pinjam',
					'pinjam.qty',
					'pinjam.total_denda',
				]);
		$this->db->from($this->table);
		$this->db->join('user','user.id = pinjam.user_id');
		$this->db->join('anggota','anggota.id = pinjam.anggota_id');
		$this->db->where('anggota.kode', $kode_anggota)
		$query_pinjam = $this->db->get();
		$query_pinjam->result();

		$this->db->select();
		$this->db->from($query_pinjam);
		$this->db->join('pinjam_detail',$query_pinjam->id,'pinjam_detail.pinjam_id');
		

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

	function get_datatables($kode_anggota)
	{
		$this->_get_datatables_query($kode_anggota);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($kode_anggota)
	{
		$this->_get_datatables_query($kode_anggota);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($kode_anggota)
	{
		//$this->db->from($this->table);
		$this->db->select([
					'pinjam.id',
					'pinjam.kode_pinjam',
					'anggota.kode',
					'anggota.nama_lengkap',
					'pinjam.tanggal_pinjam',
					'pinjam.qty',
					'pinjam.total_denda',
				]);
		$this->db->from($this->table);
		$this->db->join('user','user.id = pinjam.user_id');
		$this->db->join('anggota','anggota.id = pinjam.anggota_id');
		$this->db->where('anggota.kode', $kode_anggota)
		$query_pinjam = $this->db->get();
		$query_pinjam->result();

		$this->db->select();
		$this->db->from($query_pinjam);
		$this->db->join('pinjam_detail',$query_pinjam->id,'pinjam_detail.pinjam_id');
		return $this->db->count_all_results();
	}
	
//=========================================================
	public function getData(){
		return $this->db->get('buku');
	}

	public function showData($isbn){
		$this->db->select('*');
		$this->db->from('buku');
		$this->db->where('isbn', $isbn);
		$query = $this->db->get();

		return $query->result();
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
