
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form Menambahkan Kelas dan Mengisi Siswa
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
		<?php if (@$kelas[0] != null) {?>
			<span class="badge badge-danger" style="background-color:red !important;">
				<h3>
					Mohon maaf, saat ini masih terdapat kelas yang sedang berjalan.<br> Anda tidak bisa menambahkan kelas.
					<br>

					<strong>Rubah Kelas yang sedang berjalan menjadi selesai, baru buat kelas baru</strong>
				</h3>
			</span>
		<?php }else{ ?>
		<div class="row">
				<div class="col-sm-4 ">
			<!-- 	<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_add" autocomplete="off"> -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">Menambahkan Siswa : <span class="required">*</span></label>
								<select id="siswa_id" class="select2-siswa form-control" name="siswa_id" required>
								</select>	
							</div>
						</div>
						
						<div class="col-md-12 text-center">
							<!-- <a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a> -->
							<button type="button" onclick="add_siswa(this)" class="btn btn-brand btn-elevate btn-square">Tambahkan</button>
						</div>
					</div>
				<!-- </form> -->
			</div>
			<div class="col-sm-8 row">
				<label><h4>Siswa Dalam Kelas Yang Ditambahkan</h4></label>
				<hr>
				<div class="table-responsive">
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
							 foreach ( $siswa_data as $key) :  ?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $key['no_induk'] ?></td>
								<td><?= $key['nama_lengkap'] ?></td>
								<td><?= $key['alamat']; $i++; ?></td>
								<td>
									<a href="<?php echo $url; ?>/delete_siswa/<?= $key['rowid'] ?>" class="ajaxify" aria-haspopup="true" >
										<button class="btn btn-sm btn-danger">hapus</button>
									</a>
								</td>
							</tr>
							<?php endforeach; ;?>
						</tbody>
									
					</table>
				</div>
				
			
			</div>
			<div class="col-sm-12 p-2 border bg-warning">
				<label><h5>Deskripsi Kelas </h5></label><span> </span> <br>

				<form class="kt-form" id="form-action-kelas" data-reload='1' data-multipart='1' action="<?php echo $url; ?>/action_add_kelas" autocomplete="off">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Nama Kelas : <span class="required">*</span></label>
								<input type="text" class="form-control" name="nama_kelas" placeholder="Nama Kelas" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Tahun Ajaran: <span class="required">*</span></label>
								<input type="text" name="tahun" class="form-control" required>	
							</div>
						</div>
						<div class="col-md-4">
						
							<div class="form-group">
								<label class="form-control-label">Tanggal Cetak Rapor : <span class="required">*</span></label>
								<input type="text" class="form-control datepicker" name="tanggal_raport_cetak" value="<?= date('Y-m-d') ?>" >	
							</div>
						</div>
						<div class="col-md-4">
						
							<div class="form-group">
								<label class="form-control-label">Tanggal Pembagian Rapor : <span class="required">*</span></label>
								<input type="text" class="form-control datepicker" name="tanggal_raport_pembagian" value="<?= date('Y-m-d') ?>" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Tanggal Pengembalian Rapor : <span class="required">*</span></label>
								<input type="text" class="form-control datepicker" name="tanggal_raport_pengembalian" value="<?= date('Y-m-d') ?>" >	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Semester: <span class="required">*</span></label><br>
								<input type="radio" value='1' name="semester" id="ganjil" > <label for="ganjil">Ganjil</label> <br>	
								<input type="radio" value='2' name="semester" id="genap"> <label for="genap">Genap</label> <br>	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-control-label">Kepala Sekolah : <span class="required">*</span></label>
								<input type="text" value="<?= @$kepala_sekolah[0]->guru_nama ?>" name="kepala_sekolah" class="form-control">
							</div>
							<div class="form-group">
								<label class="form-control-label">NIP Kepala Sekolah : <span class="required">*</span></label>
								<input type="text" value="<?= @$kepala_sekolah[0]->nip ?>" name="kepala_sekolah_nip" class="form-control">
							</div>
						</div>
						
						 <div class="col-md-12 text-center">
							 <!-- <a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a>  -->
							<button type="submit" class="btn btn-brand btn-elevate btn-square">Simpan Kelas</button>
						</div> 
					</div>
				</form>
			</div>
		
			
			
			
		</div>
	<?php } ?>
		
	</div>
	<a href="<?php echo $url; ?>/" class="ajaxify reload"></a>
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		// var form 	= '#form-action',
		// 	rule 	= {
		// 	},
		// 	message = {};

		// FormValidation.handleValidation(form, rule, message);
		
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

	  function add_siswa(arg) {
	  	var siswa_id= $('#siswa_id').val();

	  	// alert(siswa_id);

	  	 $.ajax({
            type: "POST",
            url: "<?php echo $url; ?>/action_add",
            data: "siswa_id="+siswa_id,
            dataType: 'json',
                success:  function(data) {
                    if (data.status==true) {
                    	
                    	window.location.reload();
                    }else{
                    	alert(data.message);
                    }
                },
                error: function(x, t, m) {
                      
               }
        });
	  	// body...
	  }

</script>
