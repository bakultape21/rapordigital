<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MX_Controller
{

	private $prefix         = 'config/menu';
	private $url            = 'config/menu';
	private $table_db       = 't_guru_menu';
	private $table_prefix   = 'menu_';
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
			'label'  	=> $this->table_prefix . 'label',
			'link'      => $this->table_prefix . 'link',
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= NULL;

		if (@$_REQUEST['action'] == 'filter') {
			$where = [];
			foreach ($aCari as $key => $value) {
				if ($_REQUEST[$key] != '') {
					if ($key == 'lastupdate') {
						$tmp = explode(' ', $_REQUEST[$key]);
						$where_e = "DATE(" . $this->table_prefix . "lastupdate) BETWEEN '" . $this->db->escape_str($tmp[0]) . "' AND '" . $this->db->escape_str($tmp[1]) . "'";
					} else {

						$where[$value . ' LIKE '] = '%' . $_REQUEST[$key] . '%';
					}
				}
			}
		} else {
			$where[$this->table_prefix . 'status <>']    = '99';
		}

		$keys   = array_keys($aCari);
		@$order = [$aCari[$keys[($_REQUEST['order'][0]['column'] - 1)]], $_REQUEST['order'][0]['dir']];

		$arr_config['table'] 	= $this->table_db;
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

		$select = 'menu_id, menu_icon, menu_status, ' . implode(',', $aCari);

		$arr_config['select'] 	= $select;
		$arr_config['order'] 	= $order;
		$arr_config['start'] 	= $iDisplayStart;
		$arr_config['show'] 	= $iDisplayLength;

		$result = $this->m_global->get($arr_config);

		$arr_status = [
			'0' => '<span class="badge badge-secondary">InActive</span>',
			'1' => '<span class="badge badge-info">Active</span>',
			'99' => '<span class="badge badge-danger">Delete</span>'
		];

		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {
			$records["data"][] = array(
				$i,
				$rows->menu_label,
				$rows->menu_link,
				'<i class="' . $rows->menu_icon . '"></i>',
				$arr_status[$rows->menu_status],
				$this->_button($rows->menu_id, $rows->menu_status),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	private function _button($id, $status)
	{
		$html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by/' . strEncrypt($id) . '/' . ($status == 1 ? '0" data-original-title="Set to InActive"' : '1" data-original-title="Set to Active"')) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . ($status == 0 ? 'InActive' : ($status == 99 ? 'Deleted' : 'Active')) . '" class="fa fa' . ($status == 0 ? '-eye-slash' : ($status == 99 ? '-trash' : '-eye')) . '"></i></a>';

		$html .= '<a href="' . base_url() . $this->url . '/show_edit/' . strEncrypt($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction ajaxify" title="Edit">
					<i class="la la-edit"></i>
				</a>';

		$html .= '<a href="' . base_url() . $this->prefix . '/delete/' . strEncrypt($id) . '" data-original-title="Hapus" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" data-permission="d" onClick="return deleteData(this, event);"><i class="la la-trash"></i></a>';

		return $html;
	}

	public function show_add()
	{
		$data['title']		= 'Add - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation'];

		$getParent 			= [
			'table' 	=> $this->table_db,
			'where' 	=> ['menu_status' => '1'],
			'select'	=> 'menu_id, menu_label'
		];

		$data['parent'] 	= $this->m_global->get($getParent);

		$this->template->display(strtolower(__CLASS__) . '/add', $data);
	}

	public function action_add()
	{
		$post = $this->input->post();

		$this->form_validation->set_rules('label', 'Label', 'trim|required|is_unique[t_guru_menu.menu_label]');
		$this->form_validation->set_rules('link', 'Link', 'trim|required|is_unique[t_guru_menu.menu_link]');
		$this->form_validation->set_rules('icon', 'Icon', 'trim');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');

		if ($post['position'] == '0') {
			$this->form_validation->set_rules('parent', 'Parent', 'trim|required');
		} else {
			$this->form_validation->set_rules('parent', 'Parent', 'trim');
		}

		if ($this->form_validation->run() == TRUE) {
			$parent = ($post['position'] == '0') ? $post['parent'] : '0';
			$number = $this->m_global->get(
				[
					'table'  => $this->table_db,
					'where'  => ['menu_parent' => $parent],
					'select' => 'MAX(menu_number) as number'
				]
			)[0]->number;

			$data[$this->table_prefix . 'label']          = $post['label'];
			$data[$this->table_prefix . 'link']           = $post['link'];
			$data[$this->table_prefix . 'parent']         = $parent;
			$data[$this->table_prefix . 'number']         = ($number + 1);
			$data[$this->table_prefix . 'icon']           = ($post['icon'] == '-' ? 'fa fa-minus' : $post['icon']);
			$data[$this->table_prefix . 'created_by']     = login_data('user_id');
			$data[$this->table_prefix . 'created_date']   = date('Y-m-d');

			$insert = [
				'table' => $this->table_db,
				'datas' => $data
			];

			$res  = $this->m_global->insert($insert);

			if ($res['status']) {
				$result['status']     = 1;
				$result['message']    = 'Successfully add Menu with Label <strong>' . $post['label'] . '</strong>';

				echo json_encode($result);
			} else {
				$result['status']     = 0;
				$result['message']    = 'Failed add Menu with Label <strong>' . $post['label'] . '</strong>';
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
		$data['plugin'] 	= ['validation'];

		$getParent 			= [
			'table' 	=> $this->table_db,
			'where' 	=> ['menu_status' => '1'],
			'select'	=> 'menu_id, menu_label'
		];

		$data['parent'] 	= $this->m_global->get($getParent);

		$data['id'] 		= $id;

		$arr_conf 			= [
			'table'	=> $this->table_db,
			'where'	=> [strEncrypt('menu_id', TRUE) => $id]
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];

		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}

	public function action_edit($id)
	{
		$post = $this->input->post();

		$unique_label  = ($post['label'] !== $post['backup_label']) ? '|is_unique[t_menu.menu_label]' : '';
		$unique_link  = ($post['link'] !== $post['backup_link']) ? '|is_unique[t_menu.menu_link]' : '';

		$this->form_validation->set_rules('label', 'Label', 'trim|required' . $unique_label);
		$this->form_validation->set_rules('link', 'Link', 'trim|required' . $unique_link);
		$this->form_validation->set_rules('icon', 'Icon', 'trim');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');

		if ($post['position'] == '0') {
			$this->form_validation->set_rules('parent', 'Parent', 'trim|required');
		} else {
			$this->form_validation->set_rules('parent', 'Parent', 'trim');
		}

		if ($this->form_validation->run() == TRUE) {
			$parent = ($post['position'] == '0') ? $post['parent'] : '0';

			$data[$this->table_prefix . 'label']          = $post['label'];
			$data[$this->table_prefix . 'link']           = $post['link'];
			$data[$this->table_prefix . 'parent']         = $parent;
			$data[$this->table_prefix . 'icon']           = ($post['icon'] == '-' ? 'fa fa-minus' : $post['icon']);

			$update = [
				'table' => $this->table_db,
				'datas'	=> $data,
				'where'	=> [strEncrypt('menu_id', TRUE) => $id]
			];

			$res = $this->m_global->update($update);

			if ($res['status']) {
				$result['status']     = 1;
				$result['message']    = 'Successfully edit Menu with Label <strong>' . $post['label'] . '</strong>';

				echo json_encode($result);
			} else {
				$result['status']     = 0;
				$result['message']    = 'Failed edit Menu with Label <strong>' . $post['label'] . '</strong>';
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

	public function change_status_by($id, $status, $stat = FALSE)
	{
		if ($stat) {
			$delete = [
				'table' => $this->table_db,
				'where' => [strEncrypt($this->table_prefix . 'id', TRUE) => $id]
			];

			$result = $this->m_global->delete($delete);
		} else {
			$update = [
				'table' 	=> $this->table_db,
				'datas' 	=> [$this->table_prefix . 'status' => $status],
				'where' 	=> [strEncrypt($this->table_prefix . 'id', TRUE) => $id]
			];

			$result = $this->m_global->update($update);
		}

		if ($result) {
			$data['status'] = 1;
		} else {

			$data['status'] = 0;
		}

		echo json_encode($data);
	}

	public function delete($id)
	{
		$role_permission = login_data('role_permission');

		if (strpos($role_permission, 'd') !== false) {
			$arr = [
				'table'	=> $this->table_db,
				'where' => [strEncrypt('menu_id', TRUE) => $id]
			];

			$res = $this->m_global->delete($arr);

			if ($res) {
				$return = ['status' => 1];
			} else {
				$return = ['status' => 0];
			}
		} else {
			$return = ['status' => 99];
		}

		echo json_encode($return);
	}

	// =============================================================================================================== //

	public function additional_link()
	{
		$data['title']		= 'Additional Link';
		$data['breadcrumb'] = ['Additional Link' => base_url() . $this->url . '/additional_link'];
		$data['url']		= base_url() . $this->url . '/additional_link';
		$data['prefix']		= $this->prefix . '/additional_link';

		$data['plugin'] 	= ['datatables', 'validation'];

		$this->template->display(strtolower(__CLASS__) . '/index_additional_link', $data);
	}

	public function select_additional_link()
	{
		$aCari = [
			'name'  	=> 'al_name',
			'link'  	=> 'al_link',
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= NULL;

		if (@$_REQUEST['action'] == 'filter') {
			$where = [];
			foreach ($aCari as $key => $value) {
				if ($_REQUEST[$key] != '') {
					if ($key == 'lastupdate') {
						$tmp = explode(' ', $_REQUEST[$key]);
						$where_e = "DATE(al_lastupdate) BETWEEN '" . $this->db->escape_str($tmp[0]) . "' AND '" . $this->db->escape_str($tmp[1]) . "'";
					} else {

						$where[$value . ' LIKE '] = '%' . $_REQUEST[$key] . '%';
					}
				}
			}
		} else {
			$where['al_status <>']    = '99';
		}

		$keys   = array_keys($aCari);
		@$order = [$aCari[$keys[($_REQUEST['order'][0]['column'] - 1)]], $_REQUEST['order'][0]['dir']];

		$arr_config['table'] 	= 'additional_link';
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

		$select = 'al_id, al_status, ' . implode(',', $aCari);

		$arr_config['select'] 	= $select;
		$arr_config['order'] 	= $order;
		$arr_config['start'] 	= $iDisplayStart;
		$arr_config['show'] 	= $iDisplayLength;

		$result = $this->m_global->get($arr_config);

		$arr_status = [
			'0' => '<span class="badge badge-secondary">InActive</span>',
			'1' => '<span class="badge badge-info">Active</span>',
			'99' => '<span class="badge badge-danger">Delete</span>'
		];

		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {
			$records["data"][] = array(
				$i,
				$rows->al_name,
				$rows->al_link,
				$arr_status[$rows->al_status],
				$this->_button_additional_link($rows->al_id, $rows->al_status),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	private function _button_additional_link($id, $status)
	{
		$html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by_additional_link/' . strEncrypt($id) . '/' . ($status == 1 ? '0" data-original-title="Set to InActive"' : '1" data-original-title="Set to Active"')) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . ($status == 0 ? 'InActive' : ($status == 99 ? 'Deleted' : 'Active')) . '" class="fa fa' . ($status == 0 ? '-eye-slash' : ($status == 99 ? '-trash' : '-eye')) . '"></i></a>';

		$html .= '<a href="' . base_url() . $this->url . '/show_edit_additional_link/' . strEncrypt($id) . '" data-permission="w" onClick="edit_al(this, event)" data-original-title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" title="Edit">
					<i class="la la-edit"></i>
				</a>';

		$html .= '<a href="' . base_url() . $this->prefix . '/delete_additional_link/' . strEncrypt($id) . '" data-original-title="Hapus" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" data-permission="d" onClick="return deleteData(this, event);"><i class="la la-trash"></i></a>';

		return $html;
	}

	public function action_add_additional_link()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[additional_link.al_name]');
		$this->form_validation->set_rules('link', 'Link', 'trim|required|is_unique[additional_link.al_link]');

		if ($this->form_validation->run($this)) {
			$data['al_name']           = $this->input->post('name');
			$data['al_link']           = $this->input->post('link');
			$data['al_created_by']     = login_data('user_id');

			$insert = [
				'table' => 'additional_link',
				'datas' => $data
			];

			$res  = $this->m_global->insert($insert);

			if ($res['status']) {
				$data['status']     = 1;
				$data['message']    = 'Successfully add Additional Link with Name <strong>' . $this->input->post('name') . '</strong>';

				echo json_encode($data);
			} else {
				$result['status']     = 0;
				$result['message']    = 'Failed add Additional Link with Name <strong>' . $this->input->post('name') . '</strong>';
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

	public function show_edit_additional_link($id)
	{
		$config = [
			'table' 	=> 'additional_link',
			'where' 	=> [strEncrypt('al_id', TRUE) => $id],
			'select'	=> 'al_id, al_name, al_link'
		];

		$data = $this->m_global->get($config);

		echo json_encode($data);
	}

	public function action_edit_additional_link()
	{
		$post 	= $this->input->post();

		$unique_name  = ($post['name'] !== $post['backup_name']) ? '|is_unique[additional_link.al_name]' : '';
		$unique_link  = ($post['link'] !== $post['backup_link']) ? '|is_unique[additional_link.al_link]' : '';

		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required' . $unique_name);
		$this->form_validation->set_rules('link', 'Link', 'trim|required' . $unique_link);

		if ($this->form_validation->run($this)) {
			$id 			           = $this->input->post('id');
			$data['al_name']           = $this->input->post('name');
			$data['al_link']           = $this->input->post('link');

			$update = [
				'table' => 'additional_link',
				'datas' => $data,
				'where'	=> ['al_id' => $id]
			];

			$res  = $this->m_global->update($update);

			if ($res) {
				$data['status']     = 1;
				$data['message']    = 'Successfully edit Additional Link with Name <strong>' . $this->input->post('name') . '</strong>';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed edit Additional Link with Name <strong>' . $this->input->post('name') . '</strong>';
				if (ENVIRONMENT == 'development')
					$data['error']  = $this->db->error();

				echo json_encode($data);
			}
		} else {

			$data['status']     = 3;
			$str                = ['<p>', '</p>'];
			$str_replace        = ['<li>', '</li>'];
			$data['message']    = str_replace($str, $str_replace, validation_errors());

			echo json_encode($data);
		}
	}

	public function change_status_by_additional_link($id, $status, $stat = FALSE)
	{
		if ($stat) {
			$delete = [
				'table' => 'additional_link',
				'where' => [strEncrypt('al_id', TRUE) => $id]
			];

			$result = $this->m_global->delete($delete);
		} else {
			$update = [
				'table' 	=> 'additional_link',
				'datas' 	=> ['al_status' => $status],
				'where' 	=> [strEncrypt('al_id', TRUE) => $id]
			];

			$result = $this->m_global->update($update);
		}

		if ($result) {
			$data['status'] = 1;
		} else {

			$data['status'] = 0;
		}

		echo json_encode($data);
	}

	public function delete_additional_link($id)
	{
		$role_permission = login_data('role_permission');

		if (strpos($role_permission, 'd') !== false) {
			$arr = [
				'table'	=> 'additional_link',
				'where' => [strEncrypt('al_id', TRUE) => $id]
			];

			$res = $this->m_global->delete($arr);

			if ($res) {
				$return = ['status' => 1];
			} else {
				$return = ['status' => 0];
			}
		} else {
			$return = ['status' => 99];
		}

		echo json_encode($return);
	}

	// =============================================================================================================== //

	public function show_list_menu()
	{
		$data['title']		= 'Show List Menu';
		$data['breadcrumb'] = ['Show List Menu' => base_url() . $this->url . '/show_list_menu'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix . '/show_list_menu';

		$data['plugin'] 	= ['nestable'];

		$this->template->display(strtolower(__CLASS__) . '/show_list_menu', $data);
	}

	public function save_list()
	{
		$post 	= $this->input->post('data');
		$data 	= [];

		foreach ($post as $key => $val) {
			$data[] = [
				'parent' => '0',
				'no' 	 => ($key + 1),
				'id'	 => $val['id']
			];

			if (isset($val['children'])) {
				$data = array_merge($data, $this->_save_list($val['children'], $val['id']));
			}
		}

		$this->db->trans_begin();

		foreach ($data as $k => $v) {
			$data_update = [
				'table' => $this->table_db,
				'datas' => [
					'menu_parent' => $v['parent'],
					'menu_number' => $v['no']
				],
				'where' => ['menu_id' => $v['id']]
			];

			$this->m_global->update($data_update);
		}

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();

			$result['status']     = 1;
			$result['message']    = 'Successfully edit List Menu';

			echo json_encode($result);
		} else {
			$this->db->trans_rollback();

			$result['status']     = 0;
			$result['message']    = 'Failed edit List Menu';

			echo json_encode($result);
		}
	}

	private function _save_list($datas, $id)
	{
		$data 	= [];

		foreach ($datas as $key => $val) {
			$data[] = [
				'parent' => $id,
				'no' 	 => ($key + 1),
				'id'	 => $val['id']
			];

			if (isset($val['children'])) {
				$data = array_merge($data, $this->_save_list($val['children'], $val['id']));
			}
		}

		return $data;
	}
}

/* End of file Menu.php */
/* Location: ./application/modules/config/controllers/Menu.php */