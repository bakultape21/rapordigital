<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Table <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url.'/show_add' ?>" data-permission="w" class="ajaxify btn btn-icon btn-brand btnAction" aria-haspopup="true">
					<i class="fa fa-plus"></i>
				</a>
				<a href="<?php echo $url ?>" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
				<thead>
					<tr class="header">
						<th width="30px">No.</th>
						<th>Nomor Urut Elemen</th>
						<th>Elemen</th>
						<th>Kelmpok</th>
						<th width="120px">Actions</th>
					</tr>
					<tr class="filter">
						<td></td>
						<td></td>
						<td>
							<input type="text" name="elemen" class="form-control form-control-sm form-filter" placeholder="Elemen">
						</td>
						<td>
							<select class=" form-control-sm form-control form-filter" name="kelompok_id">
								<option value="">Pilih Kelompok</option>
							<?php foreach ($kelompok as $key => $value) : ?>
								<option value="<?= $value->kelompok_id ?>"><?= $value->nama_kelompok ?></option>
							<?php endforeach; ?>
							</select>
						</td>
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
					],
			order 	= [
						[1, "asc"]
					],
			sort 	= [0, 2, -1];

		initDT.handleRecords(url, header, order, sort);


		$('.select2-kecamatan').select2({
			width: '100%',
			placeholder: 'Pilih Kecamatan',
			allowClear: true,
			ajax: {
				url: base_url + '/fetch/get_kecamatan',
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
</script>