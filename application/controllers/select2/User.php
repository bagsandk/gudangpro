<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db->where('publish = "T"')->like('name', $search)->get('tbl_user')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->iduser;
      $row['text'] = $g->name;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
