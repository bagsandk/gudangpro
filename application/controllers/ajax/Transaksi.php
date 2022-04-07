<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('barang_model', 'barang');
    $this->load->model('penjualan_model', 'penjualan');
  }

  public function get_penjualan($jenis = 'semua')
  {
    $status = 'BELUM BAYAR';
    $this->get_list($jenis, $status);
  }
  public function get_pembayaran($jenis = 'semua')
  {
    $status = 'PROSES';
    $this->get_list($jenis, $status);
  }
  private function get_list($jenis = 'semua', $status = 'BELUM BAYAR')
  {
    $html = '<div id="accordion">';
    $query = $this->db
      ->order_by('tbl_transaksi_penjualan.rec_insert', 'desc')
      ->join('tbl_pelanggan', 'tbl_pelanggan.idpelanggan = tbl_transaksi_penjualan.idpelanggan');
    if ($jenis !== 'semua') {
      $query->where('jenis_do', strtoupper($jenis));
    }
    $penjualan = $query->get_where('tbl_transaksi_penjualan', ['tbl_transaksi_penjualan.publish' => 'T'])->result();

    foreach ($penjualan as $index => $penj) {
      $expand =  $index == 0 ? 'true' : 'false';
      $collapse = $jenis == 'semua' ? 'semua-' . $penj->idt_penjualan : $penj->jenis_do . '-' . $penj->idt_penjualan;
      $show =  $index == 0 ? 'show' : '';
      $p_detail = $this->db
        ->select('*,tbl_transaksi_penjualan_detail.harga_jual as harga_jual')
        ->join('tbl_barang', 'tbl_barang.idbarang = tbl_transaksi_penjualan_detail.idbarang')
        ->join('tbl_barang_kategori', 'tbl_barang.idkategori = tbl_barang_kategori.idkategori')
        ->get_where('tbl_transaksi_penjualan_detail', ['idt_penjualan' => $penj->idt_penjualan])
        ->result();
      $html .= '<div class="card my-1"><div class="p-3 rounded" style="background: rgb(63, 77, 103); color: white;" data-toggle="collapse" data-target="#collapse-' . $collapse . '" aria-expanded="' . $expand . '" aria-controls="collapse-' . $collapse . '" class="card-header" id="headingOne">
        <div class="d-flex justify-content-between align-items-center">
          <div>
          <p class="m-0">' . $penj->nmpelanggan . '</p>
          <small class="badge badge-light">' . $penj->status . '</small>
          </div>
          <div class="text-right">
            <p class="m-0 text-warning font-weight-bold">' . $penj->nofaktur . '
            </p>
            <small>' . $penj->tgl_transaksi . '</small>
          </div>
        </div>
      </div>
      <div id="collapse-' . $collapse . '" class="collapse ' . $show . '" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body p-1">';
      $tonase = 0;
      foreach ($p_detail as $detail) {
        $tonase += $detail->tonase;
        $html .= '<div class="my-1 card">
        <div class="p-2 card-body">
          <div class="row">
            <div class="col-md-9 col-sm-9 col-8">
              <h6 class="mb-0 card-title">' . $detail->nmbarang . ' | ' . $detail->merek . '</h6>
              <p class="text-mute my-0 card-text"><small>kategori : ' . $detail->nmkategori . '</small></p>
              <small>tonase : ' . $detail->tonase . '</small>
              <br>
              <small>qty : ' . $detail->qty . '</small>
            </div>
            <div class="d-flex justify-content-end align-items-center col-md-3 col-sm-3 col-4">
              <div class="text-right">
                <h6 class="text-primary text-right">Rp ' . number_format($detail->harga_jual, 2) . '</h6>
                <small class="text-danger">Diskon Rp ' . number_format($detail->discount, 2) . ' / qty</small>
              </div>
            </div>
          </div>
        </div>
      </div>';
      }
      $html .= '<div class="row">
      <div class="col-md-8 col-sm-8 col-6">
        <p class="card-text"><small>Ket : ' . $penj->keterangan . '</small></p>
      </div>
      <div class="col-md-4 col-sm-4 col-6">
      <h6 class="text-right my-2 mr-2"><small>Ongkir : </small>Rp ' . number_format($tonase * 60, 2) . '</h6>
        <h4 class="text-right my-2 mr-2 text-success"><small>Grand Total : </small>Rp ' . number_format($penj->total, 2) . '</h4>
        <a href="' . base_url((($status == 'PROSES') ? 'pembayaran' : 'penjualan') . '/detail/' . $penj->idt_penjualan) . '" class="float-right m-0 mr-1 btn text-info btn-sm">Detail</a>
      </div>
    </div>
  </div>
</div>
</div>';
    }
    $html .= '</div>';
    echo $html;
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
								<div class="col-6">
									<p class="m-0">' . $b->nmbarang . '</p>
									<p class="m-0 text-danger">' . $b->merek . '</p>
									<small class="text-secondary">satuan : ' . $b->nmsatuan . '</small><br>
									<small class="text-secondary">kategori : ' . $b->nmkategori . '</small><br>
								</div>
								<div class="col-6 text-right">
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
  public function get_rekening_bank()
  {
    $html = '';
    $search = $this->input->get('q');
    $barang = $this->db
      ->like('tbl_rekening_bank.norekening', $search)
      ->or_like('tbl_rekening_bank.nmnasabah', $search)
      ->get_where('tbl_rekening_bank', ['tbl_rekening_bank.publish' => 'T'])->result();
    if (count($barang) > 0) {
      foreach ($barang as $b) {
        $html .= '<div class="col-md-6">
				<a href="javascript:void(0)" onclick=\'tambahRekening(' . json_encode($b) . ');\'>
					<div class="card">
						<div class="card-body">
							<div class="d-flex justify-content-between">
								<div class="">
									<p class="m-0">No Rek : ' . $b->norekening . '</p>
									<small class="text-secondary">AN : ' . $b->nmnasabah . '</small><br>
									</div>
									<div class="text-right">
									<p class="m-0 text-warning">Bank : ' . $b->nmbank . '</p>
									<small class="text-secondary">Cabang : ' . $b->cabang . '</small><br>
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

  public function get_do($jenis = 'semua')
  {
    $status = 'DIKIRIM';
    $this->get_list_do($jenis, $status);
  }

  private function get_list_do($jenis = 'semua', $status = 'DIKIRIM')
  {
    $html = '<div id="accordion">';
    $query = $this->db
      ->order_by('tbl_transaksi_penjualan_do.rec_insert', 'desc')
      ->join('tbl_armada', 'tbl_armada.idarmada = tbl_transaksi_penjualan_do.idarmada');
    if ($jenis !== 'semua') {
      $query->where('status_do', strtoupper($jenis));
    }
    $penjualan = $query->get_where('tbl_transaksi_penjualan_do', ['tbl_transaksi_penjualan_do.publish' => 'T'])->result();

    foreach ($penjualan as $index => $penj) {
      $expand =  $index == 0 ? 'true' : 'false';
      $collapse = $jenis == 'semua' ? 'semua-' . $penj->idtpdo_penjualan : $penj->status_do . '-' . $penj->idtpdo_penjualan;
      $show =  $index == 0 ? 'show' : '';

      $html .= '<div class="card my-1"><div class="p-3 rounded" style="background: rgb(63, 77, 103); color: white;" data-toggle="collapse" data-target="#collapse-' . $collapse . '" aria-expanded="' . $expand . '" aria-controls="collapse-' . $collapse . '" class="card-header" id="headingOne">
        <div class="d-flex justify-content-between align-items-center">
          <div>
          <p class="m-0">' . $penj->nmpenerima . '</p>
          <small class="badge badge-light">' . $status . ' - ' . $penj->status_do . '</small>
          </div>
          <div class="text-right">
            <p class="m-0 text-warning font-weight-bold">' . $penj->kdtpdo_penjualan . '
            </p>
            <small>' . substr($penj->tgl_buat, 0, 10) . '</small>
          </div>
        </div>
      </div>
      <div id="collapse-' . $collapse . '" class="collapse ' . $show . '" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body p-1">';

      $html .= '<div class="row">
      <div class="col-md-8 col-sm-8 col-6">
        <p class="card-text"><small>Ket : ' . $penj->keterangan . '</small></p>
      </div>
      <div class="col-md-4 col-sm-4 col-6">
        <a href="' . base_url('delivery_order/detail/' . $penj->idt_penjualan) . '" class="float-right m-0 mr-1 btn text-info btn-sm">Detail</a>
      </div>
    </div>
  </div>
</div>
</div>';
    }
    $html .= '</div>';
    echo $html;
  }
}
