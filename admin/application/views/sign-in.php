<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-width="default" data-menu-styles="dark" data-toggled="close">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Spa Booking Software">
    <meta name="Author" content="Amorio Technologies Private Limited">
    <meta name="keywords" content="">

    <!-- TITLE -->
    <title> Booking Sign-in </title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpyfav']; ?>" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="<?= base_url('../assets/js/authentication-main.js'); ?>"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="<?= base_url('../assets/libs/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" >

    <!-- ICONS CSS -->
    <link href="<?= base_url('../assets/icon-fonts/icons.css'); ?>" rel="stylesheet">

    <!-- APP CSS & APP SCSS -->
    <link rel="preload" as="style" href="<?= base_url('../assets/css/app.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('../assets/css/app.css'); ?>" />

    <script src="<?= base_url('../assets/js/jquery-3.7.1.min.js'); ?>"></script>
    
</head>

<body class="authentication-background">
        
    <div class="container">
        <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="rounded my-4 bg-white basic-page">
                    <div class="basicpage-border"></div>
                    <div class="basicpage-border1"></div>
                    <div class="card-body p-5">
                        <div class="mb-3 d-flex justify-content-center"> 
                            <a href="<?= base_url('login'); ?>"> 
                                <img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="desktop-logo"> 
                                <img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="desktop-dark"> 
                            </a> 
                        </div>
                        <p class="h4 fw-semibold mb-2 text-center"></p>
                        <form method="post" id="login_form">
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="signin-email" class="form-label text-default"> Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email_id" class="form-control" id="signin-email" >
                                    <span class="text-danger error-msg"></span>
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <label for="signin-password" class="form-label text-default d-block"> Password <span class="text-danger">*</span>
                                        <!-- <a href="reset-password-basic.html" class="float-end link-danger op-5 fw-medium fs-12">Forget password ?</a> -->
                                    </label>

                                    <div class="input-group">
                                        <input type="password" name="pwd" class="form-control" id="signin-password" >
                                        <a href="javascript:void(0);" class="input-group-text text-muted bg-white" onclick="createpassword('signin-password',this)">
                                            <i class="ri-eye-off-line align-middle"></i>
                                        </a>
                                    </div>
                                    <span class="text-danger error-msg"></span>
                                </div>
                            </div>
                        
                        <div class="login_res"></div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" id="sub_btn" class="btn btn-primary">Log In</button>
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('../assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- Show Password JS -->
    <script src="<?= base_url('../assets/js/show-password.js'); ?>"></script>

    <script type="text/javascript">
       
        $(document).ready(function() {
            var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
            var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

            $('#signin-email, #signin-password').on('keyup', function() {
                $('.login_res').html('');
            });
            
            $("#login_form").submit(function(e) {
                e.preventDefault();

                const email = $('#signin-email').val();
                const pwd = $('#signin-password').val(); 
                $('.error-msg, .login_res').html('');
                $('.form-control').css('border', '');

                if(IsEmail(email) === false && email != "") {
                    var element = $('#signin-email').parent().children('span');
                    element.html('Please enter a valid email address');
                    return false;
                }

                if(email == "" && pwd == "") {
                    $('.form-control').css('border', '1px solid red');
                    $('.error-msg').html('This field is required');
                    return false;

                } else if(email == "") {
                    $('#signin-email').css('border', '1px solid red');
                    var element = $('#signin-email').parent().children('span');
                    element.html('This field is required');
                    return false;

                } else if(pwd == "") {
                    $('#signin-password').css('border', '1px solid red');
                    var element = $('#signin-password').parent().parent().children('span');
                    element.html('This field is required');
                    return false;
                } 

                var formData = $("#login_form").serializeArray();
                formData.push({ name: csrfName, value: csrfHash });
                $.ajax({
                    url: 'login_submit',
                    type: 'post',
                    data : formData,
                    dataType: 'json',
                    success : function (res) {
                        if(res.status == 200) {
                            $('.login_res').html('<div class="alert alert-success text-center my-3 authentication-barrier">'+
                                '<span class="text-success">Logged in Successfully!</span></div>');
                            
                            if(res.data.role == 2) { window.location.href = '<?= base_url('today_booking'); ?>'; } 
                            else { window.location.href = '<?= base_url('dashboard'); ?>'; }
                            
                        } else {
                            $('.login_res').html('<div class="alert alert-danger text-center my-3 authentication-barrier"><span class="text-danger">'+res.alert_msg.word+'</span></div>');
                        }
                    }, 
                    error: function(xhr, status, error) { console.log(xhr.responseText); }
               });
            });

        });
    </script>

</body>    
</html>    
