<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
	}
	public function get_barang()
	{
		$html = '';
		$search = $this->input->get('q');
		$barang = $this->db
			->join('tbl_barang_kategori', 'tbl_barang.idkategori = tbl_barang_kategori.idkategori')
			->like('tbl_barang.nmbarang', $search)
			->join('tbl_barang_satuan', 'tbl_barang.idsatuan = tbl_barang_satuan.idsatuan')
			->get_where('tbl_barang', ['tbl_barang.publish' => 'T'])->result();
		if (count($barang) > 0) {
			foreach ($barang as $b) {
				$html .= '<div class="col-md-6">
				<a href="javascript:void(0)" onclick=\'addItem(' . json_encode($b) . ');\'>
					<div class="card">
						<div class="card-body">
							<div class="d-flex justify-content-between">
								<div class="">
									<p class="m-0">' . $b->nmbarang . ' | ' . $b->merek . '</p>
									<small class="text-secondary">' . $b->nmsatuan . '</small><br>
									<small class="text-secondary">' . $b->nmkategori . '</small><br>
								</div>
								<div class="text-right">
									<p class="m-0 text-warning">Rp ' . number_format($b->harga_jual, 2) . '</p>
									<small class="text-secondary">tersedia : ' . $b->stok . '</small><br>
									<small class="text-secondary">tonase : ' . $b->tonase . '</small>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>';
			}
		} else {
			$html .= '<h5 class="text-center m-4 p-4">Kosong ...</h5>';
		}
		echo $html;
	}
}
