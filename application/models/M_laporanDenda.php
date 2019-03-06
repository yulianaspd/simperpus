<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_laporanDenda extends CI_Model
{
	var $table = 'pinjam_detail'; //nama tabel dari database
	var $column_order = array(null,'tanggal_kembali','denda'); //field yang ada di table user
	var $column_search = array( 'tanggal_kembali','denda'); //field yang diizin untuk pencarian 
	var $order = array('tanggal_kembali' => 'asc'); // default order 
	
	private function _get_datatables_query($tanggal_kembali)
	{
		$this->db->select('tanggal_kembali, SUM(denda) AS denda');
		$this->db->from($this->table);
		$this->db->where('tanggal_kembali BETWEEN "'. $tanggal_kembali[0]. '" AND "'. $tanggal_kembali[1].'"');
		$this->db->group_by('tanggal_kembali');
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

	function get_datatables($tanggal_kembali)
	{
		$this->_get_datatables_query($tanggal_kembali);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($tanggal_kembali)
	{
		$this->_get_datatables_query($tanggal_kembali);
		$query = $this->db->get();
		
		return $query->num_rows();
	}

	public function count_all($tanggal_kembali)
	{
		$this->db->select('tanggal_kembali, SUM(denda) AS denda');
		$this->db->from($this->table);
		$this->db->where('tanggal_kembali BETWEEN "'. $tanggal_kembali[0]. '" AND "'. $tanggal_kembali[1].'"');
		$this->db->group_by('tanggal_kembali');
		return $this->db->count_all_results();
	}

	//======================================================================

	public function downloadPdf($tanggal_kembali){
		$this->db->select('tanggal_kembali, SUM(denda) AS denda');
		$this->db->from($this->table);
		$this->db->where('tanggal_kembali BETWEEN "'. $tanggal_kembali[0]. '" AND "'. $tanggal_kembali[1].'"');
		$this->db->group_by('tanggal_kembali');
		$query = $this->db->get();
		
		return $query;
	}
}