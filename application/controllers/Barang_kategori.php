<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_kategori extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('barang_kategori_model', 'barang_kategori');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'barang_kategori/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->barang_kategori->get_datatables();
		$data = array();
		foreach ($list as $barang_kategori) {
			$row = array();
			$row[] = $barang_kategori->nmkategori;

			//add html for action
			$row[] = "<a class='btn btn-sm btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$barang_kategori->idkategori}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-sm btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$barang_kategori->idkategori}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->barang_kategori->count_all(),
			"recordsFiltered" => $this->barang_kategori->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->barang_kategori->get_by_id($id);
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
				'nmkategori' 	=> form_error('nmkategori'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'nmkategori' => $this->input->post('nmkategori'),
			);
			$insert = $this->barang_kategori->save($insert);
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
				'nmkategori' 	=> form_error('nmkategori'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'nmkategori' => $this->input->post('nmkategori'),
			);
			$this->barang_kategori->update(array('idkategori' => $this->input->post('idkategori')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->barang_kategori->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nmkategori', 'nama kategori', 'trim|required');
	}
}
