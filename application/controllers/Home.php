<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public $load, $session, $input, $userid;


	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->helper('common_helper');

		if(!empty($this->session->userdata('login_cust_info'))) {
			$this->userid = $this->userid = $this->session->userdata('login_cust_info')['cust_id'];
		}
	}

	public function index() {
		
		return redirect('bookings');
		$start = date('Y-m-01');
		$end = date('Y-m-31');
		$today = date('Y-m-d');
		$getuser = $this->Common_model->get_row('customers',array('fld_id'=>$this->userid));

		$data = [
			'info' => checkLogin(),
			'name' =>$getuser['fld_name'],
			'content' => 'backpanel/dashboard'
		];
		$this->load->view('template', $data);
	}


	public function getphone() {
		$post = $this->input->post();
		print_r($post); exit;
	}


	public function Getcc() {

		$csrf_token = $this->input->get_request_header('X-CSRF-TOKEN', TRUE);

		if ($csrf_token ) {
            //echo 'Yes';  
        } else {
        	exit;
        }
		$data['countrycodes'] = $this->Common_model->get_records('countrycodes',array(),null,null,'fld_countryname','ASC');
		echo json_encode($data['countrycodes']); exit;
	}

	public function logout() {
		$this->session->unset_userdata('login_cust_info');
		redirect('');
	}



}
