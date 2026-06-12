<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$ci = new MX_Controller();
	$ci =& get_instance();
	$ci->load->helper('url');
	$ci->load->library('session');

	$ajax = $_POST['status_link'];

	$url = base_url('error/error_404');

	if(@$ajax) {
		return true;
	} else {
		header('Location:'.$url);
	}
?>