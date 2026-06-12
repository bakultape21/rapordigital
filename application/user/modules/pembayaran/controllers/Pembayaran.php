<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends MX_Controller
{

	private $prefix         = 'kelas';
	private $url            = 'pembayaran';
	private $table_db       = 't_kelas_belajar';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['datatables', 'validation'];

		$cek_kabupaten= $this->m_global->get([
			'table'=> 'kabupaten k', 
			'join'=> [
				['t_sekolah s', 'k.kabupaten_id= s.kabupaten_id']], 'where'=> ['sekolah_id'=> login_data('sekolah_id')]])[0];

		if ($cek_kabupaten->nominal_utama== null) {
			redirect('dashboard');
		}else{
			$data_guru= $this->m_global->get(['table'=> 't_guru', 'where'=> ['guru_id'=> login_data('user_id')]])[0];

			if ($data_guru->nominal_tagihan == null) {
				$data['nominal_tagihan']= $cek_kabupaten->nominal_utama+ 900 + rand(1, 99);
				$this->m_global->update(['table'=> 't_guru', 'datas'=> ['nominal_tagihan'=> $data['nominal_tagihan']], 'where'=> ['guru_id'=> login_data('user_id')]]);
			}else{
				$data['nominal_tagihan']= $data_guru->nominal_tagihan;
			}
			
		}
		$data['list_pembayaran']= $this->m_global->get(['table'=> 't_pembayaran_guru', 'where'=> ['guru_id'=> login_data('user_id')]]);

		// print_r(login_data());
		// exit();

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}
	public function add_pembayaran()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['datatables', 'validation'];
		$data['guru']		= $this->m_global->get(['table'=> 't_guru', 'where'=> ['guru_id'=> login_data('user_id')]])[0];
		$this->template->display(strtolower(__CLASS__) . '/form', $data);
	}
	public function save_pembayaran()
	{
		
		if (@$_FILES['bukti_bayar'] !=null) {

			$upload_path = 'uploads/pembayaran';

			$_FILES['file']['name'] = $_FILES['bukti_bayar']['name'];
			$_FILES['file']['type'] = $_FILES['bukti_bayar']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['bukti_bayar']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['bukti_bayar']['error'];
			$_FILES['file']['size'] = $_FILES['bukti_bayar']['size'];
			$config['upload_path'] 		= $upload_path;
			$config['overwrite'] 		= TRUE;
			$config['allowed_types'] 	= 'png|gif|jpeg|jpg';
			$config['max_size']			= 500000;
			$config['encrypt_name']		= TRUE;
			$this->load->library('upload', $config);		
			$this->upload->initialize($config);

			if ($this->upload->do_upload('file')) {
				$dokumen 		= $this->upload->data();
				$product_photo 	= $upload_path . '/' .  $dokumen['file_name'];

				$insert= $this->m_global->insert(['table'=> 't_pembayaran_guru', 'datas'=> 
						['file'=> $product_photo, 
						 'guru_id'=> login_data('user_id'),
						 'status'=> 0, 'nominal'=> $_POST['nominal_tagihan']]]);

				$result['status']     = 1;
				$result['message']    = 'Berhasil Foto Berseri';

				echo json_encode($result);	
				exit();

			}else{

				$result['status']     = 2;
				$result['message']    = 'Gagal Tambahkan Foto Berseri <strong>Tidak Ada Foto</strong> '.$this->upload->display_errors();
				echo json_encode($result);	
				exit();
			}
		}
	}
	
}