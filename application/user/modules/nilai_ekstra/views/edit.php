<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo base_url(); ?>/nilai_ekstra/index/<?= ($record[0]->kelas_id); ?>" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i> Kembali
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_edit/<?= $id ?>" autocomplete="off">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nama Lengkap Siswa : <span class="required">*</span></label>
						<input type="text" required name="nama_lengkap" readonly value="<?= $record[0]->nama_lengkap ?>" class="form-control" placeholder="Full Name">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nomor Induk : <span class="required">*</span></label>
						<input type="text" required name="no_induk" readonly value="<?= $record[0]->no_induk ?>" class="form-control" >
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Kelas : <span class="required">*</span></label>
						<input type="text" required readonly value="<?= $record[0]->nama_kelas ?>" class="form-control" >
					</div>
				</div>
				<div class="col-sm-12 row" id="nilai_ekstra_list">
					<?php $i=0; foreach ($record as $key => $value) { ?>
					
					<div class="col-md-12 row" id="nilai_ekstra_<?= $i; ?>">
						<div class="col-md-12">
							<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Kegiatan Ekstra : <span class="required">*</span></label>
								<input type="text" required name="nilai_ekstra_kegiatan[]" value="<?= $value->nilai_ekstra_kegiatan ?>" class="form-control" placeholder="Kegiatan Ekstra">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Nilai Ekstra : <span class="required">*</span></label>
								<input type="text" required name="nilai_ekstra[]" value="<?= $value->nilai_ekstra ?>" class="form-control" value="Baik" placeholder="Nilai Ekstra">
							</div>
						</div>
						<div class="col-md-3">
							<label class="form-control-label">Hapus : <span class="required">*</span></label><br>
							<button type="button" class="btn btn-brand btn-danger" onclick="remove(<?= $i; ?>)">Hapus</button>
						</div>
					</div>
					<?php $i++; } ?>
					
				</div>
				<div class="col-md-12">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Kegiatan Ekstra : <span class="required">*</span></label>
						<input type="text" required name="nilai_ekstra_kegiatan[]" class="form-control" placeholder="Kegiatan Ekstra">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nilai Ekstra : <span class="required">*</span></label>
						<input type="text" required name="nilai_ekstra[]" class="form-control" placeholder="Nilai Ekstra">
					</div>
				</div>
				<div class="col-md-3">
					<label class="form-control-label">Add : <span class="required">*</span></label><br>
					<button class="btn btn-brand btn-success" type="button" onclick="add_nilai_ekstra()">Tambahkan Ekstra</button>
				</div>
			
				
				<div class="col-md-4 offset-md-4">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>
				</div>
				<div class="col-md-12 text-center">
					<a href="<?php echo base_url(); ?>/nilai_ekstra/index/<?= ($record[0]->kelas_id); ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Back</a>
					<button type="submit" class="btn btn-brand btn-elevate btn-square">Save</button>
				</div>
			</div>
		</form>
	</div>
	<a href="<?php echo base_url(); ?>/nilai_ekstra/index/<?= ($record[0]->kelas_id); ?>" class="ajaxify reload"></a>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {},
			message = {};
		FormValidation.handleValidation(form, rule, message);
		
	
	});
	var i=100;
	function add_nilai_ekstra() {

		i++;
		html = '<div class="col-md-12 row" id="nilai_ekstra_'+i+'">'+
						'<div class="col-md-12">'+
							'<div style="border: 1px solid #ccc;" id="roles" class="mb-3"></div>'+
						'</div>'+
						'<div class="col-md-4">'+
							'<div class="form-group">'+
								'<label class="form-control-label">Kegiatan Ekstra : <span class="required">*</span></label>'+
								'<input type="text" required name="nilai_ekstra_kegiatan[]" class="form-control" placeholder="Kegiatan Ekstra">'+
							'</div>'+
						'</div>'+
						'<div class="col-md-4">'+
							'<div class="form-group">'+
								'<label class="form-control-label">Nilai Ekstra : <span class="required">*</span></label>'+
								'<input type="text" required name="nilai_ekstra[]" class="form-control" value="Baik" placeholder="Nilai Ekstra">'+
							'</div>'+
						'</div>'+
						'<div class="col-md-3">'+
							'<label class="form-control-label">Hapus : <span class="required">*</span></label><br>'+
							'<button type="button" class="btn btn-brand btn-danger" onclick="remove('+i+')">Hapus</button>'+
						'</div>'+
					'</div>';
			$('#nilai_ekstra_list').append(html);

	}
	function remove(id) {

		$('#nilai_ekstra_'+id).remove();
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