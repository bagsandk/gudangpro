<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening_bank extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('rekening_bank_model', 'rekening_bank');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'rekening_bank/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->rekening_bank->get_datatables();
		$data = array();
		foreach ($list as $rekening_bank) {
			$row = array();
			$row[] = $rekening_bank->norekening;
			$row[] = $rekening_bank->nmbank;
			$row[] = $rekening_bank->cabang;
			$row[] = $rekening_bank->nmnasabah;

			//add html for action
			$row[] = "<a class='btn btn-sm btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$rekening_bank->idrekeningbank}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-sm btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$rekening_bank->idrekeningbank}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->rekening_bank->count_all(),
			"recordsFiltered" => $this->rekening_bank->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->rekening_bank->get_by_id($id);
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
				'norekening' 	=> form_error('norekening'),
				'nmbank' 	=> form_error('nmbank'),
				'cabang' 	=> form_error('cabang'),
				'nmnasabah' 	=> form_error('nmnasabah'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'norekening' => $this->input->post('norekening'),
				'nmbank' => $this->input->post('nmbank'),
				'cabang' => $this->input->post('cabang'),
				'nmnasabah' => $this->input->post('nmnasabah'),
				'iduser' => $this->session->userdata('iduser'),
			);
			$insert = $this->rekening_bank->save($insert);
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
				'norekening' 	=> form_error('norekening'),
				'nmbank' 	=> form_error('nmbank'),
				'cabang' 	=> form_error('cabang'),
				'nmnasabah' 	=> form_error('nmnasabah'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'norekening' => $this->input->post('norekening'),
				'nmbank' => $this->input->post('nmbank'),
				'cabang' => $this->input->post('cabang'),
				'nmnasabah' => $this->input->post('nmnasabah'),
				'iduser' => $this->session->userdata('iduser'),
			);
			$this->rekening_bank->update(array('idrekeningbank' => $this->input->post('idrekeningbank')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->rekening_bank->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('norekening', 'nomer rekening', 'trim|required');
		$this->form_validation->set_rules('nmbank', 'nama bank', 'trim|required');
		$this->form_validation->set_rules('cabang', 'cabang', 'trim|required');
		$this->form_validation->set_rules('nmnasabah', 'nama nasabah', 'trim|required');
	}
}
