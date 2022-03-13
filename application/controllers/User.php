<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', 'user');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'user/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->user->get_datatables();
		$data = array();
		foreach ($list as $user) {
			$row = array();
			$row[] = $user->name;
			$row[] = $user->photo;
			$row[] = $user->email;
			$row[] = $user->level;

			//add html for action
			$row[] = "<a class='btn btn-md btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$user->iduser}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-md btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$user->iduser}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->user->count_all(),
			"recordsFiltered" => $this->user->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->user->get_by_id($id);
		echo json_encode($data);
	}

	public function add()
	{
		$this->validation_for = 'add';
		$data = array();
		$data['status'] = TRUE;

		$this->_validate();

		if ($this->form_validation->run() == FALSE) {
			$errors = array(
				'name' 	=> form_error('name'),
				'email' 			=> form_error('email'),
				'password' 		=> form_error('password'),
				'level' 		=> form_error('level'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'level' => $this->input->post('level'),
			);
			$insert = $this->user->save($insert);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function update()
	{
		$this->validation_for = 'update';
		$data = array();
		$data['status'] = TRUE;

		$this->_validate();

		if ($this->form_validation->run() == FALSE) {
			$errors = array(
				'name' 	=> form_error('name'),
				'email' 			=> form_error('email'),
				'password' 		=> form_error('password'),
				'level' 		=> form_error('level'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$getData = $this->user->get_by_id($this->input->post('iduser'));
			if ($this->input->post('password') !== '') {
				$password = $getData->password;
			} else {
				$password = $this->input->post('password');
			}
			$update = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'password' => $password,
				'level' => $this->input->post('level'),
			);
			$this->user->update(array('iduser' => $this->input->post('iduser')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->user->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('level', 'Level', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim');

		$email_unique = '';
		$passwordAdd = '';
		$getData = $this->user->get_by_id($this->input->post('iduser'));

		if ($this->validation_for == 'add') {
			$passwordAdd = '|required|min_length[3]';
			$email_unique = '|is_unique[tbl_user.email]';
		} else if ($this->validation_for == 'update') {
			if ($this->input->post('email') != $getData->email) {
				$email_unique = '|is_unique[tbl_user.email]';
			}
		}
		$this->form_validation->set_rules('password', 'Password', 'trim' . $passwordAdd);
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email' . $email_unique);
	}
}
