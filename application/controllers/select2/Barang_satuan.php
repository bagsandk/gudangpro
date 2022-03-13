<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_satuan extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->where('publish = "T"')->like('nmsatuan', $search)->get('tbl_barang_satuan')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idsatuan;
      $row['text'] = $g->nmsatuan;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
