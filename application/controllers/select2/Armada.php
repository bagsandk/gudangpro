<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Armada extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $search = $this->input->get('search');
    $get = $this->db
      ->join('tbl_armada_jenis ja', 'a.idjenis_armada=ja.idjenis_armada')
      ->join('tbl_staf s', 's.idstaf=a.idstaf')
      ->where('a.publish = "T"')
      ->like('a.kdarmada', $search)
      ->or_like('a.nomor_plat', $search)
      ->or_like('a.daya_angkut', $search)
      ->or_like('a.nostnk', $search)
      ->or_like('a.tglpajak', $search)
      ->or_like('a.kondisi_armada', $search)
      ->or_like('ja.nmjenis_armada', $search)
      ->or_like('s.nmstaf', $search)
      ->get('tbl_armada a')->result();
    $data = [];
    foreach ($get as $g) {
      $row = [];
      $row['id'] = $g->idarmada;
      $row['text'] = $g->kdarmada . '|' . $g->nomor_plat . '|' . $g->daya_angkut . '|' . $g->nostnk . '|' . $g->nmjenis_armada . '|' . $g->nmstaf . '|' . $g->kondisi_armada;
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
