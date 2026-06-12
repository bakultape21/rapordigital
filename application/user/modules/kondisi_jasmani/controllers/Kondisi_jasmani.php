<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kondisi_jasmani extends MX_Controller
{

	private $prefix         = 'kondisi_jasmani';
	private $url            = 'kondisi_jasmani';
	private $table_db       = 't_kelas_belajar';
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
				'select'=> 'k.*, s.*, m.*, j.kondisi_jasmani_id',
				'join'=> [
					['t_kelas_belajar_data s', 's.kelas_id= k.kelas_id' ],
					['t_siswa m', 'm.siswa_id= s.siswa_id'],
					['t_kelas_belajar_kondisi_jasmani j', 'j.siswa_kelas_id= s.siswa_kelas_id', 'left']
				],
				'where'=> [ 'k.kelas_id'=> $id]]);
		

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
				'where'=> [ 'siswa_kelas_id'=> $id]])[0];


	
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
					['t_kelas_belajar_kondisi_jasmani d', 'd.siswa_kelas_id= s.siswa_kelas_id']
				],
				'where'=> [ 'kondisi_jasmani_id'=> $id]])[0];

	
		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}


	public function action_add($id) {
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('mata_pengelihatan', 'Mata pengelihatan', 'trim|required');
		$this->form_validation->set_rules('hidung_penciuman', 'Hidung Penciuman', 'trim|required');
		$this->form_validation->set_rules('telinga_pendengaran', 'Telinga Pendengaran', 'trim|required');
		$this->form_validation->set_rules('mulut', 'Mulut', 'trim|required');
		$this->form_validation->set_rules('gigi', 'Gigi', 'trim|required');
		$this->form_validation->set_rules('anggota_badan', 'Anggota Badan', 'trim|required');
		$this->form_validation->set_rules('kulit', 'Kulit', 'trim|required');
		$this->form_validation->set_rules('kebersihan', 'Kebersihan', 'trim|required');
		$this->form_validation->set_rules('tb_awal', 'Tinggi Badan Awal', 'trim|required');
		$this->form_validation->set_rules('tb_akhir', 'Tinggi Badan Akhir', 'trim|required');
		$this->form_validation->set_rules('bb_awal', 'BB Awal', 'trim|required');
		$this->form_validation->set_rules('bb_akhir', 'BB Akhir', 'trim|required');
		$this->form_validation->set_rules('lk_awal', 'Lingkar Kepala Awal', 'trim|required');
		$this->form_validation->set_rules('lk_akhir', 'Lingkar Kepala Akhir', 'trim|required');
		$this->form_validation->set_rules('ll_awal', 'Lingkar Lengan Awal', 'trim|required');
		$this->form_validation->set_rules('ll_akhir', 'Lingkar Lengan Akhir', 'trim|required');
		$this->form_validation->set_rules('imunisasi', 'Imunisasi', 'trim|required');
		$this->form_validation->set_rules('riwayat_penyakit', 'Riwayat Penyakit', 'trim|required');
		$this->form_validation->set_rules('kapsul_vitamin', 'Kapsul Vitamin', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			$cek = $this->m_global->get(['table'=> 't_kelas_belajar_data', 'where'=> ['siswa_kelas_id'=> $id]])[0];

			$data_array = [
				'mata_pengelihatan' => $post['mata_pengelihatan'],
				'hidung_penciuman'=> $post['hidung_penciuman'],
				'telinga_pendengaran'=> $post['telinga_pendengaran'],
				'mulut'=> $post['mulut'],
				'gigi'=> $post['gigi'],
				'anggota_badan'=> $post['anggota_badan'],
				'kulit'=> $post['kulit'],
				'kebersihan'=> $post['kebersihan'],
				'tb_awal'=> $post['tb_awal'],
				'tb_akhir'=> $post['tb_akhir'],
				'bb_awal'=> $post['bb_awal'],
				'bb_akhir'=> $post['bb_akhir'],
				'lk_awal'=> $post['lk_awal'],
				'lk_akhir'=> $post['lk_akhir'],
				'll_awal'=> $post['ll_awal'],
				'll_akhir'=> $post['ll_akhir'],
				'imunisasi'=> $post['imunisasi'],
				'riwayat_penyakit'=> $post['riwayat_penyakit'],
				'kapsul_vitamin'=> $post['kapsul_vitamin'],
				'siswa_kelas_id'=> $cek->siswa_kelas_id
			];

			$q_insert = [
				'table' => 't_kelas_belajar_kondisi_jasmani',
				'datas'	=> $data_array
			];
			$id=$this->m_global->insert($q_insert)['id'];


			if ($id != null) {

				$result['status']     = 1;
				$result['message']    = 'Berhasil Simpan Kondisi Jasmani ';

				echo json_encode($result);			
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal simpan data';

				echo json_encode($result);	
			
			};
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}

	}
	public function action_edit($id) {
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('mata_pengelihatan', 'Mata pengelihatan', 'trim|required');
		$this->form_validation->set_rules('hidung_penciuman', 'Hidung Penciuman', 'trim|required');
		$this->form_validation->set_rules('telinga_pendengaran', 'Telinga Pendengaran', 'trim|required');
		$this->form_validation->set_rules('mulut', 'Mulut', 'trim|required');
		$this->form_validation->set_rules('gigi', 'Gigi', 'trim|required');
		$this->form_validation->set_rules('anggota_badan', 'Anggota Badan', 'trim|required');
		$this->form_validation->set_rules('kulit', 'Kulit', 'trim|required');
		$this->form_validation->set_rules('kebersihan', 'Kebersihan', 'trim|required');
		$this->form_validation->set_rules('tb_awal', 'Tinggi Badan Awal', 'trim|required');
		$this->form_validation->set_rules('tb_akhir', 'Tinggi Badan Akhir', 'trim|required');
		$this->form_validation->set_rules('bb_awal', 'BB Awal', 'trim|required');
		$this->form_validation->set_rules('bb_akhir', 'BB Akhir', 'trim|required');
		$this->form_validation->set_rules('lk_awal', 'Lingkar Kepala Awal', 'trim|required');
		$this->form_validation->set_rules('lk_akhir', 'Lingkar Kepala Akhir', 'trim|required');
		$this->form_validation->set_rules('ll_awal', 'Lingkar Lengan Awal', 'trim|required');
		$this->form_validation->set_rules('ll_akhir', 'Lingkar Lengan Akhir', 'trim|required');
		$this->form_validation->set_rules('imunisasi', 'Imunisasi', 'trim|required');
		$this->form_validation->set_rules('riwayat_penyakit', 'Riwayat Penyakit', 'trim|required');
		$this->form_validation->set_rules('kapsul_vitamin', 'Kapsul Vitamin', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			$data_array = [
				'mata_pengelihatan' => $post['mata_pengelihatan'],
				'hidung_penciuman'=> $post['hidung_penciuman'],
				'telinga_pendengaran'=> $post['telinga_pendengaran'],
				'mulut'=> $post['mulut'],
				'gigi'=> $post['gigi'],
				'anggota_badan'=> $post['anggota_badan'],
				'kulit'=> $post['kulit'],
				'kebersihan'=> $post['kebersihan'],
				'tb_awal'=> $post['tb_awal'],
				'tb_akhir'=> $post['tb_akhir'],
				'bb_awal'=> $post['bb_awal'],
				'bb_akhir'=> $post['bb_akhir'],
				'lk_awal'=> $post['lk_awal'],
				'lk_akhir'=> $post['lk_akhir'],
				'll_awal'=> $post['ll_awal'],
				'll_akhir'=> $post['ll_akhir'],
				'imunisasi'=> $post['imunisasi'],
				'riwayat_penyakit'=> $post['riwayat_penyakit'],
				'kapsul_vitamin'=> $post['kapsul_vitamin']
			];

			$q_insert = [
				'table' => 't_kelas_belajar_kondisi_jasmani',
				'datas'	=> $data_array,
				'where'=> ['kondisi_jasmani_id'=> $id]
			];
			$cek=$this->m_global->update($q_insert);


			if ($cek= true) {

				$result['status']     = 1;
				$result['message']    = 'Berhasil Simpan Edit Kondisi Jasmani ';

				echo json_encode($result);			
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal simpan data';

				echo json_encode($result);	
			
			};
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}

	}
}