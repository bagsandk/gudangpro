<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendidikan extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('pendidikan_model', 'pendidikan');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'pendidikan/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->pendidikan->get_datatables();
		$data = array();
		foreach ($list as $pendidikan) {
			$row = array();
			$row[] = $pendidikan->nmpendidikan;
			$row[] = $pendidikan->alias;

			//add html for action
			$row[] = "<a class='btn btn-sm btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$pendidikan->idpendidikan}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-sm btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$pendidikan->idpendidikan}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->pendidikan->count_all(),
			"recordsFiltered" => $this->pendidikan->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->pendidikan->get_by_id($id);
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
				'nmpendidikan' 	=> form_error('nmpendidikan'),
				'alias' 	=> form_error('alias'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'nmpendidikan' => $this->input->post('nmpendidikan'),
				'alias' => $this->input->post('alias'),
			);
			$insert = $this->pendidikan->save($insert);
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
				'nmpendidikan' 	=> form_error('nmpendidikan'),
				'alias' 	=> form_error('alias'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'nmpendidikan' => $this->input->post('nmpendidikan'),
				'alias' => $this->input->post('alias'),
			);
			$this->pendidikan->update(array('idpendidikan' => $this->input->post('idpendidikan')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->pendidikan->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nmpendidikan', 'pendidikan', 'trim|required');
		$this->form_validation->set_rules('alias', 'alias', 'trim|required');
	}
}
