<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Spa Booking Software">
    <meta name="Author" content="Amorio Technologies Private Limited">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash(); ?>">

    <!-- TITLE -->
    <title> Winkin - Login </title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/images/company_imgs/').$cmpy_info['fld_cmpyfav']; ?>" width="40px" height="40px" >

    <!-- Main Theme Js -->
    <script src="<?= base_url('assets/js/authentication-main.js'); ?>"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="<?= base_url('assets/libs/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" >

    <!-- ICONS CSS -->
    <link href="<?= base_url('assets/icon-fonts/icons.css'); ?>" rel="stylesheet">

    <!-- APP CSS & APP SCSS -->
    <link rel="preload" as="style" href="<?= base_url('myassets/css/app.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('myassets/css/app.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('myassets/css/mystyle.css'); ?>" /> 

    <script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/jqueryvalidate1.19.5.js'); ?>"></script>
    <style type="text/css">
        .front {
          z-index: 999;
        }
    </style>
</head>

<body class="authentication-background">
    
<div class="container">
    <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
            <div class="rounded my-4 bg-white basic-page">
                <div class="basicpage-border"></div>
                <div class="basicpage-border1"></div>

                <div class="card-body p-5" id="loginForm">
                    <div class="mb-3 d-flex justify-content-center"> 
                        <a href="<?= base_url('login'); ?>" class="front"> 
                            <img src="<?= base_url("assets/images/company_imgs/".$cmpy_info['fld_cmpylogo'].""); ?>" alt="logo" class="desktop-logo"> 
                            <img src="<?= base_url("assets/images/company_imgs/".$cmpy_info['fld_cmpylogo'].""); ?>" alt="logo" class="desktop-dark"> 
                        </a> 
                    </div>
                    <p class="h4 fw-semibold mb-2 text-center">Sign In</p>

                    <form method="post" id="login_form">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="phone" class="form-label text-default">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control numberInput" id="phone" oninput="NumberOnly(this, 10);" >
                                <span class="text-danger error-msg"></span>
                            </div>
                            <div class="col-xl-12 mb-2">
                                <div class="row mb-3">
                                    <label for="inputEmail1" class=" col-form-label">Password <span class="danger-text">*</span>
                                        <a href="<?= base_url('forget_pwd'); ?>" class="float-end  link-danger op-5 fw-medium fs-12">Forget password ?</a>
                                    </label>
                                        <div class="input-group">
                                            <input  type="password" name="password" id="signin-password" class="form-control " id="inputEmail1" >
                                            <a href="javascript:void(0);" class="input-group-text text-muted bg-white" onclick="createpassword('signin-password',this)">
                                                <i class="ri-eye-off-line align-middle"></i>
                                            </a>
                                        </div>
                                        <span class="text-danger error-msg"></span>
                                </div>
                            </div>
                        </div>
                    
                        <div class="login_res"></div>
                    
                        <div class="d-grid mt-4">
                            <button type="submit" id="sub_btn" class="btn btn-primary">Sign In</button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mt-3 mb-0">Don't have an account? <a href="<?= base_url("Signup"); ?>" class="text-info">Sign Up</a></p>
                            <p class="mt-2"> <a href="<?= base_url('booking'); ?>" class="text-info">Book court</a> </p>
                        </div>

                    </form>
                </div>

                <div class="card-body p-5 d-none" id="forgotForm">
                    <div class="mb-3 d-flex justify-content-center"> 
                        <a href="<?= base_url('login'); ?>" class="front"> 
                            <img src="<?= base_url("assets/images/company_imgs/".$cmpy_info['fld_cmpylogo'].""); ?>" alt="logo" class="desktop-logo"> 
                            <img src="<?= base_url("assets/images/company_imgs/".$cmpy_info['fld_cmpylogo'].""); ?>" alt="logo" class="desktop-dark"> 
                        </a> 
                    </div>

                    <p class="h4 fw-semibold mb-2 text-center"></p>
                    <form method="post" id="forgot_password">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="phone" class="form-label text-default">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="emailaddress" placeholder="Email" aria-label="email" name="emailaddress">
                                <span class="text-danger error-msg"></span>
                            </div>
                        </div>
                    
                        <div class="forgot_res"></div>
                    
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="text-center">
                            <p class="text-muted mt-3 mb-0"><a href="<?= base_url("login"); ?>" class="text-primary">Back to Sign in</a></p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- Show Password JS -->
<script src="<?= base_url('assets/js/show-password.js'); ?>"></script>
<script src="<?= base_url('assets/js/footer.js'); ?>"></script>

<script type="text/javascript">

$(document).ready(function () {

    $('.numberInput').on('keypress', function (e) {
        // Prevent 'e', 'E', '+', and '-' keys
        if (e.key === 'e' || e.key === 'E' || e.key === '+' || e.key === '-') {
            e.preventDefault();
        }
    });


    function NumberOnly(input, maxLength) {
        input.value = input.value.replace(/\D/g, '');
        if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength);
        }
    }

    $("#login_form").submit(function(e) {
        e.preventDefault();
        var phone = $("#phone").val();
        var pwd = $("#signin-password").val();

        var action = validation({'phone':phone, 'signin-password':pwd});
        if(action === false) { return action; }

        $.ajax({
            url: 'login_submit',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.status === 200) {
                    $('.login_res').html('<div class="alert alert-success">Logged in successfully! Redirecting...</div>');
                    setTimeout(function () {
                        window.location.href = '<?= base_url("login"); ?>';
                    }, 2600);

                } else {
                    $('.login_res').html('<div class="alert alert-danger">Sign up failed: Try Again</div>');
                }
            },
            error: function () {
                $('.login_res').html('<div class="alert alert-danger">An error occurred. Please try again later.</div>');
            }
        });
    });

    // Forgot Password
    $('#forgotPassword').on('click', function(){
        $('#loginForm').addClass('d-none');
        $('#forgotForm').removeClass('d-none');
    });

    // Check Forgot Password Email 
    $("#forgot_password").submit(function(e) {
        e.preventDefault();
        var email = $("#emailaddress").val();

        var action = validation({'emailaddress':email});
        if(action === false) { return action; }

        $.ajax({
            url: 'forgot_password',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.status === 200) {
                    $('.forgot_res').html('<div class="alert alert-success">Logged in successfully! Redirecting...</div>');
                    setTimeout(function () {
                        window.location.href = '<?= base_url("login"); ?>';
                    }, 2600);

                } else {
                    $('.forgot_res').html('<div class="alert alert-danger mt-2">'+res.alert_msg+'</div>');
                }
            },
            error: function () {
                $('.forgot_res').html('<div class="alert alert-danger mt-2">An error occurred. Please try again later.</div>');
            }
        });
    });

});
</script>

</body>    
</html>    
