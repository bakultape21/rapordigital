<?php
$semester=
	['2'=> 'Genap', '1'=> 'Ganjil'];
 ?>

<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Laporan Harian TP/TK/ Nilai Belajar
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				
				<a href="<?php echo $url ?>" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
			<div class="col-md-12">
					<form method="post" action="<?= site_url() ?>/laporan_harian/action_laporan_harian" target="_blank">
						<div class="col-sm-6">
							<h3><label>Cetak Rekap Nilai Kegiatan/TP/TK Harian</label></h3>
							<div class="form-group">
								<label>Kelas Belajar</label>
								<select onchange="cek_tanggal(this)"  class="form-control" name="kelas_id" id="kelas_id" required>
									<option >Pilih Kelas</option>
									<?php foreach ($kelas_list as $key): ?>
										<option value="<?= $key->kelas_id ?>"><?= $key->nama_kelas.' semester '.$semester[$key->semester].' Tahun '.$key->tahun; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label>Pilih Tanggal</label>
								<input type="text" id="tanggal" onchange="cek_tanggal(this)" name="tanggal" class="form-control datepicker" autocomplete="off">
							</div>
							<div class="form-group">
								<button class="btn btn-primary" id="button_cetak" disabled> Cetak Harian</button>
							</div>
						</div>
					</form>
				
				<div class="kt-portlet__body">
					
				</div>
				

			</div>
			
		</div>
	</div>
</div>


<script type="text/javascript">
		jQuery(document).ready(function() {
		
			$('.select2-cp').select2({
			width: '100%',
			placeholder: 'Pilih CP',
			allowClear: true,
			ajax: {
				url: base_url + '/fetch/get_cp/<?= $kelas_id; ?>',
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
		var url 	= '<?php echo $url ?>/select/<?= $kelas_id ?>';
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


		function cek_tanggal(va){
			var tanggal= $('#tanggal').val();
			var kelas_id= $('#kelas_id').val();

				$.ajax({
				url: '<?= site_url() ?>/laporan_harian/cek_tanggal',
				type: 'POST',
				dataType: 'json',
				data : {tanggal:tanggal, kelas_id:kelas_id},
				success: function(res){

					if (res.status==2) {

						toastr.warning(res.message);
						document.getElementById("button_cetak").setAttribute("disabled","disabled");
					}else{
						document.getElementById('button_cetak').removeAttribute("disabled");
						toastr.success(res.message);
					}
					
				}
			});
		}

	
  $( function() {
    $( ".datepicker" ).datepicker({
    	format: "yyyy-mm-dd",
    	orientation: 'bottom auto',
		autoclose: true
    });
  } );




	</script>