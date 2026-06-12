<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Table <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
				<thead>
					<tr class="header">
						<th width="30px">No.</th>
						<th>Tanggal</th>
						<th>Nama Siswa</th>
						<th>Kelas Semester</th>
						<th>Hasil Pengamatan</th>
						<th >Actions</th>
					</tr>
					<tr class="filter">
						<td></td>
						<td></td>
						<td></td>
						<td><select name="kelas_id" class="form-control form-control-sm form-filter">
								<option value="">Pilih Kelas</option>
								<?php foreach ($kelas_list as $key => $value) :?>
									<option value="<?= $value->kelas_id ?>"><?= $value->nama_kelas.' - '.$value->tahun.' semester' ?><?= ($value->semester== 1)? 'Ganjil': 'Genap'; ?></option>
								<?php endforeach; ?>
							</select>
						</td>
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
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var url 	= '<?php echo $url ?>/select';
			header 	= [
						{ "sClass": "text-center" },
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