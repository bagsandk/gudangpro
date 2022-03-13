<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->where('publish = "T"')->like('nmsupplier', $search)->get('tbl_supplier')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idsupplier;
      $row['text'] = $g->nmsupplier;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
