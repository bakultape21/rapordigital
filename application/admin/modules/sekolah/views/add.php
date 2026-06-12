<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url; ?>/show_add" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_add" autocomplete="off">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nama Sekolah : <span class="required">*</span></label>
						<input type="text" required name="sekolah_nama" class="form-control" placeholder="Nama Sekolah">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">npsn : <span class="required">*</span></label>
						<input type="text" required name="npsn" class="form-control" placeholder="npsn">
					</div>
				</div>				

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Kabupaten/Kota : <span class="required">*</span></label>
						<select id="kabupaten_id" name="kabupaten_id" class="form-control select2-kabupaten" placeholder="Kabupaten/Kota" required>
							
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Maksimal Peserta : <span class="required">*</span></label>
						<input type="number" value="1" name="maximum_register" class="form-control" >
					</div>
				</div>
				<div class="col-md-12 offset-md-12">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				<div class="col-md-12 text-center">
					<a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Back</a>
					<button type="submit" class="btn btn-brand btn-elevate btn-square">Save</button>
				</div>
			</div>
		</form>
	</div>
	<a href="<?php echo $url; ?>/show_add" class="ajaxify reload"></a>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {
				password: "required",
				confirm : {
					equalTo: "#password"
				}
			},
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