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
	.btn-merah{
		background: #ff5050;
		color: #fff;
	}
</style>
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Detail Kelas dan Penilaian
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
			<div class="col-sm-7 p-2 border ">
				<label><h5>Deskripsi Kelas </h5></label><span> </span> <br>

				<form class="kt-form bg-secondary" id="form-action-kelas" data-multipart='1' action="<?php echo $url; ?>/action_edit_kelas" autocomplete="off">
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
						<div class="col-md-8">
							<div class="form-group">
								<label class="form-control-label">Wali Kelas : <span class="required">*</span></label>
								<input type="text" class="form-control " readonly value="<?= @$record->guru_nama ?>" >	
							</div>
						</div>
						
					</div>
				</form>
				<hr>
				<?php if ($record->kelas_status==0) {?>
				<table class=" w-100 table table-striped table-bordered">
					<thead>
						<tr>
							<th>Menu</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Memasukan CP Belajar Pada Setiap Elemen</td>
							<td>
								<a href="<?= base_url() ?>/cp_belajar/index/<?=($id)?>" data-original-title="CP Belajar" class="btn btn-sm  btn-sm p-1 btn-icon-md tooltips btn-primary btnAction ajaxify" >CP belajar</a>  <br>
							</td>
						</tr>
						<tr>
							<td>Memasukan <b>Nilai</b> TK/TP/Kegiatan Harian setiap CP Belajar </td>
							<td><a href="<?= base_url() ?>/nilai/index/<?= ($id)?>" data-original-title="Input Nilai" class="btn btn-sm  btn-sm p-1 btn-icon-md tooltips btn-danger btnAction ajaxify" >TK/TP Nilai Belajar Harian</a></td>
						</tr>
						<tr>
							<td>Merubah Data Kelas, Menambahkan Siswa dan Deskripsi pada Kelas/Rombel</td>
							<td>
								<a href="<?= base_url()?>/kelas/show_edit/<?= ($id) ?>" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-warning btn-icon-md btn-sm p-1 tooltips btnAction ajaxify" title="Edit">
								Edit</a> 
							</td>
						</tr>
						<tr style="display: none;">
							<td> 7 Kebiasaan Anak (diinput orangtua)</td>
							<td>
								<a href="<?= base_url()?>/kebiasaan/index/<?= ($id) ?>" data-permission="w" data-original-title="Tambahkan & Detail" class="btn btn-merah btn-sm btn-icon-md btn-sm p-1 tooltips btnAction ajaxify" title="Edit">
								Tambahkan & Details</a> 
							</td>
						</tr>  
						<tr>
							<td>Update Kondisi Jasmani Pada Setiap Siswa</td>
							<td><a href="<?= base_url() ?>/kondisi_jasmani/index/<?=($id)?>" data-original-title="Kondisi Jasmani Siswa" class="btn btn-sm p-1 btn-sm btn-success tooltips ajaxify ">Kondisi Jasmani Siswa</a> </td>
						</tr>
						<tr>
							<td>Cetak Daftar Siswa/Absensi Siswa</td>
							<td>
								<a href="<?= base_url() ?>/kelas/detail/<?= ($id)?>" data-original-title="cetak daftar siswa" class="btn btn-sm p-1 btn-sm btn-secondary tooltips" target="_blank"> Cetak Daftar Siswa</a>
							</td>
						</tr>
						<tr>
							<td>Memasukan Nilai Ekstra Pada Setiap Siswa</td>
							<td><a href="<?= base_url()?>/nilai_ekstra/index/<?=($id)?>" data-original-title="Nilai Ekstra" class="btn btn-sm p-1 btn-sm btn-brand tooltips ajaxify"> Nilai Ekstra</a></td>
						</tr>
					</tbody>
				</table>
				<? } ?>
				
			</div>
			<div class="col-sm-5 row">
				<div class="table-responsive tableFixHead">
					<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
						<thead>
							<tr>
								<th>No</th>
								<th>Nomor Induk</th>
								<th>Nama Lengkap Siswa</th>
								<th>Detail</th>
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
									<a class="ajaxify" href="<?= base_url() ?>/siswa/show_edit/<?= ($key->siswa_id) ?>/<?= ($key->siswa_id) ?>">
										<button type="button" class="btn btn-sm btn-primary">Data Siswa</button>
									</a>
									
									
								<!-- 	<a target="_blank" href="<?= site_url() ?>/rapor/cetak_sampul/<?= strEncrypt($key->siswa_kelas_id) ?>">
										<button class="btn btn-sm btn-warning">Cetak Sampul</button>
									</a>
									<a target="_blank" href="<?= site_url() ?>/rapor/cetak_lembaga/<?= strEncrypt($key->siswa_kelas_id) ?>">
										<button class="btn btn-sm btn-primary">Cetak Data Lembaga</button>
									</a>
									<a target="_blank" href="<?= site_url() ?>/rapor/cetak_data_siswa/<?= strEncrypt($key->siswa_kelas_id) ?>">
										<button class="btn btn-sm btn-danger">Cetak Data Peserta Didik</button>
									</a>
									<a target="_blank" title="Cetak Perkembangan Jasmani, Nilai Ekstra, dan Absensi" href="<?= site_url() ?>/rapor/cetak_lembar_terakhir/<?= strEncrypt($key->siswa_kelas_id) ?>">
										<button class="btn btn-sm btn-secondary">Cetak Nilai Extra, Absensi, Jasmani</button>
									</a>

									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#profil_pancasila<?= $key->siswa_kelas_id ?>">KOKURIKULER
									</button>

									
									<a target="_blank"  href="<?= site_url() ?>/rapor/cetak_rapor_harian/<?= strEncrypt($key->siswa_kelas_id) ?>">
										<button class="btn btn-sm btn-primary">Cetak Rapor Akhir</button>
									</a>
									<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit_foto<?= $key->siswa_kelas_id ?>">Edit Foto Rapor
										</button>
									
									<a target="_blank"  href="<?= site_url() ?>/rapor/cetak_rapor_harian_foto/<?= strEncrypt($key->siswa_kelas_id) ?>">
										<button class="btn btn-sm btn-success">Cetak Rapor Akhir Foto</button>
									</a>
 -->									
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



