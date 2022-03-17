<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{

	var $tbl_penjualan = 'tbl_transaksi_penjualan';
	var $tbl_pembayaran = 'tbl_transaksi_penjualan_pembayaran';


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function addPenjualan($data)
	{
		$this->db->insert($this->tbl_penjualan, $data);
		return $this->db->insert_id();
	}
	public function addPembayaran($data)
	{
		$this->db->insert($this->tbl_pembayaran, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$data['rec_update'] = date('Y-m-d H:i:s');
		$this->db->update($this->tbl_penjualan, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('idbarang', $id);
		$this->db->delete($this->tbl_penjualan);
	}
}
