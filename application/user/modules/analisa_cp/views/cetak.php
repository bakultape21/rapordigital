<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ceklist Analisa Capaian</title>
	<link href="<?php echo base_url(); ?>./../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

</head>
<style type="text/css">

	@media print {
		{page-break-inside: avoid;page-break-before:auto}

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
				<h3>Checklist Analisa Capaian </h3> <br>
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
					<h1>Ceklist Analisa Capaian</h1>
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
						<td width="33%">Tanggal: <?= $_POST['awal'] ?> Sampai <?= $_POST['akhir'] ?></td>
						<td width="33%"></td>
						<td width="33%">Semester: <?= $semester[$guru_sekolah->semester] ?></td>
					</tr>
				</table>
			</div>

			<div class="table-responsive">
				<table class="table table-border" >
				
						<tr>
							<th colspan="2">Capaian Pembelajaran</th>
							<th>Kemunculan</th>
							<th>Tempat Pelaksanaan</th>
							<th>Tujuan Pembelajaran</th>
						</tr>
						<?php $i=0; foreach ($kegiatan_belajar as $key => $value) : ?>
							<tr>
								<td>
									<?= $value->cp_nomor ?>
								</td>
								<td width="25%">
									<?= $value->capaian_belajar; ?>
								</td>
								<td width="25%" class="text-center">
									<?= $ceklist[$value->kegiatan_nilai]; ?>
								</td>
								<?php if($i==0){ ?>
								<td width="25%">
									Kelas dan Lingkungan Lain
								</td>
							<?php }else{ ?>
								<td style="border: none;" width="25%"></td>
							<?php } ?>
								<td width="25%">
									<?= $value->kegiatan_belajar; ?>
								</td>
							</tr>
						<?php $i++; endforeach; ?>
				
				
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