<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$CI = &get_instance();
$CI->load->library('session');

$ex = array('login');

$session_name	= $CI->config->item('session_name');

$user_data 		= $CI->session->userdata($session_name);

$status_link	= @$CI->input->post('status_link');

$path_info 		= ltrim(@$_SERVER['PATH_INFO'], '/');
$bypass			= $CI->config->item('bypass');

if (!in_array($path_info, $bypass)) {
	if (!empty($user_data) and ((in_array($this->uri->segment(1), $ex) and $this->uri->segment(2) != "out") or $this->uri->segment(1) == "")) {
		redirect(base_url('dashboard'));
	} else if (empty($user_data) and !in_array($this->uri->segment(1), $ex)) {
		if ($status_link == 'ajax') {
			echo 'out';
			die();
		} else {
			redirect(base_url('login'));
		}
	}
} else {
	return true;
}
