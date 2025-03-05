<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Razorpay\Api\Api;

class Frontend extends CI_Controller {


  public function __construct() {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->helper('common_helper');
    $this->config->load('config');
  }


  public function index($AppointID = NULL) {

    $info = checkCustLogin();
    $services = $this->Common_model->GetDatas('services', "fld_sid, fld_scate, fld_sname, fld_sduration, fld_srate, fld_stype", ['fld_sstatus' => 'Active'], "`fld_sid` DESC");
    $setting = $this->Common_model->GetDatas('settings', "fld_weekdays");

    $leaves = $this->Common_model->GetDatas('staff_attendance', "`fld_sastatus`, `fld_sadate`, `fld_satitle`", ['fld_sastatus' => 'H', 'fld_saflag' => '']);
    $leave_data = [];
    if(!empty($leaves)) {
      foreach($leaves as $value) { $leave_data[$value['fld_sadate']] = $value['fld_satitle']; }
    }
    $countrycodes = get_country_codes();

    $data = [
      'cust_info' => GetCustDetails((!empty($info['cust_id']) ? $info['cust_id'] : "")),
      'cmpy_info' => getSettingData(),
      'content' => 'frontpanel/index',
      'serv_data' => $services,
      'setting_data' => $setting,
      'leave_data' => $leave_data,
      'countrycodes' => $countrycodes,
      'edit_appoint' => [],
    ];

    $this->load->view('front_template', $data);
  }

  /* --------- customer bookings -------- */
  public function mybookings() {

    $info = checkCustLogin();
    if(empty($info)) { redirect('login'); }
    $data = [
      'cust_info' => GetCustDetails((!empty($info['cust_id']) ? $info['cust_id'] : "")),
      'cmpy_info' => getSettingData(),
      'content' => 'frontpanel/mybookings',
    ];
    $this->load->view('front_template', $data);
  }

