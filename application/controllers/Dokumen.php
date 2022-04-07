<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dokumen extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    // $this->load->library('Pdf_JavaScript'); 
    $this->load->library('Pdf');
  }
  function faktur($id)
  {
    $tglPrint = date('Y-m-d H:i:s');
    $penjualan = $this->db->order_by('tbl_transaksi_penjualan.rec_insert', 'desc')->join('tbl_pelanggan', 'tbl_pelanggan.idpelanggan = tbl_transaksi_penjualan.idpelanggan')->get_where('tbl_transaksi_penjualan', ['tbl_transaksi_penjualan.publish' => 'T', 'tbl_transaksi_penjualan.idt_penjualan' => $id])->row();
    $p_detail = $this->db
      ->select('*,tbl_transaksi_penjualan_detail.harga_jual as harga_jual')
      ->join('tbl_barang', 'tbl_barang.idbarang = tbl_transaksi_penjualan_detail.idbarang')
      ->join('tbl_barang_satuan', 'tbl_barang.idsatuan = tbl_barang_satuan.idsatuan')
      ->join('tbl_barang_kategori', 'tbl_barang.idkategori = tbl_barang_kategori.idkategori')
      ->get_where('tbl_transaksi_penjualan_detail', ['idt_penjualan' => $penjualan->idt_penjualan])
      ->result();
    $penjualan = $penjualan;
    $detail = $p_detail;
    // $pdf = new PDF_AutoPrint();
    // $pdf->AddPage();
    // $pdf->SetFont('Arial', '', 20);
    // $pdf->Text(90, 50, 'Print me!');
    // $pdf->AutoPrint();
    // $pdf->Output();
    error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
    $pdf->Image(base_url('assets/images/logo-1.png'), 10, 6, -460);
    $pdf->Cell(70, 6,);
    $pdf->Cell(50, 6, 'PT CENTRAL ARTHA ULAM', 0, 0, 'C');
    $pdf->Cell(70, 6, $tglPrint, 0, 1, 'R');
    $pdf->Cell(10, 7, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 6, 'FAKTUR PENJUALAN', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(70, 6,);
    $pdf->Cell(50, 6, 'Tanggal : ' . $penjualan->tgl_transaksi, 0, 0, 'C');
    $pdf->Cell(70, 6, 'Pelanggan : ' . $penjualan->nmpelanggan, 0, 1, 'R');
    $pdf->Cell(70, 6, '', 0, 0, 'L');
    // $pdf->MultiCell(70, 6, 'Jl A.Yani No:205 Margorahayu  II Kota Gajah, Lampung Tengah', 1, 'L');
    $pdf->Cell(50, 6, 'Faktur : ' . $penjualan->nofaktur, 0, 0, 'C');
    $pdf->MultiCell(70, 6, 'Alamat : ' . $penjualan->alamat_jalan . ' ' . $penjualan->kabupaten . ' ' . $penjualan->provinsi, 0, 'R');
    $pdf->Cell(190, 6, 'Telepon : ' . $penjualan->notelp, 0, 1, 'R');
    $pdf->Cell(190, 6, 'Email : ' . $penjualan->email, 0, 1, 'R');


    $pdf->Cell(10, 7, '', 0, 1);


    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(5, 6, 'No', 1, 0, 'C');
    $pdf->Cell(15, 6, 'QTY', 1, 0, 'C');
    $pdf->Cell(15, 6, 'Sat', 1, 0, 'C');
    $pdf->Cell(20, 6, 'Tonase', 1, 0, 'C');
    $pdf->Cell(35, 6, 'Nama Barang', 1, 0, 'C');
    $pdf->Cell(30, 6, 'Harga', 1, 0, 'C');
    $pdf->Cell(35, 6, 'Diskon', 1, 0, 'C');
    $pdf->Cell(35, 6, 'Jumlah', 1, 1, 'C');
    //loping
    $pdf->SetFont('Arial', '', 8);
    $tonase = 0;
    foreach ($detail as $idx => $item) {
      $total = $item->harga_jual * $item->qty;
      $tonase += $item->tonase;
      $totalFix = $total - ($item->qty * $item->discount);
      $pdf->Cell(5, 6, $idx + 1, 1, 0, 'C');
      $pdf->Cell(15, 6, $item->qty, 1, 0, 'C');
      $pdf->Cell(15, 6, $item->nmsatuan, 1, 0, 'C');
      $pdf->Cell(20, 6, $item->tonase, 1, 0, 'C');
      $pdf->Cell(35, 6, $item->nmbarang, 1, 0, 'C');
      $pdf->Cell(30, 6, 'Rp ' . number_format($item->harga_jual, 2), 1, 0, 'C');
      $pdf->Cell(35, 6, 'Rp ' . number_format($item->qty * $item->discount, 2), 1, 0, 'C');
      $pdf->Cell(35, 6, 'Rp ' . number_format($totalFix, 2), 1, 1, 'C');
    }
    $pdf->Cell(5, 6, '', 1, 0, 'C');
    $pdf->Cell(15, 6, '', 1, 0, 'C');
    $pdf->Cell(15, 6, '', 1, 0, 'C');
    $pdf->Cell(20, 6, $tonase, 1, 0, 'C');
    $pdf->Cell(35, 6, '', 1, 0, 'C');
    $pdf->Cell(30, 6, '', 1, 0, 'C');
    $pdf->Cell(35, 6, 'Ongkir : ', 1, 0, 'C');
    $pdf->Cell(35, 6, 'Rp ' . number_format($tonase * 60, 2), 1, 1, 'C');
    $pdf->Cell(5, 6, '', 1, 0, 'C');
    $pdf->Cell(15, 6, '', 1, 0, 'C');
    $pdf->Cell(15, 6, '', 1, 0, 'C');
    $pdf->Cell(20, 6, '', 1, 0, 'C');
    $pdf->Cell(35, 6, '', 1, 0, 'C');
    $pdf->Cell(30, 6, '', 1, 0, 'C');
    $pdf->Cell(35, 6, '', 1, 0, 'C');
    $pdf->Cell(35, 6, 'Rp ' . number_format($penjualan->total, 2), 1, 1, 'C');



    $pdf->Cell(10, 10, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 6, 'TERBILANG : ' . strtoupper(terbilang($penjualan->total)), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(10, 6, 'Memo : -*', 0, 1);
    $pdf->Cell(10, 20, '', 0, 1);

    $pdf->Cell(47.5, 6, 'Sopir', 0, 0, 'C');
    $pdf->Cell(47.5, 6, 'Pengawas', 0, 0, 'C');
    $pdf->Cell(47.5, 6, 'Customer', 0, 0, 'C');
    $pdf->Cell(47.5, 6, 'Dibuat Oleh', 0, 1, 'C');
    $pdf->Cell(10, 10, '', 0, 1);
    $pdf->Cell(47.5, 6, '', 0, 0, 'C');
    $pdf->Cell(47.5, 6, '', 0, 0, 'C');
    $pdf->Cell(47.5, 6, '', 0, 0, 'C');
    $pdf->Cell(47.5, 6, $this->session->userdata('name'), 0, 1, 'C');
    $pdf->Cell(47.5, 6, '...................................', 0, 0, 'C');
    $pdf->Cell(47.5, 6, '...................................', 0, 0, 'C');
    $pdf->Cell(47.5, 6, '...................................', 0, 0, 'C');
    $pdf->Cell(47.5, 6, '...................................', 0, 1, 'C');

    $pdf->SetXY(10, 29);
    $pdf->MultiCell(70, 6, 'Jl A.Yani No:205 Margorahayu  II Kota Gajah, Lampung Tengah', 0, 'L');





    $pdf->Output('I', 'FAKTUR-' . $penjualan->nofaktur . '.pdf');
  }
  function do($id)
  {
    $tglPrint = date('Y-m-d H:i:s');
    $penjualan = $this->db->order_by('tbl_transaksi_penjualan.rec_insert', 'desc')->join('tbl_pelanggan', 'tbl_pelanggan.idpelanggan = tbl_transaksi_penjualan.idpelanggan')->get_where('tbl_transaksi_penjualan', ['tbl_transaksi_penjualan.publish' => 'T', 'tbl_transaksi_penjualan.idt_penjualan' => $id])->row();
    $p_detail = $this->db
      ->select('*,tbl_transaksi_penjualan_detail.harga_jual as harga_jual')
      ->join('tbl_barang', 'tbl_barang.idbarang = tbl_transaksi_penjualan_detail.idbarang')
      ->join('tbl_barang_satuan', 'tbl_barang.idsatuan = tbl_barang_satuan.idsatuan')
      ->join('tbl_barang_kategori', 'tbl_barang.idkategori = tbl_barang_kategori.idkategori')
      ->get_where('tbl_transaksi_penjualan_detail', ['idt_penjualan' => $penjualan->idt_penjualan])
      ->result();
    $penjualan = $penjualan;
    $detail = $p_detail;
    // $pdf = new PDF_AutoPrint();
    // $pdf->AddPage();
    // $pdf->SetFont('Arial', '', 20);
    // $pdf->Text(90, 50, 'Print me!');
    // $pdf->AutoPrint();
    // $pdf->Output();
    error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
    $pdf->Image(base_url('assets/images/logo-1.png'), 10, 6, -460);
    $pdf->Cell(70, 6,);
    $pdf->Cell(50, 6, 'PT CENTRAL ARTHA ULAM', 0, 0, 'C');
    $pdf->Cell(70, 6, $tglPrint, 0, 1, 'R');
    $pdf->Cell(10, 7, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 6, 'DO GUDANG PAKAN', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(70, 6,);
    $pdf->Cell(50, 6, 'Tanggal : ' . $penjualan->tgl_transaksi, 0, 0, 'C');
    $pdf->Cell(70, 6, 'Pelanggan : ' . $penjualan->nmpelanggan, 0, 1, 'R');
    $pdf->Cell(70, 6, '', 0, 0, 'L');
    // $pdf->MultiCell(70, 6, 'Jl A.Yani No:205 Margorahayu  II Kota Gajah, Lampung Tengah', 1, 'L');
    $pdf->Cell(50, 6, '', 0, 0, 'C');
    $pdf->MultiCell(70, 6, 'Alamat : ' . $penjualan->alamat_jalan . ' ' . $penjualan->kabupaten . ' ' . $penjualan->provinsi, 0, 'R');
    $pdf->Cell(190, 6, 'Telepon : ' . $penjualan->notelp, 0, 1, 'R');
    $pdf->Cell(190, 6, 'Email : ' . $penjualan->email, 0, 1, 'R');
    $pdf->Cell(10, 7, '', 0, 1);


    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 6, 'No', 1, 0, 'C');
    $pdf->Cell(45, 6, 'Nama Barang', 1, 0, 'C');
    $pdf->Cell(30, 6, 'Jumlah', 1, 0, 'C');
    $pdf->Cell(30, 6, 'Krani', 1, 0, 'C');
    $pdf->Cell(30, 6, 'Pelanggan', 1, 1, 'C');
    //loping
    $pdf->SetFont('Arial', '', 10);
    $tonase = 0;
    foreach ($detail as $idx => $item) {
      $total = $item->harga_jual * $item->qty;
      $tonase += $item->tonase;
      $totalFix = $total - ($item->qty * $item->discount);
      $pdf->Cell(10, 6, $idx + 1, 1, 0, 'C');
      $pdf->Cell(45, 6, $item->nmbarang, 1, 0, 'C');
      $pdf->Cell(30, 6, $item->qty . ' ' . $item->nmsatuan, 1, 0, 'C');
      $pdf->Cell(30, 6, '', 1, 0, 'C');
      $pdf->Cell(30, 6, '', 1, 1, 'C');
    }

    $pdf->SetXY(165, 66);
    $pdf->Cell(30, 30, '', 1, 1, 'T');
    $pdf->SetXY(165, 66);
    $pdf->Cell(30, 6, 'Ttd Krani', 0, 1, 'C');
    $pdf->SetXY(165, 100);
    $pdf->Cell(30, 30, '', 1, 1, 'T');
    $pdf->SetXY(165, 100);
    $pdf->Cell(30, 6, 'Ttd Sopir', 0, 1, 'C');
    $pdf->SetXY(165, 134);
    $pdf->Cell(30, 14, '', 1, 1, 'C');
    $pdf->SetXY(165, 134);
    $pdf->Cell(30, 6, 'Tonase', 0, 1, 'C');
    $pdf->SetXY(165, 140);
    $pdf->Cell(30, 6, $tonase, 0, 1, 'C');

    $pdf->Output('I', 'DO-' . $penjualan->nofaktur . '.pdf');
  }
}
