<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

	private $prefix         = 'dashboard';
	private $url            = 'dashboard';
	private $table_db       = '';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['validation'];

		$data['code_register']= $this->m_global->get(['table'=> 't_code_register'])[0];

		$this->template->display('index', $data);
	}
	public function update()
	{
		$result = [];
		$post 	= $this->input->post();


		$this->form_validation->set_rules('code', 'Code', 'trim|required');
		$this->form_validation->set_rules('sampai', 'Batas waktu', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			
			$data_array = [
				'sampai' 		=> $post['sampai'],
				'code' 				=> $post['code']
			];

			$update = [
				'table' => 't_code_register',
				'datas'	=> $data_array,
				'where'	=> ['id' => '1']
			];

			$result = $this->m_global->update($update);

			if ($result['status']) {
				$data['status']     = 1;
				$data['message']    = 'Successfully ';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed';
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

/* End of file Dashboard.php */
/* Location: ./application/modules/dashboard/controllers/Dashboard.php */