<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_laporanMutasiPinjam extends CI_Model
{
	var $table = 'pinjam';
	var $column_order = array(null,'nama_lengkap','judul','tanggal_pinjam','jatuh_tempo'); //field yang ada di table user
	var $column_search = array('nama_lengkap','judul','tanggal_pinjam','jatuh_tempo'); //field yang diizin untuk pencarian 
	var $order = array('tanggal_pinjam' => 'asc'); // default order 
	
	private function _get_datatables_query($tanggal_pinjam)
	{
		$this->db->select('anggota.kode');
		$this->db->select('anggota.nama_lengkap');
		$this->db->select('v_pinjam_detail.judul');
		$this->db->select('pinjam.tanggal_pinjam');
		$this->db->select('v_pinjam_detail.jatuh_tempo');
		$this->db->select('v_pinjam_detail.jml_perpanjangan');
		$this->db->from($this->table); 
		$this->db->join('
						(SELECT 
							pinjam_detail.pinjam_id,
							buku.judul,
							pinjam_detail.jml_perpanjangan,
							pinjam_detail.jatuh_tempo
						 FROM pinjam_detail, buku
						 WHERE 
						 	pinjam_detail.buku_id = buku.id AND
						 	DATE(pinjam_detail.created_at) BETWEEN "'. $tanggal_pinjam[0]. '" AND "'. $tanggal_pinjam[1].'"
						) AS v_pinjam_detail','v_pinjam_detail.pinjam_id = pinjam.id');
		$this->db->join('anggota','anggota.id = pinjam.anggota_id');
		$this->db->where('pinjam.tanggal_pinjam BETWEEN "'. $tanggal_pinjam[0]. '" AND "'. $tanggal_pinjam[1].'"');


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

	function get_datatables($tanggal_pinjam)
	{
		$this->_get_datatables_query($tanggal_pinjam);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();

		return $query->result();
	}

	function count_filtered($tanggal_pinjam)
	{
		$this->_get_datatables_query($tanggal_pinjam);
		$query = $this->db->get();
		
		return $query->num_rows();
	}

	public function count_all($tanggal_pinjam)
	{
		
		$this->db->select('anggota.kode');
		$this->db->select('anggota.nama_lengkap');
		$this->db->select('v_pinjam_detail.judul');
		$this->db->select('pinjam.tanggal_pinjam');
		$this->db->select('v_pinjam_detail.jatuh_tempo');
		$this->db->select('v_pinjam_detail.jml_perpanjangan');
		$this->db->from($this->table); 
		$this->db->join('
						(SELECT 
							pinjam_detail.pinjam_id,
							buku.judul,
							pinjam_detail.jml_perpanjangan,
							pinjam_detail.jatuh_tempo
						 FROM pinjam_detail, buku
						 WHERE 
						 	pinjam_detail.buku_id = buku.id AND
						 	DATE(pinjam_detail.created_at) BETWEEN "'. $tanggal_pinjam[0]. '" AND "'. $tanggal_pinjam[1].'"
						) AS v_pinjam_detail','v_pinjam_detail.pinjam_id = pinjam.id');
		$this->db->join('anggota','anggota.id = pinjam.anggota_id');
		$this->db->where('pinjam.tanggal_pinjam BETWEEN "'. $tanggal_pinjam[0]. '" AND "'. $tanggal_pinjam[1].'"');

		return $this->db->count_all_results();
	}

	//======================================================================

	public function downloadPdf($tanggal_pinjam){
		$this->db->select('anggota.kode');
		$this->db->select('anggota.nama_lengkap');
		$this->db->select('v_pinjam_detail.judul');
		$this->db->select('pinjam.tanggal_pinjam');
		$this->db->select('v_pinjam_detail.jatuh_tempo');
		$this->db->select('v_pinjam_detail.jml_perpanjangan');
		$this->db->from($this->table); 
		$this->db->join('(SELECT 
							pinjam_detail.pinjam_id,
							buku.judul,
							pinjam_detail.jml_perpanjangan,
							pinjam_detail.jatuh_tempo
						 FROM pinjam_detail, buku
						 WHERE 
						 	pinjam_detail.buku_id = buku.id AND
						 	DATE(pinjam_detail.created_at) BETWEEN "'. $tanggal_pinjam[0]. '" AND "'. $tanggal_pinjam[1].'"
						) AS v_pinjam_detail','v_pinjam_detail.pinjam_id = pinjam.id');
		$this->db->join('anggota','anggota.id = pinjam.anggota_id');
		$this->db->where('pinjam.tanggal_pinjam BETWEEN "'. $tanggal_pinjam[0]. '" AND "'. $tanggal_pinjam[1].'"');

		$query = $this->db->get();
		
		return $query;
	}
}