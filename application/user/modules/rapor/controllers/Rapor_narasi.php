<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rapor_narasi extends MX_Controller
{

	private $prefix         = 'rapor_narasi';
	private $url            = 'rapor_narasi';
	private $table_db       = 't_kelas_belajar';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function edit_narasi($id)
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . '/rapor/' . $this->url;
		$data['prefix']		= $this->prefix;
		
		$data['permission'] = 'w';
		$data['id']			= $id;
		$data['plugin'] 	= ['validation'];
		$data['data_siswa']= $this->m_global->get([
        		'table'=> 't_kelas_belajar_data td', 
        		'select'=> '*, s.alamat as alamat_sekolah',
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id']
        		],
        		'where'=> ['siswa_kelas_id'=> $id]])[0];

		$data['id_kelas']= $data['data_siswa']->kelas_id;

		$data['nilai_rapor'] = $this->m_global->get(['table'=> 't_kelas_belajar_rapor_edit', 'where'=> ['siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]]);

		// print_r($data['nilai_rapor']);
		// exit();

		$data['cp_belajar']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'join'=> [
				['t_kelas_belajar_data kd', 'kd.kelas_id=k.kelas_id'], 
				['t_siswa s', 's.siswa_id= kd.siswa_id'],
				['t_cp_kelas_belajar cp', 'cp.kelas_id= k.kelas_id'],
				['t_sekolah_elemen_data ed', 'ed.elemen_data_id= cp.elemen_data_id'],
				['( 
					select group_concat(DISTINCT `kegiatan_belajar`
                       ORDER BY kegiatan_belajar ASC SEPARATOR ", " LIMIT 4) AS kegiatan,
       kegiatan_nilai as nilai, cp_id, siswa_kelas_id
			from v_nilai_belajar

			where siswa_kelas_id = "'.$data['data_siswa']->siswa_kelas_id.'"
			group by cp_id, kegiatan_nilai


			) nilai', '(nilai.siswa_kelas_id= kd.siswa_kelas_id and cp.cp_id= nilai.cp_id)']
						],
						'order'=> ['ed.elemen_data_id', 'asc'],
						'where'=> ['kd.siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]
		]);
		$data['kegiatan']= $this->m_global->get([
			'table'=> 'v_all_nilai',
			'where'=> ['siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]
		]);

		
		$data['elemen_sekolah']= $this->m_global->get([
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id']],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> ['sekolah_elemen_status'=> 1, 'sekolah_id'=> $data['data_siswa']->sekolah_id]]);
	

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}

	public function action_add()
	{
		if ($_POST) {

			$this->m_global->delete(['table'=> 't_kelas_belajar_rapor_edit', 'where'=>['siswa_kelas_id'=> $_POST['siswa_kelas_id']]]);

			$siswa_kelas= $this->m_global->get(['table'=> 't_kelas_belajar_data',
						'where'=> ['siswa_kelas_id'=> $_POST['siswa_kelas_id']]])[0];

			for ($i=0; $i < count($_POST['elemen_data_id']); $i++) { 

				$kalimat_muncul='';
				$kalimat_tidak_muncul='';


				for ($j=0; $j < count($_POST['kalimat_muncul_'.$_POST['elemen_data_id'][$i]]); $j++) { 
					$kalimat_muncul .= $_POST['kalimat_muncul_'.$_POST['elemen_data_id'][$i]][$j].', ';
				}
				$kalimat_muncul= rtrim($kalimat_muncul, ', ');

				
				if (@$_POST['kalimat_tidak_muncul_'.$_POST['elemen_data_id'][$i]] != null) {
					$total=count(@$_POST['kalimat_tidak_muncul_'.$_POST['elemen_data_id'][$i]]);

				}else{
					$total= 0;
				}
				for ($j=0; $j < $total; $j++) { 
					$kalimat_tidak_muncul .= @$_POST['kalimat_tidak_muncul_'.$_POST['elemen_data_id'][$i]][$j].', ';
				}
				$kalimat_tidak_muncul= rtrim($kalimat_tidak_muncul, ', ');

				$data_input=[
					'elemen_data_id'=> $_POST['elemen_data_id'][$i],
					'siswa_kelas_id'=> $siswa_kelas->siswa_kelas_id,
					'kalimat_muncul'=> $kalimat_muncul,
					'kalimat_tidak_muncul'=> $kalimat_tidak_muncul
				];
				$this->m_global->insert(['table'=> 't_kelas_belajar_rapor_edit', 'datas'=> $data_input]);

				
			}
			$result['status']     = 1;
			$result['message']    = 'Berhasil Edit Nilai Rapor ';

			echo json_encode($result);	
		}
		
	}
}