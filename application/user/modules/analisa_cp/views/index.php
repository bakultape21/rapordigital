<?php
$semester=
	['2'=> 'Genap', '1'=> 'Ganjil'];
 ?>

<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Ceklist Analisa Capaian Belajar 
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				
				<a href="<?php echo site_url() ?>/analisa_cp" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i> Kembali
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
			<div class="col-md-12">
				
				<div class="kt-portlet__body">
					<h3>Cetak Ceklist Analisa Capaian</h3>
					<form target="_blank" method="post" action="<?= base_url() ?>/analisa_cp/cetak">
						<div class="form-group">
								<label>Kelas Belajar</label>
								<select onchange="get_siswa(this)"  class="form-control" name="kelas_id" id="kelas_id" required>
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
								<label>Dari Tanggal Tanggal</label>
								<input type="text" name="awal" value="<?= date('Y-m-d', strtotime('-7 days')) ?>" class="form-control datepicker" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Sampai Tanggal Tanggal</label>
								<input type="text" name="akhir" value="<?= date('Y-m-d') ?>" class="form-control datepicker" autocomplete="off">
							</div>
							<div class="form-group">
								<button class="btn btn-success btn-sm">Cetak</button>
							</div>
					</form>
				</div>

				

			</div>
			
		</div>
	</div>
</div>


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