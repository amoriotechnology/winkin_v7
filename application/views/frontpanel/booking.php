<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/booking_style.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/calander.css'); ?>" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="<?= base_url('assets/js/calander.js'); ?>"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<style>
    .text-fixed-white {
      color: white;
    }
    .fw-medium {
      font-weight: 500;
    }
    .fw-semibold {
      font-weight: 600;
    }
    .landing-banner-heading {
      font-size: 24px;
    }
    .booked-slot {
        background-color: #ffcccc !important; /* Light red background */
        border-color: #ff0000 !important; /* Red border */
        cursor: not-allowed;
        opacity: 0.6;
    }

    @media (max-width: 576px) { 
        .nav-tabs {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
    @media (max-width: 900px) { 
        .landing-body .section {
            padding: 0.375rem !important;
        }
      
    }
    .time-active .align-items-center {
        color: #ffffff !important;
    }
    .border-end {
        background-color: #58c437 !important;
        border-radius: 0px 25px 25px 0px;
    }
    .border-start {
        background-color: #58c437 !important;
        border-radius: 25px 0px 0px 25px;
    }
    
    .wizard-nav {
        display: none !important;
    }

    .no-dropdown {
    all: unset;
    display: inline-block;
    font-size: 16px;
    font-weight: bold;
    color: #5b6e00;
    cursor: text !important;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: transparent;
    padding-right: 10px;
}

    small{
        font-size: 1.0em
        font-weight: bold;
    }

</style>


<style type="text/css">
    .owl-carousel .item img {
    width: 100%;          
    height: 300px;        
    object-fit: cover;   
    border-radius: 10px;  
    transition: transform 0.3s ease;
}
.bg-orange {
    background-color: orange !important;
    color: black;
}
</style>

<?php 
$appkey = 0;
$appservs = $app_coup_name = "";
$app_date = CURDATE;
$app_time = [];
$weeks = !empty($setting_data[0]['fld_weekdays']) ? json_decode($setting_data[0]['fld_weekdays']) : [];

if(!empty($edit_appoint)) {
    $appkey = array_keys($edit_appoint)[0];
    $appservs = $edit_appoint[$appkey]['app_serv'];
    $app_time = $edit_appoint[$appkey]['app_time'];
    $app_date = $edit_appoint[$appkey]['app_date'];
    $app_coup_name = $edit_appoint[$appkey]['coup_name'];
} 

?>

<!-- Start::app-content -->
<div class="main-content landing-main px-0">

    <section class="section section-bg" id="booking" >
        <div class="container">
            
            <!-- Start::row-1 -->
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body p-0">
                            <h4 class="text-dark fw-semibold text-center p-3">Book Your Court</h4>
                            <form class="wizard wizard-tab horizontal" method="POST" id="cust_appointment_form">
                                <input type="hidden" id="csrftoken" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">

                                <aside class="wizard-content container">
                                    
                                    <div class="wizard-step active" data-title="Court" data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                        <div class="choose-serv-error-msg text-center" tabindex="-1"></div>
                                        <div class="row gy-4">
                                            <div class="col-xl-6">
                                                <div class="form-check d-flex align-items-center">
                                                    <div class="flex-fill align-items-center">
                                                        <label for="courtA">
                                                            <img src="<?= base_url('assets/images/court2.png'); ?>" width="80%" class="m-2 mobileView" alt="courtA" style="border-radius: 5%;">
                                                        </label>
                                                        <div class="d-flex justify-content-center input-group">
                                                            <label for="courtA" class="text-center mt-2"> <b>Court A</b> </label> &emsp;
                                                            <input name="court" class="fs-5 border-dark form-check-input form-checked-primary rounded" type="radio" value="courtA" data-duration="30" data-rate="600" id="courtA" <?= ( (!empty($appservs) && ($appservs == 'courtA') ) ? 'checked' : ''); ?> >
                                                            <input type="hidden" name="court_dura[courtA]" value="30">
                                                            <input type="hidden" name="court_rate[courtA]" value="600">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="form-check d-flex align-items-center">
                                                    <div class="flex-fill">
                                                        <label for="courtB">
                                                            <img src="<?= base_url('assets/images/court.png'); ?>" width="80%" class="m-2 mobileView" alt="courtB" style="border-radius: 5%;">
                                                        </label>
                                                        <div class="d-flex justify-content-center input-group">
                                                            <label for="courtB" class="text-center mt-2"> <b>Court B</b> </label> &emsp;
                                                            <input name="court" class="fs-5 border-dark form-check-input form-checked-primary rounded" type="radio" value="courtB" data-duration="30" data-rate="600" id="courtB" <?= ( (!empty($appservs) && ($appservs == 'courtB') ) ? 'checked' : ''); ?> >
                                                            <input type="hidden" name="court_dura[courtB]" value="30">
                                                            <input type="hidden" name="court_rate[courtB]" value="600">
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wizard-step" data-title="Date & Time" data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">

                                        <div class="choose-time-error-msg text-center" tabindex="-1"></div>
                                        <div class="row" id="staffCalender">

                                            <div class="col-xl-12">
                                                <div class="d-flex justify-content-center">
                                                    <ul class="nav nav-tabs mb-3 tab-style-6 rounded border-dark" id="myTab1" role="tablist" style="background-color: #dfdedd; height: 55px;">
                                                        <li class="nav-item" role="presentation"> 
                                                            <label for="courtA" class="court_btn nav-link w-lg rounded text-center" data-value="courtA" data-bs-toggle="tab" role="tab"> <b>Court A</b> </label>
                                                        </li>
                                                        <li class="nav-item" role="presentation"> 
                                                            <label for="courtB" class="court_btn nav-link w-lg rounded text-center" data-value="courtB" data-bs-toggle="tab" role="tab"> <b>Court B</b> </label> &nbsp;
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="calendar-container">
                                                  <div class="calendar-month-arrow-container">
                                                    <div class="calendar-month-year-container">
                                                      <select class="calendar-years" disabled></select>&nbsp;&nbsp;
                                                      <select class="calendar-months" disabled></select>
                                                    </div>
                                                    <div class="calendar-month-year"></div>

                                                    <div class="calendar-arrow-container mb-3">
                                                      <button type="button" class="calendar-today-button"></button>
                                                      <button type="button" class="calendar-left-arrow"> <i class="bi bi-caret-left-fill"></i> </button>
                                                      <button type="button" class="calendar-right-arrow"> <i class="bi bi-caret-right-fill"></i> </button>
                                                    </div>
                                                  </div>
                                                  <ul class="calendar-week"></ul>
                                                  <ul class="calendar-days"></ul>
                                                </div>
                                                <input type="hidden" name="court_date" id="court_date" value="<?= date('Y-m-d'); ?>">
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="row mt-4" id="courtCal"></div>
                                                <p style="margin-left: 10px;" id="viewTimes"></p>
                                                <span class="time-countdown"></span>
                                            </div>
                                            <p class="text-center m-2"> 
                                                <span class="m-2"> <span class="bg-success m-2">&emsp;</span>Selected</span> 
                                                <span class="m-2"> <span class="cal-disabled btn-success m-2">&emsp;</span>Booked</span> 
                                                <span> <span class="bg-orange m-2">&emsp;</span>Maintenance</span> 
                                                <span class="m-2"> <span class="cal-disabled m-2">&emsp;</span>Disabled</span> 
                                            </p>
                                        </div>
                                    </div>

                                    <?php if(empty(checkCustLogin())) { ?>
                                        <div class=" wizard-step " data-title="Person Info" data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                            <div class="text-center">
                                                <p class="sign-btn mt-3 mb-0">Already have an account? 
                                                    <a href="javascript:void(0)" id="sign-btn" data-title="sign-in" class="text-info">Sign In</a>
                                                </p>
                                            </div>
                                            <div class="row gy-3 sign-up-tab mt-2">
                                                <h6 class="text-center mb-3">SIGN UP</h6>

                                                <div class="col-xl-6 mt-3">
                                                    <label for="cust_name" class="form-label">First Name <span class="text-danger">*</span> </label>
                                                    <input type="text" name="cust_name" class="form-control" id="cust_name" value="" oninput="AlphaOnly(this)" />
                                                    <span class="appoint-error-msg text-danger"></span>
                                                </div>

                                                <div class="col-xl-6 mt-3">
                                                    <label for="cust_lname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="cust_lname" class="form-control" id="cust_lname" value="" oninput="AlphaOnly(this)" />
                                                    <span class="appoint-error-msg text-danger"></span>
                                                </div>

                                                <div class="col-xl-6 mt-3">
                                                    <label class="cust_phone" class="form-label">Phone Number <span class="text-danger">*</span> </label>
                                                    <input type="text" name="cust_phone" class="form-control mt-2" id="cust_phone" oninput="NumberOnly(this, 10)" value="" >
                                                    <span class="appoint-error-msg text-danger"></span>
                                                </div>
                                               
                                                <div class="col-xl-6 mt-3">
                                                    <label for="cust_email" class="form-label">Email Address <span class="text-danger">*</span> </label>
                                                    <input type="text" name="cust_email" class="form-control " id="cust_email" value="" />
                                                    <span class="appoint-error-msg text-danger"></span>
                                                </div>

                                                <div class="col-xl-6 mt-3">
                                                    <label for="cust_pwd" class="form-label">Password <span class="text-danger">*</span> </label>
                                                    <div class="input-group">    
                                                        <input type="password" name="cust_pwd" id="cust_pwd" class="form-control" autocomplete="off">
                                                        <a href="javascript:void(0);" class="input-group-text text-muted bg-white" onclick="createpassword('cust_pwd',this)">
                                                            <i class="ri-eye-off-line align-middle"></i>
                                                        </a>
                                                    </div>
                                                    <span class="appoint-error-msg text-danger"></span>
                                                </div>
                                            </div>

                                            <div class="row justify-content-center sign-in-tab mt-3 d-none">
                                                <div class="col-xl-7">
                                                    <div class="login-page">
                                                        <h6 class="text-center mb-3">SIGN IN</h6>
                                                        <div class="row justify-content-center gy-4">
                                                            <div class="col-xl-8">
                                                                <label for="signin_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                                <input type="text" name="signin_phone" class="form-control" id="signin_phone" oninput="NumberOnly(this, 10)" >
                                                                <span class="sign-error-msg text-danger"></span>
                                                            </div>
                                                            <div class="col-xl-8">
                                                                <label for="cust_password" class="form-label">Password <span class="text-danger">*</span></label>
                                                                <a href="javascript:void(0)" id="forget_pwd" class="float-end link-danger op-5 fw-medium fs-12"><b>Forget password ?</b></a>
                                                                <div class="input-group">
                                                                    <input type="password" name="signin-password" class="form-control" id="cust_password" autocomplete="off" >
                                                                    <a href="javascript:void(0);" class="input-group-text text-muted bg-white" onclick="createpassword('cust_password',this)">
                                                                        <i class="ri-eye-off-line align-middle"></i>
                                                                    </a>
                                                                </div>
                                                                <span class="sign-error-msg text-danger"></span>
                                                            </div>
                                                            <div class="col-xl-8">
                                                                <div class="d-grid">
                                                                    <button type="button" id="login_submit" class="btn btn-primary px-4">Login</button>
                                                                </div>
                                                            </div>
                                                            <div class="login-alert text-center"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row justify-content-center change-pwd-tab mt-3 d-none">
                                                <div class="col-xl-7">
                                                    <div class="login-page">
                                                        <h6 class="text-center mb-3">Forget Password</h6>
                                                        <div class="row justify-content-center gy-4">

                                                            <div class="col-xl-8 phone_field">
                                                                <label for="change_email" class="form-label text-default">Email Address <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="email" name="change_email" class="form-control numberInput" id="change_email" >
                                                                    <button type="button" id="forget_btn" class="btn btn-primary">Sent OTP</button>
                                                                </div>
                                                                <span class="phone-msg text-danger error-msg"></span>
                                                            </div>

                                                            <div class="col-xl-8 d-none otp_field">
                                                                <label for="otp_no" class="form-label text-default">Enter OTP <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" name="otp" class="form-control" id="otp_no" oninput="NumberOnly(this, 6);" >
                                                                    <button type="button" id="validate_btn" class="d-none btn btn-primary">Validate OTP</button>
                                                                </div>
                                                                <span class="otp-error-msg text-danger error-msg"></span>
                                                            </div>

                                                            <div class="col-xl-8 mb-2 d-none new_pwd_field">
                                                                <label for="new_password" class="d-block form-label">New Password <span class="text-danger">*</span>
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

                                                            <div class="col-xl-8 mb-2 d-none confirm_pwd_field">
                                                                <label for="confirm_password" class="d-block form-label">Confirm Password <span class="text-danger">*</span>
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

                                                            <div class="col-xl-8">
                                                                <div class="d-grid">
                                                                    <button type="button" id="change_pass_btn" class="d-none btn btn-primary">Change Password</button>
                                                                </div>
                                                            </div>

                                                            <div class="login-alert text-center"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="wizard-step" data-title="Confirmation" data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row gy-3">
                                                    <div class="col-xl-4">
                                                        <label for="paymode"> <b>Payment Mode</b></label>
                                                        <input type="text" name="pay_mode" class="form-control" id="paymode" value="Online" readonly />
                                                    </div>

                                                    <div style="display:none;" class="col-xl-4">
                                                        <label for="coupon_amt"> <b>Coupon</b></label>
                                                        <div class="input-group">
                                                            <input type="hidden" name="coupon_amt" class="form-control" id="coupon_amt" value="<?= $app_coup_name; ?>" placeholder="Coupon Code">
                                                            <button type="button" class="btn btn-success" id="coupon_apply"> <i id="coupon_icon" class="fas fa-sync fa-spin"></i> Apply </button>
                                                        </div>
                                                        <span class="coupon_error text-danger error-msg"></span>
                                                    </div>

                                                    <div class="col-xl-12 UPI d-none">
                                                        <h6 class="text-center">UPI Transaction</h6>
                                                        <center><span id="qrcode_upi"></span></center>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class="col-xl-6 mt-3">
                                                    <p class="fw-medium mb-1">Booked Date : <span class="text-muted " id="book_date_show"></span></p>
                                                </div>

                                                <div class="checkout-payment-success">
                                                    <div class="col-xl-12 mb-4">
                                                        <div class="table-responsive">
                                                            <table class="table nowrap text-nowrap border mt-4">
                                                                <thead class="table-dark">
                                                                    <tr class="text-center">
                                                                        <th>Slot Date</th>
                                                                        <th>Court</th>
                                                                        <th>Duration</th>
                                                                        <th>Timing(s)</th>
                                                                        <th>Amount ₹</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="billbody"></tbody>
                                                                <tfoot id="billfoot"></tfoot>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_id" id="app_id" value="<?= !empty($edit_appoint[$appkey]['app_aid']) ? $edit_appoint[$appkey]['app_aid'] : ''; ?>">
                                        <input type="hidden" name="cust_id" value="<?= !empty($edit_appoint) ? $edit_appoint[$appkey]['app_custid'] : ''; ?>">
                                        <div class="mb-4 text-center">
                                            <button type="submit" id="pay-btn" class="btn btn-success">Pay Now</button>
                                            <!--<p class="mb-1 fs-14">You will get the booking details to your email address</p>-->
                                        </div>
                                    </div>
                                </aside>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-body p-0">
                            <h5 style="padding-top: 10px; padding-left: 10px;">Venue Info</h5>
                            <ul style="list-style: none;">
                                <li>
                                    <i class="fa-solid fa-ban"></i> &nbsp;Non Ac - <b>2</b>
                                </li>
                                <li class="mt-2">
                                    <i class="bi bi-grid-3x3-gap"></i> &nbsp;Synthetic Flooring
                                </li>
                                <li class="mt-2">
                                   <i class="fas fa-shoe-prints"></i> &nbsp; Non Marking Shoes Mandatory
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-body p-0">
                            <h5 style="padding-top: 10px; padding-left: 10px;">Amenities</h5>
                            <ul style="list-style: none;">
                                <li class="mt-2">
                                    <i class="fas fa-coffee"></i>&nbsp; Cafe
                                </li>
                                <li class="mt-2">
                                    <i class="fa-brands fa-google-pay"></i>&nbsp; UPI Accepted
                                </li>
                                <li class="mt-2">
                                    <i class="fa-solid fa-toilet"></i>&nbsp;&nbsp; Toilets
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <!--End::row-1 -->
        </div>
    </section>
    
<!-- End:: Section-2 -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    let yearDropdown = document.querySelector(".calendar-years");
    let monthDropdown = document.querySelector(".calendar-months");

    // Add class to remove dropdown arrow and prevent clicking
    yearDropdown.classList.add("no-dropdown");
    monthDropdown.classList.add("no-dropdown");

    // Disable the select elements
    yearDropdown.setAttribute("disabled", true);
    monthDropdown.setAttribute("disabled", true);
});


</script>

<script type="text/javascript">
 
$(document).ready(function() {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    var apptime = "<?= !empty($app_time) ? $app_time : ''; ?>";
    var appdate = "<?= !empty($app_date) ? $app_date : ''; ?>";
    var appcourt = "<?= !empty($appservs) ? $appservs : ''; ?>";
    var appkey = $("#app_id").val();

   $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        items: 3,
        autoplay: true,          
        autoplayTimeout: 3000,   
        autoplayHoverPause: true, 
        animateOut: 'fadeOut',   
        animateIn: 'fadeIn',     
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });


    $("input[name='court'], .court_btn").on('click', function() {
        
        var court = $("input[name='court']:checked").val();
        var label = $(this).data('value');

        $("input[name='court']").prop('checked', false);
        $('.court_btn').removeClass('active');
        $('#'+court).prop('checked', true);
        $('.court_btn[data-value="'+court+'"]').addClass('active');
    });


    /* ----- For payment methode choosing ----- */
    $('.cardpay, .UPI').css('display', 'none');
    $("input[type=radio][name='paymethode']").on('change', function() {
        var paymode = $("input[type=radio][name='paymethode']:checked").val();
        
        $('.cardpay, .cov, .UPI').css('display', 'none');
        if(paymode == "Card") {
            $('.cardpay').css('display', 'block');
        } else if(paymode == 'COV') {
            $('.cov').css('display', 'block');
        } else if(paymode == 'UPI') {
            $('.UPI').css('display', 'block');
        }
    });


    $('body').on('click', '#sign-btn', function() {
        var title = $(this).data('title');

        if(title == "sign-in") {
            $('.sign-btn').html('Don&apos;t have an account? <a href="javascript:void(0)" id="sign-btn" data-title="sign-up" class="text-info"> SIGN UP </a> ');
            $('.sign-up-tab, .change-pwd-tab').addClass('d-none');
            $('.sign-in-tab').removeClass('d-none');
            $('.next').attr('disabled', 'disabled');
        } else {
            $('.sign-btn').html('Already have an account? <a href="javascript:void(0)" id="sign-btn" data-title="sign-in" class="text-info"> SIGN IN </a> ');
            $('.sign-in-tab, .change-pwd-tab').addClass('d-none');
            $('.sign-up-tab').removeClass('d-none'); 
            $('.next').removeAttr('disabled');
        }
    });

    $('body').on("click", "#forget_pwd", function() {
        $('.sign-btn').html('Don&apos;t have an account? <a href="javascript:void(0)" id="sign-btn" data-title="change_pwd" class="fs-14 text-info"> SIGN UP </a> ');
        $(".change-pwd-tab").removeClass('d-none');
        $("#change_email, #otp_no, #new_password, #confirm_password").val('');
        $('.phone-msg').html('');
        $(".sign-in-tab, .otp_field, #validate_btn, .new_pwd_field, .confirm_pwd_field, #change_pass_btn, .login-alert").addClass('d-none');
        $('.next').attr('disabled', 'disabled');
    });

    $('body').on('click', "input[name='times[]']", function() {

        var element = $("input[name='times[]']").parent().parent().parent().parent();
        var checkedElement = $("input[name='times[]']:checked").parent().parent().parent().parent(); 
        element.removeClass('time-active btn-success text-white').addClass('btn-outline-success');
        checkedElement.removeClass('btn-outline-success').addClass('time-active btn-success text-white');

        var selCourt = $("input[type=radio][name='court']:checked").val();  
        var selCourtDur = $("input[name='court_dura[courtA]']").val();
        var CourtRate = $("input[type=radio][name='court']:checked").data('rate');

        var court_time = [];
        $("input[type=checkbox][name='times[]']:checked").each(function() {
            court_time.push($(this).val());
        });
        $('#billbody, #billfoot').empty();
        getCourtTable(court_time);
        $("#book_date_show").html(displayDate(new Date()));
    });

    $("#viewTimes").html('');
    var clickcount = 0;
    var allUnchecked = false;
    $('body').on('click', ".time-btn0, input[name='times[]']", function() {
        allUnchecked = $("input[name='times[]']:not(:checked)").length;
        var element = $(this).children().children().children().children();
        var input = element[1];
        var prev_td = $(this).data('time');
        var prev_input = $('.'+prev_td).children().children().children().children();
        var prev_input = prev_input[1];
        var next_td = $(this).data('next');
        var next_input = $('.'+next_td).children().children().children().children();
        var next_input = next_input[1];
        var cont_td = $(prev_input).prop('checked');
        
        if ($(input).prop('checked')) {
            $(input).prop('checked', false);
        } else {
            $(input).prop('checked', true);
        }
        var ctiming = [];
        var duration = 0; var rate = 0;
        $("input[name='times[]']:checked").each(function() {
            ctiming.push($(this).val());
            duration += 30;
            rate += 600;
        });
        clickcount++;
        if(ctiming == "") { clickcount = 0; }
        if(ctiming.length == 1) { clickcount = 0; }
        if(ctiming != "") {
            if(clickcount >= 1 && (cont_td == false || cont_td == undefined)) {
                $(input).prop('checked', false);
                ctiming = [];
                var duration = 0; var rate = 0;
                $("input[name='times[]']:checked").each(function() {
                    ctiming.push($(this).val());
                    duration += 30;
                    rate += 600;
                });
            }
        }
        if($(prev_input).is(':checked') && $(next_input).is(':checked')) {
            $(input).prop('checked', true);
        }
        getCourtTable(ctiming);
        $("#book_date_show").html(displayDate(new Date()));
        var element = $("input[name='times[]']").parent().parent().parent().parent();
        var checkedElement = $("input[name='times[]']:checked").parent().parent().parent().parent();
        element.removeClass('time-active btn-success text-white').addClass('btn-outline-success');
        checkedElement.removeClass('btn-outline-success').addClass('time-active btn-success text-white');

        getTimeRate(ctiming[0], duration, rate);
    });

    /* --------- activate when page load ------------ */
    getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]: csrfHash, court:appcourt, date:appdate, apptime:apptime, appkey:appkey}, 'courtCal');

    $('#courtdate').val(appdate);

    var selCourt = $("input[type=radio][name='court']:checked").val();
    var selCourtDur = $("input[name='court_dura[courtA]']").val();
    var CourtRate = $("input[type=radio][name='court']:checked").data('rate');
    var courttimings = [];
    var timesplit = apptime.split(", ");

    for(var t=0; t < timesplit.length; t++) {
        courttimings.push(timesplit[t]);
    };

    $('#billbody, #billfoot').empty();
    getCourtTable(courttimings);


    /* -------- Check the mobile number exist or not --------- */
    $('#cust_phone').on('keyup', function() {
        var phone = $(this).val();
        var element = $('#cust_phone').parent().children('span');
        element.addClass('text-danger').removeClass('text-success').html('');

        // $('#cust_name, #cust_lname, #cust_email, #cust_gender, #cust_dob, #mari_sts, #cust_addr, #cust_pref').val('');
        if(phone.length > 9) {
            $('.anni_field').addClass('d-none');
            $.ajax({
                url: '<?= base_url('checkExistorNot'); ?>',
                type: 'post',
                data: { [csrfName]: csrfHash, phone:phone },
                dataType: 'json',
                success: function(res) {
                    if(res != "") {
                        element.removeClass('text-danger').addClass('text-success').html('You have an account, Please sign-in');
                    }
                },
                error: function(xhr, status, error) { console.log(xhr.responseText); }
            });
        }
    });


    var apptime = "";
    var appdate = "";
    /* --------- activate when stylist radio click ------------- */
    $('body').on('change', "input[type=radio][name='court']", function() {
        
        var appdate = $('.calendar-day-active').data('date');
        var courts = $(this).val();

        $('#courtCal').empty();
        if(courts != "") {
            $("#viewTimes").html('');
            getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]: csrfHash, court:courts, date:appdate, apptime:apptime}, 'courtCal');
        }
    });


    /* -------- when click calendar date active change calender date --------- */
    $("body").on("click", ".cal-date", function(event) {
        var court = $("input[type=radio][name='court']:checked").val();

        var selectedDate = $(this).data('date');
        $('#court_date').val(selectedDate);

        var curdate = new Date();
        var seleDate = new Date(selectedDate);
        curdate.setHours(0, 0, 0, 0);
        seleDate.setHours(0, 0, 0, 0);
        $('.next').removeAttr('disabled');
        if(curdate > seleDate) {
            $('.next').attr('disabled', 'disabled');
        }

        $('.cal-date').removeClass('calendar-day-active');
        $(this).addClass('calendar-day-active');

        $('#courtCal').empty();
        if(selectedDate != "" && court != "") {
            $("#viewTimes").html('');
            getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]:csrfHash, court:court, date:selectedDate, apptime:apptime}, 'courtCal');
        }
    });


    $("#signin_phone, #cust_password").on("keyup", function() {
        $('.next').attr('disabled', 'disabled');
    });


    $("#forget_btn").click(function(event) {
        event.preventDefault();

        var email_addr = $('#change_email').val();
        var action = validation({'change_email':email_addr});
        if(action === false) { return false; }
        $(".new_pwd_field, .confirm_pwd_field, #change_pass_btn").addClass('d-none');

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
                    $('.otp_field, #validate_btn').addClass('d-none');
                    $(".phone-msg").removeClass('text-success').addClass('text-danger').html('Enter a valid email address');
                    setTimeout(function () {
                        $("#forget_btn").html('Resend OTP').removeAttr('disabled');
                    }, 1000);
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    });

    $("#otp_no").on('keydown', function() {
        $(".new_pwd_field, .confirm_pwd_field").addClass('d-none');
    });

    /* ----- Validate OTP Number ----- */
    $('#validate_btn').on('click', function(e) {

        const OTP = $('#otp_no').val();
        const email_addr = $('#change_email').val();
        var action = validation({'otp_no':OTP});
        $('.password_field').addClass('d-none');
        if(action === false) { return false; }
        $(".new_pwd_field, .confirm_pwd_field, #change_pass_btn").addClass('d-none');

        $.ajax({
            url: '<?= base_url('validateOTP'); ?>',
            type: 'POST',
            data: { [csrfName]: csrfHash, otp:OTP, email_addr:email_addr},
            dataType: 'json',
            success:function(res) {

                $('.otp-error-msg').html(res.text).addClass('text-danger').removeClass('text-success');
                if(res.status == 200) {
                    $(".new_pwd_field, .confirm_pwd_field, #change_pass_btn").removeClass('d-none');
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
    $('#change_pass_btn').on("click", function(event) {
        event.preventDefault();

        const email_addr = $('#change_email').val();
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
                $('.next').removeAttr('disabled');
                if(res.status == 200) {
                    $(".login_res").html('<div class="alert alert-success text-center">Password changed successfully!!!</div>');
                    setTimeout(function () {
                        $('.change-pwd-tab').addClass('d-none');
                        $('.sign-in-tab').removeClass('d-none');
                        $('.next').attr('disabled', 'disabled');
                        /*window.location.href = '<?= base_url("login"); ?>';*/
                    }, 2000);
                } else {
                    $(".login_res").html('<div class="alert alert-danger text-center">Password not changed!!!</div>');
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });
    });


    $('#login_submit').on('click', function() {
        var signin_phone = $('#signin_phone').val();
        var cust_password = $('#cust_password').val();

        var action = validation({'signin_phone':signin_phone, 'cust_password':cust_password});
        $('.amount-error-msg').html('').removeClass('alert alert-success alert-danger');
        if(action === false) { return false; }

        $.ajax({
            url: '<?= base_url('login_submit'); ?>',
            type: 'POST',
            data: { [csrfName]:csrfHash, phone:signin_phone, password:cust_password },
            dataType: 'json',
            success:function(res) {

                $('.login-alert').html(res.alert_msg.word).addClass('alert alert-danger');
                $('.next').attr('disabled', 'disabled');
                if(res.status == 200) {
                    $('.next').removeAttr('disabled');
                    $('.login-alert').html('Signed in Successfully!').removeClass('alert-danger').addClass('alert alert-success');
                }
            },
            error: function(xhr, status, error) { console.log(xhr.responseText); }
        });

    });

    /* ------------------------ Model ajax for add / edit staff ---------------------- */
    $("#cust_appointment_form").submit(function(event) {
        event.preventDefault();
        var amt = restrictAmt($('#amt').val());
        if(amt === false) { return amt; }

        var paymentType = $('select[name="pay_mode"]').val();
        var submitButton = $('button[type="submit"]');
        submitButton.prop('disabled', true).text('Loading...');

        var appoint_status = false;
        var newapp_id = "";
        $.ajax({
            url: '<?= base_url('add_cust_booking') ?>',
            type: 'post',
            data : $(this).serialize(),
            dataType: 'json',
            success:function(result) {
                if(result.status == 200) {
                    submitButton.prop('disabled', false).text('Pay Now');
                    newapp_id = result.appoint_id;

                    var courtname = $("input[name='court']:checked").val();
                    var courtdate = $("#court_date").val();
                    var courttime = "";
                    $("input[name='times[]']:checked").each(function() {
                        courttime += $(this).val()+" - ";
                    });
                    var customer_phone = $("#cust_phone").val();
                    var cust_name = $("#cust_name").val();
                    var cust_email = $("#cust_email").val();
                    if (!customer_phone) {
                        cust_name = "<?= (!empty($this->session->userdata('login_cust_info')['cust_name'])) ? $this->session->userdata('login_cust_info')['cust_name'] : ''; ?>";
                        cust_email = "<?= (!empty($this->session->userdata('login_cust_info')['cust_email'])) ? $this->session->userdata('login_cust_info')['cust_email'] : ''; ?>";
                        customer_phone = "<?= (!empty($this->session->userdata('login_cust_info')['cust_phone'])) ? $this->session->userdata('login_cust_info')['cust_phone'] : ''; ?>";
                    }

                    $.ajax({
                        url: '<?= base_url('payment_create'); ?>',
                        type: 'POST',
                        data:{[csrfName]:csrfHash, amount:$("#total_Amount").text(), gst:$("#gst_amount").val(), pay_charge: $("#payment_amount").val(), customer_phone: customer_phone},
                        dataType: 'json',
                        success : function (res) {
                            var responseData = (typeof res.data === "string") ? JSON.parse(res.data) : res.data;
                            submitButton.prop('disabled', false).text('Pay Now');
                                var options = {
                                    "key": responseData.api_key, 
                                    "amount": responseData.amount, 
                                    "currency": "INR",
                                    "order_id": responseData.order_id, 
                                    "handler": function (response) {
                                        $.ajax({
                                            url: '<?= base_url('razorpaysuccess') ?>', 
                                            method: 'POST',
                                            data: {
                                                [csrfName]:csrfHash,
                                                razorpay_payment_id: response.razorpay_payment_id,
                                                razorpay_order_id: response.razorpay_order_id,
                                                razorpay_signature: response.razorpay_signature,
                                                payment_status: response.payment_status,

                                            },
                                            dataType: 'json',
                                            success: function (data) {

                                                if (data.code > 0) {
                                                    submitButton.prop('disabled', true).text('Loading...');
                                                    $.ajax({
                                                        url: '<?= base_url('update_appointment') ?>',
                                                        type: 'post',
                                                        data : {[csrfName]:csrfHash, 'appoint_id':newapp_id, 'pay_id':data.payment_id, 'ord_id':data.order_id, 'signature':data.signature, paymentdata:data},
                                                        dataType: 'json',
                                                        success:function(res) {
                                                            if(res.status == 200) {
                                                                AlertPopup('Success!', 'Appointment Booked Successfully!', 'success', 'Ok', 'mybookings', "extra_btn");
                                                                submitButton.prop('disabled', false).text('Pay Now');
                                                            } else {
                                                                AlertPopup('Error!', 'Appointment Not Booked!!!', 'error', 'Ok', 'mybookings');
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    AlertPopup('Failed!', 'Court not booking!!!', 'error', 'Ok', 'booking');
                                                }
                                            },
                                            error: function (err) {
                                                AlertPopup('Error!', 'Payment verification failed. Please try again.', 'error', 'Ok', 'booking');
                                            }
                                        });
                                    },
                                    "prefill": {
                                        "name": cust_name,
                                        "email": cust_email,
                                        "court": courtname,
                                        "slotdate": courtdate,
                                        "slottime": courttime,
                                    }
                                };
                                var rzp1 = new Razorpay(options);
                                rzp1.open();
                        }
                    });

                } else if(result.status == 300) {
                    AlertPopup('Warning!', result.alert_msg, 'warning', 'Ok', 'booking');
                } else {
                    AlertPopup('Error!', 'Appointment Not Booked!!!', 'error', 'Ok', 'booking');
                    return false;
                }
            }
        });
    });

    // Coupon Amount 
    $('#coupon_apply').on('click', function(event) {
        if (event.which===13) event.preventDefault();
        
        var coupon_amt = $('#coupon_amt').val();
        var totalAmount = $('#old_amount').val();
        applycoupon(coupon_amt, totalAmount);
    });

    $('#coupon_amt').on('input', function(event) {
        if (event.which===13) event.preventDefault();

        var coupon_amt = $(this).val();
        var totalAmount = $('#old_amount').val();
        if (coupon_amt.trim() === '') {
            $('#total_Amount, #grand_tot').text(totalAmount);
            $('.showCoupon').addClass('d-none');
            $('#coupon_apply').text('Apply');
        }
    });
});


function applycoupon(coupon_name, totalamt) {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";

    $('.showCoupon').addClass('d-none');
    $('#coupon_apply').prop('disabled', true);
    $('#coupon_icon').removeClass().addClass('fas fa-sync fa-spin');
    $('.coupon_error').text('');

    var action = validation({'coupon_amt':coupon_amt});
    if(action === false) { return action; }
    
    $.ajax({
        url: '<?= base_url('get_coupons'); ?>',
        type: 'POST',
        data: { [csrfName]:csrfHash, coupon_amt:coupon_name, totalAmount:totalamt},
        dataType: 'json',
        success:function(res) {
            $('#total_Amount, #grand_tot').text(res.finalamount);
            if(res.status == 200) {
                $('.showCoupon').removeClass('d-none');
                $('#coupon_Percent').text(res.percent + '%');
                $('#coupon_Amount').text(res.percentamount);
                $('#total_Amount, #grand_tot').text(res.finalamount);
                $('#cpid').val(res.coupon_id);
                $('#cperc').val(res.percent);
                $('#cpamt').val(res.percentamount);
                $('#coupon_icon').removeClass().addClass('fas fa-check-circle'); 
                $('#coupon_apply').removeClass('btn-success').addClass('btn-primary'); 
                $('#coupon_apply').text('Applied');
                $('.coupon_error').removeClass('text-danger').addClass('text-success').text('Apply coupon successful!!!');
            } else {
                $('#coupon_icon').removeClass().addClass('fas fa-times-circle'); 
                $('#coupon_apply').text('Apply');
                $('.coupon_error').removeClass('text-success').addClass('text-danger').text('The coupon code is not valid.');
            }
            handlePaymentMethodChange();
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        },
        complete: function() {
            $('#coupon_apply').prop('disabled', false);
        }
    });
}

// UPI Qr Generate
function handlePaymentMethodChange() 
{
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    var paymentMethod = $('input[name="paymethode"]:checked').val(); 
    var amount = $('#total_Amount, #grand_tot').text(); 
    
    if (paymentMethod === 'UPI') {
        $.ajax({
            url: '<?= base_url('qr_generate'); ?>',
            type: 'POST',
            data: { [csrfName]: csrfHash, amount: amount },
            success: function(response) {
                $('.UPI').removeClass('d-none'); 
                $("#qrcode_upi").empty().append(response); 
            },
            error: function(xhr, status, error) {
                $('.UPI').removeClass('d-none');
                console.error('AJAX request failed:', status, error);
            }
        });
    } else {
        $('.UPI').addClass('d-none');
    }
}

function DisplayTime(time, duration) {
    var d = new Date('2000-01-01 '+time);
    d.setMinutes(d.getMinutes()+duration);
    var timestru = d.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })
    return timestru;
}


/* ----- For confirmation screen table ----- */
function getCourtTable(court_data) {

    var selCourt = $("input[type=radio][name='court']:checked").val();
    var selCourtDur = $("input[name='court_dura[courtA]']").val();
    var CourtRate = $("input[type=radio][name='court']:checked").data('rate');
    var booking_date = $("#court_date").val();

    var courtname = 'Court B';
    if(selCourt == "courtA") { courtname = 'Court A'; }

    $('#billbody, #billfoot').empty();
    var tbody = "";
    var tfoot = "";
    var courttotal = 0;
    var tot_subtotal = 0;

    for(var c = 0; c < court_data.length; c++) {

        var endTime = DisplayTime(court_data[c], parseInt(selCourtDur));
        var without_gst = (CourtRate / 1.18).toFixed(2);
        tbody += "<tr class='text-center'>  <td>" + displayDate(booking_date) + "</td>  <td>" + courtname + "</td><td>" + selCourtDur + " mins</td> <td>" + court_data[c] + " - " + endTime + "</td> <td>" + without_gst + "</td> </tr>";
        courttotal += parseFloat(CourtRate);
        tot_subtotal += parseFloat(without_gst);
    }

    var paymentAmount = courttotal * 0.02;
    var total = (courttotal / 1.18);
    var storeGstAmount = parseFloat(courttotal - (courttotal / 1.18));
    var grandTotal = total * 1.18;

    tfoot += "<tr>"+
                "<td colspan='4' align='right'> <b>Subtotal :</b> </td>"+
                "<td align='center' id='sub_Amount'>"+tot_subtotal.toFixed(2)+"</td>"+
                "<input type='hidden' id='cpid' name='fld_acpid' />"+
                "<input type='hidden' name='fld_acppercent' id='cperc' />"+
                "<input type='hidden' name='fld_acpamt' id='cpamt' />"+
                "<input type='hidden' name='old_amount' id='old_amount' value="+grandTotal+" />"+
                "<input type='hidden' name='gst_amount' id='gst_amount' value="+storeGstAmount+" />"+
                "<input type='hidden' name='payment_amount' id='payment_amount' value="+paymentAmount+" /></tr>"+
            "<tr>"+
                "<td colspan='4' align='right'> <b>GST Amount :</b> </td>"+
                "<td align='center' id=''>"+storeGstAmount.toFixed(2)+"</td></tr>"+
            "<tr class='showCoupon d-none'>"+
                "<td colspan='4' align='right'> <b>Coupon Percent % :</b> </td>"+
                "<td align='center' id='coupon_Percent'></td></tr>"+
            "<tr class='showCoupon d-none'>"+
                "<td colspan='4' align='right'> <b>Coupon Amount :</b> </td>"+
                "<td align='center' id='coupon_Amount'></td></tr>"+
            "<tr>"+
                "<td colspan='4' align='right'> <b>Total :</b> </td>"+
                "<td align='center' id='total_Amount'>"+(tot_subtotal + storeGstAmount).toFixed(2)+"</td></tr>"+
            "<tr>"+
                "<td colspan='4' align='right'> <b>Grand Total :</b> <br> <small>(Round Off)</small> </td>"+
                "<td align='center' id='grand_tot'>"+(courttotal).toFixed(2)+"</td></tr>"+
        "</td> </tr>";

    $('#billbody').append(tbody);
    $('#billfoot').append(tfoot);

    // applycoupon($('#coupon_name').val(), $('#tot_amt').val());
}

function getTimeRate(starttime, duration, rate) {

    var viewtimes = "Selected Timings: <b>"+starttime+" - "+DisplayTime(starttime, parseInt(duration))+"</b> <br> Amount ₹: <b>"+rate+"</b>";
    viewtimes = (starttime == undefined) ? "" : viewtimes;
    $("#viewTimes").html(viewtimes);
}

const settingweeks = <?= (!empty(json_encode($weeks)) ? json_encode($weeks) : []); ?>;
</script>


<script src="<?= base_url('assets/js/cal_scroll.js'); ?>" ></script>

<!-- Show Password JS -->
<script src="<?= base_url('assets/js/show-password.js'); ?>"></script>

<!-- Date & Time Picker JS -->
<script src="<?= base_url(); ?>/assets/libs/flatpickr/flatpickr.min.js"></script>

<!-- Vanilla-Wizard JS -->
<script src="<?= base_url(); ?>/assets/libs/vanilla-wizard/js/wizard.min.js"></script>

<!-- Internal Form Wizard JS -->
<script src="<?= base_url(); ?>/myassets/form-wizard.js"></script>
<link rel="modulepreload" href="<?= base_url(); ?>/myassets/form-wizard-init-front.js" />
<script type="module" src="<?= base_url(); ?>/myassets/form-wizard-init-front.js"></script>


<!-- Sticky JS -->
<script src="<?= base_url(); ?>/assets/js/sticky.js"></script>