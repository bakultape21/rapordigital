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
                $pdf->AddPage();
                // $pdf->AddPage();

                $pdf->ln(8);
                
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetFillColor(198, 201, 206);
                $pdf->SetDrawColor(0,80,180);
                $pdf->SetFillColor(230,230,0);
                $pdf->SetFont('Arial','B', 16);
                $pdf->Cell(190,6,'LAPORAN CAPAIAN PERKEMBANGAN ANAK', 0, 1, 'C');
                $pdf->Cell(190,6,'TAHUN PELAJARAN', 0, 1, 'C');
                $pdf->Cell(190,6, strtoupper($data_siswa->tahun), 0, 1, 'C');
                $pdf->ln(5);

                 $pdf->SetFillColor(255);
                $pdf->SetFont('Arial','', 12);
                $pdf->Cell(40, 6, 'Nama Lengkap ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.$data_siswa->nama_lengkap, 0, 1, 'L', true);
                $pdf->Cell(40, 6, 'No Induk ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.$data_siswa->no_induk, 0, 1, 'L', true);
                $pdf->Cell(40, 6, 'Kelompok Kelas ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.strtoupper($data_siswa->nama_kelas), 0, 1, 'L', true);
                 $semester= ($data_siswa->semester=='1') ? 'Ganjil' : 'Genap' ;

                $pdf->Cell(40, 6, 'Semester ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.$semester, 0, 1, 'L', true);

                $total_char='';
                $i = 0;
                $page=0;

                 $txt='';
                
                foreach($elemen_sekolah as $key):

                    $pdf->ln(10);
                    // $pdf->SetFont('Arial','B', 16);
                    // $pdf->Cell(190,6, $key->elemen_data , 0, 1, 'C');

                    $pdf->SetFont('Arial', 'B', 16);
                    $pdf->SetWidths(array(20, 150 ,20));
                    $pdf->SetAligns(array('R','C','R'));
                    $pdf->Rows(
                        array(
                            '',
                            $key->elemen_data,
                            '',
                        ));

                    $text_muncul=$data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_muncul_rapor.' '.$txt;

                  

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


                    $total_char .= $text_muncul;

                    $text_tidak_muncul=$data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_rapor.' ';

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

                    $total_char .= $text_tidak_muncul;

                    $pdf->Ln(2);

                    $pdf->SetFont('Arial','',12);

                    if ($key->foto== null) {
                        $image = APPPATH. './../../user/'. $key->foto_siswa;
                    }else{
                        $image = APPPATH. './../../user/'. $key->foto;
                    }

                    
                    $image = str_replace('\\','/' ,$image);
                    
                    // $pdf->Image($image, 70, 160, 50, 50);

                    $pdf->Cell( 50, 50, $pdf->Image($image, $pdf->GetX(), $pdf->GetY(), 50, 50), 0, 0, 'L', false );

                    $column_width = $pdf->GetPageWidth()-15;

                    if (strlen($text_muncul) < 365) {

                        $text_muncul=$pdf->MultiCell(130,5,$text_muncul,0,'J',0,10);

                        $pdf->Ln(1);

                        $pdf->Cell( 50, 6, '', 0, 0, 'L', false );
                        
                        $text_tidak_muncul=$pdf->MultiCell(130,5,$text_tidak_muncul,0,'J',0,15);
                        $pdf->Ln(1);

                        $text_tidak_muncul=$pdf->MultiCell(183,5,$text_tidak_muncul,0,'J',0,20);
                        # code...
                    }elseif (strlen($text_muncul) < 400 && strlen($text_muncul) > 368) {

                        $text_muncul=$pdf->MultiCell(130,5,$text_muncul,0,'J',0,10);

                        $pdf->Ln(1);

                        $pdf->Cell( 50, 6, '', 0, 0, 'L', false );
                        
                        $text_tidak_muncul=$pdf->MultiCell(130,5,$text_tidak_muncul,0,'J',0,4);
                        $pdf->Ln(1);

                        $text_tidak_muncul=$pdf->MultiCell(183,5,$text_tidak_muncul,0,'J',0,20);
                        # code...
                    }elseif(strlen($text_muncul) > 475 && strlen($text_muncul) < 550){


                        $text_muncul=$pdf->MultiCell(130,5,$text_muncul,0,'J',0,10);
                        $pdf->Ln(2);
                       
                        $text_muncul=$pdf->MultiCell(183,5,$text_muncul,0,'J',0,100);
            
                        $pdf->Ln(5);

                        $text_tidak_muncul=$pdf->MultiCell(183,5,$text_tidak_muncul,0,'J',0,20);

                    }elseif(strlen($text_muncul) > 400 && strlen($text_muncul) < 475){


                        $text_muncul=$pdf->MultiCell(130,5,$text_muncul,0,'J',0,10);
                        $pdf->Ln(2);
                       
                        $text_muncul=$pdf->MultiCell(183,5,$text_muncul,0,'J',0,100);
            
                        $pdf->Ln(8);

                        $text_tidak_muncul=$pdf->MultiCell(183,5,$text_tidak_muncul,0,'J',0,20);

                    }else{
                        $text_muncul=$pdf->MultiCell(130,5,$text_muncul,0,'J',0,10);
                        $pdf->Ln(2);
                       
                        $text_muncul=$pdf->MultiCell(183,5,$text_muncul,0,'J',0,100);
            
                        $pdf->Ln(1);

                        $text_tidak_muncul=$pdf->MultiCell(183,5,$text_tidak_muncul,0,'J',0,20);

                    }

                    if ( $i == 0 && strlen($total_char) > 1900) {
                        $pdf->AddPage();

                    }

                    if ( $i == 1 && strlen($total_char) < 1600) {
                        $pdf->AddPage();
                    }

                    if ( $i == 1 && strlen($total_char) > 1400 && $pdf->PageNo() == 1) {
                        $pdf->AddPage();
                    }

                    if ( $i == 1 && strlen($total_char) > 4000) {
                        $pdf->AddPage();
                    }
                    $i++;

                endforeach;
                $pdf->AddPage();
               if ($data_siswa->foto_profile_pancasila != null) {

                    $pdf->Ln(10);
                    $pdf->SetFont('Arial', 'B', 16);
                    $pdf->SetWidths(array(20, 150 ,20));
                    $pdf->SetAligns(array('R','C','R'));
                    $pdf->Rows(
                            array(
                                '',
                                'KOKURIKULER',
                                '',
                            ));
                    $pdf->SetFillColor(255);
                    $pdf->SetFont('Arial','', 12);


                    $image = APPPATH. './../../user/'. $data_siswa->foto_profile_pancasila;
                    $image = str_replace('\\','/' ,$image);
                    $pdf->Cell( 50, 50, $pdf->Image($image, $pdf->GetX(), $pdf->GetY(), 50, 50), 0, 0, 'L', false );

                    $profil_pancasila=$data_siswa->profil_pancasila;

                     $profil_pancasila=$pdf->MultiCell(130,5,$profil_pancasila,0,'J',0,10);
                     $pdf->Ln(1);
                     $profil_pancasila=$pdf->MultiCell(180,5,$profil_pancasila,0,'J',0,100);

                }else{

                    $pdf->Ln(10);
                    $pdf->SetFont('Arial', 'B', 16);
                    $pdf->SetWidths(array(20, 150 ,20));
                    $pdf->SetAligns(array('R','C','R'));
                    $pdf->Rows(
                            array(
                                '',
                                'KOKURIKULER',
                                '',
                            ));
                    $pdf->SetFillColor(255);
                    $pdf->SetFont('Arial','', 12);

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
             
                $pdf->Output("rapor-".$data_siswa->no_induk.".pdf", "I");
               
               

        


?>