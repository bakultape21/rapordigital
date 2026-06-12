<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends MX_Controller
{

	private $prefix         = 'pembayaran';
	private $url            = 'pembayaran';
	private $table_db       = 't_sekolah';
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
			'npsn'      =>  'npsn',
			'status'=> 'status'

		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= [
			['t_guru g', 'g.guru_id= p.guru_id'],
			['t_sekolah s', 's.sekolah_id= g.sekolah_id'],
			['kabupaten k', 'k.kabupaten_id= s.kabupaten_id
			']

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

		// if (login_data('user_id') !== '1') {
		// 	$where[$this->table_prefix . 'id <>'] = '1';
		// }

		$keys   = array_keys($aCari);
		@$order = [$aCari[$keys[($_REQUEST['order'][0]['column'] - 1)]], $_REQUEST['order'][0]['dir']];

		$arr_config['table'] 	= 't_pembayaran_guru p';
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

		$select = 'p.*, g.guru_nama,s.npsn, k.kabupaten, g.email, ' . implode(',', $aCari);

		$arr_config['select'] 	= $select;
		$arr_config['order'] 	= $order;
		$arr_config['start'] 	= $iDisplayStart;
		$arr_config['show'] 	= $iDisplayLength;

		$result = $this->m_global->get($arr_config);


		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {

			$img= '
			<a href="' . base_url(). '../user/' . $rows->file . '" target="_blank">
			<img src="' . base_url(). '../user/' . $rows->file . '" width="50">
					
				</a>';
			$status;
			 if ($rows->status==0):
				$status='<span class="badge badge-warning">proses konfirmasi</span>';
			elseif($rows->status==1):
				$status='<span class="badge badge-success">Diterima</span>';
			else:
				$status='<span class="badge badge-danger">Ditolak</span>';
			endif;
			$records["data"][] = array(
				$i,
				$rows->guru_nama,
				$rows->npsn,
				$rows->kabupaten,
				$rows->waktu_bayar,
				$rows->nominal,
				$img,
				$status, 
				$this->_button($rows->id, $rows->status, $rows->guru_id),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}
	private function _button($id, $status= null, $guru_id=null)
	{
		

		$html = '';

			if ($status==0) {
				$html .= '<button class="btn btn-success btn-sm btn-icon-md " onclick="return terima('."'".$id."'".') ">Terima Pembayaran</button>';

				$html .= '<button class="btn btn-danger btn-sm btn-icon-md " onclick="return tolak('."'".$id."'".') ">Tolak</button>';
			}elseif($status==1){
				$html= '<a href="' . base_url() . '/guru/show_edit/' . strEncrypt($guru_id) . '" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-warning btn-icon-md tooltips btnAction ajaxify" title="Edit">
					Tambah Kuota
				</a>';
			}
		

		return $html;
	}
	public function tolak($value='')
	{
		if ($_POST) {
			$this->m_global->update(['table'=> 't_pembayaran_guru', 'datas'=> ['status'=> 2], 'where'=> ['id'=> $_POST['id']]]);
			$result['status']     = 1;
				$result['message']    = 'Successfully Decline Payment <strong>OK</strong>';

				echo json_encode($result);
		}
	}
	public function terima($value='')
	{
		if ($_POST) {
			$this->m_global->update(['table'=> 't_pembayaran_guru', 'datas'=> ['status'=> 1], 'where'=> ['id'=> $_POST['id']]]);
			$result['status']     = 1;
				$result['message']    = 'Successfully Accept Payment <strong>OK</strong>';

				echo json_encode($result);
		}
	}
}