
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Master Sekolah
			</h3>
		</div>
		
	</div>
	<div class="kt-portlet__body">
		<div class="row">
				<div class="col-sm-12 ">
				<form class="kt-form" data-confirm="1" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_add" autocomplete="off">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Nama Sekolah : <span class="required">*</span></label>
								<input type="text" class='form-control' required name="sekolah_nama" value="<?= $record->sekolah_nama ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">npsn : <span class="required">*</span></label>
								<input type="text" class='form-control' required name="npsn" value="<?= $record->npsn ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">SK : <span class="required">*</span></label>
								<input type="text" class='form-control' required name="sk" value="<?= $record->sk ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Alamat Sekolah: <span class="required">*</span></label>
								<input type="text" class='form-control' required name="alamat" value="<?= $record->alamat ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Akreditasi : <span class="required">*</span></label>
								<input type="text" class='form-control' required name="akreditasi" value="<?= $record->akreditasi ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Email : <span class="required">*</span></label>
								<input type="email" class='form-control' required name="email" value="<?= $record->email ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Nomor Telepon : <span class="required">*</span></label>
								<input type="text" class='form-control' required name="nomor_telepon" value="<?= $record->nomor_telepon ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Dinas Penaung : <span class="required">*</span></label>
								<input type="text" class='form-control' required name="dinas_penaung" value="<?= $record->dinas_penaung ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Yayasan : </label>
								<input type="text" class='form-control' name="yayasan" value="<?= $record->yayasan ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Logo Sekolah : <span class="required">*</span></label>
								<img src="<?= base_url() ?>/<?= $record->logo; ?>" class="w-100">
								<input type="file" name="logo">
								<input type="hidden" name="logo_backup" value="<?= $record->logo; ?>" >
							</div>
						</div>
						<hr>
						<div class="col-md-12 text-center">
							<!-- <a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a> -->
							<button type="submit" class="btn btn-brand btn-elevate btn-square">Tambahkan</button>
						</div>
					</div>
				</form>
			</div>
		
			
		</div>
		
	</div>
	<a href="<?php echo $url; ?>" class="ajaxify reload"></a>
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {
			},
			message = {};

		FormValidation.handleValidation(form, rule, message);
		
	});


</script>
