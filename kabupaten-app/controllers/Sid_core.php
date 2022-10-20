<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sid_Core extends Admin_Controller {

	private $_set_page;

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['wilayah_model', 'config_model', 'pamong_model']);
		$this->load->library('form_validation');
		$this->modul_ini = 20;
		$this->sub_modul_ini = 20;
		$this->_set_page = ['20', '50', '100'];
	}

	public function clear()
	{
		$this->session->unset_userdata('cari');
		$this->session->per_page = $this->_set_page[0];
		redirect('sid_core');
	}

	public function index($p = 1, $o = 0)
	{
		$data['p'] = $p;
		$data['o'] = $o;

		$per_page = $this->input->post('per_page');
		if (isset($per_page))
			$this->session->per_page = $per_page;

		$data['cari'] = $this->session->cari ?: '';
		$data['func'] = 'index';
		$data['set_page'] = $this->_set_page;
		$data['per_page'] = $this->session->per_page;
		$data['paging'] = $this->wilayah_model->paging($p, $o);
		$data['main'] = $this->wilayah_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
		$data['keyword'] = $this->wilayah_model->autocomplete();
		$data['total'] = $this->wilayah_model->total();

		$this->render('sid/wilayah/wilayah_kecamatan', $data);
	}

	/*
	 * $aksi = cetak/unduh
	 */
	public function dialog($aksi = 'cetak')
	{
		$data['aksi'] = $aksi;
		$data['pamong'] = $this->pamong_model->list_data();
		$data['form_action'] = site_url("sid_core/daftar/$aksi");
		$this->load->view('global/ttd_pamong', $data);

		// $data['header'] = $this->header['kabupaten'];
		// $data['main'] = $this->wilayah_model->list_data(0, 0, 1000);
		// $data['total'] = $this->wilayah_model->total();

		// $this->load->view('sid/wilayah/wilayah_print', $data);
	}

	/*
	 * $aksi = cetak/unduh
	 */
	public function daftar($aksi = 'cetak')
	{
		$data['pamong_ttd'] = $this->pamong_model->get_data($this->input->post('pamong_ttd'));
		$data['pamong_ketahui'] = $this->pamong_model->get_data($this->input->post('pamong_ketahui'));
		$data['kabupaten'] = $this->_header;
		$data['main'] = $this->wilayah_model->list_semua_wilayah();
		$data['total'] = $this->wilayah_model->total();

		$this->load->view("sid/wilayah/wilayah_$aksi", $data);
	}


	public function form_kecamatan($id = '')
	{
		$data['penduduk'] = $this->wilayah_model->list_penduduk();

		if ($id)
		{
			$temp = $this->wilayah_model->cluster_by_id($id);
			$data['kecamatan'] = $temp['kecamatan'];
			$data['individu'] = $this->wilayah_model->get_penduduk($temp['id_kepala']);
			$data['form_action'] = site_url("sid_core/update_kecamatan/$id");
		}
		else
		{
			$data['kecamatan'] = null;
			$data['form_action'] = site_url("sid_core/insert_kecamatan");
		}

		$data['kecamatan_id'] = $this->wilayah_model->get_kecamatan_maps($id);

		$this->render('sid/wilayah/wilayah_kecamatan_form', $data);
	}

	public function search()
	{
		$cari = $this->input->post('cari');
		if ($cari != '')
			$this->session->cari = $cari;
		else $this->session->unset_userdata('cari');
		redirect('sid_core');
	}

	
	public function insert_kecamatan()
	{
		$this->wilayah_model->insert_kecamatan();
		redirect('sid_core');
	}

	public function update_kecamatan($id = '')
	{
		$this->wilayah_model->update_kecamatan($id);
		redirect('sid_core');
	}
	//Delete kecamatan/desa/dusun/rw/rt tergantung tipe
	public function delete($tipe = '', $id = '')
	{
		$kembali = $_SERVER['HTTP_REFERER'];
		$this->redirect_hak_akses('h', $kembali);
		$this->wilayah_model->delete($tipe, $id);
		redirect($kembali);
	}

//SUB DESA
public function sub_desa($id_kecamatan = '')
{
	$kecamatan = $this->wilayah_model->cluster_by_id($id_kecamatan);
	$nama_kecamatan = $kecamatan['kecamatan'];
	$data['kecamatan'] = $kecamatan['kecamatan'];
	$data['id_kecamatan'] = $id_kecamatan;

	$data['main'] = $this->wilayah_model->list_data_desa($id_kecamatan);
	$data['total'] = $this->wilayah_model->total_desa($nama_kecamatan);

	$this->render('sid/wilayah/wilayah_desa', $data);
}

public function cetak_desa($id_kecamatan = '')
{
	$kecamatan = $this->wilayah_model->cluster_by_id($id_kecamatan);
	$nama_kecamatan = $kecamatan['kecamatan'];
	$data['kecamatan'] = $kecamatan['kecamatan'];
	$data['id_kecamatan'] = $id_kecamatan;
	$data['main'] = $this->wilayah_model->list_data_desa($id_kecamatan );
	$data['total'] = $this->wilayah_model->total_desa($nama_kecamatan );

	$this->load->view('sid/wilayah/wilayah_desa_print', $data);
}

