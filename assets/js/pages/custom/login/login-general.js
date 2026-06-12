"use strict";

// Class Definition
var KTLoginGeneral = function() {

	var login = $('#kt_login');

	var showMsg = function(form, type, msg) {
		var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
			<div class="alert-text">'+msg+'</div>\
			<div class="alert-close">\
				<i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
			</div>\
		</div>');

		form.find('.alert').remove();
		alert.prependTo(form);
		//alert.animateClass('fadeIn animated');
		KTUtil.animateClass(alert[0], 'fadeIn animated');
		alert.find('span').html(msg);
	}

	// Private Functions

	var handleSignInFormSubmit = function() {
		$('#kt_login_signin_submit').click(function(e) {
			e.preventDefault();
			var btn = $(this);
			var form = $(this).closest('form');
			var act = form.attr('action');
			var met = form.attr('method');

			form.validate({
				rules: {
					username: {
						required: true,
					},
					password: {
						required: true
					}
				}
			});

			if (!form.valid()) {
				return;
			}

			btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

			form.ajaxSubmit({
				url: act,
				method: met,
				dataType: 'json',
				success: function(response, status, xhr, $form) {
					if (response.status == '1') {
						showMsg(form, 'success', response.message);

						setTimeout(function(){
							location.reload();
						}, 1000);
					} else {
						btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
						showMsg(form, 'danger', response.message);
					}
				}
			});
		});
	}

	// Public Functions
	return {
		// public functions
		init: function() {
			handleSignInFormSubmit();
		}
	};
}();

// Class Initialization
jQuery(document).ready(function() {
	KTLoginGeneral.init();
});
