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

<?php

$e_nilai= [
0=> '-',
1=> 'Tidak Muncul',
2=> 'Muncul'];

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
				Data Mingguan <br>
			</h3>


			Informasi Rekap Mingguan Pada Bulan <?= date('m', strtotime($_POST['awal'])) ?> Minggu ke-<?= $_POST['minggu']?> <br>
			Pengamatan Dari Tanggal <?= tgl_indo($_POST['awal']) ?> sampai Tanggal <?= tgl_indo($_POST['akhir']) ?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Elemen</th>
						<?php foreach ($elemen as $key => $value) :?>
						<th><?= $value->elemen_data ?></th>
						<?php endforeach ?>
					</tr>
					 <tr>
						<th>CP:</th>
						<?php foreach ($cp_belajar as $key => $value) :?>
							<th><?= $value->cp_belajar_tp ?></th>
							
						<?php endforeach ?>
					</tr>
					
					<tr>
						<th>Kegiatan:</th>
						<?php foreach ($kegiatan_belajar as $key => $value) :?>
							<th><?= $value->kegiatan_belajar_nilai ?></th>
						<?php endforeach ?>
					</tr>
					
					<tr>
						<th>Nilai</th>
						<?php foreach ($cp_belajar as $key => $value) :?>
							<th>Nilai/Capaian Anak</th>
						<?php endforeach ?>
					</tr> 
				</thead>
				<tbody>
					<?php foreach($siswa as $key): ?>
						<tr>
							<td><?= $key->nama_lengkap ?></td>
							<?php foreach ($elemen as $kay => $val) :?>
							<td>
								<?php foreach ($nilai as $ky => $v) :
									if ($v->elemen_data_id== $val->elemen_data_id && $v->siswa_kelas_id== $key->siswa_kelas_id) {
										echo $e_nilai[$v->nilai];
									}
								endforeach; ?>

							</td>
							<?php endforeach ?>
						</tr>

					<?php endforeach; ?> 
				</tbody>
			</table>
			<div class="table-responsive">
				<table class="table text-center" style="border:none;" >
					<tr>
						<td width="33%"></td>
						<td width="33%"></td>
						<td width="33%">Semester <?=  ($guru_sekolah->semester=='1') ? 'Ganjil' : 'Genap' ; ?></td>
					</tr>
					<tr>
						<td width="33%"><?= $guru_sekolah->sekolah_nama ?></td>
						<td width="33%"></td>
						<td width="33%"><?= $guru_sekolah->kabupaten.', '.tgl_indo(date('Y-m-d')) ?></td>
					</tr>
					<tr>
						<td width="33%">Kepala Sekolah</td>
						<td width="33%"></td>
						<td width="33%">Guru</td>
					</tr>
					<tr>
						<td width="33%"><br></td>
						<td width="33%"><br></td>
						<td width="33%"><br></td>
					</tr>
					<tr>
						<td width="33%"><?= $guru_sekolah->kepala_sekolah ?><br>(NIP <?= $guru_sekolah->kepala_sekolah_nip ?>)</td>
						<td width="33%"></td>
						<td width="33%"><?= $guru_sekolah->guru_nama ?><br>(NIP <?= $guru_sekolah->nip ?>)</td>
					</tr>
				</table>
			</div>
			
		</div>
	</div>

</body>
</html>
<script type="text/javascript">

</script>