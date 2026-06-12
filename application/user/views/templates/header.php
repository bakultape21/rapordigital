					<style type="text/css">
						.kt-header__brand{
							background: white;
						}
					</style>
					<div id="kt_header" class="kt-header kt-grid kt-grid--ver  kt-header--fixed" style="background-image: linear-gradient(to bottom right, #22b9ff, #f5c731);">

						<!-- begin:: Aside -->
						<div class="kt-header__brand kt-grid__item" id="kt_header_brand">
							<div class="kt-header__brand-logo">
								<a href="<?php echo base_url(); ?>">
									<img width="50" alt="Logo" src="<?php echo base_url(); ?><?= login_data('logo_sekolah'); ?>" />
								</a>
							</div>
						</div>

						<!-- end:: Aside -->

						<!-- begin:: Title -->
						<h3 class="kt-header__title kt-grid__item">
							<?php echo $title; ?>
						</h3>

						<!-- end:: Title -->

						<!-- begin: Header Menu -->
						<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
						<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
							<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default">
								<ul class="kt-menu__nav">
									<li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true"><a href="<?php echo base_url(); ?>dashboard" class="kt-menu__link"><span class="kt-menu__link-text"><?= login_data('sekolah_nama') ?></span></a></li>
								</ul>
							</div>
						</div>

						<!-- end: Header Menu -->

						<!-- begin:: Header Topbar -->
						<div class="kt-header__topbar">

							<!--begin: User bar -->
							<div class="kt-header__topbar-item kt-header__topbar-item--user">
								<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
									<!-- <span class="kt-hidden kt-header__topbar-welcome">Hi,</span> -->
									<!-- <span class="kt-hidden kt-header__topbar-username">Nick</span> -->
									<!-- <img class="kt-hidden" alt="Pic" src="<?php echo base_url(); ?>./../assets/media/users/300_21.jpg" /> -->
									<?php if (login_data('user_photo') != null) : ?>
										<img class="" alt=" Pic" src="<?php echo base_url().login_data('user_photo'); ?>" />
									<?php else : ?>
										<span class="kt-header__topbar-icon kt-hidden-"><i class="flaticon2-user-outline-symbol"></i></span>
									<?php endif; ?>
								</div>
								<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

									<!--begin: Head -->
									<div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(<?php echo base_url(); ?>./../assets/media/misc/bg-1.jpg)">
										<div class="kt-user-card__avatar">
											<img class="kt-hidden" alt="Pic" src="<?php echo base_url(); ?>./../assets/media/users/300_25.jpg" />

											<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
											<span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success"><?php echo substr(login_data('user_full_name'), 0, 1); ?></span>
										</div>
										<div class="kt-user-card__name">
											<?php echo login_data('user_full_name'); ?>
										</div>
										<div class="kt-user-card__badge">
											<!-- <span class="btn btn-success btn-sm btn-bold btn-font-md">23 messages</span> -->
										</div>
									</div>

									<!--end: Head -->

									<!--begin: Navigation -->
									<div class="kt-notification">
										<a href="<?php echo base_url(); ?>config/user/profile" class="kt-notification__item">
											<div class="kt-notification__item-icon">
												<i class="flaticon2-calendar-3 kt-font-success"></i>
											</div>
											<div class="kt-notification__item-details">
												<div class="kt-notification__item-title kt-font-bold">
													Profile
												</div>
												<div class="kt-notification__item-time">
													Pengaturan akun.
												</div>
											</div>
										</a>
										<div class="kt-notification__custom kt-space-between">
											<a href="<?php echo base_url(); ?>login/out" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
										</div>
									</div>

									<!--end: Navigation -->
								</div>
							</div>

							<!--end: User bar -->
						</div>

						<!-- end:: Header Topbar -->
					</div>