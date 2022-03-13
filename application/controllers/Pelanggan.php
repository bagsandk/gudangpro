<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('pelanggan_model', 'pelanggan');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'pelanggan/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->pelanggan->get_datatables();
		$data = array();
		foreach ($list as $pelanggan) {
			$row = array();
			$row[] = $pelanggan->kdpelanggan;
			$row[] = $pelanggan->nmpelanggan;
			$row[] = $pelanggan->notelp;
			$row[] = $pelanggan->email;
			$row[] = '<p>' . $pelanggan->alamat_jalan . ',<br>' . $pelanggan->kabupaten . ',<br>' . $pelanggan->provinsi . ',<br>' . $pelanggan->negara . '</p>';
			$row[] = $pelanggan->deposit;
			$row[] = $pelanggan->p_discount;

			//add html for action
			$row[] = "<a class='btn btn-md btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$pelanggan->idpelanggan}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-md btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$pelanggan->idpelanggan}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->pelanggan->count_all(),
			"recordsFiltered" => $this->pelanggan->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->pelanggan->get_by_id($id);
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
				'kdpelanggan' 	=> form_error('kdpelanggan'),
				'nmpelanggan' 			=> form_error('nmpelanggan'),
				'notelp' 		=> form_error('notelp'),
				'email' 		=> form_error('email'),
				'iduser' 		=> form_error('iduser'),
				'alamat_jalan' 		=> form_error('alamat_jalan'),
				'kabupaten' 		=> form_error('kabupaten'),
				'provinsi' 		=> form_error('provinsi'),
				'deposit' 		=> form_error('deposit'),
				'p_discount' 		=> form_error('p_discount'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'kdpelanggan' => $this->input->post('kdpelanggan'),
				'nmpelanggan' => $this->input->post('nmpelanggan'),
				'notelp' => $this->input->post('notelp'),
				'email' => $this->input->post('email'),
				'kabupaten' => $this->input->post('kabupaten'),
				'provinsi' => $this->input->post('provinsi'),
				'iduser' => $this->input->post('iduser'),
				'deposit' => $this->input->post('deposit'),
				'p_discount' => $this->input->post('p_discount'),
				'alamat_jalan' => $this->input->post('alamat_jalan'),
			);
			$insert = $this->pelanggan->save($insert);
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
				'kdpelanggan' 	=> form_error('kdpelanggan'),
				'nmpelanggan' 			=> form_error('nmpelanggan'),
				'notelp' 		=> form_error('notelp'),
				'iduser' 		=> form_error('iduser'),
				'email' 		=> form_error('email'),
				'alamat_jalan' 		=> form_error('alamat_jalan'),
				'kabupaten' 		=> form_error('kabupaten'),
				'provinsi' 		=> form_error('provinsi'),
				'iduser' 		=> form_error('iduser'),
				'deposit' 		=> form_error('deposit'),
				'p_discount' 		=> form_error('p_discount'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'kdpelanggan' => $this->input->post('kdpelanggan'),
				'nmpelanggan' => $this->input->post('nmpelanggan'),
				'notelp' => $this->input->post('notelp'),
				'email' => $this->input->post('email'),
				'kabupaten' => $this->input->post('kabupaten'),
				'provinsi' => $this->input->post('provinsi'),
				'iduser' => $this->input->post('iduser'),
				'deposit' => $this->input->post('deposit'),
				'p_discount' => $this->input->post('p_discount'),
				'alamat_jalan' => $this->input->post('alamat_jalan'),
			);
			$this->pelanggan->update(array('idpelanggan' => $this->input->post('idpelanggan')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->pelanggan->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('iduser', 'User', 'trim|required');
		$this->form_validation->set_rules('kdpelanggan', 'kode pelanggan', 'trim|required');
		$this->form_validation->set_rules('nmpelanggan', 'nama pelanggan', 'trim|required');
		$this->form_validation->set_rules('notelp', 'no telp', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
		$this->form_validation->set_rules('alamat_jalan', 'alamat jalan aaaaaaaaaaaa', 'trim|required');
		$this->form_validation->set_rules('kabupaten', 'kabupaten', 'trim|required');
		$this->form_validation->set_rules('provinsi', 'provinsi', 'trim|required');
		$this->form_validation->set_rules('deposit', 'deposit', 'trim|required');
		$this->form_validation->set_rules('p_discount', 'personal discount', 'trim|required');

		$kdpelanggan_unique = '';
		$email_unique = '';

		$getData = $this->pelanggan->get_by_id($this->input->post('idpelanggan'));

		if ($this->validation_for == 'add') {
			$kdpelanggan_unique = '|is_unique[tbl_pelanggan.kdpelanggan]';
			$email_unique = '|is_unique[tbl_pelanggan.email]';
		} else if ($this->validation_for == 'update') {
			if ($this->input->post('kdpelanggan') != $getData->kdpelanggan) {
				$kdpelanggan_unique = '|is_unique[tbl_pelanggan.kdpelanggan]';
				$email_unique = '|is_unique[tbl_pelanggan.email]';
			}
		}

		$this->form_validation->set_rules('kdpelanggan', 'kode pelanggan', 'trim|required' . $kdpelanggan_unique);
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email' . $email_unique);
	}
}
