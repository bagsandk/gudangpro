<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Delivery_order extends CI_Controller
{

    public $validation_for = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('delivery_order_model', 'do');
    }
    public function index()
    {
        $data['content'] = 'delivery_order/index';
        $this->load->view('templates/main', $data);
    }

    public function detail($id = NULL)
    {
        if ($id == NULL) {
            redirect('delivery_order');
        }
        $do = $this->db
            ->join('tbl_armada a', 'a.idarmada=do.idarmada')
            ->join('tbl_armada_jenis ja', 'a.idjenis_armada=ja.idjenis_armada')
            ->join('tbl_staf s', 's.idstaf=a.idstaf')
            ->get_where('tbl_transaksi_penjualan_do do', ['do.publish' => 'T', 'idtpdo_penjualan' => $id])
            ->row_array();
        $data['do'] = $do;
        $penjualan = $this->db->order_by('tbl_transaksi_penjualan.rec_insert', 'desc')->join('tbl_pelanggan', 'tbl_pelanggan.idpelanggan = tbl_transaksi_penjualan.idpelanggan')->get_where('tbl_transaksi_penjualan', ['tbl_transaksi_penjualan.publish' => 'T', 'tbl_transaksi_penjualan.idt_penjualan' => $do['idt_penjualan']])->row_array();
        $data['metodebayar'] = $this->db->order_by('idmetode_bayar', 'desc')->get_where('tbl_metode_bayar', ['publish' => 'T', 'idmetode_bayar !=' => 0])->row_array();
        $data['statusbayar'] = $this->db->order_by('idstatus_bayar', 'desc')->get_where('tbl_status_bayar', ['publish' => 'T', 'idstatus_bayar !=' => 0])->row_array();
        $p_detail = $this->db
            ->select('*,tbl_transaksi_penjualan_detail.harga_jual as harga_jual')
            ->join('tbl_barang', 'tbl_barang.idbarang = tbl_transaksi_penjualan_detail.idbarang')
            ->join('tbl_barang_kategori', 'tbl_barang.idkategori = tbl_barang_kategori.idkategori')
            ->get_where('tbl_transaksi_penjualan_detail', ['idt_penjualan' => $do['idt_penjualan']])
            ->result();
        $data['penjualan'] = $penjualan;
        $data['detail'] = $p_detail;
        $data['content'] = 'delivery_order/detail';
        $this->load->view('templates/main', $data);
    }
    public function kirim($idt_penjualan)
    {
        $data = array();
        $data['status'] = TRUE;
        $checkpt = $this->db->get_where('tbl_transaksi_penjualan', ['publish' => 'T', 'idt_penjualan' => $idt_penjualan])->row();
        if ($checkpt) {
            $this->_validate();
            if ($this->form_validation->run() == FALSE) {
                $errors = array(
                    'kdtpdo_penjualan' => form_error('kdtpdo_penjualan'),
                    'nmpenerima' => form_error('nmpenerima'),
                    'notelp' => form_error('notelp'),
                    'email' => form_error('email'),
                    'alamat_jalan' => form_error('alamat_jalan'),
                    'kabupaten' => form_error('kabupaten'),
                    'provinsi' => form_error('provinsi'),
                    'negara' => form_error('negara'),
                    'idarmada' => form_error('idarmada'),
                    'keterangan' => form_error('keterangan'),
                );
                $data = array(
                    'status'     => FALSE,
                    'errors'     => $errors,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            } else {
                $this->db->trans_begin();
                $updateStatus = [
                    'status' => 'DIKIRIM'
                ];
                $this->do->update('tbl_transaksi_penjualan', $updateStatus, ['idt_penjualan' => $this->input->post('idt_penjualan')]);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $data = array(
                        'status'     => FALSE,
                        'errors'     => [],
                        'message' => 'Gagal merubah status'
                    );
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                }
                $data = [
                    'kdtpdo_penjualan' => $this->input->post('kdtpdo_penjualan'),
                    'nmpenerima' => $this->input->post('nmpenerima'),
                    'notelp' => $this->input->post('notelp'),
                    'email' => $this->input->post('email'),
                    'alamat_jalan' => $this->input->post('alamat_jalan'),
                    'kabupaten' => $this->input->post('kabupaten'),
                    'provinsi' => $this->input->post('provinsi'),
                    'negara' => $this->input->post('negara'),
                    'idarmada' => $this->input->post('idarmada'),
                    'keterangan' => $this->input->post('keterangan'),
                    'iduser'   => $this->session->userdata('iduser'),
                    'idt_penjualan'   => $idt_penjualan
                ];
                $idtpdo_penjualan = $this->do->add('tbl_transaksi_penjualan_do', $data);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $data = array(
                        'status'     => FALSE,
                        'errors'     => [],
                        'message' => 'Gagal membuat pengiriman'
                    );
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                }
                $this->db->trans_commit();
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

    public function toLoading($idtpdo_penjualan = NULL)
    {
        if ($idtpdo_penjualan == NULL) {
            $data = array(
                'status'     => FALSE,
                'errors'     => "delivery order tidak ditemukan",
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        if ($this->minStock($idtpdo_penjualan)) {
            $data = array(
                'status'     => TRUE,
                'message'     => "mengemas barang",
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $data = array(
                'status'     => FALSE,
                'errors'     => "stok barang kurang atau status delivery order tidak berada di letter",
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function toDelivery($idtpdo_penjualan = NULL)
    {
        if ($idtpdo_penjualan == NULL) {
            $data = array(
                'status'     => FALSE,
                'errors'     => "delivery order tidak ditemukan",
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        $params = [
            'tgl_kirim' => date('Y-m-d H:i:s'),
            'status_do' => 'DELIVERY'
        ];
        $update = $this->do->update('tbl_transaksi_penjualan_do', $params, ['idtpdo_penjualan' => $idtpdo_penjualan]);
        if ($update) {
            $data = array(
                'status'     => TRUE,
                'message'     => "mengirim barang",
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $data = array(
                'status'     => FALSE,
                'errors'     => "gagal merubah status",
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function toArrive($idtpdo_penjualan = NULL)
    {
        if ($idtpdo_penjualan == NULL) {
            $data = array(
                'status'     => FALSE,
                'errors'     => "delivery order tidak ditemukan",
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        $params = [
            'tgl_tiba' => date('Y-m-d H:i:s'),
            'status_do' => 'ARRIVE'
        ];
        $update = $this->do->update('tbl_transaksi_penjualan_do', $params, ['idtpdo_penjualan' => $idtpdo_penjualan]);
        if ($update) {
            $data = array(
                'status'     => TRUE,
                'message'     => "barang sampai",
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $data = array(
                'status'     => FALSE,
                'errors'     => "gagal merubah status",
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
    private function _validate()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('kdtpdo_penjualan', 'kode pengiriman', 'trim|required|is_unique[tbl_transaksi_penjualan_do.kdtpdo_penjualan]');
        $this->form_validation->set_rules('idt_penjualan', 'penjualan', 'trim|required');
        $this->form_validation->set_rules('nmpenerima', 'nama penerima', 'trim|required');
        $this->form_validation->set_rules('notelp', 'no telpon', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_rules('alamat_jalan', 'alamat jalan', 'trim|required');
        $this->form_validation->set_rules('kabupaten', 'kabupaten', 'trim|required');
        $this->form_validation->set_rules('provinsi', 'provinsi', 'trim|required');
        $this->form_validation->set_rules('negara', 'negara', 'trim|required');
        $this->form_validation->set_rules('idarmada', 'armada', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim');
    }

    private function minStock($idtpdo_penjualan)
    {
        $this->db->trans_begin();
        $data = $this->db->get_where('tbl_transaksi_penjualan_do', ['idtpdo_penjualan' => $idtpdo_penjualan])->row_array();
        if ($data == NULL) {
            $this->db->trans_rollback();
            return false;
        } else {
            if ($data['status_do'] != 'LETTER') {
                $this->db->trans_rollback();
                return false;
            }
        }
        $dataDetail = $this->db->get_where('tbl_transaksi_penjualan_detail', ['idt_penjualan' => $data['idt_penjualan'], 'publish' => 'T'])->result_array();
        if ($dataDetail == NULL) {
            $this->db->trans_rollback();
            return false;
        }
        foreach ($dataDetail as $k => $v) {
            $dataBarang = $this->db->get_where('tbl_barang', ['idbarang' => $v['idbarang'], 'publish' => 'T'])->row_array();
            if ($dataBarang == NULL) {
                $this->db->trans_rollback();
                return false;
            }
            $newStock = $dataBarang['stok'] - $v['qty'];
            if ($newStock < 0) {
                $this->db->trans_rollback();
                return false;
            }
            $this->do->update('tbl_barang', ['stok' => $newStock], ['idbarang' => $v['idbarang']]);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            }
        }
        $this->do->update('tbl_transaksi_penjualan_do', ['status_do' => 'LOADING'], ['idtpdo_penjualan' => $idtpdo_penjualan]);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }
}
