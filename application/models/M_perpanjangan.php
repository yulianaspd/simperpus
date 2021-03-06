<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_perpanjangan extends CI_Model {

	var $table = 'pinjam_detail'; //nama tabel dari database
	var $column_order = array(null,'judul', 'tanggal_pinjam','jatuh_tempo','status'); //field yang ada di table user
	var $column_search = array('judul', 'tanggal_pinjam','jatuh_tempo','status'); //field yang diizin untuk pencarian 
	var $order = array('pinjam_detail.id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($anggota_id)
	{
		$this->db->select('
				pinjam_detail.id,
				pinjam_detail.buku_id,
				buku.judul AS judul,
				DATE_FORMAT(pinjam_detail.created_at, "%d-%m-%Y %H:%i") AS tanggal_pinjam,
				DATE_FORMAT(pinjam_detail.jatuh_tempo, "%d-%m-%Y") AS jatuh_tempo,
				jml_perpanjangan,
				pinjam_detail.status
			');
		$this->db->from($this->table);
		$this->db->join('pinjam','pinjam.id = pinjam_detail.pinjam_id');
		$this->db->join('buku','buku.id = pinjam_detail.buku_id');
		$this->db->where('pinjam.anggota_id', $anggota_id);
		$this->db->where('pinjam_detail.status', 1);
		
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

	function get_datatables($anggota_id)
	{
		$this->_get_datatables_query($anggota_id);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($anggota_id)
	{
		$this->_get_datatables_query($anggota_id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($anggota_id)
	{
		$this->db->select('
				pinjam_detail.id,
				buku.judul AS judul,
				pinjam_detail.buku_id,
				DATE_FORMAT(pinjam_detail.created_at, "%d-%m-%Y %H:%i") AS tanggal_pinjam,
				DATE_FORMAT(pinjam_detail.jatuh_tempo, "%d-%m-%Y") AS jatuh_tempo,
				jml_perpanjangan,
				pinjam_detail.status
			');
		$this->db->from($this->table);
		$this->db->join('pinjam','pinjam.id = pinjam_detail.pinjam_id');
		$this->db->join('buku','buku.id = pinjam_detail.buku_id');
		$this->db->where('pinjam.anggota_id', $anggota_id);
		$this->db->where('pinjam_detail.status', 1);

		return $this->db->count_all_results();
	}
//===========================================================================================

	public function getJmlPerpanjangan($where){
		$this->db->select('jml_perpanjangan');
		$this->db->from('pinjam_detail');
		$this->db->where('id', $where);
		return $this->db->get();
	}

	public function updateData($where, $data){
		$this->db->where($where);
		$this->db->update('pinjam_detail', $data);
	}

	public function storeData($data){
		$this->db->insert('history_perpanjangan', $data);
	}

}
