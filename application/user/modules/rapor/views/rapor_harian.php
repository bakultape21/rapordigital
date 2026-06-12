<style type="text/css">
	.form-control{
		width: 100%!important;
	}
	thead{
		background: #b2dbb6;
	}

	.tableFixHead {
	  overflow: auto;
	  height: 600px;
	}

	.tableFixHead thead th {
	  position: sticky;
	  top: 0;
	  background: #b2dbb6;
	}
</style>
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Rapor Final Dari Nilai Harian
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
			<div class="col-sm-7 p-2 border bg-secondary">
				<label><h5>Edit Deskripsi Kelas </h5></label><span> </span> <br>

				<form class="kt-form" id="form-action-kelas" data-multipart='1' action="<?php echo $url; ?>/action_edit_kelas" autocomplete="off">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Nama Kelas : <span class="required">*</span></label>
								<input readonly="" type="text" class="form-control" value="<?= @$record->nama_kelas ?>" name="nama_kelas" placeholder="Nama Kelas" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Tahun Ajaran: <span class="required">*</span></label>
								<input type="hidden" name="kelas_id" value="<?= $id; ?>">
								<input readonly="" type="text" name="tahun" class="form-control" value="<?= @$record->tahun; ?>">	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Semester: <span class="required">*</span></label><br>
								<input class="form-control" readonly disabled value="<?=  ($record->semester==1) ? 'Ganjil' : 'Genap' ; ?>">
								<!-- <input readonly="" type="radio" <?= (@$record->semester=='1')? 'checked': ''; ?> value='1' name="semester" id="ganjil" > <label for="ganjil">Ganjil</label> <br>	
								<input readonly="" type="radio" <?= (@$record->semester=='2')? 'checked': ''; ?> value='2' name="semester" id="genap"> <label for="genap">Genap</label> <br> -->	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Tanggal Cetak Rapor : <span class="required">*</span></label>
								<input type="text" class="form-control datepicker" name="tanggal_raport_cetak" value="<?= @$record->tanggal_raport_cetak ?>" >	
							</div>
						</div>
						<div class="col-md-4">
						
							<div class="form-group">
								<label class="form-control-label">Tanggal Pembagian Rapor : <span class="required">*</span></label>
								<input type="text" class="form-control datepicker" name="tanggal_raport_pembagian" value="<?= @$record->tanggal_raport_pembagian ?>" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Tanggal Pengembalian Rapor : <span class="required">*</span></label>
								<input type="text" class="form-control datepicker" name="tanggal_raport_pengembalian" value="<?= @$record->tanggal_raport_pengembalian ?>" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Kepala Sekolah : <span class="required">*</span></label>
								<input type="text" value="<?= @@$record->kepala_sekolah ?>" name="kepala_sekolah" class="form-control">
							</div>
							<div class="form-group">
								<label class="form-control-label">NIP Kepala Sekolah : <span class="required">*</span></label>
								<input type="text" value="<?= @@$record->kepala_sekolah_nip ?>" name="kepala_sekolah_nip" class="form-control">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Kalimat Depan Sebelum Nama Muncul: <span class="required">*</span></label>
								<input type="text" class="form-control" name="kalimat_depan_rapor" value="<?= $record->kalimat_depan_rapor ?>" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Kalimat Depan Sebelum Nama Tidak Muncul : <span class="required">*</span></label>
								<input type="text" class="form-control" name="kalimat_depan_rapor_tidak_muncul" value="<?= $record->kalimat_depan_rapor_tidak_muncul ?>" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Kalimat Setelah Nama (Nilai Tidak Muncul) : <span class="required">*</span></label>
								<input type="text" class="form-control" name="kalimat_setelah_nama_rapor" value="<?= $record->kalimat_setelah_nama_rapor ?>" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Kalimat Setelah Nama (Nilai Muncul) : <span class="required">*</span></label>
								<input type="text" class="form-control" name="kalimat_setelah_nama_muncul_rapor" value="<?= $record->kalimat_setelah_nama_muncul_rapor ?>" >	
							</div>
						</div>
						
						 <div class="col-md-12 text-center">
							 <!-- <a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a>  -->
							<button type="submit" class="btn btn-brand btn-elevate btn-square">Simpan Edit Kelas</button>
						</div> 
					</div>
				</form>
			</div>
			<div class="col-sm-5 row">
				<div class="table-responsive tableFixHead">
					<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
						<thead>
							<tr>
								<th>No</th>
								<th>Nomor Induk</th>
								<th>Nama Lengkap Siswa</th>
								<th>Rapor</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							 foreach ( $siswa_data as $key) : ; ?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $key->no_induk ?></td>
								<td><?= $key->nama_lengkap; $i++ ?></td>
								<td class="text-center">

									<?php if ($key->kelas_status==0) {?>
									<button type="button" onclick="get_modal_edit_data('<?= ($key->siswa_kelas_id) ?>',  '<?= str_replace("'", " ", $key->nama_lengkap) ?>')" class="btn btn-sm btn-primary">Edit Data</button>

								<?php } ?>
									<button type="button" onclick="get_modal_cetak_data('<?= ($key->siswa_kelas_id) ?>', '<?= str_replace("'", " ", $key->nama_lengkap) ?>')" class="btn btn-sm btn-success">Data Cetak</button>
											
								</td>
							</tr>
							<?php endforeach; ;?>
						</tbody>
									
					</table>
				</div>
				
			
			</div>
			
		
			
			
			
		</div>
		
	</div>
	<a href="<?php echo $url; ?>/harian/<?= $id ?>" class="ajaxify reload"></a>
