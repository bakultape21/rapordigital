<?php if (@$data_siswa== null) {
	echo "Data Jasmani Belum Dimasukan";
	exit();
} ?>

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
				<h3>Rapor Nilai Ekstra & Absensi </h3> <br>
				<button onclick="window.print()" class="btn btn-primary btn-sm">Cetak</button>
			</div>
		</div>
	</div>
	<div class="container bg-white sectiontoprint" id="sectiontoprint">
		<div class="col-md-12">
			<center>
				<h3>
					PERKEMBANGAN JASMANI DAN PERKEMBANGAN ANAK<br>
				</h3>
			</center>
			
			<div class="col-md-12">
				<table class="table table-bordered tabel-center text-center" style="border: none !important">
					<tr>
						<th colspan="4">NAMA SISWA: <?= strtoupper($data_siswa->nama_lengkap) ?></th>
					</tr>
					<tr>
						<td>No.</td>
						<td>Keadaan Jasmani dan Kesehatan anak</td>
						<td colspan="2">Keterangan</td>
					</tr>
					<tr>
						<td>1</td>
						<td>Mata/Pengelihatan</td>
						<td colspan="2"><?= $data_siswa->mata_pengelihatan ?></td>
					</tr>
					<tr>
						<td>2</td>
						<td>Hidung/Penciuman</td>
						<td colspan="2"><?= $data_siswa->hidung_penciuman; ?></td>
					</tr>
					<tr>
						<td>3</td>
						<td>Telinga/Pendengaran</td>
						<td colspan="2"><?= $data_siswa->telinga_pendengaran; ?></td>
					</tr>
					<tr>
						<td>4</td>
						<td>Mulut</td>
						<td colspan="2"><?= $data_siswa->mulut; ?></td>
					</tr>
					<tr>
						<td>5</td>
						<td>Gigi</td>
						<td colspan="2"><?= $data_siswa->gigi; ?></td>
					</tr>
					<tr>
						<td>6</td>
						<td>Angggota Badan</td>
						<td colspan="2"><?= $data_siswa->anggota_badan; ?></td>
					</tr>
					<tr>
						<td>7</td>
						<td>Kulit</td>
						<td colspan="2"><?= $data_siswa->kulit; ?></td>
					</tr>
					<tr>
						<td>8</td>
						<td>Kebersihan</td>
						<td colspan="2"><?= $data_siswa->kebersihan; ?></td>
					</tr>
					<tr>
						<td>9</td>
						<td>Berat Badan</td>
						<td> Awal=<?= $data_siswa->bb_awal; ?> Kg</td>
						<td> Akhir=<?= $data_siswa->bb_akhir; ?> Kg</td>
					</tr>
					<tr>
						<td>10</td>
						<td>Tinggi Badan</td>
						<td> Awal=<?= $data_siswa->tb_awal; ?> Cm</td>
						<td> Akhir=<?= $data_siswa->tb_akhir; ?> Cm</td>
					</tr>
					<tr>
						<td>11</td>
						<td>Lingkar Kepala</td>
						<td> Awal=<?= $data_siswa->lk_awal; ?> Cm</td>
						<td> Akhir=<?= $data_siswa->lk_akhir; ?> Cm</td>
					</tr>
					<tr>
						<td>12</td>
						<td>Lingkar Lengan</td>
						<td> Awal=<?= $data_siswa->ll_awal; ?> Cm</td>
						<td> Akhir=<?= $data_siswa->ll_akhir; ?> Cm</td>
					</tr>
					<tr>
						<td>13</td>
						<td>Riwayat Penyakit</td>
						<td colspan="2"><?= $data_siswa->riwayat_penyakit; ?></td>
					</tr>
					<tr>
						<td>14</td>
						<td>Pemberian Kapsul Vitamin</td>
						<td colspan="2"><?= $data_siswa->kapsul_vitamin; ?></td>
					</tr>
					<tr>
						<td>15</td>
						<td>Imunisasi</td>
						<td colspan="2"><?= $data_siswa->imunisasi; ?></td>
					</tr>
					<tr>
						<th colspan="4">NILAI EKSTRA</th>
					</tr>
					<tr>
						<td>No</td>
						<td>Jenis Kegiatan</td>
						<td colspan="2">Deskripsi</td>
					</tr>

					<?php $i=1; foreach ($nilai_ekstra as $key): ?>
					<tr>
						<td><?= $i; ?></td>
						<td><?= $key->nilai_ekstra_kegiatan ?></td>
						<td colspan="2"><?= $key->nilai_ekstra; ?></td>
					</tr>
				<?php $i++; endforeach; ?>
					<tr>
						<th colspan="4">ABSENSI</th>
					</tr>
					<tr>
						<td>1</td>
						<td>Sakit</td>
						<td colspan="2"><?= $data_siswa->absensi_sakit ?></td>
					</tr>
					<tr>
						<td>2</td>
						<td>Izin</td>
						<td colspan="2"><?= $data_siswa->absensi_izin ?></td>
					</tr>
					<tr>
						<td>3</td>
						<td>Tanpa Keterangan</td>
						<td colspan="2"><?= $data_siswa->absensi_tanpa_keterangan ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<br>
							Mengetahui<br>
							Kepala Sekolah<br>
							<br>
							<br>
							<br>
							<br>
							<strong><?= $data_siswa->kepala_sekolah ?></strong><br>
							Nip. <?= $data_siswa->kepala_sekolah_nip ?>
						</td>
						<td colspan="2">
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
					<tr>
						<td colspan="4" class="text-left">Komentar Orangtua .................<br></td>
					</tr>
					<tr>
						<td colspan="3" style="border: none !important;"></td>
						<td>
							<?= $data_siswa->kabupaten.', '.date($data_siswa->tanggal_raport_pengembalian) ?><br>
							Orang Tua/wali
							<br>
							<br>
							<br>
							<br>
							(.......................)
						</td>
						
					</tr>




				</table>
			</div>
			<br>

	
			

			
			
		</div>
	</div>

</body>
</html>
<script type="text/javascript">

</script>