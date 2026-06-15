<?php 
$agama=[
1=>'Islam',
2=>'Kristen',
3=>'Protestan',
4=>'Hindu',
5=>'Khong Hucu',
6=>'Budha',



];

$jenis_kelamin=[
1=>'Laki-Laki',
0=>'Perempuan',


];
            if (@$data_siswa==null) {
                echo 'Logo belum ada';
                exit();
            }

                $this->load->library('Pdf');
                $pdf = new Pdf('P','mm','A4');
                if (isset($hide_border) && $hide_border == '1') {
                    $pdf->setHideBorder(true);
                }
                $pdf->AddPage();
                $pdf->ln(8);
                
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetFillColor(198, 201, 206);
                $pdf->SetDrawColor(0);
                $pdf->SetFillColor(0,0,0);
                $pdf->SetFont('Arial','B', 16);
                $pdf->Cell(190,5,'PERKEMBANGAN JASMANI DAN PERKEMBANGAN ANAK', 0, 1, 'C');
                $pdf->ln(8);
                
                $pdf->SetFillColor(255);
                $pdf->SetFont('Arial','B', 12);
                $pdf->Cell(190, 8, 'Nama Siswa : '.$data_siswa->nama_lengkap, 1, 1, 'C',true);
                $pdf->Cell(20, 8, 'No.', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Keadaan Jasmani dan Kesehatan Anak', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Keterangan', 1, 1, 'C',true);


                $pdf->SetFont('Arial','', 12);

                $pdf->Cell(20, 8, '1', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Mata/Pengelihatan', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->mata_pengelihatan, 1, 1, 'C',true);

                $pdf->Cell(20, 8, '2', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Hidung/Penciuman', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->hidung_penciuman, 1, 1, 'C',true);

                $pdf->Cell(20, 8, '3', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Telinga/Pendengaran', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->telinga_pendengaran, 1, 1, 'C',true);

                $pdf->Cell(20, 8, '4', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Mulut', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->mulut, 1, 1, 'C',true);

                $pdf->Cell(20, 8, '5', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Gigi', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->gigi, 1, 1, 'C',true);

                $pdf->Cell(20, 8, '6', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Anggota Badan', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->anggota_badan, 1, 1, 'C',true);

                $pdf->Cell(20, 8, '7', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Kulit', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->kulit, 1, 1, 'C',true);

                $pdf->Cell(20, 8, '8', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Kebersihan', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->kebersihan, 1, 1, 'C',true);

                $pdf->Cell(20, 8, '9', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Berat Badan', 1, 0, 'C',true);
                $pdf->Cell(42.5, 8, 'Awal='.$data_siswa->bb_awal.' Kg', 1, 0, 'C',true);
                $pdf->Cell(42.5, 8, 'Akhir='.$data_siswa->bb_akhir. ' Kg', 1, 1, 'C',true);

                $pdf->Cell(20, 8, '10', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Tinggi Badan', 1, 0, 'C',true);
                $pdf->Cell(42.5, 8, 'Awal='.$data_siswa->tb_awal.' Cm', 1, 0, 'C',true);
                $pdf->Cell(42.5, 8, 'Akhir='.$data_siswa->tb_akhir. ' Cm', 1, 1, 'C',true);

                $pdf->Cell(20, 8, '11', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Lingkar Kepala', 1, 0, 'C',true);
                $pdf->Cell(42.5, 8, 'Awal='.$data_siswa->lk_awal.' Cm', 1, 0, 'C',true);
                $pdf->Cell(42.5, 8, 'Akhir='.$data_siswa->lk_akhir. ' Cm', 1, 1, 'C',true);

                $pdf->Cell(20, 8, '12', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Lingkar Lengan', 1, 0, 'C',true);
                $pdf->Cell(42.5, 8, 'Awal='.$data_siswa->ll_awal.' Cm', 1, 0, 'C',true);
                $pdf->Cell(42.5, 8, 'Akhir='.$data_siswa->ll_akhir. ' Cm', 1, 1, 'C',true);


                $pdf->Cell(20, 8, '13', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Riwayat Penyakit', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->riwayat_penyakit, 1, 1, 'C',true);


                $pdf->Cell(20, 8, '14', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Kapsul Vitamin', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->kapsul_vitamin, 1, 1, 'C',true);


                $pdf->Cell(20, 8, '15', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Imunisasi', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->imunisasi, 1, 1, 'C',true);


                $pdf->SetFont('Arial','B', 12);
                $pdf->Cell(190, 8, 'Nilai Ekstra', 1, 1, 'C',true);


                $pdf->Cell(20, 8, 'No.', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Jenis Kegiatan', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Deskripsi', 1, 1, 'C',true);


                $pdf->SetFont('Arial','', 12);

                $i=1; 
                foreach ($nilai_ekstra as $key):

                    $pdf->Cell(20, 8, $i, 1, 0, 'C',true);
                    $pdf->Cell(85, 8, $key->nilai_ekstra_kegiatan, 1, 0, 'C',true);
                    $pdf->Cell(85, 8, $key->nilai_ekstra, 1, 1, 'C',true);
                        
                    $i++; 
                endforeach;

                

                $pdf->addPage();

                $pdf->SetFont('Arial','B', 12);
                $pdf->Cell(190, 8, 'Absensi', 1, 1, 'C',true);


                $pdf->SetFont('Arial','', 12);


                $pdf->Cell(20, 8, '1', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Sakit', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->absensi_sakit, 1, 1, 'C',true);
                
                $pdf->Cell(20, 8, '2', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Izin', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->absensi_izin, 1, 1, 'C',true);
                  
                $pdf->Cell(20, 8, '3', 1, 0, 'C',true);
                $pdf->Cell(85, 8, 'Tanpa Keterangan', 1, 0, 'C',true);
                $pdf->Cell(85, 8, $data_siswa->absensi_tanpa_keterangan, 1, 1, 'C',true);
                     


                $pdf->SetFont('Arial','', 12);


                $pdf->SetFont('Arial', '', 12);
                $pdf->SetWidths(array(95, 95));
                $pdf->SetAligns(array('C', 'C'));
                $pdf->Rowd(
                    array(
                        '
Mengetahui
Kepala '.$data_siswa->sekolah_nama.'







',

'
'.$data_siswa->kabupaten.', '.tgl_indo($data_siswa->tanggal_raport_pembagian).'
Guru/Wali Kelas








'
                    ));

$pdf->SetFont('Arial','BU', 12);
                $pdf->Rowd(
                    array(
                        '
('.$data_siswa->kepala_sekolah.')
'.''.$data_siswa->kepala_sekolah_nip.'',

'
('.$data_siswa->guru_nama.')
'.$data_siswa->nip
                    ));
                 // $pdf->Cell(95, 8, 'Kepala '.$data_siswa->sekolah_nama, 'LR', 0, 'C',true);



                

                $pdf->SetFont('Arial','', 12);

                $pdf->Cell(190, 8, 'Refleksi Orang Tua..........', 'LRT', 1, 'L',true);
                $pdf->Cell(190, 20, '', 'LRB', 1, 'L',true);

                $pdf->Cell(95, 8, '', 0, 0, 'C',true);
                $pdf->Cell(95, 8, $data_siswa->kabupaten.', '.tgl_indo($data_siswa->tanggal_raport_pengembalian), 'LRT', 1, 'C',true);

                $pdf->Cell(95, 8, '', 0, 0, 'C',true);
                $pdf->Cell(95, 8, 'Orang Tua/Wali', 'LR', 1, 'C',true);

                $pdf->Cell(95, 20, '', 0, 0, 'C',true);
                $pdf->Cell(95, 20, '', 'LR', 1, 'C',true);


                $pdf->Cell(95, 20, '', 0, 0, 'C',true);
                $pdf->Cell(95, 20, '(................................)', 'LRB', 1, 'C',true);

               


                $pdf->Output();
               
               

        


?>