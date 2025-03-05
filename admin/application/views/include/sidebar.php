<body class="">
<?php 
    $allow = checkLogin(); 
    $checkStaffAccess = $this->session->userdata('login_info');
    $accessmodules = isset($checkStaffAccess['access']) ? trim(preg_replace('/\s+/', '', $checkStaffAccess['access'])) : '';

	$modules = ['Dashboard', 'Bookings', 'Staff', 'Customers', 'Coupons', 'Calander', 'Settings', 'Reports', 'Court Status'];
	$permission = [];

	// If role is ADMIN, grant access to all modules
	if ($allow['role'] == ADMIN) {
	    foreach ($modules as $module) {
	        $permission[$module] = '';
	    }
	} else {
	    // Otherwise, check individual access
	    foreach ($modules as $module) {
	        $permission[$module] = (stripos($accessmodules, $module) !== false) ? '' : 'd-none';
	    }
	}
?>
<!-- Loader -->
<div id="loader" >
<img src="<?= base_url('../assets/images/media/loader.svg'); ?>" alt="">
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
					<a href="<?= base_url('admin') ?>" class="header-logo">
						<img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="desktop-logo">
						<img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="toggle-logo">
						<img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="desktop-dark">
						<img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="toggle-dark">
					</a>
				</div>
			</div>
			<!-- End::header-element -->

			<!-- Start::header-element -->
			<div class="header-element mx-lg-0 mx-2">
				<a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0)"><span></span></a>
			</div>
		</div>
		<!-- End::header-content-left -->

		<!-- Start::header-content-right -->
		<ul class="header-content-right">

			<!-- Start::header-element -->
			<li class="header-element d-md-none d-block">
				<a href="javascript:void(0);" class="header-link dropdown-toggle h6" data-bs-toggle="modal" data-bs-target="#wishesModal" style="position: relative; top: 3px; left: 3px;">
					<i class="bi bi-cake2"></i>
				</a>
			</li>
			<!-- End::header-element -->

			<!-- Start::header-element -->
			<!-- <li class="header-element header-theme-mode">
				<button type="button" class="btn btn-danger header-link dropdown-toggle h6" data-bs-toggle="modal" data-bs-target="#dayclosed" style="position: relative; top: 4px;">Day Close</button>
			</li> &nbsp;&nbsp; -->
			<!-- End::header-element -->

			<!-- Start::header-element -->
			<li class="header-element cart-dropdown dropdown">
				<!-- Start::header-link|dropdown-toggle -->
				<a href="javascript:void(0);" class="header-link dropdown-toggle h6" data-bs-toggle="modal" data-bs-target="#wishesModal" style="position: relative; top: 3px; left: 3px;">
					<i class="bi bi-cake2"></i>
				</a>
				<!-- End::header-link|dropdown-toggle -->

				<!-- Start::main-header-dropdown -->
				<div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
					<div class="p-3">
						<div class="d-flex align-items-center justify-content-between">
							<p class="mb-0 fs-16">Today's Wishes
                            </p>
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
			&nbsp;&nbsp;&nbsp;
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
									<img src="<?= base_url('../assets/images/faces/15.jpg'); ?>" alt="img">
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
										<a href="javascript:void(0);"class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-close-circle-line fs-5"></i></a>
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
								<img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="img">
							</span>
						</div>
						<div class="d-xl-block d-none lh-1">
							<span class="fw-medium lh-1"><?= (isset($info['uname'])) ? $info['uname'] : ''; ?></span>
						</div>
					</div>
				</a>
				<!-- End::header-link|dropdown-toggle -->
				<ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
					aria-labelledby="mainHeaderProfile">
					<li class="border-bottom">
                        <a class="dropdown-item d-flex flex-column" href="#">
                            <span class="fs-12 text-muted">Wellcome!</span>
                            <span class="fs-14"><?= (isset($info['uname'])) ? $info['uname'] : ''; ?></span>
                        </a>
					</li>
					<li >
                        <a class="dropdown-item d-flex align-items-center <?= ($allow['role'] == ADMIN) ? 'd-none' : ''; ?>" href="<?= base_url('userprofile'); ?>">
                            <i class="ti ti-user me-2 fs-18 text-primary"></i>Profile
                        </a>
                    </li>
					<li>
                        <a class="dropdown-item d-flex align-items-center <?= ($allow['role'] == STAFF) ? 'd-none' : ''; ?>" href="<?= base_url('admin_setting'); ?>">
                        	<i class="ti ti-settings me-2 fs-18 text-primary"></i>Settings
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
		<a href="<?= base_url(''); ?>" class="header-logo">
			<img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="desktop-logo">
			<img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="toggle-logo">
			<img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="desktop-dark">
			<img src="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpylogo']; ?>" alt="logo" class="toggle-dark">
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
				
				<li class="slide <?= $permission['Dashboard']; ?>">
					<a href="<?= base_url('dashboard'); ?>" class="side-menu__item">
						<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/>
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/>
                        </svg>
						<span class="side-menu__label">Dashboard</span>
					</a>
				</li>

				<li class="slide <?= $permission['Court Status']; ?>">
                    <a href="<?= base_url('court_status'); ?>" class="side-menu__item">
                        <i class="bi bi-calendar-check"></i>
                        <span class="side-menu__label"> &emsp;Court Status</span>
                    </a>
                </li>

                <li class="slide <?= $permission['Bookings']; ?>">
                    <a href="<?= base_url('bookings'); ?>" class="side-menu__item">
                        <i class="bi bi-journal-check"></i>
                        <span class="side-menu__label"> &emsp;Bookings</span>
                    </a>
                </li>

                <li class="slide <?= $permission['Staff']; ?>">
                    <a href="<?= base_url('staff'); ?>" class="side-menu__item">
                        <i class="bi bi-people"></i>
                        <span class="side-menu__label"> &emsp;Staffs</span>
                    </a>
                </li>

                <li class="slide <?= $permission['Customers']; ?>">
                    <a href="<?= base_url('customer'); ?>" class="side-menu__item">
                        <i class="bi bi-people"></i>
                        <span class="side-menu__label"> &emsp;Customers</span>
                    </a>
                </li>            

                <li class="slide <?= $permission['Calander']; ?>">
                    <a href="<?= base_url('attendance'); ?>" class="side-menu__item">
                        <i class="bi bi-calendar"> </i>
                        <span class="side-menu__label"> &emsp;Calendar</span>
                    </a>
                </li>

                <li class="slide <?= $permission['Settings']; ?>">
                    <a href="<?= base_url('admin_setting'); ?>" class="side-menu__item">
                        <i class="bi bi-gear"></i>
                        <span class="side-menu__label"> &emsp;Settings</span>
                    </a>
                </li>

                <li class="slide">
                    <a href="<?= base_url('viewlogs'); ?>" class="side-menu__item">
                        <i class="bi bi-gear"></i>
                        <span class="side-menu__label"> &emsp;Logs</span>
                    </a>
                </li>

				<li class="slide <?= ($allow['role'] == ADMIN) ? 'd-none' : ''; ?>">
					<a href="<?= base_url('today_booking'); ?>" class="side-menu__item">
						<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M4 17h16v2H4zm13-6.17L15.38 12 12 7.4 8.62 12 7 10.83 9.08 8H4v6h16V8h-5.08z" opacity=".3"/>
                            <path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 12 7.4l3.38 4.6L17 10.83 14.92 8H20v6z"/>
                        </svg>
						<span class="side-menu__label">Today's Booking</span>
					</a>
				</li>


				<li class="slide has-sub <?= $permission['Reports']; ?>">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M5 5h15v3H5zm12 5h3v9h-3zm-7 0h5v9h-5zm-5 0h3v9H5z" opacity=".3"/>
                            <path d="M20 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h15c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM8 19H5v-9h3v9zm7 0h-5v-9h5v9zm5 0h-3v-9h3v9zm0-11H5V5h15v3z"/>
                        </svg>
                        <span class="side-menu__label">Reports</span>
                        <i class="ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="<?= base_url('revenue'); ?>" class="side-menu__item">Revenue</a>
                        </li>
                        <!-- <li class="slide">
                            <a href="<?= base_url('day_close'); ?>" class="side-menu__item">Day Close</a>
                        </li> -->
                        <li class="slide">
                            <a href="<?= base_url('view_maintenance'); ?>" class="side-menu__item">Court Maintenance</a>
                        </li>

                        <li class="slide">
                            <a href="<?= base_url('view_razorpay'); ?>" class="side-menu__item">Razorpay</a>
                        </li>
                    </ul>
                </li>

			</ul>
			<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
		</nav>
		<!-- End::nav -->

	</div>
	<!-- End::main-sidebar -->

</aside>
<!-- End Main-Sidebar-->