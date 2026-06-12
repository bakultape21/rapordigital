<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo base_url(); ?>rapor/harian/<?= $data_siswa->kelas_id ?>" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_add" autocomplete="off">
			<div class="row">
				<input type="hidden" name="siswa_kelas_id" value="<?= $id ?>">
				<?php foreach ($elemen_sekolah as $key) {?>
					<label class="form-label col-md-12">
						<h3><?= $key->elemen_data ?></h3>
						<input type="hidden" name="elemen_data_id[]" value="<?= $key->elemen_data_id ?>">
					</label>
					<label class="col-md-12">
						<h5>Muncul</h5>
					</label>
					 <select class="form-control set_select2 " name="kalimat_muncul_<?= $key->elemen_data_id ?>[]" multiple>

					<?php
					foreach ($kegiatan as $vl) {
						if ($key->elemen_data_id== $vl->elemen_data_id){
							?>
							<option><?= $vl->kegiatan_belajar ?></option>
							<?php 
						}
					}

					if ($nilai_rapor != null) {
						foreach ($nilai_rapor as  $value) :
							
	                        if ($value->elemen_data_id == $key->elemen_data_id ) :
	                        		$arr= explode(', ', $value->kalimat_muncul);
	                        		for ($i=0; $i < count($arr); $i++) {?>
	                            		<option selected><?= $arr[$i] ?></option>
	                            <?php
	                            }
	                        endif;
	                    endforeach;
	                    foreach ($cp_belajar as $ky => $value) :
		                        if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai == 2) :
		                        		$arr= explode(', ', $value->kegiatan);
		                        		for ($i=0; $i < count($arr); $i++) {?>
		                            		<option ><?= $arr[$i] ?></option>
		                            <?php
		                            }
		                        endif;
	                    endforeach; 
						foreach ($cp_belajar as $ky => $value) :
		                    if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai == 1) :
		                        		$arr= explode(', ', $value->kegiatan);
		                        		for ($i=0; $i < count($arr); $i++) {?>
		                            		<option ><?= $arr[$i] ?></option>
		                            <?php
		                            }
		                        endif;
		                endforeach;
					}else{
							foreach ($cp_belajar as $ky => $value) :
		                        if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai == 2) :
		                        		$arr= explode(', ', $value->kegiatan);
		                        		for ($i=0; $i < count($arr); $i++) {?>
		                            		<option selected><?= $arr[$i] ?></option>
		                            <?php
		                            }
		                        endif;
		                    endforeach;

							foreach ($cp_belajar as $ky => $value) :
		                        if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai == 1) :
		                        		$arr= explode(', ', $value->kegiatan);
		                        		for ($i=0; $i < count($arr); $i++) {?>
		                            		<option ><?= $arr[$i] ?></option>
		                            <?php
		                            }
		                        endif;
		                    endforeach;
						
					}

                     ?>
					 </select>
					 <br>
					 <label class="col-md-12">
						<h5>Tidak Muncul</h5>
					</label>

					<select class="form-control set_select2 " name="kalimat_tidak_muncul_<?= $key->elemen_data_id ?>[]" multiple>
						<?php

						foreach ($kegiatan as $vl) {
							if ($key->elemen_data_id== $vl->elemen_data_id){
								?>
								<option><?= $vl->kegiatan_belajar ?></option>
								<?php 
							}
						}

						if ($nilai_rapor != null) {
							foreach ($nilai_rapor as  $value) :
								
		                        if ($value->elemen_data_id == $key->elemen_data_id ) :
		                        		$arr= explode(', ', $value->kalimat_tidak_muncul);
		                        		for ($i=0; $i < count($arr); $i++) {?>
		                            		<option selected ><?= $arr[$i] ?></option>
		                            <?php
		                            }
		                        endif;
		                    endforeach;

		                    foreach ($cp_belajar as $ky => $value) :
		                        if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai == 2) :
		                        		$arr= explode(', ', $value->kegiatan);
		                        		for ($i=0; $i < count($arr); $i++) {?>
		                            		<option ><?= $arr[$i] ?></option>
		                            <?php
		                            }
		                        endif;
	                    	endforeach; 
							foreach ($cp_belajar as $ky => $value) :
		                        if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai == 1) :
		                        		$arr= explode(', ', $value->kegiatan);
		                        		for ($i=0; $i < count($arr); $i++) {?>
		                            		<option ><?= $arr[$i] ?></option>
		                            <?php
		                            }
		                        endif;
		                    endforeach;



						}else{
							foreach ($cp_belajar as $ky => $value) :
		                        if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai == 2) :
		                        		$arr= explode(', ', $value->kegiatan);
		                        		for ($i=0; $i < count($arr); $i++) {?>
		                            		<option ><?= $arr[$i] ?></option>
		                            <?php
		                            }
		                        endif;
	                    	endforeach; 
							foreach ($cp_belajar as $ky => $value) :
		                        if ($value->elemen_data_id== $key->elemen_data_id && $value->nilai == 1) :
		                        		$arr= explode(', ', $value->kegiatan);
		                        		for ($i=0; $i < count($arr); $i++) {?>
		                            		<option selected><?= $arr[$i] ?></option>
		                            <?php
		                            }
		                        endif;
		                    endforeach;

		                } ?>
					</select>
					
				<?php } ?>
				<div class="col-md-12 text-center">
					<a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Back</a>
					<button type="submit" class="btn btn-brand btn-elevate btn-square">Save</button>
				</div>
			</div>
		</form>
	</div>
	<a href="<?php echo base_url(); ?>/rapor/rapor_narasi/edit_narasi/<?= $id; ?>" class="ajaxify reload"></a>
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
		
		$('.set_select2').select2();
		
	});
</script>