public function excel_desa($id_kecamatan = '', $id_desa = '')
{
	$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
	$kecamatan = $temp['kecamatan'];
	$data['kecamatan'] = $temp['kecamatan'];
	$data['id_kecamatan'] = $id_kecamatan;

	$temp = $this->wilayah_model->cluster_by_id($id_desa);
	$desa = $temp['desa'];
	$data['desa'] = $desa;
	
	$data['main'] = $this->wilayah_model->list_data_desa($kecamatan, $desa);
	$data['total'] = $this->wilayah_model->total_desa($kecamatan, $desa);

	$this->load->view('sid/wilayah/wilayah_desa_excel', $data);
}


public function form_desa($id_kecamatan = '', $id_desa = '')
{
	$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
	$kecamatan = $temp['kecamatan'];
	$data['kecamatan'] = $temp['kecamatan'];
	$data['id_kecamatan'] = $id_kecamatan;
	$data['id_desa'] = $id_desa;

	$data['penduduk'] = $this->wilayah_model->list_penduduk();

	if ($id_desa)
	{
		$temp = $this->wilayah_model->cluster_by_id($id_desa);
		$data['desa'] = $temp['desa'];
		$data['individu'] = $this->wilayah_model->get_penduduk($temp['id_kepala']);
		$data['form_action'] = site_url("sid_core/update_desa/$kecamatan/$id_desa");
	}
	else
	{
		$data['desa'] = NULL;
		$data['form_action'] = site_url("sid_core/insert_desa/$kecamatan");
	}

	$this->render('sid/wilayah/wilayah_desa_form', $data);
}

public function insert_desa($kecamatan = '')
{
	$this->wilayah_model->insert_desa($kecamatan);
	redirect("sid_core/sub_desa/$kecamatan");
}

public function update_desa($kecamatan = '', $id_desa = '')
{
	$this->wilayah_model->update_desa($id_desa);
	redirect("sid_core/sub_desa/$kecamatan");
}
//end sub desa

//SUB Dusun
public function sub_dusun($id_kecamatan = '', $id_desa = '')
{
	$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
	$kecamatan = $temp['kecamatan'];
	$desa = $temp['desa'];
	$data['kecamatan'] = $temp['kecamatan'];
	$data['id_kecamatan'] = $id_kecamatan;
	
	$data_desa = $this->wilayah_model->cluster_by_id($id_desa);
	$data['desa'] = $data_desa['desa'];
	$data['id_desa'] = $id_desa;

	$data['main'] = $this->wilayah_model->list_data_dusun($kecamatan,$data['desa']);
	$data['total'] = $this->wilayah_model->total_dusun($kecamatan, $data['desa']);

	$this->render('sid/wilayah/wilayah_dusun', $data);
}

public function cetak_dusun($id_kecamatan = '')
{
	$kecamatan = $this->wilayah_model->cluster_by_id($id_kecamatan);
	$nama_kecamatan = $kecamatan['kecamatan'];
	$data['dusun'] = $kecamatan['kecamatan'];
	$data['id_kecamatan'] = $id_kecamatan;
	$data['main'] = $this->wilayah_model->list_data_dusun($id_kecamatan );
	$data['total'] = $this->wilayah_model->total_rw($nama_kecamatan );

	$this->load->view('sid/wilayah/wilayah_dusun_print', $data);
}

public function excel_dusun($id_kecamatan = '')
{
	$kecamatan = $this->wilayah_model->cluster_by_id($id_kecamatan);
	$nama_kecamatan = $kecamatan['kecamatan'];
	$data['desa'] = $kecamatan['desa'];
	$data['dusun'] = $kecamatan['kecamatan'];
	$data['id_kecamatan'] = $id_kecamatan;
	$data['main'] = $this->wilayah_model->list_data_dusun($id_kecamatan );
	$data['total'] = $this->wilayah_model->total_dusun($nama_kecamatan );

	$this->load->view('sid/wilayah/wilayah_dusun_excel', $data);
}

public function form_dusun($id_kecamatan = '', $id_desa = '', $id_dusun = '')
{
	$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
	$kecamatan = $temp['kecamatan'];
	$desa = $temp['desa'];
	$data['kecamatan'] = $temp['kecamatan'];
	$data['id_kecamatan'] = $id_kecamatan;
	
	$data_desa = $this->wilayah_model->cluster_by_id($id_desa);
	$data['desa'] = $data_desa['desa'];
	$data['id_desa'] = $id_desa;

	$data['penduduk'] = $this->wilayah_model->list_penduduk();

	if ($id_dusun)
	{
		$temp = $this->wilayah_model->cluster_by_id($id_dusun);
		$data['id_dusun'] = $id_dusun;
		$data['dusun'] = $temp['dusun'];
		$data['individu'] = $this->wilayah_model->get_penduduk($temp['id_kepala']);
		$data['form_action'] = site_url("sid_core/update_dusun/$id_kecamatan/$id_desa/$id_dusun");
	}
	else
	{
		$data['dusun'] = NULL;
		$data['form_action'] = site_url("sid_core/insert_dusun/$id_kecamatan/$id");
	}

	$this->render('sid/wilayah/wilayah_dusun_form', $data);
}

