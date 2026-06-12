<?php 
$agama=[
1=>'Islam',
2=>'Kristen',
3=>'Protestan',
4=>'Hindu',
5=>'Khong Hucu',


];
            if (@$siswa==null) {
                echo 'Logo belum ada';
                exit();
            }

                $this->load->library('Pdf');
                $pdf = new Pdf('P','mm','A4');
                $pdf->AddPage();
                // $pdf->AddPage();

                $pdf->ln(8);
                
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetFillColor(198, 201, 206);
                $pdf->SetDrawColor(0,80,180);
                $pdf->SetFillColor(230,230,0);
                $pdf->SetFont('Arial','B', 20);

                $pdf->Cell(190,6,'FOTO BERSERI', 0, 1, 'C');

                $pdf->SetFont('Arial','B', 16);
                $pdf->MultiCell(190,6,$guru_sekolah->sekolah_nama,0,'C',0,2);
                // $pdf->Cell(190,6, $siswa->nama_sekolah, 0, 1, 'C');
                // $pdf->Cell(190,6, strtoupper($siswa->tahun), 0, 1, 'C');
                $pdf->ln(5);

                $pdf->SetFillColor(255);
                $pdf->SetFont('Arial','', 12);
                $pdf->Cell(40, 6, 'Nama Lengkap ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.$siswa->nama_lengkap, 0, 1, 'L', true);
                $pdf->Cell(40, 6, 'No Induk ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.$siswa->no_induk, 0, 1, 'L', true);
                
                 $semester= ($foto_berseri[0]->semester=='1') ? 'Ganjil' : 'Genap' ;

                $pdf->Cell(40, 6, 'Semester ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.$semester, 0, 1, 'L', true);

                $date1 = new DateTime(date('Y-m-d'));
                $date2 = new DateTime(date('Y-m-d', strtotime($siswa->tanggal_lahir)));
                $interval = $date1->diff($date2);

                $pdf->Cell(40, 6, 'Usia ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.$interval->y.' Tahun', 0, 1, 'L', true);

                $pdf->Cell(40, 6, 'Kelompok Kelas ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.strtoupper($siswa->nama_kelas), 0, 1, 'L', true);

                $pdf->Cell(40, 6, 'Wali Kelas ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.strtoupper($guru_sekolah->guru_nama), 0, 1, 'L', true);
                $pdf->Cell(40, 6, 'Tanggal ', 0, 0, 'L',true);
                $pdf->Cell(50, 6, ': '.tgl_indo( $foto_berseri[0]->tanggal), 0, 1, 'L', true);

                 $pdf->ln(2);

                 $pdf->SetFont('Arial','B', 12);

                $pdf->Cell(30, 6, 'Tanggal ', 1, 0, 'C',true);
                $pdf->Cell(50, 6, 'Hasil Karya ', 1, 0, 'C',true);
                $pdf->Cell(50, 6, 'Hasil Pengamatan ', 1, 0, 'C',true);
                $pdf->Cell(60, 6, 'Capaian Belajar ', 1, 1, 'C',true);

                $pdf->SetWidths(array(30, 50, 50, 60));
                $pdf->SetAligns(array('C', 'C', 'C', 'C'));

                $i=0; 
                 $pdf->SetFont('Arial','', 10.5);
                 $pdf->setImageKey(1);

                $text='';
                foreach ($foto_berseri as $key => $value) :
                    $image = APPPATH. './../../user/'. $guru_sekolah->logo;
                    $image = str_replace('\\','/' ,$image);


                    foreach ($elemen as $ky => $val) :
                        $text.=$val->elemen_data.'
';
                        foreach ($cp_belajar as $k => $v) {
                            if ($v->elemen_data_id== $val->elemen_data_id) {
                                $text.= strtolower(('-'.$v->capaian_belajar.'
')); 
                            } 

                        } 
                                    
                    endforeach;
                    
                    $text .= '
UMPAN BALIK
'.$value->umpan_balik;

                    $ft = array();

                    foreach ($foto as $ky => $v) {

                        $image = APPPATH. './../../user/'. $v->dokumentasi;
                        $image = str_replace('\\','/' ,$image);
                        $ft[]= $image;

                    }



                    
                    $pdf->Rowimgcs(array($value->tanggal,$image, $value->pengamatan, $text), $ft);




                $i++; 
                endforeach;
                

                // $pdf->cell(1, 1,  $pdf->Image($image,null, null, 50, 50).$pdf->Image($image,null, null, 50, 50), 0,0, 0);
               

               $pdf->ln(50);


                $pdf->SetFont('Arial', '', 12);

                $pdf->Cell(95, 6, 'Mengetahui ', 'TLR', 0, 'C',true);
                $pdf->Cell(95, 6, ' ', 'TLR', 1, 'C',true);

                $pdf->Cell(95, 6, 'Kepala '.$guru_sekolah->sekolah_nama, 'LR', 0, 'C',true);
                $pdf->Cell(95, 6, $guru_sekolah->kabupaten.', '.tgl_indo($guru_sekolah->tanggal_raport_pembagian), 'LR', 1, 'C',true);

                $pdf->Cell(95, 6, '', 'LR', 0, 'C',true);
                $pdf->Cell(95, 6, 'Guru/Wali Kelas', 'LR', 1, 'C',true);

                $pdf->Cell(95, 6, '', 'LR', 0, 'C',true);
                $pdf->Cell(95, 6, '', 'LR', 1, 'C',true);
                $pdf->Cell(95, 6, '', 'LR', 0, 'C',true);
                $pdf->Cell(95, 6, '', 'LR', 1, 'C',true);
                $pdf->Cell(95, 6, '', 'LR', 0, 'C',true);
                $pdf->Cell(95, 6, '', 'LR', 1, 'C',true);
                $pdf->Cell(95, 6, '', 'LR', 0, 'C',true);
                $pdf->Cell(95, 6, '', 'LR', 1, 'C',true);
                $pdf->Cell(95, 6, '', 'LR', 0, 'C',true);
                $pdf->Cell(95, 6, '', 'LR', 1, 'C',true);
                
                $pdf->Cell(95, 6, '', 'LR', 0, 'C',true);
                $pdf->Cell(95, 6, '', 'LR', 1, 'C',true);




                $pdf->Cell(95, 6, '('.$guru_sekolah->kepala_sekolah.')', 'LR', 0, 'C',true);
                $pdf->Cell(95, 6, '('.$guru_sekolah->guru_nama.')', 'LR', 1, 'C',true);

                $pdf->Cell(95, 6, $guru_sekolah->kepala_sekolah_nip, 'LRB', 0, 'C',true);
                $pdf->Cell(95, 6, $guru_sekolah->nip, 'LRB', 1, 'C',true);
               

             
                $pdf->Output("fotoberseri-".$siswa->no_induk.".pdf", "I");
               
               

        


?>