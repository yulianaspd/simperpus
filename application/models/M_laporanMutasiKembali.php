<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_laporanMutasiKembali extends CI_Model
{
	var $table = 'pinjam';
	var $column_order = array(null,'nama_lengkap','judul','jatuh_tempo','tanggal_kembali'); //field yang ada di table user
	var $column_search = array('nama_lengkap','judul','jatuh_tempo','tanggal_kembali'); //field yang diizin untuk pencarian 
	var $order = array('tanggal_pinjam' => 'asc'); // default order 
	
	private function _get_datatables_query($tanggal_kembali, $status)
	{
		$this->db->select('anggota.kode');
		$this->db->select('anggota.nama_lengkap');
		$this->db->select('v_pinjam_detail.judul');
		$this->db->select('v_pinjam_detail.jatuh_tempo');
		$this->db->select('v_pinjam_detail.tanggal_kembali');
		$this->db->from($this->table); 
		$this->db->join('
						(SELECT 
							pinjam_detail.pinjam_id,
							buku.judul,
							pinjam_detail.jatuh_tempo,
							pinjam_detail.status,
							pinjam_detail.tanggal_kembali
						 FROM pinjam_detail, buku
						 WHERE 
						 	pinjam_detail.buku_id = buku.id AND
						 	pinjam_detail.status = "'.$status.'" AND
						 	pinjam_detail.tanggal_kembali BETWEEN "'. $tanggal_kembali[0]. '" AND "'. $tanggal_kembali[1].'"
						) AS v_pinjam_detail','v_pinjam_detail.pinjam_id = pinjam.id');
		$this->db->join('anggota','anggota.id = pinjam.anggota_id');


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

	function get_datatables($tanggal_kembali, $status)
	{
		$this->_get_datatables_query($tanggal_kembali, $status);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();

		return $query->result();
	}

	function count_filtered($tanggal_kembali, $status)
	{
		$this->_get_datatables_query($tanggal_kembali, $status);
		$query = $this->db->get();
		
		return $query->num_rows();
	}

	public function count_all($tanggal_kembali, $status)
	{
		$this->db->select('anggota.kode');
		$this->db->select('anggota.nama_lengkap');
		$this->db->select('v_pinjam_detail.judul');
		$this->db->select('v_pinjam_detail.jatuh_tempo');
		$this->db->select('v_pinjam_detail.tanggal_kembali');
		$this->db->from($this->table); 
		$this->db->join('
						(SELECT 
							pinjam_detail.pinjam_id,
							buku.judul,
							pinjam_detail.jatuh_tempo,
							pinjam_detail.status,
							pinjam_detail.tanggal_kembali
						 FROM pinjam_detail, buku
						 WHERE 
						 	pinjam_detail.buku_id = buku.id AND
						 	pinjam_detail.status = "'.$status.'" AND
						 	pinjam_detail.tanggal_kembali BETWEEN "'. $tanggal_kembali[0]. '" AND "'. $tanggal_kembali[1].'"
						) AS v_pinjam_detail','v_pinjam_detail.pinjam_id = pinjam.id');
		$this->db->join('anggota','anggota.id = pinjam.anggota_id');

		return $this->db->count_all_results();
	}

	//======================================================================

	public function downloadPdf($tanggal_kembali){
		$this->db->select('anggota.kode');
		$this->db->select('anggota.nama_lengkap');
		$this->db->select('v_pinjam_detail.judul');
		$this->db->select('v_pinjam_detail.jatuh_tempo');
		$this->db->select('v_pinjam_detail.tanggal_kembali');
		$this->db->from($this->table); 
		$this->db->join('
						(SELECT 
							pinjam_detail.pinjam_id,
							buku.judul,
							pinjam_detail.jatuh_tempo,
							pinjam_detail.status,
							pinjam_detail.tanggal_kembali
						 FROM pinjam_detail, buku
						 WHERE 
						 	pinjam_detail.buku_id = buku.id AND
						 	pinjam_detail.status = 0 AND
						 	pinjam_detail.tanggal_kembali BETWEEN "'. $tanggal_kembali[0]. '" AND "'. $tanggal_kembali[1].'"
						) AS v_pinjam_detail','v_pinjam_detail.pinjam_id = pinjam.id');
		$this->db->join('anggota','anggota.id = pinjam.anggota_id');

		$query = $this->db->get();
		
		return $query;
	}
}