<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MX_Controller
{

	private $prefix         = 'config/user';
	private $url            = 'config/user';
	private $table_db       = 't_user';
	private $table_prefix   = 'user_';
	private $title 			= __CLASS__;

	public function index()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['datatables'];

		$data['role'] 		= $this->m_global->get(['table' => 't_role', 'where' => ['role_status' => '1'], 'select' => 'role_id, role_name']);

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}

	public function select()
	{
		$aCari = [
			'fullname'  => $this->table_prefix . 'full_name',
			'name'      => $this->table_prefix . 'name',
			'role'      => $this->table_prefix . 'role',
			'email'     => $this->table_prefix . 'email',
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= [
			['t_role', 'role_id = user_role']
		];

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
			$where[$this->table_prefix . 'status <>']    = '99';
		}

		if (login_data('user_id') !== '1') {
			$where[$this->table_prefix . 'id <>'] = '1';
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

		$select = 'user_id, role_name, user_photo, user_status, ' . implode(',', $aCari);

		$arr_config['select'] 	= $select;
		$arr_config['order'] 	= $order;
		$arr_config['start'] 	= $iDisplayStart;
		$arr_config['show'] 	= $iDisplayLength;

		$result = $this->m_global->get($arr_config);

		$status = [
			'0' => '<span class="kt-badge kt-badge--danger kt-badge--inline">Tidak Aktif</span>',
			'1' => '<span class="kt-badge kt-badge--info kt-badge--inline">Aktif</span>'
		];

		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {
			$records["data"][] = array(
				$i,
				$rows->user_full_name,
				$rows->user_name,
				$rows->role_name,
				$rows->user_email,
				$this->_is_file($rows->user_photo),
				$status[$rows->user_status],
				$this->_button($rows->user_id, $rows->user_status),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
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

		$data['kabupaten']	= $this->m_global->get(['table'=> 'kabupaten']);

		if (login_data('user_id') === '1') {
			$data['role'] 		= $this->m_global->get(['table' => 't_role', 'select' => 'role_id, role_name', 'where' => ['role_status' => '1']]);
		} else {
			$data['role'] 		= $this->m_global->get(['table' => 't_role', 'select' => 'role_id, role_name', 'where' => ['role_status' => '1', 'role_id <> 1' => null]]);
		}

		$this->template->display(strtolower(__CLASS__) . '/add', $data);
	}

	public function action_add()
	{
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[t_user.user_name]');
		$this->form_validation->set_rules('email', 'email', 'trim|required|is_unique[t_user.user_email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm', 'Verify Password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('role', 'Role', 'trim|required');
		$this->form_validation->set_rules('kabupaten_id', 'Kabupaten', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$photo = null;

			if ($_FILES) {
				$upload_path = 'assets/uploads/images/users';

				// if (!is_dir($upload_path)) {
				// 	$oldmask = umask(0);
				// 	mkdir($upload_path, 0777, true);
				// 	umask($oldmask);
				// }

				$config['upload_path'] 		= $upload_path;
				$config['allowed_types'] 	= 'jpg|jpeg|png|pdf|rar|zip';
				$config['overwrite'] 		= TRUE;
				$config['max_size']			= 5000;

				$this->load->library('upload', $config);

				$name 			= str_replace(' ', '_', trim($_FILES['photo']['name']));
				$fileNameParts 	= explode(".", $name);
				$fileExtension 	= end($fileNameParts);
				$fileExtension 	= strtolower($fileExtension);
				$fix_name_file 	= time() . "_pp." . $fileExtension;

				$config['file_name']		= $fix_name_file;
				$this->upload->initialize($config);

				if ($this->upload->do_upload('photo')) {
					$photo = $upload_path . '/' . $fix_name_file;
				}
			}

			$data_array = [
				'user_full_name' 	=> $post['fullname'],
				'user_name' 		=> $post['username'],
				'user_email' 		=> $post['email'],
				'user_password' 	=> md5_mod($post['password'], $post['username']),
				'user_role' 		=> $post['role'],
				'user_kabupaten_id'	=> $post['kabupaten_id'],
				'user_photo'		=> $photo
			];

			$insert = [
				'table' => $this->table_db,
				'datas' => $data_array
			];

			$res  = $this->m_global->insert($insert);

			if ($res['status']) {
				$result['status']     = 1;
				$result['message']    = 'Successfully add User with Name <strong>' . $post['fullname'] . '</strong>';

				echo json_encode($result);
			} else {

				$result['status']     = 0;
				$result['message']    = 'Failed add User with Name <strong>' . $post['fullname'] . '</strong>';
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

		if (login_data('user_id') === '1') {
			$data['role'] 		= $this->m_global->get(['table' => 't_role', 'select' => 'role_id, role_name', 'where' => ['role_status' => '1']]);
		} else {
			$data['role'] 		= $this->m_global->get(['table' => 't_role', 'select' => 'role_id, role_name', 'where' => ['role_status' => '1', 'role_id <> 1' => null]]);
		}

		$arr_conf 			= [
			'table'	=> 't_user',
			'where'	=> [strEncrypt('user_id', TRUE) => $id]
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];

		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}

	public function action_edit($id)
	{
		$result = [];
		$post 	= $this->input->post();

		$unique_name  = ($post['username'] !== $post['backup_username']) ? '|is_unique[t_user.user_name]' : '';
		$unique_email = ($post['email'] !== $post['backup_email']) ? '|is_unique[t_user.user_email]' : '';

		$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required' . $unique_name);
		$this->form_validation->set_rules('email', 'email', 'trim|required' . $unique_email);
		$this->form_validation->set_rules('role', 'Role', 'trim|required');

		if ($post['password'] !== '') {
			$this->form_validation->set_rules('password', 'Password', 'trim');
			$this->form_validation->set_rules('confirm', 'Verify Password', 'trim|matches[password]');
		}

		if ($this->form_validation->run() == TRUE) {
			$photo = $post['pp_upload'];

			if ($_FILES) {
				$upload_path = 'assets/uploads/images/users';

				// if (!is_dir($upload_path)) {
				// 	$oldmask = umask(0);
				// 	mkdir($upload_path, 0777, true);
				// 	umask($oldmask);
				// }

				$config['upload_path'] 		= $upload_path;
				$config['allowed_types'] 	= 'jpg|jpeg|png|pdf|rar|zip';
				$config['overwrite'] 		= TRUE;
				$config['max_size']			= 5000;

				$this->load->library('upload', $config);

				if ($photo == null) {
					$name 			= str_replace(' ', '_', trim($_FILES['photo']['name']));
					$fileNameParts 	= explode(".", $name);
					$fileExtension 	= end($fileNameParts);
					$fileExtension 	= strtolower($fileExtension);
					$fix_name_file 	= time() . "_pp." . $fileExtension;

					$config['file_name'] = $fix_name_file;
				} else {
					$config['file_name'] = str_replace($upload_path . '/', '', $photo);
				}
				$this->upload->initialize($config);

				if ($this->upload->do_upload('photo')) {
					if ($photo == null) {
						$photo = $upload_path . '/' . $fix_name_file;
					} else {
						$photo = $photo;
					}
				}
			}

			if ($this->input->post('password'))
				$data_array[$this->table_prefix . 'password']   = md5_mod($post['password'], $post['username']);

			$data_array[$this->table_prefix . 'full_name'] 	= $post['fullname'];
			$data_array[$this->table_prefix . 'name'] 		= $post['username'];
			$data_array[$this->table_prefix . 'email'] 		= $post['email'];
			$data_array[$this->table_prefix . 'role'] 		= $post['role'];
			$data_array[$this->table_prefix . 'photo'] 		= $photo;

			$update = [
				'table' => $this->table_db,
				'datas'	=> $data_array,
				'where'	=> [strEncrypt('user_id', TRUE) => $id]
			];

			$result = $this->m_global->update($update);

			if ($result['status']) {
				$data['status']     = 1;
				$data['message']    = 'Successfully edit User with Name <strong>' . $post['fullname'] . '</strong>';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed edit User with Name <strong>' . $post['fullname'] . '</strong>';
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
			$file = @$this->m_global->get([
				'table' => $this->table_db,
				'where' => [strEncrypt('user_id', TRUE) => $id],
				'select' => 'user_photo'
			])[0]->user_photo;

			$arr = [
				'table'	=> $this->table_db,
				'where' => [strEncrypt('user_id', TRUE) => $id]
			];

			$res = $this->m_global->delete($arr);

			if ($res) {
				if (is_file($file)) {
					unlink($file);
				}

				$return = ['status' => 1];
			} else {
				$return = ['status' => 0];
			}
		} else {
			$return = ['status' => 99];
		}

		echo json_encode($return);
	}

	public function get_treeview()
	{
		$id = $this->input->post('id');

		$data = v_tree_view(menu('', get_access($id)));

		echo $data;
	}

	// ============================================================================================ //

	public function profile()
	{
		$data['title']		= 'Profile';
		$data['breadcrumb'] = ['Profile' => base_url() . $this->url . '/profile'];
		$data['url']		= base_url() . $this->url . '/profile';
		$data['url2']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['validation'];

		$arr_conf 			= [
			'table'		=> 't_user',
			'where'		=> ['user_id' => login_data('user_id')],
			'join'		=> [['t_role', 'role_id = user_role']],
			'select'	=> 'user_id, user_full_name, user_name, user_email, user_photo, user_status, user_lastupdate, role_name, user_address, user_phone'
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];

		$data['_content']	= $this->load->view(strtolower(__CLASS__) . '/profile', $data, TRUE);

		$this->template->display(strtolower(__CLASS__) . '/main', $data);
	}

	public function account()
	{
		$data['title']		= 'Account';
		$data['breadcrumb'] = ['Account' => base_url() . $this->url . '/account'];
		$data['url']		= base_url() . $this->url . '/account';
		$data['url2']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['validation'];

		$arr_conf 			= [
			'table'		=> 't_user',
			'where'		=> ['user_id' => login_data('user_id')],
			'join'		=> [['t_role', 'role_id = user_role']],
			'select'	=> 'user_id, user_full_name, user_name, user_email, user_photo, user_status, user_lastupdate, role_name, user_address, user_phone'
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];

		$data['_content']	= $this->load->view(strtolower(__CLASS__) . '/account', $data, TRUE);

		$this->template->display(strtolower(__CLASS__) . '/main', $data);
	}

	public function action_profile()
	{
		$id 	= login_data('user_id');
		$result = [];
		$post 	= $this->input->post();

		$unique_email = ($post['email'] !== $post['backup_email']) ? '|is_unique[t_user.user_email]' : '';

		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required' . $unique_email);

		if ($this->form_validation->run() == TRUE) {
			$photo = $post['backup_pp_upload'];

			if ($_FILES) {
				$upload_path = 'assets/uploads/images/users';

				if (!is_dir($upload_path)) {
					$oldmask = umask(0);
					mkdir($upload_path, 0777, true);
					umask($oldmask);
				}

				$config['upload_path'] 		= $upload_path;
				$config['allowed_types'] 	= 'jpg|jpeg|png';
				$config['overwrite'] 		= TRUE;
				$config['max_size']			= 5000;

				$this->load->library('upload', $config);

				if ($photo == null) {
					$name 			= str_replace(' ', '_', trim($_FILES['pp_upload']['name']));
					$fileNameParts 	= explode(".", $name);
					$fileExtension 	= end($fileNameParts);
					$fileExtension 	= strtolower($fileExtension);
					$fix_name_file 	= time() . "_pp." . $fileExtension;

					$config['file_name'] = $fix_name_file;
				} else {
					$config['file_name'] = str_replace($upload_path . '/', '', $photo);
				}
				$this->upload->initialize($config);

				if ($this->upload->do_upload('pp_upload')) {
					if ($photo == null) {
						$photo = $upload_path . '/' . $fix_name_file;
					} else {
						$photo = $photo;
					}
				}
				
			}

			$data_array[$this->table_prefix . 'full_name'] 	= $post['full_name'];
			$data_array[$this->table_prefix . 'phone'] 		= $post['phone'];
			$data_array[$this->table_prefix . 'address'] 		= $post['address'];
			$data_array[$this->table_prefix . 'email'] 		= $post['email'];
			$data_array[$this->table_prefix . 'photo'] 		= $photo;

			$update = [
				'table' => $this->table_db,
				'datas'	=> $data_array,
				'where'	=> ['user_id' => $id]
			];

			$result = $this->m_global->update($update);

			if ($result['status']) {
				updateSession();

				$data['status']     = 1;
				$data['message']    = 'Successfully update Profile';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed update Profile';
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

	public function action_profile2()
	{
		$id 	= login_data('user_id');
		$result = [];
		$post 	= $this->input->post();

		$unique_name  = ($post['username'] !== $post['backup_username']) ? '|is_unique[t_user.user_name]' : '';

		$this->form_validation->set_rules('username', 'Username', 'trim|required' . $unique_name);

		if ($post['password'] !== '') {
			$this->form_validation->set_rules('password', 'Password', 'trim');
			$this->form_validation->set_rules('verify_password', 'Verify Password', 'trim|matches[password]');
		}

		if ($this->form_validation->run() == TRUE) {
			if ($this->input->post('password'))
				$data_array[$this->table_prefix . 'password']   = md5_mod($post['password'], $post['username']);

			$data_array[$this->table_prefix . 'name'] 		= $post['username'];

			$update = [
				'table' => $this->table_db,
				'datas'	=> $data_array,
				'where'	=> ['user_id' => $id]
			];


			$result = $this->m_global->update($update);

			if ($result['status']) {
				updateSession();

				$data['status']     = 1;
				$data['message']    = 'Successfully update User & Password';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed update User & Password';
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

/* End of file User.php */
/* Location: ./application/modules/config/controllers/User.php */
