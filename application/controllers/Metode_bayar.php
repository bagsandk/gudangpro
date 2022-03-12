<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Metode_bayar extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('metode_bayar_model', 'metode_bayar');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'metode_bayar/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->metode_bayar->get_datatables();
		$data = array();
		foreach ($list as $metode_bayar) {
			$row = array();
			$row[] = $metode_bayar->metode_bayar;

			//add html for action
			$row[] = "<a class='btn btn-sm btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$metode_bayar->idmetode_bayar}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-sm btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$metode_bayar->idmetode_bayar}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->metode_bayar->count_all(),
			"recordsFiltered" => $this->metode_bayar->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->metode_bayar->get_by_id($id);
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
				'metode_bayar' 	=> form_error('metode_bayar'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'metode_bayar' => $this->input->post('metode_bayar'),
			);
			$insert = $this->metode_bayar->save($insert);
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
				'metode_bayar' 	=> form_error('metode_bayar'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'metode_bayar' => $this->input->post('metode_bayar'),
			);
			$this->metode_bayar->update(array('idmetode_bayar' => $this->input->post('idmetode_bayar')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->metode_bayar->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('metode_bayar', 'metode bayar', 'trim|required');
	}
}
