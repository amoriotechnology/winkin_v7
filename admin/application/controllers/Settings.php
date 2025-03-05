<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;
class Settings extends CI_Controller {

    public $load, $input;


    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->helper('common_helper');
        $this->load->library('email');
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

    public function attendance() {

        $attendance = $this->Common_model->GetJoinDatas('staff_attendance SA', 'users U', "`SA`.`fld_sastaffid` = `U`.`fld_uid`", "`SA`.*, `U`.*", ['fld_saflag' => '']);
        $holiday    = $this->Common_model->GetDatas('staff_attendance', '*', ['fld_sastatus' => 'H', 'fld_saflag' => '']);

        $data = [
            'info'           => checkLogin(),
            'wishes'         => GetWishes(),
            'cmpy_info'      => getSettingData(),
            'attend_record'  => json_encode($attendance),
            'holiday_record' => json_encode($holiday),
            'content'        => 'backpanel/staff_attend',
        ];
        $this->load->view('template', $data);
    }


    public function add_attend() {

        $staff_id     = trim($this->input->post('staff_name', TRUE));
        $attend_date  = $this->input->post('attend_date', TRUE);
        $attend_day   = $this->input->post('attend_day', TRUE);
        $attend_start = $this->input->post('attend_start', TRUE);
        $attend_end   = $this->input->post('attend_end', TRUE);
        $attend_sts   = $this->input->post('attend_sts', TRUE);

        $values = [];
        for ($a = 0; $a < count($attend_date); $a++) {

            $exist_attend = $this->Common_model->GetDatas('staff_attendance', 'fld_sastatus', ['fld_sadate' => struDate($attend_date[$a])]);
            if (empty($exist_attend)) {
                $values[$attend_date[$a]] = [
                    'fld_sastaffid' => $staff_id,
                    'fld_sadate'    => struDate($attend_date[$a]),
                    'fld_saday'     => $attend_day[$a],
                    'fld_sahours'   => $attend_start[$a] . ' to ' . $attend_end[$a],
                    'fld_sadayon'   => date('Y-m-d'),
                    'fld_sastatus'  => $attend_sts[$a],
                ];
            }
        }

        $result   = (! empty($values)) ? $this->Common_model->InsertBatchData('staff_attendance', $values) : 0;
        $response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        echo json_encode($response);
        exit;
    }

    public function admin_setting($ID = NULL) {

        $setting  = $this->Common_model->GetDatas('settings', "*");
        $year     = date('Y');
        $calender = $this->Common_model->GetDatas("staff_attendance", "*", ['fld_sastatus' => 'H', "YEAR(`fld_sadate`)" => $year, 'fld_saflag' => ''], "`fld_sadate` ASC");
        $profile  = $this->Common_model->GetDatas("users", "*", ['fld_staffid' => checkLogin()['staff_id']]);

        $serv_data = [];
        $services  = $this->Common_model->PaginationData('services', "*", ['fld_sstatus' => 'Active'], "`fld_sname` ASC");
        foreach ($services as $serv) {$serv_data[] = $serv['fld_sname'];}

        $edit_calender = [];
        if (! empty($ID)) {
            $edit_calender = $this->Common_model->GetDatas("staff_attendance", "*", ["md5(fld_said)" => $ID]);
        }

        $data = [
            'info'             => checkLogin(),
            'wishes'           => GetWishes(),
            'cmpy_info'        => getSettingData(),
            'content'          => 'backpanel/admin_setting',
            'setting_records'  => $setting,
            'calendar_records' => $calender,
            'profile_records'  => $profile,
            'edit_calender'    => $edit_calender,
            'serv_record'      => json_encode($serv_data),
        ];
        $this->load->view('template', $data);
    }

    public function add_holiday() {

        $info  = checkLogin();
        $id    = trim($this->input->post('cal_id', TRUE));
        $title = trim($this->input->post('cal_title', TRUE));
        $date  = struDate(trim($this->input->post('cal_date', TRUE)));
        $day   = date('D', strtotime($date));

        if (! empty($id)) {
            $result = $this->Common_model->UpdateData('staff_attendance', ['fld_sadate' => $date, 'fld_saday' => $day, 'fld_satitle' => $title, 'fld_saperson' => $info['uid']], ["md5(`fld_said`)" => $id]);
        } else {
            $result = $this->Common_model->InsertData('staff_attendance', ['fld_sastaffid' => $info['uid'], 'fld_sadate' => $date, 'fld_saday' => $day, 'fld_sastatus' => 'H', 'fld_satitle' => $title, 'fld_saperson' => $info['uid'], 'fld_sadayon' => CURDATE]);
        }

        $response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        echo json_encode($response);
        exit;
    }

