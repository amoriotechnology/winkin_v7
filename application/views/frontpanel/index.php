<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/booking_style.css'); ?>" />
<script src="<?= base_url('assets/js/gsap.min.js'); ?>"></script>

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
    .owl-nav {
        display: none;
    }

    @media (min-width: 780px) { 
        .main-banner-container {
            margin-left: 140px !important;
        }
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
                                <h6 class="fw-medium op-9" id="heading" style="color: #000;"><b>Winkin's Pickle Ball Zone</b></h6>
                            </div>
                            <p class="landing-banner-heading mb-3" id="main-text">Play, compete, and enjoy<br> <span class="fw-semibold">Pickle Ball</span> is waiting for you</p>
                            <!--<div class="fs-16 mb-4 op-7" id="sub-text" style="color: #000;">Join the action at Winkin and experience the thrill of every match!</div>-->
                            <a href="<?= base_url('booking'); ?>" class="btn btn-primary p-3 fs-18" id="about"><b>Book Now</b></a>
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
    position: relative;" >
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
                        <div class="heading-description fs-16 mt-4" style="text-align: justify;">At <b class="text-primary">Winkin</b>, our business is all about bringing people together through fun, energy, and active living. We focus on providing unique experiences and high-quality solutions for sports enthusiasts. Whether you're a beginner or a seasoned player, we aim to make it accessible, enjoyable, and memorable for everyone. With a passion for community and a commitment to excellence, Winkin’s is here to inspire and engage players of all levels. Join us in celebrating this fast-growing, exciting sport and experience  joy with <b class="text-primary">Winkin</b>!</div>
                    </div>
                    <div class="row gy-3 mb-0">
                        <div class="col-xl-12">
                            <div class="d-flex align-items-top">
                                <div class="me-2 home-prove-svg">
                                    <i class="ri-shining-line align-middle fs-14 text-primary d-inline-block"></i>
                                </div>
                                <div>
                                    <span class="fs-15"> Easy and Inclusive </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="d-flex align-items-top">
                                <div class="me-2 home-prove-svg">
                                    <i class="ri-shining-line align-middle fs-14 text-primary d-inline-block"></i>
                                </div>
                                <div>
                                    <span class="fs-15"> Health and Fitness </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 mt-4 text-center">
                           <a href="<?= base_url('booking'); ?>" class="btn btn-primary fs-18"><b>Book Now</b></a>
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
                        <p class="fs-15 mb-5 fw-normal">Your trusted partner for seamless experiences, great value, and exceptional service.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="card custom-card landing-card border shadow-none">
                        <div class="card-body">
                            <div class="text-center mb-4">
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
                            <h5 class="text-center fw-semibold">Flexible booking system</h5>
                            <p class="fs-15">We offer a user-friendly and adaptable booking process, ensuring convenience and ease for all our customers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card custom-card landing-card border shadow-none">
                        <div class="card-body">
                            <div class="text-center mb-4">
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
                            <h5 class="text-center fw-semibold">Professional Service</h5>
                            <p class="fs-15">Our experienced team is dedicated to delivering exceptional service and ensuring your experience is seamless and enjoyable.</p>
                        </div>
                    </div>
                </div>
                <div id="gallery"  class="col-xl-4">
                    <div class="card custom-card landing-card border shadow-none">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <span class="avatar avatar-xl bg-primary-transparent">
                                    <span class="avatar avatar-lg bg-primary svg-white">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256" fill="#000000">
    <path d="M48,88H176a40,40,0,0,1,0,80H48Z" opacity="0.2"></path>
    <path d="M176,80H48a8,8,0,0,0-8,8v48a48,48,0,0,0,48,48h96a40,40,0,0,0,0-80ZM88,176a32,32,0,0,1-32-32V96h120a24,24,0,0,1,0,48Z"></path>
    <path d="M80,48s0,12,0,16-4,8-4,8,8,0,12-4,4-12,4-12S80,48,80,48Z"></path>
    <path d="M112,48s0,12,0,16-4,8-4,8,8,0,12-4,4-12,4-12S112,48,112,48Z"></path>
    <path d="M144,48s0,12,0,16-4,8-4,8,8,0,12-4,4-12,4-12S144,48,144,48Z"></path>
    <path d="M48,200a8,8,0,0,0,0,16H192a8,8,0,0,0,0-16Z"></path>
</svg>


                                    </span>
                                </span>
                            </div>
                            <h5 class="text-center fw-semibold">Café</h5>
                            <p style="text-align: justify;padding-bottom: 23px;" class="fs-15">A cozy space to unwind, enjoy, and savor delightful moments.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Start:: Section-3 -->
    <br>
    <section class="section" style="padding: 1.375rem 0 !important;">
        <div class="container">
            <div class="text-center">
                <h2 class="fw-semibold text-success">Gallery</h2>
            </div>
            <div class="row mt-4">
                <div class="owl-carousel owl-theme">
                    <div class="item"><img src="<?= base_url('assets/images/gallery/1.png'); ?>" alt="gallery1" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/2.png'); ?>" alt="gallery2" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/3.png'); ?>" alt="gallery3" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/6.png'); ?>" alt="gallery6" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/7.png'); ?>" alt="gallery7" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/4.png'); ?>" alt="gallery5" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/1.png'); ?>" alt="gallery1" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/2.png'); ?>" alt="gallery2" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/3.png'); ?>" alt="gallery3" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/7.png'); ?>" alt="gallery7" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/6.png'); ?>" alt="gallery6" class="img-fluid rounded"></div>
                    <div class="item"><img src="<?= base_url('assets/images/gallery/4.png'); ?>" alt="gallery5" class="img-fluid rounded"></div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <section class="section section-bg contactEffect" id="contact" style="padding: 1.375rem 0 !important; background-image: url('assets/images/bg-footer.png');">
        <div class="container text-center">
            <h2 class="text-white fw-semibold">Contact Us</h2>
            <h3 class="text-white fw-semibold mt-3 mb-4">We're here to help – reach out now!</h3>
            <div class="card-body p-0">
                <div class="row text-start">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 pe-2 mt-2">
                        <div class="p-5 bg-light rounded">
                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <div class="">
                                        <div class="fs-18 text-dark fw-medium mb-3">Contact Information</div>
                                        <div class="mb-3 text-dark"> <i class="ri-map-pin-fill me-2 text-primary"></i><a href="https://maps.app.goo.gl/qj95w6i4F1qFAESt5" target="_blank">No 18/81 F block, 2nd main road, Annanagar east Chennai - 600102.</a></div>
                                         <div class="d-flex mb-3"> <i class="ri-phone-fill me-2 d-inline-block text-primary"></i>
                                            <div class="text-dark">
                                                <div><a href="tel: +91 9940700179">+91 9940700179</a></div>
                                            </div>
                                        </div> 
                                        <div class="mb-4 text-dark"><i class="ri-mail-fill me-2 d-inline-block text-primary"></i>
                                            <a href="mailto: support@winkin.in">support@winkin.in</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 pe-2 mt-2">
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
    
});


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

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.side-menu__item').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');

            if (href.includes('#')) {
                e.preventDefault();
                const targetId = href.split('#')[1]; // Extract section ID
                const target = document.getElementById(targetId);

                if (target) {
                    setTimeout(() => {
                        const headerOffset = href.includes("#gallery") ? -160 : -45; // Adjust offset
                        const elementPosition = target.getBoundingClientRect().top + window.scrollY;
                        const offsetPosition = elementPosition - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: "smooth" // Smooth but fast scroll
                        });
                    }, 200); // Reduced delay to 0.2 seconds for quicker action
                }
            }
        });
    });
});


</script>


<!-- Date & Time Picker JS -->
<script src="<?= base_url(); ?>/assets/libs/flatpickr/flatpickr.min.js"></script>


<!-- Sticky JS -->
<script src="<?= base_url(); ?>/assets/js/sticky.js"></script>