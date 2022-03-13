<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->where('publish = "T"')->like('nmpelanggan', $search)->get('tbl_pelanggan')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idpelanggan;
      $row['text'] = $g->nmpelanggan;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
