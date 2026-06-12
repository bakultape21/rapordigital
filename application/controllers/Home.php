<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function  __construct()
	{
		parent:: __construct();
		$this->load->helper('url'); 
	}
	public function index()
	{
		// redirect('user/login');
		header("Location: ".base_url()."/user/login");
		exit();
		die();
	}
	public function kebijakan_privasi()
	{	
		
		$this->load->view('privacy_policy');
	}
	public function privacy_policy()
	{	
		
		$this->load->view('privacy_policy');
		
	}
	public function privacy()
	{	
		$this->load->view('privacy_policy');
	}
	
}