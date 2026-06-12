<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
			<i class="flaticon2-plus-1"></i> Form Rekap Absensi
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url; ?>/" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i> Kembali
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="col-sm-12 border bg-warning">
			<label><h5>Deskripsi Kelas </h5></label><span> </span> <br>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nama Kelas : <span class="required">*</span></label>
						<input type="text" class="form-control" value="<?= $guru_sekolah->nama_kelas ?>" readonly>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Tahun Ajaran: <span class="required">*</span></label>
						<input type="text" readonly class="form-control" value ="<?= $guru_sekolah->tahun ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Semester: <span class="required">*</span></label><br>
						<input type="text" class="form-control" readonly value="<?=  ($guru_sekolah->semester==1) ? 'Ganjil' : 'Genap' ; ?>">
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-sm-12 row">
			<label><h4>Siswa Dalam Kelas </h4></label>
			<hr>
			<form class="kt-form col-md-12" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_add/<?= $id?>" autocomplete="off">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
					<thead>
						<tr>
							<th>No</th>
							<th>Nomor Induk</th>
							<th>Nama Lengkap Siswa</th>
							<th>Izin</th>
							<th>Tanpa Keterangan</th>
							<th>Sakit</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=1;
						foreach ($siswa_data as $key) :  ?>
						<tr>
							<td><?= $i; ?></td>
							<td><?= $key->no_induk ?></td>
							<td><?= $key->nama_lengkap ?></td>
							<td><input class="form-control" type="number" value="<?= $key->absensi_izin ?>" name="absensi_izin[]"></td>
							<td><input class="form-control" type="number" value="<?= $key->absensi_tanpa_keterangan ?>" name="absensi_tanpa_keterangan[]"></td>
							<td><input class="form-control" type="number" value="<?= $key->absensi_sakit ?>" name="absensi_sakit[]"><input type="hidden" name="siswa_kelas_id[]" value="<?= $key->siswa_kelas_id ?>"></td>
						</tr>
						<?php $i++; endforeach; ;?>
					</tbody>
					
				</table>
			</div>

				<div class="col-md-12 text-center">
					<a href="<?php echo base_url(); ?>/Kelas/" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a>
					<button type="submit" class="btn btn-brand btn-elevate btn-square">Simpan</button>
				</div>
					
			</form>
			
			
		</div>
	</div>
	
</div>
<a href="<?php echo base_url(); ?>/kelas/" class="ajaxify reload"></a>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {
			},
			message = {};

		FormValidation.handleValidation(form, rule, message);
		
		

		
	});

</script>