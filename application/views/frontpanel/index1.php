<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/booking_style.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/calander.css'); ?>" />
<script src="<?= base_url('assets/js/gsap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/calander.js'); ?>"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<style>
    .text-fixed-white {
      color: white;
    }
    .op-7 {
      opacity: 0.7;
    }
    .op-9 {
      opacity: 0.9;
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
</style>


<style type="text/css">
    .owl-carousel .item img {
    width: 100%;          
    height: 300px;        
    object-fit: cover;   
    border-radius: 10px;  
    transition: transform 0.3s ease;
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

    <!-- Start:: Section-1 -->
    <div class="landing-banner" id="home">
        <section class="section">
            <div class="container main-banner-container pb-lg-0">
                <div class="row">
                    <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8">
                        <div class="py-lg-5">
                            <div class="mb-3">
                                <h6 class="fw-medium text-fixed-white op-9" id="heading">Winkin's Pickle Ball Zone</h6>
                            </div>
                            <p class="landing-banner-heading mb-3" id="main-text">Play, compete, and enjoy – <span class="fw-semibold">Pickle Ball</span> is waiting for you</p>
                            <div class="fs-16 mb-4 text-fixed-white op-7" id="sub-text">Join the action at Winkin and experience the thrill of every match!</div>

                            <a href="#booking" class="btn btn-primary btn-sm btn-lg d-md-none d-lg-inline-block">Book Now</a>
                        </div>
                    </div>
                    <!-- <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4 my-auto">
                        <div class="text-end landing-main-image landing-heading-img">
                            <img src="<?= base_url('assets/images/media/landing/1.png'); ?>" alt="" class="img-fluid">
                        </div>
                    </div> -->
                </div>
            </div>
        </section>
    </div>
    <!-- End:: Section-1 -->

    <!-- Start:: Section-2 -->
    
    <section class="section section-bg mobileviewwhoare" style="padding: 3.375rem 0; 
    position: relative;" id="about">
        <div class="container">
            <div class="row gx-5 mx-0">
                <h2 class="text-center text-success fw-semibold">Who Are We?</h2>
                <div class="col-xl-5">
                    <div class="home-proving-image">
                        <img src="<?= base_url('assets/images/about.png'); ?>" alt="" class="img-fluid] about-image d-none d-xxl-block">
                    </div>
                    <div class="proving-pattern-1"></div>
                </div>
                <div class="col-xxl-7 col-xl-12 my-auto">
                    <div class="heading-section text-start mb-4">
                        <div class="heading-description fs-16 mt-4" style="text-align: justify;">At <b class="text-primary">Winkin</b>, our business "Pickle Ball" is all about bringing people together through fun, energy, and active living. We focus on providing unique experiences and high-quality solutions for pickleball enthusiasts.
                        Whether you're a beginner or a seasoned player, we aim to make pickleball accessible, enjoyable, and memorable for everyone. With a passion for community and a commitment to excellence, <b class="text-primary">Winkin’s</b> Pickle Ball is here to inspire and engage players of all levels.
                        Join us in celebrating this fast-growing, exciting sport and experience the joy of pickleball with <b class="text-primary">Winkin</b>!</div>
                    </div>
                    <div class="row gy-3 mb-0">
                        <div class="col-xl-12">
                            <div class="d-flex align-items-top">
                                <div class="me-2 home-prove-svg">
                                    <i
                                        class="ri-shining-line align-middle fs-14 text-primary d-inline-block"></i>
                                </div>
                                <div>
                                    <span class="fs-15">
                                        Easy and Inclusive
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="d-flex align-items-top">
                                <div class="me-2 home-prove-svg">
                                    <i
                                        class="ri-shining-line align-middle fs-14 text-primary d-inline-block"></i>
                                </div>
                                <div>
                                    <span class="fs-15">
                                        Health and Fitness
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 mt-4">
                           <a href="#booking" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End:: Section-3 -->
    <br>
    <section class="section chooseeffect" style="padding: 1.375rem 0 !important;">
        <div class="container position-relative">
            <div class="text-center">
               <h2 class="fw-semibold text-success">Why choose us ?</h2>
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                        <p class="text-muted fs-15 mb-5 fw-normal">Your trusted partner for seamless experiences, great value, and exceptional service.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="card custom-card landing-card border shadow-none">
                        <div class="card-body">
                            <div class="mb-4">
                                <span class="avatar avatar-xl bg-primary-transparent">
                                    <span class="avatar avatar-lg bg-primary svg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="#000000" viewBox="0 0 256 256">
                                            <path
                                                d="M208,104a79.86,79.86,0,0,1-30.59,62.92A24.29,24.29,0,0,0,168,186v6a8,8,0,0,1-8,8H96a8,8,0,0,1-8-8v-6a24.11,24.11,0,0,0-9.3-19A79.87,79.87,0,0,1,48,104.45C47.76,61.09,82.72,25,126.07,24A80,80,0,0,1,208,104Z"
                                                opacity="0.2"></path>
                                            <path
                                                d="M176,232a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,232Zm40-128a87.55,87.55,0,0,1-33.64,69.21A16.24,16.24,0,0,0,176,186v6a16,16,0,0,1-16,16H96a16,16,0,0,1-16-16v-6a16,16,0,0,0-6.23-12.66A87.59,87.59,0,0,1,40,104.5C39.74,56.83,78.26,17.15,125.88,16A88,88,0,0,1,216,104Zm-16,0a72,72,0,0,0-73.74-72c-39,.92-70.47,33.39-70.26,72.39a71.64,71.64,0,0,0,27.64,56.3h0A32,32,0,0,1,96,186v6h24V147.31L90.34,117.66a8,8,0,0,1,11.32-11.32L128,132.69l26.34-26.35a8,8,0,0,1,11.32,11.32L136,147.31V192h24v-6a32.12,32.12,0,0,1,12.47-25.35A71.65,71.65,0,0,0,200,104Z">
                                            </path>
                                        </svg>
                                    </span>
                                </span>
                            </div>
                            <h5 class="fw-semibold">Flexible booking system</h5>
                            <p class="fs-15 text-muted">We offer a user-friendly and adaptable booking process, ensuring convenience and ease for all our customers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card custom-card landing-card border shadow-none">
                        <div class="card-body">
                            <div class="mb-4">
                                <span class="avatar avatar-xl bg-primary-transparent">
                                    <span class="avatar avatar-lg bg-primary svg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="#000000" viewBox="0 0 256 256">
                                            <path
                                                d="M163.94,80.11h0C162.63,80,161.32,80,160,80a72,72,0,0,0-67.93,95.88h0a71.53,71.53,0,0,1-30-8.39l-27.76,8.16a8,8,0,0,1-9.93-9.93L32.5,138A72,72,0,1,1,163.94,80.11Z"
                                                opacity="0.2"></path>
                                            <path
                                                d="M144,140a12,12,0,1,1-12-12A12,12,0,0,1,144,140Zm44-12a12,12,0,1,0,12,12A12,12,0,0,0,188,128Zm51.34,83.47a16,16,0,0,1-19.87,19.87l-24.71-7.27A80,80,0,0,1,86.43,183.42a79,79,0,0,1-25.19-7.35l-24.71,7.27a16,16,0,0,1-19.87-19.87l7.27-24.71A80,80,0,1,1,169.58,72.59a80,80,0,0,1,62.49,114.17ZM81.3,166.3a79.94,79.94,0,0,1,70.38-93.87A64,64,0,0,0,39.55,134.19a8,8,0,0,1,.63,6L32,168l27.76-8.17a8,8,0,0,1,6,.63A63.45,63.45,0,0,0,81.3,166.3Zm135.15,15.89a64,64,0,1,0-26.26,26.26,8,8,0,0,1,6-.63L224,216l-8.17-27.76A8,8,0,0,1,216.45,182.19Z">
                                            </path>
                                        </svg>
                                    </span>
                                </span>
                            </div>
                            <h5 class="fw-semibold">Affordable rates</h5>
                            <p class="fs-15 text-muted">Enjoy top-notch services at competitive prices, providing excellent value without compromising quality.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card custom-card landing-card border shadow-none">
                        <div class="card-body">
                            <div class="mb-4">
                                <span class="avatar avatar-xl bg-primary-transparent">
                                    <span class="avatar avatar-lg bg-primary svg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="#000000" viewBox="0 0 256 256">
                                            <path
                                                d="M104,40a24,24,0,1,1,24,24A24,24,0,0,1,104,40Zm108.49,99.51L167.17,88.13a24,24,0,0,0-18-8.13H106.83a24,24,0,0,0-18,8.13L43.51,139.51a12,12,0,0,0,17,17L96,128,73.13,214.93a12,12,0,0,0,21.75,10.14L128,168l33.12,57.07a12,12,0,0,0,21.75-10.14L160,128l35.51,28.49a12,12,0,0,0,17-17Z"
                                                opacity="0.2"></path>
                                            <path
                                                d="M160,40a32,32,0,1,0-32,32A32,32,0,0,0,160,40ZM128,56a16,16,0,1,1,16-16A16,16,0,0,1,128,56Zm90.34,78.05L173.17,82.83a32,32,0,0,0-24-10.83H106.83a32,32,0,0,0-24,10.83L37.66,134.05a20,20,0,0,0,28.13,28.43l16.3-13.08L65.55,212.28A20,20,0,0,0,102,228.8l26-44.87,26,44.87a20,20,0,0,0,36.41-16.52L173.91,149.4l16.3,13.08a20,20,0,0,0,28.13-28.43Zm-11.51,16.77a4,4,0,0,1-5.66,0c-.21-.2-.42-.4-.65-.58L165,121.76A8,8,0,0,0,152.26,130L175.14,217a7.72,7.72,0,0,0,.48,1.35,4,4,0,1,1-7.25,3.38,6.25,6.25,0,0,0-.33-.63L134.92,164a8,8,0,0,0-13.84,0L88,221.05a6.25,6.25,0,0,0-.33.63,4,4,0,0,1-2.26,2.07,4,4,0,0,1-5-5.45,7.72,7.72,0,0,0,.48-1.35L103.74,130A8,8,0,0,0,91,121.76L55.48,150.24c-.23.18-.44.38-.65.58a4,4,0,1,1-5.66-5.65c.12-.12.23-.24.34-.37L94.83,93.41a16,16,0,0,1,12-5.41h42.34a16,16,0,0,1,12,5.41l45.32,51.39c.11.13.22.25.34.37A4,4,0,0,1,206.83,150.82Z">
                                            </path>
                                        </svg>
                                    </span>
                                </span>
                            </div>
                            <h5 class="fw-semibold">Professional Service & Support</h5>
                            <p class="fs-15 text-muted">Our experienced team is dedicated to delivering exceptional service and ensuring your experience is seamless and enjoyable.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Start:: Section-3 -->
    <br>
    <section class="section section-bg" id="booking" style="padding: 1.375rem 0 !important; background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(<?= base_url('assets/images/book.png'); ?>); background-size: cover; background-position: center;">
        <br>
        <div class="container">
            <div class="text-center">
                <h2 class="text-white fw-semibold">Book Your Court</h2>
            </div>

            <!-- Start::row-1 -->
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body p-0">
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
                                                            <img src="<?= base_url('assets/images/court.png'); ?>" width="80%" class="m-2 mobileView" alt="courtA" style="border-radius: 5%;">
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
                                                    <ul class="nav nav-tabs mb-3 tab-style-6 bg-white rounded-pill border-dark" id="myTab1" role="tablist">
                                                        <li class="nav-item" role="presentation"> 
                                                            <label for="courtA" class="court_btn nav-link w-lg rounded-pill text-center" data-value="courtA" data-bs-toggle="tab" role="tab"> <b>Court A</b> </label>
                                                        </li>
                                                        <li class="nav-item" role="presentation"> 
                                                            <label for="courtB" class="court_btn nav-link w-lg rounded-pill text-center" data-value="courtB" data-bs-toggle="tab" role="tab"> <b>Court B</b> </label> &nbsp;
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="calendar-container">
                                                  <div class="calendar-month-arrow-container">
                                                    <div class="calendar-month-year-container">
                                                      <select class="calendar-years"></select>&nbsp;&nbsp;
                                                      <select class="calendar-months"></select>
                                                    </div>
                                                    <div class="calendar-month-year">
                                                    </div>
                                                    <div class="calendar-arrow-container">
                                                      <button type="button" class="calendar-today-button"></button>
                                                      <button type="button" class="calendar-left-arrow"> <i class="bi bi-caret-left-fill"></i> </button>
                                                      <button type="button" class="calendar-right-arrow"> <i class="bi bi-caret-right-fill"></i> </button>
                                                    </div>
                                                  </div>
                                                  <ul class="calendar-week">
                                                  </ul>
                                                  <ul class="calendar-days">
                                                  </ul>
                                                </div>
                                                <input type="hidden" name="court_date" id="court_date" value="<?= date('Y-m-d'); ?>">
                                                <p class="text-center m-2"> 
                                                    <span class="m-2"> <span class="bg-success m-2">&emsp;</span>Selected</span> 
                                                    <span class="m-2"> <span class="cal-disabled m-2">&emsp;</span>Disabled</span> 
                                                </p>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="row mt-4" id="courtCal"></div>
                                            </div>
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
                                                    <input type="text" name="cust_phone" class="form-control" id="cust_phone" oninput="NumberOnly(this, 10)" value="" >
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
                                        </div>
                                    <?php } ?>

                                    <div class="wizard-step" data-title="Confirmation" data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="row gy-3">
                                                    <div class="col-xl-12">
                                                        <label for="paymode"> <b>Payment Mode</b></label>
                                                        <select name="pay_mode" class="form-control" id="paymode">
                                                            <option value="Online">Online</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <label for="coupon_amt"> <b>Coupon</b></label>
                                                        <div class="input-group">
                                                            <input type="text" name="coupon_amt" class="form-control" id="coupon_amt" value="<?= $app_coup_name; ?>">
                                                            <button type="button" class="btn btn-success" id="coupon_apply"> <i id="coupon_icon" class="fas fa-sync fa-spin"></i> Apply </button>
                                                        </div>
                                                        <span class="text-danger error-msg"></span>
                                                    </div>

                                                    <div class="col-xl-12 UPI d-none">
                                                        <h6 class="text-center">UPI Transaction</h6>
                                                        <center><span id="qrcode_upi"></span></center>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">

                                                <div class="col-xl-6">
                                                    <p class="fw-medium text-muted mb-1">Booking Date :</p>
                                                    <p class="fs-15 mb-1" id="book_date_show"></p>
                                                </div>

                                                <div class="checkout-payment-success">
                                                    <div class="col-xl-12 mb-4">
                                                        <div class="table-responsive">
                                                            <table class="table nowrap text-nowrap border mt-4">
                                                                <thead class="table-dark">
                                                                    <tr class="text-center">
                                                                        <th>Area</th>
                                                                        <th>Duration</th>
                                                                        <th>Time</th>
                                                                        <th>Rate ₹</th>
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
                                            <p class="mb-1 fs-14">You will get the booking details to your email address</p>
                                        </div>
                                    </div>
                                </aside>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::row-1 -->
        </div>
    </section>
    <br>
    <section class="section" id="gallery" style="padding: 1.375rem 0 !important;">
        <div class="container">
            <div class="text-center">
                <h2 class="fw-semibold text-success">Gallery</h2>
            </div>
            <div class="row mt-4">
                <div class="owl-carousel owl-theme">
                    <div class="item"><img src="<?= base_url('assets/images/gallery/1.png'); ?>" alt="gallery1" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/2.png'); ?>" alt="gallery2" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/3.png'); ?>" alt="gallery3" class="img-fluid rounded"></div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <section class="section section-bg contactEffect" id="contact" style="padding: 1.375rem 0 !important;">
        <div class="container text-center">
            <h2 class="text-success fw-semibold">Contact Us</h2>
            <h3 class="fw-semibold mt-3 mb-4">We're here to help – reach out now!</h3>
            <div class="card-body p-0">
                <div class="row text-start">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 pe-0">
                        <div class="p-5 bg-light rounded">
                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <div class="">
                                        <div class="fs-18 text-primary fw-medium mb-3">Contact Information</div>
                                        <div class="mb-3 text-default"> <i class="ri-map-pin-fill me-2 text-primary"></i><a href="https://maps.app.goo.gl/qj95w6i4F1qFAESt5" target="_blank">No 18/81 F block, 2nd main road, Annanagar east Chennai - 600102.</a></div>
                                        <div class="d-flex mb-3"> <i
                                                class="ri-phone-fill me-2 d-inline-block text-primary"></i>
                                            <div class="text-default">
                                                <div><a href="tel: +91 9677033077">+91 9677033077</a></div>
                                            </div>
                                        </div>
                                        <div class="mb-4 text-default"><i class="ri-mail-fill me-2 d-inline-block text-primary"></i>
                                            <a href="mailto: Winkin365@gmail.com">Winkin365@gmail.com</a></div>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 pe-0">
                        <div class="p-2 landing-contact-info border rounded">
                            
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15544.795308577857!2d80.220397!3d13.086582!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a526425fa9a5ef1%3A0xc7007b3aa75415e9!2s18%2C%202nd%20Main%20Rd%2C%20Block%20E%2C%20Annanagar%20East%2C%20Chennai%2C%20Tamil%20Nadu%20600102!5e0!3m2!1sen!2sin!4v1737467311601!5m2!1sen!2sin" width="100%" height="260" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br> <hr>
<!-- End:: Section-2 -->


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
            $('.sign-up-tab').addClass('d-none');
            $('.sign-in-tab').removeClass('d-none');
            $('.next').attr('disabled', 'disabled');
        } else {
            $('.sign-btn').html('Already have an account? <a href="javascript:void(0)" id="sign-btn" data-title="sign-in" class="text-info"> SIGN IN </a> ');
            $('.sign-in-tab').addClass('d-none');
            $('.sign-up-tab').removeClass('d-none'); 
            $('.next').removeAttr('disabled');
        }
    });


    $('body').on('click', "input[name='times[]']", function() {

        var element = $("input[name='times[]']").parent().parent().parent().parent();
        var checkedElement = $("input[name='times[]']:checked").parent().parent().parent().parent(); 
        element.removeClass('time-active btn-success text-white').addClass('btn-outline-success');
        checkedElement.removeClass('btn-outline-success').addClass('time-active btn-success text-white');

        var selCourt = $("input[type=radio][name='court']:checked").val();  
        var selCourtDur = $("input[name='court_dura[courtA]']").val();
        var CourtRate = $("input[type=radio][name='court']:checked").data('rate');

        var courttimings = [];
        $("input[type=checkbox][name='times[]']:checked").each(function() {
            courttimings.push($(this).val());
        });
        $('#billbody, #billfoot').empty();
        var tbody = "";
        var tfoot = "";
        var courttotal = 0;
        for(var c = 0; c < courttimings.length; c++) {
            var endTime = DisplayTime(courttimings[c], parseInt(selCourtDur));
             tbody += "<tr class='text-center'><td>" + selCourt + "</td> <td>" + selCourtDur + " mins</td> <td>" + courttimings[c] + " - " + endTime + "</td> <td>" + CourtRate + "</td> </tr>";
            courttotal += parseFloat(CourtRate);
        }

        var paymentAmount = courttotal * 0.02;
        var total = (courttotal / 1.18);
        var storeGstAmount = courttotal * 0.18;
        var grandTotal = total * 1.18;

        tfoot += "<tr class='showCoupon d-none'><td colspan='3' align='right'> <b>Coupon Percent % :</b> </td> <td align='center' id='coupon_Percent'></td></tr> <tr class='showCoupon d-none'><td colspan='3' align='right'> <b>Coupon Amount :</b> </td> <td align='center' id='coupon_Amount'></td></tr> <tr><td colspan='3' align='right'> <b>Subtotal :</b> </td> <td align='center' id='sub_Amount'>"+courttotal+"</td> <input type='hidden' id='cpid' name='fld_acpid' /> <input type='hidden' name='fld_acppercent' id='cperc' /> <input type='hidden' name='fld_acpamt' id='cpamt' /> <input type='hidden' name='old_amount' id='old_amount' value="+grandTotal+" /> <input type='hidden' name='gst_amount' id='gst_amount' value="+storeGstAmount+" /><input type='hidden' name='payment_amount' id='payment_amount' value="+paymentAmount+" /> </tr><tr><td colspan='3' align='right'> <b>Total :</b> <br> <small>(Including GST)</small> </td> <td align='center' id='total_Amount'>"+grandTotal+"</td></tr>";
        $('#billbody').append(tbody);
        $('#billfoot').append(tfoot);

        $("#book_date_show").html(displayDate($("#court_date").val()));
    });


    $('body').on('click', ".time-btn0", function() {
        var element = $(this).children().children().children().children();
        var input = element[1];

        $(input).prop('checked', false);
        if (!$(input).prop('checked')) {
            $(input).prop('checked', true);
        } 

        var element = $("input[name='times[]']").parent().parent().parent().parent();
        var checkedElement = $("input[name='times[]']:checked").parent().parent().parent().parent(); 
        element.removeClass('time-active btn-success text-white').addClass('btn-outline-success');
        checkedElement.removeClass('btn-outline-success').addClass('time-active btn-success text-white');

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
    var tbody = "";
    var tfoot = "";
    var courttotal = 0;
    for(var c = 0; c < courttimings.length; c++) {
        var endTime = DisplayTime(courttimings[c], parseInt(selCourtDur));
         tbody += "<tr class='text-center'><td>" + selCourt + "</td> <td>" + selCourtDur + " mins</td> <td>" + courttimings[c] + " - " + endTime + "</td> <td>" + CourtRate + "</td> </tr>";
        courttotal += parseFloat(CourtRate);
    }

    var paymentAmount = courttotal * 0.02;
    var total = (courttotal / 1.18);
    var storeGstAmount = courttotal * 1.18;
    var grandTotal = total * 1.18;

    tfoot += "<tr class='showCoupon d-none'><td colspan='3' align='right'> <b>Coupon Percent % :</b> </td> <td align='center' id='coupon_Percent'></td></tr> <tr class='showCoupon d-none'><td colspan='3' align='right'> <b>Coupon Amount :</b> </td> <td align='center' id='coupon_Amount'></td></tr> <tr><td colspan='3' align='right'> <b>Subtotal :</b> </td> <td align='center' id='sub_Amount'>"+courttotal+"</td> <input type='hidden' id='cpid' name='fld_acpid' /> <input type='hidden' name='fld_acppercent' id='cperc' /> <input type='hidden' name='fld_acpamt' id='cpamt' /> <input type='hidden' name='old_amount' id='old_amount' value="+grandTotal+" /><input type='hidden' name='gst_amount' id='gst_amount' value="+storeGstAmount+" /> <input type='hidden' name='payment_amount' id='payment_amount' value="+paymentAmount+" /> </tr><tr><td colspan='3' align='right'> <b>Total :</b> <br> <small>(Including GST)</small> </td> <td align='center' id='total_Amount'>"+grandTotal+"</td></tr>";
        "</td> </tr>";

    $('#billbody').append(tbody);
    $('#billfoot').append(tfoot);

    /* -------- Check the mobile number exist or not --------- */
    $('#cust_phone').on('keyup', function() {
        var phone = $(this).val();
        var element = $('#cust_phone').parent().parent().children('span');
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
            getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]: csrfHash, court:courts, date:appdate, apptime:apptime}, 'courtCal');
        }
    });


    /* -------- when click calendar date active change calender date --------- */
    $("body").on("click", ".cal-date", function(event) {
        var court = $("input[type=radio][name='court']:checked").val();

        var selectedDate = $(this).data('date');
        $('#court_date').val(selectedDate);
        $('.cal-date').removeClass('calendar-day-active');
        $(this).addClass('calendar-day-active');

        $('#courtCal').empty();
        if(selectedDate != "" && court != "") {
            getdetails('<?= base_url('getCourtTiming') ?>', {[csrfName]:csrfHash, court:court, date:selectedDate, apptime:apptime}, 'courtCal');
        }

    });


    $("#signin_phone, #cust_password").on("keyup", function() {
        $('.next').attr('disabled', 'disabled');
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
                    $('.login-alert').html('sign-in successfully!!!').removeClass('alert-danger').addClass('alert alert-success');
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
        $.ajax({
            url: '<?= base_url('payment_create'); ?>',
            type: 'POST',
            data:{[csrfName]:csrfHash, amount:$("#total_Amount").text(), gst:$("#gst_amount").val(), pay_charge: $("#payment_amount").val()},
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
                                    payment_status: response.payment_status
                                },
                                dataType: 'json',
                                success: function (data) {

                                    if (data.status === 'Payment Successfull') {
                                        var formData = $("#cust_appointment_form").serializeArray();
                                        formData.push({ name: 'pay_id', value: data.payment_id });
                                        formData.push({ name: 'ord_id', value: data.order_id });
                                        formData.push({ name: 'signature', value: data.signature });
                                        formData.push({ name: 'pay_mode', value: data.pay_mode });
                                        formData.push({ name: csrfName, value: csrfHash });
                                        submitButton.prop('disabled', true).text('Loading...');
                                        $.ajax({
                                            url: '<?= base_url('add_cust_booking') ?>',
                                            type: 'post',
                                            data : formData,
                                            dataType: 'json',
                                            success:function(result) {
                                                if(result.status == 200) {
                                                    AlertPopup('Success!', 'Appointment Booked Successfully!', 'success', 'Ok', 'mybookings');
                                                    submitButton.prop('disabled', false).text('Pay Now');
                                                } else {
                                                    AlertPopup('Error!', 'Appointment Not Booked!!!', 'error', 'Ok', 'mybookings');
                                                }
                                            }
                                        });
                                    } else {
                                       AlertPopup('Success!', 'Appointment Booked Successfully!', 'success', 'Ok', 'mybookings');
                                    }
                                },
                                error: function (err) {
                                    AlertPopup('Error!', 'Payment verification failed. Please try again.', 'error', 'Ok', 'mybookings');
                                }
                            });
                        },
                        "prefill": {
                            "name": "Customer Name", 
                            "email": "customer@example.com", 
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
            }
        });
    });

    applycoupon($('#coupon_amt').val(), $('#old_amount').val());
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
            $('#total_Amount').text(totalAmount);
            $('.showCoupon').addClass('d-none');
            $('#coupon_apply').text('Apply');
        }
    });
});


