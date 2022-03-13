<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->where('publish = "T"')->like('nmbarang', $search)->get('tbl_barang')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idbarang;
      $row['text'] = $g->nmbarang;
      $row['slug'] = $g->merek;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
