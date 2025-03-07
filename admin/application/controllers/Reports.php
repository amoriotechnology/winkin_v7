<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
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

    public function bookings($AppointID = NULL) {
        $services   = $this->Common_model->GetDatas('services', "fld_sid, fld_scate, fld_sname, fld_sduration, fld_srate, fld_stype", ['fld_sstatus' => 'Active'], "`fld_sid` DESC");
        $setting    = $this->Common_model->GetDatas('settings', "fld_weekdays");
        $phone_nos  = $this->Common_model->GetDatas('customers', "fld_phone");
        $leaves     = $this->Common_model->GetDatas('staff_attendance', "`fld_sastatus`, `fld_sadate`, `fld_satitle`", ['fld_sastatus' => 'H', 'fld_saflag' => '']);
        $leave_data = [];
        if (! empty($leaves)) {
            foreach ($leaves as $value) {$leave_data[$value['fld_sadate']] = $value['fld_satitle'];}
        }
        $edit_appoint = [];
        if (! empty($AppointID)) {
            $edit_appoint = $this->Common_model->RawSQL("SELECT `A`.*, `C`.*, `AM`.*, `CP`.*, (SELECT SUM(`P`.`fld_ppaid`) FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_aid`) AS `paid`, (SELECT `P`.`fld_pbalance` FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_aid` ORDER BY `P`.`fld_pdate` DESC LIMIT 1) AS `balance` FROM `appointments` `A` JOIN `customers` `C` ON `A`.`fld_acustid` = `C`.`fld_id` JOIN `appointment_meta` `AM` ON `AM`.`fld_amappid` = `A`.`fld_aid` LEFT JOIN `coupons` `CP` ON `CP`.`fld_cpid` = `A`.`fld_acpid` WHERE md5(`fld_appointid`) = '" . $AppointID . "' ORDER BY `fld_aid` DESC ");
        }
        $data = [
            'info'            => checkLogin(),
            'wishes'          => GetWishes(),
            'cmpy_info'       => getSettingData(),
            'content'         => 'reports/appoint_report',
            'serv_records'    => $services,
            'setting_records' => $setting,
            'phone_records'   => $phone_nos,
            'leave_records'   => $leave_data,
            'edit_appoint'    => mergeAppointment($edit_appoint),
            'modals'          => 'include/modals/appoint_modal',
        ];
        $this->load->view('template', $data);
    }

    public function getbookingsDatas() {
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $searchColumns = $this->input->post('search_columns', TRUE); 
        $datefilter     = $this->input->post('datefilter', TRUE);

        $where = ['A.fld_atype' => NULL];

        if (!empty($searchColumns)) {
            foreach ($searchColumns as $columnIndex => $searchValue) {
                if (!empty($searchValue)) {
                    switch ($columnIndex) {

                        case 1: // Booking ID
                            $where["A.fld_appointid LIKE"] = "%$searchValue%";                          
                            break;
                        case 2: // Booking Date
                            $searchDate = date("Y-m-d", strtotime(str_replace('/', '-', $searchValue)));
                            $where["DATE_FORMAT(A.fld_booked_date, '%Y-%m-%d') LIKE"] = "%$searchDate%";
                            break;
                        case 3: // Slot Date
                            $searchDate = date("Y-m-d", strtotime(str_replace('/', '-', $searchValue)));
                            $where["DATE_FORMAT(A.fld_adate, '%Y-%m-%d') LIKE"] = "%$searchDate%";
                            break;
                        case 4: // Slot Time
                            if (strpos($searchValue, '-') !== false) {
                                list($startTime, $endTime) = explode(" - ", $searchValue);
                                $where["A.fld_atime LIKE"] = "%$startTime%"; 
                            } else {
                                $where["A.fld_atime LIKE"] = "%$searchValue%";
                            }
                            break;
                        case 5: // Court
                            $searchValueFormatted = str_replace(' ', '', $searchValue);
                            $where["REPLACE(A.fld_aserv, ' ', '') LIKE"] = "%$searchValueFormatted%";
                            break;
                        case 6: // Name
                            $where["C.fld_name LIKE"] = "%$searchValue%";
                            break;
                        case 7: // Phone
                            $where["C.fld_phone LIKE"] = "%$searchValue%";
                            break;
                        case 8: // Pay Mode
                            $where["A.fld_apaymode LIKE"] = "%$searchValue%";
                            break;
                        case 9: // Amount
                            $where["A.fld_arate LIKE"] = '%' . (float) str_replace(',', '', $searchValue) . '%';
                            break;
                        case 10: // Status
                            $where["A.fld_astatus LIKE"] = "%$searchValue%";
                            break;
                    }
                }
            }
        }

        $dateWhere = [];
        if (!empty($datefilter)) {
            $split = explode(" to ", $datefilter);
            $startfilter = struDate($split[0]);
            $endfilter = struDate($split[1]);
            $startfilter = $startfilter . " 00:00:00";
            $endfilter =  $endfilter . " 23:59:59"; 

            $dateWhere = [
                'A.fld_adate >=' => $startfilter,
                'A.fld_adate <=' => $endfilter
            ];
        }

        $where = array_merge($where, $dateWhere);
        $total = $this->Common_model->GetJoinDatas('appointments A', 'customers C', '`A`.`fld_acustid` = `C`.`fld_id`', '*', $where);
        $totalItems = count($total);

        $table1     = 'appointments A';
        $table2     = 'customers C';
        $table3     = 'coupons CP';
        $table1cond = '`A`.`fld_acustid` = `C`.`fld_id`';
        $table2cond = '`CP`.`fld_cpid` = `A`.`fld_acpid`';
        $select     = "A.*, C.*, CP.*,
           (SELECT SUM(P.fld_ppaid) FROM payments P WHERE P.fld_appid = A.fld_aid) AS paid,
           (SELECT P.fld_pbalance FROM payments P WHERE P.fld_appid = A.fld_aid ORDER BY P.fld_pdate DESC LIMIT 1) AS balance";

        $items = $this->Common_model->getBookings($table1, $table2, $table3, $table1cond, $table2cond, $select, "STR_TO_DATE(`A`.`fld_atime`, '%h:%i %p') ASC", $limit, $start, $search, $where);
        $data = [];
        $i    = $start + 1;

        foreach ($items as $item) {
            $app_start_time = json_decode($item['fld_atime']);
            $curtime = date('h:i A');
            $playing = (strtotime($app_start_time[0]) <= strtotime($curtime) && strtotime(TimeDuration($app_start_time[0], $item['fld_aduring'])) >= strtotime($curtime) );
            $completed = (strtotime(TimeDuration($app_start_time[0], $item['fld_aduring'])) <= strtotime($curtime));
            $rescheduled = (strtotime($app_start_time[0]) > strtotime($curtime));

            $action = '<div class="dropdown ms-2">
                        <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">';
            if ((float)$item['fld_abalance'] == 0) {
                $action .= ' <li> <a class="dropdown-item" href="' . base_url('pdf_generate/' . $item['fld_appointid']) . '" target="_blank" role="button">View Bill</a> </li>';
            }

            if ((float)$item['fld_abalance'] > 0 && $item['fld_apaymode'] == 'Cash' && $item['fld_astatus'] != "Cancelled") {
                $action .= '<li> <a class="dropdown-item" onclick="PaymentData(\'' . md5($item['fld_appointid']) . '\', \'appointment\')" data-bs-toggle="modal" href="#PaymentModal" role="button">Payment</a> </li>';
            }

            // Conditional logic for the "Reschedule" button
            if (strtotime(CURDATE) <= strtotime($item['fld_adate']) && $rescheduled && ($item['fld_astatus'] == "Confirmed"  ||  $item['fld_astatus'] == "Confirmed")) {
                $action .= '<li><a class="dropdown-item" href="' . base_url('viewcourt_status/' . md5($item['fld_appointid'])) . '">Reschedule</a></li>';
            }

            if (strtotime(CURDATE) >= strtotime($item['fld_adate']) && $item['fld_astatus'] == "Confirmed" && $playing) {
                $action .= '<li> <a class="dropdown-item update_booking" data-id="' . md5($item['fld_appointid']) . '" data-status="Playing" >Playing...</a> </li>';
            }

            if (strtotime(CURDATE) >= strtotime($item['fld_adate']) && $completed && $item['fld_astatus'] != "Cancelled" && $item['fld_astatus'] != "Completed" && $item['fld_astatus'] != "Pending") {
                $action .= '<li> <a class="dropdown-item update_booking" data-id="' . md5($item['fld_appointid']) . '" data-status="Completed" >Completed.</a> </li>';
            }

            if (strtotime(CURDATE) <= strtotime($item['fld_adate']) && strtotime(date('h:i A')) <= strtotime($app_start_time[0]) && ($item['fld_astatus'] == "Confirmed"  ||  $item['fld_astatus'] == "Confirmed")) {
                $action .= '<li> <a class="dropdown-item cancel-confirm" data-id="' . md5($item['fld_aid']) . '">Cancelled</a> </li>';
            }
            if ($item['fld_astatus'] == "Pending") {
                $action .= '<li> <a class="dropdown-item release_confirm" data-id="' . md5($item['fld_appointid']). '" data-status="admin_update" data-amount="'.$item['fld_arate'].'">Confirm</a> </li>';
                $action .= '<li> <a class="dropdown-item release_confirm" data-id="' . md5($item['fld_appointid']) . '" data-status="Release" data-paymode="'.$item['fld_apaymode'].'">Release</a></li>';
            }
            $action .= '</ul>
                    </div>';

            $courtname      = (($item['fld_aserv'] == 'courtA') ? 'Court A' : 'Court B');

            $data[] = [
                "fld_aid"         => $i,
                "fld_appointid"   => '<a class="text-decoration-underline" onclick="viewDatas(\'' . md5($item['fld_appointid']) . '\', \'appointment\')" data-bs-toggle="modal" href="#viewAppintment" title="View" alt="View">' . $item['fld_appointid'] . '</a>',
                "fld_adate"       => showDate($item['fld_adate']),
                "fld_booked_date" => date('d/m/Y', strtotime($item['fld_booked_date'])),
                "fld_atime"       => showTime($app_start_time[0]) . ' - ' . TimeDuration($app_start_time[0], $item['fld_aduring']),
                "fld_name"        => $item['fld_name'],
                "fld_phone"       => $item['fld_phone'],
                "fld_aserv"       => $courtname,
                "fld_apaymode"    => $item['fld_apaymode'],
                "fld_arate"       => ! empty($item['fld_arate']) ? number_format($item['fld_arate'], 2) : '0.00',
                "status"          => ! empty($item['fld_astatus']) ? '<span class="badge bg-' . Bgcolors($item['fld_astatus']) . '">' . $item['fld_astatus'] . '</span>' : '',
                'action'          => $action,
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

    // Get Logs Datas
    public function getlogDatas() {
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $datefilter     = $this->input->post('datefilter', TRUE);
        $where          = [];
        if (! empty($datefilter)) {
            $split       = explode(" to ", $datefilter);
            $startfilter = struDate($split[0]) . " 00:00:00";
            $endfilter   = struDate($split[1]) . " 23:59:59";
            $where       = [
                'created_date >=' => $startfilter,
                'created_date <=' => $endfilter,
            ];
        }
        $total      = $this->Common_model->GetDatas('log_entry', "*", $where);
        $totalItems = count($total);
        $table1 = 'log_entry';
        $select = "*";
        $items  = $this->Common_model->getLogs($table1, $select, $orderField . ' ' . $orderDirection, $limit, $start, $search, $where);
        $data = [];
        $i    = $start + 1;
        foreach ($items as $item) {
            $status = $item['status'] == 'Fail' ?
            '<i class="bi bi-bookmark-x-fill text-danger test-white"></i>' :
            ($item['status'] == 'Update' ?
                '<i class="bi bi-pencil-square text-warning" style="font-size: 11px;"></i>' :
                '<i class="bi bi-check text-success"></i>'
            );
            $data[] = [
                "id"       => $i,
                "c_date"   => $status . ' ' . $item['c_date'],
                "c_time"   => $item['c_time'],
                "username" => $item['username'],
                "module"   => $item['module'],
                "details"  => $item['details'],
                "hint"     => $item['hint'],
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
    public function revenue() {
        $pageconfig = pageConfig('staff', 'users');
        $page_start = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $sales_record = [];
        $data = [
            'info'          => checkLogin(),
            'wishes'        => GetWishes(),
            'cmpy_info'     => getSettingData(),
            'content'       => 'reports/revenue_report',
            'sales_records' => $sales_record,
        ];
        $this->load->view('template', $data);
    }
    public function getrevenueDatas() {
        $datefilter     = $this->input->post('datefilter', TRUE);
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $searchColumns = $this->input->post('search_columns', TRUE);
        $totalItems    = 0;
        $col_where = ['A.fld_atype'  => NULL];
        if (! empty($searchColumns)) {
            foreach ($searchColumns as $columnIndex => $searchValue) {
                if (! empty($searchValue)) {
                    switch ($columnIndex) {
                    case 1:
                        $col_where["DATE_FORMAT(A.fld_booked_date, '%d/%m/%Y') LIKE"] = "%$searchValue%";
                        break;
                    case 2:
                        $col_where["DATE_FORMAT(A.fld_adate, '%d/%m/%Y') LIKE"] = "%$searchValue%";
                        break;
                    case 3:
                        $col_where["A.fld_appointid LIKE"] = "%$searchValue%";
                        break;
                    case 4:
                        $searchValueFormatted                            = str_replace(' ', '', $searchValue);
                        $col_where["REPLACE(A.fld_aserv, ' ', '') LIKE"] = "%$searchValueFormatted%";
                        break;
                    case 5:
                        $col_where["C.fld_name LIKE"] = "%$searchValue%";
                        break;
                    case 6:
                        $col_where["C.fld_phone LIKE"] = "%$searchValue%";
                        break;
                    case 7:
                        $col_where["A.fld_apaymode LIKE"] = "%$searchValue%";
                        break;
                    case 8:
                        $col_where["DATE_FORMAT(P.fld_pdate, '%d/%m/%Y') LIKE"] = "%$searchValue%";
                        break;
                    }
                }
            }
        }
        $dateWhere = [];
        if (! empty($datefilter)) {
            $split       = explode(" to ", $datefilter);
            $startfilter = struDate($split[0]);
            $endfilter   = struDate($split[1]);
            $startfilter = $startfilter . " 00:00:00";
            $endfilter   = $endfilter . " 23:59:59";
            $dateWhere = [
                'P.fld_pdate >=' => $startfilter,
                'P.fld_pdate <=' => $endfilter,
            ];
        }
        $this->db->where_not_in('A.fld_astatus', ['Pending', 'Cancelled']);
        $where = array_merge($col_where, $dateWhere);
        $table1     = 'appointments A';
        $table2     = 'customers C';
        $table3     = 'payments P'; // Payments table
        $table1cond = '`A`.`fld_acustid` = `C`.`fld_id`';
        $table2cond = '`P`.`fld_appid` = `A`.`fld_aid`'; 
        $select     = "A.*, C.*, P.*";                  
        // Get the total items
        $total = $this->Common_model->GetJoinDatasThreeTable($table1, $table2, $table3, $table1cond, $table2cond, $select, $where, ["A.fld_astatus" => ['Pending', 'Cancelled']]);
        $totalItems = count($total);
        $table1     = 'appointments A';
        $table2     = 'customers C';
        $table3     = 'payments P';
        $table1cond = '`A`.`fld_acustid` = `C`.`fld_id`';
        $table2cond = '`P`.`fld_appid` = `A`.`fld_aid`';
        $select     = "A.*, C.*, P.*";
        $items = $this->Common_model->getRevenue($table1, $table2, $table3, $table1cond, $table2cond, $select, $orderField . ' ' . $orderDirection, $limit, $start, $search, $where, ["A.fld_astatus" => ['Pending', 'Cancelled']]);
        $data = [];
        $i    = (float) $start + 1;
        foreach ($items as $item) {
            $booking_date = date('d/m/Y', strtotime($item['fld_booked_date']));
            $payment_date = date('d/m/Y', strtotime($item['fld_pdate']));
            $courtname    = (($item['fld_aserv'] == 'courtA') ? 'Court A' : 'Court B');
            $data[]       = [
                "fld_aid"         => $i,
                "fld_bookingdate" => $booking_date,
                "fld_adate"       => showDate($item['fld_adate']),
                "fld_appointid"   => $item['fld_appointid'],
                "fld_aserv"       => $courtname,
                "fld_name"        => $item['fld_name'],
                "fld_phone"       => $item['fld_phone'],
                "fld_apaymode"    => $item['fld_apaymode'],
                "fld_pdate"    => $payment_date,
                "fld_arate"       => round(($item['fld_arate'] - $item['fld_gst_amt']), 2),
                "fld_gst_amt"     => round(($item['fld_gst_amt']), 2),
                "fld_atotal"      => round(($item['fld_arate'] - $item['fld_acpamt']), 2),
            ];
            $i++;
        }
        $response = [
            "draw"            => ! empty($this->input->post('draw', TRUE)) ? $this->input->post('draw', TRUE) : 1,
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }
    // Day Close Reports
    public function day_close() {
        $pageconfig      = pageConfig('staff', 'users');
        $page_start      = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $dayclose_record = [];
        $data            = [
            'info'          => checkLogin(),
            'wishes'        => GetWishes(),
            'cmpy_info'     => getSettingData(),
            'content'       => 'reports/dayclose_report',
            'sales_records' => $dayclose_record,
        ];
        $this->load->view('template', $data);
    }
    public function getdaycloseDatas() {
        $datefilter     = $this->input->post('datefilter', TRUE);
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $totalItems     = 0;
        $totalItems  = $this->Common_model->getCount('day_close');
        $table1      = 'day_close';
        $select      = "*";
        $startfilter = $endfilter = $where = "";
        if (! empty($datefilter)) {
            $split       = explode(" to ", $datefilter);
            $startfilter = struDate($split[0]);
            $endfilter   = struDate($split[1]);
            $where       = ['fld_date >=' => $startfilter, 'fld_date <=' => $endfilter];
            $totalItems  = $this->Common_model->getCount('day_close', $where);
        }
        $items = $this->Common_model->getDayClose($table1, $select, $orderField . ' ' . $orderDirection, $limit, $start, $search, $where);
        $i     = $start + 1;
        foreach ($items as $item) {
            $action = '<button class="btn btn-primary" onclick="openDaycloseModal(' . $item['fld_id'] . ')" role="button">View</button> ';
            $data[] = [
                "fld_id"              => $i,
                "fld_date"            => showDate($item['fld_date']),
                "fld_opening_balance" => ! empty($item['fld_opening_balance']) ? $item['fld_opening_balance'] : 0,
                "fld_amount"          => ! empty($item['fld_closing_balance']) ? $item['fld_closing_balance'] : 0,
                "fld_cash_amount"     => ! empty($item['fld_cash_amount']) ? $item['fld_cash_amount'] : 0,
                "fld_closing_balance" => ! empty($item['fld_closing_balance']) && ! empty($item['fld_cash_amount']) ? ($item['fld_closing_balance'] - $item['fld_cash_amount']) : 0,
                "action"              => $action,
            ];
            $i++;
        }
        $response = [
            "draw"            => ! empty($this->input->post('draw', TRUE)) ? $this->input->post('draw', TRUE) : 1,
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }
    // Show modal View in Day Close
    public function showday_closeview() {
        $id       = $this->input->post('id');
        $response = $this->Common_model->GetDatas('split_payments', '*', [
            "fld_dayid" => $id,
        ]);
        if ($response) {
            echo json_encode(["status" => 200, 'data' => $response]);
        } else {
            echo json_encode(["status" => 400, 'data' => "0.00"]);
        }
        exit;
    }
    public function customer($ID = NULL) {
        $edit_cust = [];
        if (! empty($ID)) {
            $edit_cust = $this->Common_model->GetDatas('customers', '*', ["md5(`fld_id`)" => $ID]);
        }
        $data = [
            'info'      => checkLogin(),
            'wishes'    => GetWishes(),
            'cmpy_info' => getSettingData(),
            'content'   => 'reports/cust_report',
            'edit_cust' => $edit_cust,
            'modals'    => 'include/modals/cust_modal',
        ];
        $this->load->view('template', $data);
    }
    public function getcustomerDatas() {
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];

        $searchColumns = $this->input->post('search_columns', TRUE); 
        $where = [];
	    if (!empty($searchColumns)) {
		    foreach ($searchColumns as $columnIndex => $searchValue) {
		        if (!empty($searchValue)) {
		            switch ($columnIndex) {
		                case 1:
		                    $searchDate = date("Y-m-d", strtotime(str_replace('/', '-', $searchValue)));
                            $where["DATE_FORMAT(fld_created_date, '%Y-%m-%d') LIKE"] = "%$searchDate%";
		                    break;
		                case 2: 
		                    $where["fld_custid LIKE"] = "%$searchValue%";
		                    break;
		                case 3: 
		                    $where["fld_name LIKE"] = "%$searchValue%";
		                    break;
		                case 4: 
		                    $where["fld_phone LIKE"] = "%$searchValue%";
		                    break;
		                case 5: 
		                    $where["fld_email LIKE"] = "%$searchValue%";
		                    break;
		                case 6:
		                    $searchDate = date("Y-m-d", strtotime(str_replace('/', '-', $searchValue)));
                            $where["DATE_FORMAT(fld_dob, '%Y-%m-%d') LIKE"] = "%$searchDate%";
		                    break;
		            }
		        }
		    }
		}


        $searchdata = ['fld_custid' => $search, 'fld_name' => $search, 'fld_phone' => $search, 'fld_email' => $search,"DATE_FORMAT(`fld_dob`, '%Y-%m-%d')" => $search, "DATE_FORMAT(`fld_created_date`, '%Y-%m-%d')" => $search];

        $totalItems = $this->Common_model->getCount('customers', "", $searchdata, "`fld_id`", $where);
        $items      = $this->Common_model->PaginationData('customers', "*", "", "`$orderField` $orderDirection", $limit, $start, $searchdata, $where);

        $noofbook = $this->Common_model->GetDatas('appointments', "`fld_acustid`, COUNT(`fld_acustid`) as noofbook", ["fld_acustid !=" => ''], "", "fld_acustid");
        $book_cnt = [];
        if (! empty($noofbook)) {
            foreach ($noofbook as $val) {
                $book_cnt[$val['fld_acustid']] = $val['noofbook'] ?? 0;
            }
        }
        $data = [];
        $i    = $start + 1;
        foreach ($items as $item) {
            $action = '<div class="dropdown ms-2">
						    <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
						        <i class="ti ti-dots-vertical"></i>
						    </button>
						    <ul class="dropdown-menu">
						        <li>
						            <a class="dropdown-item" onclick="viewDatas(\'' . md5($item['fld_id']) . '\', \'customer\')" data-bs-toggle="modal" href="#viewCust" role="button">View</a>
						        </li>
						        <li>
						            <a class="dropdown-item" onclick="editCustomer(this)" data-id="' . md5($item['fld_id']) . '" data-bs-toggle="modal" data-bs-target="#addCustModal">Edit</a>
						        </li>
						    </ul>
						</div>';
            $data[] = [
                "fld_id"           => $i,
                "fld_created_date" => date('d/m/Y', strtotime($item['fld_created_date'])),
                "fld_custid"       => $item['fld_custid'],
                "fld_name"         => $item['fld_name'],
                "fld_phone"        => $item['fld_phone'],
                "fld_email"        => $item['fld_email'],
                "fld_dob"          => showDate($item['fld_dob']),
                "fld_acustid"      => isset($book_cnt[$item['fld_id']]) ? $book_cnt[$item['fld_id']] : 0,
                'action'           => $action,
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
    public function category($ID = NULL) {
        $edit_cate = [];
        if (! empty($ID)) {
            $edit_cate = $this->Common_model->GetDatas('categorys', "*", ["md5(`fld_cateid`)" => $ID]);
        }
        $data = [
            'info'      => checkLogin(),
            'wishes'    => GetWishes(),
            'cmpy_info' => getSettingData(),
            'content'   => 'reports/cate_report',
            'edit_cate' => $edit_cate,
            'modals'    => 'include/modals/category_modal',
        ];
        $this->load->view('template', $data);
    }
    public function getcategoryDatas() {
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $searchdata = ['fld_catename' => $search, 'fld_catetype' => $search, 'fld_catestatus' => $search];
        $totalItems = $this->Common_model->getCount('categorys', "", $searchdata);
        $items      = $this->Common_model->PaginationData('categorys', "*", "", "`$orderField` $orderDirection", 10, $start, $searchdata);
        $data       = [];
        $i          = $start + 1;
        foreach ($items as $item) {
            $status = (($item['fld_catestatus'] == "Active") ? "Deactive" : "Active");
            $action = '<div class="dropdown ms-2">
                            <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" style="">
                                <li>
                                    <a class="dropdown-item update_cate_btn" data-id="' . md5($item['fld_cateid']) . '" data-status="' . $status . '">' . $status . '</a>
                                </li>
                                <li>
                                    <a href="' . base_url('category/' . md5($item['fld_cateid'])) . '" class="dropdown-item"> Edit </a>
                                </li>
                            </ul>
                        </div>';
            $data[] = [
                "fld_cateid"     => $i,
                "fld_catename"   => $item['fld_catename'],
                "fld_catetype"   => $item['fld_catetype'],
                "fld_catestatus" => '<span class="badge bg-' . Bgcolors($item['fld_catestatus']) . '">' . $item['fld_catestatus'] . '</span>',
                'action'         => $action,
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
    // Coupon List
    public function getcouponDatas() {
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $searchdata = ['fld_cpname' => $search, 'fld_cp_expdate' => $search, 'fld_cp_percentage' => $search];
        $totalItems = $this->Common_model->getCount('coupons', ["fld_cpflag" => 1], $searchdata);
        $items      = $this->Common_model->PaginationData('coupons', "*", ["fld_cpflag" => 1], "`$orderField` $orderDirection", $limit, $start, $searchdata);
        $data       = [];
        $i          = $start + 1;
        foreach ($items as $item) {
            $status = (($item['fld_cpstatus'] == "Active") ? "Deactive" : "Active");
            $action = '<div class="dropdown ms-2">
                            <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" style="">
                                <li>
                                    <a class="dropdown-item update_cp_btn" data-id="' . md5($item['fld_cpid']) . '" data-status="' . $status . '" data-type="fld_cpstatus" >' . $status . '</a>
                                </li>
                                <li>
                                    <a href="' . base_url('coupons/' . md5($item['fld_cpid'])) . '" class="dropdown-item"> Edit </a>
                                </li>
                                <li>
                                    <a class="dropdown-item update_cp_btn" data-id="' . md5($item['fld_cpid']) . '" data-status="Deleted" data-type="fld_cpflag" >Deleted</a>
                                </li>
                            </ul>
                        </div>';
            $data[] = [
                "fld_cpid"          => $i,
                "fld_cpname"        => $item['fld_cpname'],
                "fld_cp_expdate"    => showDate($item['fld_cp_expdate']),
                "fld_cp_percentage" => $item['fld_cp_percentage'],
                "fld_cplimit"       => $item['fld_cplimit'],
                "fld_cpused"        => $item['fld_cpused'],
                "fld_cpstatus"      => '<span class="badge bg-' . Bgcolors($item['fld_cpstatus']) . '">' . $item['fld_cpstatus'] . '</span>',
                "fld_sts"           => $item['fld_cpstatus'],
                "fld_exp_date"      => $item['fld_cp_expdate'],
                'action'            => $action,
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
    public function view_maintenance($ID = NULL) {
        $edit_maintenance = [];
        $first_time       = '';
        $last_time        = '';
        if (! empty($ID)) {
            $edit_maintenance = $this->Common_model->GetDatas('appointments', "*", ["md5(`fld_aid`)" => $ID, 'fld_atype' => 'Maintenance']);
            if (! empty($edit_maintenance) && isset($edit_maintenance[0]['fld_atime'])) {
                $start_time = json_decode($edit_maintenance[0]['fld_atime'], true);
                if (is_array($start_time) && ! empty($start_time)) {
                    $first_time = reset($start_time);
                    $last_time  = end($start_time);
                }
            }
        }
        $data = [
            'info'             => checkLogin(),
            'wishes'           => GetWishes(),
            'cmpy_info'        => getSettingData(),
            'edit_maintenance' => $edit_maintenance,
            'startTime'        => $first_time,
            'last_time'        => $last_time,
            'content'          => 'reports/maintenance',
            'modals'           => 'include/modals/maintenance_modal',
        ];
        $this->load->view('template', $data);
    }
    // Court Maintenance
    public function getcourtMaintenanceDatas() {
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $searchColumns = $this->input->post('search_columns', TRUE);
        $col_where     = [];
        if (! empty($searchColumns)) {
            foreach ($searchColumns as $columnIndex => $searchValue) {
                if (! empty($searchValue)) {
                    switch ($columnIndex) {
                    case 1:
                        $col_where["DATE_FORMAT(fld_booked_date, '%d/%m/%Y') LIKE"] = "%$searchValue%";
                        break;
                    case 2:
                        $col_where["DATE_FORMAT(fld_adate, '%d/%m/%Y') LIKE"] = "%$searchValue%";
                        break;
                    case 3:
                            if (strpos($searchValue, '-') !== false) {
                                list($startTime, $endTime) = explode(" - ", $searchValue); 
                                $col_where["fld_atime LIKE"] = "%$startTime%";
                            } else {
                                $col_where["fld_atime LIKE"] = "%$searchValue%";
                            }
                            break;
                    case 4:
                        $col_where["fld_appointid LIKE"] = "%$searchValue%";
                        break;
                    case 5:
                        $col_where["fld_aserv LIKE"] = "%$searchValue%";
                        break; 
                    case 6:
                        $col_where["fld_areason LIKE"] = "%$searchValue%";
                        break;                    
                    }
                }
            }
        }
        $searchdata = ['fld_appointid' => $search, 'fld_aserv' => $search, 'fld_adate' => $search, 'fld_booked_date' => $search, 'fld_atime' => $search];
        $totalItems = $this->Common_model->getCount('appointments', ["fld_atype" => 'Maintenance'], $searchdata, '`fld_aid`', $col_where);

        $items = $this->Common_model->PaginationData('appointments', "*", ["fld_atype" => 'Maintenance'], "`$orderField` $orderDirection", $limit, $start, $searchdata, $col_where);

        $data = [];
        $formatted_time = '';
        $i    = $start + 1;
        foreach ($items as $item) {
            $app_start_time = json_decode($item['fld_atime'], true);
            $formatted_time = TimeDuration($app_start_time[0], $item['fld_aduring']);
            $courtname = (($item['fld_aserv'] == 'courtA') ? 'Court A' : 'Court B');
            $action    = '<div class="dropdown ms-2">
                            <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" style="">
                                <li>
                                    <a href="' . base_url('view_maintenance/' . md5($item['fld_aid'])) . '" class="dropdown-item"> Edit </a>
                                </li>
                            </ul>
                        </div>';
            $data[] = [
                "fld_aid"         => $i,
                "fld_booked_date" => date('d/m/Y', strtotime($item['fld_booked_date'])),
                "fld_adate"       => showDate($item['fld_adate']),
                "fld_atime"       => $app_start_time[0].' - '.$formatted_time,
                "fld_appointid"   => $item['fld_appointid'],
                "fld_areason"   => $item['fld_areason'],
                "fld_aserv"       => $courtname,
                'action'          => $action,
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
    public function service($ID = NULL) {
        $categorys = $this->Common_model->GetDatas('categorys', "fld_cateid, fld_catename, fld_catetype, fld_catestatus", ['fld_catestatus' => 'Active'], "`fld_catename` ASC");
        $edit_serv = [];
        if (! empty($ID)) {
            $edit_serv = $this->Common_model->GetDatas('services', "*", ["md5(`fld_sid`)" => $ID]);
        }
        $data = [
            'info'         => checkLogin(),
            'wishes'       => GetWishes(),
            'cmpy_info'    => getSettingData(),
            'content'      => 'reports/service_report',
            'cate_records' => $categorys,
            'edit_serv'    => $edit_serv,
            'modals'       => 'include/modals/service_modal',
        ];
        $this->load->view('template', $data);
    }
    public function getserviceDatas() {
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $searchdata = ['fld_scate' => $search, 'fld_sname' => $search, 'fld_sduration' => $search, 'fld_srate' => $search, 'fld_stype' => $search, 'fld_sdesc' => $search, 'fld_sstatus' => $search];
        $totalItems = $this->Common_model->getCount('services', "", $searchdata);
        $items      = $this->Common_model->PaginationData('services', "*", '', "`$orderField` $orderDirection", $limit, $start, $searchdata);
        $data       = [];
        $i          = $start + 1;
        foreach ($items as $item) {
            $status = (($item['fld_sstatus'] == "Active") ? "Deactive" : "Active");
            $action = '<div class="dropdown ms-2">
	                        <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
	                            <i class="ti ti-dots-vertical"></i>
	                        </button>
	                        <ul class="dropdown-menu" style="">
	                            <li>
	                                <a class="dropdown-item update_serv_btn" data-id="' . md5($item['fld_sid']) . '" data-status="' . $status . '">' . $status . '</a>
	                            </li>
	                            <li>
	                                <a class="dropdown-item" onclick="editService(this)" data-id="' . md5($item['fld_sid']) . '" data-bs-effect="effect-flip-vertical" data-bs-toggle="modal" data-bs-target="#serviceModal"> Edit </a>
	                            </li>
	                        </ul>
	                    </div>';
            $data[] = [
                "fld_sid"       => $i,
                "fld_scate"     => $item['fld_scate'],
                "fld_sname"     => $item['fld_sname'],
                "fld_sduration" => mintoHour($item['fld_sduration']),
                "fld_srate"     => '$' . $item['fld_srate'],
                "fld_stype"     => $item['fld_stype'],
                "fld_sdesc"     => $item['fld_sdesc'],
                "fld_sstatus"   => '<span class="badge bg-' . Bgcolors($item['fld_sstatus']) . '">' . $item['fld_sstatus'] . '</span>',
                'action'        => $action,
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
    public function staff($ID = NULL) {
        $serv_data = [];
        $services  = $this->Common_model->PaginationData('access_modules', "*", [], "`fld_access_module` ASC");
        foreach ($services as $serv) {$serv_data[] = $serv['fld_access_module'];}
        $edit_staff = [];
        if (! empty($ID)) {
            $edit_staff = $this->Common_model->GetDatas('users', "*", ["md5(`fld_uid`)" => $ID, 'fld_uroles' => 2]);
        }
        $data = [
            'info'        => checkLogin(),
            'wishes'      => GetWishes(),
            'cmpy_info'   => getSettingData(),
            'content'     => 'reports/staff_report',
            'serv_record' => json_encode($serv_data),
            'edit_staff'  => $edit_staff,
            'modals'      => 'include/modals/staff_modal',
        ];
        $this->load->view('template', $data);
    }
    public function getstaffDatas() {
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];

        $searchColumns = $this->input->post('search_columns', TRUE); 

        $where = [];
	    if (!empty($searchColumns)) {
		    foreach ($searchColumns as $columnIndex => $searchValue) {
		        if (!empty($searchValue)) {
		            switch ($columnIndex) {
		                case 1:
		                    $where["fld_staffid LIKE"] = "%$searchValue%";
		                    break;
		                case 2: 
		                    $where["fld_uname LIKE"] = "%$searchValue%";
		                    break;
		                case 3: 
		                    $where["fld_uphone LIKE"] = "%$searchValue%";
		                    break;
		                case 4: 
		                    $where["fld_uemail LIKE"] = "%$searchValue%";
		                    break;
		                case 5: 
		                    $where["fld_access LIKE"] = "%$searchValue%";
		                    break;
		                case 6:
		                    $where["DATE_FORMAT(fld_udob, '%d/%m/%Y') LIKE"] = "%$searchValue%";
		                    break;
		                case 7: 
		                    $where["fld_ustatus LIKE"] = "%$searchValue%";
		                    break;
		            }
		        }
		    }
		}

        $searchdata = [ 'fld_uname' => $search, 'fld_staffid' => $search, 'fld_uphone' => $search, 'fld_uemail' => $search, 'fld_ustatus' => $search, 'fld_access' => $search, "DATE_FORMAT(`fld_udob`, '%d/%m/%Y')" => $search ];

        $totalItems = $this->Common_model->getCount('users', ['fld_uroles' => 2], $searchdata, "`fld_uid`", $where);
        $items      = $this->Common_model->PaginationData('users', "*", ['fld_uroles' => 2], "`$orderField` $orderDirection", $limit, $start, $searchdata, $where);

        $data       = [];
        $i          = $start + 1;
        foreach ($items as $item) {
            $status     = (($item['fld_ustatus'] == "Active") ? "Deactive" : "Active");
            $accessTags = json_decode($item['fld_access'], true);
            $fld_access_html = "";
            if (! empty($accessTags) && is_array($accessTags)) {
                $fld_access_html = implode(', </br>', array_column($accessTags, 'value')) . '</br>';
            }
            $action = '<div class="dropdown ms-2">
                        <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" onclick="viewDatas(\'' . md5($item['fld_uid']) . '\', \'staff\')" data-bs-toggle="modal" href="#viewStaff" role="button">View</a>
                            </li>
                            <li>
                                <a class="dropdown-item" onclick="editStaff(this)" data-id="' . md5($item['fld_uid']) . '" data-bs-toggle="modal" data-bs-target="#addStaffModal"> Edit </a>
                            </li>
                             <li>
                                <a class="dropdown-item update_staff_btn" data-id="' . md5($item['fld_staffid']) . '" data-status="' . $status . '">' . $status . '</a>
                            </li>
                        </ul>
                    </div>';
            $data[] = [
                "fld_uid"     => $i,
                "fld_staffid" => $item['fld_staffid'],
                "fld_uname"   => $item['fld_uname'],
                "fld_uphone"  => $item['fld_uphone'],
                "fld_uemail"  => $item['fld_uemail'],
                "fld_access"  => $fld_access_html,
                "fld_udob"    => showDate($item['fld_udob']),
                "fld_ustatus" => '<span class="badge bg-' . Bgcolors($item['fld_ustatus']) . '">' . $item['fld_ustatus'] . '</span>',
                'action'      => $action,
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
    public function leaves($ID = NULL) {
        $staff_ids = $this->Common_model->GetDatas('users', '*', ["fld_uroles" => 2]);
        $edit_leave = [];
        if (! empty($ID)) {$edit_leave = $this->Common_model->GetDatas('leaves', '*', ["md5(`fld_lid`)" => $ID]);}
        $data = [
            'info'       => checkLogin(),
            'wishes'     => GetWishes(),
            'staff_ids'  => $staff_ids,
            'edit_leave' => $edit_leave,
            'content'    => 'reports/leave_report',
            'modals'     => 'include/modals/leave_modal',
        ];
        $this->load->view('template', $data);
    }
    public function getleaveDatas() {
        $info           = checkLogin();
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $searchdata = ['fld_lperson' => $search, 'fld_lstaff_id' => $search, 'fld_lreason' => $search, 'fld_lrej_reason' => $search, 'fld_lstatus' => $search, "DATE_FORMAT(`fld_ldate`, '%M %d,%Y')" => $search];
        $where = ['fld_lstatus !=' => 'Deleted'];
        if (checkLogin()['role'] == STAFF) {
            $where = ['fld_lstatus !=' => 'Deleted', 'fld_lstaff_id' => checkLogin()['uid']];
        }
        $totalItems = $this->Common_model->getCount('leaves', $where, $searchdata);
        $items      = $this->Common_model->PaginationData('leaves', "*", $where, "`$orderField` $orderDirection", $limit, $start, $searchdata);
        $data       = [];
        $i          = $start + 1;
        foreach ($items as $item) {
            $edit = '<li> <a onclick="editLeave(this)" data-id="' . md5($item['fld_lid']) . '" class="dropdown-item"  data-bs-effect="effect-flip-vertical" data-bs-toggle="modal" data-bs-target="#LeaveModal"> Edit</a> </li>';
            $approve = '<li> <a class="dropdown-item update_leave" data-id="' . $item['fld_lid'] . '" data-status="Approved" > Approved</a> </li>';
            $reject = '<li>
	                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#RejectModal" data-id="' . md5($item['fld_lid']) . '" data-status="Rejected" onclick="viewDatas(\'' . md5($item['fld_lid']) . '\', \'leave\')" > Rejected </a>
	                    </li>';
            $delete = '<li> <a class="dropdown-item update_btn" data-id="' . md5($item['fld_lid']) . '" data-status="Deleted" > Delete </a> </li>';
            $rej_req = '<li>
    						<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#RejectModal" data-id="' . md5($item['fld_lid']) . '" data-status="Request Reject" onclick="viewDatas(\'' . md5($item['fld_lid']) . '\', \'leave\')" > Request for Reject </a>
    					</li>';
            $approve_req = '<li>
        						<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#RejectModal" data-id="' . md5($item['fld_lid']) . '" data-status="Request Reject" onclick="viewDatas(\'' . md5($item['fld_lid']) . '\', \'leave\')" > Request for Reject </a>
        					</li>';
            $leavedate  = explode(' to ', $item['fld_ldate']);
            $start_date = struDate($leavedate[0]);
            $action = "";
            if ($info['role'] == STAFF && $item['fld_lstatus'] == 'Pending') {
                $action = '<div class="dropdown ms-2">
		                        <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		                            <i class="ti ti-dots-vertical"></i>
		                        </button>
		                        <ul class="dropdown-menu" style="">' . $edit . $delete . '</ul>
		                    </div>';
            } else if ($info['role'] == STAFF && CURDATE <= $start_date && $item['fld_lstatus'] == "Approved" && $item['fld_req_reject'] == "") {
                $action = '<div class="dropdown ms-2">
		                        <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		                            <i class="ti ti-dots-vertical"></i>
		                        </button>
		                        <ul class="dropdown-menu" style="">' . $rej_req . '</ul>
		                    </div>';
            }
            if ($info['role'] == ADMIN && CURDATE <= $start_date) {
                $action = '<div class="dropdown ms-2">
		                    <button class="btn btn-icon btn-light btn-sm btn-wave waves-secondary waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		                        <i class="ti ti-dots-vertical"></i>
		                    </button>
		                    <ul class="dropdown-menu" style="">' . $edit . (($item['fld_lstatus'] != "Approved") ? $approve : "") . (($item['fld_lstatus'] != "Rejected") ? $reject : "") . $delete . '</ul>
		                </div>';
            }
            $status = '<span class="badge bg-' . Bgcolors($item['fld_lstatus']) . '">' . $item['fld_lstatus'] . '</span>';
            if ($item['fld_req_reject'] != "") {
                $status = '<span class="badge bg-' . Bgcolors($item['fld_lstatus']) . '">' . $item['fld_lstatus'] . '</span> <span class="badge bg-warning bi bi-info-circle-fill" data-bs-toggle="modal" data-bs-target="#RejectRequModal" data-id="' . md5($item['fld_lid']) . '" data-status="Request Reject" onclick="viewDatas(\'' . md5($item['fld_lid']) . '\', \'leave\')" > </span>';
            }
            $data[] = [
                "fld_lid"         => $i,
                "fld_create_date" => showDate($item['fld_create_date']),
                "fld_ldate"       => $item['fld_ldate'],
                "fld_lstaff_id"   => GetStaffID($item['fld_lstaff_id']),
                "fld_lperson"     => $item['fld_lperson'],
                "fld_lreason"     => $item['fld_lreason'],
                "fld_lrej_reason" => $item['fld_lrej_reason'],
                "fld_lstatus"     => $status,
                'action'          => $action,
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
    public function view_records() {
        $id   = $this->input->post('id', TRUE);
        $type = $this->input->post('type', TRUE);
        if ($type == 'customer') {
            $table = 'customers';
            $where = ["md5(`fld_id`)" => $id];
        } elseif ($type == 'staff') {
            $table = 'users';
            $where = ["md5(`fld_uid`)" => $id, 'fld_uroles' => 2];
        } elseif ($type == 'my_space' || $type == 'appointment') {
            $sql = "SELECT `A`.*, `C`.*, `AM`.*, `CP`.*, `U`.*, (SELECT SUM(`P`.`fld_ppaid`) FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_aid`) AS `paid`, (SELECT `P`.`fld_pbalance` FROM `payments` `P` WHERE `P`.`fld_appid` = `A`.`fld_aid` ORDER BY `P`.`fld_pdate` DESC LIMIT 1) AS `balance` FROM `appointments` `A` JOIN `appointment_meta` `AM` ON `AM`.`fld_amappid` = `A`.`fld_aid` JOIN `customers` `C` ON `A`.`fld_acustid` = `C`.`fld_id` LEFT JOIN `coupons` `CP` ON `A`.`fld_acpid` = `CP`.`fld_cpid` LEFT JOIN `users` `U` ON `U`.`fld_uid` = `A`.`fld_astaffid` WHERE md5(`fld_appointid`) = '" . $id . "' ORDER BY `fld_adate` DESC";
        } elseif ($type == 'leave') {
            $table = 'leaves';
            $where = ["md5(`fld_lid`)" => $id];
        } elseif ($type == 'service') {
            $table = 'services';
            $where = ["md5(`fld_sid`)" => $id];
        } elseif ($type == 'attend') {
            $table = 'staff_attendance';
            $where = ['fld_sadate' => struDate($id), 'fld_sastatus' => 'H', 'fld_saflag' => ''];
        }
        if ($type == 'my_space' || $type == 'appointment') {
            $record = $this->Common_model->RawSQL($sql);
            $result = mergeAppointment($record);
        } else {
            $result = $this->Common_model->GetDatas($table, '*', $where);
        }
        echo json_encode($result);
        exit;
    }

    // Razorpay Reports View Page
    public function view_razorpay() {
        $pageconfig = pageConfig('staff', 'users');
        $page_start = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $sales_record = [];
        $data = [
            'info'          => checkLogin(),
            'wishes'        => GetWishes(),
            'cmpy_info'     => getSettingData(),
            'content'       => 'reports/razorpay_report',
            'sales_records' => $sales_record,
        ];
        $this->load->view('template', $data);
    }
    public function getrazorpayDatas() {
        $datefilter     = $this->input->post('datefilter', TRUE);
        $limit          = $this->input->post('length', TRUE);
        $start          = $this->input->post('start', TRUE);
        $search         = $this->input->post('search', TRUE)['value'];
        $orderField     = $this->input->post('columns', TRUE)[$this->input->post('order', TRUE)[0]['column']]['data'];
        $orderDirection = $this->input->post("order", TRUE)[0]["dir"];
        $searchColumns = $this->input->post('search_columns', TRUE);
        $totalItems    = 0;
        $col_where = ['A.fld_atype'  => NULL];
        $col_where = ['P.fld_phistory'  => '"Online"'];
        if (! empty($searchColumns)) {
            foreach ($searchColumns as $columnIndex => $searchValue) {
                $searchValue = trim($searchValue);
                if (! empty($searchValue)) {
                    switch ($columnIndex) {
                    case 1:
                        $col_where["DATE_FORMAT(A.fld_booked_date, '%d/%m/%Y') LIKE"] = "%$searchValue%";
                        break;
                    case 2:
                        $col_where["DATE_FORMAT(P.fld_pdate, '%d/%m/%Y') LIKE"] = "%$searchValue%";
                        break;
                    case 3:
                        $col_where["A.fld_appointid LIKE"] = "%$searchValue%";
                        break;
                    case 4:
                        $col_where["C.fld_name LIKE"] = "%$searchValue%";
                        break;
                    case 5:
                        $col_where["C.fld_phone LIKE"] = "%$searchValue%";
                        break;
                    case 6:
                        $col_where["P.fld_ppaid LIKE"] = "%$searchValue%";
                        break;
                    case 7:
                        $col_where["A.fld_payment_id LIKE"] = "%$searchValue%";
                        break;
                    case 8:
                        $payHistory = str_replace('', '"', $searchValue);
                        $col_where["P.fld_phistory LIKE"] = "%$payHistory%";
                        break;
                    case 9:
                        $col_where["A.fld_apaystatus LIKE"] = "%$searchValue%";
                        break;
                    case 10:
                        $col_where["A.fld_astatus LIKE"] = "%$searchValue%";
                        break;
                    }
                }
            }
        }
        $dateWhere = [];
        if (! empty($datefilter)) {
            $split       = explode(" to ", $datefilter);
            $startfilter = struDate($split[0]);
            $endfilter   = struDate($split[1]);
            $startfilter = $startfilter . " 00:00:00";
            $endfilter   = $endfilter . " 23:59:59";
            $dateWhere = [
                'P.fld_pdate >=' => $startfilter,
                'P.fld_pdate <=' => $endfilter,
            ];
        }
        $where = array_merge($col_where, $dateWhere);
        $table1     = 'appointments A';
        $table2     = 'customers C';
        $table3     = 'payments P'; 
        $table1cond = '`A`.`fld_acustid` = `C`.`fld_id`';
        $table2cond = '`P`.`fld_appid` = `A`.`fld_aid`'; 
        $select     = "A.*, C.*, P.*";                  
        // Get the total items
        $total = $this->Common_model->GetJoinDatasThreeTableRazorpay($table1, $table2, $table3, $table1cond, $table2cond, $select, $where);
        $totalItems = count($total);
        $table1     = 'appointments A';
        $table2     = 'customers C';
        $table3     = 'payments P';
        $table1cond = '`A`.`fld_acustid` = `C`.`fld_id`';
        $table2cond = '`P`.`fld_appid` = `A`.`fld_aid`';
        $select     = "A.*, C.*, P.*";
        $items = $this->Common_model->getRazorpay($table1, $table2, $table3, $table1cond, $table2cond, $select, $orderField . ' ' . $orderDirection, $limit, $start, $search, $where);
        $data = [];
        $i    = (float) $start + 1;
        foreach ($items as $item) { 
            $booking_date = date('d/m/Y', strtotime($item['fld_booked_date']));
            $payment_date = date('d/m/Y', strtotime($item['fld_pdate']));
            $courtname    = (($item['fld_aserv'] == 'courtA') ? 'Court A' : 'Court B');
            $data[]       = [
                "fld_aid"         => $i,
                "fld_bookingdate" => $booking_date,
                "fld_pdate"       => $payment_date,
                "fld_appointid"   => $item['fld_appointid'],
                "fld_name"        => $item['fld_name'],
                "fld_phone"       => $item['fld_phone'],
                "fld_pamt"  => !empty($item['fld_ppaid']) ? $item['fld_ppaid'] : "0.00",
                "fld_payment_id"  => !empty($item['fld_payment_id']) ? $item['fld_payment_id'] : "",
                "fld_phistory"    => $item['fld_phistory'] = str_replace('"', "", $item['fld_phistory']),
                "fld_apaystatus"  => !empty($item['fld_apaystatus']) ? $item['fld_apaystatus'] : "",
                "fld_astatus"  => !empty($item['fld_astatus']) ? $item['fld_astatus'] : "",
            ];
            $i++;
        }
        $response = [
            "draw"            => ! empty($this->input->post('draw', TRUE)) ? $this->input->post('draw', TRUE) : 1,
            "recordsTotal"    => $totalItems,
            "recordsFiltered" => $totalItems,
            "data"            => $data,
        ];
        echo json_encode($response);
    }
    public function __destruct() {}
}
