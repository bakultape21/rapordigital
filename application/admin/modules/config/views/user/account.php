<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">Account Information <small>update your account informaiton</small></h3>
		</div>
	</div>
	<form class="kt-form kt-form--label-right" action="<?php echo $url2.'/action_profile2'; ?>" method="post" id="form" autocomplete="off">
		<div class="kt-portlet__body">
			<div class="kt-section kt-section--first">
				<div class="kt-section__body">
					<div class="alert alert-solid-danger alert-bold fade show kt-margin-t-20 kt-margin-b-40" role="alert">
						<div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
						<div class="alert-text">
							<b>Perhatian !</b><br>
							Jangan memberitahu Username dan Password anda kepada siapapun.
						</div>
						<div class="alert-close">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="la la-close"></i></span>
							</button>
						</div>
					</div>
					<div class="row">
						<label class="col-xl-3"></label>
						<div class="col-lg-9 col-xl-6">
							<h3 class="kt-section__title kt-section__title-sm">Change Your Username & Password :</h3>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label">Username <span class="required">*</span></label>
						<div class="col-lg-9 col-xl-6">
							<input type="text" name="username" class="form-control" required value="<?php echo $record->user_name; ?>" placeholder="Username">
							<input readonly type="hidden" name="backup_username" value="<?php echo $record->user_name; ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
						<div class="col-lg-9 col-xl-6">
							<input type="password" name="password" id="password" class="form-control" value="" placeholder="New password">
							<span class="form-text text-muted">Kosongkan jika tidak ada perubahan.</span>
						</div>
					</div>
					<div class="form-group form-group-last row">
						<label class="col-xl-3 col-lg-3 col-form-label">Verify Password</label>
						<div class="col-lg-9 col-xl-6">
							<input type="password" name="verify_password" class="form-control" value="" placeholder="Verify password">
							<span class="form-text text-muted">Kosongkan jika tidak ada perubahan.</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="kt-portlet__foot">
			<div class="kt-form__actions">
				<div class="row">
					<div class="col-lg-3 col-xl-3">
					</div>
					<div class="col-lg-9 col-xl-9">
						<button type="submit" class="btn btn-success">Submit</button>&nbsp;
						<!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
					</div>
				</div>
			</div>
		</div>
	</form>
	<a href="<?php echo $url; ?>" class="ajaxify reload"></a>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form',
			rule 	= {
				verify_password : {
					equalTo: "#password"
				}
			},
			message = {};
		FormValidation.handleValidation(form, rule, message);
	});
</script>