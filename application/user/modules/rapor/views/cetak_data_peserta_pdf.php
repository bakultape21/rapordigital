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
                $pdf->SetDrawColor(0,80,180);
                $pdf->SetFillColor(230,230,0);
                $pdf->SetFont('Arial','B', 16);
                $pdf->Cell(190,5,'KETERANGAN TENTANG PESERTA DIDIK', 0, 1, 'C');
                $pdf->ln(8);
                
                $pdf->SetFillColor(255);
                $pdf->SetFont('Arial','', 12);
                $pdf->Cell(10, 8, '1. ', 0, 0, 'C',true);
                $pdf->Cell(50, 8, 'Nama Peserta Didik : ', 0, 1, 'L',true);
                $pdf->Cell(10, 8, '', 0, 0, 'C',true);
                $pdf->Cell(50, 8, '- Nama Lengkap ', 0, 0, 'L',true);
                $pdf->Cell(70, 8, ': '.$data_siswa->nama_lengkap, 0, 1, 'L',true);
                $pdf->Cell(10, 8, '', 0, 0, 'C',true);
                $pdf->Cell(50, 8, '- Nama Panggilan ', 0, 0, 'L',true);
                $pdf->Cell(70, 8, ': '.$data_siswa->nama_panggilan, 0, 1, 'L',true);
                $pdf->Cell(10, 8, '2. ', 0, 0, 'C',true);
                $pdf->Cell(50, 8, 'Nomor Induk ', 0, 0, 'L',true);
                $pdf->Cell(50, 8, ': '.$data_siswa->no_induk, 0, 1, 'L', true);
                $pdf->Cell(10, 8, '3. ', 0, 0, 'C',true);
                $pdf->Cell(50, 8, 'Tempat, Tanggal Lahir ', 0, 0, 'L',true);
                $pdf->Cell(50, 8, ': '.strtoupper($data_siswa->tempat_lahir).', '.tgl_indo($data_siswa->tanggal_lahir), 0, 1, 'L', true);
                $pdf->Cell(10, 8, '4. ', 0, 0, 'C',true);
                $pdf->Cell(50, 8, 'Jenis Kelamin ', 0, 0, 'L',true);
                $pdf->Cell(50, 8, ': '.strtoupper($jenis_kelamin[$data_siswa->jenis_kelamin]), 0, 1, 'L', true);
                $pdf->Cell(10, 8, '5. ', 0, 0, 'C',true);
                $pdf->Cell(50, 8, 'Agama ', 0, 0, 'L',true);
                $pdf->Cell(50, 8, ': '.$agama[$data_siswa->agama], 0, 1, 'L', true);

                 $pdf->SetFont('Arial', '', 12);
                $pdf->SetWidths(array(9, 50 ,100));
                $pdf->SetAligns(array('C','L','L'));
                $pdf->Rows(
                    array(
                        '6.',
                        'Alamat Rumah',
                        ': '.$data_siswa->alamat,
                    ));

                // $pdf->Cell(10, 8, '6. ', 0, 0, 'C',true);
                // $pdf->Cell(50, 8, 'Alamat Rumah ', 0, 0, 'L',true);
                // $pdf->Cell(50, 8, ': '.($data_siswa->alamat), 0, 1, 'L', true);

                $pdf->Cell(10, 8, '7. ', 0, 0, 'C',true);
                $pdf->Cell(50, 8, 'Orang Tua : ', 0, 1, 'L',true);
                $pdf->Cell(10, 8, '', 0, 0, 'C',true);
                $pdf->Cell(50, 8, '- Ayah ', 0, 0, 'L',true);
                $pdf->Cell(70, 8, ': '.$data_siswa->nama_ayah, 0, 1, 'L',true);
                $pdf->Cell(10, 8, '', 0, 0, 'C',true);
                $pdf->Cell(50, 8, '- Ibu ', 0, 0, 'L',true);
                $pdf->Cell(70, 8, ': '.$data_siswa->nama_ibu, 0, 1, 'L',true);
                $pdf->Cell(10, 8, '8. ', 0, 0, 'C',true);
                $pdf->Cell(50, 8, 'Pekerjaan Orang Tua : ', 0, 1, 'L',true);
                $pdf->Cell(10, 8, '', 0, 0, 'C',true);
                $pdf->Cell(50, 8, '- Ayah ', 0, 0, 'L',true);
                $pdf->Cell(70, 8, ': '.$data_siswa->pekerjaan_ayah, 0, 1, 'L',true);
                $pdf->Cell(10, 8, '', 0, 0, 'C',true);
                $pdf->Cell(50, 8, '- Ibu ', 0, 0, 'L',true);
                $pdf->Cell(70, 8, ': '.$data_siswa->pekerjaan_ibu, 0, 1, 'L',true);


                $image = APPPATH. './../../user/'. $data_siswa->foto_siswa;
                $image = str_replace('\\','/' ,$image);
                // $pdf->Image($image, 70, 160, 50, 50);
                $pdf->ln(15);

               
                $pdf->Cell(60, 8, '', 0, 0, 'C',true);
                 $pdf->Cell(40, 50,'Foto 3x4', 0, 0, 'C', false );

                $pdf->Cell(70, 8, $data_siswa->kabupaten.', '.tgl_indo($data_siswa->tanggal_raport_cetak), 0, 1, 'C',true);


                 $pdf->SetFont('Arial', '', 12);
                $pdf->SetWidths(array(100 ,70));
                $pdf->SetAligns(array('C','C'));
                $pdf->Rows(
                    array(
                        '',
                        'Kepala '.$data_siswa->sekolah_nama
                    ));

                // $pdf->Cell(100, 8, '', 0, 0, 'C',true);
                // $pdf->Cell(70, 8, 'Kepala '.$data_siswa->sekolah_nama, 0, 1, 'C',true);

                $pdf->ln(30);
                $pdf->Cell(100, 8, '', 0, 0, 'C',true);
                $pdf->SetFont('Arial','BU', 12);
                $pdf->Cell(70, 8, ($data_siswa->kepala_sekolah), 0, 1, 'C',true);
                $pdf->SetFont('Arial','B', 12);
                $pdf->Cell(100, 8, '', 0, 0, 'C',true);
                $pdf->Cell(70, 8, 'NIP. '.($data_siswa->kepala_sekolah_nip), 0, 1, 'C',true);


                $pdf->Output();
               
               

        


?>