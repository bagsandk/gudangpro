<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening_bank extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->where('publish = "T"')->where('publish = "T"')->like('nmpendidikan', $search)->get('tbl_rekening_bank')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idpendidikan;
      $row['text'] = $g->nmpendidikan . ' - ' . $g->alias;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
