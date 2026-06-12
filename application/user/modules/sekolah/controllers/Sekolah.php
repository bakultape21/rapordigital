<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sekolah extends MX_Controller
{

	private $prefix         = 'sekolah';
	private $url            = 'sekolah';
	private $table_db       = 't_sekolah';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['validation'];

		$query		= [ 'select'=> 's.*','table'=> 't_sekolah s', 'join'=> [['t_guru g', 's.sekolah_id= g.sekolah_id']], 'where'=> ['guru_id'=> login_data('user_id')]];

		$data['record']= $this->m_global->get($query)[0];

		

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}

	public function action_add()
	{
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('sekolah_nama', 'Nama Sekolah', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('nomor_telepon', 'nomor_telepon', 'trim|required');
		$this->form_validation->set_rules('npsn', 'Password', 'trim|required');
		$this->form_validation->set_rules('sk', 'SK', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
		$this->form_validation->set_rules('akreditasi', 'akreditasi', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('dinas_penaung', 'Dinas Penaung', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$photo = null;

			if ($_FILES) {
				$upload_path = 'uploads';

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

				$name 			= str_replace(' ', '_', trim($_FILES['logo']['name']));
				$fileNameParts 	= explode(".", $name);
				$fileExtension 	= end($fileNameParts);
				$fileExtension 	= strtolower($fileExtension);
				$fix_name_file 	= time() . "_pp." . $fileExtension;

				$config['file_name']		= $fix_name_file;
				$this->upload->initialize($config);

				if ($this->upload->do_upload('logo')) {
					$photo = $upload_path . '/' . $fix_name_file;
				}else{
					echo $this->upload->display_errors();
					exit();
				}
			}else{
				$photo= $post['logo_backup'];
			}

			$data_array = [
				'sekolah_nama' 	=> $post['sekolah_nama'],
				'email' 		=> $post['email'],
				'npsn' 			=> $post['npsn'],
				'sk' 			=> $post['sk'],
				'alamat' 		=> $post['alamat'],
				'akreditasi' 	=> $post['akreditasi'],
				'alamat'		=> $post['alamat'],
				'dinas_penaung' => $post['dinas_penaung'],
				'yayasan'		=> $post['yayasan'],
				'nomor_telepon' => $post['nomor_telepon'],
				'logo'			=> $photo
			];

			$update = [
				'table' => $this->table_db,
				'datas' => $data_array,
				'where'=> ['sekolah_id'=> login_data('sekolah_id')]
			];

			$res  = $this->m_global->update($update);

			if ($res['status']) {
				$result['status']     = 1;
				$result['message']    = 'Successfully Edit with Name <strong>' . $post['sekolah_nama'] . '</strong>';

				echo json_encode($result);
			} else {

				$result['status']     = 0;
				$result['message']    = 'Failed Edit with Name <strong>' . $post['sekolah_nama'] . '</strong>';
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
	
	
}