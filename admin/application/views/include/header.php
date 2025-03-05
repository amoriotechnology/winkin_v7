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
    <title> Booking Admin panel </title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('../assets/images/company_imgs/').$cmpy_info['fld_cmpyfav']; ?>" >

    <!-- Main Theme Js -->
    <script src="<?= base_url('../assets/js/main.js'); ?>"></script>

    <!-- ICONS CSS -->
    <link href="<?= base_url('../assets/icon-fonts/icons.css'); ?>" rel="stylesheet">

    <!-- Choices JS -->
    <script src="<?= base_url('../assets/libs/choices.js/public/assets/scripts/choices.min.js'); ?>"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="<?= base_url('../assets/libs/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" >

    <!-- Node Waves Css -->
    <link href="<?= base_url('../assets/libs/node-waves/waves.min.css'); ?>" rel="stylesheet" > 

    <!-- Simplebar Css -->
    <link href="<?= base_url('../assets/libs/simplebar/simplebar.min.css'); ?>" rel="stylesheet" >
    
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="<?= base_url('../assets/libs/@simonwep/pickr/themes/nano.min.css'); ?>">

    <!-- Choices Css -->
    <link rel="stylesheet" href="<?= base_url('../assets/libs/choices.js/public/assets/styles/choices.min.css'); ?>">

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="<?= base_url('../assets/libs/flatpickr/flatpickr.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('../assets/datepicker/daterangepicker.css'); ?>">

    <!-- Auto Complete CSS -->
    <link rel="stylesheet" href="<?= base_url('../assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css'); ?>"> 
         
    <!-- APP CSS & APP SCSS -->
    <link rel="preload" as="style" href="<?= base_url('../assets/css/app.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('../assets/css/app.css'); ?>" />

    <!-- Tagify CSS -->
    <link rel="stylesheet" href="<?= base_url('../assets/libs/@yaireo/tagify/tagify.css'); ?>">

    <!-- Sweetalerts CSS -->
    <link rel="stylesheet" href="<?= base_url('../assets/libs/sweetalert2/sweetalert2.min.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('../assets/libs/gridjs/theme/mermaid.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('../assets/css/booking_style.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('../assets/datatable/dataTables.bootstrap5.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('../assets/datatable/responsive.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('../assets/datatable/buttons.bootstrap5.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('../assets/datatable/buttons.dataTables.min.css'); ?>">

    <script src="<?= base_url('../assets/js/jquery-3.7.1.min.js'); ?>"></script>

    <!-- Tagify JS -->
    <script src="<?= base_url('../assets/libs/@yaireo/tagify/tagify.js'); ?>"></script>
        
    <!-- Date & Time Picker JS -->
    <script src="<?= base_url('../assets/libs/flatpickr/flatpickr.min.js'); ?>"></script>
    
    <!-- Highcharts CDN -->
    <script src="<?= base_url('../assets/highcharts/highcharts.js'); ?>"></script>
    <script src="<?= base_url('../assets/highcharts/highcharts-3d.js'); ?>"></script>
    <script src="<?= base_url('../assets/highcharts/accessibility.js'); ?>"></script>
</head>