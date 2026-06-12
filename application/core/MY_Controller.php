<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	function __construct() {
		parent::__construct();
		if (!$this->session->userdata('bka_user')) {
			redirect(base_url('admin/auth'));
		}
	}

	public function loadview($data=NULL,$page=NULL,$jscript=NULL)
	{
		$this->load->view('admin/template/v_header',$data);
		if($page != NULL){
			$this->load->view($page,$data);
		} else {
			$this->load->view('admin/template/v_content',$data);
		}
		$this->load->view('admin/template/v_footer',$data);
		if($jscript != NULL){
			$this->load->view($jscript,$data);
		}
		$this->load->view('admin/template/v_closing',$data);
	}
}
