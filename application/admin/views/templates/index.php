<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->

<head>
	<base href="">
	<meta charset="utf-8" />
	<title><?php echo $this->config->item('title'); ?></title>
	<meta name="description" content="Latest updates and statistic charts">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--begin::Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

	<!--end::Fonts -->

	<!--begin::Page Vendors Styles(used by this page) -->

	<!--end::Page Vendors Styles -->

	<!--begin::Global Theme Styles(used by all pages) -->
	<link href="<?php echo base_url(); ?>./../assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>./../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

	<!--end::Global Theme Styles -->

	<!--begin::Layout Skins(used by all pages) -->

	<!--end::Layout Skins -->
	<link rel="shortcut icon" href="<?php echo base_url(); ?>./../assets/media/logos/favicon.ico" />

	<style>
		form span.required {
			color: #fd27eb;
			font-weight: bold;
		}

		.datepicker {
			z-index: 97 !important;
		}
	</style>
</head>

<!-- end::Head -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
	var KTAppOptions = {
		"colors": {
			"state": {
				"brand": "#22b9ff",
				"light": "#ffffff",
				"dark": "#282a3c",
				"primary": "#5867dd",
				"success": "#34bfa3",
				"info": "#36a3f7",
				"warning": "#ffb822",
				"danger": "#fd3995"
			},
			"base": {
				"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
				"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
			}
		}
	};
</script>

<script src="<?php echo base_url(); ?>./../assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>./../assets/js/scripts.bundle.js" type="text/javascript"></script>

<script type="text/javascript">
	var base_url = "<?php echo base_url(); ?>";
	var role_permission = "<?php echo login_data('role_permission'); ?>";
</script>

<!-- begin::Body -->

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

	<!-- begin:: Page -->

	<!-- begin:: Header Mobile -->
	<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed">
		<div class="kt-header-mobile__logo">
			<a href="index.html">
				<img alt="Logo" src="<?php echo base_url(); ?>./../assets/media/logos/logo-6-sm.png" />
			</a>
		</div>
		<div class="kt-header-mobile__toolbar">
			<div class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></div>
			<div class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></div>
			<div class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></div>
		</div>
	</div>

	<!-- end:: Header Mobile -->
	<div class="kt-grid kt-grid--hor kt-grid--root">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

			<!-- begin:: Aside -->
			<button class="kt-aside-close" id="kt_aside_close_btn"><i class="la la-close"></i></button>
			<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

				<!-- begin:: Aside Menu -->
				<?php echo $_sidebar; ?>

				<!-- end:: Aside Menu -->
			</div>

			<!-- end:: Aside -->
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

				<!-- begin:: Header -->
				<?php echo $_header; ?>

				<!-- end:: Header -->
				<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
					<div class="kt-subheader-search" style="padding: 0px !important;">
						<!-- <div class="kt-container  kt-container--fluid">
								<h3 class="kt-subheader-search__title">
									Pemberitahuan
									<span class="kt-subheader-search__desc"></span>
								</h3>
							</div> -->
					</div>

					<!-- begin:: Content -->
					<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
						<?php echo $_fullcontent; ?>
					</div>

					<!-- end:: Content -->
				</div>

				<!-- begin:: Footer -->
				<?php echo $_footer; ?>
				<!-- end:: Footer -->
			</div>
		</div>
	</div>

	<!-- end:: Page -->

	<!-- begin::Scrolltop -->
	<div id="kt_scrolltop" class="kt-scrolltop">
		<i class="fa fa-arrow-up"></i>
	</div>
	<!-- end::Scrolltop -->

	<!-- end::Global Config -->

	<!--begin::Global Theme Bundle(used by all pages) -->

	<!--end::Global Theme Bundle -->

	<!--begin::Page Vendors(used by this page) -->

	<!--end::Page Vendors -->

	<!--end::Page Scripts -->
	<!-- Template JS -->
	<script src="<?php echo base_url(); ?>./../assets/custom/js/template.js"></script>
	<script src="<?php echo base_url(); ?>./../assets/custom/js/jquery.base64.min.js" type="text/javascript"></script>

</body>

<!-- end::Body -->

</html>