<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_satuan extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('barang_satuan_model', 'barang_satuan');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'barang_satuan/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->barang_satuan->get_datatables();
		$data = array();
		foreach ($list as $barang_satuan) {
			$row = array();
			$row[] = $barang_satuan->nmsatuan;
			$row[] = $barang_satuan->satuan;
			$row[] = $barang_satuan->kilogram;

			//add html for action
			$row[] = "<a class='btn btn-sm btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$barang_satuan->idsatuan}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-sm btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$barang_satuan->idsatuan}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->barang_satuan->count_all(),
			"recordsFiltered" => $this->barang_satuan->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->barang_satuan->get_by_id($id);
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
				'nmsatuan' 	=> form_error('nmsatuan'),
				'satuan' 	=> form_error('satuan'),
				'kilogram' 	=> form_error('kilogram'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'nmsatuan' => $this->input->post('nmsatuan'),
				'satuan' => $this->input->post('satuan'),
				'kilogram' => $this->input->post('kilogram'),
			);
			$insert = $this->barang_satuan->save($insert);
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
				'nmsatuan' 	=> form_error('nmsatuan'),
				'satuan' 	=> form_error('satuan'),
				'kilogram' 	=> form_error('kilogram'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'nmsatuan' => $this->input->post('nmsatuan'),
				'satuan' => $this->input->post('satuan'),
				'kilogram' => $this->input->post('kilogram'),
			);
			$this->barang_satuan->update(array('idsatuan' => $this->input->post('idsatuan')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->barang_satuan->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nmsatuan', 'nama satuan', 'trim|required');
		$this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
		$this->form_validation->set_rules('kilogram', 'kilogram', 'trim|required|numeric');
	}
}
