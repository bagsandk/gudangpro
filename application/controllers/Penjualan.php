<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
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
    $data['content'] = 'penjualan/index';
    $this->load->view('templates/main', $data);
  }
  public function add()
  {
    $data['content'] = 'penjualan/add';
    $this->load->view('templates/main', $data);
  }
  public function detail($id)
  {
    $penjualan = $this->db->order_by('tbl_transaksi_penjualan.rec_insert', 'desc')->join('tbl_pelanggan', 'tbl_pelanggan.idpelanggan = tbl_transaksi_penjualan.idpelanggan')->get_where('tbl_transaksi_penjualan', ['tbl_transaksi_penjualan.publish' => 'T', 'tbl_transaksi_penjualan.idt_penjualan' => $id])->row();
    $data['metodebayar'] = $this->db->order_by('idmetode_bayar', 'desc')->get_where('tbl_metode_bayar', ['publish' => 'T', 'idmetode_bayar !=' => 0])->result();
    $data['statusbayar'] = $this->db->order_by('idstatus_bayar', 'desc')->get_where('tbl_status_bayar', ['publish' => 'T', 'idstatus_bayar !=' => 0])->result();
    $p_detail = $this->db
      ->select('*,tbl_transaksi_penjualan_detail.harga_jual as harga_jual')
      ->join('tbl_barang', 'tbl_barang.idbarang = tbl_transaksi_penjualan_detail.idbarang')
      ->join('tbl_barang_kategori', 'tbl_barang.idkategori = tbl_barang_kategori.idkategori')
      ->get_where('tbl_transaksi_penjualan_detail', ['idt_penjualan' => $penjualan->idt_penjualan])
      ->result();
    $data['penjualan'] = $penjualan;
    $data['detail'] = $p_detail;
    $data['content'] = 'penjualan/detail';
    $this->load->view('templates/main', $data);
  }
  public function get_penjualan($jenis = 'semua')
  {
    $html = '<div id="accordion">';
    $query = $this->db
      ->order_by('tbl_transaksi_penjualan.rec_insert', 'desc')
      ->join('tbl_pelanggan', 'tbl_pelanggan.idpelanggan = tbl_transaksi_penjualan.idpelanggan');
    if ($jenis !== 'semua') {
      $query->where('jenis_do', strtoupper($jenis));
    }
    $penjualan = $query->get_where('tbl_transaksi_penjualan', ['tbl_transaksi_penjualan.publish' => 'T', 'status' => 'BELUM BAYAR'])->result();

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
      foreach ($p_detail as $detail) {
        $html .= '<div class="my-1 card">
        <div class="p-2 card-body">
          <div class="row">
            <div class="col-md-9 col-sm-9 col-8">
              <h6 class="mb-0 card-title">' . $detail->nmbarang . ' | ' . $detail->merek . '</h6>
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
        <h6 class="text-right my-2 mr-2"><small>Total : </small>Rp ' . number_format($penj->total, 2) . '</h6><a href="' . base_url('penjualan/detail/' . $penj->idt_penjualan) . '" class="float-right m-0 mr-1 btn text-info btn-sm">Detail</a>
      </div>
    </div>
  </div>
</div>
</div>';
    }
    $html .= '</div>';
    echo $html;
  }
  public function tambahPenjualan()
  {
    $data = array();
    $data['status'] = TRUE;

    if ($this->input->post('idbarang')) {
      $this->_validate();
      if ($this->form_validation->run() == FALSE) {
        $qtyError = [];
        $discountError = [];
        foreach ($this->input->post('idbarang') as $i => $q) {
          $qtyError['qty[' . $i . ']'] = form_error('qty[' . $i . ']');
          $discountError['discount[' . $i . ']'] = form_error('discount[' . $i . ']');
        }
        $errors = array(
          'nofaktur'   => form_error('nofaktur'),
          'tgl_transaksi'   => form_error('tgl_transaksi'),
          'jenis_do'   => form_error('jenis_do'),
          'idpelanggan'   => form_error('idpelanggan'),
          'qty'   => $qtyError,
          'discount'   => $discountError,
        );
        $data = array(
          'status'     => FALSE,
          'errors'     => $errors,
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
      } else {
        $dpTotal = 0;
        $totalTonase = 0;
        $dpItems = [];
        foreach ($this->input->post('idbarang') as $id => $val) {
          $bar  = $this->barang->get_by_id($id);
          $qty = $this->input->post('qty')[$id];
          $discount = $this->input->post('discount')[$id] ? $this->input->post('discount')[$id] : 0;
          $total = $bar->harga_jual * $qty;
          $totalTonase += $bar->tonase;
          $totalFix = $total - ($qty * $discount);
          $dpTotal += $totalFix;
          $dpItems[] = [
            'harga_jual' => $bar->harga_jual,
            'idbarang' => $bar->idbarang,
            'tonase' => $bar->tonase,
            'qty' => $qty,
            'discount' => $discount,
            'iduser' => $this->session->userdata('iduser')
          ];
        }
        $dp = [
          'nofaktur'   => $this->input->post('nofaktur'),
          'tgl_transaksi'   => $this->input->post('tgl_transaksi'),
          'jenis_do'   => $this->input->post('jenis_do'),
          'idpelanggan'   => $this->input->post('idpelanggan'),
          'keterangan'   => $this->input->post('keterangan'),
          'iduser'   => $this->session->userdata('iduser'),
          'status' => 'BELUM BAYAR',
          'total' => $dpTotal + ($totalTonase * 60),
        ];
        $idt_penjualan = $this->penjualan->addPenjualan($dp);
        for ($index = 0; count($dpItems) > $index; $index++) {
          $dpItems[$index]['idt_penjualan'] = $idt_penjualan;
        }
        $this->db->insert_batch('tbl_transaksi_penjualan_detail', $dpItems);
        $data['status'] = TRUE;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
      }
    } else {
      $data = array(
        'status'     => FALSE,
        'errors'     => [],
        'message' => 'Pilih minimal 1 barang'

      );
    }
  }
  private function _validate()
  {
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('nofaktur', 'no faktur', 'trim|required|is_unique[tbl_transaksi_penjualan.nofaktur]');
    $this->form_validation->set_rules('tgl_transaksi', 'tgl transaksi', 'trim|required');
    $this->form_validation->set_rules('jenis_do', 'jenis do', 'trim|required');
    $this->form_validation->set_rules('idpelanggan', 'pelanggan', 'trim|required');
    $this->form_validation->set_rules('idbarang[]', 'barang', 'trim|required');
    foreach ($this->input->post('idbarang') as $i => $q) {
      $this->form_validation->set_rules('qty[' . $i . ']', 'qty', 'trim|required|greater_than[0]');
      $this->form_validation->set_rules('discount[' . $i . ']', 'discount', 'trim');
    }
  }
}
