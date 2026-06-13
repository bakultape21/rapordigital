<?php 
$agama=[
1=>'Islam',
2=>'Kristen',
3=>'Protestan',
4=>'Hindu',
5=>'Khong Hucu',


];
            if (@$data_siswa==null) {
                echo 'Logo belum ada';
                exit();
            }

                $this->load->library('Pdf');
                $pdf = new Pdf('P','mm','A4');
                $pdf->AddPage();
                $pdf->Ln(5);

                // --- PREMIUM HEADER DESIGN ---
                $pdf->SetFillColor(41, 128, 185); // Blue modern background
                $pdf->SetTextColor(255, 255, 255); // White text
                $pdf->SetDrawColor(41, 128, 185);
                
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(190, 10, ' LAPORAN CAPAIAN PERKEMBANGAN ANAK', 0, 1, 'C', true);
                
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(190, 8, ' TAHUN PELAJARAN ' . strtoupper($data_siswa->tahun), 0, 1, 'C', true);
                $pdf->Ln(6);

                // --- STUDENT INFO SECTION ---
                $pdf->SetFillColor(245, 247, 250); // Sangat light gray background
                $pdf->SetTextColor(44, 62, 80); // Dark text
                $pdf->SetDrawColor(218, 225, 231); // Border gray
                
                // Atur posisi X agar rata dengan header
                $pdf->SetX($pdf->GetX());
                
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(45, 8, '   Nama Lengkap', 'LT', 0, 'L', true);
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(145, 8, ': ' . $data_siswa->nama_lengkap, 'TR', 1, 'L', true);
                
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(45, 8, '   No Induk', 'L', 0, 'L', true);
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(145, 8, ': ' . $data_siswa->no_induk, 'R', 1, 'L', true);
                
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(45, 8, '   Kelompok Kelas', 'L', 0, 'L', true);
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(145, 8, ': ' . strtoupper($data_siswa->nama_kelas), 'R', 1, 'L', true);
                
                $semester = ($data_siswa->semester == '1') ? 'Ganjil' : 'Genap';
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(45, 8, '   Semester', 'LB', 0, 'L', true);
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(145, 8, ': ' . $semester, 'RB', 1, 'L', true);
                
                // Reset colors back to normal for content
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFillColor(255, 255, 255);

                foreach($elemen_sekolah as $key):

                $pdf->Ln(8);
                // --- ELEGANT SECTION HEADER ---
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->SetTextColor(41, 128, 185); // Blue Title
                $pdf->SetDrawColor(189, 195, 199); // Light Gray Border
                
                // Simple centered cell with a nice bottom border
                $pdf->Cell(190, 10, strtoupper($key->elemen_data), 'B', 1, 'C');
                $pdf->Ln(4);
                
                // Reset Text Color for the paragraph
                $pdf->SetTextColor(44, 62, 80);

                $pdf->ln(2);
                $pdf->SetFillColor(255);
                $pdf->SetFont('Arial','', 12);
                $pdf->Cell(190,6, $data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_muncul_rapor, 0, 1, 'L');

                $i=1;
                $text = '';


                foreach ($cp_belajar as $ky => $value) :
                    if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai== 2) :

                        $text .= $value->kegiatan.'. ';
                        
                    endif;
                endforeach;

                $column_width = $pdf->GetPageWidth()-30;
                $test1 = array();
                $test1['bullet'] = chr(149);
                $test1['margin'] = ' ';
                $test1['indent'] = 0;
                $test1['spacer'] = 0;
                $test1['text'] = array();
                // for ($i=0; $i<5; $i++)
                // {
                    $test1['text'][$i] = $text;
                    $pdf->SetX(10);
                $pdf->MultiCellBltArray($column_width-$pdf->GetX(),6,$test1);
                $pdf->Ln(10);
                // }

                // $pdf->SetFont('Arial', '', 12);
                //         $pdf->SetWidths(array(0,180));
                //         $pdf->SetAligns(array('LR','LR'));
                //         $pdf->Rows(
                //             array(
                //                 '',
                //                 $text
                //             ));


                $pdf->ln(2);
                $pdf->SetFillColor(255);
                $pdf->SetFont('Arial','', 12);

                $pdf->SetWidths(array(2, 188));
                $pdf->SetAligns(array('R','C','R'));
                $pdf->Row(
                    array(
                        '',
                        $data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_rapor,
                        '',
                    ));
                // $pdf->Cell(190,6, $data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_rapor, 0, 1, 'L');

                $i=1;
                foreach ($cp_belajar as $ky => $value) :
                    if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai== 1) :

                        $pdf->SetFont('Arial', '', 12);
                        $pdf->SetWidths(array(8,180));
                        $pdf->SetAligns(array('L','L'));
                        $pdf->Rows(
                            array(
                                $i.'.',
                                $value->kegiatan
                            ));
                        $i++;
                    endif;
                endforeach;



                endforeach;

             
                $pdf->Output("rapor-".$data_siswa->no_induk.".pdf", "I");
               
               

        


?>