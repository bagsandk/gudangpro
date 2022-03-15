<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('supplier_model', 'supplier');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'supplier/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->supplier->get_datatables();
		$data = array();
		foreach ($list as $supplier) {
			$row = array();
			$row[] = $supplier->kdsupplier;
			$row[] = $supplier->nmsupplier;
			$row[] = $supplier->nmperson;
			$row[] = $supplier->notelp;
			$row[] = $supplier->email;
			$row[] = $supplier->alamat_jalan . ', ' . $supplier->kabupaten . ', ' . $supplier->provinsi . ', ' . $supplier->negara;
			$row[] = $supplier->deposit;

			//add html for action
			$row[] = " <a class='btn btn-sm btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$supplier->idsupplier}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-sm btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$supplier->idsupplier}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->supplier->count_all(),
			"recordsFiltered" => $this->supplier->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->supplier->get_by_id($id);
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
				'kdsupplier' 	=> form_error('kdsupplier'),
				'nmsupplier' 	=> form_error('nmsupplier'),
				'nmperson' 	=> form_error('nmperson'),
				'notelp' => form_error('notelp'),
				'email' => form_error('email'),
				'alamat_jalan' => form_error('alamat_jalan'),
				'kabupaten' => form_error('kabupaten'),
				'provinsi' => form_error('provinsi'),
				'negara' => form_error('negara'),
				'deposit' => form_error('deposit'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'kdsupplier' 	=> $this->input->post('kdsupplier'),
				'nmsupplier' 	=> $this->input->post('nmsupplier'),
				'nmperson' 	=> $this->input->post('nmperson'),
				'notelp' => $this->input->post('notelp'),
				'email' => $this->input->post('email'),
				'alamat_jalan' => $this->input->post('alamat_jalan'),
				'kabupaten' => $this->input->post('kabupaten'),
				'provinsi' => $this->input->post('provinsi'),
				'negara' => $this->input->post('negara'),
				'deposit' => $this->input->post('deposit'),
				'iduser' => $this->session->userdata('iduser'),
			);
			$insert = $this->supplier->save($insert);
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
				'kdsupplier' 	=> form_error('kdsupplier'),
				'nmsupplier' 	=> form_error('nmsupplier'),
				'nmperson' 	=> form_error('nmperson'),
				'notelp' => form_error('notelp'),
				'email' => form_error('email'),
				'alamat_jalan' => form_error('alamat_jalan'),
				'kabupaten' => form_error('kabupaten'),
				'provinsi' => form_error('provinsi'),
				'negara' => form_error('negara'),
				'deposit' => form_error('deposit'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'kdsupplier' 	=> $this->input->post('kdsupplier'),
				'nmsupplier' 	=> $this->input->post('nmsupplier'),
				'nmperson' 	=> $this->input->post('nmperson'),
				'notelp' => $this->input->post('notelp'),
				'email' => $this->input->post('email'),
				'alamat_jalan' => $this->input->post('alamat_jalan'),
				'kabupaten' => $this->input->post('kabupaten'),
				'provinsi' => $this->input->post('provinsi'),
				'negara' => $this->input->post('negara'),
				'deposit' => $this->input->post('deposit'),
				'iduser' => $this->session->userdata('iduser'),
			);
			$this->supplier->update(array('idsupplier' => $this->input->post('idsupplier')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->supplier->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$kdsupplier = '';
		$email = '';
		$getData = $this->supplier->get_by_id($this->input->post('idsupplier'));
		if ($this->validation_for == 'add') {
			$kdsupplier = '|is_unique[tbl_supplier.kdsupplier]';
			$email = '|is_unique[tbl_supplier.email]';
		} else if ($this->validation_for == 'update') {
			if ($this->input->post('email') != $getData->email) {
				$email = '|is_unique[tbl_supplier.email]';
			}
			if ($this->input->post('kdsupplier') != $getData->kdsupplier) {
				$kdsupplier = '|is_unique[tbl_supplier.kdsupplier]';
			}
		}
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('kdsupplier', 'kode supplier', 'trim|required' . $kdsupplier);
		$this->form_validation->set_rules('nmsupplier', 'nama supplier', 'trim|required');
		$this->form_validation->set_rules('nmperson', 'nama', 'trim|required');
		$this->form_validation->set_rules('notelp', 'no telpon', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email' . $email);
		$this->form_validation->set_rules('alamat_jalan', 'alamat jalan', 'trim|required');
		$this->form_validation->set_rules('kabupaten', 'kabupaten', 'trim');
		$this->form_validation->set_rules('provinsi', 'provinsi', 'trim');
		$this->form_validation->set_rules('negara', 'negara', 'trim');
		$this->form_validation->set_rules('deposit', 'deposit', 'trim|required');
	}
}
