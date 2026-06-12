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
		<form class="kt-form" id="form-action" action="<?php echo $url.'/action_edit/'.$id; ?>" autocomplete="off">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Label : <span class="required">*</span></label>
						<input type="text" required name="label" class="form-control" placeholder="Label" value="<?php echo $record->menu_label; ?>">
						<input type="hidden" name="backup_label" value="<?php echo $record->menu_label; ?>" readonly>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Link : <span class="required">*</span></label>
						<input type="text" required name="link" class="form-control" placeholder="Link" value="<?php echo $record->menu_link; ?>">
						<input type="hidden" name="backup_link" value="<?php echo $record->menu_link; ?>" readonly>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Icon (font-awesome) : <span class="required">*</span></label>
						<input type="text" required name="icon" class="form-control lowercase" placeholder="Icon" value="<?php echo $record->menu_icon; ?>">
						<span class="form-text text-muted">Masukan tanda minus ( - ) jika menu menjadi children.</span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Position : </label>
						<div class="kt-radio-inline">
							<label class="kt-radio kt-radio--solid kt-radio--brand">
								<input type="radio" value="1" checked name="position" <?php echo ($record->menu_parent == '0') ? 'checked' : ''; ?>> Parent
								<span></span>
							</label>
							<label class="kt-radio kt-radio--solid kt-radio--success">
								<input type="radio" value="0" name="position" <?php echo ($record->menu_parent !== '0') ? 'checked' : ''; ?>> Children
								<span></span>
							</label>
						</div>
					</div>
				</div>
				<div style="display: none;" id="show_parent" class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Parent : <span class="required">*</span></label>
						<select id="user_role" name="parent" class="form-control select2" placeholder="Parent">
							<option value="">Select Parent</option>
							<?php foreach ($parent as $key => $val): ?>
								<option <?php echo ($record->menu_parent == $val->menu_id) ? 'selected' : ''; ?> value="<?php echo $val->menu_id; ?>"><?php echo $val->menu_label; ?></option>
							<?php endforeach ?>
						</select>
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

		if("<?php echo $record->menu_parent; ?>" == '0') {
			$('#menu_parent').prop('required', false);
			$('#show_parent').hide();
		} else {
			$('#menu_parent').prop('required', true);
			$('#show_parent').show();
			$('.select2').select2();
		}

		$('input[name="position"]').on('click', function(e){
			var val 	= $(this).val(),
				target  = $('#show_parent'),
				target2 = $('#menu_parent');

			if(val == '0') {
				target2.prop('required', true);
				target.show();
				$('.select2').select2();
			} else {
				target2.prop('required', false);
				target.hide();
			}
		});

		$('.lowercase').on('blur', function(){
			$(this).val($(this).val().toLowerCase());
		});

		$('.no-space').on('keydown', function(e){
			if(e.which !== 32){
				return e.which;
			} else {
				return false;
			}
		});
	});
</script>