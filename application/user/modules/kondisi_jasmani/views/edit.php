<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form Edit <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
		
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_edit/<?= $id ?>" autocomplete="off">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nama Lengkap Siswa : <span class="required">*</span></label>
						<input type="text" required name="nama_lengkap" readonly value="<?= $record->nama_lengkap ?>" class="form-control" placeholder="Full Name">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nomor Induk : <span class="required">*</span></label>
						<input type="text" required name="no_induk" readonly value="<?= $record->no_induk ?>" class="form-control" >
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Kelas : <span class="required">*</span></label>
						<input type="text" required readonly value="<?= $record->nama_kelas ?>" class="form-control" >
					</div>
				</div>
				<div class="col-md-12">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Mata/Pengelihatan : <span class="required">*</span></label>
						<input type="text" required name="mata_pengelihatan" class="form-control" value="<?= $record->mata_pengelihatan ?>" placeholder="Mata Pengelihatan">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Hidung/Penciuman : <span class="required">*</span></label>
						<input type="text" required name="hidung_penciuman" class="form-control" value="<?= $record->hidung_penciuman ?>" placeholder="Hidung Penciuman">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Telinga/Pendengaran : <span class="required">*</span></label>
						<input type="text" required name="telinga_pendengaran" class="form-control" value="<?= $record->telinga_pendengaran ?>" placeholder="Telinga Pendengaran">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Mulut : <span class="required">*</span></label>
						<input type="text" required name="mulut" class="form-control" value="<?= $record->mulut ?>" placeholder="Mulut">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Gigi : <span class="required">*</span></label>
						<input type="text" required name="gigi" class="form-control" value="<?= $record->gigi ?>" placeholder="Gigi">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Anggota Badan : <span class="required">*</span></label>
						<input type="text" required name="anggota_badan" class="form-control" value="<?= $record->anggota_badan ?>" placeholder="Anggota Badan">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Kulit : <span class="required">*</span></label>
						<input type="text" required name="kulit" class="form-control" value="<?= $record->kulit ?>" placeholder="Kulit">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Kebersihan : <span class="required">*</span></label>
						<input type="text" required name="kebersihan" class="form-control" value="<?= $record->kebersihan ?>" placeholder="Kebersihan">
					</div>
				</div>
				<div class="col-md-12">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Tinggi Badan Awal Semester (cm): <span class="required">*</span></label>
						<input type="number" required name="tb_awal" value="<?= $record->tb_awal ?>" class="form-control" placeholder="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Tinggi Badan Akhir Semester (cm): <span class="required">*</span></label>
						<input type="number" required name="tb_akhir" value="<?= $record->tb_akhir ?>" class="form-control">
					</div>
				</div>

				<div class="col-md-12">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Berat Badan Awal Semester(Kg): <span class="required">*</span></label>
						<input type="number" required name="bb_awal" value="<?= $record->bb_awal ?>" class="form-control" placeholder="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Berat Badan Akhir Semester (Kg): <span class="required">*</span></label>
						<input type="number" required name="bb_akhir" value="<?= $record->bb_akhir ?>" class="form-control">
					</div>
				</div>

				<div class="col-md-12">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Lingkar Kepala Awal Semester (cm): <span class="required">*</span></label>
						<input type="number" required name="lk_awal" value="<?= $record->lk_awal ?>" class="form-control" placeholder="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Lingkar Kepala Akhir Semester (cm): <span class="required">*</span></label>
						<input type="number" required name="lk_akhir" value="<?= $record->lk_akhir ?>" class="form-control">
					</div>
				</div>

				<div class="col-md-12">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Lingkar Lengan Awal Semester (cm): <span class="required">*</span></label>
						<input type="number" required name="ll_awal" value="<?= $record->ll_awal ?>" class="form-control" placeholder="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Lingkar Lengan Akhir Semester (cm): <span class="required">*</span></label>
						<input type="number" required name="ll_akhir" value="<?= $record->ll_akhir ?>" class="form-control">
					</div>
				</div>
				<div class="col-md-12">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Imunisasi: <span class="required">*</span></label>
						<input type="text" required name="imunisasi" value="<?= $record->imunisasi ?>" class="form-control" value="Sudah" placeholder="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Pemberian Kapsul Vitamin: <span class="required">*</span></label>
						<input type="text" required name="kapsul_vitamin" value="<?= $record->kapsul_vitamin ?>" class="form-control" value="Sudah" placeholder="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Riwayat Penyakit: <span class="required">*</span></label>
						<textarea name="riwayat_penyakit" class="form-control"><?= $record->riwayat_penyakit ?></textarea>
					</div>
				</div>
				
				<div class="col-md-4 offset-md-4">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				<div class="col-md-12 text-center">
					<a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Back</a>
					<button type="submit" class="btn btn-brand btn-elevate btn-square">Save</button>
				</div>
			</div>
		</form>
	</div>
	<a href="<?php echo base_url(); ?>/kondisi_jasmani/index/<?=($record->kelas_id); ?>" class="ajaxify reload"></a>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {},
			message = {};
		FormValidation.handleValidation(form, rule, message);
		
	
	});
</script>
<script type="text/javascript">
	
  $( function() {
    $( ".datepicker" ).datepicker({
    	format: "yyyy-mm-dd",
    	orientation: 'bottom auto',
		autoclose: true
    });
  } );
	</script>