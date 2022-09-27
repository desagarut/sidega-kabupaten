<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Identitas extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['config_model', 'wilayah_model', 'provinsi_model']);

		$this->modul_ini = 17;
		$this->sub_modul_ini = 17;
	}

	public function index()
	{
		$data['main'] = $this->config_model->get_data();
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);
		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);
		$data['desa_map'] = $this->config_model->get_data();
		$data_kabupaten = $this->config_model->get_data();
		$data['wil_ini'] = $data_kabupaten;
		$data['wil_atas'] = $data_kabupaten;
		$data['wil_atas']['zoom'] = $data_kabupaten;

		$this->render('identitas/index', $data);
	}

	public function form()
	{
		$data['main'] = $this->config_model->get_data();
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);
		$data['kecamatan'] = ucwords($this->setting->sebutan_kecamatan);
		$data['kabupaten'] = ucwords($this->setting->sebutan_kabupaten);
		$data['list_provinsi'] = $this->provinsi_model->list_data();

		// Buat row data desa di form apabila belum ada data desa
		if ($data['main'])
			$data['form_action'] = site_url('identitas/update/' . $data['main']['id']);
		else
			$data['form_action'] = site_url('identitas/insert');

		$this->render('identitas/form', $data);
	}

	public function insert()
	{
		$this->config_model->insert();
		redirect('identitas');
	}

	public function update($id = 0)
	{
		$this->config_model->update($id);
		redirect('identitas');
	}

	public function gmaps_wilayah()
	{
		$data_kabupaten = $this->config_model->get_data();
		$data['kabupaten'] = $this->config_model->get_data();
		$data['wil_ini'] = $data_kabupaten;
		$data['wil_atas']['lat'] = -7.229426071233562;
		$data['wil_atas']['lng'] = 107.88959092620838;
		$data['wil_atas']['zoom'] = $data_kabupaten;
		//$data['wil_atas'] = $this->config_model->get_data();
		$data['kecamatan_gis'] = $this->wilayah_model->list_kecamatan_gis();
		$data['nama_wilayah'] = ucwords($this->setting->sebutan_kabupaten . " " . $data_kabupaten['nama_kabupaten']);
		$data['wilayah'] = ucwords($this->setting->sebutan_kabupaten . " " . $data_kabupaten['nama_kabupaten']);
		$data['breadcrumb'] = array(
			array('link' => site_url("identitas"), 'judul' => "Identitas " . ucwords($this->setting->sebutan_kabupaten)),
		);

		$data['form_action'] = site_url("identitas/update_maps/$tipe");

		$this->render('identitas/peta_gmaps', $data);
	}
	
	public function gmaps_kantor()
	{
		$data_kabupaten = $this->config_model->get_data();
		$data['kabupaten'] = $this->config_model->get_data();
		$data['wil_ini'] = $data_kabupaten;
		$data['wil_atas']['lat'] = -7.229426071233562;
		$data['wil_atas']['lng'] = 107.88959092620838;
		$data['wil_atas']['zoom'] = $data_kabupaten;
		$data['kecamatan_gis'] = $this->wilayah_model->list_kecamatan_gis();
		$data['nama_wilayah'] = ucwords($this->setting->sebutan_kabupaten . " " . $data_kabupaten['nama_kabupaten']);
		$data['wilayah'] = ucwords($this->setting->sebutan_kabupaten . " " . $data_kabupaten['nama_kabupaten']);
		$data['breadcrumb'] = array(
			array('link' => site_url("identitas"), 'judul' => "Identitas " . ucwords($this->setting->sebutan_kabupaten)),
		);

		$data['form_action'] = site_url("identitas/update_maps/$tipe");

		$this->render('identitas/peta_gmaps_kantor', $data);
	}

	public function maps_osm()
	{
		$data_kabupaten = $this->config_model->get_data();
		$data['kabupaten'] = $this->config_model->get_data();
		$data['wil_ini'] = $data_kabupaten;
		$data['wil_atas']['lat'] = -7.229426071233562;
		$data['wil_atas']['lng'] = 107.88959092620838;
		$data['wil_atas']['zoom'] = 14;
		$data['wil_atas'] = $this->config_model->get_data();
		$data['kabupaten_gis'] = $this->wilayah_model->list_kecamatan_gis();
		$data['kecamatan_gis'] = $this->wilayah_model->list_kecamatan_gis();
		$data['desa_gis'] = $this->wilayah_model->list_desa_gis();
		/*$data['dusun_gis'] = $this->wilayah_model->list_dusun_gis();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();*/
		$data['nama_wilayah'] = ucwords($this->setting->sebutan_kabupaten . " " . $data_kabupaten['nama_kabupaten']);
		$data['wilayah'] = ucwords($this->setting->sebutan_kabupaten . " " . $data_kabupaten['nama_kabupaten']);
		$data['breadcrumb'] = array(
			array('link' => site_url("identitas"), 'judul' => "Identitas " . ucwords($this->setting->sebutan_kabupaten)),
		);

		$data['form_action'] = site_url("identitas/update_maps/$tipe");

		//$this->render('sid/wilayah/maps_' . $tipe, $data);
		$this->render('identitas/peta_osm', $data);
	}

	public function update_maps($tipe = 'kantor')
	{
		if ($tipe = 'kantor')
			$this->config_model->update_kantor();
		else
			$this->config_model->update_wilayah();

		redirect("identitas");
	}
}
