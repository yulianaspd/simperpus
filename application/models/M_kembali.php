<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kembali extends CI_Model {

	var $table = 'pinjam'; //nama tabel dari database
	var $column_order = array(null,'judul', 'tanggal_pinjam','jatuh_tempo','status'); //field yang ada di table user
	var $column_search = array('judul', 'tanggal_pinjam','jatuh_tempo','status'); //field yang diizin untuk pencarian 
	var $order = array('id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		//$this->db->from($this->table);
		// $this->db->select('pinjam.id');
		// $this->db->select('pinjam.kode_pinjam');
		// $this->db->select('anggota.kode');
		// $this->db->select('anggota.nama_lengkap');
		// $this->db->from($this->table);
		// $this->db->join('anggota','anggota.id = pinjam.anggota_id');
		// $query_pinjam = $this->db->get();

		// $this->db->select();
		// $this->from($query->pinjam)
		$this->db->query('SELECT detail_pinjam_buku.id,
								 detail_pinjam_buku.pinjam_id,
								 detail_pinjam_buku.judul,
								 detail_pinjam_buku.tanggal_pinjam,
								 detail_pinjam_buku.jatuh_tempo,
								 detail_pinjam_buku.status
						FROM
						(
							SELECT pinjam.id, anggota.kode
						    FROM pinjam, anggota
						    WHERE
						    pinjam.anggota_id = anggota.id 
						)AS pinjam_buku,
						(
						    SELECT
						    pinjam_detail.id,
						    pinjam_detail.pinjam_id,
						    buku.judul,
						    pinjam_detail.created_at AS tanggal_pinjam,
						    pinjam_detail.jatuh_tempo,
						    pinjam_detail.status
						    FROM
						    pinjam_detail,
						    buku
						    WHERE
						    buku.id = pinjam_detail.buku_id AND
							pinjam_detail.status != 0    
						) AS detail_pinjam_buku
						WHERE pinjam_buku.id= detail_pinjam_buku.pinjam_id')->get();

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
		$this->db->query('SELECT detail_pinjam_buku.id,
								 detail_pinjam_buku.pinjam_id,
								 detail_pinjam_buku.judul,
								 detail_pinjam_buku.tanggal_pinjam,
								 detail_pinjam_buku.jatuh_tempo,
								 detail_pinjam_buku.status
						FROM
						(
							SELECT pinjam.id, anggota.kode
						    FROM pinjam, anggota
						    WHERE
						    pinjam.anggota_id = anggota.id 
						)AS pinjam_buku,
						(
						    SELECT
						    pinjam_detail.id,
						    pinjam_detail.pinjam_id,
						    buku.judul,
						    pinjam_detail.created_at AS tanggal_pinjam,
						    pinjam_detail.jatuh_tempo,
						    pinjam_detail.status
						    FROM
						    pinjam_detail,
						    buku
						    WHERE
						    buku.id = pinjam_detail.buku_id AND
							pinjam_detail.status != 0    
						) AS detail_pinjam_buku
						WHERE pinjam_buku.id= detail_pinjam_buku.pinjam_id')->get();
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
