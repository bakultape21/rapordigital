<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * [Fungsi untuk generate menu]
 * @return [array] [Array menu]
 */

function _getUserAccess()
{
	$CI = &get_instance();

	$get['table']   = 't_guru';
	$get['join']    = [['t_guru_role', 'role_id = jabatan']];
	$get['where']   = ['guru_id' => login_data('user_id')];
	$get['select']  = 'role_access';

	$result = $CI->m_global->get($get)[0]->role_access;

	return $result;
}

function menu($all = '', $access = null)
{
	$CI = &get_instance();

	$type = $CI->config->item('menu');

	$result = [];

	if ($type == 'database' || $type == '') {
		$in = ($access == null) ? _getUserAccess() : $access;

		$where_e        = ($all === '') ? '`menu_id` IN (' . $in . ')' : null;

		$get['table']   = 't_guru_menu';
		$get['where']   = ['menu_status' => '1', 'menu_parent' => '0'];
		$get['where_e'] = $where_e;
		$get['order']   = ['menu_number', 'ASC'];

		$menu_db    = $CI->m_global->get($get);

		foreach ($menu_db as $key => $val) {
			$result[] = [
				'id'   => $val->menu_id,
				'name' => $val->menu_label,
				'link' => _linkDB($val, $all, $access),
				'icon' => $val->menu_icon,
			];
		}
	} else {
		$result = _hardcode_menu();
	}

	return $result;
}

function _linkDB($val, $all, $access)
{
	$CI         = &get_instance();
	$in 		= ($access == null) ? _getUserAccess() : $access;
	$where_e    = ($all === '') ? '`menu_id` IN (' . $in . ')' : null;

	$get['table']   = 't_guru_menu';
	$get['where']   = ['menu_status' => '1', 'menu_parent' => $val->menu_id];
	$get['where_e'] = $where_e;
	$get['order']   = ['menu_number', 'ASC'];

	$link = $CI->m_global->get($get);

	$resultLink = [];

	if ($link) {
		foreach ($link as $k => $v) {
			$resultLink[] = [
				'id'   => $v->menu_id,
				'name' => $v->menu_label,
				'link' => _linkDB($v, $all, $access),
				'icon' => $v->menu_icon,
			];
		}
	} else {
		$resultLink = $val->menu_link;
	}

	return $resultLink;
}

function _hardcode_menu()
{
	$html = [];

	// menu home
	$dashboard = ['name' => 'Dashboard', 'link' => 'dashboard', 'icon' => 'flaticon2-protection'];

	// menu config
	$companies	= ['name' => 'Companies', 	'link' => 'config/companies', 	'icon' => ''];
	$user 		= ['name' => 'User', 		'link' => 'config/user', 		'icon' => ''];
	$role 		= ['name' => 'Role', 		'link' => 'config/role', 		'icon' => ''];

	$config = ['name' => 'Config', 'link' => [$companies, $user, $role], 'icon' => 'flaticon-cogwheel-2'];

	$html = [
		$dashboard,
		$config
	];

	return $html;
}

function v_menu($menu, $url)
{
	if (!isset($url[1])) {
		$url[1] = 'dashboard';
	}

	foreach ($menu as $key => $val) {
		$link   	= 'javascript:;';
		$span   	= '<i class="kt-menu__ver-arrow la la-angle-right"></i>';
		$li_class  	= 'kt-menu__item--submenu';
		$a_class  	= 'kt-menu__link kt-menu__toggle';
		$data 		= 'data-ktmenu-submenu-toggle="hover"';

		if (!is_array($val['link'])) {
			$link   	= base_url($val['link']);
			$span   	= '';
			$li_class  	= '';
			$a_class  	= 'ajaxify kt-menu__link';
			$data 		= '';
		}

		echo '
			<li class="kt-menu__item ' . $li_class . '" aria-haspopup="true" ' . $data . '>
				<a href="' . $link . '" class="' . $a_class . '">
					<i class="kt-menu__link-icon ' . $val['icon'] . '"></i>
					<span class="kt-menu__link-text">' . $val['name'] . '</span>
					' . $span . '
				</a>
				' . (is_array($val['link']) ?
			'<div class="kt-menu__submenu ">
						<span class="kt-menu__arrow"></span>
						<ul class="kt-menu__subnav">
							<li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
								<span class="kt-menu__link">
									<span class="kt-menu__link-text">' . $val['name'] . '</span>
								</span>
							</li>' .
			_submenu($val['link'], $url)
			. '</ul>
					</div>'
			: '') . '
			</li>
		';
	}
}

