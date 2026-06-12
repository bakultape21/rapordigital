  
  <style>
      label{
        color: black;
        font-weight: 500;
        padding-bottom: 20px;
        padding-top: 5px;
        text-decoration: underline 2px solid #7f86db;
      }
      .radio{
        padding-bottom: 0 !important;
        padding-top: 0 !important;
        text-decoration: none !important;
      }
      .form-control{
        border: 1px solid #030303 !important;
      }
      .select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid black;
    border-radius: 4px;
    height: 39px;
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
        <div class="contact-wthree" style="background: white;" id="contact">
            <div class="container py-sm-5">
                <h3 class="title-head-w3l">Register Baru</h3>
                <hr>
                <div class="py-lg-2 pt-4">
                    <div class="mt-lg-0 mt-3">
                        <!-- register form grid -->
                        <div class="register-top1 pb-lg-4">
                                <form action="<?php echo base_url(); ?>login/action_register" method="post" id="form-register"  autocomplete="off" accept-charset="utf-8" data-reload='1' enctype="multipart/form-data"  data-bitwarden-watching="1" class="register-wthree my-login-validation">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>
                                                    Nama Guru
                                                </label>
                                                <input class="form-control" type="text" placeholder="Nama Guru" name="guru_nama"
                                                required="">
                                            </div>
                                            <div class="col-md-6 mt-md-0 mt-4">
                                                <label>
                                                    NIP
                                                </label>
                                                <input class="form-control" type="text" placeholder="NIP" name="nip" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>
                                                    Nomor Telepon
                                                </label>
                                                <input class="form-control" type="text" placeholder="xxxx xxxxx" name="nomor_telepon"
                                                required="">
                                            </div>
                                            <div class="col-md-6 mt-md-0 mt-4">
                                                <label>
                                                    Email
                                                </label>
                                                <input class="form-control" type="email" autocomplete="off" value="" placeholder="example@email.com" name="email"
                                                required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>
                                                    Jabatan
                                                </label><br>
                                                <input type="radio" id="guru" name="jabatan" checked required value="2">  <label class="radio" for="guru">GURU</label> <br>
                                                <input type="radio" id="kepsek" name="jabatan" required value="3"> <label class="radio" for="kepsek">Kepala Sekolah</label><br>
                                            </div>
                                            <div class="col-md-6 mt-md-0 mt-4">
                                                <label>
                                                    Sekolah
                                                </label>
                                                <select name="sekolah_id" class="select2-sekolah"  required>
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>
                                                    Password
                                                </label>
                                                <input class="form-control" type="text"  name="password"
                                                required="">
                                            </div>
                                            <div class="col-md-6 mt-md-0 mt-4">
                                                <label>
                                                    Konfirmasi Password
                                                </label>
                                                <input class="form-control" type="text"  name="confirm_password"
                                                required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>
                                                    Kode Aktivasi
                                                </label>
                                                <input class="form-control" type="text" placeholder="xxxx xxxxx" name="code_aktivasi"
                                                required="">
                                            </div>
                                            <!--   <div class="col-md-6 mt-md-0 mt-4">
                                                <label>
                                                    Password
                                                </label>
                                                <input class="form-control" type="email" placeholder="example@email.com" name="email"
                                                required="">
                                            </div> -->
                                        </div>
                                    </div>
                                  
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="submit" id="kt_login_signin_submit"  class="btn btn-w3_pvt btn-block btn-success w-100 font-weight-bold text-uppercase bg-theme1">Save Register</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="text-center">
                                    <label>Sekolah Anda Belum Terdaftar? silahkan daftarkan disini !
                                    </label>
                                    <br>
                                    <button class="btn btn-danger" onclick="openWhatsApp()"><i class="fa fa-whatsapp" >Kirim Pesan ke WhatsApp</button>
                                </div>
                                
                            
                        </div>
                        <!--  //register form grid ends here -->
                    </div>
                    <!--// map-->
                </div>
            </div>
        </div>

    <a href="<?php echo site_url(); ?>/login" class="ajaxify reload"></a>
    <script>
        function openWhatsApp() {
            // Mengambil data dari form atau variabel
            var namaGuru = "";
            var npsn = "";
            var namaSekolah = "";
            var kabupaten = "";
            
            // Membuat URL WhatsApp dengan pesan template
            var message = `Halo Rapordigital.com, Saya ingin daftar akun %0A Nama Guru: ${namaGuru}%0A`;
            message += `NPSN: ${npsn}%0A`;
            message += `Nama Sekolah: ${namaSekolah}%0A`;
            message += `Kabupaten: ${kabupaten}`;

            // Membuka link WhatsApp dengan pesan
            var phoneNumber = "6289510290072"; // Ganti dengan nomor WhatsApp Anda
            var url = `https://wa.me/${phoneNumber}?text=${message}`;
            window.open(url, "_blank");
        }
    </script>

    <script src="<?php echo base_url(); ?>./../assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>./../assets/js/scripts.bundle.js" type="text/javascript"></script>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <script src="<?= base_url('./../assets/custom/js/') ?>/validation.js"></script>

    <link rel="stylesheet" href="<?= base_url() ?>./../assets/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>./../assets/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script src="<?php echo base_url(); ?>./../assets/custom/js/jquery.base64.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>./../assets/custom/js/template.js"></script>
     <script src="<?= base_url() ?>./../assets/admin/plugins/select2/js/select2.min.js"></script>



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
    </script>


