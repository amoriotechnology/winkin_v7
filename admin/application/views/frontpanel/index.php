<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed" data-theme-mode="light">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
        
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Laravel Bootstrap Responsive Admin Web Dashboard Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="">

	<!-- TITLE -->
    <title>Winkin - Admin Panel</title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url(); ?>assets/images/brand-logos/favicon.ico" type="image/x-icon">

    <!-- ICONS CSS -->
    <link href="<?= base_url(); ?>assets/icon-fonts/icons.css" rel="stylesheet">

    <!-- Bootstrap Css -->
    <link id="style" href="<?= base_url(); ?>assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="<?= base_url(); ?>assets/libs/node-waves/waves.min.css" rel="stylesheet">

    <!-- SwiperJS Css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/swiper/swiper-bundle.min.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/@simonwep/pickr/themes/nano.min.css">

    <!-- Choices Css -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/choices.js/public/assets/styles/choices.min.css">

    <script>
        if (localStorage.udonlandingdarktheme) {
            document.querySelector("html").setAttribute("data-theme-mode", "dark")
        }
        if (localStorage.udonlandingrtl) {
            document.querySelector("html").setAttribute("dir", "rtl")
            document.querySelector("#style")?.setAttribute("href", "<?= base_url(); ?>assets/libs/bootstrap/css/bootstrap.rtl.min.css");
        }
    </script>        
    <!-- APP CSS & APP SCSS -->
    <link rel="preload" as="style" href="<?= base_url(); ?>assets/css/app.css" /><link rel="stylesheet" href="<?= base_url(); ?>assets/css/app.css" />

