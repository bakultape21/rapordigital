<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Failed extends MX_Controller
{
	private $prefix         = 'error';
	private $url            = 'error';
	private $table_db       = '';
	private $table_prefix   = '';
	private $title 			= 'Error';

	public function error_404()
	{
		$data['title']		= $this->title . ' 404';
		$data['breadcrumb'] = [$this->title . '_404' => base_url() . $this->url . '_404'];
		$data['url']		= base_url() . $this->url . '/' . $this->url . '_404';
		$data['prefix']		= $this->prefix;

		$this->template->display('templates/error_404', $data);
	}
}

/* End of file Failed.php */
/* Location: ./application/modules/failed/controllers/Failed.php */