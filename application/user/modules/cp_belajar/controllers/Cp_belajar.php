<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cp_belajar extends MX_Controller
{

	private $prefix         = 'cp_belajar';
	private $url            = 'cp_belajar';
	private $table_db       = 't_cp_belajar';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index($kelas=null)
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation'];


		$data['kelas']		= $kelas;
		

		$data['cp_belajar']= $this->m_global->get([
			'table'=> 't_cp_kelas_belajar cp',
		 	'where'=> ['kelas_id'=> $kelas],
		 	'order'=> ['cp_nomor', 'asc']

		 ]);
		$data['elemen']		= $this->m_global->get([
			'table'=> 't_sekolah_elemen s', 
			'join'=> [['t_sekolah_elemen_data sd', 's.sekolah_elemen_id= sd.sekolah_elemen_id'], ['t_kelas_belajar k', 'k.sekolah_elemen_id= s.sekolah_elemen_id']], 
			'where'=> ['kelas_id'=> $kelas]]);

		if ($kelas != null) {
			$this->template->display(strtolower(__CLASS__) . '/index', $data);
		}

		
	}

	public function select()
	{
		$aCari = [
			'elemen'  => 'elemen',
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= [];

		if (@$_REQUEST['action'] == 'filter') {
			$where = [];
			foreach ($aCari as $key => $value) {
				if ($_REQUEST[$key] != '') {
					if ($key == 'lastupdate') {
						$tmp = explode(' ', $_REQUEST[$key]);
						$where_e = "DATE(" . $this->table_prefix . "lastupdate) BETWEEN '" . $this->db->escape_str($tmp[0]) . "' AND '" . $this->db->escape_str($tmp[1]) . "'";
					} else if ($key == 'role') {
						$where[$value] = $_REQUEST[$key];
					} else {
						$where[$value . ' LIKE '] = '%' . $_REQUEST[$key] . '%';
					}
				}
			}
		} else {
			// $where[$this->table_prefix . 'status <>']    = '99';
		}

		// if (login_data('user_id') !== '1') {
		// 	$where[$this->table_prefix . 'id <>'] = '1';
		// }

		$keys   = array_keys($aCari);
		@$order = [$aCari[$keys[($_REQUEST['order'][0]['column'] - 1)]], $_REQUEST['order'][0]['dir']];

		$arr_config['table'] 	= $this->table_db.' s';
		$arr_config['where'] 	= $where;
		$arr_config['where_e'] 	= $where_e;
		$arr_config['join'] 	= $join;

		$iTotalRecords  = $this->m_global->count($arr_config);
		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  = intval($_REQUEST['start']);
		$sEcho          = intval($_REQUEST['draw']);

		$records        = array();
		$records["data"] = array();

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$select = ' *, ' . implode(',', $aCari);

		$arr_config['select'] 	= $select;
		$arr_config['order'] 	= $order;
		$arr_config['start'] 	= $iDisplayStart;
		$arr_config['show'] 	= $iDisplayLength;

		$result = $this->m_global->get($arr_config);


		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {
			$records["data"][] = array(
				$i,
				$rows->elemen,
				$rows->deskripsi,				
				$this->_button($rows->elemen_id),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	private function _button($id, $status= null)
	{
		// $html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by/' . strEncrypt($id) . '/' . ($status == 1 ? '0" data-original-title="Set to InActive"' : '1" data-original-title="Set to Active"')) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . ($status == 0 ? 'InActive' : ($status == 99 ? 'Deleted' : 'Active')) . '" class="fa fa' . ($status == 0 ? '-eye-slash' : ($status == 99 ? '-trash' : '-eye')) . '"></i></a>';

		$html = '<a href="' . base_url() . $this->url . '/show_edit/' . ($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction ajaxify" title="Edit">
					<i class="la la-edit"></i>
				</a>';

		$html .= '<a href="' . base_url() . $this->prefix . '/delete/' . ($id) . '" data-original-title="Hapus" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" data-permission="d" onClick="return deleteData(this, event);"><i class="la la-trash"></i></a>';

		return $html;
	}
	
		private function _is_file($file)
	{
		$link = 'assets/media/users/default.jpg';

		if (is_file($file)) {
			$link = $file;
		}

		$html = '<span class="kt-media kt-media--circle"><img src="' . base_url() . $link . '" alt="Photo"></span>';

		return $html;
	}

	public function action_add_cp()
	{
		$this->load->library('cart');

		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('elemen_data_id', 'Elemen', 'trim|required');
		$this->form_validation->set_rules('cp_belajar', 'Capaian Belajar', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$kelas= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['kelas_id'=> $_POST['kelas_id']]])[0];
			
			$arr_query=[
				'table'=> 't_cp_kelas_belajar', 
				'datas'=> [
					'kelas_id'=> $kelas->kelas_id,
					'capaian_belajar'=> $_POST['cp_belajar'],
					'elemen_data_id'=> $_POST['elemen_data_id'],
					'cp_nomor'=> $_POST['cp_nomor']
				]
				];

			$id=$this->m_global->insert($arr_query)['id'];

			if ($id != null) {

				$result['status']     = 1;
				$result['message']    = 'Berhasil Menambahkan Capaian Belajar';

				echo json_encode($result);			
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal menambahkan Capaian Belajar  ';

				echo json_encode($result);	
			
			};
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}
	public function show_edit($kelas, $id)
	{
		$data['title']		= 'Edit - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Edit' => base_url() . $this->url . '/show_edit/' . $id];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['id'] 		= $id;
		$data['plugin'] 	= ['validation'];

		$arr_conf 			= [
			'table'	=> 't_cp_kelas_belajar cp',		

			'join'=> [['t_sekolah_elemen_data e', 'e.elemen_data_id= cp.elemen_data_id']],	
			'where'	=> ['cp_id' => $id]
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];


		$data['kelas']		= $kelas;
		$data['elemen']		= $this->m_global->get(['table'=> 't_sekolah_elemen s', 'join'=> [['t_sekolah_elemen_data sd', 's.sekolah_elemen_id= sd.sekolah_elemen_id']], 'where'=> ['sekolah_id'=> login_data('sekolah_id')]]);

		$data['cp_belajar']= $this->m_global->get([
			'table'=> 't_cp_kelas_belajar',
		 	'where'=> ['kelas_id'=> $kelas],
		 	'order'=> ['cp_nomor', 'asc']
		 ]);

		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}
	public function delete_cp()
	{

		if ($_POST) {
			$cek = $this->m_global->get(['table'=> 't_cp_kelas_belajar', 'where'=> ['cp_id'=> $_POST['cp_id']]]);

			if (@$cek[0] != null) {

				$this->m_global->delete(['table'=> 't_cp_kelas_belajar', 'where'=> ['cp_id'=> $cek[0]->cp_id]]);

				$result['status']     = 1;
				$result['message']    = 'Berhasil Hapus Capaian Belajar';

				echo json_encode($result);	
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal Hapus Data Capaian Belajar  ';

				echo json_encode($result);	
			}
		}
	}

	public function set_cp()
	{
		$this->load->model('M_cp');

		if ($_POST) {
			$cek = $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['kelas_id'=> $_POST['kelas_id']]]);

			if (@$cek[0] != null) {

				$this->M_cp->set_cp_belajar($cek[0]->kelas_id, $_POST['kelompok']);

				$result['status']     = 1;
				$result['message']    = 'Berhasil Tarik Capaian Belajar';

				echo json_encode($result);	
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal Tarik Data Capaian Belajar  ';

				echo json_encode($result);	
			}
		}
	}

	public function action_edit($id)
	{
		$result = [];
		$post 	= $this->input->post();


		
		$this->form_validation->set_rules('elemen_data_id', 'Elemen', 'trim|required');
		$this->form_validation->set_rules('cp_belajar', 'Capaian Belajar', 'trim|required');
		

		if ($this->form_validation->run() == TRUE) {
		
			$kelas= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['kelas_id'=> $_POST['kelas_id']]])[0];
			
			$arr_query=[
				'table'=> 't_cp_kelas_belajar', 
				'datas'=> [
					'capaian_belajar'=> $_POST['cp_belajar'],
					'elemen_data_id'=> $_POST['elemen_data_id'],
					'cp_nomor'=> $_POST['cp_nomor']
					],
				'where'=> ['cp_id'=> $id]
				];

			$this->m_global->update($arr_query);

			if ($id != null) {

				$result['status']     = 1;
				$result['message']    = 'Berhasil Edit Capaian Belajar';

				echo json_encode($result);			
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal Edit Capaian Belajar  ';

				echo json_encode($result);	
			
			};
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}


}