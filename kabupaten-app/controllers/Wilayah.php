<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wilayah extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('wilayah_model');
	}

	public function list_desa($kecamatan = '')
	{
		$list_rw = $this->wilayah_model->list_desa($kecamatan);
		echo json_encode($list_desa);
	}

	public function list_dusun($kecamatan = '', $desa = '-')
	{
		$list_rw = $this->wilayah_model->list_dusun($kecamatan);
		echo json_encode($list_dusun);
	}
	
	public function list_rw($kecamatan = '', $desa = '-', $dusun = '-')
	{
		$list_rw = $this->wilayah_model->list_rw($kecamatan);
		echo json_encode($list_rw);
	}

	public function list_rt($kecamatan = '', $desa = '-', $dusun = '-', $rw = '-')
	{
		$list_rt = $this->wilayah_model->list_rt($kecamatan, $rw);
		echo json_encode($list_rt);
	}
}
