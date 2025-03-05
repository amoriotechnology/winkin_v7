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
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash(); ?>">

    <!-- TITLE -->
    <title> Winkin - Sign Up </title>
    
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

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/flatpickr/flatpickr.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datepicker/daterangepicker.css'); ?>">

    <script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>

    <script src="<?= base_url('assets/js/jqueryvalidate1.19.5.js'); ?>"></script>

    <style type="text/css">
        #signin-password-error {
            display: block;
        }
    </style>
    
</head>

<body class="authentication-background">
        
    <div class="container">
        <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
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

                        <h5 class=" mb-1 fw-semibold text-center pb-4">Sign Up</h5>
                        <p class="h4 fw-semibold mb-2 text-center"></p>
                        <div class="pt-2 text-right"><span class="text-danger text-right">* &nbsp; Required Fields</span></div>
                        <form method="post" id="signup_form">

                            <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                            <div class="row gy-3">
                               
                                <div class="col-md-6">
                                    <label for="Firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control" id="Firstname"  oninput="AlphaOnly(this)">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="Lastname" class="form-label">Last Name <span class="danger-text">*</span></label>
                                    <input type="text" name="last_name" class="form-control" id="Lastname"  oninput="AlphaOnly(this)">
                                    <span class="text-danger"></span>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="phoneNumber" class="form-label">Phone Number <span class="danger-text">*</span></label>
                                    <input type="number" id="phoneNumber" class="form-control" oninput="NumberOnly(this, 10);" name="contact_number">
                                    <span class="text-danger"></span>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="email" class="form-label">Email <span class="danger-text">*</span></label>
                                    <input type="email" name="email" class="form-control" id="email">
                                    <span class="text-danger"></span>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="signin-password" class="mb-2">Password <span class="danger-text">*</span></label>
                                    <div class="input-group">
                                        <input  type="password" name="password" id="signin-password" class="form-control" >
                                        <div class="input-group-text">
                                            <a href="javascript:void(0);" class="text-muted " onclick="createpassword('signin-password',this)">
                                                <i class="ri-eye-off-line align-middle"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="dob" class="mb-2">Date of Birth </label>
                                    <div class="input-group">
                                        <input type="text" name="dob" id="dob" class="form-control datepicker_dob" >
                                        <div class="input-group-text">
                                            <label for="dob"> <i class="bi bi-calendar"></i> </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <div class="pt-1">
                            <div class="login_res pt-4"></div>
                        </div>                        
                        <div class="d-grid mt-4">
                            <div class="row mb-3">
                                <div class="col-md-6 col-sm-12"></div>
                                <div class="col-md-6 col-sm-12"></div>
                            </div>

                            <button type="submit" id="sub_btn" class="btn btn-primary">Sign Up</button>
                        </div>
                        <div class="text-center">
                            <p class="text-muted mt-3 mb-0">Already have an account? <a href="<?= base_url("Login"); ?>" class="text-info">Sign In</a></p>
                            <p class="mt-2"> <a href="<?= base_url('booking'); ?>" class="text-info">Book court</a> </p>
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

<!-- Date & Time Picker JS -->
<script src="<?= base_url('assets/libs/flatpickr/flatpickr.min.js'); ?>"></script>

<script>
    $(document).ready(function () {

        const phoneNumberRules = {
            "1": /^[0-9]{10}$/, // United States and Canada: 10 digits
            "44": /^[0-9]{10,11}$/, // United Kingdom: 10-11 digits
            "91": /^[0-9]{10}$/, // India: 10 digits
            "61": /^[0-9]{9}$/, // Australia: 9 digits
            "49": /^[0-9]{10,11}$/, // Germany: 10-11 digits
            "971": /^[0-9]{9}$/ // UAE: 9 digits
        };


        $("#countrycode").change(function () {
            const countryCode = $(this).val();
            const regex = phoneNumberRules[countryCode] || /^[0-9]+$/; 

            $.validator.methods.phoneNumberRule = null;                
            $.validator.addMethod("phoneNumberRule", function (value, element) {
                return regex.test(value);
            }, "Invalid contact number format for the selected country.");

            $("#contact_number").rules("add", {
                phoneNumberRule: true
            });
        });


        $("#countrycode").trigger("change");
        $.validator.addMethod("pattern", function (value, element, param) {
            if (this.optional(element)) {
                return true; 
            }
            const regex = new RegExp(param);
            return regex.test(value);
        }, "Only letters (a-z, A-Z), numbers (0-9), and the symbols @, $, _, *, !, #, %, ^, &, -, or + can be used."); 

        var countryData = {};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Fetch country data 
        $.ajax({
            url: '<?= base_url('Home/Getcc'); ?>', 
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken 
            },
            success: function(data) {
                // Parse the response data
                var countries = JSON.parse(data);
                countries.forEach(function(country) {
                    countryData[country.fld_countrycode] = country.required_length;
                });
            }
        });

        $.validator.addMethod("customLength", function(value, element, param) {
        return value.length === param;  
        }, "The length must be exactly {0} characters."); 


    $("#signup_form").submit(function(event) {

        event.preventDefault();
        const fname = $("#Firstname").val();
        const lname = $("#Lastname").val();
        const phone = $("#phoneNumber").val();
        const email = $("#email").val();
        const pwd = $("#signin-password").val();
        var action = validation({'Firstname':fname, 'Lastname':lname, 'phoneNumber':phone, 'email':email, 'signin-password':pwd});
        if(action === false) { return action; }
            
        $.ajax({
            url: '<?= base_url("signup_submit"); ?>',
            type: 'POST',
            data: $(this).serialize(), 
            dataType: 'json',
            success: function (res) {
                if (res.status === 1) {
                    $('.login_res').html('<div class="alert alert-success">Sign up successful! Redirecting To Login Page.</div>');
    
                    setTimeout(function () {
                        window.location.href = '<?= base_url("login"); ?>';
                    }, 2600);

                } else if (res.status === 2){
                    $('.login_res').html('<div class="alert alert-danger">Phone Number Already Exists.</div>');
                }
                else {
                    $('.login_res').html('<div class="alert alert-danger">Sign up failed: Try Again</div>');
                }

            },
            error: function () {
                $('.login_res').html('<div class="alert alert-danger">An error occurred. Please try again later.</div>');
            }
        });
    });

    });


    flatpickr(".datepicker_dob",{
        dateFormat:"M d/Y",
        disableMobile:!0,
        maxDate: "Jan 01/2006",
    });

</script>

</body>    
</html>    
