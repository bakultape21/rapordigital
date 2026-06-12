<?php
$semester=
	['2'=> 'Genap', '1'=> 'Ganjil'];
 ?>

<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Laporan Mingguan TP/TK/ Nilai Belajar
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
					<form method="post" action="<?= site_url() ?>/laporan_mingguan/action_laporan_mingguan" target="_blank">
						<div class="col-sm-6">
							<h3><label>Cetak Rekap Nilai Kegiatan/TP/TK Mingguan</label></h3>
							<div class="form-group">
								<label>Kelas Belajar</label>
								<select  class="form-control" name="kelas_id" required>
									<option >Pilih Kelas</option>
									<?php foreach ($kelas_list as $key): ?>
										<option value="<?= $key->kelas_id ?>"><?= $key->nama_kelas.' semester '.$semester[$key->semester].' Tahun '.$key->tahun; ?></option>
									<?php endforeach; ?>
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
								<label>Minggu ke-</label>
								<input type="number" name="minggu" class="form-control" autocomplete="off">
							</div>
							<div class="form-group">
								<button value="0" name="preview" class="btn btn-primary"> Preview </button>
								<!-- <button value="1" name="preview" class="btn btn-success"> Simpan & Preview</button> -->
							</div>
						</div>
					</form>
				
		<!-- 		<div class="kt-portlet__body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
							<thead>
								<tr class="header">
									<th width="30px">No.</th>
									<th>Minggu</th>
									<th>Tanggal</th>
									<th>Kelas/Semester</th>
									<th >Actions</th>
								</tr>
								<tr class="filter">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td class="text-center">
										<button class="btn btn-brand kt-btn btn-sm kt-btn--icon filter-submit"> <span> <i class="la la-search"></i> <span>Search</span> </span> </button>
										<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon filter-cancel"> <span> <i class="la la-close"></i> <span>Reset</span> </span> </button>
									</td>
								</tr>
							</thead>
							<tbody> </tbody>
						</table>
					</div>
				</div>
				 -->

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
					],
			order 	= [
						[1, "asc"]
					],
			sort 	= [0, 2, -1];

		initDT.handleRecords(url, header, order, sort);

	});
</script>
<script type="text/javascript">
	
  $( function() {
    $( ".datepicker" ).datepicker({
    	format: "yyyy-mm-dd",
    	orientation: 'bottom auto',
		autoclose: true
    });
  } );
	</script>