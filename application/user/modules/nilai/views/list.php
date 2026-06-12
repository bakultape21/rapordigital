<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Table Hasil Input Kegiatan Belajar/ TP/ TK
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url.'/index/'.$id ?>" data-permission="w" class="ajaxify btn btn-brand btnAction" aria-haspopup="true">
					<i class="fa fa-plus"></i> Input TP/ TK/ Kegiatan Belajar Harian
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
						<th>Tanggal</th>
						<th>Elemen</th>
						<th>CP Belajar</th>
						<th>Kegiatan Belajar/TP/TK</th>
						<th >Actions</th>
					</tr>
					
				</thead>
				<tbody>
					<?php 
					$i=1;
					foreach ($data_kegiatan as $key) {?>
						<tr>
							<td><?= $i++; ?></td>
							<td><?= date('Y-m-d', strtotime($key->kegiatan_tanggal)); ?></td>
							<td><span class= "badge badge-secondary"><?= $key->elemen_data ?></span></td>
							<td><?=$key->capaian_belajar ?></td>
							<td><?= $key->kegiatan_belajar ?></td>
							<td>
								<a href="<?= base_url() ?>/nilai/show_edit/<?= $key->kegiatan_id ?>" data-permission="w" data-original-title="Edit" class="btn btn-sm btn-warning btn-icon-md btn-sm p-1 tooltips btnAction ajaxify" title="Edit">Edit</a>
								<button class="btn btn-danger btn-sm btn-icon-md" type="button" onclick="delete_tp('<?= $key->kegiatan_id ?>')">Hapus</button>
							</td>
						</tr>
					<?php } ?> 
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		$('#datatable_ajax').DataTable();
	});

	function delete_tp(kegiatan_id) {
		if (confirm('Apakah Anda Yakin hapus Nilai Kegiatan ini?')== true){
				$.ajax({
					url: '<?= site_url() ?>/nilai/delete_tp',
					type: 'POST',
					dataType: 'json',
					data : {kegiatan_id:kegiatan_id},
					success: function(res){

						if (res.status==true) {
							toastr.success(res.message);
						}
						location.reload();
					}
				});
		}
		
	}
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