<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends MX_Controller
{

	private $prefix         = 'absensi';
	private $url            = 'absensi';
	private $table_db       = 't_kelas_belajar';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index($id)
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['validation'];
		$data['id']			= $id;

		$data['guru_sekolah']= $this->m_global->get([
				'table'=> 't_kelas_belajar k',
				'join'=> [
					['t_sekolah s', 'k.sekolah_id= k.sekolah_id' ],
					['t_guru g', 'g.guru_id=k.guru_id'],					
					['kabupaten b', 'b.kabupaten_id= s.kabupaten_id']

				],
				'where'=> [ 'k.kelas_id' => $id]])[0];

		$data['siswa_data']= $this->m_global->get([
				'table'=> 't_kelas_belajar k',
				'select'=> 'k.*, s.*, m.*',
				'join'=> [
					['t_kelas_belajar_data s', 's.kelas_id= k.kelas_id' ],
					['t_siswa m', 'm.siswa_id= s.siswa_id']
				],
				'where'=> [ 'k.kelas_id'=> $id]]);
		

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}
	public function action_add()
	{

		$result = [];
		$post 	= $this->input->post();
		$this->load->library('cart');

		$this->form_validation->set_rules('absensi_izin[]', 'Izin', 'trim|required');
		$this->form_validation->set_rules('absensi_tanpa_keterangan[]', 'Tanpa Keterangan', 'trim|required');
		$this->form_validation->set_rules('absensi_sakit[]', 'Sakit', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			for ($i=0; $i < count($post['siswa_kelas_id']); $i++) { 
				
				$data_array = [
					'absensi_izin' => $post['absensi_izin'][$i],
					'absensi_sakit'=> $post['absensi_sakit'][$i],
					'absensi_tanpa_keterangan'=> $post['absensi_tanpa_keterangan'][$i]
				];

				$q_update = [
					'table' => 't_kelas_belajar_data',
					'datas'	=> $data_array,
					'where'=> ['siswa_kelas_id'=> $post['siswa_kelas_id'][$i]]
				];
				$this->m_global->update($q_update);

			}

			$result['status']     = 1;
			$result['message']    = 'Berhasil Edit Absensi Kelas';
			echo json_encode($result);			
			
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}
}