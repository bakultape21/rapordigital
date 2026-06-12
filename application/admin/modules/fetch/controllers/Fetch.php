<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fetch extends MX_Controller
{

	

	public function get_kabupaten()
	{
		$q 				= @$_POST['q'];
		$where_e		= "( kabupaten LIKE '%" . $q . "%' )";

		$arr_config = [
			'table' 	=> 'kabupaten d',
			'where_e' 	=> $where_e,
			'select' 	=> 'kabupaten_id id, kabupaten name',
			'join'		=> null,
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
	public function get_sekolah()
	{
		$q 				= @$_POST['q'];
		$where_e		= "( sekolah_nama LIKE '%" . $q . "%' or npsn LIKE '%" . $q . "%' or kabupaten LIKE '%" . $q . "%' )";

		$arr_config = [
			'table' 	=> 't_sekolah s',
			'where_e' 	=> $where_e,
			'select' 	=> 'sekolah_id id, concat(sekolah_nama, " - ", npsn, " -  ",kabupaten) name',
			'join'		=> [
				['kabupaten kb', 'kb.kabupaten_id=s.kabupaten_id'],
				['provinsi p', 'p.provinsi_id=kb.provinsi_id']],
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