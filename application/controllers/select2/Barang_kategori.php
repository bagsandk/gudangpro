<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_kategori extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->where('publish = "T"')->like('nmkategori', $search)->get('tbl_barang_kategori')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idkategori;
      $row['text'] = $g->nmkategori;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
