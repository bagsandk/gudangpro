<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{

	var $table = 'tbl_transaksi_penjualan';


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function addPenjualan($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$data['rec_update'] = date('Y-m-d H:i:s');
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('idbarang', $id);
		$this->db->delete($this->table);
	}
}
