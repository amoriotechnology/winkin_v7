<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller {

	public $load, $session, $input;

	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');

		$dayopens = $this->Common_model->GetDatas('appointments', 'SUM(fld_arate) AS total_amount', [
	        "fld_adate" => date('Y-m-d', strtotime('-1 day')),
	        "fld_apaymode" => 'cash'
	    ]);

	    $checkdaycloseStatus = $this->Common_model->check_dayclose_status();

	    if(isset($checkdaycloseStatus[0]) && $checkdaycloseStatus[0]['status'] == 1){
	    	$daycloses = [];
	    }else{
	    	$daycloses = $this->Common_model->getPaymentsSummary();
	    }

	    $day_report = [
	        'dayOpen' => $dayopens,
	        'daycloses' => $daycloses,
	        'day_status' => ((isset($checkdaycloseStatus[0])) ? $checkdaycloseStatus[0]['status'] : "")
	    ];

	    $this->load->vars(['day_report' => $day_report]);
	}


	public function index() {
		
		$data = [ 'content' => 'frontpanel/index', ];
		$this->load->view('front_template', $data);

	}


}

?>