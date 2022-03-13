<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Armada extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('armada_model', 'armada');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'armada/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->armada->get_datatables();
		$data = array();
		foreach ($list as $armada) {
			$row = array();
			$row[] = $armada->kdarmada;
			$row[] = $armada->nomor_plat;
			$row[] = $armada->nmjenis_armada;
			$row[] = $armada->daya_angkut;
			$row[] = $armada->nostnk;
			$row[] = $armada->tglpajak;
			$row[] = $armada->nmstaf;
			$row[] = $armada->kondisi_armada;

			//add html for action
			$row[] = "<a class='btn btn-md btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$armada->idarmada}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-md btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$armada->idarmada}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->armada->count_all(),
			"recordsFiltered" => $this->armada->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->armada->get_by_id($id);
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
				'kdarmada' 	=> form_error('kdarmada'),
				'nomor_plat' 			=> form_error('nomor_plat'),
				'idjenis_armada' 		=> form_error('idjenis_armada'),
				'daya_angkut' 		=> form_error('daya_angkut'),
				'nostnk' 		=> form_error('nostnk'),
				'tglpajak' 		=> form_error('tglpajak'),
				'idstaf' 		=> form_error('idstaf'),
				'kondisi_armada' 		=> form_error('kondisi_armada'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'kdarmada' => $this->input->post('kdarmada'),
				'nomor_plat' => $this->input->post('nomor_plat'),
				'idjenis_armada' => $this->input->post('idjenis_armada'),
				'daya_angkut' => $this->input->post('daya_angkut'),
				'nostnk' => $this->input->post('nostnk'),
				'idstaf' => $this->input->post('idstaf'),
				'kondisi_armada' => $this->input->post('kondisi_armada'),
				'tglpajak' => $this->input->post('tglpajak'),
			);
			$insert = $this->armada->save($insert);
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
				'kdarmada' 	=> form_error('kdarmada'),
				'nomor_plat' 			=> form_error('nomor_plat'),
				'idjenis_armada' 		=> form_error('idjenis_armada'),
				'daya_angkut' 		=> form_error('daya_angkut'),
				'nostnk' 		=> form_error('nostnk'),
				'tglpajak' 		=> form_error('tglpajak'),
				'idstaf' 		=> form_error('idstaf'),
				'kondisi_armada' 		=> form_error('kondisi_armada'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'kdarmada' => $this->input->post('kdarmada'),
				'nomor_plat' => $this->input->post('nomor_plat'),
				'idjenis_armada' => $this->input->post('idjenis_armada'),
				'daya_angkut' => $this->input->post('daya_angkut'),
				'nostnk' => $this->input->post('nostnk'),
				'idstaf' => $this->input->post('idstaf'),
				'kondisi_armada' => $this->input->post('kondisi_armada'),
				'tglpajak' => $this->input->post('tglpajak'),
			);
			$this->armada->update(array('idarmada' => $this->input->post('idarmada')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->armada->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('kdarmada', 'kode armada', 'trim|required');
		$this->form_validation->set_rules('nomor_plat', 'nomor plat', 'trim|required');
		$this->form_validation->set_rules('daya_angkut', 'daya angkut', 'trim|required');
		$this->form_validation->set_rules('nostnk', 'no stnk', 'trim|required');
		$this->form_validation->set_rules('tglpajak', 'tgl pajak', 'trim|required');
		$this->form_validation->set_rules('idstaf', 'staf', 'trim|required');
		$this->form_validation->set_rules('idjenis_armada', 'staf', 'trim|required');
		$this->form_validation->set_rules('kondisi_armada', 'kondisi armada', 'trim|required');

		$kdarmada_unique = '';

		$getData = $this->armada->get_by_id($this->input->post('idarmada'));

		if ($this->validation_for == 'add') {
			$kdarmada_unique = '|is_unique[tbl_armada.kdarmada]';
		} else if ($this->validation_for == 'update') {
			if ($this->input->post('kdarmada') != $getData->kdarmada) {
				$kdarmada_unique = '|is_unique[tbl_armada.kdarmada]';
			}
		}

		$this->form_validation->set_rules('kdarmada', 'kode armada', 'trim|required' . $kdarmada_unique);
	}
}
