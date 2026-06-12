<!-- Preloader Start -->
<header>
	<!-- Header Start -->
	<div class="header-area">
		<div class="main-header ">
			<div class="header-top d-none d-sm-block">
				<div class="container-fluid padding-rl-45">
					<div class="col-xl-12">
						<div class="row d-flex justify-content-between align-items-center">
							<div class="header-info-left">
								<ul>
									<li class="title"></span><i class="fa fa-phone" aria-hidden="true"></i> <?= $profil->no_telp; ?></li>
									<li ><i class="fa fa-envelope"></i> <?= $profil->email; ?></li>
								</ul>
							</div>
							<div class="header-info-right">
								<ul class="header-date">
									<li>
										<form action="#" method="get" class="searchform">
										<div class="searchform-fields border" style="background-color: white;">
											<input name="s" style="border: none" type="text" value="" placeholder="Search…" autocomplete="off">
												<input type="hidden" name="post_type" value="post">
											<button class="btn text-white " title="Search" style="padding: 10px; background: #00927f;" type="submit"><i class="fas fa-search"></i></button>
											
										</div>
										</form>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="header-mid">
				<div class="container-fluid">
					<div class="row d-flex align-items-center">
						<div class="col-xl-3 col-lg-3 col-md-3 d-none d-md-block">
							<div class="logo">
								<a href="#"><img class="w-100" src="<?= base_url() ?>/uploads/logo.png" alt=""></a>
							</div>
						</div>
						<div class="col-xl-9 col-lg-9 col-md-9 d-none d-md-block">
							<div class="header-banner f-right" >
							</div>
						</div>
					</div>
				</div>
			</div> -->
			<div class="header-bottom header-sticky">
				<div class="container-fluid padding-rl-45">
					<div class="row align-items-center">
						<div class="col-xl-9 col-lg-9 col-md-9 header-flex">
							<!-- sticky -->
							<div class="sticky-logo">

								<a href="<?= site_url() ?>"><img class='w-25' src="https://baytalhikmah.net/download/logo/yayasan.png" alt=""></a>

							</div>
							<!-- Main-menu -->
							<div class="main-menu d-none d-md-block">

								<nav>
									<ul id="navigation">
										<li>

											<a href="<?= site_url() ?>"><img width="50" src="https://baytalhikmah.net/download/logo/yayasan.png" alt=""></a>

										</li>
										<!-- <li><a href="<?= site_url() ?>profile">Beranda</a> -->
										</li>
										<li>
											<a href="#">Bayt Al-Hikmah</a>
											<ul class="submenu">
												<li><a href="<?= site_url() ?>/page/index/profil"> Profile & Sejarah </a></li>
												<li><a href="<?= site_url() ?>/page/index/visimisi"> Visi & Misi</a></li>
												<li><a href="<?= site_url() ?>/page/index/struktur"> Struktur Kepengurusan</a></li>
											</ul>
										</li>
										<li>
											<a href="#">Pendidikan</a>
											<ul class="submenu">
												<li><a target="_blank" href="https://smp.baytalhikmah.sch.id/"> SMP Bayt Al Hikmah</a></li>
												<li><a target="_blank" href="https://sma.baytalhikmah.sch.id/"> SMA Bayt Al Hikmah</a></li>
												<li><a target="_blank" href="https://smk.baytalhikmah.sch.id/"> SMK Bayt Al Hikmah</a></li>
											</ul>
										</li>
										<li><a href="#">Lembaga</a>
											<ul class="submenu">
												<li><a href="#"> Laziswa</a></li>
											</ul>
										</li>
										<li>
											<a href="#">Sistem terintegrasi</a>
											<ul class="submenu">
												<li><a href="<?= site_url() ?>/sdm"> Kepegawaian</a></li>
												<li><a href="http://www.psb.baytalhikmah.sch.id/"> PSB Bayt Al Hikmah</a></li>
												<li><a href="#"> Sistem Pembayaran</a></li>
											</ul>
										</li>
										<li><a href="#">Informasi</a>
											<ul class="submenu">
												<li><a href="#"> Berita</a></li>
												<li><a href="#"> Event</a></li>
												<li><a href="<?= site_url() ?>/page/index/biaya"> Biaya Pendidikan</a></li>
											</ul>
										</li>
									</ul>
								</nav>
							</div>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3">
							<div class="header-right f-right d-none d-lg-block">
								<!-- Heder social -->
								<ul class="header-social">
									<li>
    									<a class="sosmed-facebook" href="">
    										<i class="fa fa-facebook"></i>
    									</a>
									</li>
									<li><a href="" class="sosmed-twitter"><i class="fab fa-twitter"></i></a></li>
									<li><a href="" class="sosmed-ig"><i class="fab fa-instagram"></i></a></li>
									<li> <a href="" class="sosmed-yt"><i class="fab fa-youtube"></i></a></li>
								</ul>
								<!-- Search Nav -->

							</div>
						</div>
						<!-- Mobile Menu -->
						<div class="col-12">
							<div class="mobile_menu d-block d-md-none"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Header End -->
</header>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="https://api.whatsapp.com/send?phone=51955081075&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20Varela%202." class="float" style="transform: rotate(90deg);
    transform-origin: right top;" target="_blank">
<i class="fa fa-whatsapp my-float"></i> Humas
</a>