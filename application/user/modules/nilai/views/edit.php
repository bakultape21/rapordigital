<?php
$semester=
	['2'=> 'Genap', '1'=> 'Ganjil'];
 ?>

<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Edit TP/TK dan Nilai Belajar
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				
				<a href="<?= site_url() ?>/kelas" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i> Kembali
				</a>
				<a href="<?= site_url() ?>/nilai/list/<?= ($kelas_id) ?>" class="ajaxify btn btn-warning" aria-haspopup="true">
					 <i class="fa fa-table"></i> Daftar Input Harian
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
			<div class="col-sm-6 badge badge-primary">
				<h3><label><?= $record->nama_kelas ?></label><br>
					Semester <?= $semester[$record->semester] ?> Tahun <?= $record->tahun; ?>
				</h3>
			</div>
			<div class="col-sm-6">
			</div> 
			
			<div class="col-md-12">
				<hr>
				<div class="col-md-12">
					<h3><label>Edit Nilai Belajar TP Siswa</label></h3>
				</div>
				<form class="kt-form" id="form-action" data-redirect='1' data-link='<?php echo $url; ?>/list/<?= ($kelas_id) ?>' data-multipart='1' action="<?php echo $url; ?>/action_edit" autocomplete="off">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label class="form-control-label col-sm-3">Elemen Belajar Siswa : <span class="required">*</span></label>
								<div class="col-sm-9">
									<select class="select2-elemen form-control" onload="elemen(this)" onchange="elemen(this)" id="elemen_data_id" name="elemen_data_id" required>
										<option selected value="<?= $record->elemen_data_id ?>"><?= $record->elemen_data ?></option>
									</select>	
								</div>
							</div>
							
						</div>
						<div class="col-md-12">

							<div class="form-group row">

								<label class="form-control-label col-sm-3">CP Belajar Siswa : <span class="required">*</span></label>
									<div class="col-sm-9">
										<select class="select2-cp form-control " name="cp_id" required>
											<option selected value="<?= $record->cp_id ?>"><?= $record->capaian_belajar ?></option>
										</select>	
										<input type="hidden" name="kegiatan_id" value="<?= $record->kegiatan_id; ?>">
									</div>
								</div>
							</div>
							
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<label class="form-control-label col-sm-3">Kegiatan Belajar/ TP/ TK : <span class="required">*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="kegiatan_belajar" value="<?= $record->kegiatan_belajar ?>" required>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<label class="form-control-label col-sm-3">Tanggal : <span class="required">*</span></label>
								<div class="col-sm-9">
									<input type="text" name="kegiatan_tanggal" value="<?= $record->kegiatan_tanggal ?>" class="form-control datepicker" required>
								</div>
							</div>
						</div>
						<hr>
						<h4>Nilai Siswa</h4>
						<hr>
						
						<?php foreach ($record_data as $key => $value) : ?>
						<div class="col-md-12">
							<div class="form-group row">
								<label class="form-control-label col-sm-3"><?= $value->nama_lengkap ?> : <span class="required">*</span></label>
								<div class="">
									
									<input type="radio" value="0" <?=  ($value->kegiatan_nilai=='0') ? 'checked' : '' ; ?> name="kegiatan_nilai[<?= $value->id ?>]" id="TAN<?= $value->id ?>"> 
										<label class="badge badge-secondary" for="TAN<?= $value->id ?>">Tidak Ada Nilai </label> <br>
									<input type="radio" <?=  ($value->kegiatan_nilai=='1') ? 'checked' : '' ; ?> value="1" name="kegiatan_nilai[<?= $value->id ?>]" id="TM<?= $value->id ?>"> 
										<label  class="badge badge-warning" for="TM<?= $value->id ?>">Tidak Muncul </label> <br>
									<input type="radio" value="2" <?=  ($value->kegiatan_nilai=='2') ? 'checked' : '' ; ?> name="kegiatan_nilai[<?= $value->id ?>]" id="M<?= $value->id ?>"> 
										<label  class="badge badge-success" for="M<?= $value->id ?>">Muncul </label> 

								</div>
								<input type="hidden" name="id[]" value="<?= $value->id ?>" required>

							</div>
						</div>
						<?php endforeach; ?>
						
						<div class="col-md-12 text-center">
							<button type="submit" class="btn btn-brand btn-elevate btn-square">Simpan</button>
						</div>
				</form>

			</div>
			
		</div>
	</div>
</div>

<a href="<?php echo $url?>/index/<?php echo strEncrypt($kelas_id); ?>" class="ajaxify reload"></a>

<script type="text/javascript">
		jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {
			},
			message = {};



		FormValidation.handleValidation(form, rule, message);


		$('.select2-elemen').select2({
			width: '100%',
			placeholder: 'Pilih Elemen',
			allowClear: true,
			ajax: {
				url: base_url + '/fetch/get_elemen/',
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
		
			var elemen_data_id= $('#elemen_data_id').val();

			$('.select2-cp').select2({
				width: '100%',
				placeholder: 'Pilih CP',
				allowClear: true,
				ajax: {
					url: base_url + '/fetch/get_cp/<?= $kelas_id; ?>/'+elemen_data_id,
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

	function elemen(cek) {

			var elemen_data_id= $('#elemen_data_id').val();

			$('.select2-cp').select2({
				width: '100%',
				placeholder: 'Pilih CP',
				allowClear: true,
				ajax: {
					url: base_url + '/fetch/get_cp/<?= $kelas_id; ?>/'+elemen_data_id,
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
		}
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