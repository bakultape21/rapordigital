
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form Edit Kelas dan Perubahan Isi Siswa
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url; ?>/index_detail/<?= $id ?>" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i> Kembali
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
				<div class="col-sm-4 ">
				<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_add_siswa" autocomplete="off">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">Menambahkan Siswa : <span class="required">*</span></label>
								<select class="select2-siswa form-control" name="siswa_id" required>
								</select>	
								<input type="hidden" name="kelas_id" value="<?= $id; ?>">

							</div>
						</div>
						
						<div class="col-md-12 text-center">
							<!-- <a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a> -->
							<button type="submit" class="btn btn-brand btn-elevate btn-square">Tambahkan</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-sm-8 row">
				<label><h4>Siswa Dalam Kelas Yang Ditambahkan</h4></label>
				<hr>
				<div class="table-responsive" style="height: 300px; overflow: scroll;">
					<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
						<thead>
							<tr>
								<th>No</th>
								<th>Nomor Induk</th>
								<th>Nama Lengkap Siswa</th>
								<th>Alamat</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							 foreach ( $record_data as $key) :  ?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $key->no_induk ?></td>
								<td><?= $key->nama_lengkap ?></td>
								<td><?= $key->alamat; $i++; ?></td>
								<td>
									<form class="kt-form" id="form-delete-siswa<?= $i ?>" data-multipart='1' data-confirm="1" action="<?= site_url() ?>/kelas/delete_siswa_edit" autocomplete="off" >
										<input type="hidden" name="siswa_kelas_id" value="<?= ($key->siswa_kelas_id); ?>">
										<button title="delete" class="btn btn-sm btn-danger"><i class="la la-edit"></i> Hapus</button> 
									</form>
									<script type="text/javascript">
										jQuery(document).ready(function() {
											var formd<?= $i ?> 	= '#form-delete-siswa<?= $i ?>',
											rule 	= {
											},
											text="Apakah anda yakin menghapus siswa dari kelas, karena data nilai keseluruhan anak ini akan hilang dan tidak bisa di kembalikan? ",
											message = {};

										FormValidation.handleValidation(formd<?= $i ?>, rule, message, 'Hapus Siswa Pada Kelas',  text);
									});
									</script>
								</td>
							</tr>
							<?php endforeach; ;?>
						</tbody>
									
					</table>
				</div>
				
			
			</div>
			<div class="col-sm-12 p-2 border" style="background-color: #90f5ac5c !important;">
				<label><h5>Edit Deskripsi Kelas </h5></label><span> </span> <br>

				<form class="kt-form" id="form-action-kelas" data-multipart='1' action="<?php echo $url; ?>/action_edit_kelas" autocomplete="off">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Nama Kelas : <span class="required">*</span></label>
								<input readonly="" type="text" class="form-control" value="<?= $record->nama_kelas ?>" name="nama_kelas" placeholder="Nama Kelas" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Tahun Ajaran: <span class="required">*</span></label>
								<input type="hidden" name="kelas_id" value="<?= $id; ?>">
								<input type="text" readonly="" name="tahun" class="form-control" value="<?= $record->tahun; ?>">	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Semester: <span class="required">*</span></label><br>
								<input type="radio" <?= ($record->semester=='1')? 'checked': ''; ?> value='1' name="semester" id="ganjil" > <label for="ganjil">Ganjil</label> <br>	
								<input type="radio" <?= ($record->semester=='2')? 'checked': ''; ?> value='2' name="semester" id="genap"> <label for="genap">Genap</label> <br>	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Tanggal Cetak Rapor : <span class="required">*</span></label>
								<input type="text" class="form-control datepicker" name="tanggal_raport_cetak" value="<?= $record->tanggal_raport_cetak ?>" >	
							</div>
						</div>
						<div class="col-md-4">
						
							<div class="form-group">
								<label class="form-control-label">Tanggal Pembagian Rapor : <span class="required">*</span></label>
								<input type="text" class="form-control datepicker" name="tanggal_raport_pembagian" value="<?= $record->tanggal_raport_pembagian ?>" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Tanggal Pengembalian Rapor : <span class="required">*</span></label>
								<input type="text" class="form-control datepicker" name="tanggal_raport_pengembalian" value="<?= $record->tanggal_raport_pengembalian ?>" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Kepala Sekolah : <span class="required">*</span></label>
								<input type="text" value="<?= @$record->kepala_sekolah ?>" name="kepala_sekolah" class="form-control">
							</div>
							<div class="form-group">
								<label class="form-control-label">NIP Kepala Sekolah : <span class="required">*</span></label>
								<input type="text" value="<?= @$record->kepala_sekolah_nip ?>" name="kepala_sekolah_nip" class="form-control">
							</div>
						</div>
					
						
						
						 <div class="col-md-12 text-center">
							 <!-- <a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a>  -->
							<button type="submit" class="btn btn-brand btn-elevate btn-square">Simpan Edit Kelas</button>
						</div> 
					</div>
				</form>
			</div>
		
			
			
			
		</div>
		
	</div>
	<a href="<?php echo $url; ?>/kelas/show_edit/<?= $id ?>" class="ajaxify reload"></a>
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		var form2 	= '#form-action',
			rule2 	= {
			},
			message2 = {};
		FormValidation.handleValidation(form2, rule2, message2);


		var form 	= '#form-delete-siswa',
			rule 	= {
			},
			message = {};

		FormValidation.handleValidation(form, rule, message);
		
			$('.select2-siswa').select2({
			width: '100%',
			placeholder: 'Pilih Siswa',
			allowClear: true,
			ajax: {
				url: base_url + '/fetch/get_siswa',
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

