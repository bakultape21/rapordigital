<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends MX_Controller
{

	private $prefix         = 'kelas';
	private $url            = 'kelas';
	private $table_db       = 't_kelas_belajar';
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
			'nama_kelas'    => 'nama_kelas'
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= [
			['t_guru d', 's.guru_id = d.guru_id'],
			['t_sekolah k', 'k.sekolah_id = d.sekolah_id'],
			['(select count(*) as total_siswa, kelas_id from t_kelas_belajar_data group by kelas_id) kd', 'kd.kelas_id= s.kelas_id', 'left']

		];

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

		$select = ' s.*, d.*, k.*, kd.total_siswa, ' . implode(',', $aCari);

		$arr_config['select'] 	= $select;
		$arr_config['order'] 	= $order;
		$arr_config['start'] 	= $iDisplayStart;
		$arr_config['show'] 	= $iDisplayLength;

		$result = $this->m_global->get($arr_config);

		$semester=['1'=> '<span class="badge badge-success">Ganjil</span>', '2'=>'<span class="badge badge-warning">Genap</span'];


		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {
			$records["data"][] = array(
				$i,
				$rows->guru_nama,
				$rows->email,
				$rows->nama_kelas,
				$rows->total_siswa.' ',
				$rows->tahun.'/'.$semester[$rows->semester],
				$rows->sekolah_nama,
				$this->_button($rows->kelas_id, $rows->kelas_status),
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
			'table'	=> 't_kelas_belajar k',
			'select'=> '*',
			'join'	=>[
				['t_guru g', 'g.guru_id = k.guru_id'],
			],
			'where'	=> [strEncrypt('kelas_id', TRUE) => $id]
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];

	

		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}

	private function _button($id, $status= null)
	{
		$html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by/' . strEncrypt($id) . '/' . 
    // Jika status 1 (Terkunci), link menuju 0 (Buka). Jika 0 (Open), link menuju 1 (Kunci).
    ($status == 1 ? '0" data-original-title="Set to Open"' : '1" data-original-title="Set to Locked"')) . 
    ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . 
    // Title pada icon
    ($status == 1 ? 'Terkunci' : 'Open') . 
    '" class="fa fa' . 
    // Class Icon: Status 1 = Lock, Status 0 = Unlock
    ($status == 1 ? '-lock' : '-unlock') . 
    '"></i></a>';

		$html .= '<a href="' . base_url() . $this->url . '/show_edit/' . strEncrypt($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction ajaxify" title="Edit">
					<i class="la la-edit"></i>
				</a>';
		$html .= '<button class="btn btn-danger btn-sm btn-icon-md " onclick="return hapus('."'".$id."'".') ">hapus</button>';

		return $html;
	}
	public function change_status_by($id, $status, $stat = FALSE)
	{
		if ($stat) {
			$delete = [
				'table' => $this->table_db,
				'where' => [strEncrypt( 'kelas_id', TRUE) => $id]
			];

			$result = $this->m_global->delete($delete);
		} else {
			$update = [
				'table' 	=> $this->table_db,
				'datas' 	=> [ 'kelas_status' => $status],
				'where' 	=> [strEncrypt('kelas_id', TRUE) => $id]
			];

			$result = $this->m_global->update($update);
		}

		if ($result) {
			$data['status'] = 1;
		} else {

			$data['status'] = 0;
		}

		echo json_encode($data);
	}
	public function delete_kelas()
	{
		if ($_POST) {

			$cek_data= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['kelas_id'=> $_POST['kelas_id']]]);

			
			if (@$cek_data[0] != null) {

				$this->m_global->delete(['table'=> 't_kelas_belajar_data', 'where'=> ['kelas_id'=> $cek_data[0]->kelas_id]]);
				// $this->m_global->delete(['table'=> 't_kelas_belajar_kegiatan_bulanan', 'where'=> ['kelas_id'=> $cek_data[0]->kelas_id]]);
				// $this->m_global->delete(['table'=> 't_kelas_belajar_kegiatan_mingguan', 'where'=> ['kelas_id'=> $cek_data[0]->kelas_id]]);
				$this->m_global->delete(['table'=> 't_kelas_belajar', 'where'=> ['kelas_id'=> $cek_data[0]->kelas_id]]);

				$data['status']     = 1;
				$data['message']    = 'Successfully edit Kelas';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed edit Kelas';
				if (ENVIRONMENT == 'development')
					$data['error']  = $this->db->error();

				echo json_encode($data);
			}
		}
	}

	public function action_edit($id)
	{
		$result = [];
		$post 	= $this->input->post();


		$this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
		

		if ($this->form_validation->run() == TRUE) {

			
			$data_array = [
				'tahun' 		=> $post['tahun'],
				'semester'		=> $post['semester'],
				'nama_kelas'	=> $post['nama_kelas']
			];

			$update = [
				'table' => $this->table_db,
				'datas'	=> $data_array,
				'where'	=> [strEncrypt('kelas_id', TRUE) => $id]
			];

			$result = $this->m_global->update($update);

			if ($result['status']) {
				$data['status']     = 1;
				$data['message']    = 'Successfully edit Kelas';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed edit Kelas';
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