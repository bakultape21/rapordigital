<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url; ?>/show_edit/<?php echo $id; ?>" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<form class="kt-form" id="form-action" data-multipart='1' data-confirm="1" action="<?php echo $url.'/action_edit/'.$id; ?>" autocomplete="off">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nama Sekolah : <span class="required">*</span></label>
						<input type="text" required name="sekolah_nama" class="form-control" value="<?= $record->sekolah_nama ?>" placeholder="Full Name">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">npsn : <span class="required">*</span></label>
						<input type="text" required name="npsn" value="<?= $record->npsn ?>" class="form-control" placeholder="npsn">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Maximum Register : <span class="required">*</span></label>
						<input type="number" required name="maximum_register" value="<?= $record->maximum_register ?>" class="form-control" placeholder="Maximum Register">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">SK : <span class="required">*</span></label>
						<input type="text"  name="sk" value="<?= $record->sk ?>" class="form-control" placeholder="SK">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nomor Telepon : <span class="required">*</span></label>
						<input type="nomor_telepon"  value="<?= $record->nomor_telepon ?>" name="nomor_telepon" class="form-control" placeholder="Nomor Telepon">
					</div>
				</div>

			
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Alamat : <span class="required">*</span></label>
						<textarea class="form-control" name="alamat"><?= $record->alamat ?></textarea>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Akreditasi : <span class="required">*</span></label>
						<select name="akreditasi" class="select2" style="width:100%">
							<option selected value="<?= $record->akreditasi ?>"><?= $record->akreditasi ?></option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Kurikulum : <span class="required">*</span></label>
						<input type="radio" value="1" name="kurikulum" checked> Merdeka <br>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Kabupaten : <span class="required">*</span></label>
						<select id="kabupaten_id" name="kabupaten_id" class="form-control select2-kabupaten" placeholder="Kabupaten">
							<option selected value="<?= $record->kabupaten_id ?>"><?= $record->kabupaten ?></option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Photo : </label>
						<div class="custom-file mb-3">
							<input type="file" class="custom-file-input" name="logo">
							<label class="custom-file-label" for="photo">Choose file</label>
							<input type="hidden" readonly name="logo_backup" value="<?php echo $record->logo; ?>">
							<img src="<?= base_url().'/'.$record->logo ?>" class="img-responsive" style='width: 100%;' >
						</div>
					</div>
				</div>
				<div class="col-md-12 text-center">
					<a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Back</a>
					<button type="submit" class="btn btn-brand btn-elevate btn-square">Save</button>
				</div>
			</div>
		</form>
	</div>
	<a href="<?php echo $url?>/show_edit/<?php echo $id; ?>" class="ajaxify reload"></a>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {},
			message = {};
		FormValidation.handleValidation(form, rule, message);

		$('.select2').select2();

		$('.select2-kabupaten').select2({
			width: '100%',
			placeholder: 'Pilih Kabupaten',
			allowClear: true,
			ajax: {
				url: base_url + '/fetch/get_kabupaten',
				dataType: 'json',
				type: "POST",
				delay: 500,
				data: function(param) {
					return {
						q: param.term
					};
				},
				processResults: function(data, page) {
					return {
						results: data.item
					};
				},
			}
		});
		
	});
</script>
