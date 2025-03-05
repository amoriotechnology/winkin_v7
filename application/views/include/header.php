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
    <title> Booking Spa </title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/images/brand-logos/amorio-toggle.png'); ?>" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>

    <!-- ICONS CSS -->
    <link href="<?= base_url('assets/icon-fonts/icons.css'); ?>" rel="stylesheet">

    <!-- Choices JS -->
    <script src="<?= base_url('assets/libs/choices.js/public/assets/scripts/choices.min.js'); ?>"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="<?= base_url('assets/libs/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" >

    <!-- Node Waves Css -->
    <link href="<?= base_url('assets/libs/node-waves/waves.min.css'); ?>" rel="stylesheet" > 

    <!-- Simplebar Css -->
    <link href="<?= base_url('assets/libs/simplebar/simplebar.min.css'); ?>" rel="stylesheet" >
    
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/@simonwep/pickr/themes/nano.min.css'); ?>">

    <!-- Choices Css -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/choices.js/public/assets/styles/choices.min.css'); ?>">

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/flatpickr/flatpickr.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datepicker/daterangepicker.css'); ?>">

    <!-- Auto Complete CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css'); ?>"> 
         
    <!-- APP CSS & APP SCSS -->
    <link rel="preload" as="style" href="<?= base_url('myassets/css/app.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css'); ?>" />

    <!-- Tagify CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/@yaireo/tagify/tagify.css'); ?>">

    <!-- Sweetalerts CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/libs/gridjs/theme/mermaid.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('myassets/css/mystyle.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/datatable/dataTables.bootstrap5.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datatable/responsive.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datatable/buttons.bootstrap5.min.css'); ?>">

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/flatpickr/flatpickr.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datepicker/daterangepicker.css'); ?>">

    <script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>

    <!-- validate -->
    <script src="<?= base_url('assets/js/jqueryvalidate1.19.5.js'); ?>"></script>

    <!-- Tagify JS -->
    <script src="<?= base_url('assets/libs/@yaireo/tagify/tagify.js'); ?>"></script>
    

    <!-- Date & Time Picker JS -->
    <script src="<?= base_url('assets/libs/flatpickr/flatpickr.min.js'); ?>"></script>


    <script type="text/javascript">

        $(document).ready(function(){
          $('input[type="number"]').on('keypress', function (e) {  //to avoid e
                  // Prevent 'e', 'E', '+', and '-' keys
                  if (e.key === 'e' || e.key === 'E' || e.key === '+' || e.key === '-') {
                    e.preventDefault();
                  }
                });

            });
    </script>

    <style type="text/css">
            
        /* Remove arrows from number input fields in most browsers */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

</head>