</div>

<div class="modal fade" id="profil_pancasila" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="nama_siswa_pancasila"></h5>
				
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-header" style="padding-top: 0;
    padding-bottom: 0;">
				<h6 class="modal-title" id="exampleModalLabel">KOKURIKULER</h6>
			</div>
			
			<div class="modal-body" 
			style="height: 600px;
    		overflow-x: scroll;">
    		<form class="kt-form" id="form-action-ppp" data-multipart='1' action="<?php echo $url; ?>/action_ppp/" autocomplete="off">
				<input type="hidden" id="siswa_kelas_id" name="siswa_kelas_id">
				<textarea style="height: 250px;" class="form-control" id="profile_pelajar_pancasila_isi" name="profil_pancasila"></textarea>

				<div class="form-group" style="padding-top: 20px; padding-bottom: 20px;">
					
					<center>
						<div class="w-100">
							<img style="width:200px;" src="" id="foto_ppp_id" >
						</div>
						<h5>
							Foto Profile Pelajar Pancasila
						</h5>
					</center>
					
					<input type="file" name="foto_ppp">
					<input type="hidden" id="backup_foto_pancasila" name="backup_foto_pancasila">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-brand btn-elevate btn-square">Save</button>
				</div>

			</form>
			</div>
			
		</div>
	</div>