public function insert_dusun($id_kecamatan = '', $id_desa = '')
{
	$this->wilayah_model->insert_dusun($id_kecamatan, $id_desa);
	redirect("sid_core/sub_dusun/$id_kecamatan/$id_desa");
}

public function update_dusun($kecamatan = '', $desa = '', $dusun = '')
{
	$this->wilayah_model->update_dusun($id_dusun);
	redirect("sid_core/sub_dusun/$kecamatan");
}

//end sub Dusun

	//DATA RW
	public function sub_rw($id_kecamatan = '', $id_desa = '', $id_dusun = '')
	{
	$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
	$kecamatan = $temp['kecamatan'];
	$desa = $temp['desa'];
	$data['kecamatan'] = $temp['kecamatan'];
	$data['id_kecamatan'] = $id_kecamatan;
	
	$data_desa = $this->wilayah_model->cluster_by_id($id_desa);
	$data['desa'] = $data_desa['desa'];
	$data['id_desa'] = $id_desa;
	
	$data_dusun = $this->wilayah_model->cluster_by_id($id_dusun);
	$data['dusun'] = $data_dusun['dusun'];
	$data['id_dusun'] = $id_dusun;

	$data['main'] = $this->wilayah_model->list_data_rw($kecamatan,$data['dusun']);
	$data['total'] = $this->wilayah_model->total_rw($kecamatan, $data['dusun']);

	$this->render('sid/wilayah/wilayah_rw', $data);
	}

	public function cetak_rw($id_kecamatan = '')
	{
		$kecamatan = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$nama_kecamatan = $kecamatan['kecamatan'];
		$data['dusun'] = $kecamatan['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;
		$data['main'] = $this->wilayah_model->list_data_rw($id_kecamatan );
		$data['total'] = $this->wilayah_model->total_rw($nama_kecamatan );

		$this->load->view('sid/wilayah/wilayah_rw_print', $data);
	}

	public function excel_rw($id_kecamatan = '')
	{
		$kecamatan = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$nama_kecamatan = $kecamatan['kecamatan'];
		$data['dusun'] = $kecamatan['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;
		$data['main'] = $this->wilayah_model->list_data_rw($id_kecamatan );
		$data['total'] = $this->wilayah_model->total_rw($nama_kecamatan );

		$this->load->view('sid/wilayah/wilayah_rw_excel', $data);
	}

	public function form_rw($id_kecamatan = '', $id_rw = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$kecamatan = $temp['kecamatan'];
		$data['kecamatan'] = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;
		
		$data_desa = $this->wilayah_model->cluster_by_id($id_desa);
		$data['desa'] = $data_desa['desa'];
		$data['id_desa'] = $id_desa;

		$data_dusun = $this->wilayah_model->cluster_by_id($id_dusun);
		$data['dusun'] = $data_dusun['dusun'];
		$data['id_dusun'] = $id_dusun;

		$data['penduduk'] = $this->wilayah_model->list_penduduk();

		if ($id_rw)
		{
			$temp = $this->wilayah_model->cluster_by_id($id_rw);
			$data['id_rw'] = $id_rw;
			$data['rw'] = $temp['rw'];
			$data['individu'] = $this->wilayah_model->get_penduduk($temp['id_kepala']);
			$data['form_action'] = site_url("sid_core/update_rw/$id_kecamatan/$id_rw");
		}
		else
		{
			$data['rw'] = NULL;
			$data['form_action'] = site_url("sid_core/insert_rw/$id_kecamatan");
		}

		$this->render('sid/wilayah/wilayah_rw_form', $data);
	}

	public function insert_rw($kecamatan = '')
	{
		$this->wilayah_model->insert_rw($kecamatan);
		redirect("sid_core/sub_rw/$kecamatan");
	}

	public function update_rw($kecamatan = '', $id_rw = '')
	{
		$this->wilayah_model->update_rw($id_rw);
		redirect("sid_core/sub_rw/$kecamatan");
	}

//SUB RT
	public function sub_rt($id_kecamatan = '', $id_desa = '', $id_dusun = '', $id_rw = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$kecamatan = $temp['kecamatan'];
		$data['kecamatan'] = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;
		$data['desa'] = $data_desa['desa'];
		$data['id_desa'] = $id_desa;
		$data['dusun'] = $data_dusun['dusun'];
		$data['id_dusun'] = $id_dusun;


		$data_rw = $this->wilayah_model->cluster_by_id($id_rw);
		$data['rw'] = $data_rw['rw'];
		$data['id_rw'] = $id_rw;
		$data['main'] = $this->wilayah_model->list_data_rt($kecamatan, $data['desa'],  $data['dusun'], $data['rw']);
		$data['total'] = $this->wilayah_model->total_rt($kecamatan,  $data['desa'],  $data['dusun'], $data['rw']);

		$this->render('sid/wilayah/wilayah_rt', $data);
	}

	public function cetak_rt($id_kecamatan = '', $id_rw = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$kecamatan = $temp['kecamatan'];
		$data['kecamatan'] = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;

		$temp = $this->wilayah_model->cluster_by_id($id_rw);
		$rw = $temp['rw'];
		$data['rw'] = $rw;
		$data['main'] = $this->wilayah_model->list_data_rt($kecamatan, $rw);
		$data['total'] = $this->wilayah_model->total_rt($kecamatan, $rw);

		$this->load->view('sid/wilayah/wilayah_rt_print', $data);
	}

	public function excel_rt($id_kecamatan = '', $id_rw = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$kecamatan = $temp['kecamatan'];
		$data['kecamatan'] = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;

		$temp = $this->wilayah_model->cluster_by_id($id_rw);
		$rw = $temp['rw'];
		$data['rw'] = $rw;
		$data['main'] = $this->wilayah_model->list_data_rt($kecamatan, $rw);
		$data['total'] = $this->wilayah_model->total_rt($kecamatan, $rw);

		$this->load->view('sid/wilayah/wilayah_rt_excel', $data);
	}

	public function form_rt($id_kecamatan = '', $id_rw = '', $rt = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$data['kecamatan'] = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;

		$data_rw = $this->wilayah_model->cluster_by_id($id_rw);
		$data['rw'] = $data_rw['rw'];
		$data['id_rw'] = $data_rw['id'];
		$data['penduduk'] = $this->wilayah_model->list_penduduk();

		if ($rt)
		{
			$temp2 = $this->wilayah_model->cluster_by_id($rt);
			$id_cluster = $temp2['id'];
			$data['rt'] = $temp2['rt'];
			$data['individu'] = $this->wilayah_model->get_penduduk($temp2['id_kepala']);
			$data['form_action'] = site_url("sid_core/update_rt/$id_kecamatan/$id_rw/$id_cluster");
		}
		else
		{
			$data['rt'] = NULL;
			$data['form_action'] = site_url("sid_core/insert_rt/$id_kecamatan/$id_rw");
		}

		$this->render('sid/wilayah/wilayah_form_rt', $data);
	}

	public function insert_rt($id_kecamatan = '', $id_rw = '')
	{
		$this->wilayah_model->insert_rt($id_kecamatan, $id_rw);
		redirect("sid_core/sub_rt/$id_kecamatan/$id_rw");
	}

	public function update_rt($kecamatan = '', $rw = '', $id_cluster = 0)
	{
		$this->wilayah_model->update_rt($id_cluster);
		redirect("sid_core/sub_rt/$kecamatan/$rw");
	}

	public function warga($id = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id);
		$id_kecamatan = $temp['id'];
		$kecamatan = $temp['kecamatan'];

		$_SESSION['per_page'] = 100;
		$_SESSION['dusun'] = $kecamatan;
		redirect("penduduk/index/1/0");
	}

	public function warga_kk($id = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id);
		$id_kecamatan = $temp['id'];
		$kecamatan = $temp['kecamatan'];
		$_SESSION['per_page'] = 50;
		$_SESSION['dusun'] = $kecamatan;
		redirect("keluarga/index/1/0");
	}

	public function warga_l($id = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id);
		$id_kecamatan = $temp['id'];
		$kecamatan = $temp['kecamatan'];

		$_SESSION['per_page'] = 100;
		$_SESSION['dusun'] = $kecamatan;
		$_SESSION['sex'] = 1;
		redirect("penduduk/index/1/0");
	}

	public function warga_p($id = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id);
		$id_kecamatan = $temp['id'];
		$kecamatan = $temp['kecamatan'];

		$_SESSION['per_page'] = 100;
		$_SESSION['dusun'] = $kecamatan;
		$_SESSION['sex'] = 2;
		redirect("penduduk/index/1/0");
	}
	