<script type="text/javascript">


		function  get_modal_cetak_data(id, nama_siswa) {
			$('#nama_siswa_cetak').empty();
			$('#nama_siswa_cetak').append(nama_siswa);
			$('#cetak_data').modal('show');
			document.getElementById("cetak_sampul").href = "<?= site_url() ?>/rapor/cetak_sampul/"+ id;
			document.getElementById("cetak_data_lembaga").href = "<?= site_url() ?>/rapor/cetak_lembaga/"+ id;
			document.getElementById("cetak_data_siswa").href = "<?= site_url() ?>/rapor/cetak_data_siswa/"+ id;
			document.getElementById("cetak_lembar_terakhir").href = "<?= site_url() ?>/rapor/cetak_lembar_terakhir/"+ id;
			document.getElementById("cetak_rapor_harian").href = "<?= site_url() ?>/rapor/cetak_rapor_harian/"+ id;
			document.getElementById("cetak_rapor_harian_foto").href = "<?= site_url() ?>/rapor/cetak_rapor_harian_foto/" + id;
			document.getElementById("cetak_rapor_harian_w").href = "<?= site_url() ?>/rapor/cetak_rapor_harian/"+ id + '/1';
			document.getElementById("cetak_rapor_harian_foto_w").href = "<?= site_url() ?>/rapor/cetak_rapor_harian_foto/" + id + '/1';

			
		}
		function  get_modal_edit_data(id, nama_siswa) {
			$('#nama_siswa_edit').empty();
			$('#nama_siswa_edit').append(nama_siswa);
			$('#edit_data').modal('show');
			document.getElementById("edit_ppp").onclick =  function() {get_edit_ppp(id, nama_siswa)};
			document.getElementById("bt_edit_foto_rapor").onclick =  function() {get_edit_foto_rapor(id, nama_siswa)};
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
							
						
						data_foto += '<label>'+respon[i].elemen_data+'</label>'+
									'<div class="w-100" id="image_preview'+respon[i].elemen_data_id+'">'+
										'<img class="w-100" id="img-remove" src="<?= base_url() ?>/'+respon[i].foto+'">'+
									'</div>'+
									'<div>'+
										'<input type="file" id="files_multi'+respon[i].elemen_data_id+'" onchange="preview_image('+respon[i].elemen_data_id+');"  name="'+respon[i].elemen_data_id+'">'+
										'<input type="hidden" name="b'+respon[i].elemen_data_id+'" value="'+respon[i].elemen_data_id+'">'+
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