function applycoupon(coupon_name, totalamt) {

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    console.log(totalamt, "totalamt");
    $('.showCoupon').addClass('d-none');
    $('#coupon_apply').prop('disabled', true);
    $('#coupon_icon').removeClass().addClass('fas fa-sync fa-spin');

    var action = validation({'coupon_amt':coupon_amt});
    if(action === false) { return action; }
    
    $.ajax({
        url: '<?= base_url('get_coupons'); ?>',
        type: 'POST',
        data: { [csrfName]:csrfHash, coupon_amt:coupon_name, totalAmount:totalamt},
        dataType: 'json',
        success:function(res) {
            $('#total_Amount').text(res.finalamount);
            if(res.status == 200) {
                $('.showCoupon').removeClass('d-none');
                $('#coupon_Percent').text(res.percent + '%');
                $('#coupon_Amount').text(res.percentamount);
                $('#total_Amount').text(res.finalamount);
                $('#cpid').val(res.coupon_id);
                $('#cperc').val(res.percent);
                $('#cpamt').val(res.percentamount);
                $('#coupon_icon').removeClass().addClass('fas fa-check-circle'); 
                $('#coupon_apply').removeClass('btn-success').addClass('btn-primary'); 
                $('#coupon_apply').text('Applied');
            } else {
                $('#coupon_icon').removeClass().addClass('fas fa-times-circle'); 
                $('#coupon_apply').text('Apply');
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

gsap.fromTo("#heading", 
    { y: -30, opacity: 0 }, 
    { y: 0, opacity: 1, duration: 2, repeat: -1, yoyo: true, ease: "bounce" }
);
  
gsap.fromTo("#main-text", 
    { y: -20, opacity: 0 }, 
    { y: 0, opacity: 1, duration: 2, repeat: -1, yoyo: true, ease: "bounce" }
);

gsap.fromTo("#sub-text", 
    { y: -10, opacity: 0 }, 
    { y: 0, opacity: 1, duration: 2, repeat: -1, yoyo: true, ease: "bounce" }
);

window.addEventListener("load", function() {
    gsap.fromTo("#booking", 
        { scale: 1.2, opacity: 0 },
        { scale: 1, opacity: 1, duration: 2, ease: "power2.out" } 
    );

    gsap.fromTo("#about", 
      { x: -50, opacity: 0 }, 
      { x: 0, opacity: 1, duration: 1.5, ease: "power2.out" }
    );

    gsap.fromTo(".chooseeffect", 
      { y: -300, opacity: 0 }, 
      { y: 0, opacity: 1, duration: 1.5, ease: "bounce.out"}
    );
   
    gsap.fromTo(".contactEffect", 
      { y: 100, opacity: 0 },
      { y: 0, opacity: 1, duration: 1, ease: "power3.out", stagger: 0.2 }
    );
});

// UPI Qr Generate
function handlePaymentMethodChange() 
{
    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    var paymentMethod = $('input[name="paymethode"]:checked').val(); 
    var amount = $('#total_Amount').text(); 
    
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