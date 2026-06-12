<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Table <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a data-toggle="modal" href="#static" class="btn btn-icon btn-brand btnAction" data-permission="w" ><i class="fa fa-plus"></i></a>
				<a href="<?php echo $url ?>" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="table-responsive">
			<table id="datatable_ajax" class="table table-bordered table-hover">
				<thead>
					<tr class="header">
						<th width="30px">No.</th>
						<th>Name</th>
						<th>Link</th>
						<th width="100px">Status</th>
						<th width="150px">Actions</th>
					</tr>
					<tr class="filter">
						<td></td>
						<td>
							<input type="text" name="name" class="form-control form-control-sm form-filter" placeholder="Name">
						</td>
						<td>
							<input type="text" name="link" class="form-control form-control-sm form-filter" placeholder="Link">
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
	<a href="<?php echo base_url(); ?>config/menu/additional_link" class="ajaxify reload"></a>
</div>

<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Form Add</h4>
				<button type="button" onClick="form_reset('form-add');" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<form action="<?= base_url(); ?>config/menu/action_add_additional_link" class="form-horizontal form-add" role="form" method="POST">
				<div class="modal-body">
					<div class="form-body">
						<div class="form-group form-md-line-input">
							<label class="col-md-3 control-label"> Name
								<span class="required">*</span>
							</label>
							<div class="col-md-8">
								<input type="text" class="form-control" placeholder="Name" required name="name" value="">
								<span class="help-block"></span>
								<div class="form-control-focus"> </div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-3 control-label"> Link
								<span class="required">*</span>
							</label>
							<div class="col-md-8">
								<input type="text" class="form-control no-space lowercase" placeholder="Link" required name="link">
								<span class="help-block"></span>
								<div class="form-control-focus"> </div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Save</button>
					<button type="button" onClick="form_reset('form-add');" data-dismiss="modal" class="btn btn-danger">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="static2" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Form Edit</h4>
				<button type="button" onClick="form_reset('form-edit');" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<form action="<?= base_url(); ?>config/menu/action_edit_additional_link" data-confirm="1" class="form-horizontal form-edit" role="form" method="POST" >
				<div class="modal-body">
					<div class="form-body">
						<input type="hidden" name="id" value="" readonly>
						<input type="hidden" name="backup_name" value="" readonly>
						<input type="hidden" name="backup_link" value="" readonly>
						<div class="form-group form-md-line-input">
							<label class="col-md-3 control-label"> Name
								<span class="required">*</span>
							</label>
							<div class="col-md-8">
								<input type="text" class="form-control" placeholder="Name" required name="name">
								<span class="help-block"></span>
								<div class="form-control-focus"> </div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label class="col-md-3 control-label"> Link
								<span class="required">*</span>
							</label>
							<div class="col-md-8">
								<input type="text" class="form-control no-space lowercase" placeholder="Link" required name="link">
								<span class="help-block"></span>
								<div class="form-control-focus"> </div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Save</button>
					<button type="button" onClick="form_reset('form-edit');" data-dismiss="modal" class="btn btn-danger">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var url 	= '<?php echo base_url(); ?>config/menu/select_additional_link';
			header 	= [
						{ "sClass": "text-center" },
						null,
						null,
						{ "sClass": "text-center" },
						{ "sClass": "text-center" }
					],
			order 	= [
						[1, "asc"]
					],
			sort 	= [0, -1];

		initDT.handleRecords(url, header, order, sort);

		var form 	= '.form-add',
			rule 	= {},
			message = {};
		FormValidation.handleValidation(form, rule, message);

		var rule2    = {};
		var message2 = {};
		var title2   = 'Confirmation';
		var text2    = 'Are you sure to continue this action?';
		var form2    = '.form-edit';
		FormValidation.handleValidation(form2, rule2, message2, title2, text2);
	});

	function edit_al(param, e) {
		e.preventDefault();

		var $this = $(param),
			form  = $('.form-edit');

		$.post($this.attr('href'), function(data) {
			form.find('[name="id"]').val(data[0].al_id);
			form.find('[name="name"]').val(data[0].al_name);
			form.find('[name="link"]').val(data[0].al_link);
			form.find('[name="backup_name"]').val(data[0].al_name);
			form.find('[name="backup_link"]').val(data[0].al_link);
		}, 'json');

		$('#static2').modal('show');
	}

	function form_reset(param) {
		$('.'+param)[0].reset();
	}
</script>