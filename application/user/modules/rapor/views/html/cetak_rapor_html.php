<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Laporan</title>
	<link href="<?php echo base_url(); ?>./../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<style type="text/css">
	body{
		background-color: white;
	}

	@media print {
    @page {
        size: A4; /* Bisa diganti: A3, A5, Letter, Legal */
        margin: 15mm; /* Margin diatur dalam mm atau in */
    }
}
	@media print {
  body {
    visibility: hidden;
  }
  #sectiontoprint {
    visibility: visible;
    position: absolute;
    left: 0;
    top: 0;
  }
}
.images { float: left; }

.text{
	 text-align: justify;
}

<?php if ($watermark==1) {?>
	.img-watermarked{
    text-align: -webkit-center;
		background-image: url('<?= base_url($data_siswa->logo) ?>');
		background-size: 100px auto;
    background-position: center;
    background-color: rgba(255, 255, 255, 0.9); /* Warna transparan */
    background-blend-mode: lighten;
}
<?php } ?>


.borderimg-hijau { 
  border: 10px solid transparent;
/*  padding: 15px;*/
  border-image: url('<?= base_url() ?>./../assets/border-hijau.png') 30 round;
/*  border-image-width: 40px;*/
}
.borderimg-hijau-stretch { 
  border: 10px solid transparent;
/*  padding: 15px;*/
  border-image: url('<?= base_url() ?>./../assets/border-hijau.png') 30 stretch;
/*  border-image-width: 40px;*/
}


.borderimg-biru { 
  border: 10px solid transparent;
/*  padding: 15px;*/
  border-image: url('<?= base_url() ?>./../assets/border-biru.png') 30 round;
/*  border-image-width: 40px;*/
}
.borderimg-biru-stretch { 
  border: 10px solid transparent;
/*  padding: 15px;*/
  border-image: url('<?= base_url() ?>./../assets/border-biru.png') 30 stretch;
/*  border-image-width: 40px;*/
}


.borderimg-merah { 
  border: 10px solid transparent;
/*  padding: 15px;*/
  border-image: url('<?= base_url() ?>./../assets/border-merah.png') 30 round;
/*  border-image-width: 40px;*/
}
.borderimg-merah-stretch { 
  border: 10px solid transparent;
/*  padding: 15px;*/
  border-image: url('<?= base_url() ?>./../assets/border-merah.png') 30 stretch;
/*  border-image-width: 40px;*/
}

h3, h2{
	font-weight: 600;
}

<?php

$e_nilai= [
0=> 'Tidak Ada Nilai',
1=> 'Tidak Muncul',
2=> 'Muncul'];

 ?>

        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        	img{
		object-fit: contain;
	}
        #title {
            font-size: 40px;
            font-weight: bold;
            margin: 20px 0;
            transition: all 0.3s ease-in-out; /* Efek perubahan font */
        }
        .select-container {
            width: 300px;
            margin: auto;
        }
        /* Custom styling untuk select2 */
        .select2-container--default .select2-selection--single {
            font-size: 18px;
            height: 40px;
            display: flex;
            align-items: center;
        }
    
