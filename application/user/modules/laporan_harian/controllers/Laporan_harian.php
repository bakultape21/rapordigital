<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_harian extends MX_Controller
{

	private $prefix         = 'laporan_harian';
	private $url            = 'laporan_harian';
	private $table_db       = 't_nilai_belajar_tp';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index($kelas_id=null)
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		if (login_data('user_role')==3) {
			$data['kelas_list']	= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['sekolah_id'=> login_data('sekolah_id')]]);
		}else{
			$data['kelas_list']	= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['guru_id'=> login_data('user_id')]]);
		}

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}

	public function select($kelas_id=null)
	{
		$aCari = [
			'nama_kelas'  => 'nama_kelas',
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= [['t_cp_kelas_belajar c', 'c.cp_id= k.cp_id'], ['t_kelas_belajar ks', 'ks.kelas_id= c.kelas_id']];

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
			$where['ks.kelas_id']    = $kelas_id;
		}

		// if (login_data('user_id') !== '1') {
		// 	$where[$this->table_prefix . 'id <>'] = '1';
		// }

		$keys   = array_keys($aCari);
		@$order = [$aCari[$keys[($_REQUEST['order'][0]['column'] - 1)]], $_REQUEST['order'][0]['dir']];

		$arr_config['table'] 	= ' t_kelas_belajar_kegiatan k';
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

		// echo $this->db->last_query();
		// exit();


		$semester=[
			'1'=> '<label class="badge badge-primary"> Ganjil</label>',
			'2'=> '<label class="badge badge-danger"> Genap</label>'
		];


		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {
			$records["data"][] = array(
				$i,
				$rows->kegiatan_belajar,
				$rows->kegiatan_tanggal,
				$rows->capaian_belajar,
				$rows->nama_kelas,
				$rows->tahun.'/'.$semester[$rows->semester],				
				$this->_button($rows->kegiatan_id),
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

		// $html = '<a href="' . base_url() . $this->url . '/show_edit/' . strEncrypt($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-warning btn-icon-md btn-sm p-1 tooltips btnAction ajaxify" title="Edit">
		// 			Edit</i>
		// 		</a> ';

		// $html .= '<a href="' . base_url() . $this->prefix . '/delete/' . strEncrypt($id) . '" data-original-title="Hapus" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" data-permission="d" onClick="return deleteData(this, event);"><i class="la la-trash"></i></a>';

		$html = '<a href="' . base_url() . $this->prefix . '/cetak/' . strEncrypt($id) . '" target="_blank" data-original-title="detail" class="btn btn-sm p-1 btn-sm btn-success tooltips "> Cetak Laporan</a> ';

		// $html .= '<a href="' . base_url() . '/cp_belajar/index/' . strEncrypt($id) . '" data-original-title="CP Belajar" class="btn btn-sm  btn-sm p-1 btn-icon-md tooltips btn-primary btnAction" >CP belajar</a>  ';

		return $html;
	}
	public function cek_tanggal()
	{
		if ($_POST) {

			$query= $this->m_global->get([
				'table'=>'t_kelas_belajar_kegiatan k',
				'join'=> [['t_cp_kelas_belajar cp', 'cp.cp_id= k.cp_id']],
				'where'=> ['cp.kelas_id'=> $_POST['kelas_id'], 'kegiatan_tanggal'=> $_POST['tanggal']]
			]);

			if (@$query[0] != null) {

				$result['status']     = 1;
				$result['message']    = 'Laporan <strong>Tersedia</strong>';

				echo json_encode($result);			
			}else{
				$result['status']     = 2;
				$result['message']    = 'Laporan <strong>Tidak Tersedia</strong>';

				echo json_encode($result);	
			
			};
		}
	}
	public function cetak($id=null){

	}
	public function action_laporan_harian()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['guru_sekolah']= $this->m_global->get([

			'table'=> 't_kelas_belajar k',
			'join'=> [
				['t_sekolah s', 's.sekolah_id= k.sekolah_id' ],
				['t_guru g', 'g.guru_id=k.guru_id'],
				['kabupaten b', 'b.kabupaten_id= s.kabupaten_id']

			],
			'where'=> ['k.kelas_id'=> $_POST['kelas_id']]])[0];

		$data['elemen']= $this->m_global->get([
			'table'=> 't_sekolah_elemen_data sd', 
			'join'=> [
				['t_sekolah_elemen c', 'c.sekolah_elemen_id= sd.sekolah_elemen_id'], 
				['t_sekolah s', 's.sekolah_id= c.sekolah_id']],
			'where'=> ['s.sekolah_id'=> $data['guru_sekolah']->sekolah_id, 'sekolah_elemen_status'=> 1],
			'order'=> ['sd.elemen_nomor', 'asc']
				]
			);

		// echo $this->db->last_query();
		// exit();

		$data['cp_belajar']= $this->m_global->get([
			'select'=> 'group_concat(c.cp_nomor) as cp_belajar_tp',
			'table'=> 't_sekolah_elemen_data sd', 
			'join'=> [
				['t_cp_kelas_belajar c', 'c.elemen_data_id= sd.elemen_data_id'], 
				['t_kelas_belajar_kegiatan k', 'k.cp_id= c.cp_id']],
			'where'=> ['kegiatan_tanggal is null or kegiatan_tanggal ='=> $_POST['tanggal'], 'c.kelas_id'=> $_POST['kelas_id']],
			'group'=> 'sd.elemen_data_id',
			'order'=> ['sd.elemen_nomor', 'asc']
				]
			);

		$data['kegiatan_belajar']= $this->m_global->get([
			'select'=> 'group_concat(kegiatan_belajar SEPARATOR  "<br>") as kegiatan_belajar_nilai',
			'table'=> 't_sekolah_elemen_data sd', 
			'join'=> [
				['t_cp_kelas_belajar c', 'c.elemen_data_id= sd.elemen_data_id'], 
				['t_kelas_belajar_kegiatan k', 'k.cp_id= c.cp_id']],
			'where'=> ['kegiatan_tanggal is null or kegiatan_tanggal ='=> $_POST['tanggal'], 'c.kelas_id'=> $_POST['kelas_id']],
			'group'=> 'sd.elemen_data_id',
			'order'=> ['sd.elemen_nomor', 'asc']
				]
			);
		$data['siswa']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'select'=> 's.*, td.*',
			'join'=> [
					['t_kelas_belajar_data td', 'td.kelas_id= k.kelas_id'], 
					['t_siswa s', 's.siswa_id= td.siswa_id'],
					['t_sekolah_elemen se', 'k.sekolah_id= se.sekolah_id'],
					['t_sekolah_elemen_data e', 'e.sekolah_elemen_id= se.sekolah_elemen_id']
				],
			'where'=> ['k.kelas_id'=> $_POST['kelas_id']],
			'group'=> 's.siswa_id'

		]);
		$data['nilai']= $this->m_global->get([
			"table"=>"(select siswa_kelas_id, max(kegiatan_nilai) as nilai, e.elemen_data_id from t_kelas_belajar_kegiatan k 
			join t_kelas_belajar_kegiatan_nilai kd on k.kegiatan_id= kd.kegiatan_id
			join t_cp_kelas_belajar cp on cp.cp_id= k.cp_id
			join t_sekolah_elemen_data e on e.elemen_data_id= cp.elemen_data_id
			where k.kegiatan_tanggal='".$_POST['tanggal']."' and cp.kelas_id='".$_POST['kelas_id']."' 
			group by e.elemen_data_id, siswa_kelas_id order by e.elemen_nomor) n"]);

		// echo $this->db->last_query();
		// exit();
	
		
		$this->load->view('preview_harian', $data);
	}
	



}