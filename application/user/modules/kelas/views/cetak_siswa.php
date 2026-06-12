<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Daftar Siswa</title>
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
				<h3>Data Siswa Kelas </h3> <br>
				<button onclick="window.print()" class="btn btn-primary btn-sm">Cetak</button>
			</div>
		</div>
	</div>
	<div class="container sectiontoprint" id="sectiontoprint">
		<div class="col-md-12">
			<h3>
				Data Siswa Kelas <br>
			</h3>
			Nama Kelas : <?= $guru_sekolah->nama_kelas ?><br>
			Tahun/Semester: <?= $guru_sekolah->tahun ?>/<?= ($guru_sekolah->semester==1) ? 'Ganjil' : 'Genap' ; ?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>No Induk</th>
						<th>Nama Lengkap</th>
						<th>TTL</th>
						<th class="text-center">Foto</th>
				</thead>
				<tbody>
					<?php $i=1; foreach ($siswa as $key => $value) : ?>
						<tr>
							<td><?= $i; ?></td>
							<td><?= $value->no_induk ?></td>
							<td><?= $value->nama_lengkap ?></td>
							<td><?= $value->tempat_lahir.','.date('d M Y', strtotime($value->tanggal_lahir)) ?></td>
							<td class="text-center">
								<?php if ($value->foto_siswa!= null) :  ?>
								<img src="<?= base_url().$value->foto_siswa; ?>" style="width: 100px;">
								<?php else: ?>
								<img src="<?= base_url() ?>../assets/admin/user.jpg" style="width: 100px;">
							<?php endif; ?>
							</td>
						</tr>
					<?php $i++; endforeach; ?>
				</tbody>
			</table>
			<div class="table-responsive">
				<table class="table text-center" style="border:none;" >
					<tr>
						<td width="33%"></td>
						<td width="33%"></td>
						<td width="33%">Semester <?= ($guru_sekolah->semester==1) ? 'Ganjil' : 'Genap' ; ?></td>
					</tr>
					<tr>
						<td width="33%"><?= $guru_sekolah->sekolah_nama ?></td>
						<td width="33%"></td>
						<td width="33%"><?= $guru_sekolah->kabupaten.', '.date('d-m-Y') ?></td>
					</tr>
					<tr>
						<td width="33%">Kepala Sekolah</td>
						<td width="33%"></td>
						<td width="33%">Wali Kelas</td>
					</tr>
					<tr>
						<td width="33%"></td>
						<td width="33%"></td>
						<td width="33%"></td>
					</tr>
					<tr>
						<td width="33%"><?= $guru_sekolah->kepala_sekolah; ?></td>
						<td width="33%"></td>
						<td width="33%"><?= $guru_sekolah->guru_nama ?></td>
					</tr>
				</table>
			</div>
			
		</div>
	</div>

</body>
</html>
<script type="text/javascript">

</script>