<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

	public $validation_for = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('barang_model', 'barang');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['content'] = 'barang/index';
		$this->load->view('templates/main', $data);
	}

	public function list()
	{
		$list = $this->barang->get_datatables();
		$data = array();
		foreach ($list as $barang) {
			$row = array();
			$row[] = $barang->kdbarang;
			$row[] = $barang->nmbarang;
			$row[] = $barang->merek;
			$row[] = $barang->nmkategori;
			$row[] = $barang->nmsatuan;
			$row[] = $barang->nmsupplier;
			$row[] = $barang->tonase;
			$row[] = $barang->harga_net;
			$row[] = $barang->harga_jual;
			$row[] = $barang->stok;

			//add html for action
			$row[] = "<a class='btn btn-md btn-outline-primary' href='javascript:void(0)' title='Edit' onclick=\"edit_data('{$barang->idbarang}')\"><i class='fa fa-edit'></i>Edit</a>"
				. " <a class='btn btn-md btn-outline-danger' href='javascript:void(0)' title='Hapus' onclick=\"delete_data('{$barang->idbarang}')\"><i class='fa fa-trash'></i>Delete</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->barang->count_all(),
			"recordsFiltered" => $this->barang->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id)
	{
		$data = $this->barang->get_by_id($id);
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
				'kdbarang' 	=> form_error('kdbarang'),
				'nmbarang' 			=> form_error('nmbarang'),
				'merek' 			=> form_error('merek'),
				'idkategori' 		=> form_error('idkategori'),
				'idsatuan' 		=> form_error('idsatuan'),
				'idsupplier' 		=> form_error('idsupplier'),
				'tonase' 		=> form_error('tonase'),
				'harga_net' 		=> form_error('harga_net'),
				'harga_jual' 		=> form_error('harga_jual'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$insert = array(
				'kdbarang' => $this->input->post('kdbarang'),
				'nmbarang' => $this->input->post('nmbarang'),
				'merek' => $this->input->post('merek'),
				'idkategori' => $this->input->post('idkategori'),
				'idsatuan' => $this->input->post('idsatuan'),
				'idsupplier' => $this->input->post('idsupplier'),
				'tonase' => $this->input->post('tonase'),
				'harga_net' => $this->input->post('harga_net'),
				'harga_jual' => $this->input->post('harga_jual'),
			);
			$insert = $this->barang->save($insert);
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
				'kdbarang' 	=> form_error('kdbarang'),
				'nmbarang' 			=> form_error('nmbarang'),
				'merek' 			=> form_error('merek'),
				'idkategori' 		=> form_error('idkategori'),
				'idsatuan' 		=> form_error('idsatuan'),
				'idsupplier' 		=> form_error('idsupplier'),
				'tonase' 		=> form_error('tonase'),
				'harga_net' 		=> form_error('harga_net'),
				'harga_jual' 		=> form_error('harga_jual'),
			);
			$data = array(
				'status' 		=> FALSE,
				'errors' 		=> $errors
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$update = array(
				'kdbarang' => $this->input->post('kdbarang'),
				'nmbarang' => $this->input->post('nmbarang'),
				'merek' => $this->input->post('merek'),
				'idkategori' => $this->input->post('idkategori'),
				'idsatuan' => $this->input->post('idsatuan'),
				'idsupplier' => $this->input->post('idsupplier'),
				'tonase' => $this->input->post('tonase'),
				'harga_net' => $this->input->post('harga_net'),
				'harga_jual' => $this->input->post('harga_jual'),
			);
			$this->barang->update(array('idbarang' => $this->input->post('idbarang')), $update);
			$data['status'] = TRUE;
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function delete($id)
	{
		$this->barang->delete_by_id($id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	private function _validate()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nmbarang', 'nama barang', 'trim|required');
		$this->form_validation->set_rules('merek', 'merek', 'trim|required');
		$this->form_validation->set_rules('idkategori', 'kategori', 'trim|required|integer');
		$this->form_validation->set_rules('idsatuan', 'satuan', 'trim|required|integer');
		$this->form_validation->set_rules('idsupplier', 'supplier', 'trim|required|integer');
		$this->form_validation->set_rules('tonase', 'ronase', 'trim|required|integer');
		$this->form_validation->set_rules('harga_net', 'harga net', 'trim|required|numeric');
		$this->form_validation->set_rules('harga_jual', 'harga jual', 'trim|required|numeric');

		$kdbarang_unique = '';

		$getData = $this->barang->get_by_id($this->input->post('idbarang'));

		if ($this->validation_for == 'add') {
			$kdbarang_unique = '|is_unique[tbl_barang.kdbarang]';
		} else if ($this->validation_for == 'update') {
			if ($this->input->post('kdbarang') != $getData->kdbarang) {
				$kdbarang_unique = '|is_unique[tbl_barang.kdbarang]';
			}
		}

		$this->form_validation->set_rules('kdbarang', 'kode barang', 'trim|required' . $kdbarang_unique);
	}
}
