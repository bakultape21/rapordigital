<style type="text/css">
	/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
			<i class="fa fa-table"></i> Capaian Belajar dadi Elemen
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo base_url() ?>/kelas/" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
			<div class="col-sm-4 p-2 border bg-warning">
				<label><h5>CP Belajar </h5></label> <br>

				<span>
					Cp Belajar siswa diterapkan pada satu kelas
				</span>
			</div>
			<div class="col-sm-8 ">
				<h3>Edit</h3>
				<form class="kt-form" id="form-action" data-multipart='1' data-redirect='1' data-link='<?php echo $url; ?>/index/<?= $kelas ?>' action="<?php echo $url; ?>/action_edit/<?= $id ?>" autocomplete="off">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Elemen : <span class="required">*</span></label>
								<select class="form-control" name="elemen_data_id" required>

									<?php foreach ($elemen as $key => $value) : ?>
									<option <?=  ($value->elemen_data_id== $record->elemen_data_id) ? 'selected' : '' ; ?> value="<?= $value->elemen_data_id ?>"><?= $value->elemen_data ?></option>
									<?php endforeach; ?>
								</select>	
							</div>
							<div class="form-group">
								<label class="form-control-label">CP Nomor : <span class="required">*</span></label>
								<input type="text" required name="cp_nomor" value="<?= $record->cp_nomor; ?>" class="form-control" placeholder="Nomor CP">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label class="form-control-label">Capaian Belajar : <span class="required">*</span></label>
								<textarea style="height:200px" class="form-control" name="cp_belajar"><?= $record->capaian_belajar ?></textarea>
							</div>
						</div>
						<input type="hidden" name="kelas_id" value="<?= $kelas; ?>">						
						<div class="col-md-12 text-center">
							<!-- <a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a> -->
							<button type="submit" class="btn btn-warning btn-elevate btn-square">Simpan Edit</button>
						</div>
					</div>
				</form>
			</div>
	
		</div>
		<hr>
		<div class="table-responsive">
			<div class="tab">
				<?php foreach ($elemen as $key => $value) : ?>
					<button class="tablinks border border-secondary <?=   ($value->elemen_data_id== $record->elemen_data_id) ? 'Active' : '' ; ?>" onclick="openCity(event, '<?= $value->elemen_data_id ?>')"><?= $value->elemen_data ?></button>
				<?php endforeach; ?>
			</div>
			<?php foreach ($elemen as $key => $value) : ?>
					
			<div id="<?= $value->elemen_data_id ?>" class="tabcontent" style="display: <?=   ($value->elemen_data_id== $record->elemen_data_id) ? 'block !important' : 'none' ; ?>;">
				<h3><?= $value->elemen_data ?></h3>
				
				<ul class="list-group">
					<?php foreach ($cp_belajar as $ke => $ky) :
						if ($ky->elemen_data_id== $value->elemen_data_id) : ?>
						<li class="list-group-item "><?= $ky->cp_nomor.'  - '.$ky->capaian_belajar; ?>
							<a href="<?= site_url() ?>/cp_belajar/show_edit/<?= $kelas ?>/<?= ($ky->cp_id) ?>" class="btnAction ajaxify" title="Edit">
								<i class="la la-edit"></i> Edit
							</a>
							<button type="button" onclick="delete_cp('<?= ($ky->cp_id) ?>')" class="btnAction btn-danger">
								<i class="la la-trash">Hapus</i>
							</button>
						</li>
					<?php 
						endif;
					endforeach; ?>
				  
				</ul>
			</div>
			<?php endforeach; ?>

		</div>
	</div>
</div>
<a href="<?php echo $url; ?>/index/<?= $kelas ?>" class="ajaxify reload"></a>

<script type="text/javascript">
	

	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {
				
			},
			message = {};
		FormValidation.handleValidation(form, rule, message);
		
		
	});

function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
function delete_cp(cp_id) {
	var cek = confirm("Anda Yakin Hapus Data CP ini?");
	if (cek==true) {
		
			$.ajax({
				url: '<?= site_url() ?>/cp_belajar/delete_cp',
				type: 'POST',
				dataType: 'json',
				data : {cp_id:cp_id},

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