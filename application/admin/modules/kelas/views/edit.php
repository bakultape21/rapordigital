
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
						<input type="text" required name="guru_nama" readonly class="form-control" value="<?= $record->guru_nama ?>" placeholder="Guru Nama">
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
						<label class="form-control-label">Nama Kelas : <span class="required">*</span></label>
						<input type="text" name="nama_kelas" required value="<?= $record->nama_kelas ?>" class="form-control">
					</div>
				</div>
				<hr>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Semester: <span class="required">*</span></label><br>
						<input type="radio" <?= ($record->semester=='1')? 'checked': ''; ?> value='1' name="semester" id="ganjil" > <label for="ganjil">Ganjil</label> <br>	
						<input type="radio" <?= ($record->semester=='2')? 'checked': ''; ?> value='2' name="semester" id="genap"> <label for="genap">Genap</label> <br>	
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Tahun Ajaran: <span class="required">*</span></label>
						<input type="hidden" name="kelas_id" value="<?= $id; ?>">
						<input type="text" class="form-control" name="tahun" value="<?= $record->tahun ?>">
							
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
