<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staf extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->like('nmstaf', $search)->get('tbl_staf')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idstaf;
      $row['text'] = $g->nmstaf;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
