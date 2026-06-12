<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Table <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
				<thead>
					<tr class="header">
						<th width="30px">No.</th>
						<th>Nama Guru</th>
						<th>Email</th>
						<th>Kelas</th>
						<th>Total Siswa</th>
						<th>Tahun/Semester</th>
						<th>Nama Sekolah</th>
						<th width="120px">Actions</th>
					</tr>
					<tr class="filter">
						<td></td>
						<td>
							<input type="text" name="guru_nama" class="form-control form-control-sm form-filter" placeholder="Nama Guru">
						</td>
						<td></td>
						<td>
							<input type="text" name="nama_kelas" class="form-control form-control-sm form-filter" placeholder="Nama Kelas">
						</td>
						<td></td>
						<td></td>
						<td>
							<select name="sekolah_id" class="form-control form-filter form-control-sm select-filter select2-sekolah" placeholder="Sekolah">
								<option value="">Sekolah ...</option>
								
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
						null,
						null,
						null,
					],
			order 	= [
						[1, "asc"]
					],
			sort 	= [0, 5, -1];

		initDT.handleRecords(url, header, order, sort);


		$('.select2-sekolah').select2({
			width: '100%',
			placeholder: 'Pilih Sekolah',
			allowClear: true,
			ajax: {
				url: base_url + '/fetch/get_sekolah',
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
	function hapus(kelas_id) {
		var cek = confirm("Anda Yakin Hapus Data ini?");

		if (cek==1) {

			$.ajax({
				url: '<?= $url ?>/delete_kelas',
				type: 'POST',
				dataType: 'json',
				data : { kelas_id:kelas_id},
				success: function(res){
					if (res.status==0) {

						toastr.warning(res.message);
						$('#datatable_ajax').DataTable().ajax.reload();
					}else{
						toastr.success(res.message);
						$('#datatable_ajax').DataTable().ajax.reload();
					}
					
				}
			});
		}
	}
</script>