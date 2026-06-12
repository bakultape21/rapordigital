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

                foreach($elemen_sekolah as $key):

                $pdf->ln(8);
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