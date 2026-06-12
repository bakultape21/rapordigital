<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_penilaian extends MX_Controller
{

	private $prefix         = 'laporan_penilaian';
	private $url            = 'laporan_penilaian';
	private $table_db       = 't_sekolah';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index()
	{
		
		$data['title']		= 'Edit - ' . ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url, 'Edit' => base_url() . $this->url . '/index/'];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['permission'] = 'w';
		$data['plugin'] 	= ['validation', 'jstree'];
		$data['id'] 		= strEncrypt(login_data('sekolah_id'));


		$arr_conf 			= [
			'table'	=> 't_sekolah s',
			'join'	=>[
				['kabupaten k', 's.kabupaten_id= k.kabupaten_id']
			],
			'where'	=> ['sekolah_id' => login_data('sekolah_id')]
		];
		$data['record'] 	= $this->m_global->get($arr_conf)[0];

		$data['guru']= $this->m_global->get([
			'table'=> 't_guru',
			'where'	=> ['sekolah_id' => login_data('sekolah_id')]
		]);


		$this->template->display(strtolower(__CLASS__) . '/detail', $data);
	
	}


	public function action_laporan($type='', $id)
	{
		if ($type== 'sekolah') {
			$query=[
				'table'=> 't_sekolah s', 
				'join'=> [
					['kabupaten k', 'k.kabupaten_id= s.kabupaten_id'],

					],
				'where'=> [strEncrypt('s.sekolah_id', true) => $id]

			];
			$data_sekolah= $this->m_global->get($query)[0];

			$elemen= $this->m_global->get([
				'table'=> 't_sekolah_elemen s',
				'join'=> [['t_sekolah_elemen_data sd','s.sekolah_elemen_id= sd.sekolah_elemen_id']],
				'where'=> ['s.sekolah_id'=> $data_sekolah->sekolah_id]
			]);

			$cp = $this->m_global->get([
				'table'=>  't_kelas_belajar k',
				'join' => [
					['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
					['t_cp_kelas_belajar cp', 'cp.kelas_id= k.kelas_id'],
					["(select kegiatan_belajar, cp_id, kegiatan_tanggal from 
						t_kelas_belajar_kegiatan
						where kegiatan_tanggal >= '".$_POST['awal']."' and kegiatan_tanggal <= '".$_POST['akhir']."'
					) tk", 'tk.cp_id= cp.cp_id', 'left']
				],
				'where'=> [
					's.sekolah_id'=> $data_sekolah->sekolah_id,
					'k.tahun_ajaran'	=> $_POST['tahun'],
					'k.semester'=> $_POST['semester']
				],
				'order'=> ['cp_nomor', 'asc']
			]);

			$kelas = $this->m_global->get([
				'table'=>  't_kelas_belajar k',
				'join' => [
					['t_guru g', 'g.guru_id= k.guru_id'],
				],
				'where'=> [
					'k.sekolah_id'=> $data_sekolah->sekolah_id,
					'k.tahun_ajaran'	=> $_POST['tahun'],
					'k.semester'=> $_POST['semester']
				]
			]);


			$this->load->library('Pdf');
			$pdf = new Pdf('L', 'mm', 'A4');
			$pdf->AliasNbPages();

			$pdf->AddPage();
			$pdf->SetFont('Arial', 'B', 14);
			$pdf->SetFillColor(255);
			$pdf->Cell(290, 5, 'LAPORAN PENILAIAN SEKOLAH', 0, 1, 'C');

			$pdf->SetFont('Arial', '', 10);
			if ($_POST['awal'] && !$_POST['akhir']) {
				$pdf->Cell(290, 5, 'Tanggal : '.($_POST['awal']).' s/d '.(date('Y-m-d')), 0, 1, 'C');
			}
			if ($_POST['awal'] && $_POST['akhir']) {
				$pdf->Cell(290, 5, 'Tanggal : '.($_POST['awal']).' s/d '.($_POST['akhir']), 0, 1, 'C');
			}
			if (!$_POST['awal'] && $_POST['akhir']) {
				$pdf->Cell(290, 5, 'Sampai dengan tanggal : '.($_POST['akhir']), 0, 1, 'C');
			}
			$pdf->SetFont('Arial', '', 8);
			$pdf->ln(3);
			$pdf->SetLineWidth(0.01);
			$pdf->Line($pdf->Getx() - 10, $pdf->GetY(), $pdf->Getx() + 290 + 10, $pdf->GetY());
			$pdf->Line($pdf->Getx() - 10, $pdf->GetY() + 0.7, $pdf->Getx() + 290 + 10, $pdf->GetY() + 0.7);
			$pdf->ln(5);

			$pdf->SetFont('Arial', '', 10);


			$y = $pdf->getY();

			$pdf->Cell(30, 5, 'Nama Lembaga', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$data_sekolah->sekolah_nama, 0, 1, 'L',true);
			$pdf->Cell(30, 5, 'NPSN', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$data_sekolah->npsn, 0, 1, 'L',true);
			$pdf->Cell(30, 5, 'Alamat', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$data_sekolah->alamat, 0, 1, 'L',true);
			$pdf->Cell(30, 5, 'Kabupaten', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$data_sekolah->kabupaten, 0, 1, 'L',true);

			$pdf->Cell(30, 5, 'Tahun ajaran', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$_POST['tahun'].' / '. ($_POST['tahun']+1), 0, 1, 'L',true);

			$pdf->Cell(30, 5, 'Semester', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '. ($_POST['semester']==1) ? 'Ganjil' : 'Genap' , 0, 1, 'L',true);

			$pdf->ln(2);


			$pdf->SetFillColor(230, 230, 230);

			$pdf->SetFont('Arial', 'B', 8);


			$pdf->Cell(10, 8, 'NO', 1, 0, 'C',true);
			$pdf->Cell(30, 8, 'KELAS', 1, 0, 'C',true);
			$pdf->Cell(20, 8, 'TANGGAL', 1, 0, 'C',true);
			$pdf->Cell(20, 8, 'CP NOMOR', 1, 0, 'C',true);
			$pdf->Cell(100, 8, 'CP', 1, 0, 'C',true);
			$pdf->Cell(100, 8, 'KEGIATAN', 1, 1, 'C',true);

			$pdf->SetFillColor(255);

			$pdf->SetFont('Arial', '', 8);
			$pdf->SetWidths(array(10,30,20,20,100,100));
			$pdf->SetAligns(array('C','L','L','C','L', 'L'));

			foreach ($elemen as $key => $value) {
				$pdf->Cell(280, 8, $value->elemen_data, 1, 1, 'C',true);

				$no=1;

				foreach ($kelas as $k => $v) {

					$pdf->SetFillColor(230, 230, 230);

					$pdf->Cell(280, 8, $v->guru_nama, 1, 1, 'L',true);
					$pdf->SetFillColor(255);

					foreach ($cp as $ky => $val) {

						if ($value->elemen_data_id == $val->elemen_data_id && $val->kelas_id == $v->kelas_id) {
							$pdf->Row(
							array(
								$no++,
								$val->nama_kelas,
								$val->kegiatan_tanggal,
								$val->cp_nomor,
								$val->capaian_belajar,
								$val->kegiatan_belajar
							));
						}
						
					}
				}
			}

			$pdf->SetFont('Arial', '', 7);

			$no = 1;
			$total=$total_register=0;


			$pdf->ln(1);
			$pdf->SetFont('Arial','I', 10);
			$pdf->Cell(140, 8, 'Dokumen ini di cetak pada tanggal '. tgl_indo($_POST['tanggal_cetak']), 0, 0, 'L',true);
			$pdf->ln(1);

			$pdf->ln(10);

                $pdf->SetFont('Arial', '', 12);
                $pdf->SetWidths(array(140 ,140));
                $pdf->SetAligns(array('C','C'));
                $pdf->Rows(
                    array(
                        '',
                        'Kepala '. $data_sekolah->sekolah_nama
                    ));

                // $pdf->Cell(100, 8, '', 0, 0, 'C',true);
                // $pdf->Cell(70, 8, 'Kepala '.$data_siswa->sekolah_nama, 0, 1, 'C',true);

                $pdf->ln(30);
                $pdf->SetFont('Arial','BU', 12);
                $pdf->Cell(140, 8, '', 0, 0, 'C',true);
                $pdf->SetFont('Arial','BU', 12);
                $pdf->Cell(140, 8, @$kelas[0]->kepala_sekolah, 0, 1, 'C',true);
                $pdf->SetFont('Arial','B', 12);
                $pdf->Cell(140, 8, '', 0, 0, 'C',true);
                $pdf->Cell(140, 8, 'NIP. '.@$kelas[0]->kepala_sekolah_nip, 0, 1, 'C',true);

			$pdf->Output("laporan_pendaftar.pdf", "I");

		}else{

				$query=[
				'table'=> 't_sekolah s', 
				'join'=> [
					['kabupaten k', 'k.kabupaten_id= s.kabupaten_id'],
					['t_guru g', 'g.sekolah_id= s.sekolah_id']

					],
				'where'=> [strEncrypt('g.guru_id', true) => $id]

			];
			$data_sekolah= $this->m_global->get($query)[0];

			$elemen= $this->m_global->get([
				'table'=> 't_sekolah_elemen s',
				'join'=> [['t_sekolah_elemen_data sd','s.sekolah_elemen_id= sd.sekolah_elemen_id']],
				'where'=> ['s.sekolah_id'=> $data_sekolah->sekolah_id]
			]);

			// echo $this->db->last_query();

			$cp = $this->m_global->get([
				'table'=>  't_kelas_belajar k',
				'join' => [
					['t_sekolah s', 's.sekolah_id= k.sekolah_id'],
					['t_cp_kelas_belajar cp', 'cp.kelas_id= k.kelas_id'],
					['t_guru g', 'g.guru_id= k.guru_id'],
					["(select kegiatan_belajar, cp_id, kegiatan_tanggal from 
						t_kelas_belajar_kegiatan
						where kegiatan_tanggal >= '".$_POST['awal']."' and kegiatan_tanggal <= '".$_POST['akhir']."'
					) tk", 'tk.cp_id= cp.cp_id', 'left']
				],
				'where'=> [
					'g.guru_id'=> $data_sekolah->guru_id,
					'k.tahun_ajaran'	=> $_POST['tahun'],
					'k.semester'=> $_POST['semester']
				],
				'order'=> ['cp_nomor', 'asc']
			]);

		

			$this->load->library('Pdf');
			$pdf = new Pdf('L', 'mm', 'A4');
			$pdf->AliasNbPages();

			$pdf->AddPage();
			$pdf->SetFont('Arial', 'B', 14);
			$pdf->SetFillColor(255);
			$pdf->Cell(290, 5, 'LAPORAN PENILAIAN GURU', 0, 1, 'C');

			$pdf->SetFont('Arial', '', 10);
			if ($_POST['awal'] && !$_POST['akhir']) {
				$pdf->Cell(290, 5, 'Tanggal : '.($_POST['awal']).' s/d '.(date('Y-m-d')), 0, 1, 'C');
			}
			if ($_POST['awal'] && $_POST['akhir']) {
				$pdf->Cell(290, 5, 'Tanggal : '.($_POST['awal']).' s/d '.($_POST['akhir']), 0, 1, 'C');
			}
			if (!$_POST['awal'] && $_POST['akhir']) {
				$pdf->Cell(290, 5, 'Sampai dengan tanggal : '.($_POST['akhir']), 0, 1, 'C');
			}
			$pdf->SetFont('Arial', '', 8);
			$pdf->ln(3);
			$pdf->SetLineWidth(0.01);
			$pdf->Line($pdf->Getx() - 10, $pdf->GetY(), $pdf->Getx() + 290 + 10, $pdf->GetY());
			$pdf->Line($pdf->Getx() - 10, $pdf->GetY() + 0.7, $pdf->Getx() + 290 + 10, $pdf->GetY() + 0.7);
			$pdf->ln(5);

			$pdf->SetFont('Arial', '', 10);


			$y = $pdf->getY();


			$pdf->Cell(30, 5, 'Nama Guru', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$data_sekolah->guru_nama, 0, 1, 'L',true);

			$pdf->Cell(30, 5, 'NIP', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$data_sekolah->nip, 0, 1, 'L',true);

			$pdf->Cell(30, 5, 'Nama Lembaga', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$data_sekolah->sekolah_nama, 0, 1, 'L',true);
			$pdf->Cell(30, 5, 'NPSN', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$data_sekolah->npsn, 0, 1, 'L',true);
			$pdf->Cell(30, 5, 'Alamat', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$data_sekolah->alamat, 0, 1, 'L',true);
			$pdf->Cell(30, 5, 'Kabupaten', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$data_sekolah->kabupaten, 0, 1, 'L',true);
			$pdf->Cell(30, 5, 'Tahun ajaran', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.$_POST['tahun'].' / '. ($_POST['tahun']+1), 0, 1, 'L',true);

			$pdf->Cell(30, 5, 'Semester', 0, 0, 'L',true);
			$pdf->Cell(100, 5, ': '.($_POST['semester']==1) ? 'Ganjil' : 'Genap' , 0, 1, 'L',true);

			$pdf->ln(2);


			$pdf->SetFillColor(230, 230, 230);

			$pdf->SetFont('Arial', 'B', 8);


			$pdf->Cell(10, 8, 'NO', 1, 0, 'C',true);
			$pdf->Cell(30, 8, 'KELAS', 1, 0, 'C',true);
			$pdf->Cell(20, 8, 'TANGGAL', 1, 0, 'C',true);
			$pdf->Cell(20, 8, 'CP NOMOR', 1, 0, 'C',true);
			$pdf->Cell(100, 8, 'CP', 1, 0, 'C',true);
			$pdf->Cell(100, 8, 'KEGIATAN', 1, 1, 'C',true);

			$pdf->SetFillColor(255);

			$pdf->SetFont('Arial', '', 8);
			$pdf->SetWidths(array(10,30,20,20,100,100));
			$pdf->SetAligns(array('C','L','L','C','L', 'L'));

			foreach ($elemen as $key => $value) {
				$pdf->Cell(280, 8, $value->elemen_data, 1, 1, 'C',true);

				
					$no=1;
					foreach ($cp as $ky => $val) {

						if ($value->elemen_data_id == $val->elemen_data_id ) {
							$pdf->Row(
							array(
								$no++,
								$val->nama_kelas,
								$val->kegiatan_tanggal,
								$val->cp_nomor,
								$val->capaian_belajar,
								$val->kegiatan_belajar
							));
						}
						
					}
				
			}

			$pdf->ln(1);
			$pdf->SetFont('Arial','I', 10);
			$pdf->Cell(140, 8, 'Dokumen ini di cetak pada tanggal '. tgl_indo($_POST['tanggal_cetak']), 0, 0, 'L',true);
			$pdf->ln(1);

			$pdf->ln(10);

                $pdf->SetFont('Arial', '', 12);
                $pdf->SetWidths(array(100 ,80,100));
                $pdf->SetAligns(array('C','C','C'));
                $pdf->Rows(
                    array(
                        'Guru',
                        '',
                        'Kepala '. $data_sekolah->sekolah_nama
                    ));

                // $pdf->Cell(100, 8, '', 0, 0, 'C',true);
                // $pdf->Cell(70, 8, 'Kepala '.$data_siswa->sekolah_nama, 0, 1, 'C',true);

                $pdf->ln(30);
                $pdf->SetFont('Arial','BU', 12);
                $pdf->Cell(100, 8, @$cp[0]->guru_nama, 0, 0, 'C',true);
                $pdf->SetFont('Arial','BU', 12);

                $pdf->SetFont('Arial','BU', 12);
                $pdf->Cell(80, 8, '', 0, 0, 'C',true);

                $pdf->Cell(100, 8, @$cp[0]->kepala_sekolah, 0, 1, 'C',true);
                $pdf->SetFont('Arial','B', 12);
                $pdf->Cell(100, 8, '', 0, 0, 'C',true);
                $pdf->Cell(80, 8, @$cp[0]->nip, 0, 0, 'C',true);
                $pdf->Cell(100, 8, 'NIP. '.@$cp[0]->kepala_sekolah_nip, 0, 1, 'C',true);


			$no = 1;
			$total=$total_register=0;
			$pdf->Output("laporan_pendaftar.pdf", "I");


		}
	}
	


}