<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

  public function index()
  {
    // $data['content'] = 'armada_jenis/index';
    $this->load->view('auth/login');
  }
}
