<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->where('publish = "T"')->like('nmjabatan', $search)->get('tbl_jabatan')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idjabatan;
      $row['text'] = $g->nmjabatan;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
