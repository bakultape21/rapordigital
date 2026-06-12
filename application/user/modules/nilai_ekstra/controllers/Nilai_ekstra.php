<?php
defined('BASEPATH') or exit('No direct script access allowed');

class nilai_ekstra extends MX_Controller
{

	private $prefix         = 'nilai_ekstra';
	private $url            = 'nilai_ekstra';
	private $table_db       = 't_kelas_belajar_nilai_ekstra';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index($id)
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['datatables'];

		$data['guru_sekolah']= $this->m_global->get([
				'table'=> 't_kelas_belajar k',
				'join'=> [
					['t_sekolah s', 'k.sekolah_id= s.sekolah_id' ],
					['t_guru g', 'g.guru_id=k.guru_id'],
					['kabupaten b', 'b.kabupaten_id= s.kabupaten_id']

				],
				'where'=> [ 'k.kelas_id' => $id]])[0];

		$data['siswa_data']= $this->m_global->get([
				'table'=> 't_kelas_belajar k',
				'select'=> 'k.*, s.*, m.*, j.nilai_ekstra_id',
				'join'=> [
					['t_kelas_belajar_data s', 's.kelas_id= k.kelas_id' ],
					['t_siswa m', 'm.siswa_id= s.siswa_id'],
					['t_kelas_belajar_nilai_ekstra j', 'j.siswa_kelas_id= s.siswa_kelas_id', 'left']
				],
				'group'=> 's.siswa_kelas_id',
				'where'=> ['k.kelas_id'=> $id]]);
		

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}
	public function show_add($id)
	{
		$data['title']		= 'Add - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation'];
		$data['id']= $id;


		$data['record']=  $this->m_global->get([
				'table'=> 't_kelas_belajar k',
				'join'=> [
					['t_kelas_belajar_data s', 's.kelas_id= k.kelas_id' ],
					['t_siswa m', 'm.siswa_id= s.siswa_id']],
				'where'=> ['siswa_kelas_id'=> $id]])[0];


	
		$this->template->display(strtolower(__CLASS__) . '/add', $data);
	}
	public function show_edit($id)
	{
		$data['title']		= 'Edit - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation'];
		$data['id']= $id;


		$data['record']=  $this->m_global->get([
				'table'=> 't_kelas_belajar k',
				'join'=> [
					['t_kelas_belajar_data s', 's.kelas_id= k.kelas_id' ],
					['t_siswa m', 'm.siswa_id= s.siswa_id'],
					['t_kelas_belajar_nilai_ekstra d', 'd.siswa_kelas_id= s.siswa_kelas_id']
				],
				'where'=> [ 'd.siswa_kelas_id'=> $id]]);

	
		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}


	public function action_add($id) {
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('nilai_ekstra_kegiatan[]', 'Nilai Ekstra Kegiatan', 'trim|required');
		$this->form_validation->set_rules('nilai_ekstra[]', 'Nilai Ekstra', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			$cek = $this->m_global->get(['table'=> 't_kelas_belajar_data', 'where'=> ['siswa_kelas_id'=> $id]])[0];

			for ($i=0; $i < count($post['nilai_ekstra_kegiatan']); $i++) { 
				
				$data_array = [
					'nilai_ekstra_kegiatan' => $post['nilai_ekstra_kegiatan'][$i],
					'nilai_ekstra'=> $post['nilai_ekstra'][$i],
					'siswa_kelas_id'=> $cek->siswa_kelas_id
				];

				$q_insert = [
					'table' => 't_kelas_belajar_nilai_ekstra',
					'datas'	=> $data_array
				];
				$this->m_global->insert($q_insert)['id'];

			}

			$result['status']     = 1;
			$result['message']    = 'Berhasil Nilai Ekstra ';
			echo json_encode($result);			
			
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}

	}
	public function action_edit($id) {
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('nilai_ekstra_kegiatan[]', 'Nilai Ekstra Kegiatan', 'trim');
		$this->form_validation->set_rules('nilai_ekstra[]', 'Nilai Ekstra', 'trim');

		if ($this->form_validation->run() == TRUE) {

			
			$cek = $this->m_global->get(['table'=> 't_kelas_belajar_data', 'where'=> ['siswa_kelas_id'=> $id]])[0];

			$this->m_global->delete(['table'=> 't_kelas_belajar_nilai_ekstra', 'where'=> ['siswa_kelas_id'=>$id]]);

			for ($i=0; $i < count($post['nilai_ekstra_kegiatan']); $i++) { 

				if ($post['nilai_ekstra_kegiatan'][$i] !='') {
					$data_array = [
						'nilai_ekstra_kegiatan' => $post['nilai_ekstra_kegiatan'][$i],
						'nilai_ekstra'=> $post['nilai_ekstra'][$i],
						'siswa_kelas_id'=> $cek->siswa_kelas_id
					];

					$q_insert = [
						'table' => 't_kelas_belajar_nilai_ekstra',
						'datas'	=> $data_array
					];
					$this->m_global->insert($q_insert)['id'];

				}
				
				
			}

				$result['status']     = 1;
				$result['message']    = 'Berhasil Simpan Edit Nilai Ekstra ';

				echo json_encode($result);			
			
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}

	}
}