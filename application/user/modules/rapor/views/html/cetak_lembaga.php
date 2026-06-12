<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak </title>
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

        .text-bold{
        	font-weight: 600;
        }

        td{
        	border-top: none !important;
        }
    
</style>
<body id="body1">
	<div class="container">
		<div class="col-md-12">
			<div class="form-group">
				<h3>Cetak Data Lembaga Dan Siswa </h3> <br>
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
			<?php } ?>


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
						document.getElementById("body1").setAttribute("style","font-size:large");
							window.print();
						
					}



				</script>
			</div>
		</div>
	</div>

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
 ?>
	<div class="container bg-white sectiontoprint" id="sectiontoprint">
		<div class="body-border " id="body-border" style="width:100%">
			<!-- <img src="<?= base_url($data_siswa->logo) ?>" class=""> -->
			<div class="col-md-12 img-watermarked" style="font-size:large; padding: 30px;">

					<center>
						<h2>
							DATA LEMBAGA
							
						</h2>
						<h3>
							<?= $data_siswa->sekolah_nama; ?>
						</h3>

					</center>
					<div class="col-md-12 row">
						<table class="table text-left" style="margin-top: 100px;">
								<tr class="text">
									<td>1.</td>
									<td>Nama Lembaga </td>
									<td colspan="2">: <?= $data_siswa->sekolah_nama ?></td>
								</tr>
								<tr class="text">
									<td>2.</td>
									<td>NPSN</td>
									<td colspan="2">: <?= $data_siswa->npsn ?></td>
								</tr>
								<tr class="text">
									<td>3. </td>
									<td>Akreditasi</td>
									<td colspan="2">: <?= $data_siswa->akreditasi ?></td>
								</tr>

								<tr class="text">
									<td>4.</td>
									<td>SK Pendirian</td>
									<td colspan="2">: <?= $data_siswa->sk ?></td>
								</tr>
								<tr class="text">
									<td>5.</td>
									<td>Yayasan</td>
									<td colspan="2">: <?= $data_siswa->yayasan ?></td>
								</tr>
								<tr class="text">
									<td>6.</td>
									<td>Alamat Sekolah</td>
									<td colspan="2">: <?= $data_siswa->alamat_sekolah ?></td>
								</tr>
								<tr class="text">
									<td>7.</td>
									<td>Kabupaten</td>
									<td colspan="2">: <?= $data_siswa->kabupaten ?></td>
								</tr>
								<tr class="text">
									<td>8.</td>
									<td>Provinsi</td>
									<td colspan="2">: <?= $data_siswa->provinsi ?></td>
								</tr>
						</table>

						<table class="table" style="margin-top: 150px;">
							<tr class="text-bold">
								<td>Nama Anak Didik :</td>
							</tr>
							<tr class="text-center">
								<td><?= $data_siswa->nama_lengkap ?></td>
							</tr>
							<tr class="text-bold">
								<td>Nomor Induk</td>
							</tr>
							<tr class="text-center">
								<td><?= $data_siswa->no_induk ?></td>
							</tr>
							<tr class="text-bold">
								<td>NISN</td>
							</tr>
							<tr class="text-center">
								<td><?= $data_siswa->nisn ?></td>
							</tr>

						</table>

						<table class="table" style="margin-top:250px">
							<tr class="text-bold">
								<td><h3><?= $data_siswa->yayasan ?></h3></td>
							</tr>
							<!-- <tr class="text-bold">
								<td><?= $data_siswa->sekolah_nama ?></td>
							</tr> -->
							<tr class="text-center" >
								<td><h3 style="font-weight: 300;"><?= $data_siswa->alamat_sekolah ?></h3></td>
							</tr>
							<tr class="text-bold">
								<td><h3><?= $data_siswa->dinas_penaung ?></h3></td>
							</tr>

							<?php

							$kabupaten='';
	         		if (substr($data_siswa->kabupaten, 0 ,4) != 'KOTA') {
	         			$kabupaten='KABUPATEN ';
	         		}
							 ?>
							<tr class="text-bold">
								<td><h3><?= $kabupaten.$data_siswa->kabupaten ?></h3></td>
							</tr>

						</table>
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