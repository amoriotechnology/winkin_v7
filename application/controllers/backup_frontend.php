<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->helper('common_helper');
	}


	public function index($AppointID = NULL) {

		$services = $this->Common_model->GetDatas('services', "fld_sid, fld_scate, fld_sname, fld_sduration, fld_srate, fld_stype", ['fld_sstatus' => 'Active'], "`fld_sid` DESC");
		$setting = $this->Common_model->GetDatas('settings', "fld_weekdays");

		$leaves = $this->Common_model->GetDatas('staff_attendance', "`fld_sastatus`, `fld_sadate`, `fld_satitle`", ['fld_sastatus' => 'H', 'fld_saflag' => '']);
		$leave_data = [];
		if(!empty($leaves)) {
			foreach($leaves as $value) { $leave_data[$value['fld_sadate']] = $value['fld_satitle']; }
		}
		$countrycodes = get_country_codes();

		$edit_appoint = [];
		if(!empty($AppointID)) {
			$edit_appoint = $this->Common_model->RawSQL("SELECT `A`.*, `C`.*, `AM`.*,`CP`.*, (SELECT SUM(`P`.`fld_ppaid`) FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_aid`) AS `paid`, (SELECT `P`.`fld_pbalance` FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_aid` ORDER BY `P`.`fld_pdate` DESC LIMIT 1) AS `balance` FROM `appointments` `A` JOIN `customers` `C` ON `A`.`fld_acustid` = `C`.`fld_id` JOIN `coupons` `CP` ON `CP`.`fld_cpid` = `A`.`fld_acpid` JOIN `appointment_meta` `AM` ON `AM`.`fld_amappid` = `A`.`fld_aid` WHERE md5(`fld_appointid`) = '".$AppointID."' ORDER BY `fld_aid` DESC ");
		}

		$data = [
			'cust_info' => checkCustLogin(),
			'cmpy_info' => getSettingData(),
			'content' => 'frontpanel/index',
			'serv_data' => $services,
			'setting_data' => $setting,
			'leave_data' => $leave_data,
			'countrycodes' => $countrycodes,
			'edit_appoint' => mergeCustAppointment($edit_appoint),
		];

		$this->load->view('front_template', $data);
	}

	/* --------- customer bookings -------- */
	public function mybookings() {
		$data = [
			'cust_info' => checkCustLogin(),
			'cmpy_info' => getSettingData(),
			'content' => 'frontpanel/mybookings',
		];
		$this->load->view('front_template', $data);
	}

	/* --------- customer Profile -------- */
	public function myprofile() {

		$info = checkCustLogin();
		$countrycodes = get_country_codes();
		$getuser = $this->Common_model->get_row('customers',array('fld_id'=>$info['cust_id']));
		$getuser['fld_dob'] = formatDateToCustom($getuser['fld_dob']);
		
		if($getuser['fld_anniversary'] != "" && $getuser['fld_anniversary'] != "0000-00-00"){   
			$getuser['fld_anniversary'] = formatDateToCustom($getuser['fld_anniversary']);
		}
		
		$data = [
			'cust_info' => $info,
			'cmpy_info' => getSettingData(),
			'content' => 'frontpanel/myprofile',
			'user' => $getuser,
			'name' => $getuser['fld_name'],
			'countrycodes' => $countrycodes,
		];

		$this->load->view('front_template', $data);
	}
    
    /* --------- customer Profile Update -------- */
	public function profile_update() 
	{
	    $post = $this->input->post();
	    $info = checkCustLogin();

	    $timestamp_dob  = DateTime::createFromFormat('M d/Y', $post['dob']);
	    $post['dob'] = $timestamp_dob->format('Y-m-d');

	    if($post['anni_date'] != ''){
	    	$timestamp_anniversary  = DateTime::createFromFormat('M d/Y', $post['anni_date']);
	    	$post['anni_date'] = $timestamp_anniversary->format('Y-m-d');
	    }
	    
		$encrypted_password = $this->encryption->encrypt($post['password']);

		
	    if ($this->input->post('csrf-token') !== $this->security->get_csrf_hash()) {
	        die('CSRF Token mismatch');
	    }
        
	    $name = ucwords(htmlspecialchars($post['first_name'], ENT_QUOTES, 'UTF-8'));
	    $lname = ucwords(htmlspecialchars($post['last_name'], ENT_QUOTES, 'UTF-8'));
	    $address = htmlspecialchars($post['address'], ENT_QUOTES, 'UTF-8');
	    $contact_number = htmlspecialchars($post['contact_number'], ENT_QUOTES, 'UTF-8');
	    $cc1 = htmlspecialchars($post['countrycode'], ENT_QUOTES, 'UTF-8');
	    $cc2 = htmlspecialchars($post['countrycode2'], ENT_QUOTES, 'UTF-8');
	    $alternate_number = htmlspecialchars($post['alternateNumber'], ENT_QUOTES, 'UTF-8');
	    $email = htmlspecialchars($post['email'], ENT_QUOTES, 'UTF-8');
	    $gender = htmlspecialchars($post['gender'], ENT_QUOTES, 'UTF-8');
	    $marital_status = htmlspecialchars($post['marital_status'], ENT_QUOTES, 'UTF-8');
	    $notes = htmlspecialchars($post['notes'], ENT_QUOTES, 'UTF-8');
	   
	    $values = [
	        'fld_name' => $name,
	        'fld_lastname' => $lname,
	        'fld_address' => $address,
	        'fld_phone' => $contact_number,
	        'fld_phone_cc' => $cc1,
	        'fld_alternatephone' => $alternate_number,
	        'fld_alternatecc' => $cc2,
	        'fld_email' => $email,
	        'fld_gender' => $gender, 
	        'fld_dob' => $post['dob'],
	        'fld_maritial_sts' => $marital_status, 
	        'fld_anniversary' => $post['anni_date'],
	        'fld_notes' => $notes
	    ];
	    $result = $this->Common_model->update('customers', $values,array('fld_id'=>$info['cust_id']));
	    echo json_encode([
	        'status' => $result ? 1 : 0
	    ]);
	    exit;
	}

	public function getcustbookingsDatas() 
	{   
		$info = checkCustLogin();
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $total = $this->Common_model->GetDatas('appointments', "DISTINCT(`fld_appointid`)", ['fld_acustid' => $info['cust_id']]);
        $totalItems = count($total);
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

        $result = $this->Common_model->getAppointment( $table1, $table2, $table3, $table4, $table5, $table1cond, $table2cond, $table3cond, $table4cond, $select, $orderField . ' ' . $orderDirection, $limit, $start, $search, ['fld_acustid' => $info['cust_id']] );

        $items = mergeCustAppointment($result);
        $data           = [];
        $i              = $start + 1;
        foreach ($items as $item) { 
        	$action = '<div class="dropdown ms-2">
		                <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		                    <i class="ti ti-dots-vertical"></i>
		                </button>
		                <ul class="dropdown-menu">';
            // Conditional logic for the "Reschedule" button
            if (strtotime(CURDATE) <= strtotime($item['app_date']) && $item['app_sts'] == "Confirm" ) {
                $action .= '<li><a class="dropdown-item" href="' . base_url('index/' . md5($item['app_id'])) . '">Reschedule</a></li>';
            }
			$action .= '<li>';
							if (strtotime(CURDATE) <= strtotime($item['app_date']) && ($item['app_sts'] != "Completed" && $item['app_sts'] != "Cancelled" )) {
		                    	$action .= '<a class="dropdown-item cancel-confirm" data-id="' . md5($item['app_aid']) . '">Cancel</a>';
		                    }
			$action .= '</li>
		                </ul>
		            </div>'; 
            $data[] = [
	                "fld_aid"   => $i,
	                "fld_appointid" => $item['app_id'],
	                "fld_adate" 	=> showDate($item['app_date']) .'<br/> <b><span class="badge bg-info" >'. str_replace([', '], " </span><br> <span class='badge bg-info' >", BookingTime($item['app_time'])).'</span></b>',
	                "fld_aserv" 	=> $item['app_serv'],
	                "fld_apaymode"   => $item['app_paymode'],
	                "fld_arate"    	=> '₹'.($item['app_rate'] + $item['fld_gst_amt'] + $item['fld_pay_charge']),
	                "paid"    	    => '₹'.$item['app_paid'],
	                "fld_abalance"   => '₹'.($item['app_balance'] + $item['fld_gst_amt'] + $item['fld_pay_charge']),
	                "fld_astatus" 	=> '<span class="badge bg-'.Bgcolors($item['app_sts']).'">'. $item['app_sts'] .'</span>',
	                'action' 	=> $action,
	            ];
            $i++;
        }
        $response = [
            "draw"            => $this->input->post('draw', TRUE),
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }

	/* --------- Get stylist list when choose service(s) -------- */
	public function getStylists() {

		$servs = $this->input->post('servs', TRUE);

		$results = $this->Common_model->getLikeDatas('users', '*', ['fld_uroles' => 2, 'fld_ustatus' => 'Active'], ['fld_uservices' => $servs]);

		$response = '<div class="col-xl-10">
						<div class="card custom-card text-center">
						<div class="card-header border-bottom-0 pb-0"></div>
							<div class="card-body pt-1">
								<span class="avatar avatar-xl avatar-rounded me-2 mb-3 text-dark border">
			                        <i class="bi bi-person-fill"></i>
			                    </span>
								<h6> Currently, there are no stylists available for this service(s) </h6>
							</div>
						</div>
					</div>';

		if(!empty($results)) {
			$response = "";
			foreach ($results as $key => $res) {
				$expe = explode(", ", $res['fld_uexperience']);
			    $response .= '<div class="col-xl-3">
			        <div class="card custom-card text-center">
			            <label for="staffCheck'.$key.'">
			                <div class="card-header border-bottom-0 pb-0">
			                    <span class="ms-auto shadow-lg fs-17">
			                        <input type="checkbox" name="stylist[]" class="form-check-input rounded-circle h5 form-checked-success" id="staffCheck'.$key.'" value="'.$res['fld_uid'].'" >
			                    </span>
			                </div>
			                <div class="card-body pt-1">
			                    <span class="avatar avatar-xl avatar-rounded me-2 mb-3 text-dark border">
			                        <img src="'.base_url('/assets/images/user.jpg').'" alt="img">
			                    </span>
			                    <div class="fw-medium fs-16 mb-1">'.strtoupper($res['fld_uname']).'</div>
			                    <p class="mb-4 text-muted fs-11">
			                        <i class="bi bi-'.(($res['fld_ugender'] == "Male") ? "gender-male" : "gender-female").'"></i>&nbsp;
			                        '.$res['fld_ugender'].'<br>' . $expe[0].' Year(s), '.$expe[1].' Month(s)
			                    </p>
			                    <div class="btn-list mb-1">
			                        <p class="text-justify"> <span class="badge bg-primary"> '. str_replace([','], '</span> <span class="badge bg-primary mt-2">', $res['fld_uservices']) .' </span> </p>
			                    </div>
			                </div>
			            </label>
			        </div>
			    </div>';
			}
		}
		echo $response;
		exit;
	}


	/* ----------- get timing based on court choose ------------ */
	public function getCourtTiming() {
		$appkey = $this->input->post('appkey', TRUE);
		$court = $this->input->post('court', TRUE);
		$apptime = $this->input->post('apptime', TRUE);
		$date = (!empty($this->input->post('date', TRUE))) ? $this->input->post('date', TRUE) : date('Y-m-d');

		$gethour = $this->Common_model->GetDatas('settings', '`fld_hours`, `fld_weekdays`');
		$start_time = strtotime('08:00'); $end_time = strtotime('19:00');
		if(!empty($gethour)) {
			$times = explode(" - ", $gethour[0]['fld_hours']);
			$start_time = strtotime($times[0]); $end_time = strtotime($times[1]);
		}

		/* ----- For get for holidate date restrict ----- */
		$attendance = $this->Common_model->GetDatas("staff_attendance", "`fld_sastatus`, `fld_sadate`", ['fld_sastatus' => 'H', 'fld_sadate' => $date, "fld_saflag" => ''] );
		$atte_data = [0 => ['fld_sadate' => '']];
		if(!empty($attendance)) {
			$atte_data = $attendance;
		}

		/* ----- For get booked time of the selected date ----- */
		$appoint_times = $this->Common_model->GetJoinDatas("appointments A", "appointment_meta AM", "`A`.`fld_aid`=`AM`.`fld_amappid`", "`fld_adate`, `fld_amserv_name`, `fld_amstaff_time`, `fld_aduring`, `fld_amserv_dura`", "`fld_amserv_name` IN ('".$court."') AND `fld_adate` = '".$date."' AND `fld_astatus` != 'Cancelled'" );

		$book_time = $this->Common_model->GetJoinDatas("appointments A", "appointment_meta AM", "`A`.`fld_aid`=`AM`.`fld_amappid`", "`fld_adate`, `fld_amserv_name`, `fld_amstaff_time`, `fld_aduring`, `fld_amserv_dura`", "`fld_amserv_name` IN ('".$court."') AND `fld_adate` = '".$date."' AND `fld_aid` = '".$appkey."' AND `fld_astatus` != 'Cancelled'" );
		$booked_time = [];
		if(!empty($book_time)) {
			foreach($book_time as $value) {
				$booked_time[$court][date("h:i A", strtotime($value['fld_amstaff_time']))] = date("H:i", strtotime($value['fld_amstaff_time']));
			}
		}

		$blockdata = [];
		$prev_id = '';
		foreach($appoint_times as $key => $val) {
			
			if($val['fld_amserv_name'] != $prev_id) { 
				$dura = 0; 
				$dura += (int)$val['fld_amserv_dura'];
			}
			$times = date('h:i A', strtotime($val['fld_amstaff_time']));
			$blockdata[$val['fld_amserv_name']][$times] = ['astart' => date('H:i', strtotime($val['fld_amstaff_time'])), 'aend' => date('H:i', strtotime($val['fld_amstaff_time'].' +'.$dura.' minutes')) ];

			$prev_id = $val['fld_amserv_name'];
		}

		$cur_time = strtotime(date('H:i', strtotime('+1 hour'))); /* add 1 hour from current time for not booking current hour*/
        $cur_date = date('Y-m-d');

		$response = "";
		for($i = 0; $i < 1; $i++) {

			$response .= '<div class="col-xl-12">
                            <div class="card custom-card border-light">
                                <div class="card-header">
                                    <div class="d-flex align-items-center w-100">
                                        <div class="me-2">
                                        </div>
                                        <div class="col-10">
                                            <div class="fs-15 fw-medium"> <b>Area:</b> '.$court.'<br> <b>Date:</b> <span class="show_date">'.showDate($date).'</span> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                <div class="card-body">
                                	<div class="row h-100">
                                		<div class="table-responsive">
	                                    	<table class="table">';
                            	$n = 0;
                            	$st_time = $start_time;
                            	$week_day = date('D', strtotime($date));

                            	if(($atte_data[0]['fld_sadate'] != $date) && in_array($week_day, json_decode($gethour[0]['fld_weekdays']), TRUE) ) {

                            		$rows = 0;

                                	while ($st_time <= $end_time) {

									    $looptime = date('H:i', $st_time);
									    $time_stru = date('h:i A', $st_time);
									    
								    	// $response .= '<div class="col-4 col-sm-1 col-xl-1 p-1">';
								    	if($rows == 0) {$response .= '<tr>';}

								    	$prevtime = (isset($booked_time[$court][$time_stru]) ? $booked_time[$court][$time_stru] : "");

								    	$blockstart = (isset($blockdata[$court][$time_stru]) ? $blockdata[$court][$time_stru]['astart'] : "");
								    	$blockend = (isset($blockdata[$court][$time_stru]) ? $blockdata[$court][$time_stru]['aend'] : "");

								    	$apptime = (!empty($blockstart)) ? date("H:i", strtotime($blockstart)) : $prevtime;

								    	if(($prevtime != $looptime) && (($cur_date == $date && $cur_time > $st_time) || ($looptime >= $blockstart && $looptime <= $blockend)) ) {
								    		$response .= '<td><label class="text-dark" for="tcheck'.$i.$n.'">
		                                            <div class="cal-disabled align-items-center '.($apptime == $looptime ? '' : '').'  text-dark" >
		                                                <div class="input-group">
		                                                    <small>
		                                                    	 <small> <b> '.showTime($looptime).'</b> </small>
		                                                    </small>
		                                                </div>
		                                            </div>
	                                            </label></td>'; 

								    	} elseif($prevtime == $looptime) {

								    		$response .= '<td><label class="text-dark" for="tcheck'.$i.$n.'">
		                                            <div class="align-items-center '.($apptime == $looptime ? '' : '').'  text-dark" >
		                                                <div class="input-group">
		                                                    <small>
		                                                    	 <small> <b> '.showTime($looptime).'</b> </small>
		                                                    </small>
		                                                    <input type="checkbox" name="times[]" class="d-none form-check-input rounded-circle form-checked-success" '.($apptime == $looptime ? 'checked' : '').' value="'.showTime($looptime).'" id="tcheck'.$i.$n.'">
		                                                </div>
		                                            </div>
	                                            </label></td>';

								    	} else { 

									    	$response .= '<td class="time-btn'.$i.'"><label class="text-dark" for="tcheck'.$i.$n.'">
		                                            <div class=" align-items-center '.($apptime == $looptime ? '' : '').'  text-dark" >
		                                                <div class="input-group">
		                                                    <small>
		                                                    	 <small> <b> '.showTime($looptime).'</b> </small>
		                                                    </small>
		                                                    &nbsp;
		                                                    <input type="checkbox" name="times[]" class="d-none form-check-input rounded-circle form-checked-success" '.($apptime == $looptime ? 'checked' : '').' value="'.showTime($looptime).'" id="tcheck'.$i.$n.'">
		                                                </div>
		                                            </div>
	                                            </label></td>';
                                        }
                                        $response .= '</div>';

									    $st_time = strtotime('+30 minutes', $st_time);
									    $n++; $rows++;
									    if($rows == 10) { $rows = 0; }
										if($rows == 0) { $response .= "<tr>"; }
									}
								} else {
									$response .= '<p class="text-center">The court is unavailable on the selected date.</p>';
								}
                                
            $response .=		'</div></div>
            						</table>
	                 			</div>
                            </div>
                        </div>
                    </div>';
        }

		echo $response;
		exit;
	}


	public function add_cust_booking() {

		$appid = $this->input->post('app_id', TRUE);
		
		/* customer detail */
		$custname 	= trim($this->input->post('cust_name', TRUE));
		$custlname 	= trim($this->input->post('cust_lname', TRUE));
		$custphone 	= trim($this->input->post('cust_phone', TRUE));
		$altcustphone 	= trim($this->input->post('alt_cust_phone', TRUE));
		$custemail 	= trim($this->input->post('cust_email', TRUE));
		$custpwd    = $this->encryption->encrypt(trim($this->input->post('cust_pwd', TRUE)));
		$custdob 	= trim($this->input->post('cust_dob', TRUE));
		$custgender = trim($this->input->post('cust_gender', TRUE));
		$mari_sts 	= trim($this->input->post('mari_sts', TRUE));
		$anni_date 	= trim($this->input->post('anni_date', TRUE));
		$custaddr 	= trim($this->input->post('cust_addr', TRUE));
		$custpref 	= trim($this->input->post('cust_pref', TRUE));

		/* sign-in detail */
		$signin_phone = trim($this->input->post('signin_phone', TRUE));
		$pwd = trim($this->input->post('signin-password', TRUE));

		/* court detail*/
		$court 		= $this->input->post('court', TRUE);
		$court_rate = $this->input->post('court_rate', TRUE);
		$court_dura = $this->input->post('court_dura', TRUE);
		$court_date = $this->input->post('court_date', TRUE);
		$timings 	= $this->input->post('times', TRUE);
		$serv_notes = $this->input->post('serv_notes', TRUE);

		/* Coupon detail*/
		$coupon_id = $this->input->post('fld_acpid', TRUE);
		$coupon_percent = $this->input->post('fld_acppercent', TRUE);
		$coupon_amount = $this->input->post('fld_acpamt', TRUE);

		$gst_amount = $this->input->post('gst_amount', TRUE);
		$payment_amount = $this->input->post('payment_amount', TRUE);

		/* payment detail*/
		// $paymode 	= $this->input->post('paymethode', TRUE);
		$paymode 	= 'Online';
		$amount 	= 0;
		$cotp 		= '';

		$history = $paymode;

		if (!empty($appid)) {

			$this->Common_model->UpdateData('customers', [
				'fld_name' => $custname,
				'fld_lastname' => $custlname,
				'fld_email' => $custemail,
				'fld_gender' => $custgender,
				'fld_dob' => struDate($custdob),
				'fld_maritial_sts' => $mari_sts,
				'fld_anniversary' => struDate($anni_date),
				'fld_address' => $custaddr,
				'fld_notes' => $custpref,
			], ["fld_phone" => $custphone]);

			$cust_lastid = $this->input->post('cust_id', TRUE);

			$past_bal = $this->Common_model->GetDatas('payments', 'fld_pbalance, fld_ppaid, fld_phistory', ['fld_appid' => $appid], "`fld_pid` DESC");
			$balance = 0;
			
			if(!empty($past_bal)) {
				$paid = (float)$past_bal[0]['fld_ppaid'];
				$history = json_decode($past_bal[0]['fld_phistory']).$paymode;
			}

			$metavalue = [];
			$duration = $rate = 0;
			for($u = 0; $u < count($timings); $u++) {

				$duration += (float)$court_dura[$court];
				$rate += (float)$court_rate[$court];
				
				$metavalue[$u] = [
					'fld_amappid' => $appid,
					'fld_amstaff_time' => $timings[$u],
					'fld_amsid' => $serv_id[$u],
					'fld_amserv_name' => $court,
					'fld_amserv_dura' => $court_dura[$court],
					'fld_amserv_rate' => $court_rate[$court],
					'fld_amstatus' => 'Active',
				];
			}
			$discount = ($rate * ((float)$coupon_percent / 100) );
			$balance = (($rate - $discount) - ((float)$amount + $paid));

			$updatedata = [
					'fld_adate' => $court_date,
					'fld_atime' => json_encode($timings),
					'fld_acustid' => $cust_lastid,
					'fld_aserv' => $court,
					'fld_aduring' => $duration,
					'fld_arate' => $rate,
					'fld_apaymode' => $paymode,
					'fld_abalance' => $balance,
					'fld_anotes' => $serv_notes,
					'fld_acpid' => $coupon_id,
					'fld_acppercent' => $coupon_percent,
					'fld_acpamt' => $coupon_amount,
					'fld_gst_amt' => $gst_amount,
					'fld_pay_charge' => $payment_amount,
				];
			$this->Common_model->UpdateData('appointments', $updatedata, ['fld_aid' => $appid]);
			$this->Common_model->DeleteData('appointment_meta', ['fld_amappid' => $appid]);
			$result  = $this->Common_model->InsertBatchData('appointment_meta', $metavalue);
			$this->Common_model->UpdateData('payments', ['fld_prate' => $rate, 'fld_ppaid' => ($amount + $gst_amount + $payment_amount), 'fld_pbalance' => $balance, 'fld_phistory' => json_encode($history)], ['fld_appid' => $appid]);

		} else {

			$checkphone = (!empty($signin_phone)) ? $signin_phone : $custphone;
			$check = ExistorNot('customers', ['fld_phone' => $checkphone]);
			

			$cust_rec = $this->Common_model->GetDatas('customers', 'fld_id, fld_custid', ['fld_status' => 'Active'], "`fld_id` DESC");
			$appoint_rec = $this->Common_model->GetDatas('appointments', 'fld_aid, fld_appointid', ['fld_aid !=' => ''], "`fld_aid` DESC");

			$CustID = 'ABC1000';
			if(!empty($cust_rec)) {
				$CustID = 'ABC'.((float)substr($cust_rec[0]['fld_custid'], 3) + 1);
			}

			$AppointID = 'ABA1000';
			if(!empty($appoint_rec)) {
				$AppointID = 'ABA'.((float)substr($appoint_rec[0]['fld_appointid'], 3) + 1);
			}

			if(empty($check)) {
				$cust_lastid = $this->Common_model->InsertData('customers', [
					'fld_custid' => $CustID,
					'fld_name' => $custname,
					'fld_lastname' => $custlname,
					'fld_phone' => $custphone,
					'fld_alternatephone' => $altcustphone,
					'fld_email' => $custemail,
					'fld_pass' => $custpwd,
					'fld_gender' => $custgender,
					'fld_dob' => struDate($custdob),
					'fld_maritial_sts' => $mari_sts,
					'fld_anniversary' => struDate($anni_date),
					'fld_address' => $custaddr,
					'fld_notes' => $custpref,
					'fld_type' => 'Online',
					'fld_otp' => $cotp,
				]);
			} else {
				$CustID = $check[0]['fld_custid'];
				$cust_lastid = $check[0]['fld_id'];
			}

			$newduration = $newrate = 0;
			for($n = 0; $n < count($timings); $n++) {
				/* --- For Appointment --- */
				$newduration += (float)$court_dura[$court];
				$newrate += (float)$court_rate[$court];
			}
			$discount = ($newrate * ((float)$coupon_percent / 100) );
			$newbalance = (($newrate - $discount) - (float)$amount);

			$new_app_data = [
					'fld_appointid ' => $AppointID,
					'fld_adate' => $court_date,
					'fld_atime' => json_encode($timings),
					'fld_acustid' => $cust_lastid,
					'fld_aserv' => $court,
					'fld_aduring' => $newduration,
					'fld_arate' => $newrate,
					'fld_astatus' => 'Confirm',
					'fld_apaymode' => $paymode,
					'fld_apaystatus' => '',
					'fld_anotes' => $serv_notes,
					'fld_abalance' => $newbalance,
					'fld_acpid' => $coupon_id,
					'fld_acppercent' => $coupon_percent,
					'fld_acpamt' => $coupon_amount,
					'fld_gst_amt' => $gst_amount,
					'fld_pay_charge' => $payment_amount,
				];

			$app_lastid  = $this->Common_model->InsertData('appointments', $new_app_data);

			for($a = 0; $a < count($timings); $a++) {
				
				/* --- For Appointment Meta --- */
				$new_meta_data[$a] = [
					'fld_amappid ' => $app_lastid,
					'fld_amstaff_time' => $timings[$a],
					'fld_amserv_name' => $court,
					'fld_amserv_dura' => $court_dura[$court],
					'fld_amserv_rate' => $court_rate[$court],
					'fld_amstatus' => 'Active',
				];
			}

			$result = $this->Common_model->InsertBatchData('appointment_meta', $new_meta_data);
			$this->Common_model->InsertData('payments', [ 'fld_appid' => $app_lastid, 'fld_prate' => ($newrate + $gst_amount + $payment_amount), 'fld_ppaid' => $amount, 'fld_pbalance' => $newbalance, 'fld_phistory' => json_encode($history)]);

			$prev_used_cnt = $this->Common_model->GetDatas('coupons', 'fld_cpused', ['fld_cpid' => $coupon_id]);
			$cp_cnt = 1;
			if(!empty($prev_used_cnt)) {
				$cp_cnt = ((int)$prev_used_cnt[0]['fld_cpused'] + 1);
			}
			$this->Common_model->UpdateData('coupons', ['fld_cpused' => $cp_cnt], ['fld_cpid' => $coupon_id]);

			// Sending Email
			$tomail = (!empty($check)) ? $check[0]['fld_email'] : $custemail;
			$name = (!empty($check)) ? $check[0]['fld_name'] : $custname;
            $subject = '🎉 Your Booking is Confirmed! Thank You for Booking with Us! 🎉';
            $tamount = $newrate - (!empty($coupon_amount) ? $coupon_amount : 0);

            $bookingtemplates = BookingTemplate(['name' => $name, 'appoint_id' =>  $AppointID, 'court' => $court, 'date' => showDate($court_date), 'time' => $timings, 'amount' => $newrate, 'couponAmount' => $coupon_amount, 'gstAmount' => $gst_amount, 'payCharge' => $payment_amount]);

            $message = "Hello [$custname], Thank you for booking with us! Your booking has been successfully confirmed. Below are the details of your booking";

			$mail = SendEmail($tomail, "", "", $subject, $bookingtemplates);
			$this->Common_model->UpdateData('appointments', ['fld_conf_email' => $mail], ['fld_aid' => $app_lastid]);
			$this->session->set_userdata('login_cust_info', [
					'cust_id' => (empty($check) ? $cust_lastid : $check[0]['fld_id']),
					'cust_name' => (empty($check) ? $custname : $check[0]['fld_name']),
					'cust_phone' => (empty($check) ? $custphone : $check[0]['fld_phone']),
					'cust_email' => (empty($check) ? $custemail : $check[0]['fld_email']),
					'role' => 'customer'
				]);
		}

		$response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
		
		echo json_encode($response);
		exit;
	}


	/* ------------ Checking the customer is new or exists ------------- */
	public function checkExistorNot() {
		$phone = trim($this->input->post('phone', TRUE));
		$result = $this->Common_model->GetDatas('customers', '*', ['fld_phone' => $phone, 'fld_status' => 'Active']);

		$response = [];
		if(!empty($result)) {
			$response = ['custname' => $result[0]['fld_name'], 'custlname' => $result[0]['fld_lastname'], 'custphone' => $result[0]['fld_phone'], 'custemail' => $result[0]['fld_email'], 'custgen' => $result[0]['fld_gender'], 'custdob' => showDate($result[0]['fld_dob']), 'annidate' => showDate($result[0]['fld_anniversary']), 'marists' => $result[0]['fld_maritial_sts'], 'custaddr' => $result[0]['fld_address'], 'notes' => $result[0]['fld_notes']];
		}
		echo json_encode($response);
		exit;
	}

	// Get Coupons List
	public function get_coupons()
	{
	    $coupon_name = $this->input->post('coupon_amt');
	    $amount = $this->input->post('totalAmount');
	    $current_date = date('Y-m-d');
	    $response = [
	        'status' => 401,
	        'msg' => 'Coupon not successfully applied',
	        'finalamount' => $amount
	    ];

	    $coupons = $this->Common_model->get_select_records('coupons','*',['fld_cpname' => $coupon_name, 'fld_cpstatus' => 'Active', 'fld_cpflag' => 1]);

	    if (!empty($coupons)) {
	        if ($coupons[0]['fld_cp_expdate'] < $current_date) {
	            $response = [
	                'status' => 401,
	                'msg' => 'Coupon has expired',
	                'finalamount' => $amount
	            ];
	        } elseif ($coupons[0]['fld_cpused'] >= $coupons[0]['fld_cplimit']) {
	            $response = [
	                'status' => 401,
	                'msg' => 'Coupon usage limit reached',
	                'finalamount' => $amount
	            ];
	        } else {

	            $amount = is_numeric($amount) ? (float)$amount : 0;

	            $percentage = isset($coupons[0]['fld_cp_percentage']) && is_numeric($coupons[0]['fld_cp_percentage'])
	                ? (float)$coupons[0]['fld_cp_percentage']
	                : 0;

	            $percent_value = ($amount * $percentage) / 100;
	            $finalAmount = $amount - $percent_value;

	            $response = [
	                'status' => 200,
	                'msg' => 'Coupon applied successfully',
	                'coupon_id' => $coupons[0]['fld_cpid'],
	                'percentamount' => $percent_value,
	                'percent' => $percentage,
	                'finalamount' => $finalAmount
	            ];
	        }
	    } else {
	        $response = [
	            'status' => 401,
	            'msg' => 'Invalid coupon or coupon not found',
	            'finalamount' => $amount
	        ];
	    }

	    echo json_encode($response);
	    exit;
	}

	// Cancel Appointment
	public function cancel_appoint() {
		$id = trim($this->input->post('id', TRUE));
		$type = trim($this->input->post('type', TRUE));
		$this->Common_model->UpdateData('appointments', ['fld_astatus' => $type, 'fld_acancel_date' => date('Y-m-d H:i')], ["md5(`fld_aid`)" => $id]);
		$result = $this->Common_model->UpdateData('appointment_meta', ['fld_amstatus' => $type], ["md5(`fld_amappid`)" => $id]);
		$response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
		echo json_encode($response);
		exit;
	}

	// Qr Code Generator
	public function qr_generate() 
	{
        $amount = $this->input->post('amount', TRUE);
        echo GetQRCode(UPI_ID, UPI_NAME, $amount, 'Pickleball Court Booking');
    }

}