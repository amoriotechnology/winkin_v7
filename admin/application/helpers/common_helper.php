<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . '../vendor/autoload.php';
use Razorpay\Api\Api;
	
	if(!function_exists('getInstance')) { /* init getinstance */
		function getInstance() {
			$CI = & get_instance();
			return $CI;
		}
	}


	if(!function_exists('getSettingData')) { /* init getSettingData */
		function getSettingData() {
			getInstance()->load->model('Common_model');
			$result = getInstance()->Common_model->GetDatas('settings', '*');
			$data = [];
			foreach($result as $key => $res) {
				$data = $res;
			}
			return $data;
		}
	}


	if(!function_exists('checkLogin')) { /* login check if not login redirect to login */
		function checkLogin() {
			getInstance()->load->library('session');
			$userdata = getInstance()->session->userdata('login_info');
			if(empty($userdata)) { redirect('login'); } else { return $userdata; }
		}
	}


	if (!function_exists('ImageUpload')) {
	    function ImageUpload($imagename, $path, $width = "", $height = "") {

	        $config['file_name'] = $_FILES[$imagename]['name'];
	        $config['upload_path'] = $path;
	        $config['allowed_types'] = 'jpg|jpeg|png|webp';
	        $config['max_size'] = 2048;
	        if(!empty($width)) { $config['max_width'] = $width; }
	        if(!empty($height)) { $config['max_height'] = $height; }
	        getInstance()->load->library('upload', $config);

	        if (!getInstance()->upload->do_upload($imagename)) {
	            $response = array('status' => 400, 'msg' => getInstance()->upload->display_errors('', '')); 
	        } else {
	        	$response = array('status' => 200, 'msg' => getInstance()->upload->data());
	        }
	        return $response;
	    }
	}


	if(!function_exists('showDate')) { /* format date for frontend view */
		function showDate($date) {
			
			$length = strlen($date);
			$showdate = "";
			if(!empty($date) && $date != "0000-00-00" && $date != "0000-00-00 00:00:00") {
				$format = 'd/m/Y';
				if($length > 11) { $format = 'd/m/Y h:i A'; }
				$showdate = date($format, strtotime($date));
			}
			return $showdate;
		}
	}


	if(!function_exists('showTime')) { /* format date for frontend view */
		function showTime($time) {
			
			$showtime = "";
			if(!empty($time) && $time != "00:00" && $time != "00:00:00") {
				$format = 'h:i A';
				$showtime = date($format, strtotime($time));
			}
			return $showtime;
		}
	}


	if(!function_exists('TimeDuration')) { /* format date for db store */
		function TimeDuration($times, $duration) {
			
			$timedura = "";
			if(!empty($times) && !empty($duration)) {
				$splitTime = explode(', ', $times);
				foreach($splitTime as $time) {
					$timedura .= date('h:i A', strtotime($time.' +'.$duration.' minutes'));
				}
			}
			return $timedura;	
		}
	}


	if(!function_exists('struDate')) { /* format date for db store */
		function struDate($date) {
			
			$length = strlen($date);
			$date = str_replace([' ', '/'], '-', $date);
			$strudate = "";

			if(!empty($date) && $date != "0000-00-00" && $date != "0000-00-00 00:00:00") {
				$format = 'Y-m-d';
				if($length > 11) { $format = 'Y-m-d H:i'; }
				$strudate = date($format, strtotime($date));
			}
			return $strudate;	
		}
	}
	
	
	if(!function_exists('BookTimes')) { /* get today bday and anniversary detail */
		function BookTimes($time) {
			
			$booktime = "";
            if(!empty($time)) {
                $splittime = explode(", ",$time);
                foreach($splittime as $times) {
                    $booktime .= date('h:i A', strtotime($times)).' - '.date('h:i A', strtotime($times.' +30 minutes')).', ';
                }
            }
	        return rtrim($booktime, ", ");
		}
	}


	if(!function_exists('alertMsg')) { /* return alert msg color & sentence */
		function alertMsg($name) {
			$color = [
				'add_suc' => 'success',
				'add_fail' => 'danger' ,
				'login_suc' => 'success', 
				'up_suc' => 'success',
				'log_fail' => 'danger',
				'already_fail' => 'danger'
			];

			$word = [
				'add_suc' => 'Added Successfully!!!',
				'add_fail' => 'Added Failed!!!' ,
				'login_suc' => 'Login Successfully!!!', 
				'up_suc' => 'Updated Successfully!!!',
				'log_fail' => 'Email / Password Incorrect!',
				'already_fail' => 'Coupon Already Exists !!!',
			];

			$alert_msg = [];
			if(in_array($name, array_keys($word))) {
				$alert_msg = ['color' => $color[$name], 'word' => $word[$name]];
			}
			return $alert_msg;
		}
	}


	if(!function_exists('mintoHour')) { /* convert minutes to hour(s) */
		function mintoHour($mins) {
			$hours = (int)((float)$mins / 60);
			$hour = ($hours < 9) ? '0'.$hours : $hours;
			$min = ($mins - ($hours * 60));
			$mins = ($min < 9) ? '0'.$min : $min;

			return $hour.':'.$mins;
		}
	}


	if(!function_exists('isSame')) { /* checking value for select dropdown */
		function isSame($var1, $var2) {
			return ($var1 == $var2) ? 'selected' : '';
		}
	}


	if(!function_exists('DateDiff')) { /* return days count of btw dates */
		function DateDiff($date1, $date2) {
			$start = struDate($date1);
			$end = struDate($date2);
			$diff = date_diff(date_create($start), date_create($end));
			return $diff->format("%a");			
		}
	}


	if(!function_exists('ExistorNot')) { /* return existing value */
		function ExistorNot($table, $where) {
			getInstance()->load->model('Common_model');
			$result = getInstance()->Common_model->GetDatas($table, '*', $where);
			return $result;
		}
	}


	if(!function_exists('AgeCal')) { /* return year diff count */
		function AgeCal($dob) {
			return ((int)date('Y') - (int)date('Y', strtotime($dob)));
		}
	}


	if(!function_exists('pageConfig')) { /* return page config */
		function pageConfig($url, $table, $where = NULL) {
			getInstance()->load->model('Common_model');
			getInstance()->load->library('pagination');
			$pageconfig = array();
			$pageconfig["base_url"] = base_url($url);
			$pageconfig["total_rows"] = getInstance()->Common_model->getCount($table, $where);
			$pageconfig["per_page"] = 10;
			$pageconfig["uri_segment"] = 10;
			// $pageconfig['num_links'] = 5;
			$pageconfig['use_page_numbers'] = TRUE;
			$pageconfig['page_query_string'] = TRUE;
			$pageconfig['reuse_query_string'] = TRUE;

			$pageconfig['full_tag_open'] = '<nav aria-label="Page navigation" class="pagination-style-1"> <ul class="pagination justify-content-end mb-0">'; 
			$pageconfig['full_tag_close'] = '</ul> </nav>';
			$pageconfig['first_link'] = '<li class="page-item"> <span class="page-link"> First </span> </li>';
			$pageconfig['last_link'] = '<li class="page-item"> <span class="page-link"> Last </span> </li>';
			$pageconfig['next_link'] = '<li class="page-item"> <span class="page-link"> <i class="ri-arrow-right-s-line align-middle"></i> </span> </li>';
			$pageconfig['prev_link'] = '<li class="page-item"> <span class="page-link"> <i class="ri-arrow-left-s-line align-middle"></i> </span> </li>';
			$pageconfig['cur_tag_open'] = '<li class="page-item active"> <a class="page-link" href="'.base_url($url).'">';
			$pageconfig['cur_tag_close'] = '</a></li>';
			$pageconfig['num_tag_open'] = '<li class="page-item"> <span class="page-link">';
			$pageconfig['num_tag_close'] = '</span> </li>';
			getInstance()->pagination->initialize($pageconfig);
			return $pageconfig;
		}
	}


	if(!function_exists('BookingTime')) { /* get today bday and anniversary detail */
		function BookingTime($time) {
			
			$booktime = "";
            if(!empty($time)) {
                $splittime = explode(", ",$time);
                foreach($splittime as $times) {
                    $booktime .= date('h:i A', strtotime($times)).' - '.date('h:i A', strtotime($times.' +30 minutes')).', ';
                }
            }
	        return rtrim($booktime, ", ");
		}
	}


	if(!function_exists('mergeAppointment')) { /* merge appointment based on appointment ID */
		function mergeAppointment($records) {

			$appoint_rec = [];
			$prev_id = '';
			if(!empty($records)) {
				foreach($records as $rec) { 

					if($rec['fld_appointid'] != $prev_id) {
						$servs = $staffs = $times = '';
						$rate = 0;
						$serv_data = [];
					}
					$servs .= $rec['fld_amserv_name'].", ";
					$times .= $rec['fld_amstaff_time'].", ";

					$courtTiming = $rec['fld_atime'];
					preg_match('/"([^"]+)"/', $courtTiming, $matches);

					$time_value = $matches[1];

					$rate += (float)$rec['fld_amserv_rate'];
					$serv_data[] = [$rec['fld_amserv_name'], $rec['fld_amserv_dura'], $rec['fld_amserv_rate'], $rec['fld_amstaff_time']];
					
					$appoint_rec[$rec['fld_appointid']] = [
						'app_aid' => $rec['fld_aid'],
						'book_date' => $rec['fld_booked_date'],
						'app_id' => $rec['fld_appointid'],
						'app_date' => $rec['fld_adate'],
						'fld_booked_date' => $rec['fld_booked_date'],
						'app_time' => rtrim($times, ", "),
						'app_dura' => $rec['fld_aduring'],
						'app_custid' => $rec['fld_id'],
						'app_starttime' => $time_value,
						'app_cid' => $rec['fld_id'],
						'app_name' => $rec['fld_name'],
						'app_lname' => $rec['fld_lastname'],
						'app_phone' => $rec['fld_phone'],
						'app_email' => $rec['fld_email'],
						'app_gst' => $rec['fld_gst_amt'],
						'app_serv' => $rec['fld_amserv_name'],
						'app_rate' => round($rate, 2),
						'app_sts' => $rec['fld_astatus'],
						'app_reason' => $rec['fld_cancel_reason'],
						'app_paymode' => $rec['fld_apaymode'],
						'app_paid' => round((float)$rec['paid'], 2),
						'app_balance' => round((float)$rec['fld_abalance'], 2),
						'app_paysts' => $rec['fld_apaystatus'],
						'cgen' => $rec['fld_gender'],
						'cdob' => $rec['fld_dob'],
						'mari_sts' => $rec['fld_maritial_sts'],
						// 'fld_staff_designation' => $rec['fld_staff_designation'],
						'canniversary' => $rec['fld_anniversary'],
						'caddr' => $rec['fld_address'],
						'app_amount' => 0,
						'app_note' => $rec['fld_anotes'],
						'cnote' => $rec['fld_notes'],
						'serv_data' => $serv_data,
						'coup_id' => $rec['fld_acpid'],
						'coup_name' => $rec['fld_cpname'],
						'coup_perc' => $rec['fld_acppercent'],
						'app_cpamt' => $rec['fld_acpamt'],
					];
					$prev_id = $rec['fld_appointid'];
				}
			}
			return $appoint_rec;
		}
	}


	if(!function_exists('GetWishes')) { /* get today bday and anniversary detail */
		function GetWishes() {
			getInstance()->load->model('Common_model');
			$wishdate = date('m-d');
			$wishes_record = getInstance()->Common_model->GetDatas('customers', "`fld_name`, `fld_phone`, `fld_email`, DATE_FORMAT(`fld_dob`, '%m-%d') as `fld_dob`, `fld_dob` as `bday`, DATE_FORMAT(`fld_anniversary`, '%m-%d') as `fld_anniversary`, `fld_anniversary` as `aday`, `fld_wishes`", "(DATE_FORMAT(`fld_dob`, '%m-%d') = '".$wishdate."') OR ( DATE_FORMAT(`fld_anniversary`, '%m-%d') = '".$wishdate."')");

			$wish_data = [];
			if(!empty($wishes_record)) {
				foreach($wishes_record as $wish) {

					if($wish['fld_dob'] == $wishdate) { 
						$wish_data['birth_days'][] = ['name' => $wish['fld_name'], 'phone' => $wish['fld_phone'], 'email' => $wish['fld_email'], 'day' => $wish['bday'], 'wish_noti' => $wish['fld_wishes']]; 
					}
					if($wish['fld_anniversary'] == $wishdate) { 
						$wish_data['anni_days'][] = ['name' => $wish['fld_name'], 'phone' => $wish['fld_phone'], 'email' => $wish['fld_email'], 'day' => $wish['aday'], 'wish_noti' => $wish['fld_wishes']];
					}
				}
			}
			return $wish_data;
		}
	}


	if(!function_exists('GetQRCode')) { /* get qr code for online transaction */
		function GetQRCode($upi_code, $upi_name, $trans_amount, $notes) {

			getInstance()->load->library('QRCode');
			/*$a = require APPPATH.'/libraries/qrcode.php';*/
			$upi_id = $upi_code;
	        $name 	= $upi_name;
	        $amount = $trans_amount;
	        $note 	= $notes;

	        $upi_url = "upi://pay?pa={$upi_id}&pn={$name}&am={$amount}&cu=INR&tn={$note}";
	        // $file_path = base_url('../assets/uploads/upi_qr_code.JPEG');
	        $qr_code = QRCode::getMinimumQRCode($upi_url, QR_ERROR_CORRECT_LEVEL_L);
			return $qr_code->printHTML("8px");
		}
	}


	if(!function_exists('EmailConfig')) { /* get today bday and anniversary detail */
		function EmailConfig() {
			$settings = getSettingData();
			$emailconfig = array(
	            'protocol'  => 'smtp', // Can also be 'mail' or 'sendmail'
	            'smtp_host' => $settings['fld_host'],
	            'smtp_port' => 465,
	            'smtp_user' => $settings['fld_fromemail'],
	            'smtp_pass' => $settings['fld_emailpass'],
	            'smtp_crypto' => 'ssl',
	            'mailtype'  => 'html',
	            'charset'   => 'utf-8',
	            'wordwrap'  => TRUE
	        );
			return $emailconfig;
		}
	}


	if(!function_exists('SendEmail')) { /* get today bday and anniversary detail */
		function SendEmail($to, $cc, $bcc, $subj, $msg, $attachment = NULL) {
			
			getInstance()->load->library('email');
			getInstance()->email->initialize(EmailConfig());
			getInstance()->email->from('yokesh@amoriotech.com', 'Amorio');
			getInstance()->email->to($to);
	        getInstance()->email->cc($cc); // Optional, use for carbon copy
	        getInstance()->email->bcc($bcc); // Optional, use for blind carbon copy
	        getInstance()->email->subject($subj);
	        if(!empty($attachment)) {
	        	getInstance()->email->attach($attachment);
	        }
	        getInstance()->email->message($msg);
	        if(getInstance()->email->send()) {
	        	$result = 'Email sent successfully.';
	        } else {
	        	$result = 'Failed to send email. ' . getInstance()->email->print_debugger();
	        }

	        return $result;
		}
	}


	if(!function_exists('EmailTemplate')) { /* Email Template for wishes */
		function EmailTemplate($data) {
			$template = "";
			if(!empty($data)) {
				$template = '<!DOCTYPE html>
								<html>
								  <head>
								    <meta charset="utf-8">
								    <meta name="viewport" content="width=device-width">
								    <meta http-equiv="X-UA-Compatible" content="IE=edge">
								    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
								    <meta name="color-scheme" content="light">
								    <meta name="supported-color-schemes" content="light">
								    <title>Wishes</title>								   
								    <style>
								      @font-face {
								        font-family: Poppins;
								        font-style: normal;
								        font-weight: 400;
								        font-display: swap;
								        src: url(https://fonts.gstatic.com/s/poppins/v20/pxiEyp8kv8JHgFVrJJfecg.woff2) format(woff2);
								        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
								      }
								      html,
								      body {
								        margin: 0 auto !important;
								        padding: 0 !important;
								        height: 100% !important;
								        width: 100% !important;
								      }
								      table {
								        border-spacing: 0 !important;
								        border-collapse: collapse !important;
								        table-layout: fixed !important;
								        margin: 0 auto !important;
								      }
								      h2, h3 {
								        padding: 0;
								        margin: 0;
								        border: 0;
								        background: none;
								      }
								      .bg-white {
								        background-color:#ffffff;
								        padding:10px 20px;
								      }
								    </style>
								  </head>

								  <body style="background-color: #F2F2F2;">
								    <center>
								      <div style="max-width: 680px; margin: 0 auto;" class="email-container">
								        <table>
								            <tr>
								              <td class="separator" aria-hidden="true" height="20" style="height:20px"> &nbsp; </td>
								            </tr>								           
								            <tr>
								              <td class="p-0-10-50 bg-white" style="border-radius:20px;">
								                <br>
								                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
								                    <tr>
								                      <td align="center" style="border:1px solid #a20c25; border-radius: 15px; padding:35px 20px">
								                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">';
									                    if(isset($data['content'])) {
									                    	$template .= '<tr>
											                            <td style="font-family:Poppins,Arial,sans-serif; font-size:14px; mso-line-height-rule: exactly;line-height: 1.5;padding-bottom:30px;color:#000000;text-align:center">
											                              <p>'.$data['content'].'</p>
											                            </td>
											                          </tr>';
									                    }
									                    if(isset($data['wish_msg'])) {
									                    	$template .= '<tr>
																			<td style="font-family:Poppins,Arial,sans-serif; font-size:20px; text-align:center">
																				<p style="margin:0; color:#a20c25;font-weight:600">Your OTP for password reset is: <strong>'.$data['wish_msg'].'</strong></p>
																				<p style="margin:10px 0; color:#000; font-size:16px;">Please use this One-Time Password (OTP) to reset your password. Do not share this code with anyone for security reasons. </p>
																			</td>
																		</tr>';
									                    }
								            $template .= '</table>
								                      </td>
								                    </tr>
								                  </table>

								            <!-- <tr>
								              <td class="p-15-10 bg-white">
								                <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
								                  <tr>
								                    <td style="border-radius: 30px; background: #a20c25;text-align:center">
								                      <a class="btn" href="" style="border: 1px solid #a20c25; font-family:Poppins,Arial,sans-serif; font-size:22px; mso-line-height-rule: exactly;line-height:22px; text-decoration: none; padding: 11px 25px; color: #ffffff; font-weight:600;display: block; border-radius: 30px;"> Booking Spa</a>
								                    </td>
								                  </tr>
								                </table>
								              </td>
								            </tr> -->

								                <table>
								                  <tr>
								                    <td align="center">
								                      <br><br>
								                      <img src="assets/images/company_imgs/amo-black.png" alt="" width="250" height="100" >
								                    </td>
								                  </tr>
								                </table>                           
								           
								                <table class="">
								                  <tr>
								                    <td style="font-family:Poppins,Arial,sans-serif; font-size:10px; padding:20px;text-align:center">
								                      <p>Spa bookings are an essential part of the spa experience, allowing clients to enjoy the relaxation and rejuvenation that comes with a variety of wellness treatments. Whether you’re visiting a luxury resort spa or a local wellness center, making an appointment in advance ensures that you get the treatment you desire at a time that suits you. A well-organized spa booking process not only guarantees your spot but also sets the stage for an enjoyable experience where you can unwind, de-stress, and take care of your well-being.
								                      </p>
								                      <p style="margin:0">
								                        <a target="_blank" href="" style="color:#000000;text-decoration:underline">Teams & Conditions</a>
								                      </p>
								                    </td>
								                  </tr>
								                </table>                               
								              </td>
								            </tr>

								          </table>
								        </div>
								    </center>
								  </body>
								</html>';
			}
			return $template;
		}
	}


	if(!function_exists('BookingTemplate')) { 
		function BookingTemplate($data) {
			$template = "";
			if(!empty($data)) {
				$amount = (float)$data['amount'] - ((isset($data['couponAmount']) && !empty($data['couponAmount'])) ? (float)$data['couponAmount'] : 0);
				$gettime= implode(',',$data['time']);
				$timing = BookingTime($gettime);
				$template = '<!DOCTYPE html>
								<html>
								  <head>
								    <meta charset="utf-8">
								    <meta name="viewport" content="width=device-width">
								    <meta http-equiv="X-UA-Compatible" content="IE=edge">
								    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
								    <meta name="color-scheme" content="light">
								    <meta name="supported-color-schemes" content="light">
								    <title>Wishes</title>
								   
								    <style>
								      @font-face {
								        font-family: monospace;
								        font-style: normal;
								        font-weight: 400;
								        font-display: swap;
								        src: url(https://fonts.gstatic.com/s/poppins/v20/pxiEyp8kv8JHgFVrJJfecg.woff2) format(woff2);
								        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
								      }
								      html,
								      body {
								        font-family: system-ui;
								        margin: 0 auto !important;
								        padding: 0 !important;
								        height: 100% !important;
								        width: 100% !important;
								        font-weight: 500;
								        font-size: 18px;
								      }
								     
								      table {
								        border-spacing: 0 !important;
								        border-collapse: collapse !important;
								        table-layout: fixed !important;
								        margin: 0 auto !important;
								      }

								      h2, h3 {
								        padding: 0;
								        margin: 0;
								        border: 0;
								        background: none;
								      }

								      .bg-white {
								        background-color:#ffffff;
								        padding:10px 20px;
								      }

								      .bg-primary {
								        background-color: #596a03;
								        color: #fff;
								      }

								      .content {
								        border-radius: 6px;
								        padding: 2rem;
								        display: flex;
								      }

								      .container {
								        border-radius: 6px;
								        padding: 1rem;
								        display: flex;
								      }

								      .div-left {
								        font-family: monospace;
								        font-weight: 500;
								        font-size: 25px;
								        width: 50%;
								        height: 100%;
								      }

								      .left {
								        width: 100%;
								        float: left;
								        margin: 50px;
								      }

								      .div-right {
								        width: 50%;
								        height: 100%;
								      }

								      .text-muted {
								        color: gray;
								        font-weight: 300;
								        font-size: 20px;
								      }

								      .text-white {
								        color: #fff;
								      }

								      .text-center {
								        width: 100%;
								        text-align: center !important;
								      }
								    </style>
								  </head><body style="background-color: #F2F2F2;"><center><div style="max-width: 680px; margin: 0 auto;" class="email-container">';
								          
								            $template .=  '<div class="content bg-primary">
																<table class="width: 100%">';
																	if ($data['payment_method'] !== '') {
																		$template .=  '<tr> <th> Payment successfully processed on '.showDate(CURDATE).' </th> </tr>';
																	}else{
																		$template .=  '<tr> <th> Payment is Pending </th> </tr>';
																	}
																	$template .=  '<tr> <th> <h2> ₹'.round($amount, 2).'</th> </tr> </h2>
																</table>
															</div>';

                                        if ($data['payment_method'] !== '') {
								           $template .=  '<p> Your payment against WINKIN for ₹'.round($amount, 2).' is successful.</p>';
										}else{
											$template .=  '<p> Your payment against WINKIN for ₹'.round($amount, 2).' is pending. </p>';
										}

										$template .= '<table width="100%" border="0">
														<tr class="container">
															<th> BOOKING ID : <span class="text-muted">#'.$data['appoint_id'].'</span> </th>
														</tr>';
														if ($data['payment_method'] !== '') {
															$template .= '<tr class="container"> <th> AMOUNT ₹: <span class="text-muted">'.round($amount, 2).'</span> </th> </tr>
															<tr class="container"><th> PAYMENT MODE : <span class="text-muted">'.$data['payment_method'].'</span> </th></tr>';
														}

										$template .= '<tr class="container">
															<th> COURT : <span class="text-muted">'.(($data['court'] == 'courtA') ? "Court A" : "Court B").'</span> </th>
														</tr>
														<tr class="container">
															<th> SLOT DATE : <span class="text-muted">'.$data['date'].'</span> </th>
														</tr>
														<tr class="container">
															<th> SLOT TIME : <span class="text-muted">'.$timing.'</span> </th>
														</tr>
													</table>';										
							  
								        $template .='<p> Track all your booking details easily through your <a href="https://winkin.in">Winkin My Bookings page</a>.</p>
										  			<p> PFA(Please Find Attachment).</p>

								          <div class="container">
								            <p class="text-center">
								              Copyright © 2025. All rights reserved.
								            </p>
								          </div>
								        </div>
								    </center>
								  </body>
								</html>';
			}
			return $template;
		}
	}


	if(!function_exists('Bgcolors')) { /* get today bday and anniversary detail */
		function Bgcolors($type) {
			
			switch($type) {
				case 'Active':
					$color = 'success';
					break;
				case 'Deactive':
					$color = 'secondary';
					break;
				case 'Confirm':
					$color = 'primary';
					break;
				case 'Confirmed':
					$color = 'primary';
					break;
				case 'Completed':
					$color = 'completesuccess';
					break;
				case 'Hold':
					$color = 'warning';
					break;
				case 'In-Progress':
					$color = 'info';
					break;
				case 'Cancelled':
					$color = 'danger';
					break;
				case 'Approved':
					$color = 'success';
					break;
				case 'Rejected':
					$color = 'danger';
					break;
				case 'Pending':
					$color = 'info';
					break;
				default:
					$color = 'info';
					break;
			}

	        return $color;
		}
	}


	if(!function_exists('GetStaffID')) { /* get data table records */
		function GetStaffID($ID) {
	        $res = getInstance()->Common_model->GetDatas('users', 'fld_staffid', ['fld_uid' => $ID]);
	        return $res[0]['fld_staffid'];
		}
	}


	if(!function_exists('TableRecords')) { /* get data table records */
		function TableRecords($records, $total_rows, $datas, $start, $draw) {
			
	        $result = $res = [];
	        $i = $start + 1;

	        foreach ($records as $item) {

	        	$action = '<div class="dropdown ms-2">
		                        <button class="btn btn-icon btn-light btn-sm btn-wave waves-light waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		                            <i class="ti ti-dots-vertical"></i>
		                        </button>
		                        <ul class="dropdown-menu" style="">
		                            <li>
		                                <a class="dropdown-item" href="">'.(($item['fld_sstatus'] == "Active") ? "Deactive" : "Active").'</a>
		                            </li>
		                            <li>
		                                <a href="'.base_url('service/'.md5($item['fld_sid'])).'" class="dropdown-item"> Edit </a>
		                            </li>
		                        </ul>
		                    </div>';
	            
	            foreach($datas as $keyfield => $field) {
	            	$res = [$keyfield => $item[$field]];
	            }
	            $result[] = array_merge($res, ['action' => $action]);
	            $i++;
	        }

	        $response = [
	            "draw"            => $draw,
	            "recordsTotal"    => $total_rows,
	            "recordsFiltered" => $total_rows,
	            "data"            => $result,
	        ];
	        return $response;
		}
	}


	if(!function_exists('payNow')) {
		function payNow($data) {
           //   $rate = isset($data['amount']) ? round((float)$data['amount'], 2) : 0;

	//	 $rate = isset($data['amount']) ? (float)$data['amount'] : 0;
			$rate = 1;
			$gst = isset($data['gst']) ? (float)$data['gst'] : 0;
			$paycharge = isset($data['pay_charge']) ? (float)$data['pay_charge'] : 0;

			$amount_in_paise = ((float)$rate * 100);

			$api = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);
			$orderData = [
			  'receipt'         => 'ORD_' . rand(10000, 99999),
			  'amount'          => round($amount_in_paise,2),
			  'currency'        => 'INR',
			  'payment_capture' => 1
			];

			try {
			  $order = $api->order->create($orderData);
			  $data = [
			      'order_id' => $order['id'],
			      'amount'   => $orderData['amount'],
			      'api_key'  => RAZOR_KEY
			  ];

			  return json_encode([
			      'status' => 'success',
			      'data'   => $data
			  ]);
			} catch (Exception $e) {
			  return json_encode([
			      'status'  => 'error',
			      'message' => 'Error: ' . $e->getMessage()
			  ]);
			}
	    }
	}

  	
  	// Payment Success 
	if(!function_exists('openRazorpay')) {
		function openRazorpay($responsedata) {

		    $api = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);

		    $payment_id = $responsedata['razorpay_payment_id'];
		    $order_id = $responsedata['razorpay_order_id'];
		    $signature = $responsedata['razorpay_signature'];

		    // Verify payment signature
		    $attributes = [
		        'razorpay_order_id' => $order_id,
		        'razorpay_payment_id' => $payment_id,
		        'razorpay_signature' => $signature
		    ];

		    try {
		        $api->utility->verifyPaymentSignature($attributes);

		        // Fetch Payment Details from Razorpay
		        $payment = $api->payment->fetch($payment_id);

		        $response = [
		        	'code' => 200,
					'amount' => round(($payment['amount'] / 100), 2),
					'status' => $payment['status'],
					'payment_id'   => $payment_id,
					'order_id'   => $order_id,
					'signature'   => $signature,
					'pay_mode' => $payment['method'],
					'captured' => $payment['captured'],
					'vpa' => $payment['vpa'],
					'email' => $payment['email'],
					'contact' => $payment['contact'],
					'created_at' => $payment['created_at']
		        ];
		    } catch (Exception $e) {
				$response = [
		        	'code' => 401,
					'amount' => round(($payment['amount'] / 100), 2),
					'status' => $payment['status'],
					'payment_id'   => $payment_id,
					'order_id'   => $order_id,
					'signature'   => $signature,
					'pay_mode' => $payment['method'],
					'captured' => $payment['captured'],
					'vpa' => $payment['vpa'],
					'email' => $payment['email'],
					'contact' => $payment['contact'],
					'created_at' => $payment['created_at']
		        ];
		    }

		  echo json_encode($response);
		  exit;
		}
	}


	if(!function_exists('getPDF')) {
		function getPDF($AppointID) {

			require_once '../vendor/autoload.php';

			$table1 = 'appointments A';
	        $table2 = 'appointment_meta AM';
	        $table3 = 'customers C';
	        $table4 = 'users U';
	        $table5 = 'coupons CP';
	        $table1cond = '`AM`.`fld_amappid` = `A`.`fld_aid`';
	        $table2cond = '`A`.`fld_acustid` = `C`.`fld_id`';
	        $table3cond = '`AM`.`fld_amstaffid` = `U`.`fld_uid`';
	        $table4cond = '`CP`.`fld_cpid` = `A`.`fld_acpid`';
	        $select = "A.*, C.*, U.*, AM.*, CP.*,
	                    (SELECT SUM(P.fld_ppaid) FROM payments P WHERE P.fld_appid = A.fld_aid) AS paid,
	                    (SELECT P.fld_pbalance FROM payments P WHERE P.fld_appid = A.fld_aid ORDER BY P.fld_pdate DESC LIMIT 1) AS balance";
	        $result = getInstance()->Common_model->getAppointment($table1, $table2, $table3, $table4, $table5, $table1cond, $table2cond, $table3cond, $table4cond, $select, "A.fld_aid DESC", 10, 0, $AppointID);
			$data = [
				'appkey' => $AppointID,
				'records' => mergeAppointment($result),
				'content' => 'pdfs/app_pdf',
			];
			
			$content = getInstance()->load->view('pdf_temp', $data, true);
			$dompdf = new Dompdf();
		    $dompdf->loadHtml($content);
		    $dompdf->setPaper('A4', 'portrait');
		    $dompdf->render();
		    $filename = 'Booking_'.$AppointID.'.pdf';
	    	return $dompdf->output();		
		}
	}

	// Client Ip Address
	if(!function_exists('getClientIp')) {
	    function getClientIp() {
	        $ip = '';
	        if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
	            $ip = $_SERVER['HTTP_CLIENT_IP'];
	        } elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
	            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	        } elseif (array_key_exists('REMOTE_ADDR', $_SERVER)) {
	            $ip = $_SERVER['REMOTE_ADDR'];
	        }
	        return $ip;
	    }
	}

	// Align time order asc
	if(!function_exists('ArrayTimeAlign')) {
	    function ArrayTimeAlign($arrayValue) {
	        usort($arrayValue, function($a, $b) {
				// Convert time string to 24-hour format and compare
				$timeA = DateTime::createFromFormat('h:i A', $a[3])->format('H:i');
				$timeB = DateTime::createFromFormat('h:i A', $b[3])->format('H:i');
				
				return strcmp($timeA, $timeB);
			});
	        return $arrayValue;
	    }
	}

	// Log Common Insert Function
	if (!function_exists('logEntry')) {
	    function logEntry($user_actions, $module, $details, $status, $hint=NULL) {
	        $ci = & get_instance();
	        $ci->load->database();
	        
	        $user_ipaddress = getClientIp();

	        $getAdminId = $ci->session->userdata('login_info');

	        date_default_timezone_set('Asia/Kolkata');
	        $current_time = new DateTime();
	        $formatted_time = $current_time->format('H:i:s');

	        $data = array(
	            'admin_id' => $getAdminId['uid'],
	            'username' => $getAdminId['uname'],
	            'user_ipaddress' => $user_ipaddress,
	            'user_actions' => $user_actions,
	            'module' => $module,
	            'details' => $details,
	            'status' => $status,
	            'hint' => $hint,
	            'c_date' => date('Y-m-d'),
	            'c_time' => $formatted_time, 
	        );
	        $res = $ci->db->insert('log_entry', $data);
	        // echo $ci->db->last_query(); die;
	        return true;
	    }
	}


