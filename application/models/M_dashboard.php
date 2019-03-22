<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

	public function totalAnggota(){
		$this->db->select('id');
		$this->db->from('anggota');
		$this->db->where('status', 1);
		return $this->db->count_all_results();
	}

	public function totalBuku(){
		$this->db->select('id');
		$this->db->from('buku');
		return $this->db->count_all_results();
	}

	public function totalPinjam(){
		$this->db->select('id');
		$this->db->from('pinjam_detail');
		$this->db->where('DATE(created_at)', date('Y-m-d'));
		return $this->db->count_all_results();
	}

	public function totalKembali(){
		$this->db->select('id');
		$this->db->from('pinjam_detail');
		$this->db->where('tanggal_kembali', date('Y-m-d'));
		return $this->db->count_all_results();
	}
}
