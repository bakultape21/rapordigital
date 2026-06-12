<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Laporan</title>
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
}


</style>
<body>
	<div class="container">
		<div class="col-md-12">
			<div class="form-group">
				<h3>Rapor Hasil Belajar </h3> <br>
				<button onclick="window.print()" class="btn btn-primary btn-sm">Cetak</button>
			</div>
		</div>
	</div>
	<div class="container bg-white sectiontoprint" id="sectiontoprint">
		<div class="col-md-12">
			<center>
				<h3>
					LAPORAN CAPAIAN PERKEMBANGAN ANAK <br>
				</h3>
			</center>
			<center>
				<h3>
					TAHUN PELAJARAN : <br>
				</h3>
			</center>
			<center>
				<h3>
					<?= $data_siswa->tahun; ?> <br>
				</h3>
			</center>
			<div class="col-md-7">
				<table class="table" style="border: none !important">
				
					<tr>
						<td>Nama Peserta Didik :</td>
						<td><?= strtoupper($data_siswa->nama_lengkap) ?></td>
						<td></td>
					</tr>
					<tr>
						<td>Nomor Induk :</td>
						<td><?= strtoupper($data_siswa->no_induk) ?></td>
						<td></td>
					</tr>
					<tr>
						<td>Kelompok Kelas :</td>
						<td><?= strtoupper($data_siswa->nama_kelas) ?></td>
						<td></td>
					</tr>
					<tr>
						<td>Semester :</td>
						<td><?= ($data_siswa->semester=='1') ? 'Ganjil' : 'Genap' ; ?></td>
						<td></td>
					</tr>
				</table>
			</div>
			<br>

			<?php foreach($elemen_sekolah as $key): ?>
			<div class="col-md-12">
				<center>
					<h4><?= $key->elemen_data ?></h4>
				</center>
				<br>
				<?= $data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_muncul_rapor ?>

				<?php foreach ($cp_belajar as $ky => $value) :
							if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai== 2) : ?>
					
					<li><?= $value->capaian_belajar ?></li>
				<?php
				endif;
				 endforeach ?>

				 <br>

				 	<?= $data_siswa->kalimat_depan_rapor.' '.$data_siswa->nama_lengkap.' '.$data_siswa->kalimat_setelah_nama_rapor ?>

				<?php foreach ($cp_belajar as $ky => $value) :
							if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai== 1) : ?>
					
					<li><?= $value->capaian_belajar ?></li>
				<?php
				endif;
				 endforeach ?>
				<br>
			</div>
			<?php endforeach; ?>
	
			

			
			
		</div>
	</div>

</body>
</html>
<script type="text/javascript">

</script>