<?php if (@$data_siswa== null) {
	exit();
} ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Peserta Didik</title>
	<link href="<?php echo base_url(); ?>./../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

</head>
<style type="text/css">
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
  td{
  	border: none !important;
  }
}
<?php 

$agama=[
1=>'Islam',
2=>'Kristen',
3=>'Protestan',
4=>'Hindu',
5=>'Khong Hucu',


];

?>

</style>
<body>
	<div class="container">
		<div class="col-md-12">
			<div class="form-group">
				<h3>Keterangan Peserta Didik </h3> <br>
				<button onclick="window.print()" class="btn btn-primary btn-sm">Cetak</button>
			</div>
		</div>
	</div>
	<div class="container bg-white sectiontoprint" id="sectiontoprint">
		<div class="col-md-12">
			<br>
			<br>
			<center>
				<h3>
					KETERANGAN TENTANG PESERTA DIDIK<br>
				</h3>
			</center>
			<br>
			<br>
			<br>
			<br>
			<div class="col-md-7">
				<table class="table" style="border: none !important">
				
					<tr>
						<td>1. Nama Peserta Didik :</td>
						<td></td>
					</tr>
					<tr>
						<td> <li>Nama Lengkap</li></td>
						<td><?= strtoupper($data_siswa->nama_lengkap) ?></td>
					</tr>
					<tr>
						<td> <li>Nama Panggilan</li></td>
						<td><?= strtoupper($data_siswa->nama_panggilan) ?></td>
					</tr>
					<tr>
						<td>2. Nomor Induk</td>
						<td><?= strtoupper($data_siswa->no_induk) ?></td>
					</tr>
					<tr>
						<td>3. Tempat, Tanggal Lahir</td>
						<td><?= strtoupper($data_siswa->tempat_lahir).', '.tgl_indo($data_siswa->tanggal_lahir) ?></td>
					</tr>
					<tr>
						<td>4. Jenis Kelamin</td>
						<td><?= strtoupper($data_siswa->jenis_kelamin) ?></td>
					</tr>
					<tr>
						<td>5. Agama</td>
						<td><?= $agama[$data_siswa->agama] ?></td>
					</tr>
					<tr>
						<td>6. Alamat Rumah</td>
						<td><?= $data_siswa->alamat ?></td>
					</tr>
					<tr>
						<td>7. Orang Tua</td>
						<td></td>
					</tr>
					<tr>
						<td> <li>Ayah</li></td>
						<td><?= strtoupper($data_siswa->nama_ayah) ?></td>
					</tr>
					<tr>
						<td> <li>Ibu</li></td>
						<td><?= strtoupper($data_siswa->nama_ibu) ?></td>
					</tr>
					<tr>
						<td>8. Pekerjaan Orang Tua</td>
						<td></td>
					</tr>
					<tr>
						<td> <li>Ayah</li></td>
						<td><?= strtoupper($data_siswa->pekerjaan_ayah) ?></td>
					</tr>
					<tr>
						<td> <li>Ibu</li></td>
						<td><?= strtoupper($data_siswa->pekerjaan_ibu) ?></td>
					</tr>
				</table>
			</div>
			<div class="col-md-12">
				<table class="table" style="border: none !important">
				
					<tr>
						<td width="25%"></td>
						<td width="25%"></td>
						<td width="25%"><img class="w-100" src="<?= base_url().$data_siswa->foto_siswa ?>"></td>
						<td width="25%" class="text-center">
							<?= $data_siswa->kabupaten.', '.tgl_indo($data_siswa->tanggal_raport_cetak) ?>
							<br>
							<br>
							Guru<br>
							<br>
							<br>
							<br>
							<br>
							<strong><?= $data_siswa->guru_nama ?></strong><br>
							Nip. <?= $data_siswa->nip ?>
						</td>
					</tr>
				</table>
			</div>

	
			

			
			
		</div>
	</div>

</body>
</html>
<script type="text/javascript">

</script>