<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends MX_Controller
{

	private $prefix         = 'notifikasi';
	private $url            = 'notifikasi';
	private $table_db       = 't_notifikasi_update';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['datatables'];

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}

	public function select()
	{
		$aCari = [
			'judul'  => 'judul',
			'isi_notifikasi'      =>  'isi_notifikasi'
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
				$rows->judul,
				$rows->isi_notifikasi,
				$this->_button($rows->id),
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

		$html = '<a href="' . base_url() . $this->url . '/show_edit/' . strEncrypt($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-warning btn-icon-md tooltips btnAction ajaxify" title="Edit">
					Edit
				</a>';

		$html .= '<button class="btn btn-danger btn-sm btn-icon-md " onclick="return hapus('."'".$id."'".') ">Hapus</button>';

		return $html;
	}
	public function hapus()
	{
		if ($_POST) {

			$cek_data= $this->m_global->get(['table'=> 't_notifikasi_update', 'where'=> ['id'=> $_POST['id']]]);

			if (@$cek_data[0] != null) {

				$this->m_global->delete(['table'=> 't_notifikasi_update', 'where'=> ['id'=> $cek_data[0]->id]]);

				$data['status']     = 1;
				$data['message']    = 'Successfully edit Kelas';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed edit Kelas';
				if (ENVIRONMENT == 'development')
					$data['error']  = $this->db->error();

				echo json_encode($data);
			}
		}
	}

	public function show_add()
	{
		$data['title']		= 'Add - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation'];

	

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

	public function action_add()
	{
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('judul', 'Judul', 'trim|required');
		$this->form_validation->set_rules('isi_notifikasi', 'Isi', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			
			$data_array = [
				'judul' 	=> $post['judul'],
				'isi_notifikasi' => $post['isi_notifikasi']
			];

			$insert = [
				'table' => 't_notifikasi_update',
				'datas' => $data_array
			];

			$res  = $this->m_global->insert($insert);

			if ($res['status']) {
				$result['status']     = 1;
				$result['message']    = 'Successfully add Notifikasi with Name <strong>' . $post['judul'] . '</strong>';

				echo json_encode($result);
			} else {

				$result['status']     = 0;
				$result['message']    = 'Failed add Notifikasi with Name <strong>' . $post['judul'] . '</strong>';
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
			'table'	=> 't_notifikasi_update s',
			'where'	=> [strEncrypt('id', TRUE) => $id]
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];

		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}

	public function action_edit($id)
	{
		$result = [];
		$post 	= $this->input->post();


		$this->form_validation->set_rules('judul', 'Judul', 'trim|required');
		$this->form_validation->set_rules('isi_notifikasi', 'ISI', 'trim|required');
		

		if ($this->form_validation->run() == TRUE) {
			
			$data_array = [
				'judul' 		=> $post['judul'],
				'isi_notifikasi' 				=> $post['isi_notifikasi']
			];


			$update = [
				'table' => $this->table_db,
				'datas'	=> $data_array,
				'where'	=> [strEncrypt('id', TRUE) => $id]
			];

			$result = $this->m_global->update($update);

			if ($result['status']) {
				$data['status']     = 1;
				$data['message']    = 'Successfully Notifikasi with Name <strong>' . $post['judul'] . '</strong>';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed Notifikasi with Name <strong>' . $post['judul'] . '</strong>';
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