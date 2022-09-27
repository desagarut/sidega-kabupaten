<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends Admin_Controller {

	private $_set_page;
	private $_list_session;

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['pamong_model', 'penduduk_model', 'config_model', 'referensi_model', 'wilayah_model']);
		$this->modul_ini = 18;
		$this->sub_modul_ini = 200;
		$this->_set_page = ['20', '50', '100'];
		$this->_list_session = ['status', 'cari'];
	}

	public function clear()
	{
		$this->session->unset_userdata($this->_list_session);
		$this->session->per_page = $this->_set_page[0];
		redirect('pegawai');
	}

	public function index($p = 1)
	{
		$this->sub_modul_ini = 200;
		foreach ($this->_list_session as $list)
		{
				$data[$list] = $this->session->$list ?: '';
		}

		$per_page = $this->input->post('per_page');
		if (isset($per_page)) $this->session->per_page = $per_page;

		$data['func'] = 'index';
		$data['set_page'] = $this->_set_page;
		$data['per_page'] = $this->session->per_page;
		$data['paging'] = $this->pamong_model->paging($p);
		$data['main'] = $this->pamong_model->list_data($data['paging']->offset, $data['paging']->per_page);
		$data['keyword'] = $this->pamong_model->autocomplete();
		$data['main_content'] = 'beranda/pengurus';
		$data['subtitle'] = "Buku Aparat Pemerintah Desa";
		$data['selected_nav'] = 'aparat';
		$this->set_minsidebar(1);
		
		//$this->render('beranda/pegawai', $data);

		$this->load->view('header', $this->header);
		$this->load->view('nav');
		$this->load->view('bumindes/umum/main', $data);
		$this->load->view('footer');
	}

	public function form($id = 0)
	{
		$id_pend = $this->input->post('id_pend');

		if ($id)
		{
			$data['pamong'] = $this->pamong_model->get_data($id);
			if (!isset($id_pend)) $id_pend = $data['pamong']['id_pend'];
			$data['form_action'] = site_url("pegawai/update/$id");
		}
		else
		{
			$data['pamong'] = NULL;
			$data['form_action'] = site_url("pegawai/insert");
		}
		$data['atasan'] = $this->pamong_model->list_atasan($id);
		$data['penduduk'] = $this->pamong_model->list_penduduk();
		$data['pendidikan_kk'] = $this->referensi_model->list_data('tweb_penduduk_pendidikan_kk');
		$data['agama'] = $this->referensi_model->list_data('tweb_penduduk_agama');

		if (!empty($id_pend))
			$data['individu'] = $this->penduduk_model->get_penduduk($id_pend);
		else
			$data['individu'] = NULL;

		$this->render('home/pegawai_form', $data);
	}

	public function filter($filter)
	{
		$value = $this->input->post($filter);
		if ($value != '')
			$this->session->$filter = $value;
		else $this->session->unset_userdata($filter);
		redirect('pegawai');
	}

	public function insert()
	{
		$this->pamong_model->insert();
		redirect('pegawai');
	}

	public function update($id = 0)
	{
		$this->pamong_model->update($id);
		redirect('pegawai');
	}

	public function delete($id = 0)
	{
		$this->redirect_hak_akses('h', 'pegawai');
		$outp = $this->pamong_model->delete($id);
		redirect('pegawai');
	}

	public function delete_all()
	{
		$this->redirect_hak_akses('h', 'pegawai');
		$this->pamong_model->delete_all();
		redirect('pegawai');
	}

	public function ttd($id = 0, $val = 0)
	{
		$this->pamong_model->ttd('pamong_ttd', $id, $val);
		redirect('pegawai');
	}

	public function ub($id = 0, $val = 0)
	{
		$this->pamong_model->ttd('pamong_ub', $id, $val);
		redirect('pegawai');
	}

	public function urut($p = 1, $id = 0, $arah = 0)
	{
		$this->pamong_model->urut($id, $arah);
		redirect("pegawai/index/$p");
	}

	public function lock($id = 0, $val = 1)
	{
		$this->pamong_model->lock($id, $val);
		redirect("pegawai");
	}

	/*
	 * $aksi = cetak/unduh
	 */
	public function dialog($aksi = 'cetak')
	{
		$data['aksi'] = $aksi;
		$data['pamong'] = $this->pamong_model->list_data();
		$data['form_action'] = site_url("pegawai/daftar/$aksi");
		$this->load->view('global/ttd_pamong', $data);
	}

	/*
	 * $aksi = cetak/unduh
	 */
	public function daftar($aksi = 'cetak')
	{
		$data['pamong_ttd'] = $this->pamong_model->get_data($this->input->post('pamong_ttd'));
		$data['pamong_ketahui'] = $this->pamong_model->get_data($this->input->post('pamong_ketahui'));
		$data['kabupaten'] = $this->config_model->get_data();
		$data['main'] = $this->pamong_model->list_data();

		$this->load->view('home/'.$aksi, $data);
	}

	public function bagan($ada_bpd = '')
	{
		$data['kabupaten'] = $this->config_model->get_data();
		$data['bagan'] = $this->pamong_model->list_bagan();
		$data['ada_bpd'] = ! empty($ada_bpd);
		$this->render('home/bagan', $data);
	}

	public function atur_bagan()
	{
		$data['atasan'] = $this->pamong_model->list_atasan();
		$data['form_action'] = site_url("pegawai/update_bagan");
		$this->load->view('home/ajax_atur_bagan', $data);
	}

	public function update_bagan()
	{
		$post = $this->input->post();
		$this->pamong_model->update_bagan($post);
		redirect('pegawai');
	}

	public function atur_bagan_layout()
	{
		$data['judul'] = 'Atur Ukuran Bagan';
		$data['list_setting'] = 'list_setting_bagan';
		$this->setting_model->load_options();

		$this->load->view('home/ajax_atur_bagan_layout', $data);
	}
}
