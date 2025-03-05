<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/* Backend Controller */
$route['admin'] = 'backend';
$route['dashboard'] = 'backend';
$route['calendar'] = 'backend/calendar';
$route['today_booking'] = 'backend/today_booking';
$route['add_booking'] = 'backend/add_booking';
$route['update_cust_booking'] = 'backend/update_cust_booking';
$route['add_customer'] = 'backend/add_customer';
$route['add_category'] = 'backend/add_category';
$route['add_service'] = 'backend/add_service';
$route['add_staff'] = 'backend/add_staff';
$route['add_leave'] = 'backend/add_leave';
$route['leave_check'] = 'backend/leave_check';
$route['getStylists'] = 'backend/getStylists';
$route['getCourtTiming'] = 'backend/getCourtTiming';
$route['checkExistorNot'] = 'backend/checkExistorNot';
$route['checkExiststaff'] = 'backend/checkExiststaff';
$route['cancel_appoint'] = 'backend/cancel_appoint';
$route['updatePayment'] = 'backend/updatePayment';
$route['get_coupons'] = 'backend/get_coupons';
$route['cancel_slot'] = 'backend/cancel_slot';
$route['getAppData'] = 'backend/getAppData';
$route['day_openinsert'] = 'backend/day_openinsert';
$route['checkdayopen_data'] = 'backend/checkdayopen_data';
$route['setopening_balance'] = 'backend/setopening_balance';
$route['dayclose_update'] = 'backend/dayclose_update';
$route['razorpaysuccess'] = 'backend/paymentSuccess';
$route['payment_create'] = 'backend/payment_create';
$route['get_customerdata'] = 'backend/get_customerdata';
$route['viewlogs'] = 'backend/viewlogs';

$route['login'] = 'backend/login';
$route['login_submit'] = 'backend/login_submit';
$route['logout'] = 'backend/logout';


/* Settings Controller*/
$route['attendance'] = 'settings/attendance';
$route['add_attend'] = 'settings/add_attend';
$route['admin_setting'] = 'settings/admin_setting';
$route['userprofile'] = 'settings/admin_setting';
$route['admin_setting/(:any)'] = 'settings/admin_setting/$1';
$route['add_holiday'] = 'settings/add_holiday';
$route['setting_config'] = 'settings/setting_config';
$route['send_wishes'] = 'settings/send_wishes';
$route['holiday_calender'] = 'settings/holiday_calender';
$route['common_update'] = 'settings/common_update';
$route['email_temp'] = 'settings/email_temp';
$route['send_otp'] = 'settings/send_otp';
$route['validateOTP'] = 'settings/validateOTP';
$route['change_password'] = 'settings/change_password';
$route['coupons'] = 'settings/coupons';
$route['coupons/(:any)'] = 'settings/coupons/$1';
$route['add_coupon'] = 'settings/add_coupon';
$route['generate_upi_qr'] = 'settings/generate_upi_qr';


/* Reports Controller */
$route['bookings'] = 'reports/bookings';
$route['getbookingsDatas'] = 'reports/getbookingsDatas';
$route['getlogDatas'] = 'reports/getlogDatas';
$route['bookings/(:any)'] = 'reports/bookings/$1';
$route['court_status'] = 'backend/court_status';
$route['add_maintenance'] = 'backend/add_maintenance';
$route['viewcourt_status/(:any)'] = 'backend/court_status/$1';
$route['revenue'] = 'reports/revenue';
$route['getrevenueDatas'] = 'reports/getrevenueDatas';
$route['customer'] = 'reports/customer';
$route['getcustomerDatas'] = 'reports/getcustomerDatas';
$route['customer/(:any)'] = 'reports/customer/$1';
$route['view_records'] = 'reports/view_records';
$route['category'] = 'reports/category';
$route['getcategoryDatas'] = 'reports/getcategoryDatas';
$route['category/(:any)'] = 'reports/category/$1';
$route['service'] = 'reports/service';
$route['getserviceDatas'] = 'reports/getserviceDatas';
$route['service/(:any)'] = 'reports/service/$1';
$route['staff'] = 'reports/staff';
$route['getstaffDatas'] = 'reports/getstaffDatas';
$route['staff/(:any)'] = 'reports/staff/$1';
$route['leaves'] = 'reports/leaves';
$route['leaves/(:any)'] = 'reports/leaves/$1';
$route['getleaveDatas'] = 'reports/getleaveDatas';
$route['getcouponDatas'] = 'reports/getcouponDatas';
$route['day_close'] = 'reports/day_close';
$route['getdaycloseDatas'] = 'reports/getdaycloseDatas';
$route['showday_closeview'] = 'reports/showday_closeview';
$route['view_maintenance'] = 'reports/view_maintenance';
$route['view_maintenance/(:any)'] = 'reports/view_maintenance/$1';
$route['getcourtMaintenanceDatas'] = 'reports/getcourtMaintenanceDatas';


$route['pdf_generate'] = 'pdf/pdf_generate';
$route['pdf_generate/(:any)'] = 'pdf/pdf_generate/$1';


$route['default_controller'] = 'Backend';
$route['404_override'] = 'error404.html';
$route['translate_uri_dashes'] = FALSE;
