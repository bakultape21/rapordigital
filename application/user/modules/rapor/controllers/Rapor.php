<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rapor extends MX_Controller
{

	private $prefix         = 'rapor';
	private $url            = 'rapor';
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

		$this->load->library('cart');
		$this->cart->destroy();


		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}
	public function delete_siswa($rowid='')
	{
		$this->load->library('cart');

		$update = array(
			'rowid'   => $rowid,
			'qty'     => 0
		);

		$this->cart->update($update); 

		$data['title']		= 'Add - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation'];
		$data['siswa_data']	= $this->cart->contents();

		$this->template->display(strtolower(__CLASS__) . '/add', $data);
	}


	public function select()
	{
		$aCari = [
			'nama_kelas'  => 'nama_kelas',
		];

		$where      = NULL;
		$where_e    = NULL;
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
			// $where['sekolah_id']    = login_data('sekolah_id');
			// $where['guru_id']   	= login_data('user_id');
		}

		// if (login_data('user_id') !== '1') {
		// 	$where[$this->table_prefix . 'id <>'] = '1';
		// }

		$where_e['sekolah_id']    = login_data('sekolah_id');
		$where_e['guru_id']   	= login_data('user_id');

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
		// echo $this->db->last_query();
		// exit();

		$semester=[
			'1'=> '<label class="badge badge-primary"> Ganjil</label>',
			'2'=> '<label class="badge badge-danger"> Genap</label>'
		];

		$status=[
			'0'=> '<label class="badge badge-warning"> Berjalan </label>',
			'1'=> '<label class="badge badge-success"> Selesai</label>'
		];

		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {
			$records["data"][] = array(
				$i,
				$rows->nama_kelas,
				$rows->tahun,
				$semester[$rows->semester],
				$status[$rows->kelas_status],				
				$this->_button($rows->kelas_id),
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

		$html = '<a href="' . base_url() . $this->url . '/harian/' . ($id) . '" data-permission="w" data-original-title="Rapor Nilai Harian" class="btn btn-sm btn-warning btn-icon-md btn-sm p-1 tooltips btnAction ajaxify" title="Rapor Dari Harian">
					Rapor Dari Harian
				</a> ';


		// $html .= '<a href="' . base_url() . $this->prefix . '/delete/' . strEncrypt($id) . '" data-original-title="Hapus" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" data-permission="d" onClick="return deleteData(this, event);"><i class="la la-trash"></i></a>';

		$html .= '<a href="' . base_url() . '/rapor/show_add_cp/' . ($id) . '" data-original-title="Rapor dari CP" class="btn btn-sm p-1 btn-sm btn-success tooltips ajaxify ">Rapor Dari CP</a> ';
		$html .= '<a href="' . base_url() . '/absensi/index/' . ($id) . '" data-original-title="Rekap Absensi" class="btn btn-sm p-1 btn-sm btn-danger tooltips ajaxify"> Rekap Absensi</a> ';

		return $html;
	}
	public function get_data_siswa_foto()
	{
		if ($_POST) {

			$data= $this->m_global->get([

			'select'=> 'e.*, s.*, r.foto',
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id'], ['t_kelas_belajar_rapor_foto r', 'r.elemen_data_id= e.elemen_data_id', 'left']],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> [
				'sekolah_elemen_status'=> 1,  
				'r.siswa_kelas_id'=> $_POST['siswa_kelas_id']]] );



			if (@$data[0] == null) {
				$data= $this->m_global->get([
					'select'=> 'e.*, ed.*, "" as foto',
					'table'=> 't_kelas_belajar_data kd',
					'join'=> [
						['t_kelas_belajar k', 'k.kelas_id= kd.kelas_id'],
						['t_sekolah s ', 's.sekolah_id= k.sekolah_id'],
						['t_sekolah_elemen e', 'e.sekolah_id= s.sekolah_id'],
						['t_sekolah_elemen_data ed', 'ed.sekolah_elemen_id= e.sekolah_elemen_id']
					],
					'where'=> ['sekolah_elemen_status'=> 1, 'kd.siswa_kelas_id'=> $_POST['siswa_kelas_id']]
				]);

			}
		
			echo json_encode($data);
		}
	}
	public function get_data_siswa()
	{
		if ($_POST) {
			$data= $this->m_global->get(['table'=> 't_kelas_belajar_data ks', 'join'=> 
				[['t_siswa s','s.siswa_id= ks.siswa_id']], 'where'=> ['siswa_kelas_id'=> $_POST['siswa_kelas_id']]])[0];

			echo json_encode($data);
		}
	}
	public function harian($id)
	{
		$data['title']		= 'Nilai  - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;
		

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation'];


		$data['siswa_data']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'select'=> '*',
			'join'=> [['t_kelas_belajar_data kd', 'kd.kelas_id=k.kelas_id'], 
						['t_siswa s', 's.siswa_id= kd.siswa_id'],
						

					],
			'where'=> ['k.kelas_id'=> $id]
		]);
		$data['elemen_sekolah']= $this->m_global->get([
			'table'=> 't_sekolah_elemen s', 
			'select'=> 's.*, sd.*, r.foto, kd.siswa_kelas_id as siswa',
			'join'=> [
				['t_sekolah_elemen_data sd', 's.sekolah_elemen_id= sd.sekolah_elemen_id'],
				['t_kelas_belajar k', 'k.sekolah_id= s.sekolah_id'],
				['t_kelas_belajar_data kd', 'kd.kelas_id= k.kelas_id'],
				['t_kelas_belajar_rapor_foto r', 'sd.elemen_data_id= r.elemen_data_id and r.siswa_kelas_id= kd.siswa_kelas_id', 'left'],
			],
			'where'=> [
				's.sekolah_id'=>$data['siswa_data'][0]->sekolah_id, 
				'kd.kelas_id'=> $data['siswa_data'][0]->kelas_id]
			]
		);
		
		$data['record']= $data['siswa_data'][0];
		$data['id']= $id;
	
		$this->template->display(strtolower(__CLASS__) . '/rapor_harian', $data);
	}

	public function show_add_cp($id)
	{
		$data['title']		= 'Nilai  - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation'];



		$data['siswa_data']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'select'=> 'kd.*, k.*, s.*, tr.*',
			'join'=> [['t_kelas_belajar_data kd', 'kd.kelas_id=k.kelas_id'], 
						['t_siswa s', 's.siswa_id= kd.siswa_id'],
						['(select siswa_kelas_id as siswa_kelas_id_rapor, rapor_siswa_id from t_kelas_belajar_rapor_cp group by siswa_kelas_id) tr', 'tr.siswa_kelas_id_rapor= kd.siswa_kelas_id', 'left'],

					],
			'where'=> ['k.kelas_id'=> $id],
			'order'=> ['s.no_induk', 'asc']
		]);




		$data['elemen_sekolah']= $this->m_global->get([
			'table'=> 't_sekolah_elemen s', 
			'select'=> 's.*, sd.*, r.foto, kd.siswa_kelas_id as siswa',
			'join'=> [
				['t_sekolah_elemen_data sd', 's.sekolah_elemen_id= sd.sekolah_elemen_id'],
				['t_kelas_belajar k', 'k.sekolah_elemen_id= sd.sekolah_elemen_id'],
				['t_kelas_belajar_data kd', 'k.kelas_id= kd.kelas_id'],
				['t_kelas_belajar_rapor_foto r', 'sd.elemen_data_id= r.elemen_data_id and r.siswa_kelas_id= kd.siswa_kelas_id', 'left'],
			],
			'where'=> [
				's.sekolah_id'=>$data['siswa_data'][0]->sekolah_id, 
				'kd.kelas_id'=> $data['siswa_data'][0]->kelas_id]

			]
		);
		// 	echo $this->db->last_query();
		// exit();
			
		$data['record']= $data['siswa_data'][0];
		$data['id']= $id;
	
		$this->template->display(strtolower(__CLASS__) . '/add_cp_rapor', $data);
	}

	public function form_add_rapor_cp($id)
	{
		$data['title']		= 'Nilai  - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation'];

		$id= $this->m_global->get(['table'=> 't_kelas_belajar_data', 'where'=> ['siswa_kelas_id'=> $id]])[0]->siswa_kelas_id;

		$data['siswa_data']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'join'=> [['t_kelas_belajar_data kd', 'kd.kelas_id=k.kelas_id'], 
						['t_siswa s', 's.siswa_id= kd.siswa_id']],
			'where'=> ['kd.siswa_kelas_id'=> $id],

			'order'=> ['s.no_induk', 'asc']
		])[0];



		$data['cp_belajar']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'select'=> 'k.*, kd.*, s.*, cp.*, ed.*, r.nilai',
			'join'=> [
				['t_kelas_belajar_data kd', 'kd.kelas_id=k.kelas_id'], 
				['t_siswa s', 's.siswa_id= kd.siswa_id'],
				['t_cp_kelas_belajar cp', 'cp.kelas_id= k.kelas_id'],
				['t_sekolah_elemen_data ed', 'ed.elemen_data_id= cp.elemen_data_id'],
				['t_kelas_belajar_rapor_cp r', '(r.cp_id= cp.cp_id and r.siswa_kelas_id= kd.siswa_kelas_id)', 'left']
			],
			'where'=> ['kd.siswa_kelas_id'=> $id],
			'group'=> 'cp.cp_id'
		]);


		$data['elemen_sekolah']= $this->m_global->get([
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id']],
			'where'=> ['sekolah_elemen_status'=> 1, 'sekolah_id'=> $data['siswa_data']->sekolah_id]]);
	
		$data['record']= $data['siswa_data'];


		$data['id']= $id;
	
		$this->template->display(strtolower(__CLASS__) . '/form_add_rapor_cp', $data);
	}
	public function cetak_data_siswa($id='', $type='')
	{

		$data['data_siswa']= @$this->m_global->get([
        		'table'=> 't_kelas_belajar_data td', 
        		'select'=> '*, s.alamat as alamat_sekolah',
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['t_guru g', 'g.guru_id= k.guru_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id']
        		],
        		'where'=> ['td.siswa_kelas_id'=> $id]

        	])[0];

		$data['nilai_ekstra']= $this->m_global->get(['table'=> 't_kelas_belajar_nilai_ekstra', 'where'=> ['siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]]);

		if ($type=='html') {
			$this->load->view('html/cetak_data_peserta_didik', $data);
		}else{
			$this->load->view('cetak_data_peserta_pdf', $data);
		}

		
	}
	public function cetak_lembar_terakhir($id='', $html='')
	{

		$data['data_siswa']= @$this->m_global->get([
        		'table'=> 't_kelas_belajar_data td', 
        		'select'=> '*, s.alamat as alamat_sekolah',
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['t_guru g', 'g.guru_id= k.guru_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id'],
        			['t_kelas_belajar_kondisi_jasmani j', 'j.siswa_kelas_id= td.siswa_kelas_id', 'left']
        		],
        		'where'=> ['td.siswa_kelas_id'=> $id]])[0];

		$data['nilai_ekstra']= $this->m_global->get(['table'=> 't_kelas_belajar_nilai_ekstra', 'where'=> ['siswa_kelas_id'=> @$data['data_siswa']->siswa_kelas_id]]);
		if ($html== 'html') {
			$this->load->view('html/cetak_lembar_terakhir_html', $data);
		}else{
			$this->load->view('cetak_lembar_terakhir_pdf', $data);
		}

		
	}
	public function putar_gambar($url='')
	{
		// if ($_POST) {

			// $url= '/assets/uploads/images/users/174997341292c8c96e4c37100777c7190b76d28233_pp.png';

			// echo $_POST['url'];

			// exit();
			$url= $_POST['url'];
			$filename= APPPATH. './../../user/'.$url;

			if (file_exists($filename)) {
			    $mime = mime_content_type($filename);
			    
			    if ($mime === 'image/png') {
			        
					$source = imagecreatefrompng($filename);

					$rotate = imagerotate($source, 90, 0);
					imagepng($rotate,  APPPATH. './../../user/'.$url);
					$result['status']     = 1;
					$result['message']    = 'Berhasil ';

			    } elseif ($mime === 'image/jpeg') {

					$source = imagecreatefromjpeg($filename);

					$rotate = imagerotate($source, 90, 0);
					imagejpeg($rotate,  APPPATH. './../../user/'.$url);
					$result['status']     = 1;
					$result['message']    = 'Berhasil ';

			    }
			}

			echo json_encode($result);
		// }
		

	}
	public function cetak_rapor_harian_foto($id='', $watermark='', $html='')
	{
		$data['watermark']= $watermark;

		$data['data_siswa']= $this->m_global->get([
        		'table'=> 't_kelas_belajar_data td', 
        		'select'=> '*, s.alamat as alamat_sekolah',
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_guru g', 'g.guru_id= k.guru_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id']
        		],
        		'where'=> ['siswa_kelas_id'=> $id]])[0];



		$data['cp_belajar']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'join'=> [
				['t_kelas_belajar_data kd', 'kd.kelas_id=k.kelas_id'], 
				['t_siswa s', 's.siswa_id= kd.siswa_id'],
				['t_cp_kelas_belajar cp', 'cp.kelas_id= k.kelas_id'],
				['t_sekolah_elemen_data ed', 'ed.elemen_data_id= cp.elemen_data_id'],
				['( 
					select group_concat(DISTINCT `kegiatan_belajar`
                       ORDER BY kegiatan_belajar ASC SEPARATOR ", " LIMIT 4) AS kegiatan,
       kegiatan_nilai as nilai, cp_id, siswa_kelas_id
from v_nilai_belajar

where siswa_kelas_id = "'.$data['data_siswa']->siswa_kelas_id.'"
group by cp_id, kegiatan_nilai


) nilai', '(nilai.siswa_kelas_id= kd.siswa_kelas_id and cp.cp_id= nilai.cp_id)']
			],
			'order'=> ['ed.elemen_data_id', 'asc'],
			'where'=> ['kd.siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]
		]);
		$data['nilai_rapor'] = $this->m_global->get(['table'=> 't_kelas_belajar_rapor_edit', 'where'=> ['siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]]);

		$data['elemen_sekolah']= $this->m_global->get([

			'select'=> 'e.*, s.*, r.foto',
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id'], ['t_kelas_belajar_rapor_foto r', 'r.elemen_data_id= e.elemen_data_id', 'left']],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> [
				'sekolah_elemen_status'=> 1, 
				'sekolah_id'=> $data['data_siswa']->sekolah_id,  
				'r.siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]]);
		if ($html== 'html') {
			$this->load->view('html/cetak_rapor_harian_foto_pdf', $data);
		}else{
			$this->load->view('cetak_rapor_harian_foto_pdf', $data);
		}
	}
	public function cetak_rapor_harian($id='', $watermark='', $html='')
	{
		$data['watermark']= $watermark;
		$data['data_siswa']= $this->m_global->get([
        		'table'=> 't_kelas_belajar_data td', 
        		'select'=> '*, s.alamat as alamat_sekolah',
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_guru g',' g.guru_id= k.guru_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id']
        		],
        		'where'=> ['siswa_kelas_id'=> $id]])[0];

		
		$data['cp_belajar']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'join'=> [
				['t_kelas_belajar_data kd', 'kd.kelas_id=k.kelas_id'], 
				['t_siswa s', 's.siswa_id= kd.siswa_id'],
				['t_cp_kelas_belajar cp', 'cp.kelas_id= k.kelas_id'],
				['t_sekolah_elemen_data ed', 'ed.elemen_data_id= cp.elemen_data_id'],
				['( 
					select group_concat(DISTINCT `kegiatan_belajar`
                       ORDER BY kegiatan_belajar ASC SEPARATOR ", " LIMIT 4) AS kegiatan,
       kegiatan_nilai as nilai, cp_id, siswa_kelas_id
from v_nilai_belajar

where siswa_kelas_id = "'.$data['data_siswa']->siswa_kelas_id.'"
group by cp_id, kegiatan_nilai


) nilai', '(nilai.siswa_kelas_id= kd.siswa_kelas_id and cp.cp_id= nilai.cp_id)']
			],
			'order'=> ['ed.elemen_data_id', 'asc'],
			'where'=> ['kd.siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]
		]);

		$data['nilai_rapor'] = $this->m_global->get(['table'=> 't_kelas_belajar_rapor_edit', 'where'=> ['siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]]);


		$data['elemen_sekolah']= $this->m_global->get([
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id']],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> ['sekolah_elemen_status'=> 1, 'sekolah_id'=> $data['data_siswa']->sekolah_id]]);
		if ($html== 'html') {
			$this->load->view('html/cetak_rapor_harian_pdf', $data);
		}else{
			$this->load->view('cetak_rapor_harian_pdf_tanpa_foto', $data);
		}
	}

	public function cetak_rapor_html( $type='',$id='', $watermark= '')
	{
		$data['watermark']= $watermark;
		$data['data_siswa']= $this->m_global->get([
        		'table'=> 't_kelas_belajar_data td', 
        		'select'=> '*, s.alamat as alamat_sekolah',
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_guru g', 'g.guru_id= k.guru_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id']
        		],
        		'where'=> ['siswa_kelas_id'=> $id]])[0];

		$data['cp_belajar']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'select'=> '*, cp.capaian_belajar as kegiatan',
			'join'=> [
				['t_kelas_belajar_data kd', 'kd.kelas_id=k.kelas_id'], 
				['t_siswa s', 's.siswa_id= kd.siswa_id'],
				['t_cp_kelas_belajar cp', 'cp.kelas_id= k.kelas_id'],
				['t_sekolah_elemen_data ed', 'ed.elemen_data_id= cp.elemen_data_id'],
				['t_kelas_belajar_rapor_cp r', '(r.cp_id= cp.cp_id and kd.siswa_kelas_id= r.siswa_kelas_id)']
			],
			'where'=> ['kd.siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]
		]);

		$data['elemen_sekolah']= $this->m_global->get([

			'select'=> 'e.*, s.*, r.foto',
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [
				['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id'], 
				['t_kelas_belajar_rapor_foto r', 'r.elemen_data_id= e.elemen_data_id', 'left']
			],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> [
				'sekolah_elemen_status'=> 1, 
				'sekolah_id'=> $data['data_siswa']->sekolah_id,  
				'r.siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]]);

		
	
	
		if ($type== 'tanpa_foto') {

			$data['elemen_sekolah']= $this->m_global->get([

			'select'=> 'e.*, s.*',
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [
				['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id']
			],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> [
				'sekolah_elemen_status'=> 1, 
				'sekolah_id'=> $data['data_siswa']->sekolah_id]
			]);
	

			$this->load->view('html/cetak_rapor_html', $data);
		}else{


		$data['elemen_sekolah']= $this->m_global->get([

			'select'=> 'e.*, s.*, r.foto',
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [
				['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id'], 
				['t_kelas_belajar_rapor_foto r', 'r.elemen_data_id= e.elemen_data_id', 'left']
			],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> [
				'sekolah_elemen_status'=> 1, 
				'sekolah_id'=> $data['data_siswa']->sekolah_id,  
				'r.siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]]);
	
			$this->load->view('html/cetak_rapor_cp_foto_html', $data);
		}
		
	}

	public function cetak_rapor( $type='',$id='', $watermark= '')
	{
		$data['watermark']= $watermark;
		$data['data_siswa']= $this->m_global->get([
        		'table'=> 't_kelas_belajar_data td', 
        		'select'=> '*, s.alamat as alamat_sekolah',
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id']
        		],
        		'where'=> ['siswa_kelas_id'=> $id]])[0];

		$data['cp_belajar']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'select'=> '*, cp.capaian_belajar as kegiatan',
			'join'=> [
				['t_kelas_belajar_data kd', 'kd.kelas_id=k.kelas_id'], 
				['t_siswa s', 's.siswa_id= kd.siswa_id'],
				['t_cp_kelas_belajar cp', 'cp.kelas_id= k.kelas_id'],
				['t_sekolah_elemen_data ed', 'ed.elemen_data_id= cp.elemen_data_id'],
				['t_kelas_belajar_rapor_cp r', '(r.cp_id= cp.cp_id and kd.siswa_kelas_id= r.siswa_kelas_id)']
			],
			'where'=> ['kd.siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]
		]);

		$data['elemen_sekolah']= $this->m_global->get([

			'select'=> 'e.*, s.*, r.foto',
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [
				['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id'], 
				['t_kelas_belajar_rapor_foto r', 'r.elemen_data_id= e.elemen_data_id', 'left']
			],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> [
				'sekolah_elemen_status'=> 1, 
				'sekolah_id'=> $data['data_siswa']->sekolah_id,  
				'r.siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]]);

		
	
	
		if ($type== 'tanpa_foto') {

			$data['elemen_sekolah']= $this->m_global->get([

			'select'=> 'e.*, s.*',
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [
				['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id']
			],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> [
				'sekolah_elemen_status'=> 1, 
				'sekolah_id'=> $data['data_siswa']->sekolah_id]
			]);
	

			$this->load->view('cetak_rapor_pdf', $data);
		}else{


		$data['elemen_sekolah']= $this->m_global->get([

			'select'=> 'e.*, s.*, r.foto',
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [
				['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id'], 
				['t_kelas_belajar_rapor_foto r', 'r.elemen_data_id= e.elemen_data_id', 'left']
			],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> [
				'sekolah_elemen_status'=> 1, 
				'sekolah_id'=> $data['data_siswa']->sekolah_id,  
				'r.siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id]]);
	
			$this->load->view('cetak_rapor_cp_foto_pdf', $data);
		}
		
	}
	public function action_ppp()
	{
		$backup_foto= $_POST['backup_foto_pancasila'];
		$photo= $backup_foto;
		if ($_FILES) {
				$upload_path = 'assets/uploads/images/users';

				$config['upload_path'] 		= $upload_path;
				$config['allowed_types'] 	= 'jpg|jpeg|png|pdf|rar|zip';
				$config['overwrite'] 		= TRUE;
				$config['max_size']			= 5000;

				$this->load->library('upload', $config);

				$name 			= str_replace(' ', '_', trim(@$_FILES['foto_ppp']['name']));
				$fileNameParts 	= explode(".", $name);
				$fileExtension 	= end($fileNameParts);
				$fileExtension 	= strtolower($fileExtension);
				$fix_name_file 	= time() . "_pp." . $fileExtension;

				$config['file_name']		= $fix_name_file;
				$this->upload->initialize($config);

				if ($this->upload->do_upload('foto_ppp')) {
					$photo = $upload_path . '/' . $fix_name_file;
					
				}else{
					$photo =  $backup_foto;
				}
			}

		$cek =$this->m_global->update([
        		'table'=> 't_kelas_belajar_data td', 
        		'datas'=> ['profil_pancasila'=> $_POST['profil_pancasila'], 'foto_profile_pancasila'=> $photo],
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id']
        		],
        		'where'=> ['siswa_kelas_id'=> $_POST['siswa_kelas_id']]]);
			
		if ($cek) {
			$result['status']     = 1;
			$result['message']    = 'Upadate ';

			echo json_encode($result);	

		}else{
			$result['status']     = 0;
			$result['message']    = 'Upadate ';

			echo json_encode($result);	
		}

		

	}
	public function action_upload_foto($id='')
	{
		
		$result = [];
		$post 	= $this->input->post();

		$id= $_POST['siswa_kelas_id'];

		
		$data['data_siswa']= $this->m_global->get([
        		'table'=> 't_kelas_belajar_data td', 
        		'select'=> '*, s.alamat as alamat_sekolah',
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id']
        		],
        		'where'=> ['siswa_kelas_id'=> $id]])[0];


		$elemen_sekolah= $this->m_global->get([
			'table'=> 't_sekolah_elemen_data e', 
			'join'=> [['t_sekolah_elemen s', 's.sekolah_elemen_id= e.sekolah_elemen_id']],
			'order'=> ['e.elemen_nomor', 'asc'],
			'where'=> ['sekolah_elemen_status'=> 1, 'sekolah_id'=> $data['data_siswa']->sekolah_id]]);

		foreach ($elemen_sekolah as $key => $value) {
			$backup_foto = $_POST['b'.$value->elemen_data_id];

			if ($_FILES) {
				$upload_path = 'assets/uploads/images/users';

				$config['upload_path'] 		= $upload_path;
				$config['allowed_types'] 	= 'jpg|jpeg|png|pdf|rar|zip';
				$config['overwrite'] 		= TRUE;
				$config['max_size']			= 5000;

				$this->load->library('upload', $config);

				$name 			= str_replace(' ', '_', trim(@$_FILES[$value->elemen_data_id]['name']));
				$fileNameParts 	= explode(".", $name);
				$fileExtension 	= end($fileNameParts);
				$fileExtension 	= strtolower($fileExtension);
				$fix_name_file 	= time() .md5($value->elemen_data_id). "_pp." . $fileExtension;

				$config['file_name']		= $fix_name_file;
				$this->upload->initialize($config);

				if ($this->upload->do_upload($value->elemen_data_id)) {
					$photo = $upload_path . '/' . $fix_name_file;
					
				}else{
					$photo =  $backup_foto;
				}

				$this->m_global->delete([
					'table'=> 't_kelas_belajar_rapor_foto', 
					'where'=> [
						'siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id, 
						'elemen_data_id'=> $value->elemen_data_id]
					]);

				$data_array=[
					'foto'=> $photo,
					'elemen_data_id'=> $value->elemen_data_id,
					'siswa_kelas_id'=> $data['data_siswa']->siswa_kelas_id
				];

				$insert = [
					'table' => 't_kelas_belajar_rapor_foto',
					'datas'	=> $data_array];

				$result = $this->m_global->insert($insert);
				
				
			}
		}
		$result['status']     = 1;
		$result['message']    = 'Berhasil Menambahkan Nilai Rapor ';

		echo json_encode($result);	


	}
		public function cetak_lembaga($id, $html=null)
        {
        
        	$data_siswa= $this->m_global->get([
        		'table'=> 't_kelas_belajar_data td', 
        		'select'=> '*, s.alamat as alamat_sekolah',
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_guru g', 'k.guru_id= g.guru_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id'],
        			['provinsi ps', 'ps.provinsi_id= kb.provinsi_id']
        		],
        		'where'=> ['siswa_kelas_id'=> $id]])[0];

        	if ($data_siswa->logo==null) {
        		echo 'Logo belum ada';
        		exit();
        	}
        	$data['data_siswa']= $data_siswa;

        	if ($html== "html") {
        		$this->load->view('html/cetak_lembaga', $data);
        		
        	}else{

                $this->load->library('Pdf');
                $pdf = new Pdf('P','mm','A4');
                $pdf->AddPage();
                $image = APPPATH. './../../user/'. $data_siswa->logo;
                $image = str_replace('\\','/' ,$image);
                // $pdf->Image($image, 80, 70, 50, 50);

                $pdf->ln(20);
                
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetFillColor(198, 201, 206);
                $pdf->SetDrawColor(0,80,180);
                $pdf->SetFillColor(230,230,0);
                $pdf->SetFont('Arial', 'BU',  10);
                $pdf->SetFont('Arial','B', 20);
                $pdf->Cell(190,5,'DATA LEMBAGA ', 0, 1, 'C');
                $pdf->ln(3);
                $pdf->SetFont('Arial','B', 16);
                $pdf->SetWidths(array(190));
                $pdf->SetAligns(array('C'));
                $pdf->Rows(array($data_siswa->sekolah_nama));
                $pdf->ln(15);

                $pdf->SetFont('Arial', '', 14);
                $pdf->SetWidths(array(7, 40 ,130));
                $pdf->SetAligns(array('L','L','L'));
                $pdf->Rows(
                    array(
                        '1.',
                        'Nama Lembaga',
                        ': '.$data_siswa->sekolah_nama,
                    ));
                $pdf->ln(3);
                $pdf->Rows(
                    array(
                        '2.',
                        'NPSN',
                        ': '.$data_siswa->npsn,
                    ));
                $pdf->ln(3);
                $pdf->Rows(
                    array(
                        '3.',
                        'Akreditasi',
                        ': '.$data_siswa->akreditasi,
                    ));
                $pdf->ln(3);
                $pdf->Rows(
                    array(
                        '4.',
                        'SK Pendirian',
                        ': '.$data_siswa->sk,
                    ));
                $pdf->ln(3);
                $pdf->Rows(
                    array(
                        '5.',
                        'Yayasan',
                        ': '.$data_siswa->yayasan,
                    ));
                $pdf->ln(3);
                $pdf->Rows(
                    array(
                        '6.',
                        'Alamat Sekolah',
                        ': '.$data_siswa->alamat_sekolah,
                    ));
                $pdf->ln(3);
                $pdf->Rows(
                    array(
                        '7.',
                        'Kabupaten',
                        ': '.$data_siswa->kabupaten,
                    ));
                $pdf->ln(3);
                 $pdf->Rows(
                    array(
                        '8.',
                        'Provinsi',
                        ': '.$data_siswa->provinsi,
                    ));

                $pdf->ln(15);

                $pdf->SetFont('Arial','B', 14);
                $pdf->Cell(190,5,'Nama Anak Didik :', 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','', 14);
                $pdf->Cell(190,5, strtoupper($data_siswa->nama_lengkap), 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','B', 14);
                $pdf->Cell(190,5,'Nomor Induk :', 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','', 14);
                $pdf->Cell(190,5, strtoupper($data_siswa->no_induk), 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','B', 14);
                $pdf->Cell(190,5,'NISN :', 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','', 14);
                $pdf->Cell(190,5, strtoupper($data_siswa->nisn), 0, 1, 'C');
                $pdf->ln(40);

                $pdf->SetFont('Arial', '', 16);
                $pdf->SetWidths(array(15, 160 ,15));
                $pdf->SetAligns(array('R','C','R'));
                $pdf->Rows(
                    array(
                        '',
                        $data_siswa->yayasan,
                        '',
                    ));

                // $pdf->SetFont('Arial','B', 16);
                // $pdf->Cell(190,5, strtoupper($data_siswa->yayasan), 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial', '', 14);
                $pdf->SetWidths(array(15, 160 ,15));
                $pdf->SetAligns(array('R','C','R'));
                $pdf->Rows(
                    array(
                        '',
                        $data_siswa->alamat_sekolah,
                        '',
                    ));

                // $pdf->SetFont('Arial','', 14);
                // $pdf->Cell(190,5, ($data_siswa->alamat_sekolah), 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','B', 16);
                $pdf->Cell(190,5, strtoupper($data_siswa->dinas_penaung), 0, 1, 'C');
                $pdf->ln(3);
         		$pdf->SetFont('Arial','B', 16);

         		$kabupaten='';
         		if (substr($data_siswa->kabupaten, 0 ,4) != 'KOTA') {
         			$kabupaten='KABUPATEN ';
         		}
                $pdf->Cell(190,5, $kabupaten.strtoupper($data_siswa->kabupaten), 0, 1, 'C');
          
               	$pdf->Output();
               

        	}

               

        }

	public function cetak_sampul($id, $html=null)
        {
        
        	$data_siswa= $this->m_global->get([
        		'table'=> 't_kelas_belajar_data td', 
        		'select'=> '*, s.alamat as alamat_sekolah',
        		'join'=> [
        			['t_kelas_belajar k', 'k.kelas_id= td.kelas_id'],
        			['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
        			['t_siswa sw', 'sw.siswa_id= td.siswa_id'],
        			['t_guru g', 'k.guru_id= g.guru_id'],
        			['kabupaten kb', 'kb.kabupaten_id= s.kabupaten_id']
        		],
        		'where'=> ['siswa_kelas_id'=> $id]])[0];

        	if ($data_siswa->logo==null) {
        		echo 'Logo belum ada';
        		exit();
        	}

        	$data['data_siswa']= $data_siswa;

        	if ($html== "html") {
        		$this->load->view('html/cetak_sampul', $data);
        		
        	}else{

                $this->load->library('Pdf');
                $pdf = new Pdf('P','mm','A4');
                $pdf->AddPage();
                $image = APPPATH. './../../user/'. $data_siswa->logo;
                $image = str_replace('\\','/' ,$image);
                $pdf->Image($image, 80, 70, 50, 50);

                $pdf->ln(15);
                
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetFillColor(198, 201, 206);
                $pdf->SetDrawColor(0,80,180);
                $pdf->SetFillColor(230,230,0);
                $pdf->SetFont('Arial', 'BU',  10);
                $pdf->SetFont('Arial','B', 20);
                $pdf->Cell(190,5,'LAPORAN ', 0, 1, 'C');
                $pdf->ln(3);
                $pdf->SetFont('Arial','B', 16);
                $pdf->Cell(190,5,'PENILAIAN PERKEMBANGAN PESERTA DIDIK ', 0, 1, 'C');
                $pdf->ln(3);
                $pdf->SetFont('Arial','B', 16);
                $pdf->Cell(190,5, strtoupper($data_siswa->sekolah_nama), 0, 1, 'C');

                $pdf->ln(90);
                $pdf->SetFont('Arial','B', 14);
                $pdf->Cell(190,5,'Nama Anak Didik :', 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','', 14);
                $pdf->Cell(190,5, strtoupper($data_siswa->nama_lengkap), 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','B', 14);
                $pdf->Cell(190,5,'Nomor Induk :', 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','', 14);
                $pdf->Cell(190,5, strtoupper($data_siswa->no_induk), 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','B', 14);
                $pdf->Cell(190,5,'NISN :', 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','', 14);
                $pdf->Cell(190,5, strtoupper($data_siswa->nisn), 0, 1, 'C');
                $pdf->ln(40);

                $pdf->SetFont('Arial', '', 16);
                $pdf->SetWidths(array(15, 160 ,15));
                $pdf->SetAligns(array('R','C','R'));
                $pdf->Rows(
                    array(
                        '',
                        $data_siswa->yayasan,
                        '',
                    ));

                // $pdf->SetFont('Arial','B', 16);
                // $pdf->Cell(190,5, strtoupper($data_siswa->yayasan), 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial', '', 14);
                $pdf->SetWidths(array(15, 160 ,15));
                $pdf->SetAligns(array('R','C','R'));
                $pdf->Rows(
                    array(
                        '',
                        $data_siswa->alamat_sekolah,
                        '',
                    ));

                // $pdf->SetFont('Arial','', 14);
                // $pdf->Cell(190,5, ($data_siswa->alamat_sekolah), 0, 1, 'C');
                $pdf->ln(3);

                $pdf->SetFont('Arial','B', 16);
                $pdf->Cell(190,5, strtoupper($data_siswa->dinas_penaung), 0, 1, 'C');
                $pdf->ln(3);
         		$pdf->SetFont('Arial','B', 16);

         		$kabupaten='';
         		if (substr($data_siswa->kabupaten, 0 ,4) != 'KOTA') {
         			$kabupaten='KABUPATEN ';
         		}
                $pdf->Cell(190,5, $kabupaten.strtoupper($data_siswa->kabupaten), 0, 1, 'C');
          
               	$pdf->Output();
               
            }

        }

	public function detail($id)
	{
		$cek = $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['kelas_id'=> $id]]);

		if (@$cek[0] !=null) {
			
			$data['guru_sekolah']= $this->m_global->get([
				'table'=> 't_kelas_belajar k',
				'join'=> [
					['t_sekolah s', 'k.sekolah_id= k.sekolah_id' ],
					['t_guru g', 'g.guru_id=k.guru_id'],
					['kabupaten b', 'b.kabupaten_id= s.kabupaten_id']

				],
				'where'=> ['k.kelas_id'=> $cek[0]->kelas_id]])[0];

			$data['siswa']= $this->m_global->get([
				'table'=> 't_kelas_belajar k',
				'join'=> [
					['t_kelas_belajar_data s', 's.kelas_id= k.kelas_id' ],
					['t_siswa m', 'm.siswa_id= s.siswa_id']],
				'where'=> ['k.kelas_id'=> $cek[0]->kelas_id]]);
		

			$this->load->view('cetak_siswa', $data);
		}
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

	public function action_rapor_cp()
	{
		$result = [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('siswa_kelas_id', 'Siswa', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			$siswa= $this->m_global->get(['table'=> 't_kelas_belajar_data td', 'where'=> ['siswa_kelas_id'=> $_POST['siswa_kelas_id']]])[0];


			$this->m_global->delete(['table'=> 't_kelas_belajar_rapor_cp', 'where'=> ['siswa_kelas_id'=> $siswa->siswa_kelas_id]]);


			for ($i=0; $i < count($_POST['cp_id']); $i++) { 
				
				$q_insert=[
					'table'=> 't_kelas_belajar_rapor_cp',
					'datas'=> [
						'siswa_kelas_id'=> $siswa->siswa_kelas_id,
						'nilai'=> $_POST['nilai_cp'.$_POST['cp_id'][$i]][$_POST['cp_id'][$i]],
						'cp_id'=> $_POST['cp_id'][$i]

					]];
				$id= $this->m_global->insert($q_insert);

			}
			

			if ($id != null) {

				$result['status']     = 1;
				$result['message']    = 'Berhasil Menambahkan Nilai Rapor ';

				echo json_encode($result);			
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal menambahkan Nilai Rapor';

				echo json_encode($result);	
			
			};
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}
	public function action_edit_kelas()
	{

		$result = [];
		$post 	= $this->input->post();
		$this->load->library('cart');

		$this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'trim|required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
		// $this->form_validation->set_rules('semester', 'Semester', 'trim|required');

		$this->form_validation->set_rules('kepala_sekolah', 'Kepala Sekolah', 'trim|required');
		$this->form_validation->set_rules('tanggal_raport_cetak', 'Tanggal Cetak', 'trim|required');
		$this->form_validation->set_rules('tanggal_raport_pembagian', 'Tanggal Pembagian', 'trim|required');
		$this->form_validation->set_rules('tanggal_raport_pengembalian', 'Tanggal Pengembalian', 'trim|required');
		$this->form_validation->set_rules('kalimat_depan_rapor', 'Kalimat Depan', 'trim|required');
		$this->form_validation->set_rules('kalimat_setelah_nama_rapor', 'Kalimat Setelah Nama', 'trim|required');
		$this->form_validation->set_rules('kalimat_setelah_nama_muncul_rapor', 'Kalimat Setelah Nama', 'trim|required');


		if ($this->form_validation->run() == TRUE) {

			$kelas= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['kelas_id'=> $_POST['kelas_id']]]);
			if ($kelas ==null) {

				$kelas= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['kelas_id'=> $_POST['kelas_id']]])[0];
				$kelas_id= $kelas->kelas_id;

			}else{
				$kelas_id= $kelas[0]->kelas_id;
			}

			

			$data_array = [
				'nama_kelas' => $post['nama_kelas'],
				'kepala_sekolah'=> $post['kepala_sekolah'],
				'kepala_sekolah_nip'=> $post['kepala_sekolah_nip'],
				'tanggal_raport_cetak'=> $post['tanggal_raport_cetak'],
				'tanggal_raport_pembagian'=> $post['tanggal_raport_pembagian'],
				'tanggal_raport_pengembalian'=> $post['tanggal_raport_pembagian'],
				'kalimat_depan_rapor'=> $post['kalimat_depan_rapor'],
				'kalimat_setelah_nama_rapor'=> $post['kalimat_setelah_nama_rapor'],
				'kalimat_depan_rapor_tidak_muncul' => $post['kalimat_depan_rapor_tidak_muncul'],
				'kalimat_setelah_nama_muncul_rapor'=> $post['kalimat_setelah_nama_muncul_rapor'],
			];

			$q_insert = [
				'table' => 't_kelas_belajar',
				'datas'	=> $data_array,
				'where'=> ['kelas_id'=> $kelas_id]
			];
			$this->m_global->update($q_insert);


			// if ($kelas_id != null) {

				$result['status']     = 1;
				$result['message']    = 'Berhasil Edit Kelas <strong>'.$_POST['nama_kelas'].'</strong>';

				echo json_encode($result);			
			// }else{
			// 	$result['status']     = 2;
			// 	$result['message']    = 'Gagal Edit Kelas <strong>'.$_POST['nama_kelas'].'</strong>';

			// 	echo json_encode($result);	
			
			// };
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}

	public function action_add_kelas()
	{

		$result = [];
		$post 	= $this->input->post();
		$this->load->library('cart');

		$this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'trim|required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
		$this->form_validation->set_rules('semester', 'Semester', 'trim|required');

		$this->form_validation->set_rules('kepala_sekolah', 'Kepala Sekolah', 'trim|required');
		$this->form_validation->set_rules('kepala_sekolah_nip', 'Kepala Sekolah', 'trim|required');
		$this->form_validation->set_rules('tanggal_raport_cetak', 'Tanggal Cetak', 'trim|required');
		$this->form_validation->set_rules('tanggal_raport_pembagian', 'Tanggal Pembagian', 'trim|required');
		$this->form_validation->set_rules('tanggal_raport_pengembalian', 'Tanggal Pengembalian', 'trim|required');


		if ($this->form_validation->run() == TRUE) {


			if (empty($this->cart->contents())) {

				$result['status']     = 2;
				$result['message']    = 'Gagal, Siswa Belum Dimasukan';

				echo json_encode($result);	
				exit();
			}

			$data_array = [
				'nama_kelas' => $post['nama_kelas'],
				'tahun' => $post['tahun'],
				'semester'=> $post['semester'],
				'kepala_sekolah'=> $post['kepala_sekolah'],
				'kepala_sekolah_nip'=> $post['kepala_sekolah_nip'],
				'tanggal_raport_cetak'=> $post['tanggal_raport_cetak'],
				'tanggal_raport_pembagian'=> $post['tanggal_raport_pembagian'],
				'tanggal_raport_pengembalian'=> $post['tanggal_raport_pembagian'],
				'guru_id'=> login_data('user_id'),
				'sekolah_id'=> login_data('sekolah_id')
			];

			$q_insert = [
				'table' => 't_kelas_belajar',
				'datas'	=> $data_array,
			];
			$kelas_id= $this->m_global->insert($q_insert)['id'];

			$siswa_kelas= $this->cart->contents();

			foreach ($siswa_kelas as $key ) {
				$q_insert_data=[
					'table'=> 't_kelas_belajar_data',
					'datas'=> [
						'kelas_id'=> $kelas_id,
						'siswa_id'=> $key['siswa_id']]
					];
				$this->m_global->insert($q_insert_data);

			};

			$this->cart->destroy();

			if ($kelas_id != null) {

				$result['status']     = 1;
				$result['message']    = 'Berhasil Menambahkan Kelas <strong>'.$_POST['nama_kelas'].'</strong>';

				echo json_encode($result);			
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal menambahkan Kelas <strong>'.$_POST['nama_kelas'].'</strong>';

				echo json_encode($result);	
			
			};
			
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
		$data['plugin'] 	= ['validation'];
		$data['id'] 		= $id;

		$arr_conf 			= [

			'table'	=> 't_kelas_belajar s',			
			'where'	=> ['kelas_id' => $id]
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];

		$data['kepala_sekolah']= $this->m_global->get(['table'=> 't_guru', 'where'=> ['sekolah_id'=> login_data('sekolah_id'), 'jabatan'=> '3']]);

		$data['record_data']= $this->m_global->get([
			'table'=> 't_kelas_belajar_data kd', 
			'join'=> [['t_siswa s', 's.siswa_id= kd.siswa_id']],
			'where'=> ['kelas_id'=> $id]
		]);

		$this->template->display(strtolower(__CLASS__) . '/edit', $data);
	}
	public function action_add_siswa()
	{
		$result = [];
		$post 	= $this->input->post();


		$this->form_validation->set_rules('siswa_id', 'Siswa', 'trim|required');


		if ($this->form_validation->run() == TRUE) {
		
			$kelas_id= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['kelas_id'=> $_POST['kelas_id']]])[0];

			$cek_siswa= $this->m_global->get(['table'=> 't_kelas_belajar_data', 'where'=> ['kelas_id'=> $_POST['kelas_id'], 'siswa_id'=> $_POST['siswa_id']]]);
			
			if (@$cek_siswa[0] != null) {
				
				$data['status']     = 2;
				$data['message']    = 'Siswa Sudah Ada <strong> Gagal</strong>';
				echo json_encode($data);
				exit();
			}

			$cek_total=  $this->m_global->get(['table'=> 't_kelas_belajar_data', 'where'=> ['kelas_id'=> $_POST['kelas_id']]]);
			
			if (count($cek_total) >= 30) {
				
				$data['status']     = 2;
				$data['message']    = 'Siswa Sudah Ada <strong> Gagal</strong>';
				echo json_encode($data);
				exit();
			}

			$this->m_global->insert([
				'table'=> 't_kelas_belajar_data', 
				'datas'=> ['siswa_id'=> $_POST['siswa_id'], 'kelas_id'=> $kelas_id->kelas_id]
			]);
			
			$data['status']     = 1;
			$data['message']    = 'Successfully Delete <strong> Siswa</strong>';
			echo json_encode($data);
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}

	public function delete_siswa_edit()
	{
		$result = [];
		$post 	= $this->input->post();


		$this->form_validation->set_rules('siswa_kelas_id', 'Siswa', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
		
		
			
			$this->m_global->delete(['table'=> 't_kelas_belajar_data', 'where'=> ['siswa_kelas_id'=> $_POST['siswa_kelas_id']]]);
			
			$data['status']     = 1;
			$data['message']    = 'Successfully Delete <strong> Siswa</strong>';
			echo json_encode($data);
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}

	public function action_edit($id)
	{
		$result = [];
		$post 	= $this->input->post();


		$this->form_validation->set_rules('elemen', 'Elemen', 'trim|required');
		$this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');

		

		if ($this->form_validation->run() == TRUE) {
		
		
			$data_array = [
				'elemen' 	=> $post['elemen'],
				'deskripsi' => $post['deskripsi'],
			];

			$update = [
				'table' => $this->table_db,
				'datas'	=> $data_array,
				'where'	=> ['elemen_id' => $id]
			];

			$result = $this->m_global->update($update);

			if ($result['status']) {
				$data['status']     = 1;
				$data['message']    = 'Successfully edit Elemen with Name <strong>' . $post['elemen'] . '</strong>';

				echo json_encode($data);
			} else {

				$data['status']     = 0;
				$data['message']    = 'Failed edit Elemen with Name <strong>' . $post['elemen'] . '</strong>';
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