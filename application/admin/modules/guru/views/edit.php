
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
						<label class="form-control-label">Nama Guru : <span class="required">*</span></label>
						<input type="text" required name="guru_nama" class="form-control" value="<?= $record->guru_nama ?>" placeholder="Guru Nama">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nip : <span class="required">*</span></label>
						<input type="text" required name="nip" value="<?= $record->nip ?>" class="form-control" placeholder="NIP">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Email : <span class="required">*</span></label>
						<input type="email" required name="email" value="<?= $record->email ?>" class="form-control" placeholder="Email">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nomor Telepon : <span class="required">*</span></label>
						<input type="nomor_telepon" required value="<?= $record->nomor_telepon ?>" name="nomor_telepon" class="form-control" placeholder="Nomor Telepon">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Password : <span class="required">*</span></label>
						<input type="text" name="password_new" autocomplete="off" class="form-control">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Jabatan : <span class="required">*</span></label>
						<select name="jabatan" class="select2" style="width:100%">
							<option selected value="<?= $record->jabatan ?>"><?= ($record->jabatan=='2') ? 'Guru' : 'Kepala Sekolah' ; ?></option>
							<option value="2">Guru</option>
							<option value="3">Kepala Sekolah</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Batas Semester : <span class="required">*</span></label>
						<input type="number" required value="<?= $record->batas_semester ?>" name="batas_semester" class="form-control">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Sekolah : <span class="required">*</span></label>
						<select class="form-control select2-sekolah" name="sekolah_id">
							<option value="<?= $record->sekolah_id ?>"><?= $record->sekolah_nama; ?></option>
						</select>
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

		$('.select2-sekolah').select2({
			width: '100%',
			placeholder: 'Pilih Sekolah',
			allowClear: true,
			ajax: {
				url: base_url + '/fetch/get_sekolah',
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
