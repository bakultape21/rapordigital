<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anekdot extends MX_Controller
{

	private $prefix         = 'anekdot';
	private $url            = 'anekdot';
	private $table_db       = 't_kelas_belajar_catatan_anekdot';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index($id=null)
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;
		$data['plugin'] 	= ['validation'];

		$query 				= [
								'table'=> 't_kelas_belajar k', 
								'where'=> ['guru_id'=> login_data('user_id')]];
		$data['kelas_list']		= $this->m_global->get($query);

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}

	public function list()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;
		$data['plugin'] 	= ['datatables'];

		if (login_data('user_role')==3) {
			$data['kelas_list']	= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['sekolah_id'=> login_data('sekolah_id')]]);
		}else{
			$data['kelas_list']	= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['guru_id'=> login_data('user_id')]]);
		}

		$this->template->display(strtolower(__CLASS__) . '/list', $data);
	}


	public function get_form()
	{
		if ($_POST) {
			
		$kegiatan_belajar= $this->m_global->get([
			'select'=> '*',
			'table'=> 't_kelas_belajar_kegiatan k', 
			'join'=> [
				['t_kelas_belajar_kegiatan_nilai n', 'n.kegiatan_id= k.kegiatan_id'],
				['t_cp_kelas_belajar cp', 'cp.cp_id= k.cp_id']
			],
			'where'=> ['(kegiatan_tanggal >="'. $_POST['awal'].'" and kegiatan_tanggal <= "'.$_POST['akhir'].'")'=> null, 'n.siswa_kelas_id'=> $_POST['siswa_kelas_id']],
			'group'=> 'kegiatan_tanggal'
				]
			);

		$data_siswa= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'select'=> 's.*, td.*, k.*',
			'join'=> [
					['t_kelas_belajar_data td', 'td.kelas_id= k.kelas_id'], 
					['t_siswa s', 's.siswa_id= td.siswa_id'],
					['t_sekolah_elemen se', 'k.sekolah_id= se.sekolah_id'],
					['t_sekolah_elemen_data e', 'e.sekolah_elemen_id= se.sekolah_elemen_id']
				],
			'where'=> ['td.siswa_kelas_id'=> $_POST['siswa_kelas_id']],
			'group'=> 's.siswa_id'

		])[0];

		$elemen = $this->m_global->get(['table'=> 't_sekolah_elemen_data sd', 
			'join'=> [
				['t_sekolah_elemen c', 'c.sekolah_elemen_id= sd.sekolah_elemen_id'], 
				['t_sekolah s', 's.sekolah_id= c.sekolah_id']],
			'where'=> ['s.sekolah_id'=> login_data('sekolah_id'), 'sekolah_elemen_status'=> 1],
			'order'=> ['sd.sekolah_elemen_id', 'asc']
				]);

	

		$html= null;
		
						
		

		foreach ($kegiatan_belajar as $key => $value) {

			$cp_belajar= $this->m_global->get([

				'table'=> 't_kelas_belajar_kegiatan k', 
				'join'=> [
					['t_kelas_belajar_kegiatan_nilai kd', 'kd.kegiatan_id= k.kegiatan_id'],
					['t_cp_kelas_belajar cp', 'cp.cp_id= k.cp_id']

				],

				'where'=> [
							'kd.siswa_kelas_id'=> $_POST['siswa_kelas_id'], 
							'k.kegiatan_tanggal'=> $value->kegiatan_tanggal],
				'group'=> 'cp.cp_id'
						]);
			$capaian_belajar= '';

			foreach ($elemen as $ky => $val) :
				$capaian_belajar .='<strong>'.$val->elemen_data.'</strong><br>';
				foreach ($cp_belajar as $k => $v) {
					if ($v->elemen_data_id== $val->elemen_data_id) { 
						$capaian_belajar .='<li>'.$v->capaian_belajar.'</li>';
					} 
				} 
			endforeach;

			$html .= '<tr id="id-'.$value->id.'">
						<td>'.$value->kegiatan_tanggal.' <input type="hidden" name="tanggal[]" value="'.$value->kegiatan_tanggal.'"></td>
						<td>
							<textarea name="ca_kejadian[]" class="form-control"></textarea>
						</td>
						<td>
							'.$capaian_belajar.'
						</td>
						<td>
							<textarea class="form-control" name="ca_umpan_balik[]"></textarea>
						</td>
						<td>
							<textarea class="form-control" name="ca_keterangan[]"></textarea>
						</td>
					</tr>';
		}
		$result= [
			'html'=> $html,
			'data_siswa'=> $data_siswa];

		echo json_encode($result);


		}
	}
	public function save_catatan_anekdot($value=''){

		$result = [];
		$post 	= $this->input->post();
		
		$this->form_validation->set_rules('siswa_kelas_id', 'Siswa Kelas Id', 'trim|required');
		

		if ($this->form_validation->run() == TRUE) {
			
			for ($i=0; $i < count($_POST['tanggal']); $i++) { 
						
				$arr_query=[
					'table'=> 't_kelas_belajar_catatan_anekdot', 
					'datas'=> [
						'siswa_kelas_id'=> $_POST['siswa_kelas_id'],
						'tanggal'=> $_POST['tanggal'][$i],
						'ca_umpan_balik'=> $_POST['ca_umpan_balik'][$i],
						'ca_keterangan'=> $_POST['ca_keterangan'][$i],
						'ca_kejadian'=> $_POST['ca_kejadian'][$i]
						]
					];

				$id=$this->m_global->insert($arr_query);
			}
		

			if ($id != null) {

				$result['status']     = 1;
				$result['message']    = 'Berhasil Edit Capaian Belajar';

				echo json_encode($result);			
			}else{
				$result['status']     = 2;
				$result['message']    = 'Gagal Edit Capaian Belajar  ';

				echo json_encode($result);	
			
			};
			
		} else {
			$result['message'] 	= validation_errors();
			$result['status'] 	= 2;

			echo json_encode($result);
		}
	}
	public function select()
	{
		$aCari = [
			'kelas_id'  => 'k.kelas_id',
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= [['t_kelas_belajar_data kd', 'kd.siswa_kelas_id= c.siswa_kelas_id'], ['t_kelas_belajar k ', 'k.kelas_id= kd.kelas_id'], ['t_siswa s', 's.siswa_id= kd.siswa_id']];

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
			// $where['k.sekolah_id']    = login_data('sekolah_id');
			// $where['k.guru_id']   	= login_data('user_id');
		}

		if (login_data('user_role') == '3') {
			$where_e['k.sekolah_id']    = login_data('sekolah_id');
		}else{
			$where_e['k.sekolah_id']    = login_data('sekolah_id');
			$where_e['k.guru_id']   	= login_data('user_id');
		}

		$keys   = array_keys($aCari);
		@$order = [$aCari[$keys[($_REQUEST['order'][0]['column'] - 1)]], $_REQUEST['order'][0]['dir']];

		$arr_config['table'] 	= $this->table_db.' c';
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
				$rows->tanggal,
				$rows->nama_lengkap,
				$rows->nama_kelas.' - '.$rows->tahun.' / '.$semester[$rows->semester],
				$rows->ca_kejadian,				
				$this->_button($rows->ca_id),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}
	
	private function _button($id= null)
	{
		// $html = '<a data-permission="r" href="' . base_url($this->prefix . '/change_status_by/' . strEncrypt($id) . '/' . ($status == 1 ? '0" data-original-title="Set to InActive"' : '1" data-original-title="Set to Active"')) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md tooltips btnAction" onClick="return f_status(1, this, event)"><i title="' . ($status == 0 ? 'InActive' : ($status == 99 ? 'Deleted' : 'Active')) . '" class="fa fa' . ($status == 0 ? '-eye-slash' : ($status == 99 ? '-trash' : '-eye')) . '"></i></a>';

		// $html = '<a href="' . base_url() . $this->url . '/show_edit/' . strEncrypt($id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-warning btn-icon-md btn-sm p-1 tooltips btnAction ajaxify" title="Edit">
		// 			Edit
		// 		</a> ';

		$html = '<a href="' . base_url() . $this->prefix . '/delete/' . strEncrypt($id) . '" data-original-title="Hapus" class="btn btn-sm btn-danger btn-sm p-1 btn-icon-md tooltips btnAction" data-permission="d" onClick="return deleteData(this, event);">Hapus</a>';


		$html .= '<a href="' . base_url() . $this->url . '/cetak_ca/' . strEncrypt($id) . '" target="_blank" data-original-title="cetak" class="btn btn-sm btn-success btn-icon-md btn-sm p-1 tooltips btnAction" title="Cetak">
					Cetak
				</a> ';



		return $html;
	}
	public function delete($id='')
	{
		
		$delete = [
			'table' => 't_kelas_belajar_catatan_anekdot',
			'where' => [strEncrypt('ca_id', TRUE) => $id]
		];

		$result = $this->m_global->delete($delete);
		

		if ($result) {
			$data['status'] = 1;
		} else {

			$data['status'] = 0;
		}

		echo json_encode($data);
	
	}
	public function cetak_ca($id='')
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['catatan_anekdot']= $this->m_global->get([
			'select'=> '*',
			'table'=> 't_kelas_belajar_catatan_anekdot k', 
			'join'=> [
				['t_kelas_belajar_data td', 'td.siswa_kelas_id= k.siswa_kelas_id'],
				['t_kelas_belajar kb', 'kb.kelas_id= td.kelas_id']
				
			],
			'where'=> [strEncrypt('k.ca_id', TRUE) => $id]
				]
			);

		$data['cp_belajar']= $this->m_global->get([
			'table'=> 't_kelas_belajar_kegiatan k', 
			'join'=> [
				['t_kelas_belajar_kegiatan_nilai kd', 'kd.kegiatan_id= k.kegiatan_id'],
				['t_cp_kelas_belajar cp', 'cp.cp_id= k.cp_id']

			],

			'where'=> [
						'kd.siswa_kelas_id'=> $data['catatan_anekdot'][0]->siswa_kelas_id, 
						'k.kegiatan_tanggal'=> $data['catatan_anekdot'][0]->tanggal 
					],

			'group'=> 'cp.cp_id'
		]);

		$data['guru_sekolah']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'join'=> [
				['t_sekolah s', 'k.sekolah_id= s.sekolah_id' ],
				['t_guru g', 'g.guru_id=k.guru_id'],
				['kabupaten b', 'b.kabupaten_id= s.kabupaten_id']

			],
			'where'=> ['k.kelas_id'=> $data['catatan_anekdot'][0]->kelas_id]])[0];

		$data['elemen']= $this->m_global->get(['table'=> 't_sekolah_elemen_data sd', 
			'join'=> [
				['t_sekolah_elemen c', 'c.sekolah_elemen_id= sd.sekolah_elemen_id'], 
				['t_sekolah s', 's.sekolah_id= c.sekolah_id']],
			'where'=> ['s.sekolah_id'=> $data['catatan_anekdot'][0]->sekolah_id, 'sekolah_elemen_status'=> 1],
			'order'=> ['sd.elemen_nomor', 'asc']
				]);

		

		$data['siswa']= $this->m_global->get([
			'table'=> 't_kelas_belajar k',
			'select'=> 's.*, td.*',
			'join'=> [
					['t_kelas_belajar_data td', 'td.kelas_id= k.kelas_id'], 
					['t_siswa s', 's.siswa_id= td.siswa_id'],
					['t_sekolah_elemen se', 'k.sekolah_id= se.sekolah_id'],
					['t_sekolah_elemen_data e', 'e.sekolah_elemen_id= se.sekolah_elemen_id']
				],
			'where'=> ['td.siswa_kelas_id'=> $data['catatan_anekdot'][0]->siswa_kelas_id],
			'group'=> 's.siswa_id',
			'order'=> ['e.elemen_nomor', 'asc']

		])[0];
	

	
		
		$this->load->view('cetak', $data);

	}
}