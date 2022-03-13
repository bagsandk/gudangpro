<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $data['content'] = 'penjualan/index';
    $this->load->view('templates/main', $data);
  }
  public function add()
  {
    $data['content'] = 'penjualan/add';
    $this->load->view('templates/main', $data);
  }
  public function detail()
  {
    $data['content'] = 'penjualan/detail';
    $this->load->view('templates/main', $data);
  }
  public function get_penjualan($jenis = 'semua')
  {
    $html = '<div id="accordion">';
    $penjualan = $this->db->join('tbl_pelanggan', 'tbl_pelanggan.idpelanggan = tbl_transaksi_penjualan.idpelanggan')->get_where('tbl_transaksi_penjualan', ['tbl_transaksi_penjualan.publish' => 'T'])->result();
    foreach ($penjualan as $index => $penj) {
      $expand =  $index == 0 ? 'true' : 'false';
      $show =  $index == 0 ? 'show' : '';
      $p_detail = $this->db
        ->select('*,tbl_transaksi_penjualan_detail.harga_jual as harga_jual')
        ->join('tbl_barang', 'tbl_barang.idbarang = tbl_transaksi_penjualan_detail.idbarang')
        ->join('tbl_barang_kategori', 'tbl_barang.idkategori = tbl_barang_kategori.idkategori')
        ->get_where('tbl_transaksi_penjualan_detail', ['idt_penjualan' => $penj->idt_penjualan])
        ->result();
      $html .= '<div class="card"><div class="p-3" style="background: rgb(63, 77, 103); color: white;" data-toggle="collapse" data-target="#collapse-' . $penj->idt_penjualan . '" aria-expanded="' . $expand . '" aria-controls="collapse-' . $penj->idt_penjualan . '" class="card-header" id="headingOne">
        <div class="d-flex justify-content-between align-items-center">
          <p class="m-0">' . $penj->nmpelanggan . '</p>
          <div class="text-right">
            <p class="m-0">' . $penj->nofaktur . '
            </p>
            <small>' . $penj->tgl_transaksi . '</small>
          </div>
        </div>
      </div>
      <div id="collapse-' . $penj->idt_penjualan . '" class="collapse ' . $show . '" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body p-1">';
      foreach ($p_detail as $detail) {
        $html .= '<div class="my-1 card">
        <div class="p-2 card-body">
          <div class="row">
            <div class="col-md-9 col-sm-9 col-8">
              <h6 class="mb-0 card-title">' . $detail->nmbarang . '</h6>
              <p class="text-mute my-0 card-text"><small>kategori : ' . $detail->nmkategori . '</small></p>
              <small>tonase : ' . $detail->tonase . '</small>
              <br>
              <small>x' . $detail->qty . '</small>
            </div>
            <div class="d-flex justify-content-end align-items-center col-md-3 col-sm-3 col-4">
              <div class="text-right">
                <h6 class="text-right">Rp ' . number_format($detail->harga_jual, 2) . '</h6>
                <p>-' . $detail->discount . '%</p>
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
        <h6 class="text-right my-2 mr-2"><small>Total : </small>Rp ' . number_format($penj->total, 2) . '</h6><a href="' . base_url('penjualan/detail/1') . '" class="float-right m-0 mr-1 btn text-info btn-sm">Detail</a>
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