</div>
<div class="modal fade" id="edit_foto_rapor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"  id="nama_siswa_edit_foto_rapor"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="height: 600px; overflow-y: scroll;">
				<form class="kt-form" id="form-action-rapor" data-multipart='1' action="<?php echo $url; ?>/action_upload_foto/" autocomplete="off">
					<div id="data_foto" class="col-md-12"></div>
					
					
					<button type="submit" class="btn btn-brand btn-elevate btn-square">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="cetak_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="nama_siswa_cetak"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Nama Dokumen</th>
							<th>Action</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								Cetak Sampul Rapor Siswa
							</td>
							<td>
								<a target="_blank" id="cetak_sampul" href="">
									<button class="btn btn-sm btn-warning">Cetak</button>
								</a>
							</td>
							<td>
								<a target="_blank" id="cetak_sampul_html" href="">
									<button class="btn btn-sm btn-primary">Custome</button>
								</a>
							</td>
						</tr>
						<tr>
							<td>
								Cetak Data Lembaga dan Nama siswa
							</td>
							<td>
								<a target="_blank" id="cetak_data_lembaga" href="">
									<button class="btn btn-sm btn-warning">Cetak</button>
								</a>
							</td>
							<td>
								<a target="_blank" id="cetak_data_lembaga_html" href="">
									<button class="btn btn-sm btn-primary">Custome</button>
								</a>
							</td>
						<tr>
							<td>
								Cetak Data Peserta Didik
							</td>
							<td>
								<a target="_blank" id="cetak_data_siswa" href="">
									<button class="btn btn-sm btn-warning">Cetak</button>
								</a>
							</td>
							<td>
								<a target="_blank" id="cetak_data_siswa_html" href="">
									<button class="btn btn-sm btn-primary">Custome</button>
								</a>
							</td>
						</tr>
						<tr>
							<td>
								Cetak Nilai Extra, Rekap Absensi, Nilai Jasmani
							</td>
							<td>
								<a target="_blank" id="cetak_lembar_terakhir" href="">
									<button class="btn btn-sm btn-warning">Cetak</button>
								</a>
							</td>
							<td>
								<a target="_blank" id="cetak_lembar_terakhir_html" href="">
									<button class="btn btn-sm btn-primary">Custome</button>
								</a>
							</td>
						</tr>
						<tr>
							<td>Cetak Rapor Akhir (Tanpa Foto)</td>
							<td>
								<a target="_blank" id="cetak_rapor_harian"  href="<?= site_url() ?>/rapor/cetak_rapor_harian/">
									<button class="btn btn-sm btn-warning">Cetak</button>
								</a>
							</td>
							<td>
								<a target="_blank" id="cetak_rapor_harian_html"  href="<?= site_url() ?>/rapor/cetak_rapor_harian/">
									<button class="btn btn-sm btn-primary">Custome</button>
								</a>
							</td>
						</tr>
						<tr>
							<td>Cetak Rapor Akhir (Dengan Foto)</td>
							<td>
								<a target="_blank" id="cetak_rapor_harian_foto"  href="<?= site_url() ?>/rapor/cetak_rapor_harian_foto/">
									<button class="btn btn-sm btn-warning">Cetak</button>
								</a>
							</td>
							<td>
								<a target="_blank" id="cetak_rapor_harian_foto_html"  href="<?= site_url() ?>/rapor/cetak_rapor_harian_foto/">
									<button class="btn btn-sm btn-primary">Custome</button>
								</a>
							</td>
						</tr>
						<tr>
							<td>Cetak Rapor Akhir (Tanpa Foto) Watermark</td>
							<td>
								<a target="_blank" id="cetak_rapor_harian_w"  href="<?= site_url() ?>/rapor/cetak_rapor_harian/">
									<button class="btn btn-sm btn-warning">Cetak</button>
								</a>
							</td>
							<td>
								<a target="_blank" id="cetak_rapor_harian_w_html"  href="<?= site_url() ?>/rapor/cetak_rapor_harian/">
									<button class="btn btn-sm btn-primary">Custome</button>
								</a>
							</td>
						</tr>
						<tr>
							<td>Cetak Rapor Akhir (Dengan Foto) Watermark</td>
							<td>
								<a target="_blank" id="cetak_rapor_harian_foto_w"  href="<?= site_url() ?>/rapor/cetak_rapor_harian_foto/">
									<button class="btn btn-sm btn-warning">Cetak</button>
								</a>
							</td>
							<td>
								<a target="_blank" id="cetak_rapor_harian_foto_w_html"  href="<?= site_url() ?>/rapor/cetak_rapor_harian_foto/">
									<button class="btn btn-sm btn-primary">Custome</button>
								</a>
							</td>
						</tr>

					</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="nama_siswa_edit"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Nama Menu</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								KOKURIKULER
							</td>
							<td>
								<button type="button" onclick="" id="edit_ppp" class="btn btn-sm btn-warning">Edit</button>
								
							</td>
						</tr>
						<tr>
							<td>
								Foto Siswa Pada Rapor Setiap Elemen CP
							</td>
							<td>
								<button type="button" onclick="" id="bt_edit_foto_rapor" class="btn btn-sm btn-warning">Edit</button>
								
							</td>
						</tr>
						<tr>
							<td>
								Edit Narasi Akhir
							</td>
							<td>
								<a href="" class="ajaxify" id="bt_edit_narasi">
									<button type="button"   class="btn btn-sm btn-warning">Edit</button>
								</a>
								
								
							</td>
						</tr>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function preview_image(id) 
		{

		$('#img-remove'+id).remove();
		$('#image_preview'+id).empty();

		 var total_file=document.getElementById("files_multi"+id).files.length;
		 for(var i=0;i<total_file;i++)
		 {
		  $('#image_preview'+id).append("<img style='width:200px;' src='"+URL.createObjectURL(event.target.files[i])+"'><br>");
		 }
		}

		function  get_modal_cetak_data(id, nama_siswa) {
			$('#nama_siswa_cetak').empty();
			$('#nama_siswa_cetak').append(nama_siswa);
			$('#cetak_data').modal('show');
			document.getElementById("cetak_sampul").href = "<?= site_url() ?>/rapor/cetak_sampul/"+ id;
			document.getElementById("cetak_sampul_html").href = "<?= site_url() ?>/rapor/cetak_sampul/"+ id+"/html";

			document.getElementById("cetak_data_lembaga_html").href = "<?= site_url() ?>/rapor/cetak_lembaga/"+ id+"/html";
			document.getElementById("cetak_data_lembaga").href = "<?= site_url() ?>/rapor/cetak_lembaga/"+ id;
			document.getElementById("cetak_data_siswa_html").href = "<?= site_url() ?>/rapor/cetak_data_siswa/"+ id+"/html";
			document.getElementById("cetak_data_siswa").href = "<?= site_url() ?>/rapor/cetak_data_siswa/"+ id;
			document.getElementById("cetak_lembar_terakhir_html").href = "<?= site_url() ?>/rapor/cetak_lembar_terakhir/"+ id+"/html";
			document.getElementById("cetak_lembar_terakhir").href = "<?= site_url() ?>/rapor/cetak_lembar_terakhir/"+ id;

			document.getElementById("cetak_rapor_harian").href = "<?= site_url() ?>/rapor/cetak_rapor_harian/"+ id;

			document.getElementById("cetak_rapor_harian_html").href = "<?= site_url() ?>/rapor/cetak_rapor_harian/"+ id+"/0/html";

			document.getElementById("cetak_rapor_harian_foto").href = "<?= site_url() ?>/rapor/cetak_rapor_harian_foto/" + id;

			document.getElementById("cetak_rapor_harian_foto_html").href = "<?= site_url() ?>/rapor/cetak_rapor_harian_foto/" + id+"/0/html";

			document.getElementById("cetak_rapor_harian_w").href = "<?= site_url() ?>/rapor/cetak_rapor_harian/"+ id + '/1';

			document.getElementById("cetak_rapor_harian_w_html").href = "<?= site_url() ?>/rapor/cetak_rapor_harian/"+ id + '/1/html';

			document.getElementById("cetak_rapor_harian_foto_w").href = "<?= site_url() ?>/rapor/cetak_rapor_harian_foto/" + id + '/1';

			document.getElementById("cetak_rapor_harian_foto_w_html").href = "<?= site_url() ?>/rapor/cetak_rapor_harian_foto/" + id + '/1/html';

			
		}
		function  get_modal_edit_data(id, nama_siswa) {
			$('#nama_siswa_edit').empty();
			$('#nama_siswa_edit').append(nama_siswa);
			$('#edit_data').modal('show');
			document.getElementById("edit_ppp").onclick =  function() {get_edit_ppp(id, nama_siswa)};
			document.getElementById("bt_edit_foto_rapor").onclick =  function() {get_edit_foto_rapor(id, nama_siswa)};
			document.getElementById("bt_edit_narasi").href = "<?= site_url() ?>/rapor/rapor_narasi/edit_narasi/" + id;

			// document.getElementById("cetak_data_lembaga").href = "<?= site_url() ?>/rapor/cetak_lembaga/"+ id;
			
			
		}
		function get_edit_ppp(id, nama_siswa) {

			$('#nama_siswa_pancasila').empty();
			$('#nama_siswa_pancasila').append(nama_siswa);

			$.ajax({
					url: '<?= site_url() ?>/rapor/get_data_siswa',
					type: 'POST',
					dataType: 'json',
					async: false,
					data : {siswa_kelas_id:id},
					success: function(respon){
						$('#edit_data').modal('hide');
						document.getElementById('siswa_kelas_id').value= id;
						document.getElementById('profile_pelajar_pancasila_isi').value= respon.profil_pancasila;
						document.getElementById('foto_ppp_id').src= "<?= base_url() ?>"+respon.foto_profile_pancasila;
						document.getElementById('backup_foto_ppp').value= respon.foto_profile_pancasila;
						document.getElementById('backup_foto_pancasila').value= respon.foto_profile_pancasila;

						
					}
				});
			$('#profil_pancasila').modal('show');
			
		}
		function putar_gambar(url, id, nama_siswa) {
			let targetImg = null;
			let imgs = document.querySelectorAll('#form-action-rapor img');
			for (let img of imgs) {
				if (img.src.includes(url)) {
					targetImg = img;
					break;
				}
			}

			if (!targetImg) {
				alert('Gambar tidak ditemukan di layar.');
				return;
			}

			let image = new Image();
			image.crossOrigin = "Anonymous";
			
			let currentSrc = targetImg.src;
			if (currentSrc.startsWith('data:') || currentSrc.startsWith('blob:')) {
				image.src = currentSrc; 
			} else {
				let cleanUrl = currentSrc.split('?')[0]; 
				image.src = cleanUrl + "?t=" + new Date().getTime();
			}

			image.onload = function() {
				let canvas = document.createElement("canvas");
				let ctx = canvas.getContext("2d");

				canvas.width = image.height;
				canvas.height = image.width;

				ctx.translate(canvas.width / 2, canvas.height / 2);
				ctx.rotate(90 * Math.PI / 180);
				ctx.drawImage(image, -image.width / 2, -image.height / 2);

				let base64Data = canvas.toDataURL("image/jpeg", 1.0);
				targetImg.src = base64Data;

				$.ajax({
					url: '<?= site_url() ?>/rapor/putar_gambar',
					type: 'POST',
					dataType: 'json',
					data: {
						url: url,
						base64_data: base64Data,
						siswa_kelas_id: id
					},
					success: function(response) {
						if (response.status === 1) {
							console.log('Gambar di server berhasil ditimpa dengan rotasi baru.');
						} else {
							alert('Gagal di server: ' + response.message);
						}
					},
					error: function() {
						alert('Terjadi error jaringan saat menyimpan rotasi.');
					}
				});
			};
		}
		function get_edit_foto_rapor(id, nama_siswa) {

			$('#nama_siswa_edit_foto_rapor').empty();
			$('#nama_siswa_edit_foto_rapor').append(nama_siswa);
			var data_foto ='';

			$.ajax({
					url: '<?= site_url() ?>/rapor/get_data_siswa_foto',
					type: 'POST',
					dataType: 'json',
					async: false,
					data : {siswa_kelas_id:id},
					success: function(respon){
						data_foto = '<input type="hidden" name="siswa_kelas_id" value="'+id+'">';
						for (var i = respon.length - 1; i >= 0; i--) {
					
						data_foto += '<center><label><h4>'+respon[i].elemen_data+'</h4></label></center>'+
									'<div class="w-100" id="image_preview'+respon[i].elemen_data_id+'">'+
										'<img class="w-100" id="img-remove" src="<?= base_url() ?>/'+respon[i].foto+'">'+
									'</div>'+
									'<div style="padding-top:20px; padding-bottom:20px;">'+
										'<input type="file" id="files_multi'+respon[i].elemen_data_id+'" onchange="preview_image('+respon[i].elemen_data_id+');"  name="'+respon[i].elemen_data_id+'">'+
										'<input type="hidden" name="b'+respon[i].elemen_data_id+'" value="'+respon[i].foto+'">'+
										'<button type="button" class="btn btn-warning" onclick="putar_gambar('+"'"+respon[i].foto+"',"+id+ ",'"+nama_siswa+"'"+')">Putar Gambar</button>'+
									'</div>';
						}
						$('#data_foto').empty();
						$('#data_foto').append(data_foto);

						$('#edit_data').modal('hide');

						var form2 	= '#form-action-rapor',
							rule2 	= {
							},
							message2 = {};
						FormValidation.handleValidation(form2, rule2, message2);

					}
				});
			$('#edit_foto_rapor').modal('show');
			
		}

	
	jQuery(document).ready(function() {
		
		

		var formppp 	= '#form-action-ppp',
			ruleppp 	= {
			},
			messageppp = {};
		FormValidation.handleValidation(formppp, ruleppp, messageppp);

	});



	jQuery(document).ready(function() {
		var form1 	= '#form-action-kelas',
			rule1 	= {
			},
			message1 = {};

		FormValidation.handleValidation(form1, rule1, message1);
	});

	$( function() {
	    $( ".datepicker" ).datepicker({
	    	format: "yyyy-mm-dd",
	    	orientation: 'bottom auto',
			autoclose: true
	    });
  } );

</script>


