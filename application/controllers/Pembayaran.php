<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('barang_model', 'barang');
    $this->load->model('penjualan_model', 'penjualan');
  }
  public function index()
  {
    $data['content'] = 'pembayaran/index';
    $this->load->view('templates/main', $data);
  }
  public function tambahPembayaran($idt_penjualan)
  {

    $data = array();
    $data['status'] = TRUE;
    $checkpt = $this->db->get_where('tbl_transaksi_penjualan', ['publish' => 'T', 'idt_penjualan' => $idt_penjualan])->row();
    if ($checkpt) {
      $this->_validate();
      if ($this->form_validation->run() == FALSE) {
        $errors = array(
          'kdtp_penjualan'   => form_error('kdtp_penjualan'),
          'tgl_pembayaran'   => form_error('tgl_pembayaran'),
          'idmetode_bayar'   => form_error('idmetode_bayar'),
          'idrekeningbank'   => form_error('idrekeningbank'),
          'keterangan'   => form_error('keterangan'),
          'total'   => form_error('total'),
          'idstatus_bayar'   => form_error('idstatus_bayar'),
          'idt_penjualan'   => form_error('idt_penjualan'),
        );
        $data = array(
          'status'     => FALSE,
          'errors'     => $errors,
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
      } else {
        $data = [
          'kdtp_penjualan'   => $this->input->post('kdtp_penjualan'),
          'tgl_pembayaran'   => $this->input->post('tgl_pembayaran'),
          'idmetode_bayar'   => $this->input->post('idmetode_bayar'),
          'idrekeningbank'   => $this->input->post('idrekeningbank'),
          'keterangan'   => $this->input->post('keterangan'),
          'total'   => $this->input->post('total'),
          'idstatus_bayar'   => $this->input->post('idstatus_bayar'),
          'iduser'   => $this->session->userdata('iduser'),
          'idt_penjualan'   => $idt_penjualan
        ];
        $idtp_penjualan = $this->penjualan->addPembayaran($data);
        $this->db->where('idt_penjualan', $idt_penjualan)->update('tbl_transaksi_penjualan', ['status' => 'PROSES']);
        $rdata['status'] = TRUE;
        $this->output->set_content_type('application/json')->set_output(json_encode($rdata));
      }
    } else {
      $data = array(
        'status'     => FALSE,
        'errors'     => [],
        'message' => 'Data penjualan tidak ada'

      );
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
  }

  public function detail($id)
  {
    $penjualan = $this->db->order_by('tbl_transaksi_penjualan.rec_insert', 'desc')->join('tbl_pelanggan', 'tbl_pelanggan.idpelanggan = tbl_transaksi_penjualan.idpelanggan')->get_where('tbl_transaksi_penjualan', ['tbl_transaksi_penjualan.publish' => 'T', 'tbl_transaksi_penjualan.idt_penjualan' => $id])->row();
    $data['metodebayar'] = $this->db->order_by('idmetode_bayar', 'desc')->get_where('tbl_metode_bayar', ['publish' => 'T', 'idmetode_bayar !=' => 0])->result();
    $data['statusbayar'] = $this->db->order_by('idstatus_bayar', 'desc')->get_where('tbl_status_bayar', ['publish' => 'T', 'idstatus_bayar !=' => 0])->result();
    $p_detail = $this->db
      ->select('*,tbl_transaksi_penjualan_detail.harga_jual as harga_jual')
      ->join('tbl_barang', 'tbl_barang.idbarang = tbl_transaksi_penjualan_detail.idbarang')
      ->join('tbl_barang_satuan', 'tbl_barang.idsatuan = tbl_barang_satuan.idsatuan')
      ->join('tbl_barang_kategori', 'tbl_barang.idkategori = tbl_barang_kategori.idkategori')
      ->get_where('tbl_transaksi_penjualan_detail', ['idt_penjualan' => $penjualan->idt_penjualan])
      ->result();
    $p_bayar = $this->db
      ->select('*')
      ->join('tbl_transaksi_penjualan', 'tbl_transaksi_penjualan.idt_penjualan = tbl_transaksi_penjualan_pembayaran.idt_penjualan')
      ->join('tbl_metode_bayar', 'tbl_transaksi_penjualan_pembayaran.idmetode_bayar = tbl_metode_bayar.idmetode_bayar')
      ->join('tbl_status_bayar', 'tbl_transaksi_penjualan_pembayaran.idstatus_bayar = tbl_status_bayar.idstatus_bayar')
      ->join('tbl_rekening_bank', 'tbl_transaksi_penjualan_pembayaran.idrekeningbank = tbl_rekening_bank.idrekeningbank')
      ->get_where('tbl_transaksi_penjualan_pembayaran', ['tbl_transaksi_penjualan_pembayaran.idt_penjualan' => $penjualan->idt_penjualan, 'tbl_transaksi_penjualan_pembayaran.publish' => 'T',])
      ->result();

    $data['pembayaran'] = $p_bayar;
    $data['penjualan'] = $penjualan;
    $data['detail'] = $p_detail;
    $data['content'] = 'pembayaran/detail';
    $this->load->view('templates/main', $data);
  }
  private function _validate()
  {
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('kdtp_penjualan', 'kode penjualan', 'trim|required|is_unique[tbl_transaksi_penjualan_pembayaran.kdtp_penjualan]');
    $this->form_validation->set_rules('tgl_pembayaran', 'tgl pembayaran', 'trim|required');
    $this->form_validation->set_rules('idmetode_bayar', 'metode pembayran', 'trim|required');
    $this->form_validation->set_rules('idrekeningbank', 'rekening bank', 'trim');
    $this->form_validation->set_rules('keterangan', 'keterangan', 'trim');
    $this->form_validation->set_rules('total', 'total', 'trim|required');
    $this->form_validation->set_rules('idstatus_bayar', 'status bayar', 'trim|required');
  }
}
