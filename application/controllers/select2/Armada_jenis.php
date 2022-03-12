<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Armada_jenis extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->where('publish = "T"')->like('nmjenis_armada', $search)->get('tbl_armada_jenis')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idjenis_armada;
      $row['text'] = $g->nmjenis_armada;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
