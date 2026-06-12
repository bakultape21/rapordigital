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
						<label class="form-control-label">Kurikulum : <span class="required">*</span></label>

						<?php foreach ($kurikulum as $key => $value) {?>
							<div class="row">
								<input value="<?= $value->nama_kelompok ?>" class="form-control col-md-6" type="text" readonly> <?= ($value->sekolah_elemen_status==1) ? '<span class="badge badge-primary" >Diterapkan</span>' : '-' ; ?></span>
							</div>
							
						<?php } ?>
						<br>
					</div>
				</div>

				 <?php foreach ($kelompok as $key => $value): ?>
	       		<button class="btn btn-sm btn-primary" onclick="return insert_elemen('<?= $value->kelompok_id ?>', '<?= $record->sekolah_id ?>')" type="button"><?= $value->nama_kelompok ?></button>
	       		<?php endforeach; ?>
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

	function insert_elemen(kelompok_id, sekolah_id) {
	var cek = confirm("Anda Yakin Untuk Tarik Data Elemen ini?");
	if (cek==true) {
		
			$.ajax({
				url: '<?= site_url() ?>/sekolah/set_elemen',
				type: 'POST',
				dataType: 'json',
				data : {kelompok_id:kelompok_id, sekolah_id: sekolah_id},
				success: function(res){

					if (res.status==2) {
						toastr.warning(res.message);
					}else{
						toastr.success(res.message);

						location.reload();
					}
					
				}
			});
	}else{
		
	}
}
</script>
