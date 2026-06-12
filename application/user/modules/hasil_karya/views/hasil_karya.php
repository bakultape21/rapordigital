<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Hasil Karya</title>
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
				<h3>Hasil Karya Siswa </h3> <br>
				<button onclick="window.print()" class="btn btn-primary btn-sm">Cetak</button>
			</div>
		</div>
	</div>
	<div class="container sectiontoprint" id="sectiontoprint">
		<div class="col-md-12">
			<h3>
				<br>
			</h3>

			<div class="col-md-12 text-center">
					<h1>HASIL KARYA</h1>
					<h2><?= $guru_sekolah->sekolah_nama ?></h2>

			</div>

			<div class="table-responsive">
				<table class="table text-center" style="border:none;" >
					<tr>
						<td width="33%">Nama Siswa:</td>
						<td width="33%"></td>
						<td width="33%">Kelompok</td>
					</tr>
					<tr>
						<td width="33%">Usia:</td>
						<td width="33%"></td>
						<td width="33%">Wali Kelas</td>
					</tr>
					<tr>
						<td width="33%">Tanggal:</td>
						<td width="33%"></td>
						<td width="33%">Semester</td>
					</tr>
				</table>
			</div>

			<div class="table-responsive">
				<table class="table table-border" >
					<thead>
						<tr>
							<th>Hasil Karya</th>
							<th>Kegiatan</th>
							<th>Analisa</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td width="33%">
									<img src="http://localhost/sirapor/uploads/sirapor.jpeg" width="100%">
								</td>
								<td width="33%">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
								</td>
								<td width="33%">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
								</td>
							</tr>
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
						<td width="33%">Semester Ganjil</td>
					</tr>
					<tr>
						<td width="33%"><?= $guru_sekolah->sekolah_nama ?></td>
						<td width="33%"></td>
						<td width="33%">Lamongan, 5 Januari 2023</td>
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
						<td width="33%">Dr. Ma Sk.kom</td>
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