</head>

    <body class="landing-body">

        <!-- Switcher -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Switcher</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="">
                <p class="switcher-style-head">Theme Color Mode:</p>
                <div class="row switcher-style">
                    <div class="col-4">
                        <div class="form-check switch-select">
                            <label class="form-check-label" for="switcher-light-theme">
                                Light
                            </label>
                            <input class="form-check-input" type="radio" name="theme-style" id="switcher-light-theme"
                                checked>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-check switch-select">
                            <label class="form-check-label" for="switcher-dark-theme">
                                Dark
                            </label>
                            <input class="form-check-input" type="radio" name="theme-style" id="switcher-dark-theme">
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <p class="switcher-style-head">Directions:</p>
                <div class="row switcher-style">
                    <div class="col-4">
                        <div class="form-check switch-select">
                            <label class="form-check-label" for="switcher-ltr">
                                LTR
                            </label>
                            <input class="form-check-input" type="radio" name="direction" id="switcher-ltr" checked>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-check switch-select">
                            <label class="form-check-label" for="switcher-rtl">
                                RTL
                            </label>
                            <input class="form-check-input" type="radio" name="direction" id="switcher-rtl">
                        </div>
                    </div>
                </div>
            </div>
            <div class="theme-colors">
                <p class="switcher-style-head">Theme Primary:</p>
                <div class="d-flex align-items-center switcher-style">
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-1" type="radio" name="theme-primary"
                            id="switcher-primary">
                    </div>
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-2" type="radio" name="theme-primary"
                            id="switcher-primary1">
                    </div>
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-3" type="radio" name="theme-primary"
                            id="switcher-primary2">
                    </div>
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-4" type="radio" name="theme-primary"
                            id="switcher-primary3">
                    </div>
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-5" type="radio" name="theme-primary"
                            id="switcher-primary4">
                    </div>
                    <div class="form-check switch-select me-3 ps-0 mt-1 color-primary-light">
                        <div class="theme-container-primary"></div>
                        <div class="pickr-container-primary"></div>
                    </div>
                </div>
            </div>
            <div>
                <p class="switcher-style-head">reset:</p>
                <div class="text-center">
                    <button id="reset-all" class="btn btn-danger mt-3">Reset</button>
                </div>
            </div>
        </div>
    </div>        <!-- End switcher -->

        <div class="landing-page-wrapper">

            <!-- Main-Header -->
            <header class="app-header">

			<!-- Start::main-header-container -->
			<div class="main-header-container container-fluid">

				<!-- Start::header-content-left -->
				<div class="header-content-left">

					<!-- Start::header-element -->
					<div class="header-element">
						<div class="horizontal-logo">
							<a href="index.html" class="header-logo">
								<img src="<?= base_url(); ?>assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
								<img src="<?= base_url(); ?>assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
							</a>
						</div>
					</div>
					<!-- End::header-element -->

					<!-- Start::header-element -->
					<div class="header-element">
						<!-- Start::header-link -->
						<a href="javascript:void(0);" class="sidemenu-toggle header-link" data-bs-toggle="sidebar">
							<span class="open-toggle">
								<i class="ri-menu-3-line fs-20"></i>
							</span>
						</a>
						<!-- End::header-link -->
					</div>
					<!-- End::header-element -->

				</div>
				<!-- End::header-content-left -->

				<!-- Start::header-content-right -->
				<div class="header-content-right">

					<!-- Start::header-element -->
					<div class="header-element align-items-center">
						<!-- Start::header-link|switcher-icon -->
						<div class="btn-list d-lg-none d-flex">
							<a href="sign-up-basic.html" class="btn btn-primary-light">
								Sign Up
							</a>
							<button class="btn btn-icon btn-success switcher-icon d-flex align-items-center justify-content-center" data-bs-toggle="offcanvas"
								data-bs-target="#switcher-canvas">
								<i class="ri-settings-3-line"></i>
							</button>
						</div>
						<!-- End::header-link|switcher-icon -->
					</div>
					<!-- End::header-element -->

				</div>
				<!-- End::header-content-right -->

			</div>
			<!-- End::main-header-container -->

		</header>            <!-- End Main-Header -->

            <!-- Main-Sidebar -->
            <aside class="app-sidebar sticky" id="sidebar">

            <div class="container-xl">
                <!-- Start::main-sidebar -->
                <div class="main-sidebar">

                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills sub-open">
                        <div class="landing-logo-container">
                            <div class="horizontal-logo">
                                <a href="index.html" class="header-logo">
                                    <img src="<?= base_url(); ?>assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                                    <img src="<?= base_url(); ?>assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-dark">
                                </a>
                            </div>
                        </div>
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                            </svg></div>
                        <ul class="main-menu">
                            <!-- Start::slide -->
                            <li class="slide">
                                <a class="side-menu__item" href="#home">
                                    <span class="side-menu__label">Home</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#about" class="side-menu__item">
                                    <span class="side-menu__label">About</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class="side-menu__label me-2">More</span>
                                    <i class="fe fe-chevron-right side-menu__angle op-8"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="#services" class="side-menu__item">Services</a>
                                    </li>
                                    <li class="slide">
                                        <a href="#expectations" class="side-menu__item">Expectations</a>
                                    </li>
                                    <li class="slide">
                                        <a href="#features" class="side-menu__item">Features</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Level-2
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="javascript:void(0);" class="side-menu__item">Level-2-1</a>
                                            </li>
                                            <li class="slide has-sub">
                                                <a href="javascript:void(0);" class="side-menu__item">Level-2-2
                                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                                <ul class="slide-menu child3">
                                                    <li class="slide">
                                                        <a href="javascript:void(0);"
                                                            class="side-menu__item">Level-2-2-1</a>
                                                    </li>
                                                    <li class="slide has-sub">
                                                        <a href="javascript:void(0);"
                                                            class="side-menu__item">Level-2-2-2</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#pricing" class="side-menu__item">
                                    <span class="side-menu__label">Pricing</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#team" class="side-menu__item">
                                    <span class="side-menu__label">Team</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#faqs" class="side-menu__item">
                                    <span class="side-menu__label">FAQ's</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#testimonials" class="side-menu__item">
                                    <span class="side-menu__label">Testimonials</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#contact" class="side-menu__item">
                                    <span class="side-menu__label">Contact Us</span>
                                </a>
                            </li>
                            <!-- End::slide -->

                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                </path>
                            </svg></div>
                        <div class="d-lg-flex d-none">
                            <div class="btn-list d-lg-flex d-none mt-lg-2 mt-xl-0 mt-0">
                                <a href="sign-up-basic.html" class="btn btn-wave btn-secondary">
                                    Sign Up
                                </a>
                                <button class="btn btn-wave btn-icon btn-light switcher-icon d-flex align-items-center justify-content-center" data-bs-toggle="offcanvas"
                                    data-bs-target="#switcher-canvas">
                                    <i class="ri-settings-3-line"></i>
                                </button>
                            </div>
                        </div>
                    </nav>
                    <!-- End::nav -->

                </div>
                <!-- End::main-sidebar -->
            </div>

        </aside>            <!-- End Main-Sidebar -->

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
                                        <h6 class="fw-medium text-fixed-white op-9">BRILLIANCE IN EXECUTION</h6>
                                    </div>
                                    <p class="landing-banner-heading mb-3">Your sure stop place for best theme ends here
                                        with <span class="fw-semibold">Vertix</span></p>
                                    <div class="fs-16 mb-5 text-fixed-white op-7">Vertix - Now you can use this admin
                                        template to design stunning dashboards that will wow your target viewers or
                                        users to no end.</div>
                                    <a href="index.html" class="m-1 btn btn-lg bg-white-transparent" target="_blank">
                                        View Demos
                                        <i class="ri-eye-line ms-2 align-middle"></i>
                                    </a>
                                    <a href="index.html" target="_blank"
                                        class="m-1 btn btn-lg text-fixed-white border border-white border-opacity-25 btn-wave waves-effect waves-light">
                                        Learn More
                                        <i class="ri-arrow-right-line ms-2 align-middle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4 my-auto">
                                <div class="text-end landing-main-image landing-heading-img">
                                    <img src="<?= base_url(); ?>assets/images/media/landing/1.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- End:: Section-1 -->

            <!-- Start:: Section-2 -->
            <section class="section" id="about">
                <div class="container position-relative">
                    <div class="text-center">
                        <p class="fs-12 fw-medium text-success mb-1"><span
                                class="landing-section-heading text-primary">GLANCE</span>
                        </p>
                        <h3 class="fw-semibold mb-2 mt-3">Why you choose us ?</h3>
                        <div class="row justify-content-center">
                            <div class="col-xl-7">
                                <p class="text-muted fs-15 mb-5 fw-normal">Our mission is to support you in achieving
                                    your goals.</p>
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
                                    <h4 class="fw-semibold">Smart Services</h4>
                                    <p class="fs-15 text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing
                                        elitipsum dolor sit, amet consectetur</p>
                                    <a href="javascript:void(0);" class="fw-medium text-primary">Read More<i
                                            class="ti ti-arrow-narrow-right ms-2 fs-5 align-middle"></i></a>
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
                                    <h4 class="fw-semibold">24/7 Customer Support</h4>
                                    <p class="fs-15 text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing
                                        elitipsum dolor sit, amet consectetur</p>
                                    <a href="javascript:void(0);" class="fw-medium text-primary">Read More<i
                                            class="ti ti-arrow-narrow-right ms-2 fs-5 al align-middle"></i></a>
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
                                    <h4 class="fw-semibold">Experienced Staff</h4>
                                    <p class="fs-15 text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing
                                        elitipsum dolor sit, amet consectetur</p>
                                    <a href="javascript:void(0);" class="fw-medium text-primary">Read More<i
                                            class="ti ti-arrow-narrow-right ms-2 fs-5 align-middle"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-2 -->

            <!-- Start:: Section-3 -->
            <section class="section section-bg" id="expectations">
                <div class="container">
                    <div class="row gx-5 mx-0">
                        <div class="col-xl-5">
                            <div class="home-proving-image">
                                <img src="<?= base_url(); ?>assets/images/media/landing/2.png" alt="" class="img-fluid] about-image d-none d-xxl-block">
                            </div>
                            <div class="proving-pattern-1"></div>
                        </div>
                        <div class="col-xxl-7 col-xl-12 my-auto">
                            <div class="heading-section text-start mb-4">
                                <p class="fs-12 fw-medium text-start text-success mb-1"><span
                                        class="landing-section-heading text-primary">ABOUT US</span>
                                </p>
                                <h3 class="mt-3 fw-semibold mb-2">Exceeding your Expectations !</h3>
                                <div class="heading-description fs-16">Welcome to Vibro, where we offer a unique and
                                    tailored
                                    experience that is sure to exceed your expectations. Choose us and let us show you
                                    what true excellence looks like</div>
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
                                                We have years of experience in our industry and have built a reputation.
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
                                                Our team is made up of experienced and professional individuals.
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
                                                We understand that every client is unique, and we tailor our services.
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
                                                Our services are designed to be convenient and hassle-free, saving you
                                                time and effort.
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
                                                We provide 24/7 support each day in a week for all 365 days.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-3 -->

            <!-- Start:: Section-4 -->
            <section class="section" id="services">
                <div class="container">
                    <div class="text-center">
                        <p class="fs-12 fw-medium text-success mb-1"><span
                                class="landing-section-heading text-primary">SERVICES</span>
                        </p>
                        <h3 class="fw-semibold mt-3 mb-2">Best Services You Get</h3>
                        <div class="row justify-content-center">
                            <div class="col-xl-7">
                                <p class="text-muted fs-15 mb-5 fw-normal">Nemo enim ipsam voluptatem quia voluptas sit
                                    aspernatur</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <span
                                            class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M215,168.71a96.42,96.42,0,0,1-30.54,37l-9.36-9.37a8,8,0,0,0-3.63-2.09L150,188.59a8,8,0,0,1-5.88-8.9l2.38-16.2a8,8,0,0,1,4.84-6.22l30.46-12.66a8,8,0,0,1,8.47,1.49ZM159.89,105,182.06,79.2A8,8,0,0,0,184,74V50A96,96,0,0,0,50.49,184.65l9.92-6.52A8,8,0,0,0,64,171.49l.21-36.23a8.06,8.06,0,0,1,1.35-4.41l20.94-31.3a8,8,0,0,1,11.34-2l19.81,13a8.06,8.06,0,0,0,5.77,1.45l31.46-4.26A8,8,0,0,0,159.89,105Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,16a87.5,87.5,0,0,1,48,14.28V74L153.83,99.74,122.36,104l-.31-.22L102.38,90.92A16,16,0,0,0,79.87,95.1L58.93,126.4a16,16,0,0,0-2.7,8.81L56,171.44l-3.27,2.15A88,88,0,0,1,128,40ZM62.29,186.47l2.52-1.65A16,16,0,0,0,72,171.53l.21-36.23L93.17,104a3.62,3.62,0,0,0,.32.22l19.67,12.87a15.94,15.94,0,0,0,11.35,2.77L156,115.59a16,16,0,0,0,10-5.41l22.17-25.76A16,16,0,0,0,192,74V67.67A87.87,87.87,0,0,1,211.77,155l-16.14-14.76a16,16,0,0,0-16.93-3l-30.46,12.65a16.08,16.08,0,0,0-9.68,12.45l-2.39,16.19a16,16,0,0,0,11.77,17.81L169.4,202l2.36,2.37A87.88,87.88,0,0,1,62.29,186.47ZM185,195l-4.3-4.31a16,16,0,0,0-7.26-4.18L152,180.85l2.39-16.19L184.84,152,205,170.48A88.43,88.43,0,0,1,185,195Z">
                                                </path>
                                            </svg>
                                    </div>
                                    <h6 class="fw-semibold">Business Audit</h6>
                                    <p class="fs-15 text-muted mb-0">Justo aliquyam duo vero clita aliquyam vero eirmod
                                        stet amet dolorem ipsum.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <div class="mb-4">
                                            <span
                                                class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M224,128a96,96,0,1,1-96-96A96,96,0,0,1,224,128Z"
                                                        opacity="0.2"></path>
                                                    <path
                                                        d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm40-68a28,28,0,0,1-28,28h-4v8a8,8,0,0,1-16,0v-8H104a8,8,0,0,1,0-16h36a12,12,0,0,0,0-24H116a28,28,0,0,1,0-56h4V72a8,8,0,0,1,16,0v8h16a8,8,0,0,1,0,16H116a12,12,0,0,0,0,24h24A28,28,0,0,1,168,148Z">
                                                    </path>
                                                </svg>
                                        </div>
                                    </div>
                                    <h6 class="fw-semibold">Marketing</h6>
                                    <p class="fs-15 text-muted mb-0">Sed ut perspiciatis unde omnis natus error sit
                                        voluptatem accusantium.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <div class="mb-4">
                                            <span
                                                class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M208,40V208H152V40Z" opacity="0.2"></path>
                                                    <path
                                                        d="M224,200h-8V40a8,8,0,0,0-8-8H152a8,8,0,0,0-8,8V80H96a8,8,0,0,0-8,8v40H48a8,8,0,0,0-8,8v64H32a8,8,0,0,0,0,16H224a8,8,0,0,0,0-16ZM160,48h40V200H160ZM104,96h40V200H104ZM56,144H88v56H56Z">
                                                    </path>
                                                </svg>
                                        </div>
                                    </div>
                                    <h6 class="fw-semibold">Trading</h6>
                                    <p class="fs-15 text-muted mb-0">Quasi architecto beatae vitae dicta sunt explicabo.
                                        Nemo enim.trande your product.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <span
                                            class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path d="M224,64l-12.16,66.86A16,16,0,0,1,196.1,144H70.55L56,64Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M230.14,58.87A8,8,0,0,0,224,56H62.68L56.6,22.57A8,8,0,0,0,48.73,16H24a8,8,0,0,0,0,16h18L67.56,172.29a24,24,0,0,0,5.33,11.27,28,28,0,1,0,44.4,8.44h45.42A27.75,27.75,0,0,0,160,204a28,28,0,1,0,28-28H91.17a8,8,0,0,1-7.87-6.57L80.13,152h116a24,24,0,0,0,23.61-19.71l12.16-66.86A8,8,0,0,0,230.14,58.87ZM104,204a12,12,0,1,1-12-12A12,12,0,0,1,104,204Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,200,204Zm4-74.57A8,8,0,0,1,196.1,136H77.22L65.59,72H214.41Z">
                                                </path>
                                            </svg>
                                    </div>
                                    <h6 class="fw-semibold">Ecommerce</h6>
                                    <p class="fs-15 text-muted mb-0">At vero eos et accusamus et iusto odio dignissimos
                                        ducimus qui blanditiiss.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <span
                                            class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M16,152H48v56H16a8,8,0,0,1-8-8V160A8,8,0,0,1,16,152ZM204,56a28,28,0,0,0-12,2.71h0A28,28,0,1,0,176,85.29h0A28,28,0,1,0,204,56Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M230.33,141.06a24.43,24.43,0,0,0-21.24-4.23l-41.84,9.62A28,28,0,0,0,140,112H89.94a31.82,31.82,0,0,0-22.63,9.37L44.69,144H16A16,16,0,0,0,0,160v40a16,16,0,0,0,16,16H120a7.93,7.93,0,0,0,1.94-.24l64-16a6.94,6.94,0,0,0,1.19-.4L226,182.82l.44-.2a24.6,24.6,0,0,0,3.93-41.56ZM16,160H40v40H16Zm203.43,8.21-38,16.18L119,200H56V155.31l22.63-22.62A15.86,15.86,0,0,1,89.94,128H140a12,12,0,0,1,0,24H112a8,8,0,0,0,0,16h32a8.32,8.32,0,0,0,1.79-.2l67-15.41.31-.08a8.6,8.6,0,0,1,6.3,15.9ZM164,96a36,36,0,0,0,5.9-.48,36,36,0,1,0,28.22-47A36,36,0,1,0,164,96Zm60-12a20,20,0,1,1-20-20A20,20,0,0,1,224,84ZM164,40a20,20,0,0,1,19.25,14.61,36,36,0,0,0-15,24.93A20.42,20.42,0,0,1,164,80a20,20,0,0,1,0-40Z">
                                                </path>
                                            </svg>
                                    </div>
                                    <h6 class="fw-semibold">Financial Plans</h6>
                                    <p class="fs-15 text-muted mb-0">At vero eos et accusamus et iusto odio dignissimos
                                        ducimus qui blanditiis.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <span
                                            class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path d="M224,56l-96,88L32,56Z" opacity="0.2"></path>
                                                <path
                                                    d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48Zm-96,85.15L52.57,64H203.43ZM98.71,128,40,181.81V74.19Zm11.84,10.85,12,11.05a8,8,0,0,0,10.82,0l12-11.05,58,53.15H52.57ZM157.29,128,216,74.18V181.82Z">
                                                </path>
                                            </svg>
                                    </div>
                                    <h6 class="fw-semibold">Email Services</h6>
                                    <p class="fs-15 text-muted mb-0">At vero eos et accusamus et iusto odio dignissimos
                                        ducimus qui blanditiis.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <span
                                            class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path d="M168,100a60,60,0,1,1-60-60A60,60,0,0,1,168,100Z" opacity="0.2">
                                                </path>
                                                <path
                                                    d="M144,157.68a68,68,0,1,0-71.9,0c-20.65,6.76-39.23,19.39-54.17,37.17a8,8,0,0,0,12.25,10.3C50.25,181.19,77.91,168,108,168s57.75,13.19,77.87,37.15a8,8,0,0,0,12.25-10.3C183.18,177.07,164.6,164.44,144,157.68ZM56,100a52,52,0,1,1,52,52A52.06,52.06,0,0,1,56,100Zm197.66,33.66-32,32a8,8,0,0,1-11.32,0l-16-16a8,8,0,0,1,11.32-11.32L216,148.69l26.34-26.35a8,8,0,0,1,11.32,11.32Z">
                                                </path>
                                            </svg>
                                    </div>
                                    <h6 class="fw-semibold">Skilled</h6>
                                    <p class="fs-15 text-muted mb-0">At vero eos et accusamus et iusto odio dignissimos
                                        ducimus qui blanditiis.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <span
                                            class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path d="M216,48V88H40V48a8,8,0,0,1,8-8H208A8,8,0,0,1,216,48Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-38.34-85.66a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L116,164.69l42.34-42.35A8,8,0,0,1,169.66,122.34Z">
                                                </path>
                                            </svg>
                                    </div>
                                    <h6 class="fw-semibold">Planning</h6>
                                    <p class="fs-15 text-muted mb-0">At vero eos et accusamus et iusto odio dignissimos
                                        ducimus qui blanditiis.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-4 -->

            <!-- Start:: Section-5 -->
            <section class="section landing-Features" id="features">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-8">
                            <div class="heading-section text-center mb-0">
                                <p class="fs-12 fw-medium text-success mb-1"><span
                                        class="landing-section-heading landing-section-heading-dark text-fixed-white">FEATURES</span>
                                </p>
                                <h3 class="text-fixed-white text-center mt-3 fw-medium">World Class Features</h3>
                                <div class="fs-16 text-fixed-white text-center op-8">Ullamco ea commodo.Sed ut
                                    perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                    laudantium, totam rem aperiam.perspiciatis unde omnis.</div>
                                <div class="mt-4 mb-5 d-flex align-items-center justify-content-center">
                                    <a href="index.html" class="btn bg-white-transparent me-3 mb-sm-0">Get Started
                                        Now</a>
                                    <a href="index.html"
                                        class="btn text-fixed-white border border-white border-opacity-25 btn-wave waves-effect waves-light">Discover
                                        More<i class="fe fe-arrow-right fs-14 align-text-bottom ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-10 my-auto">
                            <div
                                class="d-flex align-items-center justify-content-center trusted-companies sub-card-companies flex-wrap mb-3 mb-xl-0 gap-4">
                                <div class="trust-img"><img src="<?= base_url(); ?>assets/images/media/landing/web/5.png" alt="img"
                                        class="border-0"></div>
                                <div class="trust-img"><img src="<?= base_url(); ?>assets/images/media/landing/web/1.png" alt="img"
                                        class="border-0"></div>
                                <div class="trust-img"><img src="<?= base_url(); ?>assets/images/media/landing/web/2.png" alt="img"
                                        class="border-0"></div>
                                <div class="trust-img"><img src="<?= base_url(); ?>assets/images/media/landing/web/4.png" alt="img"
                                        class="border-0"></div>
                                <div class="trust-img"><img src="<?= base_url(); ?>assets/images/media/landing/web/6.png" alt="img"
                                        class="border-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-5 -->

            <!-- Start:: Section-6 -->
            <section class="section" id="team">
                <div class="container">
                    <div class="text-center">
                        <p class="fs-12 fw-medium text-success mb-1"><span
                                class="landing-section-heading text-primary">OUR TEAM</span>
                        </p>
                        <h3 class="fw-semibold mt-3 mb-2">The people who make our organization Successful</h3>
                        <div class="row justify-content-center">
                            <div class="col-xl-7">
                                <p class="text-muted fs-15 mb-5 fw-normal">Our team is made up of real people who are
                                    passionate about what they do.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-lg-0 mb-4">
                            <div class="card custom-card  team-card text-center">
                                <div class="top-left"></div>
                                <div class="top-right"></div>
                                <div class="bottom-left"></div>
                                <div class="bottom-right"></div>
                                <div class="card-body"> <img src="<?= base_url(); ?>assets/images/media/landing/team/1.png"
                                        class="avatar avatar-xxl mb-4 mb-3 border p-1 bg-light landing-team-img mt-2"
                                        alt="...">
                                    <div class="text-center py-2">
                                        <h5 class="mb-0 fw-medium">Charlie John</h5>
                                        <p class="mb-1 fs-14 fw-medium text-primary">HR Manager</p>
                                        <p class="mb-0 fs-13 text-muted op-8">Aliquam ullamcorper neque vitae dui
                                            ullamcorper, at varius erat feugiat. Proin aliquam, purus ut.</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light"><i
                                                    class="ri-twitter-x-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-facebook-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-instagram-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-linkedin-fill"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-lg-0 mb-4">
                            <div class="card custom-card  team-card text-center">
                                <div class="top-left"></div>
                                <div class="top-right"></div>
                                <div class="bottom-left"></div>
                                <div class="bottom-right"></div>
                                <div class="card-body"> <img src="<?= base_url(); ?>assets/images/media/landing/team/2.png"
                                        class="avatar avatar-xxl mb-4 mb-3 border p-1 bg-light landing-team-img mt-2"
                                        alt="...">
                                    <div class="text-center py-2">
                                        <h5 class="mb-0 fw-medium">Marlin Shane</h5>
                                        <p class="mb-1 fs-14 fw-medium text-primary">Team Lead</p>
                                        <p class="mb-0 fs-13 text-muted op-8">Aliquam ullamcorper neque vitae dui
                                            ullamcorper, at varius erat feugiat. Proin aliquam, purus ut.</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light"><i
                                                    class="ri-twitter-x-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-facebook-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-instagram-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-linkedin-fill"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-lg-0 mb-4">
                            <div class="card custom-card  team-card text-center">
                                <div class="top-left"></div>
                                <div class="top-right"></div>
                                <div class="bottom-left"></div>
                                <div class="bottom-right"></div>
                                <div class="card-body"> <img src="<?= base_url(); ?>assets/images/media/landing/team/3.png"
                                        class="avatar avatar-xxl mb-4 mb-3 border p-1 bg-light landing-team-img mt-2"
                                        alt="...">
                                    <div class="text-center py-2">
                                        <h5 class="mb-0 fw-medium">Angela Lia</h5>
                                        <p class="mb-1 fs-14 fw-medium text-primary">Project Manager</p>
                                        <p class="mb-0 fs-13 text-muted op-8">Aliquam ullamcorper neque vitae dui
                                            ullamcorper, at varius erat feugiat. Proin aliquam, purus ut.</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light"><i
                                                    class="ri-twitter-x-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-facebook-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-instagram-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-linkedin-fill"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-lg-0 mb-4">
                            <div class="card custom-card  team-card text-center">
                                <div class="top-left"></div>
                                <div class="top-right"></div>
                                <div class="bottom-left"></div>
                                <div class="bottom-right"></div>
                                <div class="card-body"> <img src="<?= base_url(); ?>assets/images/media/landing/team/4.png"
                                        class="avatar avatar-xxl mb-4 mb-3 border p-1 bg-light landing-team-img mt-2"
                                        alt="...">
                                    <div class="text-center py-2">
                                        <h5 class="mb-0 fw-medium">Stella Daisy</h5>
                                        <p class="mb-1 fs-14 fw-medium text-primary">Head of Department</p>
                                        <p class="mb-0 fs-13 text-muted op-8">Aliquam ullamcorper neque vitae dui
                                            ullamcorper, at varius erat feugiat. Proin aliquam, purus ut.</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light"><i
                                                    class="ri-twitter-x-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-facebook-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-instagram-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-linkedin-fill"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-6 -->

            <!-- Start:: Section-7 -->
            <section class="section section-bg" id="pricing">
                <div class="container">
                    <div class="text-center">
                        <p class="fs-12 fw-medium text-success mb-1"><span
                                class="landing-section-heading text-primary">PRICING</span>
                        </p>
                        <h3 class="fw-semibold mt-3 mb-2">We offer most affordable Pricing</h3>
                        <div class="row justify-content-center">
                            <div class="col-xl-7">
                                <p class="text-muted fs-15 mb-5 fw-normal">Our plans are most affordable and are mainly
                                    placed by focussing every category.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card custom-card landing-card pricing-card border shadow-none">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <p class="fs-18 fw-medium mb-1">Intro</p>
                                        <p class="text-justify fw-medium mb-1">
                                            <span class="fs-2">$</span><span class="fs-2 me-1">0</span>
                                            <span class="fs-24"><span class="fs-20">/</span> month</span>
                                        </p>
                                        <p class="mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <p class="fs-12 mb-2 badge bg-primary-transparent text-primary">Billed monthly
                                            on regular basis!</p>
                                    </div>
                                    <ul class="text-justify list-unstyled pricing-body ps-0">
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 2 Free
                                            Services
                                        </li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span>1 Month Pack
                                        </li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> No
                                            Agreement</li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> Money
                                            BackGuarantee</li>
                                        <li class="mb-0"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 24/7
                                            support</li>
                                    </ul>
                                    <div class="text-center border-top-0 pt-4 d-grid">
                                        <button type="button" class="btn btn-lg btn-primary-light">
                                            <span class="ms-4 me-4">Get a quote</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card pricing-card border custom-card landing-card border-primary shadow-none">
                                <div class="card-body">
                                    <div class="ribbon-6 ribbon-right ribbon-primary">Best Plan</div>
                                    <div class="mb-4">
                                        <p class="fs-18 fw-medium mb-1">Basic</p>
                                        <p class="text-justify fw-medium mb-1">
                                            <span class="fs-2">$</span><span class="fs-2 me-1">29</span>
                                            <span class="fs-24"><span class="fs-20">/</span> month</span>
                                        </p>
                                        <p class="mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <p class="fs-12 mb-2 badge bg-primary-transparent text-primary">Billed monthly
                                            on regular basis!</p>
                                    </div>
                                    <ul class="text-justify list-unstyled pricing-body ps-0">
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 5 Free
                                            Services
                                        </li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span>3 Months
                                            Pack
                                        </li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 3 Months
                                            Agreement</li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> Money
                                            BackGuarantee</li>
                                        <li class="mb-0"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i> 24/7 support</li>
                                    </ul>
                                    <div class="text-center border-top-0 pt-4 d-grid">
                                        <button type="button" class="btn btn-lg btn-primary text-fixed-white">
                                            <span class="ms-4 me-4">Get a quote</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card custom-card landing-card pricing-card border shadow-none">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <p class="fs-18 fw-medium mb-1">Popular</p>
                                        <p class="text-justify fw-medium mb-1">
                                            <span class="fs-2">$</span><span class="fs-2 me-1">49</span>
                                            <span class="fs-24"><span class="fs-20">/</span> month</span>
                                        </p>
                                        <p class="mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <p class="fs-12 mb-2 badge bg-primary-transparent text-primary">Billed monthly
                                            on regular basis!</p>
                                    </div>
                                    <ul class="text-justify list-unstyled pricing-body ps-0">
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 10 Free
                                            Services
                                        </li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span>6 Months
                                            Pack
                                        </li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 6 Months
                                            Agreement</li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> Money
                                            BackGuarantee</li>
                                        <li class="mb-0"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 24/7
                                            support</li>
                                    </ul>
                                    <div class="text-center border-top-0 pt-4 d-grid">
                                        <button type="button" class="btn btn-lg btn-primary-light">
                                            <span class="ms-4 me-4">Get a quote</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-7 -->

            <!-- Start:: Section-8 -->
            <section class="section" id="faqs">
                <div class="container text-center">
                    <p class="fs-12 fw-medium text-success mb-1"><span
                            class="landing-section-heading text-primary">F.A.Q 's</span>
                    </p>
                    <h3 class="fw-semibold mt-3 mb-2">Frequently asked questions ?</h3>
                    <div class="row justify-content-center">
                        <div class="col-xl-7">
                            <p class="text-muted fs-15 mb-5 fw-normal">We have shared some of the most frequently asked
                                questions to help you out.</p>
                        </div>
                    </div>
                    <div class="row text-start">
                        <div class="col-xl-12">
                            <div class="row gy-2">
                                <div class="col-xl-6">
                                    <div class="accordion accordion-customicon1 accordion-primary accordions-items-seperate"
                                        id="accordionFAQ1">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1One">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapsecustomicon1One" aria-expanded="true"
                                                    aria-controls="collapsecustomicon1One">
                                                    Where can I subscribe to your newsletter?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1One" class="accordion-collapse collapse show"
                                                aria-labelledby="headingcustomicon1One" data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1Two">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Two"
                                                    aria-expanded="false" aria-controls="collapsecustomicon1Two">
                                                    Where can in edit my address?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1Two" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon1Two" data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1Three">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Three"
                                                    aria-expanded="false" aria-controls="collapsecustomicon1Three">
                                                    What are your opening hours?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1Three" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon1Three"
                                                data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1Four">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Four"
                                                    aria-expanded="false" aria-controls="collapsecustomicon1Four">
                                                    Do I have the right to return an item?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1Four" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon1Four"
                                                data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1Five">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Five"
                                                    aria-expanded="false" aria-controls="collapsecustomicon1Five">
                                                    General Terms & Conditions (GTC)
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1Five" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon1Five"
                                                data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1Six">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Six"
                                                    aria-expanded="false" aria-controls="collapsecustomicon1Six">
                                                    Do I need to create an account to make an order?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1Six" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon1Six" data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="accordion accordion-customicon1 accordion-primary accordions-items-seperate"
                                        id="accordionFAQ2">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Five">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Five"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Five">
                                                    General Terms & Conditions (GTC)
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Five" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Five"
                                                data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Six">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Six"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Six">
                                                    Do I need to create an account to make an order?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Six" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Six" data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2One">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2One"
                                                    aria-expanded="true" aria-controls="collapsecustomicon2One">
                                                    Where can I subscribe to your newsletter?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2One" class="accordion-collapse collapse "
                                                aria-labelledby="headingcustomicon2One" data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Two">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Two"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Two">
                                                    Where can in edit my address?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Two" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Two" data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Three">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Three"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Three">
                                                    What are your opening hours?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Three" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Three"
                                                data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Four">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapsecustomicon2Four" aria-expanded="false"
                                                    aria-controls="collapsecustomicon2Four">
                                                    Do I have the right to return an item?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Four" class="accordion-collapse collapse show"
                                                aria-labelledby="headingcustomicon2Four"
                                                data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-8 -->

            <!-- Start:: Section-9 -->
            <section class="section landing-Features" id="testimonials">
                <div class="container reviews-container">
                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <div class="text-center mb-0 mt-4 heading-section">
                                <p class="fs-12 fw-medium text-success mb-1"><span
                                    class="landing-section-heading landing-section-heading-dark text-fixed-white">TESTIMONALS</span>
                               </p>
                                <div class="h3 mt-3 text-fixed-white">Have a look at what people say About Us</div>
                                <div class="fs-15 text-fixed-white mb-4 op-8">We care about our customer satisfaction
                                    and
                                    experience.</div>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <div class="swiper pagination-dynamic testimonialSwiperService">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="card mb-0 text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p- text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="<?= base_url(); ?>assets/images/faces/4.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="">
                                                        <h5 class="mb-0 text-fixed-white">Penny Black</h5>
                                                        <div class="mb-2 text-fixed-white fs-15"> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-16"> "To achieve error-free paradigms,
                                                            organizations must foster a culture of continuous
                                                            improvement and quality assurance. By implementing robust
                                                            processes, conducting thorough testing, and leveraging
                                                            automation tools, businesses can minimize errors and
                                                            ensure." </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card mb-0 text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p- text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="<?= base_url(); ?>assets/images/faces/3.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="">
                                                        <h5 class="mb-0 text-fixed-white">Laura Norda</h5>
                                                        <div class="mb-2 text-fixed-white fs-15"> <i
                                                                class="ri-star-fill"></i> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-16"> "The ability to tailor strategies to
                                                            meet specific objectives and adapt to changing market
                                                            dynamics is paramount. Embracing innovation as a core value
                                                            allows companies to stay ahead of the curve, consistently
                                                            delivering value to their customers while maintaining a
                                                            competitive." </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card mb-0  text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p- text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="<?= base_url(); ?>assets/images/faces/2.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="">
                                                        <h5 class="mb-0 text-fixed-white">Percy Kewsh</h5>
                                                        <div class="mb-2 text-fixed-white fs-15"> <i
                                                                class="ri-star-fill"></i> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-16"> "In today's rapidly evolving
                                                            business landscape, it is essential to efficiently innovate
                                                            customized growth strategies that propel organizations
                                                            toward success. By analyzing market trends, consumer
                                                            behavior, and competitive landscapes, businesses can
                                                            identify unique." </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card mb-0 text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p- text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="<?= base_url(); ?>assets/images/faces/3.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="">
                                                        <h5 class="mb-0 text-fixed-white">Laura Norda</h5>
                                                        <div class="mb-2 text-fixed-white fs-15"> <i
                                                                class="ri-star-fill"></i> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-16"> "The ability to tailor strategies to
                                                            meet specific objectives and adapt to changing market
                                                            dynamics is paramount. Embracing innovation as a core value
                                                            allows companies to stay ahead of the curve, consistently
                                                            delivering value to their customers while maintaining a
                                                            competitive." </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card mb-0 text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p-4 text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="<?= base_url(); ?>assets/images/faces/2.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="">
                                                        <h5 class="mb-0 text-fixed-white">Percy Kewsh</h5>
                                                        <div class="mb-2 text-fixed-white fs-15"> <i
                                                                class="ri-star-fill"></i> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-16"> "In today's rapidly evolving
                                                            business landscape, it is essential to efficiently innovate
                                                            customized growth strategies that propel organizations
                                                            toward success. By analyzing market trends, consumer
                                                            behavior, and competitive landscapes, businesses can
                                                            identify unique." </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card mb-0 text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p-4 text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="<?= base_url(); ?>assets/images/faces/6.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="">
                                                        <h5 class="mb-0 text-fixed-white">Audie Yose</h5>
                                                        <div class="mb-2 text-warning fs-15"> <i
                                                                class="ri-star-fill"></i> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-16"> "The QuantumGlide Smart Hoverboard
                                                            has exceeded my expectations! Not only does it look
                                                            futuristic with its sleek design, but the ride is incredibly
                                                            smooth. The app connectivity is a standout feature - I can
                                                            customize the LED lights to match my mood and track my
                                                            rides.
                                                            " </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-9 -->

            <!-- Start:: Section-10 -->
            <section class="section" id="contact">
                <div class="container text-center">
                    <p class="fs-12 fw-medium text-success mb-1"><span
                            class="landing-section-heading text-primary">CONTACT US</span>
                    </p>
                    <h3 class="fw-semibold mt-3 mb-2">Have any questions ? We would love to hear from you.</h3>
                    <div class="row justify-content-center">
                        <div class="col-xl-9">
                            <p class="text-muted fs-15 mb-5 fw-normal">You can contact us anytime regarding any queries
                                or deals,dont hesitate to clear your doubts before trying our product.</p>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row text-start">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 pe-0">
                                <div class="p-5 bg-light rounded">
                                    <div class="row gy-3">
                                        <div class="col-xl-6">
                                            <div class="row gy-3">
                                                <div class="col-xl-12">
                                                    <label for="contact-address-name" class="form-label ">Full Name
                                                        :</label>
                                                    <input type="text" class="form-control"
                                                        id="contact-address-name" placeholder="Enter Name">
                                                </div>
                                                <div class="col-xl-12">
                                                    <label for="contact-address-phone" class="form-label ">Phone No
                                                        :</label>
                                                    <input type="text" class="form-control"
                                                        id="contact-address-phone" placeholder="Enter Phone No">
                                                </div>
                                                <div class="col-xl-12">
                                                    <label for="contact-address-address" class="form-label ">Address
                                                        :</label>
                                                    <textarea class="form-control" id="contact-address-address"
                                                        rows="1"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="contact-address-message" class="form-label ">Message
                                                :</label>
                                            <textarea class="form-control" id="contact-address-message"
                                                rows="8"></textarea>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="d-flex  mt-3">
                                                <div class="">
                                                    <div class="btn-list">
                                                        <button class="btn btn-icon btn-primary-light btn-wave">
                                                            <i class="ri-facebook-line fw-bold"></i>
                                                        </button>
                                                        <button class="btn btn-icon btn-primary-light btn-wave">
                                                            <i class="ri-twitter-x-line fw-bold"></i>
                                                        </button>
                                                        <button class="btn btn-icon btn-primary-light btn-wave">
                                                            <i class="ri-instagram-line fw-bold"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-primary  btn-wave">Send Message</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 pe-0">
                                <div class="p-5 landing-contact-info border rounded">
                                    <div class="">
                                        <div class="fs-18 text-primary fw-medium mb-3">Contact Information</div>
                                        <div class="mb-3 text-default"> <i class="ri-map-pin-fill me-2 text-primary"></i> 1352/A-12,
                                            Abcd Street, KLM Town, Hyderabad. </div>
                                        <div class="d-flex mb-3"> <i
                                                class="ri-phone-fill me-2 d-inline-block text-primary"></i>
                                            <div class="text-default">
                                                <div>+122 1234 32422</div> <span>+121 1234 14511</span>
                                            </div>
                                        </div>
                                        <div class="mb-4 text-default"><i class="ri-mail-fill me-2 d-inline-block text-primary"></i>
                                            carolinahanasandy4424@example.com</div>
                                    </div>
                                    <div class="">
                                        <div class="card custom-card border mb-0 shadow-none overflow-hidden"> <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d30444.274596168965!2d78.54114692513858!3d17.48198883339408!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e6!4m3!3m2!1d17.4886524!2d78.5495041!4m5!1s0x3bcb9c7ec139a15d%3A0x326d1c90786b2ab6!2sspruko%20technologies!3m2!1d17.474805099999998!2d78.570258!5e0!3m2!1sen!2sin!4v1670225507254!5m2!1sen!2sin"
                                                height="100" style="border:0;width:100%" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-10 -->

            <!-- Start:: Section-11 -->
            <section class="section landing-footer text-fixed-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-12 mb-md-0 mb-3">
                            <div class="px-4">
                                <p class="fw-medium mb-3"><a href="index.html"><img
                                            src="<?= base_url(); ?>assets/images/brand-logos/desktop-dark.png" alt=""></a></p>
                                <p class="mb-2 op-6 fw-normal">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit et magnam,
                                    fuga est mollitia eius, quo illum illo inventore optio aut quas omnis rem. Dolores
                                    accusantium aspernatur minus ea incidunt.
                                </p>
                                <p class="mb-0 op-6 fw-normal">Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                    Autem ea esse ad</p>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 col-12">
                            <div class="px-4">
                                <h6 class="fw-medium mb-3 text-fixed-white">PAGES</h6>
                                <ul class="list-unstyled op-6 fw-normal landing-footer-list">
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Email</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Profile</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Timeline</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Projects</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Contacts</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Portfolio</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 col-12">
                            <div class="px-4">
                                <h6 class="fw-medium text-fixed-white">INFO</h6>
                                <ul class="list-unstyled op-6 fw-normal landing-footer-list">
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Our Team</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Contact US</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">About</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Services</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Blog</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white">Terms & Conditions</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="px-4">
                                <h6 class="fw-medium text-fixed-white">CONTACT</h6>
                                <ul class="list-unstyled fw-normal landing-footer-list">
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white op-6"><i
                                                class="ri-home-4-line me-1 align-middle"></i> New York, NY 10012, US</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white op-6"><i
                                                class="ri-mail-line me-1 align-middle"></i> info@fmail.com</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white op-6"><i
                                                class="ri-phone-line me-1 align-middle"></i> +(555)-1920 1831</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white op-6"><i
                                                class="ri-printer-line me-1 align-middle"></i> +(123) 1293 123</a>
                                    </li>
                                    <li class="mt-3">
                                        <p class="mb-2 fw-medium op-8">FOLLOW US ON :</p>
                                        <div class="mb-0">
                                            <div class="btn-list">
                                                <button
                                                    class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light">
                                                    <i class="ri-facebook-line fw-bold"></i>
                                                </button>
                                                <button
                                                    class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light">
                                                    <i class="ri-twitter-x-line fw-bold"></i>
                                                </button>
                                                <button
                                                    class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light">
                                                    <i class="ri-instagram-line fw-bold"></i>
                                                </button>
                                                <button
                                                    class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light">
                                                    <i class="ri-github-line fw-bold"></i>
                                                </button>
                                                <button
                                                    class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light">
                                                    <i class="ri-youtube-line fw-bold"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-11 -->

            <div class="text-center landing-main-footer py-3">
                <span class="text-muted fs-15"> Copyright © <span id="year"></span> 
                <a href="javascript:void(0);" class="text-primary fw-medium"><u>VERTIX</u>
                </a>. Designed with <span class="fa fa-heart text-danger"></span> by <a href="javascript:void(0);"
                        class="text-primary fw-medium"><u>
                            Spruko</u>
                    </a> All rights reserved
                </span>
            </div>

            </div>
            <!-- End::main-content -->
                
        </div>
        <!--app-content closed-->
          

        <!-- SCRIPTS -->
        <!-- Back To Top -->
        <div class="scrollToTop">
            <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
        </div>
        <div id="responsive-overlay"></div>

        <!-- Popper JS -->
        <script src="<?= base_url(); ?>assets/libs/@popperjs/core/umd/popper.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Color Picker JS -->
        <script src="<?= base_url(); ?>assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>

        <!-- Choices JS -->
        <script src="<?= base_url(); ?>assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

        <!-- Swiper JS -->
        <script src="<?= base_url(); ?>assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- Defaultmenu JS -->
        <link rel="modulepreload" href="<?= base_url(); ?>assets/js/defaultmenu-BBKPfIID.js" /><script type="module" src="<?= base_url(); ?>assets/defaultmenu-BBKPfIID.js"></script>
        <!-- Internal Landing JS -->
        <link rel="modulepreload" href="<?= base_url(); ?>assets/js/landing-OrsPQY-i.js" /><script type="module" src="<?= base_url(); ?>assets/landing-OrsPQY-i.js"></script>
        <!-- Node Waves JS-->
        <script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>

        <!-- Sticky JS -->
        <script src="<?= base_url(); ?>assets/js/sticky.js"></script>
      
    </body> 

</html>
