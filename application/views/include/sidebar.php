<body class="">
<?php $allow = checkCustLogin(); ?>
<!-- Loader -->
<div id="loader" >
<img src="<?= base_url('assets/images/media/loader.svg'); ?>" alt="">
</div>
<!-- Loader -->

<div class="page">

<!-- Main-Header -->
<header class="app-header sticky" id="header">

	<!-- Start::main-header-container -->
	<div class="main-header-container container-fluid">

		<!-- Start::header-content-left -->
		<div class="header-content-left">

			<!-- Start::header-element -->
			<div class="header-element">
				<div class="horizontal-logo">
					<a href="" class="header-logo">
						<img src="<?= base_url('assets/images/brand-logos/amorio-white.png'); ?>" alt="logo" class="desktop-logo">
						<img src="<?= base_url('assets/images/brand-logos/amorio-toggle.png'); ?>" alt="logo" class="toggle-logo">
						<img src="<?= base_url('assets/images/brand-logos/amorio-dark.png'); ?>" alt="logo" class="desktop-dark">
						<img src="<?= base_url('assets/images/brand-logos/amorio-toggle.png'); ?>" alt="logo" class="toggle-dark">
					</a>
				</div>
			</div>
			<!-- End::header-element -->

			<!-- Start::header-element -->
			<div class="header-element mx-lg-0 mx-2">
				<a aria-label="Hide Sidebar"
					class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
					data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
			</div>
			<!-- End::header-element -->

			<!-- Start::header-element -->
			<!-- <div class="header-element header-search d-md-block d-none my-auto">
				<input type="text" class="header-search-bar form-control" id="header-search"
					placeholder="Search for anything here..." spellcheck=false autocomplete="off" autocapitalize="off">
				<a href="javascript:void(0);" class="header-search-icon border-0">
					<i class="bi bi-search"></i>
				</a>
			</div> -->
			<!-- End::header-element -->

		</div>
		<!-- End::header-content-left -->

		<!-- Start::header-content-right -->
		<ul class="header-content-right">

			<!-- Start::header-element -->
			<li class="header-element d-md-none d-block">
				<a href="javascript:void(0);" class="header-link" data-bs-toggle="modal"
					data-bs-target="#header-responsive-search">
					<!-- Start::header-link-icon -->
					<i class="bi bi-search header-link-icon"></i>
					<!-- End::header-link-icon -->
				</a>
			</li>
			<!-- End::header-element -->

			<!-- Start::header-element -->
			<li class="header-element header-theme-mode">
				<!-- Start::header-link|layout-setting -->
				<a href="javascript:void(0);" class="header-link layout-setting">
					<span class="light-layout">
						<!-- Start::header-link-icon -->
						<svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon"
							enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px"
							fill="#000000">
							<rect fill="none" height="24" width="24" />
							<path
								d="M9.37,5.51C9.19,6.15,9.1,6.82,9.1,7.5c0,4.08,3.32,7.4,7.4,7.4c0.68,0,1.35-0.09,1.99-0.27 C17.45,17.19,14.93,19,12,19c-3.86,0-7-3.14-7-7C5,9.07,6.81,6.55,9.37,5.51z"
								opacity=".1" />
							<path
								d="M9.37,5.51C9.19,6.15,9.1,6.82,9.1,7.5c0,4.08,3.32,7.4,7.4,7.4c0.68,0,1.35-0.09,1.99-0.27C17.45,17.19,14.93,19,12,19 c-3.86,0-7-3.14-7-7C5,9.07,6.81,6.55,9.37,5.51z M12,3c-4.97,0-9,4.03-9,9s4.03,9,9,9s9-4.03,9-9c0-0.46-0.04-0.92-0.1-1.36 c-0.98,1.37-2.58,2.26-4.4,2.26c-2.98,0-5.4-2.42-5.4-5.4c0-1.81,0.89-3.42,2.26-4.4C12.92,3.04,12.46,3,12,3L12,3z" />
						</svg>
						<!-- End::header-link-icon -->
					</span>
					<span class="dark-layout">
						<!-- Start::header-link-icon -->
						<svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon"
							enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px"
							fill="#000000">
							<rect fill="none" height="24" width="24" />
							<circle cx="12" cy="12" opacity=".1" r="3" />
							<path
								d="M12,9c1.65,0,3,1.35,3,3s-1.35,3-3,3s-3-1.35-3-3S10.35,9,12,9 M12,7c-2.76,0-5,2.24-5,5s2.24,5,5,5s5-2.24,5-5 S14.76,7,12,7L12,7z M2,13l2,0c0.55,0,1-0.45,1-1s-0.45-1-1-1l-2,0c-0.55,0-1,0.45-1,1S1.45,13,2,13z M20,13l2,0c0.55,0,1-0.45,1-1 s-0.45-1-1-1l-2,0c-0.55,0-1,0.45-1,1S19.45,13,20,13z M11,2v2c0,0.55,0.45,1,1,1s1-0.45,1-1V2c0-0.55-0.45-1-1-1S11,1.45,11,2z M11,20v2c0,0.55,0.45,1,1,1s1-0.45,1-1v-2c0-0.55-0.45-1-1-1C11.45,19,11,19.45,11,20z M5.99,4.58c-0.39-0.39-1.03-0.39-1.41,0 c-0.39,0.39-0.39,1.03,0,1.41l1.06,1.06c0.39,0.39,1.03,0.39,1.41,0s0.39-1.03,0-1.41L5.99,4.58z M18.36,16.95 c-0.39-0.39-1.03-0.39-1.41,0c-0.39,0.39-0.39,1.03,0,1.41l1.06,1.06c0.39,0.39,1.03,0.39,1.41,0c0.39-0.39,0.39-1.03,0-1.41 L18.36,16.95z M19.42,5.99c0.39-0.39,0.39-1.03,0-1.41c-0.39-0.39-1.03-0.39-1.41,0l-1.06,1.06c-0.39,0.39-0.39,1.03,0,1.41 s1.03,0.39,1.41,0L19.42,5.99z M7.05,18.36c0.39-0.39,0.39-1.03,0-1.41c-0.39-0.39-1.03-0.39-1.41,0l-1.06,1.06 c-0.39,0.39-0.39,1.03,0,1.41s1.03,0.39,1.41,0L7.05,18.36z" />
						</svg>
						<!-- End::header-link-icon -->
					</span>
				</a>
				<!-- End::header-link|layout-setting -->
			</li>
			<!-- End::header-element -->

			<!-- Start::header-element -->
			<li class="header-element cart-dropdown dropdown">
				
			

				<!-- Start::main-header-dropdown -->
				<div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
					<div class="p-3">
						<div class="d-flex align-items-center justify-content-between">
							<p class="mb-0 fs-16">Today's Wishes</p>
						</div>
					</div>
					<div class="dropdown-divider"></div>
					<ul class="list-unstyled mb-0" id="header-cart-items-scroll"></ul>
					<div class="p-5 empty-item d-none">
						<div class="text-center">
							<span class="avatar avatar-xl avatar-rounded bg-primary-transparent">
								<i class="ri-shopping-cart-2-line fs-2"></i>
							</span>
							<h6 class="fw-medium mb-1 mt-3">Your Cart is Empty</h6>
							<span class="mb-3 fw-normal fs-13 d-block">Add some items to make it happy :)</span>
						</div>
					</div>
				</div>
				<!-- End::main-header-dropdown -->
			</li>
			<!-- End::header-element -->

			<!-- Start::header-element -->
			<li class="header-element notifications-dropdown d-xl-block d-none dropdown">
				<div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
					<div class="p-3">
						<div class="d-flex align-items-center justify-content-between">
							<p class="mb-0 fs-16">Notifications</p>
							<span class="badge bg-primary-transparent" id="notifiation-data">2 Unread</span>
						</div>
					</div>
					<div class="dropdown-divider"></div>
					<ul class="list-unstyled mb-0" id="header-notification-scroll">
						<li class="dropdown-item">
							<div class="d-flex align-items-start">
								<div class="pe-2 lh-1">
									<span class="avatar avatar-md avatar-rounded bg-light p-1 svg-white">
									<img src="<?= base_url('assets/images/faces/15.jpg'); ?>" alt="img">
									</span>
								</div>
								<div class="flex-grow-1 d-flex align-items-start justify-content-between">
									<div>
										<p class="mb-0 fw-medium"><a href="">Luther Mahin<span class="text-muted fs-11 ms-2">2 Min Ago</span></a></p>
										<div class="fw-normal fs-12 header-notification-text text-truncate">
											Asked to join<span class="text-primary fw-medium ms-1">Ui Dashboad</span></div>
										<div class="d-flex align-items-center gap-2 mt-2">
											<button class="btn btn-sm btn-primary-light">Accept</button>
											<button class="btn btn-sm btn-danger-light">Reject</button>
										</div>
									</div>
									<div>
										<a href="javascript:void(0);"
											class="min-w-fit-content text-muted dropdown-item-close1"><i
												class="ri-close-circle-line fs-5"></i></a>
									</div>
								</div>
							</div>
						</li>
					</ul>
					<div class="p-3 empty-header-item1 border-top">
						<div class="d-grid">
							<a href="" class="btn btn-primary btn-wave">View All</a>
						</div>
					</div>
					<div class="p-5 empty-item1 d-none">
						<div class="text-center">
							<span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
								<i class="ri-notification-off-line fs-2"></i>
							</span>
							<h6 class="fw-medium mt-3">No New Notifications</h6>
						</div>
					</div>
				</div>
				<!-- End::main-header-dropdown -->
			</li>
			<!-- End::header-element -->

			<!-- Start::header-element -->
			<li class="header-element header-fullscreen">
				<!-- Start::header-link -->
				<a onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
					<svg xmlns="http://www.w3.org/2000/svg" class=" full-screen-open header-link-icon" height="24px"
						viewBox="0 0 24 24" width="24px" fill="#000000">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z" />
					</svg>
					<svg xmlns="http://www.w3.org/2000/svg" class="full-screen-close header-link-icon d-none"
						height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
					</svg>
				</a>
				<!-- End::header-link -->
			</li>
			<!-- End::header-element -->

			<!-- Start::header-element -->
			<li class="header-element dropdown">
				<!-- Start::header-link|dropdown-toggle -->
				<a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
					data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
					<div class="d-flex align-items-center">
						<div class="me-xl-2 me-0 lh-1 d-flex align-items-center ">
							<span class="avatar avatar-xs avatar-rounded bg-primary-transparent">
								<img src="<?= base_url('assets/images/brand-logos/amorio-toggle.png'); ?>" alt="img">
							</span>
						</div>
						<div class="d-xl-block d-none lh-1">
							<span class="fw-medium lh-1"><?= (isset($cust_info['cust_name'])) ? $cust_info['cust_name'] : ''; ?></span>
						</div>
					</div>
				</a>
				<!-- End::header-link|dropdown-toggle -->
				<ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
					aria-labelledby="mainHeaderProfile">
					
					<li >
                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('userprofile'); ?>">
                            <i class="ti ti-user me-2 fs-18 text-primary"></i> Profile
                        </a>
                    </li>
					
					<li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout'); ?>">
                            <i class="ti ti-logout me-2 fs-18 text-primary"></i>Log Out
                        </a>
                    </li>
				</ul>
			</li>
			<!-- End::header-element -->

			</li>
			<!-- End::header-element -->

		</ul>
		<!-- End::header-content-right -->

	</div>
	<!-- End::main-header-container -->

