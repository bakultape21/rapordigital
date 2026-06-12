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
			
				<a href="<?php echo base_url() ?>/kelas/" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i> Kembali
				</a>
				<?php if ($elemen[0]->sekolah_elemen_kelompok_id != null && $cp_belajar ==NULL) {?>
					<button class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#tarik_data" >Tarik Data Master CP</button>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
			<div class="col-sm-4 p-2 border bg-warning">
				<label><h5>CP Belajar </h5></label><span> </span> <br>

				<span>
					Cp Belajar siswa diterapkan pada satu kelas
				</span>
			</div>
			<div class="col-sm-8 ">

				<form class="kt-form" id="form-action" data-multipart='1' data-reload='1' action="<?php echo $url; ?>/action_add_cp" autocomplete="off">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Elemen : <span class="required">*</span></label>
								<select class="form-control" name="elemen_data_id" required>
									
									<?php foreach ($elemen as $key => $value) : ?>
									<option value="<?= $value->elemen_data_id ?>"><?= $value->elemen_data ?></option>
									<?php endforeach; ?>
								</select>	
							</div>
							<div class="form-group">
								<label class="form-control-label">CP Nomor : <span class="required">*</span></label>
								<input type="text" required name="cp_nomor" class="form-control" placeholder="Nomor CP">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label class="form-control-label">Capaian Belajar : <span class="required">*</span></label>
								<textarea style="height:200px" class="form-control" name="cp_belajar"></textarea>
							</div>
						</div>
						<input type="hidden" name="kelas_id" value="<?= $kelas; ?>">
						
						<div class="col-md-12 text-center">
							<!-- <a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a> -->
							<button type="submit" class="btn btn-brand btn-elevate btn-square">Tambahkan</button>
						</div>
					</div>
				</form>
			</div>
	
		</div>
		<hr>
		<div class="table-responsive">
			<div class="tab">
				<?php foreach ($elemen as $key => $value) : ?>
					<button class="tablinks border border-secondary " onclick="openCity(event, '<?= $value->elemen_data_id ?>')"><?= $value->elemen_data ?></button>
				<?php endforeach; ?>
			</div>
			<?php foreach ($elemen as $key => $value) : ?>
					
			<div id="<?= $value->elemen_data_id ?>" class="tabcontent " >
				<h3><?= $value->elemen_data ?></h3>
				
				<ul class="list-group">
					<table class="table table-border">
						
					
					<?php foreach ($cp_belajar as $ke => $ky) :
						if ($ky->elemen_data_id== $value->elemen_data_id) : ?>
							<tr>
								<td><?= $ky->cp_nomor ?></td>
								<td><?= $ky->capaian_belajar ?></td>
								<td>
									<a style="padding: 1px; width: 80px;" href="<?= site_url() ?>/cp_belajar/show_edit/<?= $kelas ?>/<?= ($ky->cp_id) ?>" class="btn btn-warning ajaxify" title="Edit">
										<i class="la la-edit"></i> Edit
									</a>
									<a href="#" style="padding:1px; width: 80px;" type="button" onclick="delete_cp('<?= ($ky->cp_id) ?>')" class="btn btn-danger " title="Hapus">
										<i class="la la-trash"></i> Hapus
									</a>
								</td>
							</tr>
						
					<?php 
						endif;
					endforeach; ?>
				</table>
				  
				</ul>
			</div>
			<?php endforeach; ?>

		</div>
	</div>
</div>
<div class="modal fade" id="tarik_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tarik Data Master Capaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="col-md-12">
	       	<span class="badge badge-warning">
	       		<strong>Tarik Data Master Capain</strong> adalah menu untuk memasukan <br>
	       						data capaian yang umum digunakan oleh masing-masing lembaga <br>
	       						sehingga <strong>Guru</strong> tidak harus memasukan ulang data <br>
	       						 capaian belajar. <br>
	       						<strong>Guru masih bisa melakukan koreksi</strong> setelah data ditarik.
	       	</span>
	       	<br>
	       	<hr>
	       	<button class="btn btn-sm btn-primary" onclick=" insert_cp( '<?= $kelas ?>','A')" type="button">TK A</button>
	       	<button class="btn btn-sm btn-success" onclick=" insert_cp( '<?= $kelas ?>','B')" type="button">TK B</button>
	       </div>
	       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
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

function insert_cp(kelas_id, kelompok) {
	var cek = confirm("Anda Yakin Untuk Tarik Data CP ini?");
	if (cek==true) {
		
			$.ajax({
				url: '<?= site_url() ?>/cp_belajar/set_cp',
				type: 'POST',
				dataType: 'json',
				data : {kelas_id:kelas_id, kelompok:kelompok},

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