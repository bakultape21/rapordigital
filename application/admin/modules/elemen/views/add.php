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
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-control-label">Kelompok : <span class="required">*</span></label>
						<select class="form-control" name="kelompok_id" required >
							<option value="">Pilih Kelompok</option>
							<?php foreach ($kelompok as $key => $value) : ?>
								<option value="<?= $value->kelompok_id ?>"><?= $value->nama_kelompok ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nomor : <span class="required">*</span></label>
						<input type="number" required name="nomor" class="form-control" placeholder="Nomor">
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label class="form-control-label">Elemen : <span class="required">*</span></label>
						<input type="text" required name="elemen" class="form-control" placeholder="Elemen">
					</div>
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
			$('.select2-desa').select2({
			width: '100%',
			placeholder: 'Pilih Desa',
			allowClear: true,
			ajax: {
				url: base_url + '/fetch/get_desa',
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