// Start Pemetaan Wilayah Kecamatan

	public function ajax_kantor_kecamatan_maps_google($id = '')

	{

		$sebutan_kabupaten = ucwords($this->setting->sebutan_kabupaten);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['wil_ini'] = $this->wilayah_model->get_kecamatan_maps($id);
		$data['kecamatan_gis'] = $this->wilayah_model->list_kecamatan_gis();
		$data['desa_gis'] = $this->wilayah_model->list_dusun_gis();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();

		$data['nama_wilayah'] = ucwords($this->setting->sebutan_wilayah." ".$data['wil_ini']['kecamatan']." ".$sebutan_kabupaten." ".$data['wil_atas']['nama_kabupaten']);
		$data['wilayah'] = ucwords($this->setting->sebutan_wilayah);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
		);
		$data['form_action'] = site_url("sid_core/update_kantor_kecamatan_map/$id");
		$nama_kabupaten =  $data['wil_atas']['nama_kabupaten'];
		$data['logo'] = $this->config_model->get_data();

		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->render("sid/wilayah/maps_google_kantor", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Lokasi Kantor $sebutan_kabupaten $nama_kabupaten Belum Dilengkapi";
			redirect("sid_core", $data);
		}
	}

	public function ajax_wilayah_kecamatan_openstreet_maps($id = '')
	{
		$sebutan_kabupaten = ucwords($this->setting->sebutan_kabupaten);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['wil_ini'] = $this->wilayah_model->get_kecamatan_maps($id);
		$data['kecamatan_gis'] = $this->wilayah_model->list_kecamatan();
		$data['desa_gis'] = $this->wilayah_model->list_desa();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = ucwords($this->setting->sebutan_kecamatan." ".$data['wil_ini']['kecamatan']." ".$sebutan_kabupaten." ".$data['wil_atas']['nama_kabupaten']);
		$data['wilayah'] = ucwords($this->setting->sebutan_kecamatan);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
		);
		$data['form_action'] = site_url("sid_core/update_wilayah_kecamatan_map/$id");
		$nama_kabupaten =  $data['wil_atas']['nama_kabupaten'];
		$data['logo'] = $this->config_model->get_data();
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->render("sid/wilayah/maps_openstreet_wilayah", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_kabupaten $nama_kabupaten Belum Dilengkapi";
			redirect("sid_core");
		}
	}
	
	public function ajax_wilayah_kecamatan_maps_google($id = '')
	{
		$sebutan_kabupaten = ucwords($this->setting->sebutan_kabupaten);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['wil_ini'] = $this->wilayah_model->get_kecamatan_maps($id);
		$data['kecamatan_gis'] = $this->wilayah_model->list_kecamatan_gis();
		$data['desa_gis'] = $this->wilayah_model->list_desa_gis();
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = ucwords($this->setting->sebutan_wilayah." ".$data['wil_ini']['kecamatan']." ".$sebutan_kabupaten." ".$data['wil_atas']['nama_kabupaten']);
		$data['wilayah'] = ucwords($this->setting->sebutan_wilayah);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
		);
		$data['form_action'] = site_url("sid_core/update_wilayah_kecamatan_map/$id");
		$nama_kabupaten =  $data['wil_atas']['nama_kabupaten'];
		$data['logo'] = $this->config_model->get_data();
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->render("sid/wilayah/maps_google_wilayah", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_kabupaten $nama_kabupaten Belum Dilengkapi";
			redirect("sid_core");
		}
	}

	public function update_kantor_kecamatan_map($id = '')
	{
		$sebutan_kecamatan = ucwords($this->setting->sebutan_kecamatan);
		$nama_kecamatan =  $this->input->post('kecamatan');
		$id_kecamatan =  $this->input->post('id');

		$this->wilayah_model->update_kantor_kecamatan_map($id);
		redirect("sid_core");
	}

	public function update_wilayah_kecamatan_map($id = '')
	{
		$sebutan_kecamatan = ucwords($this->setting->sebutan_dusun);
		$nama_kecamatan =  $this->input->post('kecamatan');
		$id_kecamatan =  $this->input->post('id');

		$this->wilayah_model->update_wilayah_kecamatan_map($id);
		redirect("sid_core");
	}


