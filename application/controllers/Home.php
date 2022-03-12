<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

  public $validation_for = '';

  public function __construct()
  {
    parent::__construct();
    $this->load->model('contact_model', 'contact');
    $this->load->helper('form');
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['content'] = 'home/index';
    $this->load->view('templates/main', $data);
  }
}
