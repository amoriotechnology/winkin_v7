<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['signup'] = 'Signup';
$route['signup_validate'] = 'Signup/signup_validate';
$route['signup_submit'] = 'Signup/signup_validate';

$route['login'] = 'Login';
$route['login_submit'] = 'Login/login_submit';
$route['forgot_password'] = 'Login/forgot_password';

$route['mybooking'] = 'Booking';
$route['bookings'] = 'Booking';
 
$route['dashboard'] = 'Home';
$route['Getcustphone'] = 'Home/getphone';
$route['logout'] = 'Home/logout';

$route['index'] = 'Frontend/index';
$route['index/(:any)'] = 'Frontend/index/$1';
$route['getStylists'] = 'Frontend/getStylists';
$route['getCourtTiming'] = 'Frontend/getCourtTiming';
$route['add_cust_booking'] = 'Frontend/add_cust_booking';
$route['checkExistorNot'] = 'Frontend/checkExistorNot';
$route['get_coupons'] = 'Frontend/get_coupons';
$route['cancel_appoint'] = 'Frontend/cancel_appoint';
$route['qr_generate'] = 'Frontend/qr_generate';
$route['pdf_generate/(:any)'] = 'Pdf/pdf_generate/$1';

$route['mybookings'] = 'Frontend/mybookings';
$route['getcustbookingsDatas'] = 'Frontend/getcustbookingsDatas';
$route['profile'] = 'Frontend/myprofile';
$route['user_update'] = 'Frontend/profile_update';
$route['update_appointment'] = 'Frontend/update_appointment';
$route['razorpaysuccess'] = 'Frontend/paymentSuccess';
$route['payment_create'] = 'Frontend/payment_create';

$route['forget_pwd'] = 'Profile/forget_pwd';
$route['send_otp'] = 'Profile/send_otp';
$route['validateOTP'] = 'Profile/validateOTP';
$route['change_password'] = 'Profile/change_password';

$route['default_controller'] = 'Frontend';
$route['404_override'] = 'error404.html';
$route['translate_uri_dashes'] = FALSE;
