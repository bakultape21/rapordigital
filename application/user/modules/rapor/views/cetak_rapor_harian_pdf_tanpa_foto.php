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

                $this->load->library('PDFb');
                $pdf = new Pdfb('P','mm','A4');
                if ($watermark==1) {
                    $pdf->setImgHead($data_siswa->logo);
                }
                
                // --- SETUP DYNAMIC THEME ---
                if (!empty($theme_color)) {
                    if ($theme_color == 'merah') {
                        $pdf->setBorderColor(231, 76, 60);
                        $bg_r = 231; $bg_g = 76; $bg_b = 60;
                    } elseif ($theme_color == 'kuning') {
                        $pdf->setBorderColor(241, 196, 15);
                        $bg_r = 241; $bg_g = 196; $bg_b = 15;
                    } else {
                        $pdf->setBorderColor(41, 128, 185);
                        $bg_r = 41; $bg_g = 128; $bg_b = 185;
                    }
                } else {
                    $pdf->setBorderColor(41, 128, 185);
                    $bg_r = 41; $bg_g = 128; $bg_b = 185;
                }
                
                $font = (!empty($theme_font)) ? $theme_font : 'Arial';
                
                $pdf->AddPage();
                //
                $pdf->AddPage();

                $pdf->Ln(5);

                // --- PREMIUM HEADER DESIGN ---
                $pdf->SetFillColor($bg_r, $bg_g, $bg_b); // Blue modern background
                $pdf->SetTextColor(255, 255, 255); // White text
                $pdf->SetDrawColor($bg_r, $bg_g, $bg_b);
                
                $pdf->SetFont($font, 'B', 16);
                $pdf->Cell(190, 10, ' LAPORAN CAPAIAN PERKEMBANGAN ANAK', 0, 1, 'C', true);
                
                $pdf->SetFont($font, 'B', 12);
                $pdf->Cell(190, 8, ' TAHUN PELAJARAN ' . strtoupper($data_siswa->tahun), 0, 1, 'C', true);
                $pdf->Ln(6);

                // --- STUDENT INFO SECTION ---
                $pdf->SetFillColor(245, 247, 250); // Sangat light gray background
                $pdf->SetTextColor(44, 62, 80); // Dark text
                $pdf->SetDrawColor(218, 225, 231); // Border gray
                
                // Atur posisi X agar rata dengan header
                $pdf->SetX($pdf->GetX());
                
                $pdf->SetFont($font, 'B', 11);
                $pdf->Cell(45, 8, '   Nama Lengkap', 'LT', 0, 'L', true);
                $pdf->SetFont($font, '', 11);
                $pdf->Cell(145, 8, ': ' . $data_siswa->nama_lengkap, 'TR', 1, 'L', true);
                
                $pdf->SetFont($font, 'B', 11);
                $pdf->Cell(45, 8, '   No Induk', 'L', 0, 'L', true);
                $pdf->SetFont($font, '', 11);
                $pdf->Cell(145, 8, ': ' . $data_siswa->no_induk, 'R', 1, 'L', true);
                
                $pdf->SetFont($font, 'B', 11);
                $pdf->Cell(45, 8, '   Kelompok Kelas', 'L', 0, 'L', true);
                $pdf->SetFont($font, '', 11);
                $pdf->Cell(145, 8, ': ' . strtoupper($data_siswa->nama_kelas), 'R', 1, 'L', true);
                
                $semester = ($data_siswa->semester == '1') ? 'Ganjil' : 'Genap';
                $pdf->SetFont($font, 'B', 11);
                $pdf->Cell(45, 8, '   Semester', 'LB', 0, 'L', true);
                $pdf->SetFont($font, '', 11);
                $pdf->Cell(145, 8, ': ' . $semester, 'RB', 1, 'L', true);
                
                // Reset colors back to normal for content
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFillColor(255, 255, 255);

                foreach($elemen_sekolah as $key):

                    $pdf->Ln(8);
                    // --- ELEGANT SECTION HEADER ---
                    $pdf->SetFont($font, 'B', 14);
                    $pdf->SetTextColor($bg_r, $bg_g, $bg_b); // Blue Title
                    $pdf->SetDrawColor(189, 195, 199); // Light Gray Border
                    
                    // Simple centered cell with a nice bottom border
                    $pdf->Cell(190, 10, strtoupper($key->elemen_data), 'B', 1, 'C');
                    $pdf->Ln(4);
                    
                    // Reset Text Color for the paragraph
                    $pdf->SetTextColor(44, 62, 80);

                    $text_muncul=$data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_muncul_rapor.' ';

                     if ($nilai_rapor != null) {
                        foreach ($nilai_rapor as $ky) {
                            if ($key->elemen_data_id == $ky->elemen_data_id) {
                                $text_muncul .= $ky->kalimat_muncul;
                            }
                        }
                    }else{
                        foreach ($cp_belajar as $ky => $value) :
                            if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai== 2) :
                                $text_muncul .= $value->kegiatan.'. ';
                                
                            endif;
                        endforeach;
                    }

                  

                    $pdf->Ln(2);

                    $pdf->SetFont($font,'',12);

                    $pdf->Cell(2,6, '', 0, 0, 'L');
                    // $pdf->Cell(190,6, , 0, 1, 'L');



                    $column_width = $pdf->GetPageWidth()-15;
                    //Test1
                    $test1 = array();
                    $test1['bullet'] = '';
                    $test1['margin'] = '';
                    $test1['indent'] = 0;
                    $test1['spacer'] = 0;
                    $test1['text'] = array();
                    
                    $test1['text'][0] = $text_muncul;
                    
                    $pdf->SetX(10);
                    $pdf->MultiCellBltArray($column_width-$pdf->GetX(),6,$test1);
                    
                    $pdf->ln(2);
                    $pdf->SetFillColor(255);
                    $pdf->SetFont($font,'', 12);
                    // $pdf->Cell(190,6, , 0, 1, 'L');

                    $text_tidak_muncul=$data_siswa->kalimat_depan_rapor_tidak_muncul.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_rapor.' ';

                    if ($nilai_rapor != null) {
                        foreach ($nilai_rapor as $ky) {
                            if ($key->elemen_data_id == $ky->elemen_data_id) {
                                $text_tidak_muncul .= $ky->kalimat_tidak_muncul;
                            }
                        }
                    }else{
                        foreach ($cp_belajar as $ky => $value) :
                            if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai== 1) :
                                $text_tidak_muncul .= $value->kegiatan.'. ';
                                
                            endif;
                        endforeach;
                    }

                    

                    $column_width = $pdf->GetPageWidth()-15;
                    //Test1
                    $test1 = array();
                    $test1['bullet'] = '';
                    $test1['margin'] = '';
                    $test1['indent'] = 0;
                    $test1['spacer'] = 0;
                    $test1['text'] = array();
                    
                    $test1['text'][0] = $text_tidak_muncul;
                    
                    $pdf->SetX(10);
                    $pdf->MultiCellBltArray($column_width-$pdf->GetX(),6,$test1);


                endforeach;
                $pdf->AddPage();
               

                if ($data_siswa->foto_profile_pancasila != null) {

                    $pdf->Ln(8);
                    $pdf->SetFont($font, 'B', 14);
                    $pdf->SetTextColor($bg_r, $bg_g, $bg_b); // Blue Title
                    $pdf->SetDrawColor(189, 195, 199);
                    $pdf->Cell(190, 10, 'KOKURIKULER', 'B', 1, 'C');
                    $pdf->Ln(4);
                    $pdf->SetTextColor(44, 62, 80);
                    $pdf->SetFillColor(255);
                    $pdf->SetFont($font,'', 12);


                    $image = APPPATH. './../../user/'. $data_siswa->foto_profile_pancasila;
                    $image = str_replace('\\','/' ,$image);
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->SetDrawColor(189, 195, 199); // Light gray border
                    $pdf->Rect($x, $y, 50, 50, 'D'); // Draw border frame for image
                    $pdf->Cell( 50, 50, $pdf->Image($image, $x, $y, 50, 50), 0, 0, 'L', false );

                    $profil_pancasila=$data_siswa->profil_pancasila;

                     $profil_pancasila=$pdf->MultiCell(130,5,$profil_pancasila,0,'J',0,10);
                     $pdf->Ln(1);
                     $profil_pancasila=$pdf->MultiCell(180,5,$profil_pancasila,0,'J',0,30);

                }else{

                    $pdf->Ln(8);
                    $pdf->SetFont($font, 'B', 14);
                    $pdf->SetTextColor($bg_r, $bg_g, $bg_b); // Blue Title
                    $pdf->SetDrawColor(189, 195, 199);
                    $pdf->Cell(190, 10, 'KOKURIKULER', 'B', 1, 'C');
                    $pdf->Ln(4);
                    $pdf->SetTextColor(44, 62, 80);
                    $pdf->SetFillColor(255);
                    $pdf->SetFont($font,'', 12);

                    $column_width = $pdf->GetPageWidth()-15;
                    //Test1
                    $test1 = array();
                    $test1['bullet'] = '';
                    $test1['margin'] = '';
                    $test1['indent'] = 0;
                    $test1['spacer'] = 0;
                    $test1['text'] = array();
                    
                    $test1['text'][0] = $data_siswa->profil_pancasila;
                    
                    $pdf->SetX(10);
                    $pdf->MultiCellBltArray($column_width-$pdf->GetX(),6,$test1);

                }

                
               
                
                
               
               
                

                // $pdf->SetFont($font, 'B', 16);
                // $pdf->SetWidths(array(20, 150 ,20));
                // $pdf->SetAligns(array('R','C','R'));
                // $pdf->Rows(
                //     array(
                //         '',
                //         $key->elemen_data,
                //         '',
                //     ));

                // $pdf->ln(2);
                // $pdf->SetFillColor(255);
                // $pdf->SetFont($font,'', 12);
                // $pdf->Cell(190,6, $data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_muncul_rapor, 0, 1, 'L');

                // $i=1;
                // $text = '';


              

                // $column_width = $pdf->GetPageWidth()-30;
                // $test1 = array();
                // $test1['bullet'] = chr(149);
                // $test1['margin'] = ' ';
                // $test1['indent'] = 0;
                // $test1['spacer'] = 0;
                // $test1['text'] = array();
                // // for ($i=0; $i<5; $i++)
                // // {
                // $test1['text'][$i] = $text;
                // $pdf->SetX(10);
                // $pdf->MultiCellBltArray($column_width-$pdf->GetX(),6,$test1);
                // $pdf->Ln(10);
                // // }

                // $pdf->SetFont($font, '', 12);
                //         $pdf->SetWidths(array(0,180));
                //         $pdf->SetAligns(array('LR','LR'));
                //         $pdf->Rows(
                //             array(
                //                 '',
                //                 $text
                //             ));


                // $pdf->ln(2);
                // $pdf->SetFillColor(255);
                // $pdf->SetFont($font,'', 12);
                // $pdf->Cell(190,6, $data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_rapor, 0, 1, 'L');

                // $i=1;
                // foreach ($cp_belajar as $ky => $value) :
                //     if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai== 1) :

                //         $pdf->SetFont($font, '', 12);
                //         $pdf->SetWidths(array(8,180));
                //         $pdf->SetAligns(array('L','L'));
                //         $pdf->Rows(
                //             array(
                //                 $i.'.',
                //                 $value->kegiatan
                //             ));
                //         $i++;
                //     endif;
                // endforeach;



                // endforeach;

             
                $pdf->Output("rapor-".$data_siswa->no_induk.".pdf", "I");
               
               

        


?>