// End Pemetaan Wilayah Kecamatan	

// Start Pemetaan Desa
	
	public function ajax_kantor_desa_maps_google($id = '')

	{

		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['wil_ini'] = $this->wilayah_model->get_dusun_maps($id);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();

		$data['nama_wilayah'] = ucwords($this->setting->sebutan_wilayah." ".$data['wil_ini']['dusun']." ".$sebutan_desa." ".$data['wil_atas']['nama_desa']);
		$data['wilayah'] = ucwords($this->setting->sebutan_wilayah);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
		);
		$data['form_action'] = site_url("sid_core/update_kantor_desa_map/$id");
		$namadesa =  $data['wil_atas']['nama_desa'];
		$data['logo'] = $this->config_model->get_data();

		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->render("sid/wilayah/maps_google_kantor", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Lokasi Kantor $sebutan_desa $nama_desa Belum Dilengkapi";
			redirect("sid_core", $data);
		}
	}
	
	public function ajax_wilayah_desa_openstreet_maps($id = '')
	{
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['wil_ini'] = $this->wilayah_model->get_dusun_maps($id);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = ucwords($this->setting->sebutan_dusun." ".$data['wil_ini']['dusun']." ".$sebutan_desa." ".$data['wil_atas']['nama_desa']);
		$data['wilayah'] = ucwords($this->setting->sebutan_dusun);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
		);
		$data['form_action'] = site_url("sid_core/update_wilayah_desa_map/$id");
		$namadesa =  $data['wil_atas']['nama_desa'];
		$data['logo'] = $this->config_model->get_data();
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->render("sid/wilayah/maps_openstreet_wilayah", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("sid_core");
		}
	}

	public function ajax_wilayah_desa_maps_google($id = '')
	{
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['wil_ini'] = $this->wilayah_model->get_dusun_maps($id);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = ucwords($this->setting->sebutan_wilayah." ".$data['wil_ini']['dusun']." ".$sebutan_desa." ".$data['wil_atas']['nama_desa']);
		$data['wilayah'] = ucwords($this->setting->sebutan_wilayah);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
		);
		$data['form_action'] = site_url("sid_core/update_wilayah_dusun_map/$id");
		$nama_desa =  $data['wil_atas']['nama_desa'];
		$data['logo'] = $this->config_model->get_data();
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->render("sid/wilayah/maps_google_wilayah", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("sid_core");
		}
	}

	public function update_kantor_desa_map($id = '')
	{
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$nama_desa =  $this->input->post('desa');
		$id_desa =  $this->input->post('id');

		$this->wilayah_model->update_kantor_desa_map($id);
		redirect("sid_core");
	}

	public function update_wilayah_desa_map($id = '')
	{
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$nama_desa =  $this->input->post('desa');
		$id_desa =  $this->input->post('id');

		$this->wilayah_model->update_wilayah_desa_map($id);
		redirect("sid_core");
	}

