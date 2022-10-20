<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function autocomplete()
	{
		return $this->autocomplete_str('kecamatan', 'tweb_wilayah');
	}

	private function search_sql()
	{
		if (isset($_SESSION['cari']))
		{
			$cari = $this->db->escape_like_str($_SESSION['cari']);
			$kw = $this->db->escape_like_str($cari);
			$kw = '%' .$kw. '%';
			$search_sql= " AND u.kecamatan LIKE '$kw'";
			return $search_sql;
		}
	}

	public function paging($p = 1, $o = 0)
	{
		$sql = "SELECT COUNT(*) AS jml " . $this->list_data_sql();
		$query = $this->db->query($sql);
		$row = $query->row_array();
		$jml_data = $row['jml'];

		$this->load->library('paging');
		$cfg['page'] = $p;
		$cfg['per_page'] = $_SESSION['per_page'];
		$cfg['num_rows'] = $jml_data;
		$this->paging->init($cfg);

		return $this->paging;
	}

	private function list_data_sql()
	{
		$sql = " FROM tweb_wilayah u
			LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id
			WHERE u.desa = '0' AND u.dusun = '0' AND u.rw = '0' AND u.rt = '0'";
		$sql .= $this->search_sql();
		return $sql;
	}

	/*
		Struktur tweb_wilayah:
		- baris dengan kolom  rt = '0' dan  rw = '0' dan dusun = '0' dan desa = '0' menunjukkan kecamatan
		- baris dengan kolom dusun = '-' dan desa <> '-' menunjukkan desa
		- baris dengan kolom dusun <> '0' dan dusun <> '0' menunjukkan dusun

		Di tabel penduduk_hidup  dan keluarga_aktif, kolom id_cluster adalah id untuk
		baris dusun.
	*/
	public function list_data($o = 0, $offset = 0, $limit = 500)
	{
		$paging_sql = ' LIMIT ' .$offset. ',' .$limit;

		$select_sql = "SELECT u.*, a.nama AS nama_camat, a.nik AS nik_camat,
		
		(SELECT COUNT(desa.id) FROM tweb_wilayah desa WHERE kecamatan <> '-' AND kecamatan <> '0' AND desa <> '-' AND desa <> '0' AND dusun = '0' AND rw = '0' AND rt = '0') AS jumlah_desa,
		
		(SELECT COUNT(dusun.id) FROM tweb_wilayah dusun WHERE kecamatan <> '-' AND kecamatan <> '0' AND desa <> '-' AND desa <> '0' AND dusun <> '0' AND dusun <> '-' AND rw = '0' AND rt = '0') AS jumlah_dusun,
		
		(SELECT COUNT(rw.id) FROM tweb_wilayah rw WHERE kecamatan <> '-' AND kecamatan <> '0' AND desa <> '-' AND desa <> '0' AND dusun <> '0' AND dusun <> '-' AND rw <> '0' AND rw <> '-' AND rt = '0') AS jumlah_rw,
		
		(SELECT COUNT(rt.id) FROM tweb_wilayah rt WHERE kecamatan <> '-' AND kecamatan <> '0' AND desa <> '-' AND desa <> '0' AND dusun <> '0' AND dusun <> '-' AND rw <> '0' AND rw <> '-' AND rt <> '0' AND rt <> '-') AS jumlah_rt,	

		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = u.kecamatan)) AS jumlah_warga,
		
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = u.kecamatan) AND p.sex = 1) AS jumlah_warga_l,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = u.kecamatan) AND p.sex = 2) AS jumlah_warga_p,
		(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id  WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = u.kecamatan) AND p.kk_level = 1) AS jumlah_kk ";
		$sql = $select_sql . $this->list_data_sql();
		$sql .= $paging_sql;

		$query = $this->db->query($sql);
		$data = $query->result_array();

		//Formating Output
		$j = $offset;
		for ($i=0; $i<count($data); $i++)
		{
			$data[$i]['no'] = $j + 1;
			$j++;
		}
		return $data;
	}

	public function list_semua_wilayah()
	{
		$this->case_kecamatan = "w.desa = '0' and w.dusun = '0' and w.rw = '0' and w.rt = '0'";
		$this->case_desa = "w.desa <> '0' and w.desa <> '-' and w.dusun = '0' and w.rw = '0' and w.rt = '0'";
		$this->case_dusun = "w.desa <> '0' and w.desa <> '-' and w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' and w.rt = '0'";
		$this->case_rw = "w.desa <> '0' and w.desa <> '-' and w.dusun <> '0' and w.dusun <> '-' and w.rw <> '0'and w.rw <> '-' and w.rt = '0'";
		$this->case_rt = "w.desa <> '0' and w.desa <> '-' and w.dusun <> '0' and w.dusun <> '-' and w.rw <> '0'and w.rw <> '-' and w.rt <> '0'and w.rt <> '-'";

		$this->select_jumlah_desa_dusun();
		$this->select_jumlah_warga();
		$this->select_jumlah_kk();

		$data = $this->db
			->select('w.*, p.nama AS nama_kepala, p.nik AS nik_kepala')
			->select("(CASE WHEN w.desa = '0' THEN '' ELSE w.desa END) AS desa")
			->select("(CASE WHEN w.dusun = '0' THEN '' ELSE w.dusun END) AS dusun")
			->select("(CASE WHEN w.rw = '0' THEN '' ELSE w.rw END) AS rw")
			->select("(CASE WHEN w.rt = '0' THEN '' ELSE w.rt END) AS rt")
			->from('tweb_wilayah w')
			->join('penduduk_hidup p', 'w.id_kepala = p.id', 'left')

			->group_start()
				->where("w.desa = '0' and w.dusun = '0' and w.rw = '0' and w.rt = '0'")
				->or_where("w.desa <> '-' and w.desa <> '0' and w.dusun = '0' and w.rw = '0' and w.rt = '0'")
				->or_where("w.dusun <> '0' and w.dusun <> '-'")
				->or_where("w.kecamatan <> '0' and w.kecamatan <> '-'")
			->group_end()

			->order_by('w.kecamatan, w.desa, w.dusun, w.rw, w.rt')
			->get()
			->result_array();
		return $data;
	}

	private function select_jumlah_desa_dusun()
	{
		$this->db
			->select("(CASE
				WHEN ".$this->case_kecamatan." THEN (SELECT COUNT(id) FROM tweb_wilayah WHERE kecamatan = w.kecamatan AND desa <> '-' AND dusun = '-')
				END) AS jumlah_desa");

		$this->db
			->select("(CASE
				WHEN ".$this->case_kecamatan." THEN (SELECT COUNT(id) FROM tweb_wilayah WHERE kecamatan = w.kecamatan AND dusun <> '0' AND dusun <> '-')
				WHEN ".$this->case_desa." THEN (SELECT COUNT(id) FROM tweb_wilayah WHERE kecamatan = w.kecamatan AND desa = w.desa AND dusun <> '0' AND dusun <> '-')
				END) AS jumlah_rt");
	}

	private function select_jumlah_warga()
	{
		$this->db
			->select("(CASE
				WHEN ".$this->case_kecamatan." THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = w.kecamatan))
				WHEN ".$this->case_desa." THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = w.kecamatan and desa = w.desa))
				WHEN ".$this->case_dusun." THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster = w.id)
				END) AS jumlah_warga");

		$this->db
			->select("(CASE
				WHEN ".$this->case_kecamatan." THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = w.kecamatan) AND p.sex = 1)
				WHEN ".$this->case_desa." THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = w.kecamatan and desa = w.desa) AND p.sex = 1)
				WHEN ".$this->case_dusun." THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster = w.id and p.sex = 1)
				END) AS jumlah_warga_l");

		$this->db
			->select("(CASE
				WHEN ".$this->case_kecamatan." THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = w.kecamatan) AND p.sex = 2)
				WHEN ".$this->case_desa." THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = w.kecamatan and desa = w.desa) AND p.sex = 2)
				WHEN ".$this->case_dusun." THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster = w.id and p.sex = 2)
				END) AS jumlah_warga_p");
	}

	private function select_jumlah_kk()
	{
		$this->db
			->select("(CASE
				WHEN ".$this->case_kecamatan." THEN (SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = w.kecamatan) AND p.kk_level = 1)
				WHEN ".$this->case_desa." THEN (SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = w.kecamatan and desa = w.desa) AND p.kk_level = 1)
				WHEN ".$this->case_dusun." THEN (SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id WHERE p.id_cluster = w.id AND p.kk_level = 1)
				END) AS jumlah_kk ");
	}

	private function bersihkan_data($data)
	{
		if (empty((int)$data['id_kepala']))
			unset($data['id_kepala']);
		$data['kecamatan'] = nama_terbatas($data['kecamatan']) ?: 0;
		$data['kode_kecamatan'] = bilangan($data['kode_kecamatan']) ?: 0;
		$data['desa'] = nama_terbatas($data['desa']) ?: 0;
		$data['kode_desa'] = bilangan($data['kode_desa']) ?: 0;
		$data['dusun'] = nama_terbatas($data['dusun']) ?: 0;
		$data['rw'] = bilangan($data['rw']) ?: 0;
		$data['rt'] = bilangan($data['rt']) ?: 0;
		return $data;
	}

	private function cek_data($table, $data = [])
	{
		$count = $this->db->get_where($table, $data)->num_rows();
		return $count;
	}

	public function insert_kecamatan()
	{
		$data = $this->bersihkan_data($this->input->post());
		$wil = array('kecamatan' => $data['kecamatan']);
		$cek_data = $this->cek_data('tweb_wilayah', $wil);
		if ($cek_data)
		{
			$_SESSION['success'] = -2;
			return;
		}
		$this->db->insert('tweb_wilayah', $data);

		$desa = $data;
		$desa['desa'] = "-";
		$this->db->insert('tweb_wilayah', $desa);

		$dusun = $desa;
		$dusun['dusun'] = "-";
		$outp = $this->db->insert('tweb_wilayah', $dusun);
		
		$rw = $dusun;
		$rw['rw'] = "-";
		$outp = $this->db->insert('tweb_wilayah', $rw);
		
		$rt = $rw;
		$rt['rt'] = "-";
		$outp = $this->db->insert('tweb_wilayah', $rt);
		status_sukses($outp); //Tampilkan Pesan
	}

	public function update_kecamatan($id = 0)
	{
		$data = $this->bersihkan_data($this->input->post());
		$wil = array('kecamatan' => $data['kecamatan'], 'desa' => '0', 'dusun' => '0', 'rw' => '0', 'rt' => '0', 'id <>' => $id);
		$cek_data = $this->cek_data('tweb_wilayah', $wil);
		if ($cek_data)
		{
			$_SESSION['success'] = -2;
			return;
		}
		$temp = $this->wilayah_model->cluster_by_id($id);
		$this->db->where('kecamatan',$temp['kecamatan']);
		$this->db->where('desa', '0');
		$this->db->where('dusun', '0');
		$this->db->where('rw', '0');
		$this->db->where('rt', '0');
		$outp1 = $this->db->update('tweb_wilayah', $data);

		// Ubah nama kecamatan di semua baris desa/dusun untuk kecamatan ini
		$outp2 = $this->db->where('kecamatan', $temp['kecamatan'])->
			update('tweb_wilayah', array('kecamatan' => $data['kecamatan']));

		if ( $outp1 AND $outp2) $_SESSION['success'] = 1;
		else $_SESSION['success'] = -1;
	}

	//Delete kecamatan/desa/dusun tergantung tipe
	public function delete($tipe = '', $id = '')
	{
		$this->session->success = 1;
		// Perlu hapus berdasarkan nama, supaya baris RW dan RT juga terhapus
		$temp = $this->cluster_by_id($id);
		$desa = $temp['desa'];
		$kecamatan = $temp['kecamatan'];

		switch ($tipe)
		{
			case 'kecamatan':
				$this->db->where('kecamatan', $kecamatan);
				break; //kecamatan
			case 'desa':
				$this->db->where('desa', $desa)->where('kecamatan', $kecamatan);
				break; //desa
			default:
				$this->db->where('id', $id);
				break; //dusun
		}

		$outp = $this->db->delete('tweb_wilayah');

		status_sukses($outp, $gagal_saja=true); //Tampilkan Pesan
	}

	//Bagian RW
	public function list_data_desa($id = '')
	{
		$temp = $this->cluster_by_id($id);
		$kecamatan = $temp['kecamatan'];

		$sql = "SELECT u.*, a.nama AS nama_kepala, a.nik AS nik_kepala,
		(SELECT COUNT(dusun.id) FROM tweb_wilayah dusun WHERE kecamatan = u.kecamatan AND desa = u.desa AND dusun <> '-' AND dusun <> '0' ) AS jumlah_dusun,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = u.desa)) AS jumlah_warga,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = u.desa) AND p.sex = 1) AS jumlah_warga_l,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = u.desa) AND p.sex = 2) AS jumlah_warga_p,
		(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id  WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = u.desa) AND p.kk_level = 1) AS jumlah_kk
		FROM tweb_wilayah u
		LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id
		WHERE u.rt = '0' AND u.rw = '0' AND u.dusun = '0' AND u.desa <> '0' AND u.desa <> '-' AND u.kecamatan = '$kecamatan'";
		$query = $this->db->query($sql);
		$data = $query->result_array();

		//Formating Output
		for ($i=0; $i<count($data); $i++)
		{
			$data[$i]['no'] = $i + 1;
		}
		return $data;
	}

	public function insert_desa($id_kecamatan = '')
	{
		$data = $this->bersihkan_data($this->input->post());
		$temp = $this->cluster_by_id($id_kecamatan);
		$data['kecamatan']= $temp['kecamatan'];
		
		$wil = array('kecamatan' => $data['kecamatan'], 'desa' => $data['desa']);
		$cek_data = $this->cek_data('tweb_wilayah', $wil);
		
		if ($cek_data)
		{
			$_SESSION['success'] = -2;
			return;
		}
		$outp1 = $this->db->insert('tweb_wilayah', $data);

		$dusun = $data;
		$dusun['dusun'] = "-";
		$outp2 = $this->db->insert('tweb_wilayah', $dusun);
		
		$rw = $dusun;
		$rw['rw'] = "-";
		$outp2 = $this->db->insert('tweb_wilayah', $rw);

		$rt = $rw;
		$rt['rt'] = "-";
		$outp2 = $this->db->insert('tweb_wilayah', $rt);
		status_sukses($outp1 & $outp2); //Tampilkan Pesan
	}
	
	public function insert_dusun($id_kecamatan = '', $id_desa = '')
	{
		$data = $this->bersihkan_data($this->input->post());
		$temp = $this->cluster_by_id($id_kecamatan);
		$data['kecamatan']= $temp['kecamatan'];
		
		$temp = $this->cluster_by_id($id_desa);
		$data['desa']= $temp['desa'];

		$wil = array('kecamatan' => $data['kecamatan'], 'desa' => $data['desa'], 'dusun' => $data['dusun']);
		$cek_data = $this->cek_data('tweb_wilayah', $wil);
		if ($cek_data)
		{
			$_SESSION['success'] = -2;
			return;
		}
		$outp1 = $this->db->insert('tweb_wilayah', $data);

		
		$rw = $data;
		$rw['rw'] = "-";
		$outp2 = $this->db->insert('tweb_wilayah', $rw);

		$rt = $rw;
		$rt['rt'] = "-";
		$outp2 = $this->db->insert('tweb_wilayah', $rt);
		status_sukses($outp1 & $outp2); //Tampilkan Pesan
	}

	public function update_desa($id_desa = '')
	{
		$data = $this->bersihkan_data($this->input->post());
		$temp = $this->wilayah_model->cluster_by_id($id_desa);
		$wil = array('kecamatan' => $temp['kecamatan'], 'desa' => $data['desa'], 'dusun' => '0', 'id <>' => $id_desa);
		unset($data['id_desa']);
		$cek_data = $this->cek_data('tweb_wilayah', $wil);
		if ($cek_data)
		{
			$_SESSION['success'] = -2;
			return;
		}
		// Update data RW
		$data['kecamatan'] = $temp['kecamatan'];
		$outp1 = $this->db->where('id', $id_desa)
			->update('tweb_wilayah', $data);
		// Update nama RW di semua RT untuk RW ini
		$outp2 = $this->db->where('desa', $temp['desa'])
			->update('tweb_wilayah', array('desa' => $data['desa']));
		status_sukses($outp1 and $outp2); //Tampilkan Pesan
	}

	//Bagian DUSUN
	public function list_data_dusun($kecamatan = '', $desa = '', $dusun = '')
	{
		$sql = "SELECT u.*, a.nama AS nama_kadus, a.nik AS nama_kadus,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun)) AS jumlah_warga,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.sex = 1) AS jumlah_warga_l,(
		SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.sex = 2) AS jumlah_warga_p,
		(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id  WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.kk_level = 1) AS jumlah_kk
		FROM tweb_wilayah u
		LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id
		WHERE u.kecamatan = '$kecamatan' AND u.desa = '$desa' AND u.dusun <> '0' AND u.dusun <> '-' AND u.rw = '0' AND u.rt = '0'
		ORDER BY u.dusun";

		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
		
		//Formating Output
		for ($i=0; $i<count($data); $i++)
		{
			$data[$i]['no'] = $i + 1;
		}
		return $data;
	}


	public function update_dusun($id=0)
	{
		$data = $this->bersihkan_data($this->input->post());
		$rt_lama = $this->db->where('id', $id)->get('tweb_wilayah')->row_array();
		$wil = array('kecamatan' => $rt_lama['kecamatan'], 'desa' => $rt_lama['desa'], 'dusun' => $data['dusun'], 'id <>' => $id);
		$cek_data = $this->cek_data('tweb_wilayah', $wil);
		if ($cek_data)
		{
			$_SESSION['success'] = -2;
			return;
		}
		$data['kecamatan'] = $rt_lama['kecamatan'];
		$data['desa'] = $rt_lama['desa'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wilayah', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	//Bagian RW
	public function list_data_rw($kecamatan = '', $desa = '', $dusun = '', $rw = '')
	{
		$sql = "SELECT u.*, a.nama AS nama_kadus, a.nik AS nama_kadus,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun)) AS jumlah_warga,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.sex = 1) AS jumlah_warga_l,(
		SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.sex = 2) AS jumlah_warga_p,
		(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id  WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.kk_level = 1) AS jumlah_kk
		FROM tweb_wilayah u
		LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id
		WHERE u.kecamatan = '$kecamatan' AND u.desa = '$desa' AND u.dusun = '$dusun' AND u.rw <> '0' AND u.rw <> '-' AND u.rt = '0'
		ORDER BY u.rw";

		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
		
		//Formating Output
		for ($i=0; $i<count($data); $i++)
		{
			$data[$i]['no'] = $i + 1;
		}
		return $data;
	}
	
	public function insert_rw($dusun = '')
	{
		$data = $this->bersihkan_data($this->input->post());
		$temp = $this->cluster_by_id($dusun);
		$data['dusun']= $temp['dusun'];
		
		$wil = array('dusun' => $data['dusun'], 'rw' => $data['rw']);
		$cek_data = $this->cek_data('tweb_wilayah', $wil);
		
		if ($cek_data)
		{
			$_SESSION['success'] = -2;
			return;
		}
		$outp1 = $this->db->insert('tweb_wilayah', $data);

		$rt = $data;
		$rt['rt'] = "-";
		$outp2 = $this->db->insert('tweb_wilayah', $rt);

		status_sukses($outp1 & $outp2); //Tampilkan Pesan
	}

	public function update_rw($id_rw = '')
	{
		$data = $this->bersihkan_data($this->input->post());
		$temp = $this->wilayah_model->cluster_by_id($id_rw);
		$wil = array('dusun' => $temp['dusun'], 'rw' => $data['rw'], 'rt' => '0', 'id <>' => $id_rw);
		unset($data['id_rw']);
		$cek_data = $this->cek_data('tweb_wilayah', $wil);
		if ($cek_data)
		{
			$_SESSION['success'] = -2;
			return;
		}
		// Update data RW
		$data['dusun'] = $temp['dusun'];
		$outp1 = $this->db->where('id', $id_rw)
			->update('tweb_wilayah', $data);
		// Update nama RW di semua RT untuk RW ini
		$outp2 = $this->db->where('rw', $temp['rw'])
			->update('tweb_wilayah', array('rw' => $data['rw']));
		status_sukses($outp1 and $outp2); //Tampilkan Pesan
	}

	public function list_penduduk()
	{
		$data = $this->db->select('p.id, p.nik, p.nama, c.kecamatan')
			->from('penduduk_hidup p')
			->join('tweb_wilayah c', 'p.id_cluster = c.id', 'left')
			->where('p.id NOT IN (SELECT c.id_kepala FROM tweb_wilayah c WHERE c.id_kepala != 0)')
			->get()->result_array();
		return $data;
	}

	public function get_penduduk($id = 0)
	{
		$sql = "SELECT id,nik,nama FROM penduduk_hidup WHERE id = ?";
		$query = $this->db->query($sql, $id);
		$data = $query->row_array();
		return $data;
	}

	public function cluster_by_id($id = 0)
	{
		$data = $this->db->where('id', $id)
			->get('tweb_wilayah')
			->row_array();
		return $data;
	}

	public function list_kecamatan()
	{
		$data = $this->db
			->where('desa', '0')
			->where('dusun', '0')
			->where('rw', '0')
			->where('rt', '0')
			->get('tweb_wilayah')
			->result_array();

		return $data;
	}

	public function list_desa($kecamatan = '')
	{
		$data = $this->db
			->where('dusun', '0')
			->where('kecamatan', urldecode($kecamatan))
			->where('desa <>', '0')
			->order_by('desa')
			->get('tweb_wilayah')
			->result_array();

		return $data;
	}

	public function list_dusun($kecamatan = '', $desa = '')
	{
		$data = $this->db
			->where('dusun <>', '0')
			->where('kecamatan', urldecode($kecamatan))
			->where('desa', urldecode($desa))
			->order_by('dusun')
			->get('tweb_wilayah')
			->result_array();

		return $data;
	}

	public function list_rw($kecamatan = '', $desa = '', $dusun = '' )
	{
		$data = $this->db
			->where('rw <>', '0')
			->where('kecamatan', urldecode($kecamatan))
			->where('desa', urldecode($desa))
			->where('dusun', urldecode($dusun))
			->order_by('rw')
			->get('tweb_wilayah')
			->result_array();

		return $data;
	}
	
	public function list_rt($kecamatan = '', $desa = '', $dusun = '', $rw = '' )
	{
		$data = $this->db
			->where('rt <>', '0')
			->where('kecamatan', urldecode($kecamatan))
			->where('desa', urldecode($desa))
			->where('dusun', urldecode($dusun))
			->where('rw', urldecode($rw))
			->order_by('rt')
			->get('tweb_wilayah')
			->result_array();

		return $data;
	}

	public function get_dusun($kecamatan = '', $desa = '', $dusun = '')
	{
		$sql = "SELECT * FROM tweb_wilayah WHERE kecamatan = ? AND desa = ? AND dusun = ?";
		$query = $this->db->query($sql, array($kecamatan, $desa, $dusun));
		return $query->row_array();
	}

	public function total()
	{
		$sql = "SELECT
		(SELECT COUNT(desa.id) FROM tweb_wilayah desa WHERE  desa <> '-' AND dusun = '-') AS total_desa,
		(SELECT COUNT(dusun.id) FROM tweb_wilayah dusun WHERE dusun.dusun <> '0' AND dusun.dusun <> '-' AND rw = '0' AND rt = '0') AS total_dusun,
		(SELECT COUNT(dusun.id) FROM tweb_wilayah dusun WHERE dusun.dusun <> '0' AND dusun.dusun <> '-' AND rw = '0' AND rt = '0') AS total_rw,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah)) AS total_warga,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah) AND p.sex = 1) AS total_warga_l,
		(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah) AND p.sex = 2) AS total_warga_p,
		(SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah) AND p.kk_level = 1) AS total_kk
		FROM tweb_wilayah u
		LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id WHERE u.dusun = '0' AND u.desa = '0' limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function total_desa($kecamatan = '')
	{
		$sql = "SELECT sum(jumlah_rt) AS jmlrt, sum(jumlah_warga) AS jmlwarga, sum(jumlah_warga_l) AS jmlwargal, sum(jumlah_warga_p) AS jmlwargap, sum(jumlah_kk) AS jmlkk
			FROM
			(SELECT u.*, a.nama AS nama_ketua, a.nik AS nik_ketua,
				(SELECT COUNT(dusun.id) FROM tweb_wilayah dusun WHERE kecamatan = u.kecamatan AND desa = u.desa AND dusun <> '-' AND dusun <> '0' ) AS jumlah_rt,
				(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = u.desa )) AS jumlah_warga,
				(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = u.desa) AND p.sex = 1) AS jumlah_warga_l,
				(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = u.desa) AND p.sex = 2) AS jumlah_warga_p,
				(SELECT COUNT(p.id) FROM  keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id   WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = u.desa) AND p.kk_level = 1) AS jumlah_kk
				FROM tweb_wilayah u
				LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id
				WHERE u.dusun = '0' AND u.desa <> '0' AND u.kecamatan = '$kecamatan') AS x ";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;
	}

	public function total_dusun($kecamatan = '', $desa = '')
	{
		$sql = "SELECT sum(jumlah_warga) AS jmlwarga, sum(jumlah_warga_l) AS jmlwargal, sum(jumlah_warga_p) AS jmlwargap, sum(jumlah_kk) AS jmlkk
			FROM
				(SELECT u.*, a.nama AS nama_ketua,a.nik AS nik_ketua,
					(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun)) AS jumlah_warga,
					(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.sex = 1) AS jumlah_warga_l,
					(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.sex = 2) AS jumlah_warga_p,
					(SELECT COUNT(p.id) FROM  keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id   WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.kk_level = 1) AS jumlah_kk
					FROM tweb_wilayah u
					LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id
					WHERE rt = '0' AND rw = '0' AND u.dusun <> '0' AND u.dusun <> '-' AND u.desa = '$desa' AND u.kecamatan = '$kecamatan') AS x  ";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;
	}

	public function total_rw($kecamatan = '', $desa = '', $dusun = '')
	{
		$sql = "SELECT sum(jumlah_warga) AS jmlwarga, sum(jumlah_warga_l) AS jmlwargal, sum(jumlah_warga_p) AS jmlwargap, sum(jumlah_kk) AS jmlkk
			FROM
				(SELECT u.*, a.nama AS nama_ketua,a.nik AS nik_ketua,
					(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun)) AS jumlah_warga,
					(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.sex = 1) AS jumlah_warga_l,
					(SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.sex = 2) AS jumlah_warga_p,
					(SELECT COUNT(p.id) FROM  keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala=p.id   WHERE p.id_cluster IN(SELECT id FROM tweb_wilayah WHERE kecamatan = '$kecamatan' AND desa = '$desa' AND dusun = u.dusun) AND p.kk_level = 1) AS jumlah_kk
					FROM tweb_wilayah u
					LEFT JOIN penduduk_hidup a ON u.id_kepala = a.id
					WHERE u.rt <> '0' AND u.rw <> '0' AND u.dusun = '$dusun' AND u.desa = '$desa' AND u.kecamatan = '$kecamatan') AS x ";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;
	}

	private function validasi_koordinat($post)
	{
		$data['id'] = $post['id'];
		$data['zoom'] = $post['zoom'];
		$data['map_tipe'] = $post['map_tipe'];
		$data['lat'] = koordinat($post['lat']) ?: NULL;
		$data['lng'] = koordinat($post['lng']) ?: NULL;
		return $data;
	}

	public function update_kantor_kecamatan_map($id = 0)
	{
		$data = $this->validasi_koordinat($this->input->post());
		$id = $data['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wilayah', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function update_wilayah_kecamatan_map($id = 0)
	{
		$data = $_POST;
		$id = $_POST['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wilayah', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function update_kantor_desa_map($id = 0)
	{
		$data = $this->validasi_koordinat($this->input->post());
		$id = $data['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wilayah', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function update_wilayah_desa_map($id = 0)
	{
		$data = $_POST;
		$id = $_POST['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wilayah', $data);

		status_sukses($outp); //Tampilkan Pesan
	}
	
	public function get_kecamatan_maps($id_kecamatan)
	{
		$data = $this->db->where('id', $id_kecamatan)
			->get('tweb_wilayah')
			->row_array();
		return $data;
	}


	public function get_desa_maps($kecamatan = '', $desa = '')
	{
		$sql = "SELECT * FROM tweb_wilayah WHERE kecamatan = ? AND desa = ?";
		$query = $this->db->query($sql, array($kecamatan, $desa));
		return $query->row_array();
	}
	
	public function get_dusun_maps($kecamatan = '', $desa = '', $dusun = '')
	{
		$sql = "SELECT * FROM tweb_wilayah WHERE kecamatan = ? AND desa = ? AND dusun = ?";
		$query = $this->db->query($sql, array($kecamatan, $desa, $dusun));
		return $query->row_array();
	}

	public function get_rw_maps($rw_id)
	{
		$data = $this->db->where('id', $rw_id)
			->get('tweb_wilayah')
			->row_array();
		return $data;
	}
	
	public function get_rt_maps($rt_id)
	{
		$data = $this->db->where('id', $rt_id)
			->get('tweb_wilayah')
			->row_array();
		return $data;
	}
	

	public function update_kantor_rt_map($id = 0)
	{
		$data = $this->validasi_koordinat($this->input->post());
		$id = $data['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wilayah', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function update_wilayah_rt_map($id = 0)
	{
		$data = $_POST;
		$id = $_POST['id'];
		$this->db->where('id', $id);
		$outp = $this->db->update('tweb_wilayah', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	public function list_kecamatan_gis()
	{
		$data = $this->db->
			//where('kecamatan', urldecode($kecamatan))->
			where('kecamatan <>', '0')->
			where('desa', '0')->
			where('dusun', '0')->
			where('rw', '0')->
			where('rt', '0')->
			order_by('kecamatan')->
			get('tweb_wilayah')->
			result_array();
		return $data;
	}

	public function list_desa_gis($kecamatan = '')
	{
		$data = $this->db->
			//where('kecamatan', urldecode($kecamatan))->
			where('desa <>', '0')->
			where('dusun', '0')->
			where('rw', '0')->
			where('rt', '0')->
			order_by('desa')->
			get('tweb_wilayah')->
			result_array();
		return $data;
	}
	
	public function list_dusun_gis($kecamatan = '', $desa = '')
	{
		$data = $this->db->
			where('rw', '0')->
			//where('kecamatan', urldecode($kecamatan))->
			where('dusun <>', '0')->
			order_by('desa')->
			get('tweb_wilayah')->
			result_array();
		return $data;
	}
	
	public function list_rw_gis($kecamatan = '', $desa = '', $dusun = '')
	{
		$data = $this->db->
			where('rt', '0')->
			//where('kecamatan', urldecode($kecamatan))->
			where('rw <>', '0')->
			order_by('desa')->
			get('tweb_wilayah')->
			result_array();
		return $data;
	}

	public function list_rt_gis($kecamatan = '', $desa = '', $dusun = '', $rw = '')
	{
		$data = $this->db->
			where('dusun <>', '0')->
			//where('kecamatan', urldecode($kecamatan))->
			//where('desa', $desa)->
			order_by('dusun')->
			get('tweb_wilayah')->
			result_array();
		return $data;
	}

	// TO DO : Gunakan untuk get_alamat mendapatkan alamat penduduk
	public function get_alamat_wilayah($data)
	{
		$alamat_wilayah= "$data[alamat] RT $data[dusun] / RW $data[desa] ".ucwords(strtolower($this->setting->sebutan_kecamatan))." ".ucwords(strtolower($data['kecamatan']));

		return trim($alamat_wilayah);
	}

	public function get_alamat($id_penduduk)
	{
		$sebutan_kecamatan = ucwords($this->setting->sebutan_kecamatan);

		$data = $this->db
			->select("(
				case when (p.id_kk IS NULL or p.id_kk = 0)
					then
						case when (cp.kecamatan = '-' or cp.kecamatan = '')
							then CONCAT(COALESCE(p.alamat_sekarang, ''), ' RT ', cp.dusun, ' / RW ', cp.desa)
							else CONCAT(COALESCE(p.alamat_sekarang, ''), ' {$sebutan_kecamatan} ', cp.kecamatan, ' RT ', cp.dusun, ' / RW ', cp.desa)
						end
					else
						case when (ck.kecamatan = '-' or ck.kecamatan = '')
							then CONCAT(COALESCE(k.alamat, ''), ' RT ', ck.dusun, ' / RW ', ck.desa)
							else CONCAT(COALESCE(k.alamat, ''), ' {$sebutan_kecamatan} ', ck.kecamatan, ' RT ', ck.dusun, ' / RW ', ck.desa)
						end
				end) AS alamat")
			->from('tweb_penduduk p')
			->join('tweb_wilayah cp', 'p.id_cluster = cp.id', 'left')
			->join('tweb_keluarga k', 'p.id_kk = k.id', 'left')
			->join('tweb_wilayah ck', 'k.id_cluster = ck.id', 'left')
			->where('p.id', $id_penduduk)
			->get()
			->row_array();

		return $data['alamat'];
	}

}

?>
