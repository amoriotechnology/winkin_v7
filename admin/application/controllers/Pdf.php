<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->helper('common_helper');
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
			'records' => mergeAppointment($result),
			'content' => 'pdfs/app_pdf',
		];
		
		$content = $this->load->view('pdf_temp', $data, true);
		$dompdf = new Dompdf();
	    $dompdf->loadHtml($content);
	    $dompdf->setPaper('A4', 'portrait');
	    $dompdf->render();
	    $filename = 'Booking_'.$AppointID.'.pdf';
    // 	$pdf = $dompdf->output();

	    if (empty($pdf)) {
	        $dompdf->stream($filename, array('Attachment' => 0));
	    } else {
	        return $pdf;
	    }
	}
}