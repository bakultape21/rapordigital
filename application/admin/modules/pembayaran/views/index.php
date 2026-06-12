<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Table <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<!-- <a href="<?php echo $url.'/show_add' ?>" data-permission="w" class="ajaxify btn btn-icon btn-brand btnAction" aria-haspopup="true">
					<i class="fa fa-plus"></i>
				</a>
				<a href="<?php echo $url ?>" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formCetak">Cetak
				</button> -->
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
						<th>NPSN</th>
						<th>Kabupaten</th>
						<th>Waktu Pembayaran</th>
						<th >Nominal Pembayaran</th>
						<th >Bukti Bayar</th>
						<th>Status</th>
						<th >Actions</th>
					</tr>
					<tr class="filter">
						<td></td>
						<td>
							<input type="text" name="guru_nama" class="form-control form-control-sm form-filter" placeholder="nama Guru">
						</td>
						<td>
							<input type="text" name="npsn" class="form-control form-control-sm form-filter" placeholder="npsn">
						</td>
						<td>
							<select name="kabupaten_id" class="form-control form-filter form-control-sm select-filter select2-kabupaten" placeholder="Kabupaten">
								<option value="">Kabupaten ...</option>
								
							</select>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td>
							<select name="status" class="form-control form-filter form-control-sm select-filter select2-status">
								<option value=''>All</option>
								<option value ='0'>Menunggu Konfirmasi</option>
								<option value ='1'>Dikonfirmasi</option>
								<option value= '2'>Di tolak</option>
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
						{ "sClass": "text-center" },
						{ "sClass": "text-center" },
						{ "sClass": "text-center" }
					],
			order 	= [
						[1, "asc"]
					],
			sort 	= [0, 5, -1];

		initDT.handleRecords(url, header, order, sort);


		$('.select2-kabupaten').select2({
			width: '100%',
			placeholder: 'Pilih Kabupaten',
			allowClear: true,
			ajax: {
				url: base_url + '/fetch/get_kabupaten',
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
	function tolak(id) {
		var cek = confirm("Anda Yakin Tolak Pembayaran?");

		if (cek==1) {

			$.ajax({
				url: '<?= $url ?>/tolak',
				type: 'POST',
				dataType: 'json',
				data : { id:id},
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
	function terima(id) {
		var cek = confirm("Anda Yakin Terima Pembayaran?");

		if (cek==1) {

			$.ajax({
				url: '<?= $url ?>/terima',
				type: 'POST',
				dataType: 'json',
				data : { id:id},
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
	  $( function() {
    $( ".datepicker" ).datepicker({
    	format: "yyyy-mm-dd",
    	orientation: 'bottom auto',
		autoclose: true
    });
  } );
</script>