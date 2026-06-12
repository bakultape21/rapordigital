var Layout = function() {
	var ajaxify = [null, null, null];

	var addt_ajaxify = function() {
		$('#kt_header, .kt-portlet').on('click', '.ajaxify', function(e) {
			var ele = $(this);
			functionAjaxify(e, ele);
		});
	}

	var class_sidebar = function(url) {
		var menu 			= $('#kt_aside_menu > .kt-menu__nav');
		var link 			= $('a.kt-menu__link[href="' + url + '"]');

		menu.find('li.kt-menu__item.kt-menu__item--active').removeClass('kt-menu__item--active');
		menu.find('li.kt-menu__item.kt-menu__item--open').removeClass('kt-menu__item--open');

		if(link.length > 0) {
			link.parents('li').each(function () {
				if ($(this).hasClass('kt-menu__item--submenu')) {
					$(this).addClass('kt-menu__item--open kt-menu__item--active');
				}
			});

			link.parents('li').addClass('kt-menu__item--active');
		} else {
			let a = menu.find('a');

			$.each(a, function(i, v){
				let a_href = $(v).attr('href');

				if(url.includes(a_href)) {
					$('a[href="' + a_href + '"]').parents('li').each(function () {
						if ($(this).hasClass('kt-menu__item--submenu')) {
							$(this).addClass('kt-menu__item--open kt-menu__item--active');
						}
					});

					$(v).parents('li').addClass('kt-menu__item--active');
				}
			});
		}
	}
	
	var handleContent = function() {
		$('#kt_aside_menu > ul.kt-menu__nav').on('click', ' li > a.ajaxify', function(e) {
			e.preventDefault();
			$('html,body').animate({
				scrollTop: 0
			}, 'slow');

			var url 			= $(this).attr("href");
			var pageContent 	= $('#kt_content > .kt-container');
			var menuContainer 	= $('#kt_aside_menu > ul.kt-menu__nav');

			class_sidebar(url);

			history.pushState(null, null, url);

			if(url != ajaxify[2]){
				ajaxify.push(url);
			}
			ajaxify = ajaxify.slice(-3, 5);

			$.ajax({
				url 		: url,
				data 		: { status_link : 'ajax'},
				dataType	: 'html',
				type 		: 'POST',
				cache 		: false,
				beforeSend	: function(xhr) {
					pageContent.css('position', 'relative');
					KTApp.blockPage({overlayColor:"#000000",type:"v2",state:"success",message:"Please wait..."});
					$(".tooltips").tooltip("hide");
				},
				error 		: function(xhr, status, error) {
					errorAjaxify();
				},
				success		: function(result, status, xhr) {
					if (result == 'out') {
						window.location = base_url + 'login';
					} else {
						$('div.daterangepicker ').remove();
						pageContent.html(result);
						pageContent.css('position', '');
						KTApp.unblockPage();
						addt_ajaxify();
					}
				}
			});
		});

		addt_ajaxify();
	}

	var functionAjaxify = function (e, ele, new_url){
		e.preventDefault();
		$('html,body').animate({
			scrollTop: 0
		}, 'slow');

		if(typeof ele === "undefined" || ele === null) {
			var url = new_url;
		} else {
			var url = $(ele).attr("href");
		}

		class_sidebar(url);

		var pageContent 	= $('#kt_content > .kt-container');
		var menuContainer 	= $('#kt_aside_menu > ul.kt-menu__nav');
		
		if(url != ajaxify[2]){
			ajaxify.push(url);
			history.pushState(null, null, url);
		}
		ajaxify = ajaxify.slice(-3, 5);

		$.ajax({
			url 		: url,
			data 		: { status_link : 'ajax'},
			dataType	: 'html',
			type 		: 'POST',
			cache 		: false,
			beforeSend	: function(xhr) {
				pageContent.css('position', 'relative');
				KTApp.blockPage({overlayColor:"#000000",type:"v2",state:"success",message:"Please wait..."});
				$(".tooltips").tooltip("hide");
			},
			error 		: function(xhr, status, error) {
				errorAjaxify();
			},
			success		: function(result, status, xhr) {
				if (result == 'out') {
					window.location = base_url + 'login';
				} else {
					$('div.daterangepicker ').remove();
					pageContent.html(result);
					pageContent.css('position', '');
					KTApp.unblockPage();
					addt_ajaxify();
				}
			}
		});
	}

	var errorAjaxify = function() {
		var pageContent = $('#kt_content > .kt-container');
		$.ajax({
			type: "POST",
			cache: false,
			url: base_url+'error/error_404', 
			data: { status_link : 'ajax', url: ajaxify[1], url1: ajaxify[2] },
			dataType: "html",
			success: function (html){ 
				if (html == 'out') {
					window.location = base_url + 'login';
				} else {
					$('div.daterangepicker ').remove();
					pageContent.html(html);
					pageContent.css('position', '');
					KTApp.unblockPage();
					$(".tooltips").tooltip("hide");
					addt_ajaxify();
				}
			}
		});
	}

	return {
		handleMenuActive_reload: function() {
			var url 	= location.href.toLowerCase();
			var menu 	= $('#kt_aside_menu > .kt-menu__nav');
			var link 	= $('a.kt-menu__link[href="' + url + '"]');

			menu.find('li.kt-menu__item.kt-menu__item--active').removeClass('kt-menu__item--active');
			menu.find('li.kt-menu__item.kt-menu__item--open').removeClass('kt-menu__item--open');

			if(link.length > 0) {
				link.parents('li').each(function () {
					if ($(this).hasClass('kt-menu__item--submenu')) {
						$(this).addClass('kt-menu__item--open kt-menu__item--active');
					}
				});

				link.parents('li').addClass('kt-menu__item--active');
			} else {
				let a = menu.find('a');

				$.each(a, function(i, v){
					let a_href = $(v).attr('href');

					if(url.includes(a_href)) {
						$('a[href="' + a_href + '"]').parents('li').each(function () {
							if ($(this).hasClass('kt-menu__item--submenu')) {
								$(this).addClass('kt-menu__item--open kt-menu__item--active');
							}
						});

						$(v).parents('li').addClass('kt-menu__item--active');
					}
				});
			}
		},

		rolePermission: function() {
			$('.btnAction').on('click', function(e){
				let the 	= $(this),
					data 	= the.data('permission'),
					role 	= role_permission;

				if (typeof data === "undefined") {
					return true;
				} else {
					const Toast = Swal.mixin({
									toast: true,
									position: 'top-end',
									showConfirmButton: false,
									timer: 3000
								});

					let length = $.trim(data).length;

					if(length == 1) {
						if(role.includes(data) == false) {
							Toast.fire({
								type: 'warning',
								title: 'Permission Denied'
							});

							return false;
						} else {
							return true;
						}
					} else {
						Toast.fire({
							type: 'error',
							title: 'Internal Server Error'
						});

						return false;
					}

					return false;
				}
			});
		},

		handlePopstate: function(e, ele, href) {
			functionAjaxify(e, ele, href);
		},

		init: function() {
			this.handleMenuActive_reload();
			this.rolePermission();
			handleContent();
		}
	}
}();