  /* --------- customer Profile -------- */
  public function myprofile() {

    $info = checkCustLogin();
    if(empty($info)) { redirect('login'); }
    $countrycodes = get_country_codes();
    $getuser = $this->Common_model->get_row('customers', array('fld_id'=>$info['cust_id']));
    
    $data = [
      'cust_info' => GetCustDetails((!empty($info['cust_id']) ? $info['cust_id'] : "")),
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
      
      if ($this->input->post('csrf-token') !== $this->security->get_csrf_hash()) {
        die('CSRF Token mismatch');
      }
        
      $name = ucwords(htmlspecialchars($post['first_name'], ENT_QUOTES, 'UTF-8'));
      $lname = ucwords(htmlspecialchars($post['last_name'], ENT_QUOTES, 'UTF-8'));
      $contact_number = htmlspecialchars($post['contact_number'], ENT_QUOTES, 'UTF-8');
      $email = htmlspecialchars($post['email'], ENT_QUOTES, 'UTF-8');
      /*$encrypted_password = $this->encryption->encrypt($post['password']);*/
     
      $values = [
          'fld_name' => $name,
          'fld_lastname' => $lname,
          'fld_phone' => $contact_number,
          'fld_email' => $email,
          'fld_dob' => struDate($post['dob']),
      ];
      $result = $this->Common_model->update('customers', $values,array('fld_id'=>$info['cust_id']));
      echo json_encode(['status' => $result ? 1 : 0 ]);
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
    $table2 = 'customers C';
    $table3 = 'coupons CP';
    $table1cond = '`A`.`fld_acustid` = `C`.`fld_id`';
    $table2cond = '`CP`.`fld_cpid` = `A`.`fld_acpid`';
    $select = "A.*, C.*, CP.*,
       (SELECT SUM(P.fld_ppaid) FROM payments P WHERE P.fld_appid = A.fld_aid) AS paid,
       (SELECT P.fld_pbalance FROM payments P WHERE P.fld_appid = A.fld_aid ORDER BY P.fld_pdate DESC LIMIT 1) AS balance";

    $items = $this->Common_model->getBookings( $table1, $table2, $table3, $table1cond, $table2cond, $select, $orderField . ' ' . $orderDirection, $limit, $start, $search, ['fld_acustid' => $info['cust_id'], 'fld_atype IS NULL' => NULL] );

    $data           = [];
    $i              = $start + 1;
    foreach ($items as $item) {
      $action = '<div class="dropdown ms-2">
                  <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="ti ti-dots-vertical"></i>
                  </button>
                 <ul class="dropdown-menu">';
                 if(($item['fld_astatus'] != "Pending")){
                    $action .=     '<li> <a class="dropdown-item" href="'.base_url('pdf_generate/'.$item['fld_appointid']).'" target="_blank" role="button">View Bill</a> </li><li>';
                 }
              //if (strtotime(CURDATE) <= strtotime($item['fld_adate']) && ($item['fld_astatus'] != "Completed" && $item['fld_astatus'] != "Cancelled" )) {
               // $action .= '<a class="dropdown-item cancel-confirm" data-id="' . md5($item['fld_aid']) . '">Cancel</a>';
              //}
          $action .= '</li>
                  </ul>
              </div>';

        $app_start_time = json_decode($item['fld_atime']);
        $courtname = (($item['fld_aserv'] == 'courtA') ? 'Court A' : 'Court B');

        $data[] = [
              "fld_aid"   => $i,
              "fld_appointid" => $item['fld_appointid'],
              "fld_booked_date"   => date("d/m/Y", strtotime($item['fld_booked_date'])),
              "fld_adate"   => showDate($item['fld_adate']),
              "fld_atime"   => $app_start_time[0].' - '.TimeDuration($app_start_time[0], $item['fld_aduring']),
              "fld_aserv"   => $courtname,
              "fld_apaymode"   => $item['fld_apaymode'],
              "fld_arate"     => '₹'.($item['fld_arate']),
              "fld_astatus"   => '<span class="badge bg-'.Bgcolors($item['fld_astatus']).'">'. $item['fld_astatus'] .'</span>',
              'action'  => $action,
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
    $date = (!empty($this->input->post('date', TRUE))) ? $this->input->post('date', TRUE) : CURDATE;

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
    $appoint_times = $this->Common_model->GetJoinDatas("appointments A", "appointment_meta AM", "`A`.`fld_aid`=`AM`.`fld_amappid`", "`fld_appointid`, `fld_adate`, `fld_amserv_name`, `fld_amstaff_time`, `fld_aduring`, `fld_amserv_dura`, `fld_atype`", "`fld_amserv_name` IN ('".$court."') AND `fld_adate` = '".$date."' AND `fld_astatus` != 'Cancelled'" );
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
      $type = (($val['fld_atype'] == "Maintenance") ? "Maintenance" : $val['fld_appointid']);
      $blockdata[$val['fld_amserv_name']][$times] = ['appid' => $type, 'astart' => date('H:i', strtotime($val['fld_amstaff_time'])), 'aend' => date('H:i', strtotime($val['fld_amstaff_time'].' +'.$dura.' minutes')) ];

      $prev_id = $val['fld_amserv_name'];
    }

    $cur_time = strtotime(date('H:i', strtotime('+0 minutes'))); /* add 30 Minutes from current time for not booking current hour*/
    $cur_date = date('Y-m-d');

    $curtime = date('H:i');
    $morn_start = '06:00';
    $morn_end = '11:30';
    $noon_start = '12:00';
    $noon_end = '17:30';
    $even_start = '18:00';
    $even_end = '23:59';

    $active_tab = 'morning';
    if($cur_date == $date) {
      if ($curtime >= $even_start && $curtime <= $even_end) {
        $active_tab = 'evening';
      } elseif ($curtime > $noon_start && $curtime <= $noon_end) {
        $active_tab = 'noon';
      }
    }
    
    $tabs = [
          "morning" => ["06:00 AM", "11:30 AM"],
          "noon"    => ["12:00 PM", "05:30 PM"],
          "evening" => ["06:00 PM", "11:30 PM"]
        ];

    $response = "";
    for($i = 0; $i < 1; $i++) {

      $response .= '<div class="col-xl-12">
                      <div class="card custom-card border-light">
                        <div class="">
                          <div class="d-flex align-items-center w-100">
                            <div class="me-2"></div>
                          </div>

                          <ul class="nav nav-tabs nav-justified nav-style-1 d-flex flex-nowrap" role="tablist">';

          foreach ($tabs as $tab_name => $time_range) {
              $response .= '<li class="nav-item" role="presentation">
                <a class="nav-link '.($active_tab == $tab_name ? 'active' : '').'" data-bs-toggle="tab" role="tab" href="#'.$tab_name.'-justified">'.ucfirst($tab_name).'</a>
              </li>';
          }

      $response .= '</ul>
                  </div>
                <div class="tab-content">';
          $k = 0;
          foreach ($tabs as $tab_name => $time_range) {
              $prev_class = $st_time = strtotime($time_range[0]);
              $end_time = strtotime($time_range[1]);
              $week_day = date('D', strtotime($date));
              $rows = 0;
              $m = 0;

              $response .= '<div class="tab-pane fade '.($active_tab == $tab_name ? 'active show' : '').'" id="'.$tab_name.'-justified" >
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="table">';
              if (($atte_data[0]['fld_sadate'] != $date) && in_array($week_day, json_decode($gethour[0]['fld_weekdays']), TRUE)) {

                 while ($st_time <= $end_time) {
                    if ($rows == 0) { $response .= '<tr>'; }
                    
                    $looptime = date('H:i', $st_time);
                    $classtime = date('Hi', $st_time);
                    $prev = strtotime('-30 minutes', $st_time);
                    $prev_class = date('Hi', $prev);
                    $next = strtotime('+30 minutes', $st_time);
                    $next_class = date('Hi', $next);
                    $time_stru = date('h:i A', $st_time);
                    $time_stru = date('h:i A', $st_time);
                    $blockid = isset($blockdata[$court][$time_stru]) ? $blockdata[$court][$time_stru]['appid'] : "";
                    $prevtime = isset($booked_time[$court][$time_stru]) ? $booked_time[$court][$time_stru] : "";
                    $blockstart = isset($blockdata[$court][$time_stru]) ? $blockdata[$court][$time_stru]['astart'] : "";
                    $blockend = isset($blockdata[$court][$time_stru]) ? $blockdata[$court][$time_stru]['aend'] : "";

                    $apptime = !empty($blockstart) ? date("H:i", strtotime($blockstart)) : $prevtime;

                    $isDisabled = ($cur_date == $date && $cur_time > $st_time) || ($looptime >= $blockstart && $looptime <= $blockend);
                    $isChecked = ($apptime == $looptime) || ($prevtime == $looptime);

                    $bgColor = ($blockid == "Maintenance") ? 'bg-orange' : '';
                    $response .= '<td class="text-center '.($isDisabled ? 'cal-disabled' : '').' '.($isChecked ? 'btn-success' : 'btn-outline-success').' time-btn'.$k.' '.$classtime.' '.$bgColor.'" style="cursor: pointer;" data-time="'.$prev_class.'" onclick="getTimeRate(\''.showTime($looptime).'\', 30)"  data-next="'.$next_class.'">
                        <label class="text-dark '.($isDisabled ? 'cal-disabled' : '').'">
                          <div class="align-items-center text-dark">
                            <div class="input-group">
                              <small><b> '.showTime($looptime).'</b><br>';

                              if($blockid == "Maintenance") {
                                $response .= '<span class="text-dark">'.$blockid.'</span></small>';
                              } else {
                                $response .= '<span class="text-white"></span></small>';
                              }
                              
                    if (!$isDisabled) {
                        $response .= '<input type="checkbox" name="times[]" class="d-none form-check-input rounded-circle form-checked-success" '.($isChecked ? 'checked' : '').' value="'.showTime($looptime).'" >';
                    }

                    $response .= '</div></div></label></td>';
                    
                    $st_time = strtotime('+30 minutes', $st_time);
                    $m++;
                    $rows++;
                    
                    if ($rows == 3) { $rows = 0; }
                    if ($rows == 0) { $response .= '</tr>'; }
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

  public function add_cust_booking() {

    $info = checkCustLogin();
    $appid = $this->input->post('app_id', TRUE);
    
    /* customer detail */
    $custname   = trim($this->input->post('cust_name', TRUE));
    $custlname  = trim($this->input->post('cust_lname', TRUE));
    $custphone  = trim($this->input->post('cust_phone', TRUE));
    $altcustphone   = trim($this->input->post('alt_cust_phone', TRUE));
    $custemail  = trim($this->input->post('cust_email', TRUE));
    $custpwd    = $this->encryption->encrypt(trim($this->input->post('cust_pwd', TRUE)));
    $custdob    = trim($this->input->post('cust_dob', TRUE));
    $custgender = trim($this->input->post('cust_gender', TRUE));
    $mari_sts   = trim($this->input->post('mari_sts', TRUE));
    $anni_date  = trim($this->input->post('anni_date', TRUE));
    $custaddr   = trim($this->input->post('cust_addr', TRUE));
    $custpref   = trim($this->input->post('cust_pref', TRUE));

    /* sign-in detail */
    $signin_phone = (!empty($this->input->post('signin_phone', TRUE))) ? trim($this->input->post('signin_phone', TRUE)) : (!empty($info['cust_phone']) ? $info['cust_phone'] : $custphone);
    $pwd = trim($this->input->post('signin-password', TRUE));

    /* court detail*/
    $court    = $this->input->post('court', TRUE);
    $court_rate = $this->input->post('court_rate', TRUE);
    $court_dura = $this->input->post('court_dura', TRUE);
    $court_date = $this->input->post('court_date', TRUE);
    $timings  = $this->input->post('times', TRUE);
    $serv_notes = $this->input->post('serv_notes', TRUE);

    /* Coupon detail*/
    $coupon_id = $this->input->post('fld_acpid', TRUE);
    $coupon_percent = $this->input->post('fld_acppercent', TRUE);
    $coupon_amount = $this->input->post('fld_acpamt', TRUE);

    $gst_amount = $this->input->post('gst_amount', TRUE);
    $payment_amount = $this->input->post('payment_amount', TRUE);

    /* payment detail*/
    $paymode  = 'Online';//$this->input->post('pay_mode', TRUE);
    $amount   = 0;
    $cotp     = '';

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
      $this->Common_model->UpdateData('payments', ['fld_prate' => $rate, 'fld_ppaid' => ($amount + $gst_amount + $payment_amount), 'fld_pbalance' => 0, 'fld_phistory' => json_encode($history)], ['fld_appid' => $appid]);

    } else {
      
      /* Check already have the slot, date, time */
      $bookedtime = '';
      for($b = 0; $b < count($timings); $b++) {
        $bookedtime .= "'".$timings[$b]."', ";
      }

      $prev_booking = $this->Common_model->GetJoinDatas('appointments A', 'appointment_meta AM', 'A.fld_aid = AM.fld_amappid', "`fld_adate`", "`fld_amstaff_time` IN ('".trim($bookedtime, ", '")."') AND `fld_adate` = '".$court_date."' AND `fld_aserv` = '".$court."' AND `fld_astatus` != 'Cancelled'");
      if(!empty($prev_booking)) {
        echo json_encode(['status' => 300, 'alert_msg' => 'Sorry, but this slot is already booked!']);
        exit;
      }

      /* Fresh entry */
      $checkphone = (!empty($signin_phone)) ? $signin_phone : $custphone;
      $check = ExistorNot('customers', ['fld_phone' => $checkphone]); 

      $cust_rec = $this->Common_model->GetDatas('customers', 'fld_id, fld_custid', ['fld_status' => 'Active'], "`fld_id` DESC");
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
          'fld_alternatephone' => $altcustphone,
          'fld_email' => $custemail,
          'fld_pass' => $custpwd,
          'fld_gender' => $custgender,
          'fld_dob' => struDate($custdob),
          'fld_maritial_sts' => $mari_sts,
          'fld_anniversary' => struDate($anni_date),
          'fld_address' => $custaddr,
          'fld_notes' => $custpref,
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
          'fld_astatus' => 'Pending',
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

        $this->Common_model->InsertData('payments', [ 'fld_appid' => $app_lastid, 'fld_prate' => ($newrate), 'fld_ppaid' => 0, 'fld_pbalance' => 0, 'fld_phistory' => json_encode($history)]);
        $prev_used_cnt = $this->Common_model->GetDatas('coupons', 'fld_cpused', ['fld_cpid' => $coupon_id]);

        $cp_cnt = 1;
        if(!empty($prev_used_cnt)) {
          $cp_cnt = ((int)$prev_used_cnt[0]['fld_cpused'] + 1);
        }
        $this->Common_model->UpdateData('coupons', ['fld_cpused' => $cp_cnt], ['fld_cpid' => $coupon_id]);

        $this->session->set_userdata('login_cust_info', [
          'cust_id' => (empty($check) ? $cust_lastid : $check[0]['fld_id']),
          'cust_name' => (empty($check) ? $custname : $check[0]['fld_name']),
          'cust_phone' => (empty($check) ? $custphone : $check[0]['fld_phone']),
          'cust_email' => (empty($check) ? $custemail : $check[0]['fld_email']),
          'role' => 'customer'
        ]);
    }

    $response = ($result > 0) ? ['status' => 200, 'alert_msg' => alertMsg('add_suc'), 'appoint_id' => $AppointID] : ['status' => 401, 'alert_msg' => alertMsg('add_fail')];
    echo json_encode($response);
    exit;
  }

  public function update_appointment() {
    
    $info = checkCustLogin();
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
    $app_detail = $this->Common_model->GetJoinDatas('appointments A', 'customers C', 'A.fld_acustid = C.fld_id', '`fld_aid`, `fld_appointid`, `fld_name`, `fld_email`, `fld_phone`, `fld_aserv`, `fld_adate`, `fld_atime`, `fld_arate`, `fld_acpamt`, `fld_apaymode`', ['fld_appointid' => $appoint_id]);
    if(!empty($app_detail)) {
      $balance = ((float)$app_detail[0]['fld_arate'] - (float)$paydata['amount']);
      $this->Common_model->UpdateData('appointments', ['fld_astatus' => $status, 'fld_payment_id' => $payment_id, 'fld_order_id' => $order_id, 'fld_signature' => $signature, 'fld_apaystatus' => $paydata['status'], 'fld_abalance' => $balance], ['fld_appointid' => $appoint_id]);
      $this->Common_model->UpdateData('payments', ['fld_ppaid' => $paydata['amount'], 'fld_pbalance' => $balance, 'fld_pstatus' => $paystatus, 'fld_ppayid' => $payment_id, 'fld_pvpa' => $paydata['vpa'], 'fld_pemail' => $paydata['email'], 'fld_pcont' => $paydata['contact'], 'fld_pcreated_at' => $paydata['created_at'], 'fld_pamt' => $paydata['amount']], ['fld_appid' => $app_detail[0]['fld_aid']]);

      // Sending Email
      $tomail = (!empty($app_detail)) ? $app_detail[0]['fld_email'] : $info['cust_email'];
      $name = (!empty($app_detail)) ? $app_detail[0]['fld_name'] : $info['cust_name'];
      $subject = '🎉 Your Booking is Confirmed! Thank You for Booking with Us! 🎉';
      $court = $app_detail[0]['fld_aserv'];
      $court_date = $app_detail[0]['fld_adate'];
      $timings = json_decode($app_detail[0]['fld_atime']);
      $newrate = $app_detail[0]['fld_arate'];
      $coupon_amount = $app_detail[0]['fld_acpamt'];
      $gst_amount = 0;
      $payment_amount = $app_detail[0]['fld_arate'];

      $bookingtemplates = BookingTemplate(['name' => $name, 'appoint_id' =>  $appoint_id, 'payment_method' => $app_detail[0]['fld_apaymode'], 'court' => $court, 'date' => showDate($court_date), 'time' => $timings, 'amount' => $newrate, 'couponAmount' => $coupon_amount, 'gstAmount' => $gst_amount, 'payCharge' => $payment_amount]);

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
    $select = "A.*, C.*, U.*, AM.*, CP.*,
                (SELECT SUM(P.fld_ppaid) FROM payments P WHERE P.fld_appid = A.fld_aid) AS paid,
                (SELECT P.fld_pbalance FROM payments P WHERE P.fld_appid = A.fld_aid ORDER BY P.fld_pdate DESC LIMIT 1) AS balance";
    $result = $this->Common_model->getAppointment($table1, $table2, $table3, $table4, $table5, $table1cond, $table2cond, $table3cond, $table4cond, $select, "A.fld_aid DESC", 10, 0, $AppointID);

    $data = [
      'appkey' => $AppointID,
      'cmpy_info' => getSettingData(),
      'records' => mergeCustAppointment($result),
      'content' => 'pdfs/app_pdf',
    ];
    
    $content = $this->load->view('pdf_temp', $data, true);
    $dompdf = new Dompdf();
      $dompdf->loadHtml($content);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $pdfFilePath = FCPATH.('/assets/pdf/').'Booking_'.$AppointID.'.pdf';

      if (file_put_contents($pdfFilePath, $dompdf->output())) {
          return $pdfFilePath;
      } else {
          return false;
      }
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

  // Razorpay Payment Integration
  public function payment_create() {

    $result = payNow($this->input->post());
    $paymentdata = json_decode($result, true);
    echo json_encode($paymentdata);
    exit;
  }

  public function paymentSuccess() {
    $result = openRazorpay($this->input->post());
    echo json_decode($result, true);
    exit;
  }


}