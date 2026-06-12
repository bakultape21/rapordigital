<?php
$semester=
	['2'=> 'Genap', '1'=> 'Ganjil'];
 ?>

<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Hasil Karya 
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				
				<a href="<?php echo site_url() ?>/" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i> Kembali
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
			<div class="col-md-12">
					<form>
						<div class="form-group">
								<label>Kelas Belajar</label>
								<select onchange="get_siswa(this)"  class="form-control select2" name="kelas_id" id="kelas_id" required>
									<option >Pilih Kelas</option>
									<?php foreach ($kelas_list as $key): ?>
										<option value="<?= $key->kelas_id ?>"><?= $key->nama_kelas.' semester '.$semester[$key->semester].' Tahun '.$key->tahun; ?></option>
									<?php endforeach; ?>
								</select>
						</div>
						<div class="form-group">
								<label>Siswa</label>
								<select  class="form-control select2-siswa" name="siswa_kelas_id" id="siswa_kelas_id" required>
									<option >Pilih Siswa</option>
								</select>
						</div>
							<div class="form-group">
								<label> Tanggal </label>
								<input type="text" id="awal" name="awal" value="<?= date('Y-m-d') ?>" class="form-control datepicker" autocomplete="off">
							</div>
						<!-- 	<div class="form-group">
								<label>Sampai Tanggal Tanggal</label>
								<input type="text" id="akhir" name="akhir" value="<?= date('Y-m-d') ?>" class="form-control datepicker" autocomplete="off">
							</div> -->
							<div class="form-group">
								<button type="button" onclick="get_form()" class="btn btn-success btn-sm">Tampilkan Form</button>
							</div>
					</form>

					
				
				<div class="kt-portlet__body">
					<h3>Hasil Karya</h3>
					<form class="kt-form" id="form-action" data-reload="1" enctype='multipart/form-data' data-confirm="1" data-multipart='1' action="<?php echo $url; ?>/save_data" autocomplete="off">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Kelas</label>
									<input type="text" class="form-control" id="nama_kelas" readonly >
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>No Induk</label>
									<input type="text" class="form-control" id="no_induk" readonly>
								</div>
								<div class="form-group">
									<label>Nama</label>
									<input type="text" class="form-control" id="nama_lengkap" readonly >
									<input type="hidden" name="siswa_kelas_id" id="siswa_kelas_id_a">
								</div>
								<div class="form-group">
									<label>Hasil Karya</label>
									<input type="file" name="logo">
								</div>
							</div>
							
						</div>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="10%">Tanggal</th>
									<th width="25%">Judul Karya </th>
									<th width="35%">Pengamatan</th>
									<th width="25%">Capaian Belajar</th>
								</tr>
							</thead>
							<tbody id="id_form_add">
								
								
							</tbody>
						</table>
					<div class="form-group">
						<button class="btn btn-primary btn-sm">Submit</button>
					</div>
					</form>
				</div>
				

			</div>
			
		</div>
	</div>
</div>
<a href="<?php echo $url; ?>/" class="ajaxify reload"></a>


<script type="text/javascript">
		jQuery(document).ready(function() {
		

});

		jQuery(document).ready(function() {
		var url 	= '<?php echo $url ?>/select/';
			header 	= [
						{ "sClass": "text-center" },
						null,
						null,
						null,
						null,
						null,
						null,
					],
			order 	= [
						[1, "asc"]
					],
			sort 	= [0, 2, -1];

		initDT.handleRecords(url, header, order, sort);

	});
</script>
<script type="text/javascript">

	function get_form() {
		var kelas_id= $('#kelas_id').val();
		var siswa_kelas_id= $('#siswa_kelas_id').val();
		var awal= $('#awal').val();
		var akhir = $('#akhir').val();


				$.ajax({
				url: '<?= site_url() ?>/hasil_karya/get_form',
				type: 'POST',
				dataType: 'json',
				data : {kelas_id:kelas_id, siswa_kelas_id:siswa_kelas_id, awal: awal, akhir: akhir},
				success: function(res){
						$('#id_form_add').empty();
						$('#id_form_add').append(res.html);
						document.getElementById('nama_lengkap').value=res.data_siswa.nama_lengkap;
						document.getElementById('no_induk').value=res.data_siswa.no_induk;
						document.getElementById('nama_kelas').value=res.data_siswa.nama_kelas;
						document.getElementById('siswa_kelas_id_a').value= res.data_siswa.siswa_kelas_id;


						var form 	= '#form-action',
						rule 	= {
							
						},
						message = {};
						FormValidation.handleValidation(form, rule, message);
				}
			});
	}

		function get_siswa(va){
			var kelas_id= $('#kelas_id').val();

				$('.select2-siswa').select2({
					width: '100%',
					placeholder: 'Pilih Siswa',
					allowClear: true,
					ajax: {
						url: base_url + '/fetch/get_siswa_kelas/'+kelas_id,
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
		}

	
  $( function() {
    $( ".datepicker" ).datepicker({
    	format: "yyyy-mm-dd",
    	orientation: 'bottom auto',
		autoclose: true
    });

    $('.select2').select2({});

  } );


 





	</script>