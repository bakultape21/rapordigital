<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Table Capaian Belajar
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				
				<a href="<?php echo $url ?>" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i> Kembali
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<form class="kt-form" id="form-action"  data-multipart='1' action="<?php echo $url_action; ?>" autocomplete="off">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label class="form-control-label">Jenis CP : <span class="required">*</span></label>
						<select class="form-control" name="capaian_jenis" required >
							<option value="">Pilih Jenis</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<?php if (@$id !=null) :?>
								<option value="<?= $capaian_belajar[0]->capaian_jenis ?>" selected><?= $capaian_belajar[0]->capaian_jenis ?></option>
							<?php endif; ?>
							
						</select>
					</div>
					<input type="hidden" name="id" value="<?= @$id; ?>">
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Capaian Nomor : <span class="required">*</span></label>
						<input type="text" required name="capaian_nomor" value="<?= @$capaian_belajar[0]->capaian_nomor ?>" class="form-control" placeholder="Nomor">
						<input type="hidden" name="elemen_id" value="<?= $elemen_id; ?>">
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<label class="form-control-label">Capaian Belajar : <span class="required">*</span></label>
						<textarea class="form-control" name="capaian_belajar" required><?= @$capaian_belajar[0]->capaian_belajar ?></textarea>
					</div>
				</div>
				<div class="col-md-12 text-center">
					<button type="submit" class="btn btn-brand btn-elevate btn-square">Save</button>
				</div>
			</div>
		</form>
	</div>
	<a href="<?php echo $url; ?>/add_cp/<?= $elemen_id; ?>" class="ajaxify reload"></a>
	<div class="kt-portlet__body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
				<thead>
					<tr class="header">
						<th width="30px">No.</th>
						<th>Capaian Nomor</th>
						<th>Capaian Belajar</th>
						<th>Jenis</th>
						<th width="120px">Actions</th>
					</tr>
					<tr class="filter">
						<td></td>
						<td></td>
						<td></td>
						<td>
							<select  name="capaian_jenis" class="form-control form-control-sm form-filter">
								<option value="">All</option>
								<option value="A">A</option>
								<option value="B">B</option>
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
		$("#datatable_ajax").dataTable().fnDestroy();

		var form 	= '#form-action',
			rule 	= {
				password: "required",
				confirm : {
					equalTo: "#password"
				}
			},
			message = {};
		FormValidation.handleValidation(form, rule, message);
		


		var url 	= '<?php echo $url ?>/select_cp/<?= $elemen_id ?>';
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