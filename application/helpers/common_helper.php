<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';
use Razorpay\Api\Api;
	
	if(!function_exists('getInstance')) { /* init getinstance */
		function getInstance() {
			$CI = & get_instance();
			return $CI;
		}
	}


	if (!function_exists('get_country_codes')) {
		function get_country_codes() {
		    getInstance()->load->model('Common_model');
		    $countrycodes = getInstance()->Common_model->get_records('countrycodes', array(), null, null, 'fld_countryname', 'ASC');
		    return $countrycodes;
		}
	}


	if (!function_exists('formatDateToCustom')) { /* Convert a date from `Y-m-d` to `Dec20/2005` format. */
	    function formatDateToCustom(string $date): string {
	        $dateTime = new DateTime($date);
	        return $dateTime->format('M j/Y');
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

	if(!function_exists('GetCustDetails')) { /* init GetCustDetails */
		function GetCustDetails($id) {
			getInstance()->load->model('Common_model');
			$result = getInstance()->Common_model->GetDatas('customers', "`fld_id` as `cust_id`, `fld_name` as `cust_name`, `fld_lastname` as `cust_lname`, `fld_phone` as `cust_phone`, `fld_email` as `cust_email`", ['fld_id' => $id]);
			$detail = [];
			if(!empty($result)) {
				foreach($result as $key => $res) {
					$detail = $res;
				}
			}
			return $detail;
		}
	}

	if(!function_exists('checkCustLogin')) { /* login check if not login redirect to login */
		function checkCustLogin() {
			getInstance()->load->library('session');
			$custdata = getInstance()->session->userdata('login_cust_info');
			return $custdata = (empty($custdata['cust_phone'])) ? [] : $custdata;
		}
	}

	if (!function_exists('ImageUpload')) {
	    function ImageUpload($imagename, $path, $width = "", $height = "") {

	        $new_name = 'blog_' . time();
	        $config['file_name'] = $new_name;
	        $config['upload_path'] = $path;
	        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
	        $config['max_size'] = 2048;
	        $config['max_width'] = $width;
	        $config['max_height'] = $height;

	        getInstance()->load->library('upload', $config);

	        if (!$CI->upload->do_upload($imagename)) {
	            $error = array('status' => 400, 'msg' => $CI->upload->display_errors('', '')); 
	            return $error;
	        } else {
	            $data = array('status' => 200, 'msg' => $CI->upload->data()); 
	            return $data;
	        }
	    }
	}

	if(!function_exists('showDate')) { /* format date for frontend view */
		function showDate($date) {
			$length = strlen($date);
			$showdate = "";
			if(!empty($date) && $date != "0000-00-00" && $date != "0000-00-00 00:00:00") {
				$format = 'd/m/Y';
				if($length > 11) { $format = 'd/m/Y - h:i A'; }
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

	if(!function_exists('TimeDuration')) { /* duration calculation */
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

	if(!function_exists('alertMsg')) { /* return alert msg color & sentence */
		function alertMsg($name) {
			$color = [
				'add_suc' => 'success',
				'add_fail' => 'danger' ,
				'login_secc' => 'success', 
				'up_suc' => 'success',
				'log_fail' => 'danger',
			];

			$word = [
				'add_suc' => 'Added Successfully!!!',
				'add_fail' => 'Added Failed!!!' ,
				'login_secc' => 'Login Successfully!!!', 
				'up_suc' => 'Updated Successfully!!!',
				'log_fail' => 'Email / Password Incorrect!',
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
			$conv = ((float)$mins / 60);
			return ($conv >= 1) ? $conv.' Hour(s)' : $conv.' Mins';
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

	if(!function_exists('mergeCustAppointment')) { /* merge appointment based on appointment ID */
		function mergeCustAppointment($records) {
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
					$rate += (float)$rec['fld_amserv_rate'];
					$serv_data[] = [$rec['fld_amserv_name'], $rec['fld_amserv_dura'], $rec['fld_amserv_rate'], $rec['fld_amstaff_time']];
					
					$appoint_rec[$rec['fld_appointid']] = [
						'app_aid' => $rec['fld_aid'],
						'book_date' => $rec['fld_booked_date'],
						'app_id' => $rec['fld_appointid'],
						'app_date' => $rec['fld_adate'],
						'app_dura' => $rec['fld_aduring'],
						'app_time' => rtrim($times, ", "),
						'app_start_time' => json_decode($rec['fld_atime']),
						'app_custid' => $rec['fld_id'],
						'app_cid' => $rec['fld_id'],
						'app_name' => $rec['fld_name'],
						'app_lname' => $rec['fld_lastname'],
						'app_phone' => $rec['fld_phone'],
						'app_email' => $rec['fld_email'],
						'app_serv' => $rec['fld_amserv_name'],
						'fld_gst_amt' => $rec['fld_gst_amt'],
						'fld_pay_charge' => $rec['fld_pay_charge'],
						'app_rate' => $rate,
						'app_sts' => $rec['fld_astatus'],
						'app_paymode' => $rec['fld_apaymode'],
						'app_paid' => (float)$rec['paid'],
						'app_balance' => (float)$rec['fld_abalance'],
						'app_paysts' => $rec['fld_apaystatus'],
						'cgen' => $rec['fld_gender'],
						'cdob' => $rec['fld_dob'],
						'mari_sts' => $rec['fld_maritial_sts'],
						'canniversary' => $rec['fld_anniversary'],
						'caddr' => $rec['fld_address'],
						'app_amount' => 0,
						'app_note' => $rec['fld_anotes'],
						'cnote' => $rec['fld_notes'],
						'coup_id' => $rec['fld_acpid'],
						'coup_name' => $rec['fld_cpname'],
						'coup_prec' => $rec['fld_acppercent'],
						'coup_amt' => $rec['fld_acpamt'],
						'serv_data' => $serv_data
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
			$wishes_record = getInstance()->Common_model->GetDatas('customers', "`fld_name`, `fld_phone`, `fld_email`, DATE_FORMAT(`fld_dob`, '%m-%d') as `fld_dob`, `fld_dob` as `bday`, DATE_FORMAT(`fld_anniversary`, '%m-%d') as `fld_anniversary`, `fld_anniversary` as `aday`", "(DATE_FORMAT(`fld_dob`, '%m-%d') = '".$wishdate."') OR ( DATE_FORMAT(`fld_anniversary`, '%m-%d') = '".$wishdate."')");

			$wish_data = [];
			if(!empty($wishes_record)) {
				foreach($wishes_record as $wish) {

					if($wish['fld_dob'] == $wishdate) { 
						$wish_data['birth_days'][] = ['name' => $wish['fld_name'], 'phone' => $wish['fld_phone'], 'email' => $wish['fld_email'], 'day' => $wish['bday']]; 
					}
					if($wish['fld_anniversary'] == $wishdate) { 
						$wish_data['anni_days'][] = ['name' => $wish['fld_name'], 'phone' => $wish['fld_phone'], 'email' => $wish['fld_email'], 'day' => $wish['aday']]; 
					}
				}
			}
			return $wish_data;
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
								                      <td align="center" style="border:1px solid #A20C25; border-radius: 15px; padding:35px 20px">
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
                                                                <td style="font-family:Poppins,Arial,sans-serif; font-size:20px; text-align:center; background-color: #fff;">
                                                                  <p style="margin:0; color:#000; font-weight:600">
                                                                    Your OTP for password reset is: <strong>'.$data['wish_msg'].'</strong>
                                                                  </p>
                                                                  <p style="margin:10px 0; color:#000; font-size:16px;">
                                                                    Please use this One-Time Password (OTP) to reset your password. 
                                                                    Do not share this code with anyone for security reasons.
                                                                  </p>
                                                                </td>
                                                              </tr>';
									                    }
								            $template .= '</table>
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
	        getInstance()->email->cc($cc); 
	        getInstance()->email->bcc($bcc);
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

	if(!function_exists('BookingTemplate')) { 
		function BookingTemplate($data) {
			$template = "";
			if(!empty($data)) {
				$amount = (float)$data['amount'] - ((isset($data['couponAmount']) && !empty($data['couponAmount'])) ? (float)$data['couponAmount'] : 0);

				$gettime= implode(', ',$data['time']);
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
								        color: #fff !important;
								      }

								      .text-center {
								        width: 100%;
								        text-align: center !important;
								      }
								    </style>
								  </head>

								  <body style="background-color: #F2F2F2;">

								    <center>
								      <div style="max-width: 680px; margin: 0 auto;" class="email-container">
								    
								          <div class="content bg-primary">
								              <table class="width: 100%">';
													if ($data['payment_method'] !== '') {
														$template .=  '<tr> <th> Payment successfully processed on '.showDate(CURDATE).' </th> </tr>';
													} else {
														$template .=  '<tr> <th> Payment is Pending </th> </tr>';
													}
													$template .=  '<tr> <th> <h2> ₹'.round($amount, 2).'</th> </tr> </h2>
												</table>
								          </div>';
										  if ($data['payment_method'] !== '') {
											$template .=  '<p> Your payment against WINKIN for ₹'.round($amount, 2).' is successful.</p>';
										 } else {
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

								        $template .= '<p> Track all your booking details easily through your <a href="https://winkin.in">Winkin My Bookings page</a>.</p>
							  			  			  <p> PFA(Please Find Attachment).</p>

								          <div class="container"> <p class="text-center"> Copyright © 2025. All rights reserved.</p> </div>
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
				case 'Completed':
					$color = 'success';
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

	// Qr code Generate
	if(!function_exists('GetQRCode')) { /* get qr code for online transaction */
		function GetQRCode($upi_code, $upi_name, $amt, $notes) {
		    
			getInstance()->load->library('QRCode');
			
			$upi_id = $upi_code;
	        $name 	= $upi_name;
	        $amount = $amt;
	        $note 	= $notes;
	        
	        $upi_url = "upi://pay?pa={$upi_id}&pn={$name}&am={$amount}&cu=INR&tn={$note}";
	        // $file_path = base_url('../assets/uploads/upi_qr_code.JPEG');
	        
	        $qr_code = QRcode::getMinimumQRCode($upi_url, QR_ERROR_CORRECT_LEVEL_L);
			return $qr_code->printHTML("8px");
		}
	}

	if(!function_exists('payNow')) {
		function payNow($data) {

	//	 $rate = isset($data['amount']) ? (float)$data['amount'] : 0;
	//	 $rate = isset($data['amount']) ? round((float)$data['amount'], 2) : 0;
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
		        $payment_mode = $payment['method'];

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



