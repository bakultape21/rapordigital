<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nilai extends MX_Controller
{

	private $prefix         = 'nilai';
	private $url            = 'nilai';
	private $table_db       = 't_nilai_belajar_tp';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index($kelas_id=null)
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['validation'];

		if ($kelas_id == null) {
			$q_kelas			= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['guru_id'=> login_data('user_id'), 'kelas_status'=> 0]])[0];
			$data['kelas']		= $q_kelas;

		}else{
			$q_kelas			= $this->m_global->get([
				'table'=> 't_kelas_belajar', 
				'where'=> 
						['kelas_id'=> $kelas_id]])[0];
			$data['kelas']		= $q_kelas;
		}
		$data['kelas_id']		= $data['kelas']->kelas_id;
		$data['siswa_data']		= $this->m_global->get([
			'table'=> 't_kelas_belajar_data td', 
			'join'=> [['t_kelas_belajar k', 'td.kelas_id= k.kelas_id'],['t_siswa s', 'td.siswa_id= s.siswa_id']], 'where'=> ['k.kelas_id'=> $data['kelas']->kelas_id]]);

		$data['elemen']		= $this->m_global->get([
			'table'=> 't_sekolah_elemen s', 
			'join'=> [['t_sekolah_elemen_data sd', 's.sekolah_elemen_id= sd.sekolah_elemen_id'], ['t_kelas_belajar k', 'k.sekolah_elemen_id= s.sekolah_elemen_id']], 
			'where'=> ['kelas_id'=> $data['kelas']->kelas_id]]);

		
				
		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}

	public function show_edit($id=null)
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['validation'];

		$data['record']		= $this->m_global->get([
			'table'=> 't_kelas_belajar_kegiatan tp',
			'join'=> [['t_cp_kelas_belajar cp', 'cp.cp_id= tp.cp_id'],
					['t_kelas_belajar k', 'k.kelas_id= cp.kelas_id'],
					['t_sekolah_elemen_data s', 's.elemen_data_id= cp.elemen_data_id']
				],
			'where'=> ['kegiatan_id'=> $id]
			])[0];

		$data['kelas_id']= $data['record']->kelas_id;

		$data['record_data'] = $this->m_global->get([
			'table'=> 't_kelas_belajar_kegiatan_nilai kd', 
			'join'=> [
				['t_kelas_belajar_data s', 's.siswa_kelas_id= kd.siswa_kelas_id'],
				['t_siswa i', 's.siswa_id= i.siswa_id']],
			'where'=> ['kegiatan_id'=> $id]
		]);


		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}

	public function list($id=null)
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['datatables'];
		$data['id']	= ($id);
		$kelas_id	= $id;

		$data['data_kegiatan']	= $this->m_global->get([
							'table'=> 't_kelas_belajar_kegiatan tp',
							'join'=> [
									['t_cp_kelas_belajar cp', 'cp.cp_id= tp.cp_id'],
									['t_sekolah_elemen_data e', 'cp.elemen_data_id= e.elemen_data_id']
								],
							'where' => ['kelas_id'=> $kelas_id]
						]);
		
		$this->template->display(strtolower(__CLASS__) . '/list', $data);
	}
			

		private function _button($id, $status= null)
	{
		
		$html = '<a href="' . base_url() . $this->url . '/show_edit/' . ($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-warning btn-icon-md btn-sm p-1 tooltips btnAction ajaxify" title="Edit">
					Edit
				</a> ';

		$html .= '<button onclick="return confirm('."'Anda Yakin Hapus Data Ini?'".')?delete_tp('."'".($id)."'".'):'."''".'"  data-original-title="Delete" class="btn btn-sm  btn-sm p-1 btn-icon-md tooltips btn-danger btnAction ajaxify" > Delete</button>  ';


		return $html;
	}

	


	public function action_add()
	{

		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('kegiatan_belajar', 'Kegiatan Belajar', 'trim|required');
		$this->form_validation->set_rules('cp_id', 'Capaian Belajar', 'trim|required');
		$this->form_validation->set_rules('kegiatan_tanggal', 'Tanggal', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			
			$arr_query=[
				'table'=> 't_kelas_belajar_kegiatan', 
				'datas'=> [
					'cp_id'=> $_POST['cp_id'],
					'kegiatan_belajar'=> $_POST['kegiatan_belajar'],
					'kegiatan_tanggal'=> $_POST['kegiatan_tanggal']]
				];

			$kegiatan_id=$this->m_global->insert($arr_query)['id'];
			$datas;

			for ($i=0; $i < count($_POST['siswa_kelas_id']); $i++) { 
				$datas[]=[
						'kegiatan_id'=> $kegiatan_id,
						'siswa_kelas_id'=> $_POST['siswa_kelas_id'][$i],
						'kegiatan_nilai'=> $_POST['kegiatan_nilai'][$_POST['siswa_kelas_id'][$i]]];
			}
			
			$arr_query=[
					'table'=> 't_kelas_belajar_kegiatan_nilai', 
					'datas'=> $datas
				];
			$this->m_global->insert_batch($arr_query);


			

			if ($kegiatan_id != null) {

				$result['status']     = 1;
				$result['message']    = 'Berhasil Menambahkan Nilai Belajar';

				echo json_encode($result);			
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal menambahkan Nilai Belajar  ';

				echo json_encode($result);	
			
			};
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}
	public function delete_tp()
	{
		if ($_POST) {

			$this->m_global->delete(['table'=> 't_kelas_belajar_kegiatan',
									'where'=> ['kegiatan_id'=> $_POST['kegiatan_id']]]);

			$this->m_global->delete(['table'=> 't_kelas_belajar_kegiatan_nilai',
									'where'=> ['kegiatan_id'=> $_POST['kegiatan_id']]]);

			$result['status']     = 1;
			$result['message']    = 'Berhasil Hapus Nilai Belajar';
			echo json_encode($result);


		}

				
	}
	

	public function action_edit()
	{

		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('kegiatan_belajar', 'Kegiatan Belajar', 'trim|required');
		$this->form_validation->set_rules('cp_id', 'Capaian Belajar', 'trim|required');
		$this->form_validation->set_rules('kegiatan_tanggal', 'Tanggal', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			
			$arr_query=[
				'table'=> 't_kelas_belajar_kegiatan', 
				'datas'=> [
					'cp_id'=> $_POST['cp_id'],
					'kegiatan_belajar'=> $_POST['kegiatan_belajar'],
					'kegiatan_tanggal'=> $_POST['kegiatan_tanggal']],
				'where'=> ['kegiatan_id'=> $_POST['kegiatan_id']]
				];

			$this->m_global->update($arr_query);

			for ($i=0; $i < count($_POST['id']); $i++) { 
				$arr_query=[
					'table'=> 't_kelas_belajar_kegiatan_nilai', 
					'datas'=> [
						'kegiatan_nilai'=> $_POST['kegiatan_nilai'][$_POST['id'][$i]]],
					'where'=> ['id'=> $_POST['id'][$i]]
				];

				$kegiatan_id=$this->m_global->update($arr_query);
			}

			$result['status']     = 1;
			$result['message']    = 'Berhasil Edit Nilai Belajar';

			echo json_encode($result);			
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}
	



}