    public function send_wishes() {

        $bday_emails = $this->input->post('bday_wish', TRUE);
        $anni_emails = $this->input->post('anni_daywish', TRUE);
        $settings    = getSettingData();
        $this->Common_model->UpdateData('customers', ['fld_wishes' => '', 'fld_wishdate' => NULL], ['fld_id !=' => '', "DATE_FORMAT(`fld_wishdate`, '%Y-%m-%d') !=" => CURDATE]);

        $send = [];
        $data = [];
        /* ----- Send birthday wishes ------ */
        if (! empty($bday_emails)) {
            for ($b = 0; $b < count($bday_emails); $b++) {

                $bday_data = explode(" | ", $bday_emails[$b]);
                $bday_subj = $settings['fld_bdaysubj'] . ' ' . $bday_data[1];
                $bday_temp = 'Dear ' . $bday_data[1] . ', <br><br> ' . $settings['fld_bdaytemp'];

                $data         = ['content' => $bday_temp, 'wish_msg' => $bday_subj, 'logo' => $settings['fld_cmpylogo']];
                $btemplate    = EmailTemplate($data);
                $send['bday'] = [SendEmail($bday_data[0], "", "", $bday_subj, $btemplate)];
                $this->Common_model->UpdateData('customers', ['fld_wishes' => 'bday', 'fld_wishdate' => CURDATETIME], ['fld_email' => $bday_data[0]]);
            }
        }

        /* ----- send anniversary wishes ----- */
        if (! empty($anni_emails)) {
            for ($a = 0; $a < count($anni_emails); $a++) {

                $anni_data = explode(" | ", $anni_emails[$a]);
                $anni_subj = $settings['fld_annisubj'] . ' ' . $anni_data[1];
                $anni_temp = 'Dear ' . $anni_data[1] . ', <br><br> ' . $settings['fld_annitemp'];

                $data         = ['content' => $anni_temp, 'wish_msg' => $anni_subj, 'logo' => $settings['fld_cmpylogo']];
                $atemplate    = EmailTemplate($data);
                $send['aday'] = [SendEmail($anni_data[0], "", "", $anni_subj, $atemplate)];
                $this->Common_model->UpdateData('customers', ['fld_wishes' => 'anniversary', 'fld_wishdate' => CURDATETIME], ['fld_email' => $anni_data[0]]);
            }
        }
        echo json_encode(['status' => 200, 'word' => $send]);
        exit;
    }

    public function holiday_calender() {
        $year        = trim($this->input->post('year', TRUE));
        $getcalender = $this->Common_model->GetDatas("staff_attendance", "*", ['fld_sastatus' => 'H', "YEAR(`fld_sadate`)" => $year, 'fld_saflag' => ''], "`fld_sadate` ASC");
        $holidays    = "";
        if (! empty($getcalender)) {
            foreach ($getcalender as $cal) {
                $holidays .= '<li class="border-0 border-bottom mt-3">

						        <p class="fs-16 mb-1 fw-medium">' . htmlspecialchars($cal['fld_satitle']) . '
						            <span class="float-end gap-3">
						                <!-- Edit Button -->
						                <a href="' . base_url('admin_setting/' . md5($cal['fld_said'])) . '" class="btn btn-info">
						                    <i class="bi bi-pencil-square"></i>
						                </a>

						                <!-- Delete Button -->
						                <a class="btn btn-danger alert-confirm" data-id="' . md5($cal['fld_said']) . '">
						                    <i class="bi bi-trash3"></i>
						                </a>
						            </span>
						        </p>
						        <p class="fs-12 mb-0 text-muted">' . showDate($cal['fld_sadate']) . ' - ' . date('D', strtotime($cal['fld_sadate'])) . '</p>
						    </li>';

            }
        } else {
            $holidays = '<p class="border-0 border-bottom mt-3 text-center"> No Records Found!!! </p>';
        }
        echo $holidays;
        exit;
    }