jQuery(window).on('popstate', function(e){
	var href = window.location.href;

	Layout.handlePopstate(e, null, href);
});

jQuery(document).ready(function() {
	Layout.init();
});

// function update status
function f_status(stat, ele, e, dtele){
	e.preventDefault();
	dtGrid = (dtele != null ? $("#"+dtele): $("#datatable_ajax") );

	if(stat == 1){
		var mes = "Apakah anda yakin ingin merubah status ?";
		var sus = "Berhasil Merubah Status!";
		var err = "Gagal Merubah Status!";
		var html = false;
	}else if(stat == 2){
		var mes = "Apakah anda yakin ingin menghapus data ?";
		var sus = "Berhasil Menghapus data!";
		var err = "Gagal Menghapus data!";
		var html = false;
	}else if(stat == 3){
		var mes = "<b>This will delete all related Subscription too!</b></br>Are you sure want to Delete data ?";
		var sus = "Berhasil Menghapus data!";
		var err = "Gagal Menghapus data!";
		var html = true;
	}
	Swal.fire({
		title 				: "Apakah anda yakin ?",
		text 				: mes,
		html 				: html,
		type 				: "warning",
		showCancelButton 	: true,
		confirmButtonColor	: '#3085d6',
		confirmButtonText 	: 'Ya',
		cancelButtonColor 	: '#d33',
		cancelButtonText 	: 'Tidak'
	}).then((result) => {
		if (result.value) {
			var href = $(ele).attr('href');
			$.post(href, function(data, textStatus, xhr) {
				if(data.status == 1){
					dtGrid.DataTable().ajax.reload();
					toastr.success(sus);
				}else{
					toastr.error(err);
				}
			}, 'json');
		}
	});
};

function deleteData(ele, e) {
	e.preventDefault();

	Swal.fire({
		title 				: "Apakah anda yakin ?",
		text 				: "Data akan dihapus secara permanen ?",
		html 				: false,
		type 				: "warning",
		showCancelButton 	: true,
		confirmButtonColor	: '#3085d6',
		confirmButtonText 	: 'Ya',
		cancelButtonColor 	: '#d33',
		cancelButtonText 	: 'Tidak'
	}).then((result) => {
		if (result.value) {
			let $this = $(ele),
				href  = $this.attr('href');

			$.post(href, function(data, textStatus, xhr) {
				if(data.status == 1){
					gridT.getDataTable().ajax.reload();
					toastr.success("Berhasil Menghapus data!");
				} else if(data.status == 99) {
					toastr.error("Anda tidak bisa menghapus data ini!");
				} else{
					toastr.error("Gagal Menghapus data!");
				}
			}, 'json');
		}
	});
}
function deleteDatareload(ele, e) {
		e.preventDefault();

		Swal.fire({
			title 				: "Apakah anda yakin ?",
			text 				: "Data akan dihapus secara permanen ?",
			html 				: false,
			type 				: "warning",
			showCancelButton 	: true,
			confirmButtonColor	: '#3085d6',
			confirmButtonText 	: 'Ya',
			cancelButtonColor 	: '#d33',
			cancelButtonText 	: 'Tidak'
		}).then((result) => {
			if (result.value) {
				let $this = $(ele),
					href  = $this.attr('href');

				$.post(href, function(data, textStatus, xhr) {
					if(data.status == 1){
						toastr.success("Berhasil Menghapus data!");
						location.reload(true);
					} else if(data.status == 99) {
						toastr.error("Anda tidak bisa menghapus data ini!");
					} else{
						toastr.error("Gagal Menghapus data!");
					}
				}, 'json');
			}
		});
	}


// $(document).bind('keydown', 'f5', function assets(e) {
// 	var href = window.location.href;

// 	Layout.handlePopstate(e, null, href);

// 	return false;
// });

// $('input').bind('keydown', 'f5', function assets(e) {
// 	var href = window.location.href;

// 	Layout.handlePopstate(e, null, href);

// 	return false;
// });
var currentUrl;
function changeUrl(key, val, is_new = true) {
	currentUrl = new URL(currentUrl);
	if(is_new){
		currentUrl.searchParams.set(key, val);
	}else{
		currentUrl.searchParams.delete(key);
	}
	window.history.pushState(null, '', currentUrl);
	window.location = currentUrl;
}