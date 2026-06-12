<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rapor Digital</title>
    <link href="https://fonts.googleapis.com/css?family=Heebo:400,500,700|Fira+Sans:600" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>../assets/profile/dist/css/style.css">
	<script src="https://unpkg.com/animejs@2.2.0/anime.min.js"></script>
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
     
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="<?= base_url() ?>/../../assets/admin/plugins/select2/css/select2.css" rel="stylesheet">
</head>
<style type="text/css">
	.button-red{
		background: #ed4962 !important;
	}
	a{
		text-decoration: none !important;
	}

	@media (min-width: 992px) {
    .navbar-expand-lg .navbar-nav .nav-link {
        
	        padding: 0 25px 0 25px;
	    }


	}
	.nav-link{
		color: black;
    	font-weight: 500;

	}
	.hover-underline-animation:after {
  content: '';
  position: absolute;
  width: 100%;
  transform: scaleX(0);
  height: 2px;
  bottom: 0;
  left: 0;
  background-color: #0087ca;
  transform-origin: bottom right;
  transition: transform 0.25s ease-out;
}

.hover-underline-animation:hover:after {
  transform: scaleX(1);
  transform-origin: bottom left;
}
</style>

<body class="is-boxed has-animations">
	<div class="col-sm-12" style="background: #313ac794;">
		<div class="col-sm-12 p-2" style="padding-left: 50px !important; padding-right: 50px !important;">
			<small class="text-white float-left" >
				AdminRD ID (+62) 878-4045-1295
			</small>
			<small class="text-white" style="float: right;" >
				<ul class="footer-social-links list-reset">
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Facebook</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.023 16L6 9H3V6h3V4c0-2.7 1.672-4 4.08-4 1.153 0 2.144.086 2.433.124v2.821h-1.67c-1.31 0-1.563.623-1.563 1.536V6H13l-1 3H9.28v7H6.023z" fill="#FFF"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Twitter</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 3c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.6-2.1.8-.6-.6-1.5-1-2.4-1-1.7 0-3.2 1.5-3.2 3.3 0 .3 0 .5.1.7-2.7-.1-5.2-1.4-6.8-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.5-.4C.7 7.7 1.8 9 3.3 9.3c-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4H0c1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4C15 4.3 15.6 3.7 16 3z" fill="#FFF"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Google</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.9 7v2.4H12c-.2 1-1.2 3-4 3-2.4 0-4.3-2-4.3-4.4 0-2.4 2-4.4 4.3-4.4 1.4 0 2.3.6 2.8 1.1l1.9-1.8C11.5 1.7 9.9 1 8 1 4.1 1 1 4.1 1 8s3.1 7 7 7c4 0 6.7-2.8 6.7-6.8 0-.5 0-.8-.1-1.2H7.9z" fill="#FFF"></path>
                                </svg>
                            </a>
                        </li>
                    </ul>
			</small>
		</div>
	</div>

	 <nav class="navbar navbar-expand-lg bg-light" style="width:100% !important; display: block;">
      <div class="container-fluid">
      	<div class="navbar-brand" style="margin-right: 100px; margin-left: 50px;">
	        <a class="" href="#">
	        	<img src="<?= base_url() ?>../assets/profile/src/logo.png" class="img-responsive" style="width: 75px;">
	        </a>
	    </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item hover-underline-animation">
              <a class="nav-link " aria-current="page" href="<?= site_url() ?>/login">Home</a>
            </li>
            <li class="nav-item hover-underline-animation">
              <a class="nav-link" aria-current="page" href="#">Media Balajar</a>
            </li>
            <li class="nav-item hover-underline-animation">
              <a class="nav-link" aria-current="page" href="#">Siplah</a>
            </li>
            <li class="nav-item hover-underline-animation">
              <a class="nav-link" aria-current="page" href="#">Contact</a>
            </li>
            
          </ul>
          <a href="<?= site_url() ?>/login/form_login">
            <button class="button button-primary button-block">Login</button>
        </a>
        <a href="<?= site_url() ?>/login/register">
            <button class="button button-primary button-red button-block">Register</button>
        </a>
          
        </div>
      </div>
    </nav>
    