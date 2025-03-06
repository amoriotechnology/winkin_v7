<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once '../vendor/autoload.php';
use Dompdf\Dompdf;

class Backend extends CI_Controller {

    public $load, $session, $input;
    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->helper('common_helper');
        $this->load->library('encryption');

        $dayopens = $this->Common_model->GetDatas('appointments', 'SUM(fld_arate) AS total_amount', [
            "fld_adate"    => date('Y-m-d', strtotime('-1 day')),
            "fld_apaymode" => 'cash',
        ]);

        $checkdaycloseStatus = $this->Common_model->check_dayclose_status();

        if (isset($checkdaycloseStatus[0]) && $checkdaycloseStatus[0]['status'] == 1) {
            $daycloses = [];
        } else {
            $daycloses = $this->Common_model->getPaymentsSummary();
        }

        $day_report = [
            'dayOpen'    => $dayopens,
            'daycloses'  => $daycloses,
            'day_status' => ((isset($checkdaycloseStatus[0])) ? $checkdaycloseStatus[0]['status'] : ""),
        ];

        $this->load->vars(['day_report' => $day_report]);
    }

    public function index() {

        $start      = date('Y-m-01');
        $end        = date('Y-m-31');
        $today      = date('Y-m-d');
        $year_month = date('Y-m');

                /* Get current month appointment count */
        $mon_appoi_cnt = $this->Common_model->RawSQL(" SELECT COUNT(DISTINCT `fld_appointid`) AS mon_appoint_cnt FROM `appointments` WHERE DATE_FORMAT(`fld_adate`, '%Y-%m') = '$year_month'  AND `fld_astatus` != 'Cancelled'  AND `fld_astatus` != 'Pending' AND `fld_atype` IS NULL");

        /* Get today appointment count */
        $today_appoi_cnt = $this->Common_model->RawSQL(" SELECT COUNT(DISTINCT `fld_appointid`) AS today_appoint_cnt FROM `appointments` WHERE `fld_adate` = '$today' AND `fld_astatus` != 'Cancelled'  AND `fld_astatus` != 'Pending' AND `fld_atype` IS NULL ");

        /* Get till the date of appointment count */
        $till_appoi_cnt = $this->Common_model->RawSQL("SELECT COUNT(DISTINCT `fld_appointid`) as till_appoint_cnt FROM `appointments` WHERE `fld_adate` <= '$today' AND `fld_atype` IS NULL");

        /* get today revenue value */
        $today_sales = $this->Common_model->RawSQL("SELECT SUM(p.fld_prate) AS today_paid FROM payments p JOIN appointments a ON p.fld_appid = a.fld_aid WHERE p.fld_pdate BETWEEN '" . $today . " 00:00:00' AND '" . $today . " 23:59:59' AND a.fld_astatus != 'Cancelled' AND a.fld_astatus != 'Pending'");

        /* get this monthly revenue value */
        $monthly_sales = $this->Common_model->RawSQL("SELECT SUM(p.fld_prate) AS monthly_paid FROM payments p JOIN appointments a ON p.fld_appid = a.fld_aid WHERE DATE_FORMAT(`fld_pdate`, '%Y-%m') = '" . $year_month . "' AND a.fld_astatus != 'Cancelled' AND a.fld_astatus != 'Pending'");

        /* get till date revenue value */
        $till_sales = $this->Common_model->RawSQL("SELECT SUM(`fld_prate`) as `till_paid` FROM `payments` WHERE `fld_pdate` <= '" . $today . "' ");

        $cust_cnt = $this->Common_model->getCount('customers', ['fld_status' => 'Active']);

        $staff_cnt = $this->Common_model->getCount('users', ['fld_ustatus' => 'Active', 'fld_uroles' => 2]);

        $today_present = $this->Common_model->getCount('staff_attendance', ['fld_sadate' => $today, 'fld_sastatus' => 'P']);

        /*Booking Data passing in charts */
        $bookingData = $this->Common_model->getBookingData();
        if (empty($bookingData)) {$bookingData = [];}

        $bookingCount = $this->Common_model->totalBookingCount() ?: 0;

        /*Revenue Data passing in charts */
        $revenueData = $this->Common_model->GetJoinDatas('appointments A', 'payments P', "A.fld_aid = P.fld_appid", "DATE_FORMAT(A.fld_booked_date, '%Y-%m') AS month, SUM(P.fld_prate) AS total_revenue", ["YEAR(P.fld_pdate)" => date('Y')], "A.fld_atype IS NULL", "month", ["A.fld_astatus" => ['Pending', 'Cancelled']]);
        if (empty($revenueData)) {$revenueData = [];}

        $data = [
            'info'               => checkLogin(),
            'wishes'             => GetWishes(),
            'cmpy_info'          => getSettingData(),
            'appoint'            => 1,
            'sales'              => 1,
            'mon_appoint'        => (! empty($mon_appoi_cnt[0]['mon_appoint_cnt']) ? (int) $mon_appoi_cnt[0]['mon_appoint_cnt'] : 0),
            'today_appoint'      => (! empty($today_appoi_cnt[0]['today_appoint_cnt']) ? (int) $today_appoi_cnt[0]['today_appoint_cnt'] : 0),
            'till_appoint'       => (! empty($till_appoi_cnt[0]['till_appoint_cnt']) ? (int) $till_appoi_cnt[0]['till_appoint_cnt'] : 0),
            'monthly_sales'      => (! empty($monthly_sales[0]['monthly_paid']) ? (float) $monthly_sales[0]['monthly_paid'] : 0),
            'today_sales'        => (! empty($today_sales[0]['today_paid']) ? (float) $today_sales[0]['today_paid'] : 0),
            'till_sales'         => (! empty($till_sales[0]['till_paid']) ? (float) $till_sales[0]['till_paid'] : 0),
            'totcust'            => (float) $cust_cnt,
            'totstaff'           => (float) $staff_cnt,
            'today_present'      => $today_present,
            'bookCount'          => $bookingCount,
            'booking_chart_data' => json_encode($bookingData),
            'monthly_revenue'    => $revenueData,
            'content'            => 'backpanel/dashboard',
        ];
        $this->load->view('template', $data);
    }

    public function login() {
        if (! empty($this->session->userdata('login_info'))) {
            if ($this->session->userdata('login_info')['role'] == STAFF) {
                redirect('today_booking');
            } else {
                redirect('dashboard');
            }
        }

        $data = ['cmpy_info' => getSettingData()];
        $this->load->view('sign-in', $data);
    }

    public function login_submit() {

        $email = $this->input->post('email_id', TRUE);
        $pwd   = $this->input->post('pwd', TRUE);

        $ActiveEmail = $this->Common_model->GetDatas('users', '*', ['fld_uemail' => $email, 'fld_ustatus' => 'Active'], "'fld_uid', 'DESC'");

        $response = ['status' => 401, 'data' => ['role' => 0], 'alert_msg' => ['word' => 'Invalid Email Address']];
        if (! empty($ActiveEmail)) {
            $password = $this->encryption->decrypt($ActiveEmail[0]['fld_upass']);

            $staffAccess      = $ActiveEmail[0]['fld_access'];
            $fld_accessPoints = "";

            if (! empty($staffAccess)) {
                $accessPoints = json_decode($staffAccess, true);
                if (! empty($accessPoints) && is_array($accessPoints)) {
                    $fld_accessPoints = implode(", ", array_column($accessPoints, 'value'));
                }
            }

            $response = ['status' => 401, 'data' => ['role' => 0], 'alert_msg' => ['word' => 'Invalid Password']];
            if ($password === $pwd) {
                $this->session->set_userdata('login_info', [
                    'uid'      => $ActiveEmail[0]['fld_uid'],
                    'uname'    => $ActiveEmail[0]['fld_uname'],
                    'staff_id' => $ActiveEmail[0]['fld_staffid'],
                    'email_id' => $ActiveEmail[0]['fld_uemail'],
                    'phone_no' => $ActiveEmail[0]['fld_uphone'],
                    'role'     => $ActiveEmail[0]['fld_uroles'],
                    'access'   => $fld_accessPoints,
                ]);
                logEntry('Login', 'Login', 'Login successfully', 'Add', '');
                $this->session->set_flashdata('wishes', 'Popup');
                $response = ['status' => 200, 'data' => ['role' => $ActiveEmail[0]['fld_uroles']], 'alert_msg' => alertMsg('login_suc')];
            }
        }
        echo json_encode($response);
    }

    public function calendar() {

        $staff_id   = checkLogin()['uid'];
        $attendance = $this->Common_model->RawSQL("SELECT * FROM `staff_attendance` `SA` JOIN `users` `U` ON `SA`.`fld_sastaffid` = `U`.`fld_uid` WHERE `fld_sastaffid` = '" . $staff_id . "' AND `fld_sastatus` != 'H' AND `fld_saflag` = '' ");

        $holiday = $this->Common_model->GetDatas('staff_attendance', '*', ['fld_sastatus' => 'H', 'fld_saflag' => '']);

        $appoint = $this->Common_model->RawSQL("SELECT `A`.*, `C`.*, `U`.*, (SELECT SUM(`P`.`fld_ppaid`) FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_appointid`) AS `paid`, (SELECT `P`.`fld_pbalance` FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_appointid` ORDER BY `P`.`fld_pdate` DESC LIMIT 1) AS `balance` FROM `appointments` `A` JOIN `customers` `C` ON `A`.`fld_acustid` = `C`.`fld_id` JOIN `users` `U` ON `A`.`fld_astaffid` = `U`.`fld_uid` WHERE `fld_astaffid` = '" . $staff_id . "' ORDER BY `fld_atime` DESC");

        $data = [
            'info'           => checkLogin(),
            'wishes'         => GetWishes(),
            'cmpy_info'      => getSettingData(),
            'attend_record'  => json_encode($attendance),
            'holiday_record' => json_encode($holiday),
            'appoint_record' => json_encode(mergeAppointment($appoint)),
            'content'        => 'backpanel/calendar',
        ];
        $this->load->view('template', $data);
    }

    public function today_booking() {

        // var_dump($this->session->userdata('login_info')); exit;

        $staff_id      = checkLogin()['uid'];
        $today_appoint = $this->Common_model->RawSQL("SELECT `A`.*, `C`.*, `U`.*, (SELECT SUM(`P`.`fld_ppaid`) FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_appointid`) AS `paid`, (SELECT `P`.`fld_pbalance` FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_appointid` ORDER BY `P`.`fld_pdate` DESC LIMIT 1) AS `balance` FROM `appointments` `A` JOIN `customers` `C` ON `A`.`fld_acustid` = `C`.`fld_id` JOIN `users` `U` ON `A`.`fld_astaffid` = `U`.`fld_uid` WHERE `fld_adate` = '" . date('Y-m-d') . "' AND `fld_astaffid` = '" . $staff_id . "' ORDER BY `fld_atime` DESC");

        $data = [
            'info'          => checkLogin(),
            'wishes'        => GetWishes(),
            'cmpy_info'     => getSettingData(),
            'today_appoint' => mergeAppointment($today_appoint),
            'content'       => 'backpanel/today_booking',
        ];
        $this->load->view('template', $data);
    }

    /* --------------- insert / edit category --------------------- */
    public function add_category() {
        $cateid    = trim($this->input->post('cateid', TRUE));
        $cate_name = trim($this->input->post('cate_name', TRUE));
        $cate_type = trim($this->input->post('cate_type', TRUE));

        $values = ['fld_catename' => $cate_name, 'fld_catetype' => $cate_type];

        if (! empty($cateid)) {
            $result = $this->Common_model->UpdateData('categorys', $values, ["md5(`fld_cateid`)" => $cateid]);
        } else {
            $result = $this->Common_model->InsertData('categorys', $values);
        }

        $response = ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        if ($result > 0) {
            $response = ['status' => 200, 'alert_msg' => alertMsg('add_suc')];
        }
        echo json_encode($response);
    }

    /* --------------- insert / edit category --------------------- */
    public function add_customer() {
        $cust_id        = trim($this->input->post('cust_id', TRUE));
        $cust_name      = trim(ucfirst($this->input->post('cust_name', TRUE)));
        $cust_lname     = trim(ucfirst($this->input->post('cust_lname', TRUE)));
        $cust_phone     = trim($this->input->post('cust_phone', TRUE));
        $cust_email     = trim($this->input->post('cust_email', TRUE));
        $cust_anni_date = struDate(trim($this->input->post('cust_anni_date', TRUE)));
        $cust_mari_sts  = trim($this->input->post('cust_mari_sts', TRUE));
        $gender         = trim($this->input->post('cust_gender', TRUE));
        $cust_dob       = struDate(trim($this->input->post('cust_dob', TRUE)));
        $cust_addr      = trim($this->input->post('cust_addr', TRUE));
        $cust_notes     = trim($this->input->post('cust_notes', TRUE));

        $values = ['fld_name' => $cust_name, 'fld_lastname' => $cust_lname, 'fld_email' => $cust_email, 'fld_anniversary' => $cust_anni_date, 'fld_maritial_sts' => $cust_mari_sts, 'fld_gender' => $gender, 'fld_dob' => $cust_dob, 'fld_address' => $cust_addr, 'fld_notes' => $cust_notes, 'fld_phone' => $cust_phone];

        if (! empty($cust_id)) {
            $values = array_merge($values, ['fld_updated_date' => CURDATE]);

            $checkExistingEmail = $this->Common_model->GetDatas('customers', '`fld_email`', [
                'fld_email' => $cust_email,
                'fld_id !=' => $cust_id,
            ]);

            if (! empty($checkExistingEmail)) {
                echo json_encode(['status' => 409, 'alert_msg' => 'Email already exists!']);
                exit;
            }

            logEntry('Update Customer', 'Customer', 'Customer Update successfully', 'Update', '');

            $result = $this->Common_model->UpdateData('customers', $values, ["fld_id" => $cust_id]);
        } else {
            $checkExistingEmail = $this->Common_model->GetDatas('customers', '`fld_email`', ['fld_email' => $cust_email]);

            if (! empty($checkExistingEmail)) {
                logEntry('Customer Existing Email', 'Customer', 'Customer Email already exists', 'Fail', '');
                echo json_encode(['status' => 409, 'alert_msg' => 'Email already exists!']);
                exit;
            }

            $prev_id = $this->Common_model->PaginationData('customers', 'fld_custid', NULL, "`fld_id` DESC", 1, 0);
            $cust_id = 'WC1000';
            if (! empty($prev_id)) {
                $cust_id = 'WC' . ((float) substr($prev_id[0]['fld_custid'], 2) + 1);
            }

            $pass   = $this->encryption->encrypt('user@123');
            $values = array_merge($values, [
                'fld_custid' => $cust_id,
                'fld_phone'  => $cust_phone,
                'fld_type'   => 'Direct',
                'fld_pass'   => $pass,
            ]);

            logEntry('Add Customer', 'Customer', 'Customer Added successfully', 'Add', '');


		    $result = $this->Common_model->InsertData('customers', $values);
		}

		$response = ['status' => 401, 'alert_msg' => alertMsg('add_fail')];

		if ($result > 0) {
		    $response = ['status' => 200, 'alert_msg' => alertMsg('add_suc')];
		}

		echo json_encode($response);
	}


	/* --------------- insert / edit service ----------------- */
	public function add_service() {
		$sid 	   = trim($this->input->post('sid', TRUE));
		$cate 	   = trim($this->input->post('cate', TRUE));
		$serv_name = trim($this->input->post('serv_name', TRUE));
		$duration = trim($this->input->post('serv_duration', TRUE));
		$split_duration = explode(":", $duration);
		$serv_dura = (($split_duration[0] * 60) + $split_duration[1]);
		$serv_rate = trim($this->input->post('serv_rate', TRUE));
		$serv_type = trim($this->input->post('serv_type', TRUE));
		$serv_desc = trim($this->input->post('serv_desc', TRUE));


		$values = ['fld_scate' => $cate, 'fld_sname' => $serv_name, 'fld_sduration' => $serv_dura, 'fld_srate' => $serv_rate, 'fld_stype' => $serv_type, 'fld_sdesc' => $serv_desc];

		if(!empty($sid)) {
			$result = $this->Common_model->UpdateData('services', $values, ['fld_sid' => $sid]);
		} else {
			$result = $this->Common_model->InsertData('services', $values); 
		}

		$response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
		echo json_encode($response);
	}


	/* --------------- insert / edit staff ---------------- */
	public function add_staff() {
		$staff_id 	   		= trim($this->input->post('staff_id', TRUE));
		$staff_name  		= trim(ucfirst($this->input->post('staff_name', TRUE)));
		$staff_phone 		= trim($this->input->post('staff_phone', TRUE));
		$staff_email 		= trim($this->input->post('staff_email', TRUE));
		$staff_doj 			= struDate(trim($this->input->post('staff_doj', TRUE)));
		$staff_designation  = trim($this->input->post('staff_designation', TRUE));
		$staff_anni 		= struDate(trim($this->input->post('staff_anni', TRUE)));
		$gender 			= trim($this->input->post('gender', TRUE));
		$staff_dob 			= struDate(trim($this->input->post('staff_dob', TRUE)));
		$staff_access 		= trim($this->input->post('staff_access', TRUE));
		$staff_access       = !empty($staff_access) ? $staff_access : '{}';
		$staff_expe 		= trim($this->input->post('staff_year', TRUE)).', '.trim($this->input->post('staff_month', TRUE));
		$servs = "";

		if(!empty($staff_serv)) {
			foreach(json_decode($staff_serv) as $key => $serv) {
				$servs .= $serv->value.', ';
			}
		}
		$staff_addr 		= trim($this->input->post('staff_addr', TRUE));
		// $staff_serv = rtrim($servs, ", ");

		$values = ['fld_uname' => $staff_name, 'fld_uphone'=>$staff_phone, 'fld_uemail' => $staff_email, 'fld_udoj' => $staff_doj, 'fld_staff_designation' => $staff_designation, 'fld_uanniversary' => $staff_anni, 'fld_ugender' => $gender, 'fld_udob' => $staff_dob, 'fld_uexperience' => $staff_expe, 'fld_access' => $staff_access, 'fld_uaddress' => $staff_addr];

        
		if(!empty($staff_id)) {
			$values = array_merge($values, ['fld_uupdated_date' => CURDATE]);
			logEntry('Update Staff', 'Staff', 'Staff Update successfully', 'Update', '');
			$result = $this->Common_model->UpdateData('users', $values, ['fld_uid' => $staff_id]);
		} else {
			$prev_id = $this->Common_model->PaginationData('users', 'fld_staffid', NULL, "`fld_uid` DESC", 1, 0);
			$staff_id = 'WS1000';
			if(!empty($prev_id)) {
				$staff_id = 'WS'.((float)substr($prev_id[0]['fld_staffid'], 2) + 1);
			}

			$pass = $this->encryption->encrypt('staff@123');
			$values = array_merge($values, ['fld_staffid' => $staff_id, 'fld_uphone' => $staff_phone, 'fld_upass' => $pass, 'fld_uroles' => 2]);

			logEntry('Add Staff', 'Staff', 'Staff Added successfully', 'Add', '');
			$result = $this->Common_model->InsertData('users', $values); 
		}

		$response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
		echo json_encode($response);
	}


	/* --------------- insert / edit Maintenance ---------------- */
	public function add_maintenance()
    {
        $mnt_court     = trim($this->input->post('mnt_court', TRUE));
        $mnt_date      = date('Y-m-d', strtotime($this->input->post('mnt_date', TRUE)));
        $mnt_frm_time  = trim($this->input->post('mnt_frm_time', TRUE));
        $mnt_end_time  = trim($this->input->post('mnt_end_time', TRUE));
        $mnt_reason    = trim($this->input->post('mnt_reason', TRUE));
        $maintain_id      = $this->input->post('maintain_id', TRUE);
        $getAdminId    = $this->session->userdata('login_info');
        $startTime = new DateTime($mnt_frm_time);
        $endTime   = new DateTime($mnt_end_time);
        // Start time is greater than End time Condition
        if ($startTime >= $endTime) {
            echo json_encode([
                'status' => 400,
                'alert_msg' => 'Start time must be earlier than end time.'
            ]);
            return;
        }
        // Start Time and End time is equal Condition
        if ($startTime == $endTime) {
            echo json_encode([
                'status' => 400,
                'alert_msg' => 'Start time and end time cannot be the same.'
            ]);
            return;
        }
        $interval  = new DateInterval('PT30M');
        $timeSlots = [];
        while ($startTime <= $endTime) {
            $timeSlots[] = $startTime->format('h:i A');
            $startTime->add($interval);
        }
        $conflict = $this->Common_model->isTimeSlotBooked($mnt_court, $mnt_date, $timeSlots);
        if ($conflict) {
            echo json_encode([
                'status' => 400,
                'alert_msg' => 'Selected time slot is already booked. Please choose another time.'
            ]);
            return;
        }
        $totalMinutes = count($timeSlots) * 30;
        $values = [
            'fld_aserv'  => $mnt_court,
            'fld_adate'  => $mnt_date,
            'fld_atime'  => json_encode($timeSlots),
            'fld_acustid' => $getAdminId['uid'],
            'fld_aduring' => $totalMinutes,
            'fld_areason' => $mnt_reason,
            'fld_atype'  => 'Maintenance'
        ];
        if (!empty($maintain_id)) {
            $result = $this->Common_model->UpdateData('appointments', $values, ['md5(`fld_aid`)' => $maintain_id]);
            logEntry('Update Maintenance', 'Court Maintenance', 'Court Maintenance Update successfully', 'Update', '');
        } else {
            $prev_id = $this->Common_model->PaginationData('appointments', 'fld_appointid', ['fld_atype' => 'Maintenance'], "`fld_aid` DESC", 1, 0);
            $maintain_id = 'WM1000';
            if (!empty($prev_id) && isset($prev_id[0]['fld_appointid'])) {
                $prev_num = (int) substr($prev_id[0]['fld_appointid'], 2);
                $maintain_id = 'WM' . str_pad($prev_num + 1, 4, '0', STR_PAD_LEFT);
            }
            $values['fld_appointid'] = $maintain_id;
            $app_lastid  = $this->Common_model->InsertData('appointments', $values);
            $new_meta_data = [];
            foreach ($timeSlots as $time) {
                $new_meta_data[] = [
                    'fld_amappid'      => $app_lastid,
                    'fld_amstaff_time' => $time,
                    'fld_amserv_name'  => $mnt_court,
                    'fld_amserv_dura'  => 30,
                    'fld_amserv_rate'  => '0.00',
                    'fld_amstatus'     => 'Active',
                ];
            }
            if (!empty($new_meta_data)) {
                $result = $this->Common_model->InsertBatchData('appointment_meta', $new_meta_data);
            }
            logEntry('Add Maintenance', 'Court Maintenance', 'Court Maintenance Added successfully', 'Add', '');
        }
        $response = ($result > 0)
            ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')]
            : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        echo json_encode($response);
    }

	/* --------------- insert / edit leave ---------------- */
	public function add_leave() {

		$info = checkLogin();
		$lid = trim($this->input->post('lid', TRUE));
		$daterange = trim($this->input->post('leave_date', TRUE));
		$reason = trim($this->input->post('reason', TRUE));
		$ids = explode("|", $this->input->post('person', TRUE));
		$apply_by = $info['uid'];

		if(!empty($ids[0])) {
			$person = $ids[0];
			$staff_id = $ids[1];
			$splitdate = explode(" to ", $daterange);
		}		
		
		$return = ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
		if(!empty($lid)) {
			/* ----- Update leave status like approved and rejected ----- */
			$sts = trim($this->input->post('sts', TRUE));
			$rej_reason = "";

			$prev_data = $this->Common_model->GetDatas('leaves', '*', [ 'fld_lid' => $lid ]); /* --- get leave date using both edit and update status --- */
			$prev_daterange = $prev_data[0]['fld_ldate'];
			$split = explode(" to ", $prev_daterange);
			$prev_days = DateDiff($split[0], $split[1]);
			$prev_staff_id = $prev_data[0]['fld_lstaff_id'];


			if(!empty($sts)) {

				for($u = 0; $u <= $prev_days; $u++) {
					$update_date = date('Y-m-d', strtotime(struDate($split[0]). '+ '.$u.' day'));
					$value = ['fld_saflag' => 'disabled'];
					if($sts == 'Approved') {
						$value = ['fld_saflag' => ''];
					} else {
						$rej_reason = trim($this->input->post('rej_reason', TRUE));
					}

					$this->Common_model->UpdateData('staff_attendance', $value, ['fld_leaveid'=> $lid, 'fld_sastaffid' => $prev_staff_id, 'fld_sadate' => $update_date]);
				}

				$updatedata = ($info['role'] == STAFF) ? ['fld_req_reject' => $rej_reason] : ['fld_lstatus' => $sts, 'fld_lrej_reason' => $rej_reason];

			} else {

				/* ----- Edit leave datas ----- */
				$days = DateDiff($splitdate[0], $splitdate[1]);
				for($r = 0; $r <= $prev_days; $r++) {
					$prev_date = date('Y-m-d', strtotime(struDate($split[0]). '+ '.$r.' day'));
					$this->Common_model->DeleteData('staff_attendance', ['fld_sadate' => $prev_date, 'fld_sastaffid' => $prev_staff_id]);
				}

				for($n = 0; $n <= $days; $n++) {
					$new_date = date('Y-m-d', strtotime(struDate($splitdate[0]). '+ '.$n.' day'));
					$new_day = date('D', strtotime(struDate($splitdate[0]). '+ '.$n.' day'));

					$flag = ($info['role'] == ADMIN) ? '' : 'disabled';
					$newinsertdata[$n] = [
						'fld_sastaffid' => $staff_id,
						'fld_leaveid' => $lid,
						'fld_sadate' => $new_date,
						'fld_saday' => $new_day,
						'fld_satitle' => 'Leave',
						'fld_sastatus' => 'L',
						'fld_saflag' => $flag
					];
				}
				$this->Common_model->InsertBatchData('staff_attendance', $newinsertdata);
				$updatedata = ['fld_ldate' => $daterange, 'fld_lperson' => $person, 'fld_lstaff_id' => $staff_id, 'fld_lreason' => $reason];
			}

			$result = $this->Common_model->UpdateData('leaves', $updatedata, ['fld_lid' => $lid] );

		} else {

			$leave_check = $this->Common_model->GetDatas('staff_attendance', 'fld_sadate', ['fld_sastaffid' => $staff_id, 'fld_sadate >=' => struDate($splitdate[0]), 'fld_sadate <=' => struDate($splitdate[1]), 'fld_saflag' => '']);
			$result = 0;
			$return = ['status' => 402, 'alert_msg' => ['word' => 'This staff have the leave date, Kindly apply other date(s)!!!']];

			/* ----- Prevent the application of dates that have already been applied ----- */
			if(empty($leave_check)) {

				$lstatus = ($info['role'] == ADMIN) ? 'Approved' : 'Pending';
				$last_id = $this->Common_model->InsertData('leaves', ['fld_ldate' => $daterange, 'fld_lperson' => $person, 'fld_lstaff_id' => $staff_id, 'fld_applied_by' => $apply_by, 'fld_lreason' => $reason, 'fld_lstatus' => $lstatus]);

				/* ----- Insert leave data to leaves and attendance ----- */
				$days = DateDiff($splitdate[0], $splitdate[1]);
				$insertdata = [];
				for ($d=0; $d <= $days; $d++) { 
					$date = date('Y-m-d', strtotime(struDate($splitdate[0]). '+ '.$d.' day'));
					$day = date('D', strtotime(struDate($splitdate[0]). '+ '.$d.' day'));

					$flag = ($info['role'] == ADMIN) ? '' : 'disabled';
					$insertdata[$d] = [
						'fld_sastaffid' => $staff_id,
						'fld_leaveid' => $last_id,
						'fld_sadate' => $date,
						'fld_saday' => $day,
						'fld_satitle' => 'Leave',
						'fld_sastatus' => 'L',
						'fld_saflag' => $flag
					];
				}
				$result = $this->Common_model->InsertBatchData('staff_attendance', $insertdata);
			}
		}

		$response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : $return;
		echo json_encode($response);
		exit;
	}


	public function add_booking() {
		$appid = $this->input->post('app_id', TRUE);
		
		/* customer detail */
		$custname 	= trim($this->input->post('cust_name', TRUE));
		$custlname 	= trim($this->input->post('cust_lname', TRUE));
		$custphone 	= trim($this->input->post('cust_phone', TRUE));
		$custemail 	= trim($this->input->post('cust_email', TRUE));
		$custdob 	= trim($this->input->post('cust_dob', TRUE));
		$custgender = trim($this->input->post('cust_gender', TRUE));
		$mari_sts 	= trim($this->input->post('mari_sts', TRUE));
		$anni_date 	= trim($this->input->post('anni_date', TRUE));
		$custaddr 	= trim($this->input->post('cust_addr', TRUE));
		$custpref 	= trim($this->input->post('cust_pref', TRUE));

		/* service detail*/
		$admincourt 	= $this->input->post('admincourt', TRUE);
		$court_dura 	= $this->input->post('court_dura', TRUE);
		$court_rate 	= $this->input->post('court_rate', TRUE);
		$court_date 	= $this->input->post('court_date', TRUE);
		$timings 	= $this->input->post('times', TRUE);

		/* Coupon detail*/
		$coupon_id = $this->input->post('fld_acpid', TRUE);
		$coupon_percent = $this->input->post('fld_acppercent', TRUE);
		$coupon_amount = $this->input->post('fld_acpamt', TRUE);

		$gst_amount = $this->input->post('getAmount', TRUE);
		$payment_amount = $this->input->post('payment_amount', TRUE);

		/* payment detail*/
		$paymode 	= $this->input->post('pay_mode', TRUE);
		$amount 	= 0;
		$cotp 		= $this->input->post('cotp', TRUE);

		$history = $paymode;
		if (!empty($appid)) {

			$AppointID = $this->input->post('appoint_id');
			/* Check already have the slot, date, time */
			$bookedtime = '';
			for($b = 0; $b < count($timings); $b++) {
			  $bookedtime .= "'".$timings[$b]."', ";
			}
	  
			$prev_booking = $this->Common_model->GetJoinDatas('appointments A', 'appointment_meta AM', 'A.fld_aid = AM.fld_amappid', "`fld_adate`", "`fld_amstaff_time` IN ('".trim($bookedtime, ", '")."') AND `fld_adate` = '".$court_date."' AND `fld_aserv` = '".$admincourt."' AND `fld_astatus` != 'Cancelled'");
			if(!empty($prev_booking)) {
			  echo json_encode(['status' => 300, 'alert_msg' => 'Sorry, but this slot is already booked!']);
			  exit;
			}
			
            $check = ExistorNot('customers', ['fld_phone' => $custphone]);
			$cust_rec = $this->Common_model->GetDatas('customers', 'fld_id, fld_custid', ['fld_id !=' => ''], "`fld_id` DESC");
			$newduration = $newrate = 0;
			for($n = 0; $n < count($timings); $n++) {
				/* --- For Appointment --- */
				$newduration += (float)$court_dura[$admincourt];
				$newrate += (float)$court_rate[$admincourt];
			}
			$this->Common_model->UpdateData('customers', [
				'fld_name' => $custname,
				'fld_lastname' => $custlname,
				'fld_email' => $custemail,
			], ["fld_phone" => $custphone]);

			$CustID = $this->input->post('cust_id', TRUE);

			$past_bal = $this->Common_model->GetDatas('payments', 'fld_pbalance, fld_ppaid, fld_phistory', ['fld_appid' => $appid], "`fld_pid` DESC");
			$balance = 0;
			
			if(!empty($past_bal)) {
				$paid = (float)$past_bal[0]['fld_ppaid'];
				$history = json_decode($past_bal[0]['fld_phistory']).$paymode;
			}

			$metavalue = [];
			$duration = $rate = 0;
			for($u = 0; $u < count($timings); $u++) {

				$duration += (float)$court_dura[$admincourt];
				$rate += (float)$court_rate[$admincourt];
				
				$metavalue[$u] = [
					'fld_amappid' => $appid,
					'fld_amstaff_time' => $timings[$u],
					'fld_amserv_name' => $admincourt,
					'fld_amserv_dura' => $court_dura[$admincourt],
					'fld_amserv_rate' => $court_rate[$admincourt],
					'fld_amstatus' => 'Active',
				];
			}
			$discount = ($rate * ((float)$coupon_percent / 100));
			$balance = (($rate - $discount)- ((float)$amount + $paid));

			$updatedata = [
					'fld_adate' => $court_date,
					'fld_atime' => json_encode($timings),
					'fld_acustid' => $CustID,
					'fld_aserv' => $admincourt,
					'fld_aduring' => $duration,
					'fld_arate' => $rate,
					'fld_abalance' => $balance,
					'fld_gst_amt' => $gst_amount,
					'fld_pay_charge' => $payment_amount,
				];

			logEntry('Reschedule Appointment', 'Court Status', 'Reschedule Appointment successfully', 'Update', json_encode($timings));
			$this->Common_model->UpdateData('appointments', $updatedata, ['fld_aid' => $appid]);
			$this->Common_model->DeleteData('appointment_meta', ['fld_amappid' => $appid]);
			$result  = $this->Common_model->InsertBatchData('appointment_meta', array_reverse($metavalue));
			// $this->Common_model->UpdateData('payments', ['fld_prate' => $rate, 'fld_ppaid' => $amount, 'fld_pbalance' => $balance, 'fld_phistory' => json_encode($history)], ['fld_appid' => $appid]);
            
			$tomail = (!empty($check)) ? $check[0]['fld_email'] : $custemail;
			$name = (!empty($check)) ? $check[0]['fld_name'] : $custname;
			$paymode = $this->Common_model->GetDatas('appointments', "fld_apaymode", ['fld_appointid' => $AppointID]);
            $bookingtemplates = BookingTemplate(['name' => $name, 'appoint_id' =>  $AppointID, 'payment_method' => $paymode[0]['fld_apaymode'], 'court' => $admincourt, 'date' => showDate($court_date), 'time' => $timings, 'amount' => $newrate, 'couponAmount' => '', 'gstAmount' => $gst_amount, 'payCharge' => $payment_amount]);
            
			$getPdf = $this->pdf_generate($AppointID);
			$mail = SendEmail($tomail, "", "", '🎉 Your Booking Has Been Rescheduled! 🎉', $bookingtemplates, $getPdf);
			$this->Common_model->UpdateData('appointments', ['fld_conf_email' => $mail], ['fld_aid' => $appid]);
		    
		} else {

			/* Check already have the slot, date, time */
			$bookedtime = '';
			for($b = 0; $b < count($timings); $b++) {
			  $bookedtime .= "'".$timings[$b]."', ";
			}
	  
			$prev_booking = $this->Common_model->GetJoinDatas('appointments A', 'appointment_meta AM', 'A.fld_aid = AM.fld_amappid', "`fld_adate`", "`fld_amstaff_time` IN ('".trim($bookedtime, ", '")."') AND `fld_adate` = '".$court_date."' AND `fld_aserv` = '".$admincourt."' AND `fld_astatus` != 'Cancelled'");
			if(!empty($prev_booking)) {
			  echo json_encode(['status' => 300, 'alert_msg' => 'Sorry, but this slot is already booked!']);
			  exit;
			}

			$check = ExistorNot('customers', ['fld_phone' => $custphone]);
			$cust_rec = $this->Common_model->GetDatas('customers', 'fld_id, fld_custid', ['fld_id !=' => ''], "`fld_id` DESC");
			$appoint_rec = $this->Common_model->GetDatas('appointments', 'fld_aid, fld_appointid', ['fld_aid !=' => '', 'fld_atype IS NULL' => NULL], "`fld_aid` DESC");

			$CustID = 'WC1000';
			if(!empty($cust_rec)) {
				$CustID = 'WC'.((float)substr($cust_rec[0]['fld_custid'], 2) + 1);
			}

			$AppointID = 'WB1000';
			if(!empty($appoint_rec)) {
				$AppointID = 'WB'.((float)substr($appoint_rec[0]['fld_appointid'], 2) + 1);
			}

			if(empty($check)) {
				$cust_lastid = $this->Common_model->InsertData('customers', [
					'fld_custid' => $CustID,
					'fld_name' => $custname,
					'fld_lastname' => $custlname,
					'fld_phone' => $custphone,
					'fld_email' => $custemail,
					'fld_pass' => $this->encryption->encrypt('user@123'),
					'fld_type' => 'Direct',
				]);
			} else {
				$CustID = $check[0]['fld_custid'];
				$cust_lastid = $check[0]['fld_id'];
			}

			$newduration = $newrate = 0;
			for($n = 0; $n < count($timings); $n++) {
				/* --- For Appointment --- */
				$newduration += (float)$court_dura[$admincourt];
				$newrate += (float)$court_rate[$admincourt];
			}
			$discount = ($newrate * ((float)$coupon_percent / 100));
			$newbalance = (($newrate - $discount) - (float)$amount);
            $status = ($paymode == 'Online') ? 'Pending' : 'Confirmed';
			$new_app_data = [
					'fld_appointid ' => $AppointID,
					'fld_adate' => $court_date,
					'fld_atime' => json_encode($timings),
					'fld_acustid' => $cust_lastid,
					'fld_aserv' => $admincourt,
					'fld_aduring' => $newduration,
					'fld_arate' =>  $newrate,
					'fld_astatus' => $status,
					'fld_apaymode' => $paymode,
					'fld_apaystatus' => '',
					'fld_abalance' => 0,
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
					'fld_amserv_name' => $admincourt,
					'fld_amserv_dura' => $court_dura[$admincourt],
					'fld_amserv_rate' => $court_rate[$admincourt],
					'fld_amstatus' => 'Active',
				];
			}
            
            logEntry('Appointment Booking', 'Court Status', 'Appointment Booking successfully', 'Add', json_encode($timings));
			$result = $this->Common_model->InsertBatchData('appointment_meta', array_reverse($new_meta_data));
			$this->Common_model->InsertData('payments', [ 'fld_appid' => $app_lastid, 'fld_prate' => $newrate, 'fld_ppaid' => $newrate, 'fld_pbalance' => 0, 'fld_phistory' => json_encode($history)]);

			$prev_used_cnt = $this->Common_model->GetDatas('coupons', 'fld_cpused', ['fld_cpid' => $coupon_id]);
			$cp_cnt = 1;
			if(!empty($prev_used_cnt)) { $cp_cnt = ((int)$prev_used_cnt[0]['fld_cpused'] + 1); }
			$this->Common_model->UpdateData('coupons', ['fld_cpused' => $cp_cnt], ['fld_cpid' => $coupon_id]);
		}

		$response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc'), 'appoint_id' => $AppointID] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
		echo json_encode($response);
		exit;
	}
	
	public function update_cust_booking() {
    
		$info = checkLogin();
		// Razorpay Status
		$appoint_id = $this->input->post('appoint_id', TRUE);
		$payment_id = $this->input->post('pay_id', TRUE);
		$order_id = $this->input->post('ord_id', TRUE);
		$signature = $this->input->post('signature', TRUE);
		$paydata = $this->input->post('paymentdata', TRUE);
		
		$razorstatus = strtolower($paydata['status']);
		$paystatus = 'Paid';
		$status = "Confirmed";
		if(!empty($paydata)) {
			if($razorstatus == "created" || $razorstatus == "authorized" || $razorstatus == "pending") {
				$paystatus = $status = "Pending";
			} elseif($razorstatus == "failed" || $razorstatus == "cancelled") {
				$paystatus = $status = "Cancelled";
			} elseif($razorstatus == "refunded") {
				$paystatus = $status = "Refunded";
			}
		}

		$result = 0;
		$app_detail = $this->Common_model->GetJoinDatas('appointments A', 'customers C', 'A.fld_acustid = C.fld_id', '`fld_aid`, `fld_appointid`, `fld_name`, `fld_email`, `fld_phone`, `fld_aserv`, `fld_adate`, `fld_atime`, `fld_arate`, `fld_acpamt`', ['fld_appointid' => $appoint_id]);
		if(!empty($app_detail)) {
			$balance = ((float)$app_detail[0]['fld_arate'] - (float)$paydata['amount']);
			$this->Common_model->UpdateData('appointments', ['fld_astatus' => $status, 'fld_payment_id' => $payment_id, 'fld_order_id' => $order_id, 'fld_signature' => $signature, 'fld_apaystatus' => $paydata['status'], 'fld_abalance' => $balance], ['fld_appointid' => $appoint_id]);
			$this->Common_model->UpdateData('payments', ['fld_ppaid' => $paydata['amount'], 'fld_pbalance' => $balance, 'fld_pstatus' => $paystatus, 'fld_ppayid' => $payment_id, 'fld_pvpa' => $paydata['vpa'], 'fld_pemail' => $paydata['email'], 'fld_pcont' => $paydata['contact'], 'fld_pcreated_at' => $paydata['created_at'], 'fld_pamt' => $paydata['amount']], ['fld_appid' => $app_detail[0]['fld_aid']]);
		
			// Sending Email
			$tomail = (!empty($app_detail)) ? $app_detail[0]['fld_email'] : $info['email_id'];
			$name = (!empty($app_detail)) ? $app_detail[0]['fld_name'] : $info['uname'];
			$subject = '🎉 Your Booking is Confirmed! Thank You for Booking with Us! 🎉';
			$court = $app_detail[0]['fld_aserv'];
			$court_date = $app_detail[0]['fld_adate'];
			$timings = json_decode($app_detail[0]['fld_atime']);
			$newrate = $app_detail[0]['fld_arate'];
			$coupon_amount = $app_detail[0]['fld_acpamt'];
			$gst_amount = 0;
			$payment_amount = $app_detail[0]['fld_arate'];
		
			$bookingtemplates = BookingTemplate(['name' => $name, 'appoint_id' =>  $appoint_id, 'payment_method' => 'Online', 'court' => $court, 'date' => showDate($court_date), 'time' => $timings, 'amount' => $newrate, 'couponAmount' => $coupon_amount, 'gstAmount' => $gst_amount, 'payCharge' => $payment_amount]);
		
			$Pdf = $this->pdf_generate($appoint_id);
			$mail = SendEmail($tomail, "", "", $subject, $bookingtemplates, $Pdf);
			$result = $this->Common_model->UpdateData('appointments', ['fld_conf_email' => $mail], ['fld_appointid' => $appoint_id]);	
		}

		$response = (!empty($result)) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
		echo json_encode($response);
		exit;
	  }

	public function pdf_generate($AppointID = NULL) {
		$table1 = 'appointments A';
        $table2 = 'appointment_meta AM';
        $table3 = 'customers C';
        $table4 = 'users U';
        $table5 = 'coupons CP';
        $table1cond = '`AM`.`fld_amappid` = `A`.`fld_aid`';
        $table2cond = '`A`.`fld_acustid` = `C`.`fld_id`';
        $table3cond = '`AM`.`fld_amstaffid` = `U`.`fld_uid`';
        $table4cond = '`CP`.`fld_cpid` = `A`.`fld_acpid`';
        $select     = "A.*, C.*, U.*, AM.*, CP.*,
                    (SELECT SUM(P.fld_ppaid) FROM payments P WHERE P.fld_appid = A.fld_aid) AS paid,
                    (SELECT P.fld_pbalance FROM payments P WHERE P.fld_appid = A.fld_aid ORDER BY P.fld_pdate DESC LIMIT 1) AS balance";
        $result = $this->Common_model->getAppointment($table1, $table2, $table3, $table4, $table5, $table1cond, $table2cond, $table3cond, $table4cond, $select, "A.fld_aid DESC", 10, 0, $AppointID);
        $data   = [
            'appkey'    => $AppointID,
            'cmpy_info' => getSettingData(),
            'records'   => mergeAppointment($result),
            'content'   => 'pdfs/app_pdf',
        ];

        $content = $this->load->view('pdf_temp', $data, true);
        $dompdf  = new Dompdf();
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfFilePath = FCPATH . ('../assets/pdf/') . 'Booking_' . $AppointID . '.pdf';

        if (file_put_contents($pdfFilePath, $dompdf->output())) {
            return $pdfFilePath;
        } else {
            return false;
        }
    }

    /* ------------ Cancelling the appointment ------------- */
    public function updatePayment() {
        $id        = trim($this->input->post('id', TRUE));
        $payamount = trim($this->input->post('payamount', TRUE));
        $payments  = $this->Common_model->GetDatas('payments', '*', ['fld_appid' => $id]);

        $paid    = ((float) $payments[0]['fld_ppaid'] + $payamount);
        $balance = (float) $payments[0]['fld_pbalance'];
        $calc    = ($balance - $payamount);

        $this->Common_model->UpdateData('payments', ['fld_ppaid' => $paid, 'fld_pbalance' => $calc], ['fld_appid' => $id]);
        $result = $this->Common_model->UpdateData('appointments', ['fld_abalance' => $calc], ['fld_aid' => $id]);

        $response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        echo json_encode($response);
        exit;
    }

    /* ------------ Checking the customer is new or exists ------------- */
    public function checkExistorNot() {
        $phone  = trim($this->input->post('phone', TRUE));
        $result = $this->Common_model->GetDatas('customers', '*', ['fld_phone' => $phone, 'fld_status' => 'Active']);

        $response = [];
        if (! empty($result)) {
            $response = ['custname' => $result[0]['fld_name'], 'custlname' => $result[0]['fld_lastname'], 'custphone' => $result[0]['fld_phone'], 'custemail' => $result[0]['fld_email'], 'custgen' => $result[0]['fld_gender'], 'custdob' => showDate($result[0]['fld_dob']), 'annidate' => showDate($result[0]['fld_anniversary']), 'marists' => $result[0]['fld_maritial_sts'], 'custaddr' => $result[0]['fld_address'], 'notes' => $result[0]['fld_notes']];
        }
        echo json_encode($response);
        exit;
    }

    /* ------------ Checking the staff is new or exists ------------- */
    public function checkExiststaff() {
        $email  = trim($this->input->post('email', TRUE));
        $result = $this->Common_model->GetDatas('users', '*', ['fld_uemail' => $email, 'fld_ustatus' => 'Active']);

        $response = [];
        if (! empty($result)) {
            $response = ['name' => $result[0]['fld_uname'], 'phone' => $result[0]['fld_uphone'], 'email' => $result[0]['fld_uemail'], 'gender' => $result[0]['fld_ugender'], 'dob' => showDate($result[0]['fld_udob']), 'annidate' => showDate($result[0]['fld_uanniversary']), 'marists' => $result[0]['fld_umarital_sts'], 'addr' => $result[0]['fld_uaddress']];
        }
        echo json_encode($response);
        exit;
    }

    /* ------------ Cancelling the appointment ------------- */
    public function cancel_appoint() {

        $id   = trim($this->input->post('id', TRUE));
        $type = trim($this->input->post('type', TRUE));

        $this->Common_model->UpdateData('appointments', ['fld_astatus' => $type, 'fld_acancel_date' => date('Y-m-d H:i')], ["md5(`fld_aid`)" => $id]);
        $result = $this->Common_model->UpdateData('appointment_meta', ['fld_amstatus' => $type], ["md5(`fld_amappid`)" => $id]);

        $response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        echo json_encode($response);
        exit;
    }

    /* --------- Get stylist list when choose service(s) -------- */
    public function getStylists() {

        $servs     = $this->input->post('servs', TRUE);
        $app_staff = ! empty($this->input->post('app_staff', TRUE)) ? $this->input->post('app_staff', TRUE) : [];

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

        if (! empty($results)) {
            $response = "";
            foreach ($results as $key => $res) {
                $expe = explode(", ", $res['fld_uexperience']);
                $response .= '<div class="col-xl-3">
			        <div class="card custom-card text-center">
			            <label for="staffCheck' . $key . '">
			                <div class="card-header border-bottom-0 pb-0">
			                    <span class="ms-auto shadow-lg fs-17">
			                        <input type="checkbox" name="staffs[]" class="form-check-input rounded-circle h5 form-checked-success" id="staffCheck' . $key . '" ' . (in_array($res['fld_uid'], $app_staff) ? 'checked' : '') . ' value="' . $res['fld_uid'] . '" >
			                    </span>
			                </div>
			                <div class="card-body pt-1">
			                    <span class="avatar avatar-xl avatar-rounded me-2 mb-3 text-dark border">
			                        <img src="' . base_url('../assets/images/user.jpg') . '" alt="img">
			                    </span>
			                    <div class="fw-medium fs-16 mb-1">' . strtoupper($res['fld_uname']) . '</div>
			                    <p class="mb-4 text-muted fs-11">
			                        <i class="bi bi-' . (($res['fld_ugender'] == "Male") ? "gender-male" : "gender-female") . '"></i>&nbsp;
			                        ' . $res['fld_ugender'] . '<br>' . $expe[0] . ' Year(s), ' . $expe[1] . ' Month(s)
			                    </p>
			                    <div class="btn-list mb-1">
			                        <p class="text-justify"> <span class="badge bg-primary"> ' . str_replace([','], '</span> <span class="badge bg-primary mt-2">', $res['fld_uservices']) . ' </span> </p>
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

    /* ----------- get staff timing based on staff choose ------------ */
    public function getCourtTiming() {

        $appkey  = $this->input->post('appkey', TRUE);
        $court   = $this->input->post('court', TRUE);
        $apptime = $this->input->post('apptime', TRUE);
        $date    = (! empty($this->input->post('date', TRUE))) ? $this->input->post('date', TRUE) : CURDATE;

        $gethour    = $this->Common_model->GetDatas('settings', '`fld_hours`, `fld_weekdays`');
        $start_time = strtotime('08:00');
        $end_time   = strtotime('19:00');
        if (! empty($gethour)) {
            $times      = explode(" - ", $gethour[0]['fld_hours']);
            $start_time = strtotime($times[0]);
            $end_time   = strtotime($times[1]);
        }

        /* ----- For get for holidate date restrict ----- */
        $attendance = $this->Common_model->GetDatas("staff_attendance", "`fld_sastatus`, `fld_sadate`", ['fld_sastatus' => 'H', 'fld_sadate' => $date, "fld_saflag" => '']);
        $atte_data  = [0 => ['fld_sadate' => '']];
        if (! empty($attendance)) {
            $atte_data = $attendance;
        }

        /* ----- For get booked time of the selected date ----- */
        $appoint_times = $this->Common_model->GetJoinDatas("appointments A", "appointment_meta AM", "`A`.`fld_aid`=`AM`.`fld_amappid`", "`fld_appointid`, `fld_adate`, `fld_amserv_name`, `fld_amstaff_time`, `fld_aduring`, `fld_amserv_dura`, `fld_atype`", "`fld_amserv_name` IN ('" . $court . "') AND `fld_adate` = '" . $date . "' AND `fld_astatus` != 'Cancelled'");
        $blockdata     = [];
        $prev_id       = '';
        foreach ($appoint_times as $key => $val) {

            if ($val['fld_amserv_name'] != $prev_id) {
                $dura = 0;
                $dura += ((int) $val['fld_amserv_dura'] - 1);
            }
            $times                                      = date('h:i A', strtotime($val['fld_amstaff_time']));
            $type                                       = (($val['fld_atype'] == "Maintenance") ? "Maintenance" : $val['fld_appointid']);
            $blockdata[$val['fld_amserv_name']][$times] = ['appid' => $type, 'astart' => date('H:i', strtotime($val['fld_amstaff_time'])), 'aend' => date('H:i', strtotime($val['fld_amstaff_time'] . ' +' . $dura . ' minutes'))];
            $prev_id                                    = $val['fld_amserv_name'];
        }

        $book_time     = $this->Common_model->GetJoinDatas("appointments A", "appointment_meta AM", "`A`.`fld_aid`=`AM`.`fld_amappid`", "`fld_adate`, `fld_amserv_name`, `fld_amstaff_time`, `fld_aduring`, `fld_amserv_dura`", "`fld_amserv_name` IN ('" . $court . "') AND `fld_adate` = '" . $date . "' AND `fld_aid` = '" . $appkey . "' AND `fld_astatus` != 'Cancelled'");
        $booked_time   = [];
        $selected_time = [];
        if (! empty($book_time)) {

            foreach ($book_time as $value) {
                $booked_time[$court][date("h:i A", strtotime($value['fld_amstaff_time']))] = date("H:i", strtotime($value['fld_amstaff_time']));
                $selected_time[$court]                                                     = ['start' => date('H:i', strtotime($value['fld_amstaff_time'])), 'end' => date('H:i', strtotime($value['fld_amstaff_time'] . ' +' . $value['fld_aduring'] . ' minutes'))];
            }
        }

        $cur_time = strtotime(date('H:i', strtotime('+0 minutes')));
        $cur_date = date('Y-m-d');

        $curTime    = date('H:i');
        $morn_start = '06:00';
        $morn_end   = '11:30';
        $noon_start = '12:00';
        $noon_end   = '17:30';
        $even_start = '18:00';
        $even_end   = '23:59';

        $active_tab = 'morning';
        if ($cur_date == $date) {
            if ($curTime >= $even_start && $curTime <= $even_end) {
                $active_tab = 'evening';
            } elseif ($curTime > $noon_start && $curTime <= $noon_end) {
                $active_tab = 'noon';
            }
        }

        $tabs = [
            "morning" => ["06:00 AM", "11:30 AM"],
            "noon"    => ["12:00 PM", "05:30 PM"],
            "evening" => ["06:00 PM", "11:30 PM"],
        ];

        $response = "";
        for ($i = 0; $i < 1; $i++) {

            $response .= '<div class="col-xl-12">
                      <div class="card custom-card border-light">
                        <div class="">
                          <div class="d-flex align-items-center w-100">
                            <div class="me-2"></div>
                          </div>

                          <ul class="nav nav-tabs nav-justified nav-style-1 d-flex flex-nowrap" role="tablist">';

            foreach ($tabs as $tab_name => $time_range) {
                $response .= '<li class="nav-item" role="presentation">
                <a class="nav-link ' . ($active_tab == $tab_name ? 'active' : '') . '" data-bs-toggle="tab" role="tab" href="#' . $tab_name . '-justified">' . ucfirst($tab_name) . '</a>
              </li>';
            }

            $response .= '</ul>
                  </div>
                <div class="tab-content">';
            $k = 0;
            $w = 0;
            $prev_bid = "";
            foreach ($tabs as $tab_name => $time_range) {
                $prev_class = $st_time = strtotime($time_range[0]);
                $end_time   = strtotime($time_range[1]);
                $week_day   = date('D', strtotime($date));
                $rows       = 0;
                $m          = 0;
                $response .= '<div class="tab-pane fade ' . ($active_tab == $tab_name ? 'active show' : '') . '" id="' . $tab_name . '-justified">
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="table">';
                if (($atte_data[0]['fld_sadate'] != $date) && in_array($week_day, json_decode($gethour[0]['fld_weekdays']), TRUE)) {
                    while ($st_time <= $end_time) {

                        if ($rows == 0) {$response .= '<tr>';}
                        $looptime  = date('H:i', $st_time);
                        $classtime = date('Hi', $st_time);

                        $prev       = strtotime('-30 minutes', $st_time);
                        $prev_class = date('Hi', $prev);

                        $next       = strtotime('+30 minutes', $st_time);
                        $next_class = date('Hi', $next);

                        $time_stru = date('h:i A', $st_time);
                        $prevtime  = isset($booked_time[$court][$time_stru]) ? $booked_time[$court][$time_stru] : "";

                        $blockid    = isset($blockdata[$court][$time_stru]) ? $blockdata[$court][$time_stru]['appid'] : "";
                        $blockstart = isset($blockdata[$court][$time_stru]) ? $blockdata[$court][$time_stru]['astart'] : "";
                        $blockend   = isset($blockdata[$court][$time_stru]) ? $blockdata[$court][$time_stru]['aend'] : "";

                        $apptime           = ! empty($blockstart) ? date("H:i", strtotime($blockstart)) : $prevtime;
                        $select_time_start = (isset($selected_time[$court]) ? $selected_time[$court]['start'] : "");
                        $select_time_end   = (isset($selected_time[$court]) ? $selected_time[$court]['end'] : "");
                        $scheduleCount     = isset($booked_time[$court]) && is_array($booked_time[$court]) ? count($booked_time[$court]) : 0;
                        $isDisabled        = (($cur_date == $date && $cur_time > $st_time) || ($looptime >= $blockstart && $looptime <= $blockend));

                        $resch_bool = (! empty($select_time_start) && ($select_time_start <= $looptime && $select_time_end >= $looptime));
                        $isChecked  = ($apptime == $looptime) || ($prevtime == $looptime);
                        $bgColor    = ($blockid == "Maintenance") ? 'bg-orange' : '';

                        $response .= '<td class="text-center ' . ($isDisabled ? 'cal-disabled' : '') . ' ' . ($isChecked ? 'btn-success' : 'btn-outline-success') . ' time-btn' . $k . ' ' . $classtime . ' ' . $bgColor . '" style="cursor: pointer;" data-time="' . $prev_class . '" onclick="getTimeRate(\'' . showTime($looptime) . '\', 30)"  data-next="' . $next_class . '">
                        <label class="text-dark ' . ($isDisabled ? 'cal-disabled' : '') . '">
                          <div class="align-items-center text-dark">
                          <input type="hidden" class="existing_slot" value="' . $scheduleCount . '">
                             <div class="input-group">
                              <small><b> ' . showTime($looptime) . '</b><br>';

                        if ($blockid == "Maintenance") {
                            $response .= '<span class="text-white">' . $blockid . '</span></small>';
                        } else {
                            if ($prev_bid != $blockid) {
                                $response .= '<a class="text-decoration-underline text-white" style="cursor: pointer;" onclick="getCustomerDetails(\'' . $blockid . '\')" title="View" alt="View">' . $blockid . '</a>';
                                $w++;
                            } 
                              
                            $response .= '</small>';
                        }
                        $prev_bid = $blockid;

                        if (! $isDisabled) {
                            $response .= '<input type="checkbox" name="times[]" class="d-none form-check-input rounded-circle form-checked-success" ' . ($isChecked ? 'checked' : '') . ' value="' . showTime($looptime) . '" >';
                        }

                        $response .= '</div>';

                        $response .= '</div></label></td>';
                        $st_time = strtotime('+30 minutes', $st_time);
                        $m++;
                        $rows++;
                        if ($rows == 3) {$rows = 0;}
                        if ($rows == 0) {$response .= '</tr>';}
                    }
                } else {
                    $response .= '<p class="text-center">The court is unavailable on the selected date.</p>';
                }
                $response .= '</table></div></div></div>';
            }

            $response .= '</div></div></div>';
            $k++;
        }

        echo $response;
        exit;
    }

    public function leave_check() {
        $id        = trim($this->input->post('id', TRUE));
        $startdate = trim($this->input->post('startdate', TRUE));
        $enddate   = trim($this->input->post('enddate', TRUE));

        $result   = $this->Common_model->GetDatas('staff_attendance', 'fld_sadate', ['fld_sastaffid' => $id, 'fld_sadate >=' => $startdate, 'fld_sadate <=' => $enddate, 'fld_saflag' => '']);
        $response = ! empty($result) ? "Kindly Change the Date(s)" : '';
        echo json_encode($response);
        exit;
    }

    public function get_coupons() {
        $coupon_name  = $this->input->post('coupon_amt');
        $amount       = $this->input->post('totalAmount');
        $current_date = date('Y-m-d');
        $response     = [
            'status'      => 401,
            'msg'         => 'Coupon not successfully applied',
            'finalamount' => $amount,
        ];
        $coupons = $this->Common_model->GetDatas('coupons', '*', ['fld_cpname' => $coupon_name, 'fld_cpstatus' => 'Active', 'fld_cpflag' => 1]);
        if (! empty($coupons)) {
            if ($coupons[0]['fld_cp_expdate'] < $current_date) {
                $response = [
                    'status'      => 401,
                    'msg'         => 'Coupon has expired',
                    'finalamount' => $amount,
                ];
            } elseif ($coupons[0]['fld_cpused'] >= $coupons[0]['fld_cplimit']) {
                $response = [
                    'status'      => 401,
                    'msg'         => 'Coupon usage limit reached',
                    'finalamount' => $amount,
                ];
            } else {
                $amount     = is_numeric($amount) ? (float) $amount : 0;
                $percentage = isset($coupons[0]['fld_cp_percentage']) && is_numeric($coupons[0]['fld_cp_percentage'])
                ? (float) $coupons[0]['fld_cp_percentage']
                : 0;
                $percent_value = ($amount * $percentage) / 100;
                $finalAmount   = $amount - $percent_value;
                $response      = [
                    'status'        => 200,
                    'msg'           => 'Coupon applied successfully',
                    'coupon_id'     => $coupons[0]['fld_cpid'],
                    'percentamount' => $percent_value,
                    'percent'       => $percentage,
                    'finalamount'   => $finalAmount,
                ];
            }
        } else {
            $response = [
                'status'      => 401,
                'msg'         => 'Invalid coupon or coupon not found',
                'finalamount' => $amount,
            ];
        }
        echo json_encode($response);
        exit;
    }

    // Court Status
    public function court_status($AppointID = NULL) {
        $filter      = (! empty($this->session->userdata('filter')) ? $this->session->userdata('filter') : []);
        $datefilter  = (! empty($filter['date_filter']) ? $filter['date_filter'] : CURDATE);
        $courtfilter = (! empty($filter['court_filter']) ? $filter['court_filter'] : '');

        $where = empty($courtfilter) ? ['A.fld_adate' => $datefilter] : ['A.fld_adate' => $datefilter, 'A.fld_aserv' => $courtfilter];

        $gethour = $this->Common_model->GetDatas('settings', 'fld_hours');

        $start_time = strtotime('06:00');
        $end_time   = strtotime('23:30');
        if (! empty($gethour)) {
            $times      = explode(" - ", $gethour[0]['fld_hours']);
            $start_time = strtotime($times[0]);
            $end_time   = strtotime($times[1]);
        }

        $staff_count = $this->Common_model->getCount('users', ['fld_uroles' => 2]);

        $todaySlots = $this->Common_model->GetJoinDatas('appointments A', 'customers C', "`C`.`fld_id`=`A`.`fld_acustid`", 'A.fld_adate, A.fld_acustid, A.fld_aserv, A.fld_appointid, A.fld_adate, C.fld_id, C.fld_name, C.fld_phone, C.fld_lastname', $where);

        $table1     = 'appointments A';
        $table2     = 'appointment_meta AM';
        $table3     = 'customers C';
        $table4     = 'coupons CP';
        $table5     = 'users U';
        $table1cond = '`AM`.`fld_amappid` = `A`.`fld_aid`';
        $table2cond = '`A`.`fld_acustid` = `C`.`fld_id`';
        $table3cond = '`A`.`fld_acpid` = `CP`.`fld_cpid`';
        $table4cond = '`U`.`fld_uid` = `A`.`fld_astaffid`';
        $select     = "A.*, C.*, AM.*, CP.*, U.*,
                    (SELECT SUM(P.fld_ppaid) FROM payments P WHERE P.fld_appid = A.fld_aid) AS paid,
                    (SELECT P.fld_pbalance FROM payments P WHERE P.fld_appid = A.fld_aid ORDER BY P.fld_pdate DESC LIMIT 1) AS balance";
        $orderby = "fld_aid DESC";

        $app_data = $this->Common_model->getAppointment($table1, $table2, $table3, $table4, $table5, $table1cond, $table2cond, $table3cond, $table4cond, $select, $orderby, $limit = 100, $start = 0, $search = '', $where);
        $items    = mergeAppointment($app_data);

        $setting = $this->Common_model->GetDatas('settings', "fld_weekdays");

        $edit_appoint = [];
        if (! empty($AppointID)) {

            $edit_appoint = $this->Common_model->RawSQL("SELECT `A`.*, `C`.*,`AM`.*, `CP`.*, (SELECT SUM(`P`.`fld_ppaid`) FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_aid`) AS `paid`, (SELECT `P`.`fld_pbalance` FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_aid` ORDER BY `P`.`fld_pdate` DESC LIMIT 1) AS `balance` FROM `appointments` `A` JOIN `customers` `C` ON `A`.`fld_acustid` = `C`.`fld_id` JOIN `appointment_meta` `AM` ON `AM`.`fld_amappid` = `A`.`fld_aid` LEFT JOIN `coupons` `CP` ON `CP`.`fld_cpid` = `A`.`fld_acpid` WHERE md5(`fld_appointid`) = '" . $AppointID . "' ORDER BY `fld_aid` DESC ");
        }

        $phone_nos = $this->Common_model->GetDatas('customers', "fld_phone");

        $data = [
            'info'          => checkLogin(),
            'wishes'        => GetWishes(),
            'cmpy_info'     => getSettingData(),
            'content'       => 'backpanel/court_status',
            'timeslot'      => ['start_time' => $start_time, 'end_time' => $end_time],
            'todaySlots'    => $todaySlots,
            'appLists'      => [],
            'datefill'      => showDate($datefilter),
            'courtfill'     => $courtfilter,
            'app_result'    => $items,
            'setting_data'  => $setting,
            'edit_appoint'  => mergeAppointment($edit_appoint),
            'phone_records' => $phone_nos,
        ];

        $this->load->view('template', $data);
    }

    // Cancel Slot
    /* ------------ Cancelling the appointment ------------- */
    public function cancel_slot() {
        $id     = md5(trim($this->input->post('id', TRUE)));
        $type   = trim($this->input->post('type', TRUE));
        $reason = trim($this->input->post('reason', TRUE));

        $this->Common_model->UpdateData('appointments', ['fld_astatus' => $type, 'fld_cancel_reason' => $reason, 'fld_acancel_date' => date('Y-m-d H:i')], ["md5(`fld_aid`)" => $id]);

        $result = $this->Common_model->UpdateData('appointment_meta', ['fld_amstatus' => $type], ["md5(`fld_amappid`)" => $id]);

        $response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        echo json_encode($response);
        exit;
    }

    public function getAppData() {
        $datefilter  = struDate($this->input->post('datefilter', TRUE));
        $courtfilter = $this->input->post('courtfilter', TRUE);
        $data        = ['status' => 200, 'filter' => $this->session->set_userdata('filter', ['date_filter' => $datefilter, 'court_filter' => $courtfilter])];
        echo json_encode($data);
        exit;
    }

    // Check Dayopen Modal
    public function checkdayopen_data() {
        $response = $this->Common_model->check_opening_balance();

        if ($response) {
            echo json_encode(["status" => 200, "message" => "Day is open"]);
        } else {
            echo json_encode(["status" => 400, "message" => "Day is not open"]);
        }
        exit;
    }

    // Day Open Insert
    public function day_openinsert() {
        $openbalance      = $this->input->post('openbalance', TRUE);
        $openbalancenotes = $this->input->post('opennotes', TRUE);
        $result           = $this->Common_model->InsertData('day_close', ['fld_date' => CURDATE, 'fld_opening_balance' => $openbalance, 'fld_opening_notes' => $openbalancenotes]);
        $response         = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        echo json_encode($response);
        exit;
    }

    // Update Day Close
    public function dayclose_update() {
        $cashAmount       = 0;
        $closing_totalamt = intval($this->input->post('closeAmount'));
        $closing_notes    = $this->input->post('fld_closing_notes');
        $cashpaymode      = $this->input->post('cashpaymode');
        $final_amount     = $this->input->post('final_amount');
        $c_amount         = intval(str_replace(',', '', $this->input->post('c_amount') ?: '0'));
        $cashAmount       = $closing_totalamt - $c_amount;
        $fld_paymethod    = $this->input->post('fld_paymethod');
        $fld_split_amt    = $this->input->post('fld_split_amt');
        $where            = ['fld_date' => date('Y-m-d')];
        $existing_record  = $this->Common_model->GetDatas('day_close', '*', $where);
        $result           = false;
        if ($existing_record) {
            $last_insert_id = $existing_record[0]['fld_id'] ?? null;
            $update_data    = [
                'fld_closing_balance' => ($final_amount),
                'fld_closing_notes'   => $closing_notes,
                'fld_cash_amount'     => $c_amount,
                'fld_paymode'         => $cashpaymode,
                'status'              => 1,
            ];
            $update_result = $this->Common_model->UpdateData('day_close', $update_data, $where);
            if (! $update_result) {
                log_message('error', 'Day close update failed: ' . $this->db->last_query());
            }
            if (! empty($fld_paymethod) && ! empty($fld_split_amt) && $last_insert_id) {
                $split_data = [];
                foreach ($fld_paymethod as $index => $method) {
                    if (! empty($method) && isset($fld_split_amt[$index])) {
                        $split_data[] = [
                            'fld_dayid'     => $last_insert_id,
                            'fld_date'      => date('Y-m-d'),
                            'fld_paymethod' => $method,
                            'fld_split_amt' => $fld_split_amt[$index],
                        ];
                    }
                }
                if (! empty($split_data)) {
                    log_message('info', 'Split Payment Insert: ' . json_encode($split_data));
                    $insert_status = $this->Common_model->InsertBatchData('split_payments', $split_data);
                    if (! $insert_status) {
                        log_message('error', 'Split payments insert failed: ' . $this->db->last_query());
                        $result = false;
                    }
                }
            }
            $result = $update_result;
        }
        if ($result) {
            $response = ['status' => 200, 'alert_msg' => alertMsg('add_suc')];
        } else {
            $response = ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        }
        echo json_encode($response);
        exit;
    }

    // Check Opening Balance
    public function setopening_balance() {
        $response = $this->Common_model->GetDatas('appointments', 'SUM(fld_arate) AS total_amount', [
            "fld_adate"    => date('Y-m-d', strtotime('-1 day')),
            "fld_apaymode" => 'cash',
        ]);
        if ($response) {
            echo json_encode(["status" => 200, 'data' => $response]);
        } else {
            echo json_encode(["status" => 400, 'data' => "0.00"]);
        }
        exit;
    }

    public function get_customerdata() {
        $id = $this->input->post('id');

        $response = $this->Common_model->getAppointmentDetails($id);

        if ($response) {
            echo json_encode(["status" => 200, 'data' => $response]);
        } else {
            echo json_encode(["status" => 400, 'data' => "0.00"]);
        }
        exit;
    }

    // Razorpay Payment Integration
    public function payment_create() {
        $result      = payNow($this->input->post());
        $paymentdata = json_decode($result, true);
        logEntry('Razorpay', 'Razorpay End', 'Razorpay Payment Create', 'Add', json_encode($paymentdata));
        echo json_encode($paymentdata);
        exit;
    }

    public function paymentSuccess() {
        $result = openRazorpay($this->input->post());
        logEntry('Razorpay', 'Razorpay End', 'Razorpay Payment Success', 'Add', $paymentdata);
        echo json_decode($result, true);
        exit;
    }

    // View Logs
    public function viewlogs() {
        $data = [
            'info'      => checkLogin(),
            'wishes'    => GetWishes(),
            'cmpy_info' => getSettingData(),
            'content'   => 'backpanel/view_logs',
        ];
        $this->load->view('template', $data);
    }

    public function logout() {
        logEntry('Logout', 'Logout', 'Logout successfully', 'Add', '');
        $this->session->unset_userdata('login_info');
        redirect('login');
    }

}
