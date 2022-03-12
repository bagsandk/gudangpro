<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Armada_jenis extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('armada_jenis_model', 'armada_jenis');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'armada_jenis/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->armada_jenis->get_datatables();
		$data = array();
		foreach ($list as $armada_jenis) {
			$row = array();
			$row[] = $armada_jenis->nmjenis_armada;

			//add html for action
			$row[] = "<a class='btn btn-sm btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$armada_jenis->idjenis_armada}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-sm btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$armada_jenis->idjenis_armada}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->armada_jenis->count_all(),
			"recordsFiltered" => $this->armada_jenis->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->armada_jenis->get_by_id($id);
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
				'nmjenis_armada' 	=> form_error('nmjenis_armada'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'nmjenis_armada' => $this->input->post('nmjenis_armada'),
			);
			$insert = $this->armada_jenis->save($insert);
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
				'nmjenis_armada' 	=> form_error('nmjenis_armada'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'nmjenis_armada' => $this->input->post('nmjenis_armada'),
			);
			$this->armada_jenis->update(array('idjenis_armada' => $this->input->post('idjenis_armada')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->armada_jenis->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nmjenis_armada', 'nama jenis armada', 'trim|required');
	}
}