function _submenu($val, $url)
{
	$result = '';

	foreach ($val as $k => $v) {
		$link   	= 'javascript:;';
		$span   	= '<i class="kt-menu__ver-arrow la la-angle-right"></i>';
		$li_class  	= 'kt-menu__item--submenu';
		$a_class  	= 'kt-menu__link kt-menu__toggle';

		if (!is_array($v['link'])) {
			$link   	= base_url($v['link']);
			$span   	= '';
			$li_class  	= '';
			$a_class  	= 'ajaxify kt-menu__link';
		}

		$result .= '<li class="kt-menu__item ' . $li_class . '" aria-haspopup="true">
						<a href="' . $link . '" class="' . $a_class . '">
							<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
							<span class="kt-menu__link-text">' . $v['name'] . '</span>
							' . $span . '
						</a>
						' . (is_array($v['link']) ?
			'<div class="kt-menu__submenu ">
								<span class="kt-menu__arrow"></span>
								<ul class="kt-menu__subnav">' .
			_submenu($v['link'], $url)
			. '</ul>
							</div>'
			: '') . '
					</li>';
	}

	return $result;
}

function v_tree_view($menu, $access = null)
{
	$data_access = ['1'];

	if ($access) {
		$data_access = explode(', ', $access);
	}

	$html = '<ul id="rolesData" style="display: none;">';
	foreach ($menu as $key => $val) {
		$selected = '';

		if (!is_array($val['link'])) {
			$selected = (in_array($val['id'], $data_access)) ? "data-jstree='{\"selected\" : true}'" : '';
		}

		$html .=  '<li id="id_node_' . $val['id'] . '" ' . $selected . '>'
			. $val['name']
			. (is_array($val['link']) ?
				'<ul>' .
				_tree_submenu($val['link'], $data_access)
				. '</ul>'
				: '') . '
		</li>';
	}

	$html .= '</ul>';

	echo $html;
}

function _tree_submenu($val, $access = null)
{
	$html = '';
	foreach ($val as $k => $v) {
		$selected = '';

		if (!is_array($v['link'])) {
			$selected = (in_array($v['id'], $access)) ? "data-jstree='{\"selected\" : true}'" : '';
		}


		$html .=  '<li id="id_node_' . $v['id'] . '" ' . $selected . '>'
			. $v['name']
			. (is_array($v['link']) ?
				'<ul>' .
				_tree_submenu($v['link'], $access)
				. '</ul>'
				: '') . '
		</li>';
	}

	return $html;
}

function v_list_menu($menu)
{
	$html = '<div class="dd" id="nestable_list">';
	$html .= '<ol class="dd-list">';
	foreach ($menu as $key => $val) {
		$html .= '<li class="dd-item" data-id="' . $val['id'] . '">'
			. '<div class="dd-handle" style="border-radius: 0px;"> ' . $val['name'] . ' </div>'
			. (is_array($val['link']) ?
				'<ol class="dd-list">' .
				_list_submenu($val['link'], $val['id'])
				. '</ol>'
				: '') . '
					</li>';
	}
	$html .= '</ol>';
	$html .= '</div>';

	echo $html;
}

function _list_submenu($val, $id)
{
	$html = '';
	foreach ($val as $k => $v) {
		$html .= '<li class="dd-item" data-id="' . $v['id'] . '">'
			. '<div class="dd-handle" style="border-radius: 0px;"> ' . $v['name'] . ' </div>'
			. (is_array($v['link']) ?
				'<ol class="dd-list">' .
				_list_submenu($v['link'], $id)
				. '</ol>'
				: '') . '
		</li>';
	}

	return $html;
}
