<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends MX_Controller
{

	private $prefix         = 'guru';
	private $url            = 'guru';
	private $table_db       = 't_guru';
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
			'guru_nama'  => 'guru_nama',
			'sekolah_id' =>  's.sekolah_id',
			'kabupaten_id'    => 'k.kabupaten_id'
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= [
			['t_sekolah d', 's.sekolah_id = d.sekolah_id'],
			['kabupaten k', 'k.kabupaten_id= d.kabupaten_id'],
			['(select count(kelas_id) as tot_semester, guru_id from t_kelas_belajar group by guru_id) kl', 'kl.guru_id= s.guru_id', 'left']

		];

		if (@$_REQUEST['action'] == 'filter') {
			$where = [];
			foreach ($aCari as $key => $value) {
				if ($_REQUEST[$key] != '') {
					if ($key == 'lastupdate') {
						$tmp = explode(' ', $_REQUEST[$key]);
						$where_e = "DATE(" . $this->table_prefix . "lastupdate) BETWEEN '" . $this->db->escape_str($tmp[0]) . "' AND '" . $this->db->escape_str($tmp[1]) . "'";
					} else if ($key == 'sekolah_id') {
						$where[$value] = $_REQUEST[$key];
					} else {
						$where[$value . ' LIKE '] = '%' . $_REQUEST[$key] . '%';
					}
				}
			}
		} else {
			// $where[$this->table_prefix . 'status <>']    = '99';
		}


		$keys   = array_keys($aCari);
		@$order = [$aCari[$keys[($_REQUEST['order'][0]['column'] - 1)]], $_REQUEST['order'][0]['dir']];

		$arr_config['table'] 	= $this->table_db.' s';
		$arr_config['where'] 	= $where;
		$arr_config['where_e'] 	= $where_e;
		$arr_config['join'] 	= $join;
		// $arr_config['group']	= 's.guru_id';

		$iTotalRecords  = $this->m_global->count($arr_config);
		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  = intval($_REQUEST['start']);
		$sEcho          = intval($_REQUEST['draw']);

		$records        = array();
		$records["data"] = array();

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$select = ' s.*,k.*, kl.tot_semester, d.sekolah_nama, ' . implode(',', $aCari);

		$arr_config['select'] 	= $select;
		$arr_config['order'] 	= $order;
		$arr_config['start'] 	= $iDisplayStart;
		$arr_config['show'] 	= $iDisplayLength;

		$result = $this->m_global->get($arr_config);


		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {
			$records["data"][] = array(
				$i,
				$rows->guru_nama,
				$rows->email,
				$rows->nip,
				'<span class="badge badge-secondary">'.$rows->kabupaten."</span>",
				$rows->sekolah_nama,
				$rows->nomor_telepon,
				'<span class="badge badge-primary">'.$rows->tot_semester.'</span>',
				'<span class="badge badge-danger">'.$rows->batas_semester.'</span>',
				$this->_button($rows->guru_id),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
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
			'table'	=> 't_guru s',
			'select'=> 's.*, d.sekolah_nama',
			'join'	=>[
				['t_sekolah d', 's.sekolah_id = d.sekolah_id'],
			],
			'where'	=> [strEncrypt('guru_id', TRUE) => $id]
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];
	

		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}

	private function _button($id, $status= null)
	{
		// $html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by/' . strEncrypt($id) . '/' . ($status == 1 ? '0" data-original-title="Set to InActive"' : '1" data-original-title="Set to Active"')) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . ($status == 0 ? 'InActive' : ($status == 99 ? 'Deleted' : 'Active')) . '" class="fa fa' . ($status == 0 ? '-eye-slash' : ($status == 99 ? '-trash' : '-eye')) . '"></i></a>';

		$html = '<a href="' . base_url() . $this->url . '/show_edit/' . strEncrypt($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction ajaxify" title="Edit">
					<i class="la la-edit"></i>
				</a>';

		return $html;
	}

		public function action_edit($id)
	{
		$result = [];
		$post 	= $this->input->post();


		$this->form_validation->set_rules('guru_nama', 'Guru Nama', 'trim|required');
		

		if ($this->form_validation->run() == TRUE) {

			
			$data_array = [
				'guru_nama' 		=> $post['guru_nama'],
				'email' 				=> $post['email'],
				'nip' 				=> $post['nip'],
				'nomor_telepon'			=> $post['nomor_telepon'],
				'jabatan'			=> $post['jabatan'],
				'sekolah_id'		=> $post['sekolah_id'],
				'batas_semester'	=> $post['batas_semester']

			];

			if ($_POST['password_new']!= null) {
				$password = md5_mod($this->input->post('password_new'), $this->input->post('email'));
				$data_array['password']= $password;
			}


			$update = [
				'table' => $this->table_db,
				'datas'	=> $data_array,
				'where'	=> [strEncrypt('guru_id', TRUE) => $id]
			];

			$result = $this->m_global->update($update);

			if ($result['status']) {
				$data['status']     = 1;
				$data['message']    = 'Successfully edit Guru with Name <strong>' . $post['guru_nama'] . '</strong>';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed edit Guru with Name <strong>' . $post['guru_nama'] . '</strong>';
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