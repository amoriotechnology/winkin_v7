<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

	public $load, $session, $input, $userid;


	public function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->helper('common_helper');

		if(!empty($this->session->userdata('login_cust_info'))){
			$this->userid = $this->session->userdata('login_cust_info')['cust_id'];
		} 
	}
	
	public function index() {
		
		$info = checkCustLogin();
		$setting = $this->Common_model->GetDatas('settings', "fld_weekdays");

		$data = [
			'cust_info' => GetCustDetails((!empty($info['cust_id']) ? $info['cust_id'] : "")),
			'cmpy_info' => getSettingData(),
			'content' => 'frontpanel/booking',
			'setting_data' => $setting
		];
		$this->load->view('front_template', $data);

	}


}