    public function setting_config() {

        $week      = $this->input->post('week', TRUE);
        $mail_host = trim($this->input->post('mail_host', TRUE));
        $cmpy_name = trim($this->input->post('cmpy_name', TRUE));
        $hours     = trim($this->input->post('hour', TRUE));

        $response = ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        if (! empty($mail_host)) {
            $mail_addr     = trim($this->input->post('mail_addr', TRUE));
            $mail_pass     = trim($this->input->post('mail_pass', TRUE));
            $bday_subject  = trim($this->input->post('bday_subject', TRUE));
            $bday_template = trim($this->input->post('bday_template', TRUE));
            $anni_subject  = trim($this->input->post('anni_subject', TRUE));
            $anni_template = trim($this->input->post('anni_template', TRUE));

            $values = [
                'fld_bdaysubj'  => $bday_subject,
                'fld_bdaytemp'  => $bday_template,
                'fld_annisubj'  => $anni_subject,
                'fld_annitemp'  => $anni_template,
                'fld_host'      => $mail_host,
                'fld_fromemail' => $mail_addr,
                'fld_emailpass' => $mail_pass,
            ];

        } else if (! empty($cmpy_name)) {

            $path       = '../assets/images/company_imgs/';
            $cmpy_email = trim($this->input->post('cmpy_email', TRUE));
            $cmpy_addr  = trim($this->input->post('cmpy_addr', TRUE));

            $cmpy_logo = trim($this->input->post('edit_logo', TRUE));
            if (! empty($_FILES['cmpy_logo']['name'])) {
                $logo = ImageUpload('cmpy_logo', $path, '130', '56');

                if ($logo['status'] == 400) {
                    $response = ['status' => 400, 'alert_msg' => ['word' => "Image doesn't fit into the allowed dimensions."]];
                } else {
                    $cmpy_logo = trim($logo['msg']['file_name']);
                }
            }

            $cmpy_favicon = trim($this->input->post('edit_favicon', TRUE));
            if (! empty($_FILES['cmpy_favicon']['name'])) {
                $fav = ImageUpload('cmpy_favicon', $path, '40', '40');

                if ($fav['status'] == 400) {
                    $response = ['status' => 400, 'alert_msg' => ['word' => "Image doesn't fit into the allowed dimensions."]];
                } else {
                    $cmpy_favicon = trim($fav['msg']['file_name']);
                }
            }

            $values = ['fld_cmpyname' => $cmpy_name, 'fld_cmpyemail' => $cmpy_email, 'fld_cmpyaddr' => $cmpy_addr, 'fld_cmpylogo' => $cmpy_logo, 'fld_cmpyfav' => $cmpy_favicon];

        } elseif (! empty($hours)) {
            $values = ['fld_hours' => $hours];
        } else {
            $values = ['fld_weekdays' => json_encode($week)];
        }

        $result   = $this->Common_model->UpdateData('settings', $values, ['fld_setid' => 1]);
        $response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : $response;
        echo json_encode($response);
        exit;
    }


