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
						<label class="form-control-label">Nama Lengkap Siswa : <span class="required">*</span></label>
						<input type="text" required name="nama_lengkap" class="form-control" placeholder="Full Name">
					</div>
					<div class="form-group">
						<label class="form-control-label">Nama Panggilan : <span class="required">*</span></label>
						<input type="text" required name="nama_panggilan" class="form-control" placeholder="Nama Panggilan">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">NISN : <span class="required">*</span></label>
						<input type="text" required name="nisn" class="form-control" placeholder="NISN">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nomor Induk : <span class="required">*</span></label>
						<input type="text" required name="no_induk" class="form-control" placeholder="No induk">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Tempat Lahir : <span class="required">*</span></label>
						<input type="text" required name="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Tanggal Lahir : <span class="required">*</span></label>
						<input type="text" required name="tanggal_lahir" class="form-control datepicker" placeholder="YYYY-MM-DD">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Agama :  <span class="required">*</span></label><br>
						<select class="form-control" name="agama" required>
							<option value="1">Islam</option>
							<option value="2">Kristen</option>
							<option value="3">Katolik</option>
							<option value="4">Hindu</option>
							<option value="5">Kong hucu</option>
							<option value="6">Budha</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Jenis Kelamin :  <span class="required">*</span></label><br>
						<input type="radio" required name="jenis_kelamin" value="1"> Laki-laki <br>
						<input type="radio" required name="jenis_kelamin" value="0"> Perempuan <br>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Alamat : <span class="required">*</span></label>
						<textarea class="form-control" name="alamat" required></textarea>
					</div>
				</div>
				
				
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Foto Siswa : </label>
						<div class="custom-file mb-3">
							<input type="file" class="custom-file-input" name="foto_siswa">
							<label class="custom-file-label" for="foto_siswa">Choose file</label>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nomor Telepon Ortu: <span class="required">*</span></label>
						<input type="nomor_telepon" required name="nomor_telepon" class="form-control" placeholder="Nomor Telepon">
					</div>
				</div>
				<div class="col-md-12">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nama Ibu : <span class="required">*</span></label>
						<input type="text" required name="nama_ibu" class="form-control" placeholder="Nama Ibu Kandung">
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Pekerjaan Ibu : <span class="required">*</span></label>
						<input type="text" name="pekerjaan_ibu" class="form-control" required>
					</div>
				</div>
				<div class="col-md-4">
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nama Ayah  : <span class="required">*</span></label>
						<input type="text" required name="nama_ayah" class="form-control" placeholder="Nama Ayah">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Pekerjaan Ayah  : <span class="required">*</span></label>
						<input type="text" name="pekerjaan_ayah" class="form-control" required>
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