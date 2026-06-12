<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
	START Core Helper
*/

# untuk print_f
function pre($var, $exit = null)
{
	$CI = &get_instance();
	echo '<pre>';
	if ($var == 'lastdb') {
		print_r($CI->db->last_query());
	} else if ($var == 'post') {
		print_r($CI->input->post());
	} else if ($var == 'get') {
		print_r($CI->input->get());
	} else {
		print_r($var);
	}
	echo '</pre>';

	if ($exit) {
		exit();
	}
}
function tgl_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tahun
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tanggal
	 
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}

function md5_mod($str, $salt)
{

	$str = md5(md5($str) . $salt);
	return $str;
}

function strEncrypt($str, $forDB = FALSE)
{
	$CI = &get_instance();
	$key    = $CI->config->item('encryption_key');

	$str    = ($forDB) ? 'md5(concat(\'' . $key . '\',' . $str . '))' : md5($key . $str);
	return $str;
}

function login_data($val = '')
{
	$CI             = &get_instance();

	$session_name	= $CI->config->item('session_name');
	$user_data      = $CI->session->userdata($session_name);

	if ($val == '') {
		return $user_data;
	} else {
		return $user_data->$val;
	}
}

function updateSession()
{
	$CI = &get_instance();

	$array_config = [
		'table'     => 't_user',
		'join'      => [['t_role', 'role_id = user_role']],
		'where'     => ['user_id' => login_data('user_id')],
		'select'    => 'user_id, user_full_name, user_name, user_email, user_status, user_photo, role_permission'
	];

	$result   = $CI->m_global->get($array_config)[0];

	$session_name   = $CI->config->item('session_name');

	if (isset($_SESSION[$session_name])) {
		$_SESSION[$session_name] = $result;
	}
}

function uang($var, $tipe = null, $dec = "0")
{
	if (empty($var)) return 0;
	return 'Rp. ' . number_format(str_replace(',', '.', $var), $dec, ',', '.') . ($dec == "0" ? ($tipe == true ? ',-' : ",00") : '');
}

function uang2($var, $dec = "0")
{
	if (empty($var)) return 0;
	return number_format(str_replace(',', '.', $var), $dec, ',', '.');
}

function bulan($bulan)
{
	$aBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

	return $aBulan[$bulan];
}

function hari($hari)
{
	$data  = date('N', strtotime($hari));
	$aHari = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu', 'Minggu'];

	return $aHari[$data];
}

function tgl_format($tgl, $format = "")
{
	if ($format == "") {
		$tanggal    = date('d', strtotime($tgl));
		$bulan      = bulan(date('n', strtotime($tgl)) - 1);
		$tahun      = date('Y', strtotime($tgl));
		return $tanggal . ' ' . $bulan . ' ' . $tahun;
	} elseif ($format == 'd/m/Y') {
		$tanggal    = date('d', strtotime($tgl));
		$bulan      = date('m', strtotime($tgl));
		$tahun      = date('Y', strtotime($tgl));
		return $tanggal . '-' . $bulan . '-' . $tahun;
	}
}

function date_format_indo($tgl, $style = null)
{
	$exp = explode(' ', $tgl);
	$detik      = date('s', strtotime($tgl));
	$menit      = date('i', strtotime($tgl));
	$jam        = date('H', strtotime($tgl));
	$tanggal    = date('d', strtotime($tgl));
	$bulan      = bulan(date('n', strtotime($tgl)) - 1);
	$tahun      = date('Y', strtotime($tgl));

	if (empty($exp[1])) {
		return $tanggal . ' ' . $bulan . ' ' . $tahun;
	} else {
		if ($style == true) {
			return $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $jam . ':' . $menit . ':' . $detik;
		} else {
			return $tanggal . ' ' . $bulan . ' ' . $tahun;
		}
	}
}

function bulan_tahun($param)
{
	$bulan = bulan(date('n', strtotime($param)) - 1);
	$tahun = date('Y', strtotime($param));
	return $bulan . ' ' . $tahun;
}

function date_value($tgl)
{
	$date        = date_format_indo($tgl);
	$date_indo   = explode(' ', $date);

	$hr  = hari($tgl);
	$tg  = Terbilang($date_indo[0]);
	$bln = $date_indo[1];
	$thn = Terbilang($date_indo[2]);

	return $hr . ' tanggal ' . $tg . ' bulan ' . $bln . ' tahun ' . $thn;
}

function bln_thn($tgl, $deli)
{
	$data   = explode($deli, $tgl);
	$x      = (intval($data[0]) - 1);

	return bulan($x) . ' ' . $data[1];
}

function config($val, $json = null)
{
	$CI = &get_instance();
	$result = $CI->m_global->get_data_all('config', null, ['config_nama' => $val])[0];
	if ($result) {
		if ($json) {
			return json_decode($result->config_value);
		} else {
			return $result->config_value;
		}
	} else {
		return null;
	}
}

