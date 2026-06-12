<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<style type="text/css">
    .banner-inner {
    padding: 8vw 0;
    background: url(<?= base_url() ?>../assets/web/images/newbanner2.jpg) no-repeat !important;
    background-size: cover;
}
</style>
<!DOCTYPE html>
<html lang="zxx">
    <head>
        <title>Rapor Digital</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8" />
        <meta name="keywords" content=" Rapor Digital" />
        <script>
        addEventListener("load", function () {
        setTimeout(hideURLbar, 0);
        }, false);
        function hideURLbar() {
        window.scrollTo(0, 1);
        }
        </script>
        <!-- Custom Theme files -->
        <link href="<?= base_url() ?>/../../assets/web/css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
        <link href="<?= base_url() ?>/../../assets/web/css/style.css" type="text/css" rel="stylesheet" media="all">
        <!-- font-awesome icons -->
        <link href="<?= base_url() ?>/../../assets/web/css/font-awesome.min.css" rel="stylesheet">

        <link href="<?= base_url() ?>/../../assets/admin/plugins/select2/css/select2.css" rel="stylesheet">
        <!-- //Custom Theme files -->
        <!-- online-fonts -->
        <link href="<?= base_url() ?>/../../assets/web///fonts.googleapis.com/css?family=Encode+Sans+Condensed:100,200,300,400,500,600,700,800,900" rel="stylesheet">

        <script src="<?= base_url('./../assets/front/js/') ?>/jquery.min.js"></script>

        <script src="<?= base_url() ?>./../assets/admin/plugins/select2/js/select2.min.js"></script>

        <!-- //online-fonts -->
    </head>
    <body>
        <!-- header -->
        <header class="header-top text-md-left text-center bg-theme1">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <h1 class="wthree-logo">
                    <a href="#" id="logoLink">Rapor Digital</a>
                    </h1>
                    <div class="nav-sec  position-relative">
                        <ul id="menu">
                            <li>
                                <input id="check01" type="checkbox" name="menu"/>
                                <label class="menulist" for="check01">&nbsp;</label>
                                <ul class="submenu">
                                    <li><a href="index.html"  class="active">Home</a></li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="about.html">My Team</a></li>
                                    <li><a href="#testimonials" class="scroll">Testimonials</a></li>
                                    <li><a href="portfolio.html">My Projects</a></li>
                                    <li><a href="contact.html">Contact Me</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center">
                        <!-- <span class="fa fa-envelope-open mr-2 text-theme"></span> -->
                        <a href="<?= base_url() ?>/login">Login</a>
                        <a href="<?= base_url() ?>/login/register" class="text-white">Register</a>
                    </div>
                </div>
            </div>
        </header>
        <!-- //header -->
        
      