</header>
<!-- End Main-Header -->

<!--Main-Sidebar-->
<aside class="app-sidebar sticky" id="sidebar">

	<!-- Start::main-sidebar-header -->
	<div class="main-sidebar-header">
		<a href="" class="header-logo">
			<img src="<?= base_url('assets/images/brand-logos/amorio-white.png'); ?>" alt="logo" class="desktop-logo" width="100%">
			<img src="<?= base_url('assets/images/brand-logos/amorio-white.png'); ?>" alt="logo" class="desktop-white" width="100%">
			<img src="<?= base_url('assets/images/brand-logos/amorio-toggle.png'); ?>" alt="logo" class="toggle-dark" width="100%">
			<img src="<?= base_url('assets/images/brand-logos/amorio-white.png'); ?>" alt="logo" class="desktop-dark" width="100%">
			<img src="<?= base_url('assets/images/brand-logos/amorio-toggle.png'); ?>" alt="logo" class="toggle-logo" width="100%">
		</a>
	</div>
	<!-- End::main-sidebar-header -->

	<!-- Start::main-sidebar -->
	<div class="main-sidebar" id="sidebar-scroll">

		<!-- Start::nav -->
		<nav class="main-menu-container nav nav-pills flex-column sub-open">
			<div class="slide-left" id="slide-left">
				<svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> 
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> 
                </svg>
			</div>
			<ul class="main-menu">
				<li class="slide" >
					<a href="<?= base_url('bookings'); ?>" class="side-menu__item">
						<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/>
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/>
                        </svg>
						<span class="side-menu__label">My Bookings</span>
					</a>
				</li>
			</ul>
			<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
		</nav>
		<!-- End::nav -->

	</div>
	<!-- End::main-sidebar -->

</aside>
<!-- End Main-Sidebar-->

