<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Elemen extends MX_Controller
{

	private $prefix         = 'elemen';
	private $url            = 'elemen';
	private $table_db       = 't_master_elemen';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;
		$data['kelompok']	= $this->m_global->get(['table'=> 't_master_elemen_kelompok']);


		$data['plugin'] 	= ['datatables'];

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}

	public function select()
	{
		$aCari = [
			'elemen'  => 'elemen',
			'kelompok_id'=> 'k.kelompok_id'
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= [['t_master_elemen_kelompok k', 's.kelompok_id= k.kelompok_id']];

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
				$rows->nomor,
				$rows->elemen,
				'<span class=" badge badge-secondary">'.$rows->nama_kelompok."</span>",				
				$this->_button($rows->elemen_id),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}
	public function select_cp($elemen_id)
	{
		$aCari = [
			'capaian_jenis'  => 'capaian_jenis',
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= [['t_master_elemen k', 's.elemen_id= k.elemen_id']];

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

		$arr_config['table'] 	= ' t_master_cp s';
		$arr_config['where'] 	= $where;
		$arr_config['where_e'] 	= [strEncrypt('k.elemen_id', TRUE)=> '"'.$elemen_id.'"'];
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
				$rows->capaian_nomor,
				$rows->capaian_belajar,
				'<span class=" badge badge-secondary">'.$rows->capaian_jenis."</span>",				
				$this->_button_cp($rows->elemen_id, $rows->id),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}
	private function _button_cp($elemen_id=null, $id= null)
	{
		// $html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by/' . strEncrypt($id) . '/' . ($status == 1 ? '0" data-original-title="Set to InActive"' : '1" data-original-title="Set to Active"')) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . ($status == 0 ? 'InActive' : ($status == 99 ? 'Deleted' : 'Active')) . '" class="fa fa' . ($status == 0 ? '-eye-slash' : ($status == 99 ? '-trash' : '-eye')) . '"></i></a>';

		$html = '<a href="' . base_url() . $this->url . '/add_cp/' . strEncrypt($elemen_id) . '/' . strEncrypt($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-warning btn-icon btn-icon-md tooltips btnAction ajaxify" title="Edit">
					<i class="la la-edit"></i>
				</a>';
		return $html;
	}
	private function _button($id, $status= null)
	{
		// $html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by/' . strEncrypt($id) . '/' . ($status == 1 ? '0" data-original-title="Set to InActive"' : '1" data-original-title="Set to Active"')) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . ($status == 0 ? 'InActive' : ($status == 99 ? 'Deleted' : 'Active')) . '" class="fa fa' . ($status == 0 ? '-eye-slash' : ($status == 99 ? '-trash' : '-eye')) . '"></i></a>';

		$html = '<a href="' . base_url() . $this->url . '/show_edit/' . strEncrypt($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-warning btn-icon btn-icon-md tooltips btnAction ajaxify" title="Edit">
					<i class="la la-edit"></i>
				</a>';

		$html .= '<a href="' . base_url() . $this->url . '/add_cp/' . strEncrypt($id) . '" data-permission="w" data-original-title="Add CP" class="btn btn-sm btn-success btn-icon-md tooltips btnAction ajaxify" title="Add CP">
					Add CP
				</a>';

		$html .= '<a href="' . base_url() . $this->prefix . '/delete/' . strEncrypt($id) . '" data-original-title="Hapus" class="btn btn-sm btn-danger btn-icon btn-icon-md tooltips btnAction" data-permission="d" onClick="return deleteData(this, event);"><i class="la la-trash"></i></a>';

		return $html;
	}
	public function add_cp($elemen_id, $id=null )
	{
		$data['title']		= 'Add - Capaian Belajar' ;
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation', 'datatables'];

		$data['elemen_id']			= $elemen_id;

		if (@$id != null) {
			$data['capaian_belajar']= $this->m_global->get(['table'=>'t_master_cp c', 'join'=> [['t_master_elemen m', 'm.elemen_id= c.elemen_id']], 'where'=> [strEncrypt('id', TRUE)=> $id]]);
			$data['url_action']= site_url().'/elemen/action_edit_cp';
			$data['id']= $id;
		}else{
			$data['capaian_belajar']=null;
			$data['url_action']= site_url().'/elemen/action_add_cp';
			$data['id']= null;
		}

		$arr_conf 			= [
			'table'	=> 't_master_elemen s',
			'join'=> [['t_master_elemen_kelompok k', 's.kelompok_id= k.kelompok_id']],			
			'where'	=> [strEncrypt('elemen_id', TRUE) => $elemen_id]
		];
		
		$data['record'] 	= $this->m_global->get($arr_conf)[0];


		$data['kelompok']	= $this->m_global->get(['table'=> 't_master_elemen_kelompok']);

		$this->template->display(strtolower(__CLASS__) . '/add_cp', $data);
	}
	public function show_add()
	{
		$data['title']		= 'Add - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation', 'jstree'];

		$data['kelompok']	= $this->m_global->get(['table'=> 't_master_elemen_kelompok']);

		$this->template->display(strtolower(__CLASS__) . '/add', $data);
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
	public function action_edit_cp()
	{
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('capaian_belajar', 'Capaian Belajar', 'trim|required');
		$this->form_validation->set_rules('capaian_nomor', 'Capaian Nomor', 'trim|required');
		$this->form_validation->set_rules('capaian_jenis', 'Jenis', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			

			$data_array = [
				'capaian_belajar' 	=> $post['capaian_belajar'],
				'capaian_jenis' => $post['capaian_jenis'],
				'capaian_nomor' => $post['capaian_nomor']
				
			];

			$update = [
				'table' => 't_master_cp',
				'datas' => $data_array,
				'where'=> [strEncrypt('id', TRUE)=> $_POST['id']]
			];

			$this->m_global->update($update);

				$result['status']     = 1;
				$result['message']    = 'Successfully Update Capaian with Name <strong>' . $post['capaian_nomor'] . '</strong>';

				echo json_encode($result);
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}
	public function action_add_cp()
	{
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('capaian_belajar', 'Capaian Belajar', 'trim|required');
		$this->form_validation->set_rules('capaian_nomor', 'Capaian Nomor', 'trim|required');
		$this->form_validation->set_rules('capaian_jenis', 'Jenis', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			$elemen= $this->m_global->get(['table'=> 't_master_elemen', 'where'=> [strEncrypt('elemen_id', TRUE)=> $_POST['elemen_id']]])[0];


			$data_array = [
				'capaian_belajar' 	=> $post['capaian_belajar'],
				'capaian_jenis' => $post['capaian_jenis'],
				'capaian_nomor' => $post['capaian_nomor'],
				'elemen_id'		=> $elemen->elemen_id
			];

			$insert = [
				'table' => 't_master_cp',
				'datas' => $data_array
			];

			$res  = $this->m_global->insert($insert);

			if ($res['status']) {
				$result['status']     = 1;
				$result['message']    = 'Successfully add Capaian with Name <strong>' . $post['capaian_nomor'] . '</strong>';

				echo json_encode($result);
			} else {

				$result['status']     = 0;
				$result['message']    = 'Failed add Capaian with Name <strong>' . $post['capaian_nomor'] . '</strong>';
				if (ENVIRONMENT == 'development')
					$result['error']  = $this->db->error();

				echo json_encode($result);
			}
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}

	public function action_add()
	{
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('elemen', 'Elemen', 'trim|required');
		$this->form_validation->set_rules('kelompok_id', 'Pilih Kelmpok', 'trim|required');
		$this->form_validation->set_rules('nomor', 'Nomor Urut Elemen', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			$data_array = [
				'elemen' 	=> $post['elemen'],
				'kelompok_id' => $post['kelompok_id'],
				'nomor'		=> $post['nomor']
			];

			$insert = [
				'table' => 't_master_elemen',
				'datas' => $data_array
			];

			$res  = $this->m_global->insert($insert);

			if ($res['status']) {
				$result['status']     = 1;
				$result['message']    = 'Successfully add Elemen with Name <strong>' . $post['elemen'] . '</strong>';

				echo json_encode($result);
			} else {

				$result['status']     = 0;
				$result['message']    = 'Failed add Elemen with Name <strong>' . $post['elemen'] . '</strong>';
				if (ENVIRONMENT == 'development')
					$result['error']  = $this->db->error();

				echo json_encode($result);
			}
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}
		public function show_edit($id)
	{
		$data['title']		= 'Edit - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Edit' => base_url() . $this->url . '/show_edit/' . $id];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation', 'jstree'];
		$data['id'] 		= $id;


		$arr_conf 			= [
			'table'	=> 't_master_elemen s',
			'join'=> [['t_master_elemen_kelompok k', 's.kelompok_id= k.kelompok_id']],			
			'where'	=> [strEncrypt('elemen_id', TRUE) => $id]
		];

		$data['record'] 	= $this->m_global->get($arr_conf)[0];



		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}

	public function action_edit($id)
	{
		$result = [];
		$post 	= $this->input->post();


		$this->form_validation->set_rules('elemen', 'Elemen', 'trim|required');
		$this->form_validation->set_rules('kelompok_id', 'kelompok_id', 'trim|required');
		$this->form_validation->set_rules('nomor', 'nomor', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
		
		
			$data_array = [
				'elemen' 	=> $post['elemen'],
				'kelompok_id' => $post['kelompok_id'],
				'nomor'=> $post['nomor']
			];

			$update = [
				'table' => $this->table_db,
				'datas'	=> $data_array,
				'where'	=> [strEncrypt('elemen_id', TRUE) => $id]
			];

			$result = $this->m_global->update($update);

			if ($result['status']) {
				$data['status']     = 1;
				$data['message']    = 'Successfully edit Elemen with Name <strong>' . $post['elemen'] . '</strong>';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed edit Elemen with Name <strong>' . $post['elemen'] . '</strong>';
				if (ENVIRONMENT == 'development')
					$data['error']  = $this->db->error();

				echo json_encode($data);
			}
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}


}