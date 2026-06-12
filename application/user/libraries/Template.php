<?php
class Template {

	protected $_ci;

	function __construct()
	{
		$this->_ci = &get_instance();
	}

	function display( $template, $data = NULL)
	{
		$url 		= isset($data['url']) ? $data['url'] : null;
		$permission = (isset($data['permission'])) ? $data['permission'] : false;

		$status_link    = @$this->_ci->input->post('status_link');
		// if ($this->_check_link($url, $permission) === false) {
		// 	$template = 'templates/error_404';
		// }

		if ( $status_link == 'ajax' )
		{
			$data['_content']       = $this->_ci->load->view($template, $data, TRUE);

			$this->_ci->load->view('templates/content', $data);

		}
		else
		{
			$data['_content']       = $this->_ci->load->view($template, $data, TRUE);
			$data['_header']        = $this->_ci->load->view('templates/header', $data, TRUE);
			$data['_sidebar']       = $this->_ci->load->view('templates/sidebar', $data, TRUE);
			$data['_footer']        = $this->_ci->load->view('templates/footer', $data, TRUE);
			$data['_fullcontent']   = $this->_ci->load->view('templates/content', $data, TRUE);

			$this->_ci->load->view('templates/index.php', $data);

		}
	}
		function profile( $template, $data = NULL)
	{
		$url 		= isset($data['url']) ? $data['url'] : null;
		$permission = (isset($data['permission'])) ? $data['permission'] : false;

		$status_link    = @$this->_ci->input->post('status_link');
		// if ($this->_check_link($url, $permission) === false) {
		// 	$template = 'templates/error_404';
		// }

		if ( $status_link == 'ajax' )
		{
			$data['_content']       = $this->_ci->load->view($template, $data, TRUE);

			$this->_ci->load->view('profile/content', $data);

		}
		else
		{
			$data['_content']       = $this->_ci->load->view($template, $data, TRUE);
			$data['_header']       = $this->_ci->load->view('profile/header', $data, TRUE);
			$data['_footer']        = $this->_ci->load->view('profile/footer', $data, TRUE);
			$data['_fullcontent']   = $this->_ci->load->view('profile/content', $data, TRUE);

			$this->_ci->load->view('profile/index.php', $data);

		}
	}

	function _check_link($data_url, $permission = false) {
		$arr_get_role   = [
			'table'     => 't_guru',
			'join'      => [['t_guru_role', 'role_id = jabatan']],
			'where'     => ['guru_id' => login_data('user_id')],
			'select'    => 'role_access'
		];
		$get_role       = $this->_ci->m_global->get($arr_get_role)[0]->role_access;
		
		$arr_get_menu   = [
			'table'     => 't_guru_menu',
			'where'     => ['menu_status' => '1'],
			'select'    => 'menu_id, menu_link',
			'where_e'   => '`menu_id` IN ('.$get_role.')'
		];
		$get_menu   = $this->_ci->m_global->get($arr_get_menu);

		$link       = $this->_check_acc($get_menu)['link'];

		$url        = str_replace(base_url(), '', $data_url);

		$arr_escape = [
			'table'     => 'additional_link',
			'where'     => ['al_status' => '1'],
			'select'    => 'al_link',
			'array'     => TRUE
		];
		$escape     = array_column($this->_ci->m_global->get( $arr_escape ), 'al_link');

		if(in_array($url, $link) || in_array($url, $escape)) {
			$role_permission = login_data('role_permission');

			if (strpos($role_permission, 'r') !== false) {
				if($permission !== false) {
					if (strpos($role_permission, $permission) !== false) {
						return true;
					} else {
						return false;
					}
				}
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function _check_acc($data) {
		$link = [];

		foreach ($data as $key => $val) {
			$link['id'][]   = $val->menu_id;
			$link['link'][] = $val->menu_link;
		}

		return $link;
	}

}
