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

		$this->load->library('cart');
		$this->cart->destroy();

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}
	public function index_detail($id='')
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;
		// $data['id']			= $id;

		$data['plugin'] 	= ['datatables'];

		$kelas_id= $this->m_global->get([
			'table'=> 't_kelas_belajar', 
			'where'=> ['kelas_id'=> $id]
		])[0];

		$data['siswa_data']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'select'=> 'kd.*, k.*, s.*, tr.*, g.*',
			'join'=> [['t_kelas_belajar_data kd', 'kd.kelas_id=k.kelas_id'], 
						['t_siswa s', 's.siswa_id= kd.siswa_id'],
						['t_guru g', 'g.guru_id= k.guru_id'],
						['(select siswa_kelas_id as siswa_kelas_id_rapor, rapor_siswa_id from t_kelas_belajar_rapor_cp group by siswa_kelas_id) tr', 'tr.siswa_kelas_id_rapor= kd.siswa_kelas_id', 'left'],

					],
			'where'=> ['k.kelas_id'=> $kelas_id->kelas_id],
			'order'=> ['s.no_induk', 'asc']
		]);


		$data['record']= $data['siswa_data'][0];
		$data['id']= $id;

		$this->template->display(strtolower(__CLASS__) . '/index-detail', $data);
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
		$data['plugin'] 	= ['validation', 'datatables'];
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
		$join 		= [['t_guru g', 'g.guru_id= s.guru_id']];

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
			
		}


		if (login_data('user_role') == '3') {
			$where_e['g.sekolah_id']    = login_data('sekolah_id');
		}else{
			$where_e['g.sekolah_id']    = login_data('sekolah_id');
			$where_e['g.guru_id']   	= login_data('user_id');
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

		$select = ' *, ' . implode(',', $aCari);

		$arr_config['select'] 	= $select;
		$arr_config['order'] 	= $order;
		$arr_config['start'] 	= $iDisplayStart;
		$arr_config['show'] 	= $iDisplayLength;

		$result = $this->m_global->get($arr_config);

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
				$rows->guru_nama,
				$rows->tahun,
				$semester[$rows->semester],
				$status[$rows->kelas_status],	
				$this->_button1($rows->kelas_id, $rows->kelas_status)			
				// $this->_button($rows->kelas_id),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}
		private function _button1($id, $status= null)
	{
		// $html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by/' . strEncrypt($id) . '/' . ($status == 1 ? '0" data-original-title="Set to InActive"' : '1" data-original-title="Set to Active"')) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . ($status == 0 ? 'InActive' : ($status == 99 ? 'Deleted' : 'Active')) . '" class="fa fa' . ($status == 0 ? '-eye-slash' : ($status == 99 ? '-trash' : '-eye')) . '"></i></a>';
		$html = '<a href="' . base_url() . '/kelas/index_detail/' . ($id) . '/'.($id).'" data-original-title="Detail Kelas" class="btn btn-sm  btn-sm p-1 btn-icon-md tooltips btn-primary btnAction ajaxify" ><i class="fa fa-table"></i> Detail dan Nilai</a>';

		if ($status== 0) {
			$html .= '<button data-original-title="Tutup kelas jika sudah ganti semester" onclick= "sendData('."'".$id."'".')"  style= "background: #ff0000a1; margin-left: 5px;" class="btn btn-sm  btn-sm p-1 btn-icon-md btn-danger" >Tutup Kelas</button>';
		}

		

		// $html .= '<a href="' . base_url() . '/nilai/index/' . strEncrypt($id) . '" data-original-title="Input Nilai" class="btn btn-sm  btn-sm p-1 btn-icon-md tooltips btn-danger btnAction ajaxify" >TK/TP Nilai Belajar Harian</a>  ';


		return $html;
	}
	public function change_status()
	{
		if ($_POST) {
			$this->m_global->update([
				'table'=> 't_kelas_belajar', 
				'datas'=> ['kelas_status'=> 1], 
				'where'=> ['kelas_id'=> $_POST['id']]
			]);


				
			$result['status']     = 1;
			$result['message']    = 'Berhasil';

			echo json_encode($result);	
			exit();
		}
	}

	private function _button($id, $status= null)
	{
		// $html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by/' . strEncrypt($id) . '/' . ($status == 1 ? '0" data-original-title="Set to InActive"' : '1" data-original-title="Set to Active"')) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . ($status == 0 ? 'InActive' : ($status == 99 ? 'Deleted' : 'Active')) . '" class="fa fa' . ($status == 0 ? '-eye-slash' : ($status == 99 ? '-trash' : '-eye')) . '"></i></a>';

		$html = '<a href="' . base_url() . $this->url . '/show_edit/' . ($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-warning btn-icon-md btn-sm p-1 tooltips btnAction ajaxify" title="Edit">
					Edit
				</a> ';

		// $html .= '<a href="' . base_url() . $this->prefix . '/delete/' . strEncrypt($id) . '" data-original-title="Hapus" class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" data-permission="d" onClick="return deleteData(this, event);"><i class="la la-trash"></i></a>';

		$html .= '<a href="' . base_url() . '/kondisi_jasmani/index/' . ($id) . '" data-original-title="Kondisi Jasmani Siswa" class="btn btn-sm p-1 btn-sm btn-success tooltips ajaxify ">Kondisi Jasmani Siswa</a> ';

		$html .= '<a href="' . base_url() . $this->prefix . '/detail/' . ($id) . '" data-original-title="cetak daftar siswa" class="btn btn-sm p-1 btn-sm btn-secondary tooltips" target="_blank"> Cetak Daftar Siswa</a> ';

		$html .= '<a href="' . base_url() . '/nilai_ekstra/index/' . ($id) . '" data-original-title="Nilai Ekstra" class="btn btn-sm p-1 btn-sm btn-brand tooltips ajaxify"> Nilai Ekstra</a> ';

		

		// $html .= '<a href="' . base_url() . '/cp_belajar/index/' . strEncrypt($id) . '" data-original-title="CP Belajar" class="btn btn-sm  btn-sm p-1 btn-icon-md tooltips btn-primary btnAction ajaxify" >CP belajar</a>  ';

		// $html .= '<a href="' . base_url() . '/nilai/index/' . strEncrypt($id) . '" data-original-title="Input Nilai" class="btn btn-sm  btn-sm p-1 btn-icon-md tooltips btn-danger btnAction ajaxify" >TK/TP Nilai Belajar</a>  ';


		return $html;
	}
	public function show_add()
	{
		$this->load->library('cart');

		$data['title']		= 'Add - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Add' => base_url() . $this->url . '/show_add'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation'];

		$data['siswa_data']= @$this->cart->contents();

		// print_r($data['elemen_data']);
		// exit;

		$data['kelas']= $this->m_global->get([
			'table'=> 't_kelas_belajar',
			'where'=> ['kelas_status'=> 0, 
						'guru_id'=> login_data('user_id')]
		]);

		$data['kepala_sekolah']= $this->m_global->get(['table'=> 't_guru', 'where'=> ['sekolah_id'=> login_data('sekolah_id'), 'jabatan'=> '3']]);
	
		$this->template->display(strtolower(__CLASS__) . '/add', $data);
	}
	public function detail($id)
	{
		$cek = $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['kelas_id'=> $id]]);

		if (@$cek[0] !=null) {
			
			$data['guru_sekolah']= $this->m_global->get([
				'table'=> 't_kelas_belajar k',
				'join'=> [
					['t_sekolah s', 'k.sekolah_id= s.sekolah_id' ],
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

	public function action_add()
	{
		$this->load->library('cart');

		$result = [];
		$post 	= $this->input->post();

		// $this->form_validation->set_rules('siswa_id', 'Siswa', 'trim|required');

		// if ($this->form_validation->run() == TRUE) {

			$siswa= @$this->m_global->get(['table'=> 't_siswa', 'where'=> ['siswa_id'=> $_POST['siswa_id']]])[0];

			$cek_total = $this->cart->contents();

			if (count($cek_total) > 30) {
				
				$result['status']     = 2;
				$result['message']    = 'Maximal 30 siswa';

				echo json_encode($result);	
				exit();
			}
			if (@$siswa == null) {
				$result['status']     = 2;
				$result['message']    = 'Gagal, Pilih siswa Terlebih dahulu';

				echo json_encode($result);	
				exit();
			}else{
				$data = array(
					'id'	  => rand(100,900),
			        'qty'     => 1,
			        'price'   => 1,
			        'name'    => 'siswa',
			        'siswa_id'=> $_POST['siswa_id'],
			        'nama_lengkap'  => $siswa->nama_lengkap,
			        'no_induk'=> $siswa->no_induk,
			        'alamat' => $siswa->alamat
				);

				$id= $this->cart->insert($data);

			}

			
			if ($id != null) {

				$result['status']     = 1;
				$result['message']    = 'Berhasil Menambahkan Siswa,' . $siswa->nama_lengkap . '';

				echo json_encode($result);			
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal menambahkan Siswa,'.$siswa->nama_lengkap.'';

				echo json_encode($result);	
			
			};
			
		// } else {
		// 	$result['message'] 	= validation_errors();
		// 	$result['status'] 	= 2;

		// 	echo json_encode($result);
		// }
	}
	public function action_edit_kelas()
	{

		$result = [];
		$post 	= $this->input->post();
		$this->load->library('cart');

		$this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'trim|required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
		$this->form_validation->set_rules('semester', 'Semester', 'trim|required');

		$this->form_validation->set_rules('kepala_sekolah', 'Kepala Sekolah', 'trim|required');
		$this->form_validation->set_rules('tanggal_raport_cetak', 'Tanggal Cetak', 'trim|required');
		$this->form_validation->set_rules('tanggal_raport_pembagian', 'Tanggal Pembagian', 'trim|required');
		$this->form_validation->set_rules('tanggal_raport_pengembalian', 'Tanggal Pengembalian', 'trim|required');

		if ($this->form_validation->run() == TRUE) {


			

			$data_array = [
				'nama_kelas' => $post['nama_kelas'],
				'kepala_sekolah'=> $post['kepala_sekolah'],
				'kepala_sekolah_nip'=> $post['kepala_sekolah_nip'],
				'tanggal_raport_cetak'=> $post['tanggal_raport_cetak'],
				'tanggal_raport_pembagian'=> $post['tanggal_raport_pembagian'],
				'tanggal_raport_pengembalian'=> $post['tanggal_raport_pengembalian'],
			];

			$q_insert = [
				'table' => 't_kelas_belajar',
				'datas'	=> $data_array,
				'where'=> [('kelas_id')=> $_POST['kelas_id']]
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

			$q_guru = [
				'table'=> 't_guru g',
				'join'=> [['(select count(kelas_id) total, guru_id from t_kelas_belajar group by guru_id) k', 'g.guru_id=k.guru_id', 'left']],
				'where'=> ['g.guru_id'=> login_data('user_id'), 'batas_semester <= total'=>null]
			];

			$guru_cek = $this->m_global->get($q_guru);
			
			if (@$guru_cek[0]->total != null) {

					$result['status']     = 2;
					$result['message']    = 'Gagal menambahkan Kelas <strong>KUOTA HABIS</strong>';

					echo json_encode($result);

					exit();
				
			}
			$sekolah_elemen= $this->m_global->get(['table'=> 't_sekolah_elemen', 'where'=> ['sekolah_id'=> login_data('sekolah_id'), 'sekolah_elemen_status'=> 1]])[0];

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
				'sekolah_id'=> login_data('sekolah_id'),
				'sekolah_elemen_id'=> $sekolah_elemen->sekolah_elemen_id
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

			$cek_siswa= $this->m_global->get([
				'table'=> 't_kelas_belajar_data k', 
				'join'=> [['t_siswa s', 's.siswa_id= k.siswa_id']],
				'where'=> ['kelas_id'=> $_POST['kelas_id'], 'k.siswa_id'=> $_POST['siswa_id']]]);
			
			if (@$cek_siswa[0] != null) {
				
				$data['status']     = 2;
				$data['message']    = 'Siswa Sudah Ada <strong> Gagal</strong>';
				echo json_encode($data);
				exit();
			}

			$cek_total=  $this->m_global->get(['table'=> 't_kelas_belajar_data', 'where'=> ['kelas_id'=> $_POST['kelas_id']]]);
			
			if (count($cek_total) >= 30) {
				
				$data['status']     = 2;
				$data['message']    = 'KUOTA HABIS<strong> GAGAL</strong>';
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
