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
				<a href="<?php echo $url.'/show_list_menu' ?>" class="ajaxify btn btn-success btnAction" aria-haspopup="true" data-permission="w">
					<i class="fas fa-list"></i> List Menu
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
						<th>Label</th>
						<th>URL</th>
						<th>Icon</th>
						<th width="100px">Status</th>
						<th width="150px">Actions</th>
					</tr>
					<tr class="filter">
						<td></td>
						<td>
							<input type="text" name="label" class="form-control form-control-sm form-filter" placeholder="Label">
						</td>
						<td>
							<input type="text" name="link" class="form-control form-control-sm form-filter" placeholder="URL">
						</td>
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
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var url 	= '<?php echo $url ?>/select';
			header 	= [
						{ "sClass": "text-center" },
						null,
						null,
						{ "sClass": "text-center" },
						{ "sClass": "text-center" },
						{ "sClass": "text-center" }
					],
			order 	= [
						[1, "asc"]
					],
			sort 	= [0, 3, -1];

		initDT.handleRecords(url, header, order, sort);
	});
</script>