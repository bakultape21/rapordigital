<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends MX_Controller
{

	private $prefix         = 'config/role';
	private $url            = 'config/role';
	private $table_db       = 't_role';
	private $table_prefix   = 'role_';
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
			'name'  	=> $this->table_prefix . 'name',
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

		$select = 'role_id, role_permission, role_status, ' . implode(',', $aCari);

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
				$rows->role_name,
				$this->_permission($rows->role_permission),
				$arr_status[$rows->role_status],
				$this->_button($rows->role_id, $rows->role_status),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	private function _permission($data)
	{
		$arr = str_split($data);

		$arr2 = [
			'r' => '<span class="badge badge-info">Read</span>',
			'w' => '<span class="badge badge-success">Edit</span>',
			'd' => '<span class="badge badge-danger">Delete</span>'
		];

		$res = [];

		foreach ($arr as $key => $val) {
			$res[] = $arr2[$val];
		}

		return list_name2($res, ' - ');
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
		$data['plugin'] 	= ['validation', 'jstree'];

		$this->template->display(strtolower(__CLASS__) . '/add', $data);
	}

	public function action_add()
	{
		$post 	= $this->input->post();

		$this->form_validation->set_rules('name', 'Role Name', 'trim|required|is_unique[t_role.role_name]');
		$this->form_validation->set_rules('access', 'Role Access', 'trim|required');
		$this->form_validation->set_rules('read', 'Read', 'trim');
		$this->form_validation->set_rules('write', 'Edit', 'trim');
		$this->form_validation->set_rules('delete', 'Delete', 'trim');

		if ($this->form_validation->run() == TRUE) {
			$r = (isset($post['read'])) ? $post['read'] : '';
			$w = (isset($post['write'])) ? $post['write'] : '';
			$d = (isset($post['delete'])) ? $post['delete'] : '';

			$permission = $r . $w . $d;

			$role_data 	= [
				'role_name' 		=> $post['name'],
				'role_access' 		=> str_replace([' #,', ', #'], '', $post['access']),
				'role_permission' 	=> $permission,
				'role_created_by'	=> login_data('user_id'),
				'role_created_date'	=> date('Y-m-d')
			];

			$insert = [
				'table' => $this->table_db,
				'datas' => $role_data
			];

			$res  = $this->m_global->insert($insert);

			if ($res['status']) {
				$result['status']     = 1;
				$result['message']    = 'Successfully add Role with Name <strong>' . $post['name'] . '</strong>';

				echo json_encode($result);
			} else {
				$result['status']     = 0;
				$result['message']    = 'Failed add Role with Name <strong>' . $post['name'] . '</strong>';
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
			'table'	=> 't_role',
			'where'	=> [strEncrypt('role_id', TRUE) => $id]
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];

		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}

	public function action_edit($id)
	{
		$post 	= $this->input->post();

		$unique_name  = ($post['name'] !== $post['backup_name']) ? '|is_unique[t_role.role_name]' : '';

		$this->form_validation->set_rules('name', 'Role Name', 'trim|required' . $unique_name);
		$this->form_validation->set_rules('access', 'Role Access', 'trim|required');
		$this->form_validation->set_rules('read', 'Read', 'trim');
		$this->form_validation->set_rules('write', 'Edit', 'trim');
		$this->form_validation->set_rules('delete', 'Delete', 'trim');

		if ($this->form_validation->run() == TRUE) {
			$r = (isset($post['read'])) ? $post['read'] : '';
			$w = (isset($post['write'])) ? $post['write'] : '';
			$d = (isset($post['delete'])) ? $post['delete'] : '';

			$permission = $r . $w . $d;

			$role_data 	= [
				'role_name' 		=> $post['name'],
				'role_access' 		=> str_replace([' #,', ', #'], '', $post['access']),
				'role_permission' 	=> $permission,
				'role_created_by'	=> login_data('user_id'),
			];

			$update = [
				'table' => $this->table_db,
				'datas'	=> $role_data,
				'where'	=> [strEncrypt('role_id', TRUE) => $id]
			];

			$res = $this->m_global->update($update);

			if ($res['status']) {
				$result['status']     = 1;
				$result['message']    = 'Successfully edit Role with Name <strong>' . $post['name'] . '</strong>';

				echo json_encode($result);
			} else {
				$result['status']     = 0;
				$result['message']    = 'Failed edit Role with Name <strong>' . $post['name'] . '</strong>';
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
				'where' => [strEncrypt('role_id', TRUE) => $id]
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
}

/* End of file Role.php */
/* Location: ./application/modules/config/controllers/Role.php */