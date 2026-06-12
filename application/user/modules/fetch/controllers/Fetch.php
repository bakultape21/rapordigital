<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fetch extends MX_Controller
{

	

	 public function get_kegiatan_rekomendasi()
    {
        // 1. Ambil kata kunci pencarian dari POST request.
        // Menggunakan Input Class dari CodeIgniter lebih aman.
        $query = $this->input->post('query', TRUE);

        // 2. Buat klausa WHERE untuk pencarian menggunakan LIKE.
        // Menggunakan escape_like_str untuk mencegah SQL Injection.
        // Asumsi nama tabel adalah 'nilai_kegiatan' dan kolomnya 'kegiatan_belajar'. 
        // Silakan sesuaikan jika berbeda.
        $where_e = "(kegiatan LIKE '%" . $this->db->escape_like_str($query) . "%')";

        // 3. Siapkan konfigurasi untuk query menggunakan model global Anda.
        $arr_config = [
            'table'     => 't_rekomendasi_kegiatan', // <-- SESUAIKAN NAMA TABEL ANDA
            'where_e'   => $where_e,
            // Ambil hanya nama kegiatan yang unik (DISTINCT) untuk menghindari duplikat.
            'select'    => 'kegiatan AS kegiatan_belajar',
            'show'      => 10, // Batasi hasil hanya 10 rekomendasi teratas.
            'array'     => true
        ];

        // 4. Eksekusi query menggunakan model global.
        $result = $this->m_global->get($arr_config);

		// echo $this->db->last_query(); exit;

        $data = [];
        if (!empty($result)) {
            foreach ($result as $val) {
                // Ambil nilai dari kolom 'kegiatan_belajar' dan masukkan ke array.
                $data[] = $val['kegiatan_belajar'];
            }
        }

        // 6. Atur header sebagai JSON dan kirim respons.
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(['item' => $data]));
    }

	public function get_kecamatan()
	{
		$q 				= @$_POST['q'];
		$where_e		= "( provinsi LIKE '%" . $q . "%' or kecamatan LIKE '%" . $q . "%' or kabupaten LIKE '%" . $q . "%' or k.kecamatan_id LIKE '%" . $q . "%' or k.kabupaten_id LIKE '%" . $q . "%' )";

		$arr_config = [
			'table' 	=> 'kecamatan k',
			'where_e' 	=> $where_e,
			'select' 	=> 'kecamatan_id id, concat( kecamatan, " - ", kabupaten, " -  ",provinsi) name',
			'join'		=> [['kabupaten kb', 'kb.kabupaten_id=k.kabupaten_id'],['provinsi p', 'p.provinsi_id=kb.provinsi_id']],
			'start'		=> 0,
			'show'		=> 10,
			'array' 	=> true
		];

		$result = $this->m_global->get($arr_config);

		$data = [];

		foreach ($result as $key => $val) {

			$data[$key] = ['id' => $val['id'], 'text' =>  $val['name']];
		}

		echo json_encode(['item' => $data]);
	}


	public function get_pekerjaan()
	{
		$q 				= @$_POST['q'];
		$where_e		= "( pekerjaan LIKE '%" . $q . "%' )";

		$arr_config = [
			'table' 	=> 't_pekerjaan p',
			'where_e' 	=> $where_e,
			'select' 	=> 'pekerjaan_id id, pekerjaan name',
			'start'		=> 0,
			'show'		=> 10,
			'array' 	=> true
		];

		$result = $this->m_global->get($arr_config);

		$data = [];

		foreach ($result as $key => $val) {

			$data[$key] = ['id' => $val['id'], 'text' =>  $val['name']];
		}

		echo json_encode(['item' => $data]);
	}
	public function get_siswa()
	{
		$q 				= @$_POST['q'];
		$where_e		= "( status_siswa= 0 and sekolah_id = '".login_data('sekolah_id')."' and (nama_lengkap LIKE '%" . $q . "%' or no_induk LIKE '%" . $q . "%') )";

		$arr_config = [
			'table' 	=> 't_siswa p',
			'where_e' 	=> $where_e,
			'select' 	=> 'siswa_id id, concat(no_induk, " - ", nama_lengkap) name',
			'start'		=> 0,
			'show'		=> 10,
			'array' 	=> true
		];

		$result = $this->m_global->get($arr_config);

		$data = [];

		foreach ($result as $key => $val) {

			$data[$key] = ['id' => $val['id'], 'text' =>  $val['name']];
		}

		echo json_encode(['item' => $data]);
	}

	public function get_siswa_kelas($kelas_id)
	{
		$q 				= @$_POST['q'];
		$where_e		= "(  kelas_id = '".$kelas_id."' and (nama_lengkap LIKE '%" . $q . "%' or no_induk LIKE '%" . $q . "%') )";

		$arr_config = [
			'table' 	=> 't_siswa p',
			'where_e' 	=> $where_e,
			'join'		=> [['t_kelas_belajar_data kd', 'kd.siswa_id= p.siswa_id']],
			'select' 	=> 'siswa_kelas_id id, concat(no_induk, " - ", nama_lengkap) name',
			'start'		=> 0,
			'show'		=> 10,
			'array' 	=> true
		];

		$result = $this->m_global->get($arr_config);

		$data = [];

		foreach ($result as $key => $val) {

			$data[$key] = ['id' => $val['id'], 'text' =>  $val['name']];
		}

		echo json_encode(['item' => $data]);
	}
	public function get_cp($kelas_id= null, $elemen_data_id=null)
	{
		$q 				= @$_POST['q'];
		$where_e		= "( kelas_id = '".$kelas_id."' and sd.elemen_data_id = '".$elemen_data_id."' )";

		$arr_config = [
			'table' 	=> 't_cp_kelas_belajar p',
			'where_e' 	=> $where_e,
			'join'		=> [['t_sekolah_elemen_data sd', 'sd.elemen_data_id= p.elemen_data_id']],
			'select' 	=> 'cp_id id, concat(cp_nomor, ". ", capaian_belajar) name',
			
			'array' 	=> true
		];

		$result = $this->m_global->get($arr_config);

		$data = [];

		foreach ($result as $key => $val) {

			$data[$key] = ['id' => $val['id'], 'text' =>  $val['name']];
		}

		echo json_encode(['item' => $data]);
	}

	public function get_cp_elemen($kelas_id=null)
	{
		// $where_e		= "(sd.elemen_data_id = '".$_POST['elemen_data_id']."' )";

		$arr_config = [
			'table' 	=> 't_cp_kelas_belajar p',
			'where' 	=> ['sd.elemen_data_id'=> $_POST['elemen_data_id'], 'kelas_id'=>$kelas_id],
			'join'		=> [['t_sekolah_elemen_data sd', 'sd.elemen_data_id= p.elemen_data_id']],
			'select' 	=> 'cp_id id, concat(cp_nomor, ". ", capaian_belajar) name',
			
			'array' 	=> true
		];

		$result = $this->m_global->get($arr_config);
		$data = [];
		foreach ($result as $key => $val) {

			$data[$key] = ['id' => $val['id'], 'text' =>  $val['name']];
		}
		echo json_encode(['item' => $data]);
	}


	public function get_elemen()
	{
		$q 				= @$_POST['q'];
		$where_e		= "( sekolah_id = '".login_data('sekolah_id')."')";

		$arr_config = [
			'table' 	=> 't_sekolah_elemen_data p',
			'where_e' 	=> $where_e,
			'join'		=> [['t_sekolah_elemen sd', 'sd.sekolah_elemen_id= p.sekolah_elemen_id']],
			'select' 	=> 'elemen_data_id id, concat(elemen_data) name',
			'start'		=> 0,
			'show'		=> 10,
			'array' 	=> true
		];

		$result = $this->m_global->get($arr_config);

		$data = [];

		foreach ($result as $key => $val) {

			$data[$key] = ['id' => $val['id'], 'text' =>  $val['name']];
		}

		echo json_encode(['item' => $data]);
	}

	
	

	

}

/* End of file Fetch.php */
/* Location: ./application/modules/fetch/controllers/Fetch.php */