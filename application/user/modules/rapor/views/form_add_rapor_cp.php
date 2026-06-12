
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form Penilaian Rapor Final Semester
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url; ?>/" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i> Kembali
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
			
			<div class="col-sm-12 p-2 border bg-secondary">

				

				<form class="kt-form" id="form-action" data-confirm='1'  data-multipart='1' action="<?php echo $url; ?>/action_rapor_cp" autocomplete="off">
					<input type="hidden" name="siswa_kelas_id" value="<?= $id ?>">
					<div class="row">
						<?php foreach ($elemen_sekolah as $key => $value) :?>
							
						<div class="col-md-12">
							<h5><?= strtoupper($value->elemen_data) ?> </h5>
						</div>						
						
						<?php foreach ($cp_belajar as $ky=> $val) : 

							if ($val->elemen_data_id == $value->elemen_data_id) : ?>

							<div class="col-md-12 row">
								<div class="col-md-10">
									<input type="text" class="form-control" value="<?= $val->capaian_belajar; ?>" name="capaian_belajar"  readonly >	
								</div>
								<div class="col-md-2">
									<input type="radio" <?= ($val->nilai== 0) ? 'checked' : '' ; ?>  value="0" name="nilai_cp<?= $val->cp_id ?>[<?= $val->cp_id ?>]"> <label>Tidak Ada Nilai</label><br>
									<input type="radio" <?= ($val->nilai== 1) ? 'checked' : '' ; ?> value="1" name="nilai_cp<?= $val->cp_id ?>[<?= $val->cp_id ?>]"> <label>Tidak Muncul</label><br>
									<input type="radio" <?= ($val->nilai== 2) ? 'checked' : '' ; ?> value="2" name="nilai_cp<?= $val->cp_id ?>[<?= $val->cp_id ?>]"> <label>Muncul</label>
								</div>
								<hr width="100%">
								<input type="hidden" name="cp_id[]" value="<?= $val->cp_id; ?>">
							</div>
						<?php 
						endif;
						endforeach; 
						endforeach; ?>
						
						
						 <div class="col-md-12 text-center">
							 <!-- <a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a>  -->
							<button type="submit" class="btn btn-brand btn-elevate btn-square">Simpan</button>
						</div> 
					</div>
				</form>
			</div>
		
			
			
			
		</div>
		
	</div>
	<a href="<?php echo $url; ?>/show_add_cp/<?= ($record->kelas_id) ?>" class="ajaxify reload"></a>
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		var form2 	= '#form-action',
			rule2 	= {
			},
			message2 = {};
		FormValidation.handleValidation(form2, rule2, message2);

	});

$( function() {
    $( ".datepicker" ).datepicker({
    	format: "yyyy-mm-dd",
    	orientation: 'bottom auto',
		autoclose: true
    });
  } );

</script>

