<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">Personal Information <small>update your personal informaiton</small></h3>
		</div>
	</div>
	<form class="kt-form kt-form--label-right" action="<?php echo $url2.'/action_profile'; ?>" method="post" id="form" data-multipart="1" data-confirm="1" data-reload="1" autocomplete="off">
		<div class="kt-portlet__body">
			<div class="kt-section kt-section--first">
				<div class="kt-section__body">
					<div class="row">
						<label class="col-xl-3"></label>
						<div class="col-lg-9 col-xl-6">
							<h3 class="kt-section__title kt-section__title-sm">Information :</h3>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label">Avatar</label>
						<div class="col-lg-9 col-xl-6">
							<div class="kt-avatar kt-avatar--outline" id="kt_user_avatar">
								
								<?php if ($record->user_photo == '' || $record->user_photo == null) : ?>
									<div class="kt-avatar__holder" style="background-image: url(<?php echo base_url(); ?>assets/media/users/default.jpg)"></div>
								<?php else : ?>
									<div class="kt-avatar__holder" style="background-image: url(<?php echo base_url().$record->user_photo; ?>)"></div>
								<?php endif; ?>
								
								<label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
									<i class="fa fa-pen"></i>
									<input type="file" name="pp_upload">
								</label>
								<span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
									<i class="fa fa-times"></i>
								</span>
							</div>
							<input type="hidden" readonly name="backup_pp_upload" value="<?php echo $record->user_photo; ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label">Full Name <span class="required">*</span></label>
						<div class="col-lg-9 col-xl-6">
							<input class="form-control" name="full_name" required placeholder="Full Name" type="text" value="<?php echo $record->user_full_name; ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label">Address <span class="required">*</span></label>
						<div class="col-lg-9 col-xl-6">
							<textarea name="address" placeholder="Address" required class="form-control" style="resize: vertica;" rows="6"><?php echo $record->user_address; ?></textarea>
						</div>
					</div>
					<div class="row">
						<label class="col-xl-3"></label>
						<div class="col-lg-9 col-xl-6">
							<h3 class="kt-section__title kt-section__title-sm">Contact Info:</h3>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label">Contact Phone <span class="required">*</span></label>
						<div class="col-lg-9 col-xl-6">
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
								<input type="text" name="phone" required class="form-control" value="<?php echo $record->user_phone; ?>" placeholder="Phone" aria-describedby="basic-addon1">
							</div>
							<span class="form-text text-muted"></span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-3 col-lg-3 col-form-label">Email Address <span class="required">*</span></label>
						<div class="col-lg-9 col-xl-6">
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
								<input type="text" name="email" required class="form-control" value="<?php echo $record->user_email; ?>" placeholder="Email" aria-describedby="basic-addon1">
								<input readonly type="hidden" name="backup_email" value="<?php echo $record->user_email; ?>">
							</div>
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

<script src="<?php echo base_url(); ?>../assets/js/pages/custom/user/profile.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form',
			rule 	= {},
			message = {};
		FormValidation.handleValidation(form, rule, message);
	});
</script>