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
		<form class="kt-form" id="form-action" data-multipart='1' data-confirm="1" action="<?php echo $url.'/action_edit/'.$id; ?>" autocomplete="off">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Full Name : <span class="required">*</span></label>
						<input type="text" required name="fullname" class="form-control" placeholder="Full Name" value="<?php echo $record->user_full_name; ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Kabupaten : <span class="required">*</span></label>
						<select class="form-control select2" name="kabupaten_id" required >
							<option selected value="<?= $record->user_kabupaten_id ?>"><?= $record->kabupaten ?></option>
							<?php foreach($kabupaten as $key): ?>
								<option value="<?= $key->kabupaten_id ?>"><?= $key->kabupaten; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Sekolah : <span class="required">*</span></label>
						<select class="form-control select2" required multiple name="sekolah_id[]" required >
							<?php foreach($sekolah_data as $val): ?>
								<option <?=  ($val->user_id != null) ? 'selected' : '' ;?> value="<?= $val->sekolah_id ?>"><?= $val->sekolah_nama. ' - '. $val->kabupaten; ?></option>

							<?php endforeach; ?>
						
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Username : <span class="required">*</span></label>
						<input type="text" required name="username" class="form-control" placeholder="Username" value="<?php echo $record->user_name; ?>">
						<input type="hidden" readonly name="backup_username" value="<?php echo $record->user_name; ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Email : <span class="required">*</span></label>
						<input type="email" required name="email" class="form-control" placeholder="Email" value="<?php echo $record->user_email; ?>">
						<input type="hidden" readonly name="backup_email" value="<?php echo $record->user_email; ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Password :</label>
						<input id="password" type="password" name="password" class="form-control" placeholder="Password">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Verify Password :</label>
						<input type="password" name="confirm" class="form-control" placeholder="Verify Password">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Role : <span class="required">*</span></label>
						<select id="user_role" name="role" class="form-control select2" placeholder="Role" required>
							<option value="">Select Role</option>
							<?php foreach ($role as $key => $val): ?>
								<option <?php echo ($record->user_role == $val->role_id) ? 'selected' : ''; ?> value="<?php echo $val->role_id; ?>"><?php echo ($key+1).'. '.$val->role_name; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Photo : </label>
						<div class="custom-file mb-3">
							<input type="file" class="custom-file-input" name="photo">
							<label class="custom-file-label" for="photo">Choose file</label>
							<input type="hidden" readonly name="pp_upload" value="<?php echo $record->user_photo; ?>">
						</div>
					</div>
				</div>
				<div class="col-md-4 offset-md-4">
					<div style="border: 1px solid #ccc;" id="roles" class="mb-3">
						<?php v_tree_view(menu('', get_access($record->user_role))); ?>
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
			rule 	= {
				confirm : {
					equalTo: "#password"
				}
			},
			message = {};
		FormValidation.handleValidation(form, rule, message);

		$('.select2').select2();

		$("#roles").jstree({
						'plugins': ["wholerow", "types"],
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
					}).bind("ready.jstree", function(event, data) {
						$(this).jstree("open_all");
					});

		$('#user_role').on('change', function(e){
			e.preventDefault();
			var id = $(this).val();

			$('#roles').html('');
			$('#roles').jstree("destroy");

			if(id !== '') {
				$.ajax({
					url: base_url+'config/user/get_treeview',
					data: {id: id},
					type: 'post',
					dataType: 'html',
					success: function(data) {
						$('#roles').html(data);
					}
				}).done(function(){
					$("#roles").jstree({
						'plugins': ["wholerow", "types"],
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
					}).bind("ready.jstree", function(event, data) {
						$(this).jstree("open_all");
					});
				});
			} else {
				$('#roles').jstree();
			}
		});
	});
</script>
