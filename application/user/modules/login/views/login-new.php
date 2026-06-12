<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->

<head>
	<meta charset="utf-8" />
	<title>Login</title>
	<meta name="description" content="Login page example">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--begin::Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

	<!--end::Fonts -->

	<!--begin::Page Custom Styles(used by this page) -->
	<link href="<?php echo base_url(); ?>./../assets/css/pages/login/login-3.css" rel="stylesheet" type="text/css" />

	<!--end::Page Custom Styles -->

	<!--begin::Global Theme Styles(used by all pages) -->
	<link href="<?php echo base_url(); ?>./../assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>./../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

	<!--end::Global Theme Styles -->

	<!--begin::Layout Skins(used by all pages) -->

	<!--end::Layout Skins -->
	<link rel="shortcut icon" href="<?php echo base_url(); ?>./../uploads/logo.png" />
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

	<!-- begin:: Page -->
	<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
		<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(<?php echo base_url(); ?>./../assets/uploads/bg-page.jpg);
    background-size: cover;">
				<div class="m-5 row" style="background: white;">
					<div class="col-sm-6 row">
						<div class="col-sm-3 mt-1 text-center">
							<a href="<?php echo base_url(); ?>login" style="font-style: unset;" >
								<!-- Si Rapor -->
							</a>
						</div>
						<div class="col-sm-9 mt-5">
							<h3>Guru Kepsek </h3>
						</div>
					</div>
					<div class=" col-sm-6">
						
						<div class=" mt-5">
							
							<form action="<?php echo base_url(); ?>login/action" method="post" id="form-register"  autocomplete="off" accept-charset="utf-8" data-reload='1' enctype="multipart/form-data"  data-bitwarden-watching="1" class="register-wthree my-login-validation">

								<div class="col-sm-6">
									<div class="input-group">
										<input class="form-control" type="text" autocomplete="off" placeholder="Email" name="email" autocomplete="off">
									</div>
								
								</div>
								<div class="col-sm-6 row">
									<div class="col-sm-10">
										<input class="form-control" type="password" autocomplete="off" placeholder="Password" name="password">
									</div>
									
									<div class="col-sm-2" style="float: right;">
										<button id="kt_login_signin_submit" class="btn btn-brand btn-success">Login</button>
									</div>
								</div>
								
								
								
							</form>
						</div>
						<a href="<?= site_url() ?>/login/register">
							<div class="col-sm-2" style="float: right;">
								<button id="kt_login_signin_submit" class="btn btn-brand btn-primary">Register</button>
							</div>
						</a>
					</div>

					<div class="col-sm-9">
						<div id="demo" class="carousel slide m-2 p-2 pt-5 pb-5" data-bs-ride="carousel">

						  <!-- Indicators/dots -->
						  <div class="carousel-indicators">
						    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
						    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
						    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
						    <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
						    <button type="button" data-bs-target="#demo" data-bs-slide-to="4"></button>
						    <button type="button" data-bs-target="#demo" data-bs-slide-to="5"></button>
						  </div>
						  
						  <!-- The slideshow/carousel -->
						  <div class="carousel-inner">
						  	
							    <div class="carousel-item active">
							    	<a href="#">
							    		<img src="<?= base_url() ?>../uploads/sirapor.jpeg"  class="d-block" style="width:100%">
							    	</a>
							      	
							    </div>
						  </div>
						  
						  <!-- Left and right controls/icons -->
						  <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
						    <span class="carousel-control-prev-icon"></span>
						  </button>
						  <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
						    <span class="carousel-control-next-icon"></span>
						  </button>
						</div>
					</div>
						
					
						<div class="col-sm-12">
							<label style="float: right;">Rapor Digital</label>
						</div>
					<!-- Carousel -->
					
				</div>
			</div>
		</div>
	</div>

	<!-- end:: Page -->

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
<style type="text/css">
	.bt-kategori {
    background: #25d366;
    /* padding-left: 5px; */
    /* padding-right: 2px; */
    padding: 3px;
    font-size: 0.8rem;
    margin: 2px;
    text-decoration: none;
}
.span-date {
    font-size: 0.75rem;
    font-weight: 700;
    padding: 3px;
    background-color: #14655c;
    text-decoration: none;
    color: white;
}
</style>
	<!-- end::Global Config -->

	<!--begin::Global Theme Bundle(used by all pages) -->
	<script src="<?php echo base_url(); ?>./../assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>./../assets/js/scripts.bundle.js" type="text/javascript"></script>

	<!--end::Global Theme Bundle -->

	<!--begin::Page Scripts(used by this page) -->
	<script src="<?php echo base_url(); ?>./../assets/js/pages/custom/login/login-general.js" type="text/javascript"></script>

	<!--end::Page Scripts -->
</body>

<!-- end::Body -->

</html>