    public function common_update() {
        $id     = trim($this->input->post('id', TRUE));
        $table  = trim($this->input->post('table', TRUE));
        $coloum = trim($this->input->post('coloum', TRUE));
        $type   = trim($this->input->post('type', TRUE));
        $value  = [$coloum => $type];
        if ($table == "calender") {
            $table = "staff_attendance";
            $where = ["md5(`fld_said`)" => $id];

        } else if ($table == "appoint") {
            $table = "appointments";
            $where = ["md5(`fld_appointid`)" => $id];

        } else if ($table == "update_status") {
            $paymentMode = trim($this->input->post('paymentMode', TRUE)) ?: '';

            if ($type == 'admin_update') {
                $type = "Confirmed";
            }
            $table   = "appointments";
            $where   = ["md5(`fld_appointid`)" => $id];
            $check   = $this->Common_model->GetJoinDatas('appointments AP', 'customers C', "`AP`.`fld_acustid` = `C`.`fld_id`", "`AP`.fld_appointid,`AP`.fld_adate,`AP`.fld_aserv,`AP`.fld_atime, `C`.fld_name,`C`.fld_lastname,`C`.fld_email,`AP`.fld_arate,`AP`.fld_apaymode", $where);
            $tomail  = $check[0]['fld_email'];
            $name    = $check[0]['fld_name'] . " " . $check[0]['fld_lastname'];
            $subject = 'Your Booking is Confirmed! Thank You for Booking with Us';
            if ($paymentMode === 'true') {$paymentMode = '';}
            $bookingtemplates = BookingTemplate(['name' => $name, 'type' => $type, 'appoint_id' => $check[0]['fld_appointid'], 'payment_method' => $paymentMode, 'court' => $check[0]['fld_aserv'], 'date' => showDate($check[0]['fld_adate']), 'time' => json_decode($check[0]['fld_atime'], true), 'amount' => $check[0]['fld_arate'], 'couponAmount' => '', 'gstAmount' => '', 'payCharge' => '']);
            if ($type == 'Cancelled') {
                $subject = 'Your Booking is Cancelled! Please Try After Sometime';
                $mail    = SendEmail($tomail, "", "", $subject, $bookingtemplates);
            } else {
                $Pdf  = $this->pdf_generate($check[0]['fld_appointid']);
                $mail = SendEmail($tomail, "", "", $subject, $bookingtemplates, $Pdf);
            }
            $value = [$coloum => $type, 'fld_apaymode' => $paymentMode];
        } else if ($table == "leave") {
            $table = "leaves";
            $where = ["md5(`fld_lid`)" => $id];

            if ($type == "Deleted") {

                $prev_data      = $this->Common_model->GetDatas('leaves', '*', ["md5(`fld_lid`)" => $id]);
                $prev_daterange = $prev_data[0]['fld_ldate'];
                $split          = explode(" to ", $prev_daterange);
                $prev_days      = DateDiff($split[0], $split[1]);
                $staff_id       = $prev_data[0]['fld_lstaff_id'];

                for ($u = 0; $u <= $prev_days; $u++) {
                    $date  = date('Y-m-d', strtotime(struDate($split[0]) . '+ ' . $u . ' day'));
                    $value = ['fld_saflag' => 'disabled'];
                    $this->Common_model->UpdateData('staff_attendance', $value, ["md5(`fld_leaveid`)" => $id, 'fld_sastaffid' => $staff_id, 'fld_sadate' => $date]);
                }
            }

        } else if ($table == "cate") {
            $table = "categorys";
            $where = ["md5(`fld_cateid`)" => $id];

        } else if ($table == "service") {
            $table = "services";
            $where = ["md5(`fld_sid`)" => $id];

        } else if ($table == "staff") {
            $table = "users";
            $where = ["md5(`fld_staffid`)" => $id];

        } else if ($table == "coupon") {
            $table = "coupons";
            $where = ["md5(`fld_cpid`)" => $id];
        }

        $result = $this->Common_model->UpdateData($table, $value, $where);

        $response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc')] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
        echo json_encode($response);
        exit;
    }
    public function pdf_generate($AppointID = NULL) {
        $table1     = 'appointments A';
        $table2     = 'appointment_meta AM';
        $table3     = 'customers C';
        $table4     = 'users U';
        $table5     = 'coupons CP';
        $table1cond = '`AM`.`fld_amappid` = `A`.`fld_aid`';
        $table2cond = '`A`.`fld_acustid` = `C`.`fld_id`';
        $table3cond = '`AM`.`fld_amstaffid` = `U`.`fld_uid`';
        $table4cond = '`CP`.`fld_cpid` = `A`.`fld_acpid`';
        $select     = "A.*, C.*, U.*, AM.*, CP.*,
                    (SELECT SUM(P.fld_ppaid) FROM payments P WHERE P.fld_appid = A.fld_aid) AS paid,
                    (SELECT P.fld_pbalance FROM payments P WHERE P.fld_appid = A.fld_aid ORDER BY P.fld_pdate DESC LIMIT 1) AS balance";
        $result = $this->Common_model->getAppointment($table1, $table2, $table3, $table4, $table5, $table1cond, $table2cond, $table3cond, $table4cond, $select, "A.fld_aid DESC", 10, 0, $AppointID);
        $data = [
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
    public function send_otp() {

        if ($this->input->post('csrf-token', TRUE) !== $this->security->get_csrf_hash()) {
            $response = ['status' => 403, 'title' => 'CSRF Token mismatch', 'text' => 'Please tryagin later...', 'icon' => 'warning'];
        }
        $info    = checkLogin();
        $trigger = $this->input->post('trigger', TRUE);

        $random_no = rand(100000, 999999); /* generate 6 digit random number */
        $email_id  = $info['email_id'];
        $template  = EmailTemplate(['wish_msg' => $random_no]);
        SendEmail($email_id, "", "", 'Your 6 Digit OTP Number', $template);
        $this->Common_model->UpdateData('users', ['fld_uotp' => $random_no, 'fld_uotp_date' => CURDATETIME], ['fld_uemail' => $email_id]);

        $response = ['status' => 200, 'title' => 'OTP sent successfully', 'text' => '6-digit OTP has been sent. Please check your email address.', 'icon' => 'success'];
        echo json_encode($response);
        exit;
    }

    public function validateOTP() {

        if ($this->input->post('csrf-token', TRUE) !== $this->security->get_csrf_hash()) {
            $response = ['status' => 403, 'title' => 'CSRF Token mismatch', 'text' => 'Please tryagin later...'];
        }
        $info = checkLogin();
        $OTP  = trim($this->input->post('otp', TRUE));

        $result   = $this->Common_model->GetDatas('users', "`fld_uemail`, `fld_upass`, `fld_uotp`", ['fld_uemail' => $info['email_id'], 'fld_uotp' => $OTP]);
        $response = (! empty($result)) ? ['status' => 200, 'title' => 'OTP Validated', 'text' => 'Matched Successfully!!!'] : ['status' => 400, 'title' => 'OTP Validated', 'text' => 'Invalid OTP Number'];
        echo json_encode($response);
        exit;
    }


    public function change_password() {

        if ($this->input->post('csrf-token', TRUE) !== $this->security->get_csrf_hash()) {
            $response = ['status' => 403, 'title' => 'CSRF Token mismatch', 'text' => 'Please tryagin later...', 'icon' => 'warning'];
        }

        $info        = checkLogin();
        $newpass     = trim($this->input->post('new', TRUE));
        $confirmpass = trim($this->input->post('confirm', TRUE));
		$pass = $this->encryption->encrypt($newpass);
		$result = $this->Common_model->UpdateData('users', ['fld_upass' => $pass], ['fld_uemail' => $info['email_id']]);
		$response = ($result > 0) ? ['status' => 200, 'title' => 'OTP Validated', 'text' => 'Matched Successfully!!!'] : ['status' => 400, 'title' => 'OTP Validated', 'text' => 'Invalid OTP Number'];
		$this->session->unset_userdata('login_info');
		echo json_encode($response);
    	exit;
	}

    // Coupons 
    public function coupons($ID = NULL) {
        $edit_coupon = [];
        if (! empty($ID)) {
            $edit_coupon = $this->Common_model->GetDatas('coupons', "*", ["md5(`fld_cpid`)" => $ID]);
        }

        $data = [
            'info'      => checkLogin(),
            'wishes'    => GetWishes(),
            'cmpy_info' => getSettingData(),
            'content'   => 'backpanel/coupons',
            'edit_cate' => $edit_coupon,
            'modals'    => 'include/modals/coupon_modal',
        ];
        $this->load->view('template', $data);
    }

    // Add Coupon
    public function add_coupon() {
        $cp_name       = trim($this->input->post('fld_cpname', TRUE));
        $cp_percentage = trim($this->input->post('fld_cp_percentage', TRUE));
        $cplimit       = trim($this->input->post('fld_cplimit', TRUE));
        $cp_expdate    = trim($this->input->post('fld_cp_expdate', TRUE));
        $cpid          = trim($this->input->post('cpid', TRUE));

        $values = [
            'fld_cpname'        => (! empty($cpid)) ? $cp_name : $cp_name . rand(1000, 9999),
            'fld_cp_percentage' => $cp_percentage,
            'fld_cplimit'       => $cplimit,
            'fld_cp_expdate'    => struDate($cp_expdate),
        ];

        if (! empty($cpid)) {
            $result = $this->Common_model->UpdateData('coupons', $values, ["md5(`fld_cpid`)" => $cpid]);
        } else {
            $result = $this->Common_model->InsertData('coupons', $values);
        }

        $response = [
            'status'    => $result > 0 ? 200 : 401,
            'alert_msg' => $result > 0 ? alertMsg('add_suc') : alertMsg('add_fail'),
        ];

        echo json_encode($response);
    }

    public function email_temp() {
        $this->load->view('email_temp');
    }

    // Qr Code Generator
    public function generate_upi_qr() {
        $amount = $this->input->post('amount', TRUE);
        echo GetQRCode(UPI_ID, UPI_NAME, $amount, "Pickleball Court Booking");
    }

}

?>