function terbilang($x)
{
	$x = abs($x);
	$angka = array("", "satu ", "dua ", "tiga ", "empat ", "lima ", "enam ", "tujuh ", "delapan ", "sembilan ", "sepuluh ", "sebelas ");
	$temp = "";
	if ($x < 12) {
		$temp = "" . $angka[$x];
	} else if ($x < 20) {
		$temp = Terbilang($x - 10) . "belas ";
	} else if ($x < 100) {
		$temp = Terbilang($x / 10) . "puluh " . Terbilang($x % 10);
	} else if ($x < 200) {
		$temp = "seratus " . Terbilang($x - 100);
	} else if ($x < 1000) {
		$temp = Terbilang($x / 100) . "ratus " . Terbilang($x % 100);
	} else if ($x < 2000) {
		$temp = " seribu" . Terbilang($x - 1000);
	} else if ($x < 1000000) {
		$temp = Terbilang($x / 1000) . "ribu " . Terbilang($x % 1000);
	} else if ($x < 1000000000) {
		$temp = Terbilang($x / 1000000) . "juta " . Terbilang($x % 1000000);
	} else if ($x < 1000000000000) {
		$temp = Terbilang($x / 1000000000) . "milyar " . Terbilang(fmod($x, 1000000000));
	} else if ($x < 1000000000000000) {
		$temp = Terbilang($x / 1000000000000) . "trilyun " . Terbilang(fmod($x, 1000000000000));
	}
	return $temp;
}

function list_name($array)
{
	$data   = '';
	$count  = count($array);

	if ($count == 1) {
		$data = $array[0];
	} else if ($count == 2) {
		$data = $array[0] . ' dan ' . $array[1];
	} else if ($count > 2) {
		foreach ($array as $key => $val) {
			($key == ($count - 1)) ?
				$data .= ' dan ' . $val :
				$data .= $val . ', ';
		}
	}

	return $data;
}

function list_name2($array, $glue = ',')
{
	$data   = '';
	$count  = count($array);

	if ($count == 1) {
		$data = current($array);
	} else if ($count > 1) {
		$e = end($array);
		$k = key($array);

		foreach ($array as $key => $val) {
			($key == $k) ?
				$data .= $val :
				$data .= $val . $glue;
		}
	}

	return $data;
}

function get_access($id)
{
	$CI = &get_instance();

	$arr = [
		'table'     => 't_role',
		'where'     => ['role_id' => $id],
		'select'    => 'role_access'
	];

	$data = $CI->m_global->get($arr);

	return $data[0]->role_access;
}

function randomData($i = 6)
{
	$data 	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	// $data 	= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$res 	= '';
	$max 	= strlen($data) - 1;

	for ($j = 0; $j < $i; $j++) {
		$res .= $data[mt_rand(0, $max)];
	}

	return $res;
}

//function styling excel
function xls_style()
{
	$CI = &get_instance();
	$CI->load->library('PHPExcel');
	$style = array(
		'acenter' => array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		),
		'hcenter' => array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
		),
		'vcenter' => array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		),

		'left'    => array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
		),
		'right'   => array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			),
		),

		//border
		'border1' => array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		),

		//background
		'bg1'     => array(
			'fill' => array(
				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					'rgb' => 'DDDDDD',
				),
			),
		),

		'bg2'     => array(
			'fill' => array(
				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					'rgb' => 'FFEE99',
				),
			),
		),

		'bg3'     => array(
			'fill' => array(
				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					'rgb' => '99EEFF',
				),
			),
		),

		//font
		'h1'      => array(
			'font' => array(
				'bold' => true,
				'size' => 16,
			),
		),

		'h2'      => array(
			'font' => array(
				'bold' => true,
				'size' => 14,
			),
		),

		'h3'      => array(
			'font' => array(
				'bold' => true,
				'size' => 12,
			),
		),
	);
	return $style;
}

function get_tempat_berangkat($id)
{
	if ($id == '1') {
		$a = 'Pendopo Kota Madiun';
	} else {
		$a = 'Pendopo Caruban';
	}

	return $a;
}
 function status_order($value='')
{
	$arr_status = [
			'0' => '<span class="badge badge-secondary">Payment Proses</span>',
			'1' => '<span class="badge badge-warning">Payment Submit</span>',
			'2' => '<span class="badge badge-success">Payment Approved</span>',
			'3' => '<span class="badge badge-danger">Payment Decline</span>',
			'4' => '<span class="badge badge-info">Deliver</span>',
			'5' => '<span class="badge badge-success">Success</span>',
			'6' => '<span class="badge badge-info">Quotation</span>'
		];
	return $arr_status[$value];
}