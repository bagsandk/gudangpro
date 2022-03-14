<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Login_model', 'login');
    $this->load->library('form_validation');
  }
  public function index()
  {
    $this->load->view('auth/login');
  }

  public function act_login()
  {
    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'password', 'trim|required');
    if ($this->form_validation->run()) {
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $check = $this->login->check($email, $password);
      if ($check == NULL) {
        $this->session->set_flashdata('message', "<script>
                    Swal.fire({
                            icon: 'error',
                            title: 'Gagal...',
                            text: 'Email atau password salah..',
                        })
					</script>");
        redirect('login/index');
      }
      $data_session = array(
        'email' => $email,
        'name' => $check['name'],
        'photo' => $check['photo'],
        'level' => $check['level'],
        'login' => true,
      );
      $this->session->set_userdata($data_session);
      redirect("home");
    } else {
      $this->session->set_flashdata('message', "<script>
                    Swal.fire({
                            icon: 'error',
                            title: 'Gagal...',
                            text: 'Email atau password salah..',
                        })
					</script>");
      redirect('login/index');
    }
  }
  public function logout()
  {
    $this->session->sess_destroy();
    redirect('login');
  }
}
