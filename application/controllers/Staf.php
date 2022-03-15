<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staf extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('staf_model', 'staf');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'staf/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->staf->get_datatables();
		$data = array();
		foreach ($list as $staf) {
			$row = array();
			$row[] = $staf->kdstaf;
			$row[] = $staf->nmstaf;
			// $row[] = $staf->nik;
			// $row[] = $staf->tempat_lahir;
			// $row[] = $staf->tanggal_lahir;
			$row[] = (($staf->sex == 'L') ? 'Laki-laki' : (($staf->sex == 'P') ? 'Perempuan' : '-'));
			$row[] = $staf->notelp;
			$row[] = $staf->email;
			// $row[] = $staf->alamat_jalan;
			// $row[] = $staf->kabupaten;
			// $row[] = $staf->provinsi;
			// $row[] = $staf->negara;
			// $row[] = $staf->tgl_masuk;
			// $row[] = $staf->tgl_berhenti;
			// $row[] = $staf->nmjabatan;
			// $row[] = $staf->nmunit;
			// $row[] = $staf->alias;

			//add html for action
			$row[] = "<a class='btn btn-sm btn-outline-primary' href='javascript:void(0)' title='Detail' onclick=\"detail_data('{$staf->idstaf}')\"><i class='fa fa-info'></i>Detail</a>"
				. " <a class='btn btn-sm btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$staf->idstaf}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-sm btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$staf->idstaf}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->staf->count_all(),
			"recordsFiltered" => $this->staf->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->staf->get_by_id($id);
		echo json_encode($data);
	}

	public function detail($id)
	{
		$data = $this->staf->get_by_id($id);
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
				'kdstaf' 	=> form_error('kdstaf'),
				'nmstaf' 	=> form_error('nmstaf'),
				'nik' 	=> form_error('nik'),
				'tempat_lahir' 	=> form_error('tempat_lahir'),
				'tanggal_lahir' => form_error('tanggal_lahir'),
				'sex' => form_error('sex'),
				'notelp' => form_error('notelp'),
				'email' => form_error('email'),
				'alamat_jalan' => form_error('alamat_jalan'),
				'kabupaten' => form_error('kabupaten'),
				'provinsi' => form_error('provinsi'),
				'negara' => form_error('negara'),
				'tgl_masuk' => form_error('tgl_masuk'),
				'tgl_berhenti' => form_error('tgl_berhenti'),
				'idjabatan' => form_error('idjabatan'),
				'idunit' => form_error('idunit'),
				'idpendidikan' => form_error('idpendidikan'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'kdstaf' 	=> $this->input->post('kdstaf'),
				'nmstaf' 	=> $this->input->post('nmstaf'),
				'nik' 	=> $this->input->post('nik'),
				'tempat_lahir' 	=> $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'sex' => $this->input->post('sex'),
				'notelp' => $this->input->post('notelp'),
				'email' => $this->input->post('email'),
				'alamat_jalan' => $this->input->post('alamat_jalan'),
				'kabupaten' => $this->input->post('kabupaten'),
				'provinsi' => $this->input->post('provinsi'),
				'negara' => $this->input->post('negara'),
				'tgl_masuk' => $this->input->post('tgl_masuk'),
				'tgl_berhenti' => $this->input->post('tgl_berhenti'),
				'idjabatan' => $this->input->post('idjabatan'),
				'idunit' => $this->input->post('idunit'),
				'idpendidikan' => $this->input->post('idpendidikan'),
				'iduser' => $this->session->userdata('iduser'),
			);
			$insert = $this->staf->save($insert);
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
				'kdstaf' 	=> form_error('kdstaf'),
				'nmstaf' 	=> form_error('nmstaf'),
				'nik' 	=> form_error('nik'),
				'tempat_lahir' 	=> form_error('tempat_lahir'),
				'tanggal_lahir' => form_error('tanggal_lahir'),
				'sex' => form_error('sex'),
				'notelp' => form_error('notelp'),
				'email' => form_error('email'),
				'alamat_jalan' => form_error('alamat_jalan'),
				'kabupaten' => form_error('kabupaten'),
				'provinsi' => form_error('provinsi'),
				'negara' => form_error('negara'),
				'tgl_masuk' => form_error('tgl_masuk'),
				'tgl_berhenti' => form_error('tgl_berhenti'),
				'idjabatan' => form_error('idjabatan'),
				'idunit' => form_error('idunit'),
				'idpendidikan' => form_error('idpendidikan'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'kdstaf' 	=> $this->input->post('kdstaf'),
				'nmstaf' 	=> $this->input->post('nmstaf'),
				'nik' 	=> $this->input->post('nik'),
				'tempat_lahir' 	=> $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'sex' => $this->input->post('sex'),
				'notelp' => $this->input->post('notelp'),
				'email' => $this->input->post('email'),
				'alamat_jalan' => $this->input->post('alamat_jalan'),
				'kabupaten' => $this->input->post('kabupaten'),
				'provinsi' => $this->input->post('provinsi'),
				'negara' => $this->input->post('negara'),
				'tgl_masuk' => $this->input->post('tgl_masuk'),
				'tgl_berhenti' => $this->input->post('tgl_berhenti'),
				'idjabatan' => $this->input->post('idjabatan'),
				'idunit' => $this->input->post('idunit'),
				'idpendidikan' => $this->input->post('idpendidikan'),
				'iduser' => $this->session->userdata('iduser'),
			);
			$this->staf->update(array('idstaf' => $this->input->post('idstaf')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->staf->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$kdstaf = '';
		$nik = '';
		$email = '';
		$getData = $this->staf->get_by_id($this->input->post('idstaf'));
		if ($this->validation_for == 'add') {
			$kdstaf = '|is_unique[tbl_staf.kdstaf]';
			$nik = '|is_unique[tbl_staf.nik]';
			$email = '|is_unique[tbl_staf.email]';
		} else if ($this->validation_for == 'update') {
			if ($this->input->post('email') != $getData->email) {
				$email = '|is_unique[tbl_staf.email]';
			}
			if ($this->input->post('kdstaf') != $getData->kdstaf) {
				$kdstaf = '|is_unique[tbl_staf.kdstaf]';
			}
			if ($this->input->post('nik') != $getData->nik) {
				$nik = '|is_unique[tbl_staf.nik]';
			}
		}
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('kdstaf', 'kode staf', 'trim|required' . $kdstaf);
		$this->form_validation->set_rules('nmstaf', 'nama staf', 'trim|required');
		$this->form_validation->set_rules('nik', 'nik', 'trim|required' . $nik);
		$this->form_validation->set_rules('tempat_lahir', 'tempat lahir', 'trim|required');
		$this->form_validation->set_rules('tanggal_lahir', 'tanggal lahir', 'trim|required');
		$this->form_validation->set_rules('sex', 'jenis kelamin', 'trim|required|in_list[-,L,P]');
		$this->form_validation->set_rules('notelp', 'no telpon', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email' . $email);
		$this->form_validation->set_rules('alamat_jalan', 'alamat jalan', 'trim|required');
		$this->form_validation->set_rules('kabupaten', 'kabupaten', 'trim');
		$this->form_validation->set_rules('provinsi', 'provinsi', 'trim');
		$this->form_validation->set_rules('negara', 'negara', 'trim');
		$this->form_validation->set_rules('tgl_masuk', 'tanggal masuk', 'trim');
		$this->form_validation->set_rules('tgl_berhenti', 'tanggal berhenti', 'trim');
		$this->form_validation->set_rules('idjabatan', 'jabatan', 'trim|required');
		$this->form_validation->set_rules('idunit', 'unit', 'trim|required');
		$this->form_validation->set_rules('idpendidikan', 'pendidikan', 'trim|required');
	}
}
