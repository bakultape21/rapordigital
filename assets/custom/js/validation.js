var FormValidation = function() {
	return {
		handleValidation : function( form_target, rule, message, title, text ) {
			var form_input 	 	= $(form_target);
			var form_action  	= form_input.attr('action');
			var form_confirm 	= form_input.attr('data-confirm');
			var form_multipart 	= form_input.attr('data-multipart');
			var form_reload 	= form_input.attr('data-reload');
			var redirect 		= form_input.attr('data-redirect');

			var link_redirect 		= form_input.attr('data-link');
			var upload_archive 	= form_input.attr('data-archive');


			var data_multiple 	= form_input.attr('data-multiple');

			var form_print 		= form_input.attr('data-print'); //0 or 1
			var link_print		= form_input.attr('data-linkcetak'); // link cetak
			var title 		 	= (typeof title !== 'undefined') ? title : 'Are you sure ?';
			var text 		 	= (typeof text !== 'undefined') ? text : '';
			var files 			= {};

			$('input[type=file]').on('change', prepareUpload);
			$(".custom-file-input").on("change", function() {
				var fileName = $(this).val().split("\\").pop();

				if(fileName == '') {
					fileName = 'Choose file';
				}

				$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
			});

			form_input.validate({
				errorElement 	: 'div',
				errorClass 		: 'error invalid-feedback',
				focusInvalid	: false,
				message 		: message,
				rules 			: rule,

				invalidHandler	: function(event, validator) {
									KTUtil.scrollTo(null, 0, 600);
								},

				// errorPlacement	: function(error, element) {
				// 					if(!element.hasClass('select2')) {
				// 						error.insertAfter(element);
				// 					} else {
				// 						let p = element.parent('div').find('.help-block');
				// 						error.insertAfter(p);
				// 					}
				// 				},

				// highlight 		: function(element) {
				// 					$(element).closest('.form-group').addClass('has-error');
				// 					$(element).closest('.form-group').find('input.form-control').addClass('is-invalid');
				// 				},

				// unhighlight 	: function(element) {
				// 					$(element).closest('.form-group').removeClass('has-error');
				// 					$(element).closest('.form-group').find('input.form-control').removeClass('is-invalid');
				// 				},

				// success			: function(label) {
				// 					label.closest('.form-group').removeClass('has-error');
				// 					label.closest('.form-group').find('input.form-control').removeClass('is-invalid');
				// 				},

				submitHandler 	: function(form) {
									localStorage.removeItem('unique_code');

									if(typeof form_confirm !== 'undefined' && form_confirm == 1) {
										Swal.fire({
											title				: title,
											text 				: text,
											type 				: 'warning',
											showCancelButton 	: true,
											confirmButtonColor	: '#3085d6',
											confirmButtonText 	: 'Yes',
											cancelButtonColor 	: '#d33',
											cancelButtonText 	: 'Cancel'
										}).then((result) => {
											if (result.value) {
												KTApp.blockPage({overlayColor:"#000000",type:"v2",state:"success",message:"Please wait..."});
												
												form_submit(form);
											} else {
												KTUtil.scrollTo(null, 0, 600);
											}
										});
									} else {
										KTApp.blockPage({overlayColor:"#000000",type:"v2",state:"success",message:"Please wait..."});
										
										form_submit(form);
									}
								},
			});

			function form_submit(form) {
				var the 	= $(form),
					datas 	= new FormData(),
					input 	= the.serializeArray(),
					action 	= the.attr('action');

				if (data_multiple !== 'undefined' && data_multiple == '1') {
					var totalfiles = document.getElementById('files_multi').files.length;

				   for (var index = 0; index < totalfiles; index++) {
				      datas.append("files[]", document.getElementById('files_multi').files[index]);
				   }

				   $.each(files, function(k, v) {
						datas.append(k, v[0]);
					});

				   // alert('cek multi');
				
				}else{
					// alert('cek');
					if(typeof form_multipart !== 'undefined' && form_multipart == 1) {
						$.each(files, function(k, v) {
							datas.append(k, v[0]);
						});
					}
				}

				

				$.each(input, function(i, v){
					datas.append(v.name, v.value);
				});
				
				$.ajax({
					url 			: action,
					type 			: 'POST',
					data 			: datas,
					cache 			: false,
					dataType		: 'json',
					processData		: false,
					contentType		: false,
					success 		: function(res, status, xhr) {
										callback_form(res, status, xhr, the, form_print, link_print);
										
										
									 },
					error 			: function(jqXHR, textStatus, errorThrown) {
										callback_error();
									 }
				}).done(function(e){
					KTApp.unblockPage();
				});
				
			}

			function callback_form(res, statusText, xhr, $form,  form_print, link_print){
				if(res.status == 1){
					toastr.success(res.message);

					if(typeof res.unique_code !== 'undefined') {
						localStorage.unique_code = res.unique_code;
					}

					if(typeof res.reload_data !== 'undefined') {
						hermes.send('reload_data', true);
					}
					if(typeof redirect !== 'undefined' && redirect == 1) {
						
						location.href = link_redirect;
					} else {
						if($('.reload').length) {
							$('.reload').trigger('click');
						}

						$('.modal-backdrop').remove();
					}

					if(typeof form_reload !== 'undefined' && form_reload == 1) {
						location.reload(true);
					} else {
						if($('.reload').length) {
							$('.reload').trigger('click');
						}

						$('.modal-backdrop').remove();
					}
					if (form_print ==1) {
						window.open(link_print+res.id,'_blank');
					}

					files = {};
				}else if(res.status == 0 || res.status == 2){
					toastr.error(res.message);

					KTUtil.scrollTo(null, 0, 600);
				}else{
					toastr.warning(res.message);

					KTUtil.scrollTo(null, 0, 600);
				}
			}

			function callback_error(){
				toastr.error('Something wrong !');
				KTApp.unblockPage();
			}

			function prepareUpload(event) {
				let files_target = event.target;

				let key 	= $(files_target).attr('name'),
					file 	= files_target.files,
					ext 	= ['xlsx','xls','pdf','jpeg', 'jpg', 'png', 'gif', 'doc', 'docx'],
					max 	= 5000000;

				if(typeof upload_archive !== 'undefined' && upload_archive == 1) {
					ext 	= ['xlsx','xls','pdf','jpeg', 'jpg', 'png', 'gif', 'doc', 'docx', 'rar', 'zip', 'tar', '7z'];
					max 	= 500000000;
				}

				if(file.length > 0) {
					if ($.inArray($(files_target).val().split('.').pop().toLowerCase(), ext) !== -1 && file[0].size <= max) {
						files[key] = file;
					} else {
						$(files_target).val('');
						let target = $(files_target).parent().find('label');

						target.html('Choose file');

						toastr.warning('File tidak sesuai format atau melebihi batas maksimal !');
						return false;
					}
				} else {
					delete files[key];
				}
			}
		}
	}
}();