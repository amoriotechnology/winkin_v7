<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Booking Software">
    <meta name="Author" content="Winkin Pickle ball">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash(); ?>">

    <!-- TITLE -->
    <title> Winkin - Forget Password </title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/images/company_imgs/').$cmpy_info['fld_cmpyfav']; ?>" >

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
                            <img src="<?= base_url('assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="desktop-logo"> 
                            <img src="<?= base_url('assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="desktop-dark"> 
                        </a> 
                    </div>

                    <h5 class=" mb-1 fw-semibold text-center">Forget Password</h5>
                    <p class="h4 fw-semibold mb-2 text-center"></p>
                    <form method="post" id="forget_pwd_form">

                        <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                        <div class="row gy-3">
                            <div class="col-xl-12 phone_field">
                                <label for="signin-email" class="form-label text-default">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="email" name="phone" class="form-control" id="signin-email">
                                    <button type="button" id="forget_btn" class="btn btn-primary">Sent OTP</button>
                                </div>
                                <span class="phone-msg text-danger error-msg"></span>
                            </div>

                            <div class="col-xl-12 d-none otp_field">
                                <label for="otp_no" class="form-label text-default">Enter OTP <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="otp" class="form-control" id="otp_no" oninput="NumberOnly(this, 6);" >
                                    <button type="button" id="validate_btn" class="d-none btn btn-primary">Validate OTP</button>
                                </div>
                                <span class="otp-error-msg text-danger error-msg"></span>
                            </div>

                            <div class="col-xl-12 mb-2 d-none new_pwd_field">
                                <label for="new_password" class="d-block form-label">New Password <span class="danger-text">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" name="newpassword" id="new_password" class="form-control" >
                                    <div class="input-group-text">
                                        <a href="javascript:void(0);" class="" onclick="createpassword('new_password',this)">
                                            <i class="ri-eye-off-line align-middle"></i>
                                        </a>
                                    </div>
                                </div>
                                <span class="new_pass_alt text-danger error-msg"></span>
                            </div>

                            <div class="col-xl-12 mb-2 d-none confirm_pwd_field">
                                <label for="confirm_password" class="d-block form-label">Confirm Password <span class="danger-text">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" name="confirmpassword" id="confirm_password" class="form-control" >
                                    <div class="input-group-text">
                                        <a href="javascript:void(0);" class="" onclick="createpassword('confirm_password',this)">
                                            <i class="ri-eye-off-line align-middle"></i>
                                        </a>
                                    </div>
                                </div>
                                <span class="confirm_alt text-danger error-msg"></span>
                            </div>
                            
                        </div>
                    
                        <div class="login_res"></div>
                    
                        <div class="d-grid mt-4">
                            <button type="submit" id="pass_submit_btn" class="d-none btn btn-primary">Submit</button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mt-1 mb-0">Already have an account? <a href="<?= base_url('Login'); ?>" class="fs-14 text-info">Sign In</a></p>
                            <p class="text-center mt-3 mb-0"> <a href="<?= base_url('booking'); ?>" class="text-info">Book Court</a></p>
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

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $("#forget_btn").click(function(event) {
        event.preventDefault();

        var email_addr = $('#signin-email').val();
        var action = validation({'signin-email':email_addr});
        if(action === false) { return false; }
        $(".new_pwd_field, .confirm_pwd_field, #pass_submit_btn").addClass('d-none');

        $(this).html('OTP Sending...').attr('disabled', 'disabled');
        
        $.ajax({
            url: '<?= base_url('send_otp'); ?>',
            type: 'POST',
            data: { [csrfName]:csrfHash, trigger:'Yes', email_addr:email_addr},
            dataType: 'json',
            success: function(res) {

                if(res.status == 200) {
                    $('.otp_field, #validate_btn').removeClass('d-none');
                    $(".phone-msg").removeClass('text-danger').html('OTP Sent successfully!!!').addClass('text-success');
                    setTimeout(function () {
                        $("#forget_btn").html('Resend OTP').removeAttr('disabled');
                    }, 5000);
                
                } else if(res.status == 400) {

                    $(".phone-msg").removeClass('text-success').addClass('text-danger').html('Enter a valid Email Address');
                    $('.otp_field, #validate_btn').addClass('d-none');
                    setTimeout(function () {
                        $("#forget_btn").html('Resend OTP').removeAttr('disabled');
                    }, 1000);
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    });


    /* ----- Validate OTP Number ----- */
    $('#validate_btn').on('click', function(e) {

        const OTP = $('#otp_no').val();
        const email_addr = $('#signin-email').val();
        var action = validation({'otp_no':OTP});
        $('.password_field').addClass('d-none');
        if(action === false) { return false; }
        $(".new_pwd_field, .confirm_pwd_field, #pass_submit_btn").addClass('d-none');

        $.ajax({
            url: '<?= base_url('validateOTP'); ?>',
            type: 'POST',
            data: { [csrfName]: csrfHash, otp:OTP, email_addr:email_addr},
            dataType: 'json',
            success:function(res) {

                $('.otp-error-msg').html(res.text).addClass('text-danger').removeClass('text-success');
                if(res.status == 200) {
                    $(".new_pwd_field, .confirm_pwd_field, #pass_submit_btn").removeClass('d-none');
                    $('.otp-error-msg').html(res.text).addClass('text-success').removeClass('text-danger');
                    $('.password_field').removeClass('d-none');
                
                } else if(res.status == 403) {
                    AlertPopup('Warning', res.text, 'warning', 'OK', '');
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    });

    
    /* ----- Change New Password ----- */
    $('#forget_pwd_form').submit( function(event) {
        event.preventDefault();

        const email_addr = $('#signin-email').val();
        const new_pass = $('#new_password').val();
        const confirm_pass = $('#confirm_password').val();

        var action = true;
        action = validation({'new_password':new_pass, 'confirm_password':confirm_pass});
        
        if($.trim(new_pass).length <= 5 && action === true) {
            $('.new_pass_alt').html('Password must be 6 characters or above');
            action = false;
        }

        if(new_pass != confirm_pass) {
            $('.confirm_alt').html('Please match with new password');
            action = false;
        }

        if(action === false) { return action; }

        $.ajax({
            url: '<?= base_url('change_password'); ?>',
            type: 'POST',
            data: { [csrfName]: csrfHash, new:new_pass, confirm:confirm_pass, email_addr:email_addr },
            dataType: 'json',
            success:function(res) {

                if(res.status == 200) {
                    $(".login_res").html('<div class="alert alert-success text-center">Password changed successfully!!!</div>');
                    setTimeout(function () {
                        window.location.href = '<?= base_url("login"); ?>';
                    }, 2000);
                } else {
                    $(".login_res").html('<div class="alert alert-danger text-center">Password not changed!!!</div>');
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    });

});

</script>

</body>    
</html>    
