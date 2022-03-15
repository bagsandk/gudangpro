<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unit extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->where('publish = "T"')->like('nmunit', $search)->get('tbl_unit')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idunit;
      $row['text'] = $g->nmunit;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