// End Pemetaan Desa


// Start Pemetaan Dusun
	
	public function ajax_kantor_dusun_maps_google($id = '')

	{

		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['wil_ini'] = $this->wilayah_model->get_dusun_maps($id);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();

		$data['nama_wilayah'] = ucwords($this->setting->sebutan_wilayah." ".$data['wil_ini']['dusun']." ".$sebutan_desa." ".$data['wil_atas']['nama_desa']);
		$data['wilayah'] = ucwords($this->setting->sebutan_wilayah);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
		);
		$data['form_action'] = site_url("sid_core/update_kantor_dusun_map/$id");
		$namadesa =  $data['wil_atas']['nama_desa'];
		$data['logo'] = $this->config_model->get_data();

		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->render("sid/wilayah/maps_google_kantor", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Lokasi Kantor $sebutan_desa $nama_desa Belum Dilengkapi";
			redirect("sid_core", $data);
		}
	}

	public function ajax_wilayah_dusun_openstreet_maps($id = '')
	{
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['wil_ini'] = $this->wilayah_model->get_dusun_maps($id);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = ucwords($this->setting->sebutan_dusun." ".$data['wil_ini']['dusun']." ".$sebutan_desa." ".$data['wil_atas']['nama_desa']);
		$data['wilayah'] = ucwords($this->setting->sebutan_dusun);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
		);
		$data['form_action'] = site_url("sid_core/update_wilayah_dusun_map/$id");
		$namadesa =  $data['wil_atas']['nama_desa'];
		$data['logo'] = $this->config_model->get_data();
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->render("sid/wilayah/maps_openstreet_wilayah", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("sid_core");
		}
	}

	public function ajax_wilayah_dusun_maps_google($id = '')
	{
		$sebutan_desa = ucwords($this->setting->sebutan_desa);
		$data['wil_atas'] = $this->config_model->get_data();
		$data['wil_ini'] = $this->wilayah_model->get_dusun_maps($id);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = ucwords($this->setting->sebutan_wilayah." ".$data['wil_ini']['dusun']." ".$sebutan_desa." ".$data['wil_atas']['nama_desa']);
		$data['wilayah'] = ucwords($this->setting->sebutan_wilayah);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$data['wilayah']),
		);
		$data['form_action'] = site_url("sid_core/update_wilayah_dusun_map/$id");
		$nama_desa =  $data['wil_atas']['nama_desa'];
		$data['logo'] = $this->config_model->get_data();
		if (!empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng'] && !empty($data['wil_atas']['path']))))
		{
			$this->render("sid/wilayah/maps_google_wilayah", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_desa $namadesa Belum Dilengkapi";
			redirect("sid_core");
		}
	}

	public function update_kantor_dusun_map($id = '')
	{
		$sebutan_dusun = ucwords($this->setting->sebutan_dusun);
		$namadusun =  $this->input->post('dusun');
		$iddusun =  $this->input->post('id');

		$this->wilayah_model->update_kantor_dusun_map($id);
		redirect("sid_core");
	}

	public function update_wilayah_dusun_map($id = '')
	{
		$sebutan_dusun = ucwords($this->setting->sebutan_dusun);
		$namadusun =  $this->input->post('dusun');
		$iddusun =  $this->input->post('id');

		$this->wilayah_model->update_wilayah_dusun_map($id);
		redirect("sid_core");
	}

// End Pemetaan Dusun

	public function ajax_kantor_rw_google_maps($id_kecamatan = '', $id_rw = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$kecamatan = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;
		$sebutan_wilayah = ucwords($this->setting->sebutan_wilayah);
		$temp = $this->wilayah_model->cluster_by_id($id_rw);

		$rw = $temp['rw'];
		$data['rw'] = $rw;
		$data['id_rw'] = $id_rw;
		$data['wil_atas'] = $this->wilayah_model->get_dusun_maps($id_kecamatan);
		$data['wil_ini'] = $this->wilayah_model->get_rw_maps($kecamatan, $rw);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = 'RW '.$data['wil_ini']['rw']." ".ucwords($sebutan_wilayah." ".$data['wil_ini']['dusun']);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$sebutan_wilayah),
			array('link' => site_url("sid_core/sub_rw/$id_kecamatan"), 'judul' => 'Daftar RW')
		);

		$data['wilayah'] = 'RW';
		$data['form_action'] = site_url("sid_core/update_kantor_rw_map/$id_kecamatan/$id_rw");
		$data['logo'] = $this->config_model->get_data();


		if (!empty($data['wil_atas']['path'] && !empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng']))))
		{
			$this->render("sid/wilayah/maps_google_kantor", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Lokasi Kantor $sebutan_wilayah $kecamatan Belum Dilengkapi";
			redirect("sid_core/sub_rw/$id_kecamatan");
		}
	}

	public function ajax_wilayah_rw_openstreet_maps($id_kecamatan = '', $id_rw = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$kecamatan = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;
		$sebutan_dusun = ucwords($this->setting->sebutan_dusun);
		$temp = $this->wilayah_model->cluster_by_id($id_rw);
		$rw = $temp['rw'];
		$data['rw'] = $rw;
		$data['id_rw'] = $id_rw;
		$data['wil_atas'] = $this->wilayah_model->get_dusun_maps($id_kecamatan);
		$data['wil_ini'] = $this->wilayah_model->get_rw_maps($kecamatan, $rw);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = 'RW '.$data['wil_ini']['rw']." ".ucwords($sebutan_dusun." ".$data['wil_ini']['dusun']);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$sebutan_dusun),
			array('link' => site_url("sid_core/sub_rw/$id_kecamatan"), 'judul' => 'Daftar RW')
		);
		$data['wilayah'] = 'RW';
		$data['form_action'] = site_url("sid_core/update_wilayah_rw_map/$id_kecamatan/$id_rw");
		$data['logo'] = $this->config_model->get_data();

		if (!empty($data['wil_atas']['path'] && !empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng']))))
		{
			$this->render("sid/wilayah/maps_openstreet_wilayah", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_dusun $kecamatan Belum Dilengkapi";
			redirect("sid_core/sub_rw/$id_kecamatan");
		}
	}

	public function ajax_wilayah_rw_google_maps($id_kecamatan = '', $id_rw = '')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$kecamatan = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;
		$sebutan_dusun = ucwords($this->setting->sebutan_dusun);
		$temp = $this->wilayah_model->cluster_by_id($id_rw);
		$rw = $temp['rw'];
		$data['rw'] = $rw;
		$data['id_rw'] = $id_rw;
		$data['wil_atas'] = $this->wilayah_model->get_dusun_maps($id_kecamatan);
		$data['wil_ini'] = $this->wilayah_model->get_rw_maps($kecamatan, $rw);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = 'RW '.$data['wil_ini']['rw']." ".ucwords($sebutan_dusun." ".$data['wil_ini']['dusun']);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$sebutan_dusun),
			array('link' => site_url("sid_core/sub_rw/$id_kecamatan"), 'judul' => 'Daftar RW')
		);
		$data['wilayah'] = 'RW';
		$data['form_action'] = site_url("sid_core/update_wilayah_rw_map/$id_kecamatan/$id_rw");
		$data['logo'] = $this->config_model->get_data();

		if (!empty($data['wil_atas']['path'] && !empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng']))))
		{
			$this->render("sid/wilayah/maps_google_wilayah", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_dusun $kecamatan Belum Dilengkapi";
			redirect("sid_core/sub_rw/$id_kecamatan");
		}
	}

	public function update_kantor_rw_map($id_kecamatan = '', $id_rw = '')
	{
		$this->wilayah_model->update_kantor_rw_map($id_rw);
		redirect("sid_core/sub_rw/$id_kecamatan");
	}

	public function update_wilayah_rw_map($id_kecamatan = '', $rw = '')
	{
		$this->wilayah_model->update_wilayah_rw_map($id_rw);
		redirect("sid_core/sub_rw/$id_kecamatan");
	}

	public function ajax_kantor_rt_maps($id_kecamatan = '', $id_rw ='', $id ='')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$kecamatan = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;
		$temp_rw = $this->wilayah_model->cluster_by_id($id_rw);
		$rw = $temp_rw['rw'];

		$sebutan_wilayah = ucwords($this->setting->sebutan_wilayah);
		$data['wil_atas'] = $this->wilayah_model->get_dusun_maps($id_kecamatan);
		$data_rw = $this->wilayah_model->get_rw_maps($kecamatan, $rw);
		$data['wil_ini'] = $this->wilayah_model->get_rt_maps($id);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = 'RT '.$data['wil_ini']['rt'].' RW '.$data['wil_ini']['rw'].' '.ucwords($sebutan_wilayah." ".$data['wil_ini']['dusun']);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$sebutan_wilayah),
			array('link' => site_url("sid_core/sub_rw/$id_kecamatan"), 'judul' => 'Daftar RW'),
			array('link' => site_url("sid_core/sub_rt/$id_kecamatan/$id_rw"), 'judul' => 'Daftar RT')
		);

		$data['wilayah'] = 'RT';
		$data['form_action'] = site_url("sid_core/update_wilayah_rt_map/$id_kecamatan/$id_rw/$id");
		$data['logo'] = $this->config_model->get_data();

		if (!empty($data['wil_atas']['path'] && !empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng']))))
		{
			$this->render("sid/wilayah/maps_google_kantor", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Lokasi Kantor $sebutan_wilayah $kecamatan Belum Dilengkapi";
			redirect("sid_core/sub_rt/$id_kecamatan/$id_rw");
		}
	}

	public function ajax_wilayah_rt_google_maps($id_kecamatan = '', $id_rw ='', $id ='')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$kecamatan = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;

		$sebutan_dusun = ucwords($this->setting->sebutan_dusun);
		$data['wil_atas'] = $this->wilayah_model->get_dusun_maps($id_kecamatan);
		$data_rw = $this->wilayah_model->get_rw_maps($kecamatan, $rw);
		$data['wil_ini'] = $this->wilayah_model->get_rt_maps($id);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = 'RT '.$data['wil_ini']['rt'].' RW '.$data['wil_ini']['rw'].' '.ucwords($sebutan_dusun." ".$data['wil_ini']['dusun']);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$sebutan_dusun),
			array('link' => site_url("sid_core/sub_rw/$id_kecamatan"), 'judul' => 'Daftar RW'),
			array('link' => site_url("sid_core/sub_rt/$id_kecamatan/$id_rw"), 'judul' => 'Daftar RT')
		);
		$data['wilayah'] = 'RT';
		$data['form_action'] = site_url("sid_core/update_wilayah_rt_map/$id_kecamatan/$id_rw/$id");
		$data['logo'] = $this->config_model->get_data();

		if (!empty($data['wil_atas']['path'] && !empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng']))))
		{
			$this->render("sid/wilayah/maps_google_wilayah", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_dusun $kecamatan Belum Dilengkapi";
			redirect("sid_core/sub_rt/$id_kecamatan/$id_rw");
		}
	}
	
	public function ajax_wilayah_rt_openstreet_maps($id_kecamatan = '', $id_rw ='', $id ='')
	{
		$temp = $this->wilayah_model->cluster_by_id($id_kecamatan);
		$kecamatan = $temp['kecamatan'];
		$data['id_kecamatan'] = $id_kecamatan;

		$sebutan_dusun = ucwords($this->setting->sebutan_dusun);
		$data['wil_atas'] = $this->wilayah_model->get_dusun_maps($id_kecamatan);
		$data_rw = $this->wilayah_model->get_rw_maps($kecamatan, $rw);
		$data['wil_ini'] = $this->wilayah_model->get_rt_maps($id);
		$data['dusun_gis'] = $this->wilayah_model->list_dusun();
		$data['rw_gis'] = $this->wilayah_model->list_rw_gis();
		$data['rt_gis'] = $this->wilayah_model->list_rt_gis();
		$data['nama_wilayah'] = 'RT '.$data['wil_ini']['rt'].' RW '.$data['wil_ini']['rw'].' '.ucwords($sebutan_dusun." ".$data['wil_ini']['dusun']);
		$data['breadcrumb'] = array(
			array('link' => site_url('sid_core'), 'judul' => "Daftar ".$sebutan_dusun),
			array('link' => site_url("sid_core/sub_rw/$id_kecamatan"), 'judul' => 'Daftar RW'),
			array('link' => site_url("sid_core/sub_rt/$id_kecamatan/$id_rw"), 'judul' => 'Daftar RT')
		);
		$data['wilayah'] = 'RT';
		$data['form_action'] = site_url("sid_core/update_wilayah_rt_map/$id_kecamatan/$id_rw/$id");
		$data['logo'] = $this->config_model->get_data();

		if (!empty($data['wil_atas']['path'] && !empty($data['wil_atas']['lat'] && !empty($data['wil_atas']['lng']))))
		{
			$this->render("sid/wilayah/maps_openstreet_wilayah", $data);
		}
		else
		{
			$_SESSION['success'] = -1;
			$_SESSION['error_msg'] = "Peta Lokasi/Wilayah $sebutan_dusun $kecamatan Belum Dilengkapi";
			redirect("sid_core/sub_rt/$id_kecamatan/$id_rw");
		}
	}

	public function update_kantor_rt_map($id_kecamatan = '', $id_rw ='', $id ='')
	{
		$this->wilayah_model->update_kantor_rt_map($id);
		redirect("sid_core/sub_rt/$id_kecamatan/$id_rw");
	}

	public function update_wilayah_rt_map($id_kecamatan = '', $id_rw ='', $id ='')
	{
		$this->wilayah_model->update_wilayah_rt_map($id);
		redirect("sid_core/sub_rt/$id_kecamatan/$id_rw");
	}
}
