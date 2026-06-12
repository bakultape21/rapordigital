<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends MX_Controller
{

	private $prefix         = 'siswa';
	private $url            = 'siswa';
	private $table_db       = 't_siswa';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['datatables'];

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}

	public function select()
	{
		$aCari = [
			'nama_lengkap'  => 'nama_lengkap',
			'no_induk'      =>  'no_induk'
		];

		$where      = NULL;
		$where_e    = ['sekolah_id'=> login_data('sekolah_id')];
		$join 		= [];

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
			// $where[$this->table_prefix . 'status <>']    = '99';
		}

		// if (login_data('user_id') !== '1') {
		// 	$where[$this->table_prefix . 'id <>'] = '1';
		// }

		$keys   = array_keys($aCari);
		@$order = [$aCari[$keys[($_REQUEST['order'][0]['column'] - 1)]], $_REQUEST['order'][0]['dir']];

		$arr_config['table'] 	= $this->table_db.' s';
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

		$select = ' *, ' . implode(',', $aCari);

		$arr_config['select'] 	= $select;
		$arr_config['order'] 	= $order;
		$arr_config['start'] 	= $iDisplayStart;
		$arr_config['show'] 	= $iDisplayLength;

		$result = $this->m_global->get($arr_config);

		$status= [
			'0'=> '<span class="badge badge-success">Belajar</span>',
			'1'=> '<span class="badge badge-danger">Lulus</span>',
		];


		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {
			$records["data"][] = array(
				$i,
				$rows->nama_lengkap,
				$rows->no_induk,
				$rows->nisn,
				$rows->tempat_lahir.', '.date('d-m-Y', strtotime($rows->tanggal_lahir)),
				$rows->alamat,
				$rows->nama_ibu,
				$status[$rows->status_siswa],
				$this->_button($rows->siswa_id),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	private function _button($id, $status= null)
	{
		// $html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by/' . strEncrypt($id) . '/' . ($status == 1 ? '0" data-original-title="Set to InActive"' : '1" data-original-title="Set to Active"')) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . ($status == 0 ? 'InActive' : ($status == 99 ? 'Deleted' : 'Active')) . '" class="fa fa' . ($status == 0 ? '-eye-slash' : ($status == 99 ? '-trash' : '-eye')) . '"></i></a>';

		$html = '<a href="' . base_url() . $this->url . '/show_edit/' . ($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction ajaxify" title="Edit">
					<i class="la la-edit"></i>
				</a>';

		// $html .= '<a href="' . base_url() . $this->prefix . '/delete/' . strEncrypt($id) . '" data-original-title="Hapus" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" data-permission="d" onClick="return deleteData(this, event);"><i class="la la-trash"></i></a>';

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

	

		$this->template->display(strtolower(__CLASS__) . '/add', $data);
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

	public function action_add()
	{
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('no_induk', 'Nomor Induk', 'trim|required');
		$this->form_validation->set_rules('nisn', 'nisn', 'trim|required');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
		$this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'trim|required');
		$this->form_validation->set_rules('nomor_telepon', 'Nomor Telepon Orang Tua', 'trim|required');
		$this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'trim|required');
		$this->form_validation->set_rules('pekerjaan_ayah', 'Pekerjaan Ayah', 'trim|required');
		$this->form_validation->set_rules('nama_ibu', 'Nama Ibu', 'trim|required');
		$this->form_validation->set_rules('pekerjaan_ibu', 'Pekerjaan Ibu', 'trim|required');
		$this->form_validation->set_rules('agama', 'Agama', 'trim|required');
		$this->form_validation->set_rules('nama_panggilan', 'Nama Panggilan', 'trim|required');

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

				$name 			= str_replace(' ', '_', trim($_FILES['foto_siswa']['name']));
				$fileNameParts 	= explode(".", $name);
				$fileExtension 	= end($fileNameParts);
				$fileExtension 	= strtolower($fileExtension);
				$fix_name_file 	= time() . "_pp." . $fileExtension;

				$config['file_name']		= $fix_name_file;
				$this->upload->initialize($config);

				if ($this->upload->do_upload('foto_siswa')) {
					$photo = $upload_path . '/' . $fix_name_file;
				}

			}

			$data_array = [
				'nama_lengkap' 	=> $post['nama_lengkap'],
				'nisn' 			=> $post['nisn'],
				'no_induk' 		=> $post['no_induk'],
				'nomor_telepon' => $post['nomor_telepon'],
				'tempat_lahir' 		=> $post['tempat_lahir'],
				'tanggal_lahir'	=>$post['tanggal_lahir'],
				'jenis_kelamin'=> $post['jenis_kelamin'],
				'alamat'	=> $post['alamat'],
				'nama_ayah'	=> $post['nama_ayah'],
				'foto_siswa'		=> $photo,
				'nama_ibu'	=> $post['nama_ibu'],
				'sekolah_id'=> login_data('sekolah_id'),
				'pekerjaan_ibu'	=> $post['pekerjaan_ibu'],
				'pekerjaan_ayah'	=> $post['pekerjaan_ayah'],
				'agama'=> $post['agama'],
				'nama_panggilan'=> $post['nama_panggilan']
			];

			$insert = [
				'table' => 't_siswa',
				'datas' => $data_array
			];

			$res  = $this->m_global->insert($insert);

			if ($res['status']) {
				$result['status']     = 1;
				$result['message']    = 'Berhasil Menambahkan Siswa <strong>' . $post['nama_lengkap'] . '</strong>';

				echo json_encode($result);
			} else {

				$result['status']     = 0;
				$result['message']    = 'Gagal Menambahkan Siswa  <strong>' . $post['nama_lengkap'] . '</strong>';
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


		$arr_conf 			= [
			'select'=> 's.*',
			'table'	=> 't_siswa s',
			'where'	=> ['siswa_id' => $id]
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];

		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}

	public function action_edit($id)
	{
		$result = [];
		$post 	= $this->input->post();


		$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('no_induk', 'Nomor Induk', 'trim|required');
		$this->form_validation->set_rules('nisn', 'nisn', 'trim|required');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
		$this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'trim|required');
		$this->form_validation->set_rules('nomor_telepon', 'Nomor Telepon Orang Tua', 'trim|required');
		$this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'trim|required');
		$this->form_validation->set_rules('pekerjaan_ayah', 'Pekerjaan Ayah', 'trim|required');
		$this->form_validation->set_rules('nama_ibu', 'Nama Ibu', 'trim|required');
		$this->form_validation->set_rules('pekerjaan_ibu', 'Pekerjaan Ibu', 'trim|required');
		$this->form_validation->set_rules('agama', 'Agama', 'trim|required');
		$this->form_validation->set_rules('nama_panggilan', 'Nama Panggilan', 'trim|required');


		if ($this->form_validation->run() == TRUE) {
			$photo = $post['foto_siswa_backup'];

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

				$name 			= str_replace(' ', '_', trim($_FILES['foto_siswa']['name']));
				$fileNameParts 	= explode(".", $name);
				$fileExtension 	= end($fileNameParts);
				$fileExtension 	= strtolower($fileExtension);
				$fix_name_file 	= time() . "_pp." . $fileExtension;

				$config['file_name']		= $fix_name_file;
				$this->upload->initialize($config);

				if ($this->upload->do_upload('foto_siswa')) {
					$photo = $upload_path . '/' . $fix_name_file;
				}else{
					exit();
				}
				// exit();
			}
			if ($post['tahun_lulus'] != null) {
				$status=1;
			}else{
				$status=0;
			}

		
			$data_array = [
				'nama_lengkap' 	=> $post['nama_lengkap'],
				'nisn' 			=> $post['nisn'],
				'no_induk' 		=> $post['no_induk'],
				'nomor_telepon' => $post['nomor_telepon'],
				'tempat_lahir' 		=> $post['tempat_lahir'],
				'tanggal_lahir'	=>$post['tanggal_lahir'],
				'jenis_kelamin'=> $post['jenis_kelamin'],
				'alamat'	=> $post['alamat'],
				'nama_ayah'	=> $post['nama_ayah'],
				'foto_siswa'		=> $photo,
				'nama_ibu'	=> $post['nama_ibu'],
				'sekolah_id'=> login_data('sekolah_id'),
				'pekerjaan_ibu'	=> $post['pekerjaan_ibu'],
				'pekerjaan_ayah'	=> $post['pekerjaan_ayah'],
				'agama'=> $post['agama'],
				'nama_panggilan'=> $post['nama_panggilan'],
				'tahun_lulus'=> $post['tahun_lulus'],
				'status_siswa'=> $status
			];



			$update = [
				'table' => $this->table_db,
				'datas'	=> $data_array,
				'where'	=> ['siswa_id' => $id]
			];

			$result = $this->m_global->update($update);

			if ($result['status']) {
				$data['status']     = 1;
				$data['message']    = 'Berhasil Edit Siswa <strong>' . $post['nama_lengkap'] . '</strong>';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Gagal Edit Siswa <strong>' . $post['nama_lengkap'] . '</strong>';
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