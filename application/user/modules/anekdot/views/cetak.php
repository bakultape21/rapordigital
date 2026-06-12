<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laporan Catatan Anekdot</title>
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

<?php
$semester=
[1=> "Ganjil", 2=> "Genap"];

$ceklist=[
0=> '',
1=> 'X',
2=> '<input type="checkbox" checked >'];
 ?>
</style>
<body id="body1">
	<div class="container">
		<div class="col-md-12">
			<div class="form-group">
				<h3>Catatan Anekdot </h3> <br>
				<button onclick="cetak(0)" class="btn btn-primary btn-sm">Cetak Kecil</button>
				<button onclick="cetak(1)" class="btn btn-primary btn-sm">Cetak Sedang</button>
				<button onclick="cetak(2)" class="btn btn-primary btn-sm">Cetak Besar</button>

				<script>
					function cetak(cek) {
						if (cek==0) {
							document.getElementById("body1").setAttribute("style","font-size:small");
							window.print();
						}
						if (cek==1) {
								document.getElementById("body1").setAttribute("style","font-size:medium");
							window.print();
						}
						if (cek==2) {
								document.getElementById("body1").setAttribute("style","font-size:large");
							window.print();
						}
					}
				</script>
			</div>
		</div>
	</div>
	<div class="container bg-white sectiontoprint" id="sectiontoprint">
		<div class="col-md-12">
			<h3>
				<br>
			</h3>

			<div class="col-md-12 text-center">
					<h1>CATATAN ANEKDOT DAN ANALISIS CAPAIAN</h1>
					<h2><?= $guru_sekolah->sekolah_nama ?></h2>

			</div>

			<div class="table-responsive">
				<table class="table text-center" style="border:none;" >
					<tr>
						<td width="33%">Nama Siswa: <?= $siswa->nama_lengkap ?></td>
						<td width="33%"></td>
						<td width="33%">Kelompok: <?= $guru_sekolah->nama_kelas ?></td>
					</tr>
					<tr>
						<?php
						$date1 = new DateTime(date('Y-m-d'));
						$date2 = new DateTime(date('Y-m-d', strtotime($siswa->tanggal_lahir)));
						$interval = $date1->diff($date2);


						 ?>
						<td width="33%">Usia: <?= $interval->y;  ?> Tahun</td>
						<td width="33%"></td>
						<td width="33%">Wali Kelas: <?= $guru_sekolah->guru_nama ?></td>
					</tr>
					<tr>
						<td width="33%">Tanggal: <?= $catatan_anekdot[0]->tanggal ?></td>
						<td width="33%"></td>
						<td width="33%">Semester: <?= $semester[$guru_sekolah->semester] ?></td>
					</tr>
				</table>
			</div>

			<div class="table-responsive">
				<table class="table table-border" >
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Kejadian</th>
							<th>Capaian Belajar</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($catatan_anekdot as $key => $value) : ?>
							<tr>
								<td width="25%">
									<?= $value->tanggal ?>
								</td>
								<td width="25%" class="text-center">
									<?= $value->ca_kejadian ?>
								</td>
								<td width="25%">
									<?php foreach ($elemen as $ky => $val) : ?>

									<strong><?= $val->elemen_data ?></strong><br>
									<?php foreach ($cp_belajar as $k => $v) {

										 if ($v->elemen_data_id== $val->elemen_data_id) { ?>

										 	<li><?= $v->capaian_belajar; ?></li>
										 

										 <?php } 

										} ?>
									
									<?php endforeach; ?>


									<br>

									<strong>Umpan Balik</strong>: <?= $value->ca_umpan_balik ?>
								</td>
								<td>
									<?= $value->ca_keterangan; ?>
								</td>
							</tr>
						<?php $i++; endforeach; ?>
					</tbody>
				
				</table>
			</div>
			<hr>
			<br>
			<div class="table-responsive">
				<table class="table text-center" style="border:none;" >
					<tr>
						<td width="33%"></td>
						<td width="33%"></td>
						<td width="33%">Semester <?= $semester[$guru_sekolah->semester] ?></td>
					</tr>
					<tr>
						<td width="33%"><?= $guru_sekolah->sekolah_nama ?></td>
						<td width="33%"></td>
						<td width="33%"><?= $guru_sekolah->kabupaten ?>, <?= tgl_indo(date('Y-m-d')) ?></td>
					</tr>
					<tr>
						<td width="33%">Kepala Sekolah</td>
						<td width="33%"></td>
						<td width="33%">Guru</td>
					</tr>
					<tr>
						<td width="33%"></td>
						<td width="33%"></td>
						<td width="33%"></td>
					</tr>
					<tr>
						<td width="33%" class="text-center"><?= $guru_sekolah->kepala_sekolah; ?><br>(<?= $guru_sekolah->kepala_sekolah_nip ?>)</td>
						<td width="33%"></td>
						<td width="33%" class="text-center"><?= $guru_sekolah->guru_nama ?><br>(<?= $guru_sekolah->nip ?>)</td>
					</tr>
				</table>
			</div>
			
		</div>
	</div>

</body>
</html>
<script type="text/javascript">

</script>