</style>
<body id="body1">
	<div class="container">
		<div class="col-md-12">
			<div class="form-group">
				<h3>Cetak Rapor CP Tanpa Foto dan Watermark </h3> <br>

				<?php if ($data_siswa->account_type==1) {?>
				<div class="col-md-12">
					<button onclick="hijau_1()" class="btn btn-success">Border Hijau 1</button>
					<button onclick="hijau_2()" class="btn btn-success">Border Hijau 2</button>

					<button onclick="biru_1()" class="btn btn-primary">Border Biru 1</button>
					<button onclick="biru_2()" class="btn btn-primary">Border Biru 2</button>

					<button onclick="merah_1()" class="btn btn-danger">Border Merah 1</button>
					<button onclick="merah_2()" class="btn btn-danger">Border Merah 2</button>

					<hr>
					<div class="form-group">
						 <div class="select-container" style="width:100%">
			        <label><h4>Pilih Font:</h4></label>
			        <select class="form-control" id="fontSelector">
			            <option value="Arial, sans-serif" style="font-family: Arial;">Arial</option>
			            <option value="'Comic Sans MS', cursive" style="font-family: 'Comic Sans MS';">Comic Sans</option>
			            <option value="'Courier New', monospace" style="font-family: 'Courier New';">Courier New</option>
			            <option value="'Georgia', serif" style="font-family: Georgia;">Georgia</option>
			            <option value="'Impact', sans-serif" style="font-family: Impact;">Impact</option>
			            <option value="'Times New Roman', serif" style="font-family: 'Times New Roman';">Times New Roman</option>
			            <option value="'Verdana', sans-serif" style="font-family: Verdana;">Verdana</option>
			            <option value="'Fantasy'" style="font-family: Fantasy;">Fantasy</option>
			            <option value="'Cursive'" style="font-family: Cursive;">Cursive</option>
			        </select>
			    </div>
					</div>
				</div>
				<?php }; ?>


				<!-- <button onclick="cetak(0)" class="btn btn-primary btn-sm">Cetak Ukuran Kecil</button> -->
				<!-- <button onclick="cetak(1)" class="btn btn-primary btn-sm">Cetak Ukuran Sedang</button> -->
				<button onclick="cetak()" class="btn btn-warning">Cetak</button>

				
				<script>
					function hijau_1(argument) {
  					document.getElementById("body-border").className = "";
  					document.getElementById("body-border").className="borderimg-hijau-stretch";
  					
  					



  					document.getElementById("border-elemen1").className ="";
  					document.getElementById("border-elemen1").className="borderimg-hijau-stretch";
  					document.getElementById("border-elemen2").className ="";
  					document.getElementById("border-elemen2").className="borderimg-hijau-stretch";
  					document.getElementById("border-elemen3").className ="";
  					document.getElementById("border-elemen3").className="borderimg-hijau-stretch";


  					document.getElementById("border-ppp").className ="";
  					document.getElementById("border-ppp").className="borderimg-hijau-stretch";
				};
				function hijau_2(argument) {

						document.getElementById("body-border").className = "";
  					document.getElementById("body-border").className="borderimg-hijau";


  					document.getElementById("border-elemen1").className ="";
  					document.getElementById("border-elemen1").className="borderimg-hijau";
  					document.getElementById("border-elemen2").className ="";
  					document.getElementById("border-elemen2").className="borderimg-hijau";
  					document.getElementById("border-elemen3").className ="";
  					document.getElementById("border-elemen3").className="borderimg-hijau";


  					// document.getElementById("border-head").className ="";
  					document.getElementById("border-ppp").className ="";
  					// document.getElementById("body-head").className="borderimg-hijau";
  					document.getElementById("border-ppp").className="borderimg-hijau";
				};

				function biru_1(argument) {
  					document.getElementById("body-border").className = "";
  					document.getElementById("body-border").className="borderimg-biru-stretch";


  					document.getElementById("border-elemen1").className ="";
  					document.getElementById("border-elemen1").className="borderimg-biru-stretch";
  					document.getElementById("border-elemen2").className ="";
  					document.getElementById("border-elemen2").className="borderimg-biru-stretch";
  					document.getElementById("border-elemen3").className ="";
  					document.getElementById("border-elemen3").className="borderimg-biru-stretch";

  					
  					document.getElementById("border-ppp").className ="";
  					document.getElementById("border-ppp").className="borderimg-biru-stretch";
				};
				function biru_2(argument) {
						document.getElementById("body-border").className = "";
  					document.getElementById("body-border").className="borderimg-biru";

  					document.getElementById("border-elemen1").className ="";
  					document.getElementById("border-elemen1").className="borderimg-biru";
  					document.getElementById("border-elemen2").className ="";
  					document.getElementById("border-elemen2").className="borderimg-biru";
  					document.getElementById("border-elemen3").className ="";
  					document.getElementById("border-elemen3").className="borderimg-biru";


  					
  					document.getElementById("border-ppp").className ="";
  					document.getElementById("border-ppp").className="borderimg-biru";
				};

				function merah_1(argument) {
  					document.getElementById("body-border").className = "";
  					document.getElementById("body-border").className="borderimg-merah-stretch";

  					document.getElementById("border-elemen1").className ="";
  					document.getElementById("border-elemen1").className="borderimg-merah-stretch";
  					document.getElementById("border-elemen2").className ="";
  					document.getElementById("border-elemen2").className="borderimg-merah-stretch";
  					document.getElementById("border-elemen3").className ="";
  					document.getElementById("border-elemen3").className="borderimg-merah-stretch";


  					
  					document.getElementById("border-ppp").className ="";
  					document.getElementById("border-ppp").className="borderimg-merah-stretch";
				};
				function merah_2(argument) {
						document.getElementById("body-border").className = "";
  					document.getElementById("body-border").className="borderimg-merah";

  					document.getElementById("border-elemen1").className ="";
  					document.getElementById("border-elemen1").className="borderimg-merah";
  					document.getElementById("border-elemen2").className ="";
  					document.getElementById("border-elemen2").className="borderimg-merah";
  					document.getElementById("border-elemen3").className ="";
  					document.getElementById("border-elemen3").className="borderimg-merah";

  					document.getElementById("border-ppp").className ="";
  					document.getElementById("border-ppp").className="borderimg-merah";
				};


					function cetak(cek) {
						// document.getElementById("body1").setAttribute("style","font-size:large");
							window.print();
						
					}



				</script>
			</div>
		</div>
	</div>
	<div class="container bg-white sectiontoprint" id="sectiontoprint">
		<div class="body-border " id="body-border" style="width:100%">
			<!-- <img src="<?= base_url($data_siswa->logo) ?>" class=""> -->
			<div class="col-md-12 img-watermarked" style="font-size:large; padding: 30px;">

					<center>
						<h2>
							LAPORAN CAPAIAN PERKEMBANGAN ANAK
							<br>
							TAHUN PELAJARAN <?= strtoupper($data_siswa->tahun) ?>
						</h2>

						<!-- <h1 class="title">Judul Seru!</h1> -->



					</center>
					<br>
					<br>
			<div class="col-md-12 row">
				<table class="text-left">
						<tr>
							<?php if($data_siswa->foto_siswa !=null): ?>
							<td rowspan="4"><img style="padding:5px" height="150" width="150" src="<?= base_url($data_siswa->foto_siswa) ?>"></td>
						<?php endif; ?>
							<td width="200">Nama Lengkap</td>
							<td><?= $data_siswa->nama_lengkap ?></td>
						</tr>
						<tr>
							<!-- <td></td> -->
							<td>Nomor Induk</td>
							<td><?= $data_siswa->no_induk ?></td>
						</tr>
						<tr>
							<!-- <td></td> -->
							<td>Kelompok Kelas</td>
							<td><?= $data_siswa->nama_kelas ?></td>
						</tr>
						<tr>
							<!-- <td></td> -->
							<td>Semester</td>
							<td><?= $semester= ($data_siswa->semester=='1') ? 'Ganjil' : 'Genap' ; ?></td>
						</tr>
					</table>
			</div>

			<div class="">
				
			
			<?php

			$i=1;

			 foreach($elemen_sekolah as $key):?>
					<br>
					
					<br>
					<center id="border-elemen<?= $i++ ?>" class= ""><h3 class="title"><?= $key->elemen_data ?></h3></center>
					<br>
          <?php 

          	$text_muncul=$data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_muncul_rapor.' ';
							foreach ($cp_belajar as $ky => $value) :
                if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai== 2) :
                	$text_muncul .= $value->kegiatan.'. ';
                                
              endif;
            endforeach;
                    
          ?>
        	<span>
        		<!-- <div class="images">
        			<img style="padding: 10px; padding-bottom: 0px !important;" width="200" src="<?= base_url() ?><?= $key->foto; ?>">
						</div> -->
						<div class="text"><?= $text_muncul ?></div>        		
        	</span>
					<?php 
					 $text_tidak_muncul=$data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_rapor.' ';

            foreach ($cp_belajar as $ky => $value) :
              if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai== 1) :
                $text_tidak_muncul .= $value->kegiatan.'. ';
                                
              endif;
            endforeach;
                 	
            ?>

           <div class="text"><?= $text_tidak_muncul ?></div>

      <?php endforeach; ?>

      		<br>
					<center id="border-ppp" class=""><h3 class="title">KOKURIKULER</h3></center>
					<br>
					<div class="images">
        		<img style="padding: 10px; padding-bottom: 0px !important; height: 200px !important; width:200px !important;"  src="<?= base_url() ?><?= $data_siswa->foto_profile_pancasila ?>">
					</div>
					<div class="text"><?= $data_siswa->profil_pancasila ?></div>  

					<br>
					<br>
					<br>
					<br>
			</div>


			
		</div>
		</div>
		
	</div>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
    	
					 $(document).ready(function() {
            // Inisialisasi Select2 pada dropdown
            $('#fontSelector').select2();

            // Mengubah font berdasarkan pilihan Select2
            $('#fontSelector').on('change', function() {
                $('.sectiontoprint').css('font-family', $(this).val());
            });
        });
    </script>
<!-- <script src="<?php echo base_url(); ?>./../assets/custom/js/jquery.min.js" type="text/javascript"></script> -->