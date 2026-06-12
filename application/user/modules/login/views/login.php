  
  <style type="text/css">
      @media (min-width: 992px) {
        .pt-200{
            padding-top: 170px !important;
        }
    }
     @media (max-width: 500px) {
        .pt-200{
            padding-top: 20px !important;
        }
    }
  </style>
        <div class="home-wthreepvt">
            <div class="banner-inner">
            </div>
        </div>
        <!-- //banner -->
        <!-- breadcrumbs -->
        
        <!-- //breadcrumbs -->
        <!-- contact -->
        <div class="contact-wthree" id="contact" style="background: white;">
            <div class="container row ">
                <div class="col-sm-6">
                    
                    <div class="py-lg-2 ">
                        <div class="mt-lg-0 mt-3">
                            <!-- register form grid -->
                            <div class="row">
                                <img src="<?= base_url() ?>../assets/illustration.jpg" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="py-lg-5 pt-4 pt-200" style="">
                        <h3 class="title-head-w3l">Portal Login</h3>
                        <div class="mt-lg-0 mt-3">
                            <!-- register form grid -->
                            <div class="row">
                                 <div class="register-top1 pb-lg-4">
                                    <form action="<?php echo base_url(); ?>login/action" method="post" id="form-register"  autocomplete="off" accept-charset="utf-8" data-reload='1' enctype="multipart/form-data"  data-bitwarden-watching="1" class="register-wthree my-login-validation">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12 mt-md-0 mt-4">
                                                    <label>
                                                        Email
                                                    </label>
                                                    <input class="form-control" type="email" placeholder="Email" name="email" required="">
                                                </div>
                                                <div class="col-md-12">
                                                    <label>
                                                        Password
                                                    </label>
                                                    <input class="form-control" type="password"  name="password"
                                                    required="" id="myInput">
                                                    <input type="checkbox" onclick="myFunction()">Show Password


                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <button type="submit" id="kt_login_signin_submit"  class="btn btn-w3_pvt btn-success btn-block w-100 font-weight-bold text-uppercase bg-theme1">Login</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            
                            
                        </div>
                       
                        <!--  //register form grid ends here -->
                    </div>
                </div>
            </div>
        </div>

<a href="<?php echo site_url(); ?>/login" class="ajaxify reload"></a>

    <script src="<?php echo base_url(); ?>./../assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>./../assets/js/scripts.bundle.js" type="text/javascript"></script>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <script src="<?= base_url('./../assets/custom/js/') ?>/validation.js"></script>

    <link rel="stylesheet" href="<?= base_url() ?>./../assets/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>./../assets/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script src="<?php echo base_url(); ?>./../assets/custom/js/jquery.base64.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>./../assets/custom/js/template.js"></script>



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
    <script type="text/javascript">

        jQuery(document).ready(function() {

        var form = '#form-register',
            rule = {},
            message = {};

        FormValidation.handleValidation(form, rule, message);
    });

        $('.select2').select2();
            $('.select2-sekolah').select2({
            width: '100%',
            placeholder: 'Pilih Sekolah',
            allowClear: true,
            ajax: {
                url: '<?= base_url() ?>' + '/login/get_sekolah',
                dataType: 'json',
                type: "POST",
                delay: 500,
                data: function(param) {
                    return {
                        q: param.term
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data.item
                    };
                },
            }
        });

function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
    </script>


