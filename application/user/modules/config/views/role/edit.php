<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url; ?>/show_edit/<?php echo $id; ?>" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<form class="kt-form" id="form-action" data-confirm="1" action="<?php echo $url.'/action_edit/'.$id; ?>" autocomplete="off">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nama : <span class="required">*</span></label>
						<input type="text" required name="name" class="form-control" placeholder="Name" value="<?php echo $record->role_name; ?>">
						<input type="hidden" name="backup_name" value="<?php echo $record->role_name; ?>" readonly>
					</div>
					<div class="form-group">
						<label class="form-control-label">Permission : </label>
						<div class="kt-checkbox-inline">
							<label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
								<input type="checkbox" value="r" name="read" <?php echo (strpos($record->role_permission, 'r') !== false) ? 'checked' : ''; ?>> Read
								<span></span>
							</label>
							<label class="kt-checkbox kt-checkbox--solid kt-checkbox--success">
								<input type="checkbox" value="w" name="write" <?php echo (strpos($record->role_permission, 'w') !== false) ? 'checked' : ''; ?>> Edit
								<span></span>
							</label>
							<label class="kt-checkbox kt-checkbox--solid kt-checkbox--danger">
								<input type="checkbox" value="d" name="delete" <?php echo (strpos($record->role_permission, 'd') !== false) ? 'checked' : ''; ?>> Delete
								<span></span>
							</label>
						</div>
					</div>
					<div style="display: none;">
						<textarea required readonly name="access" id="inputTree"><?php echo $record->role_access; ?></textarea>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label class="form-control-label">Menu : </label>
						<br>
						<button type="button" onclick="jstreeSelect(true);" class="btn btn-sm btn-brand"><i class="icon-check"></i> Select All</button>
						<button type="button" onclick="jstreeSelect(false);" class="btn btn-sm btn-danger"><i class="icon-close"></i> Deselect All</button>
					</div>
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3">
						<?php v_tree_view(menu('all'), $record->role_access); ?>
					</div>
				</div>
				<div class="col-md-12 text-center">
					<a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Back</a>
					<button type="submit" class="btn btn-brand btn-elevate btn-square">Save</button>
				</div>
			</div>
		</form>
	</div>
	<a href="<?php echo $url?>/show_edit/<?php echo $id; ?>" class="ajaxify reload"></a>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {},
			message = {};
		FormValidation.handleValidation(form, rule, message);

		$("#roles").jstree({
			'plugins': ["wholerow", "types", "checkbox"],
			'core': {
				"themes" : {
					"responsive": false
				},
			},
			"types" : {
				"default" : {
								"icon" : "fa fa-folder kt-font-warning"
							},
				"file" : {
							"icon" : "fa fa-file  kt-font-warning"
						}
			},
		}).bind("ready.jstree", function(e, data) {
			$(this).jstree("open_all");
		}).on("changed.jstree", function(e, data) {
			var datas = $(this).jstree().get_selected(true);
			var selKeys = $.map(datas, function(node){
				// console.log(node);
				var id_c = [node.id],
					id_p = node.parents;

				return id_c.concat(id_p);
			});

			const distinct = (value, index, self) => {
				return self.indexOf(value) === index;
			}

			var unique = selKeys.filter(distinct);

			$("#inputTree").html(unique.join(", ").replace(/id_node_/g, ''));
		});
	});

	function jstreeSelect(status) {
		if (status == true) {
			$("#roles").jstree().select_all(true);

			var datas = $("#roles").jstree().get_selected(true);
			var selKeys = $.map(datas, function(node){
				// console.log(node);
				var id_c = [node.id],
					id_p = node.parents;

				return id_c.concat(id_p);
			});

			const distinct = (value, index, self) => {
				return self.indexOf(value) === index;
			}

			var unique = selKeys.filter(distinct);

			$("#inputTree").html(unique.join(", ").replace(/id_node_/g, ''));
		} else {
			$("#roles").jstree().deselect_all(true);

			$("#inputTree").html('');
		}

		return true;
	}
</script>