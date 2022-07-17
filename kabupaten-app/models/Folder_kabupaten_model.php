<?php

class folder_kabupaten_model extends CI_Model {

/*
	Dimasukkan di autoload. Supaya folder desa dibuat secara otomatis menggunakan
	kabupaten-contoh apabila belum ada. Yaitu pada pertama kali menginstall SIDeGa.

	Perubahan folder desa pada setiap rilis dilakukan sebagai bagian dari
	Database > Migrasi DB.
*/
	public function __construct()
	{
		parent::__construct();
		$this->periksa_folder_desa();
	}

	public function periksa_folder_desa()
	{
		$this->salin_contoh();
	}

	private function salin_contoh()
	{
		if (!file_exists('kabupaten'))
		{
			mkdir('kabupaten');
			xcopy('kabupaten-contoh', 'kabupaten');
		}
	}

	public function amankan_folder_desa()
	{
		$this->salin_file('kabupaten', 'index.html', 'kabupaten-contoh/index.html');
		$this->salin_file('kabupaten/upload', '.htaccess', 'kabupaten-contoh/upload/media/.htaccess');
	}

	public function salin_file($cek, $cari, $contoh)
	{
		if (!file_exists("$cek/$cari")) copy($contoh, "$cek/$cari");

		foreach (glob("$cek/*", GLOB_ONLYDIR) as $folder)
		{
			$file = "$folder/$cari";

			if (!file_exists($file)) copy($contoh, $file);

			$this->salin_file($folder, $cari, $contoh);
		}
	}

}
