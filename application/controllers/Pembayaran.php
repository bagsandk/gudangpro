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
        $data['status'] = TRUE;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
      }
    } else {
      $data = array(
        'status'     => FALSE,
        'errors'     => [],
        'message' => 'Data penjualan tidak ada'

      );
    }
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
