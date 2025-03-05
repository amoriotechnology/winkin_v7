<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public $load, $session, $input;

	public $userid;
	public $username;

	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->helper('common_helper');

		if(!empty($this->session->userdata('login_cust_info'))) {
			$this->userid = $this->session->userdata('login_cust_info')['cust_id'];
		}

	}

	public function index() {
		
		$countrycodes = get_country_codes();
		$getuser = $this->Common_model->get_row('customers',array('fld_id'=>$this->userid));
		if(empty($getuser)) { redirect('Login'); }

		$getuser['fld_pass'] = $this->encryption->decrypt($getuser['fld_pass']);
		$getuser['fld_dob'] = formatDateToCustom($getuser['fld_dob']);
		
		if($getuser['fld_anniversary'] != "" && $getuser['fld_anniversary'] != "0000-00-00"){   
			$getuser['fld_anniversary'] = formatDateToCustom($getuser['fld_anniversary']);
		}
		
		$data = [
			'cust_info' => checkCustLogin(),
			'cmpy_info' => getSettingData(),
			'content' => 'user-profile',
			'user' => $getuser,
			'name' => $getuser['fld_name'],
			'countrycodes' => $countrycodes
		];	

		$this->load->view('template', $data);
	}

	public function profile_update() {
	    $post = $this->input->post();

	    checkCustLogin();

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
	    $password = htmlspecialchars($post['password'], ENT_QUOTES, 'UTF-8');
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
	        'fld_pass' => $encrypted_password, 
	        'fld_gender' => $gender, 
	        'fld_dob' => $post['dob'],
	        'fld_maritial_sts' => $marital_status, 
	        'fld_anniversary' => $post['anni_date'],
	        'fld_notes' => $notes
	    ];

	    // Insert data into the database
	    $result = $this->Common_model->update('customers', $values,array('fld_id'=>$this->userid));

	    // Return response
	    echo json_encode([
	        'status' => $result ? 1 : 0
	    ]);
	    exit;
	}


	public function forget_pwd()
	{
		$this->session->unset_userdata('login_cust_info');
		$data = [
			'cmpy_info' => getSettingData(),
		];

		$this->load->view('forget_pwd', $data);
	}


	public function send_otp() {

		if ($this->input->post('csrf-token', TRUE) !== $this->security->get_csrf_hash()) {
        	$response = ['status' => 403, 'title' => 'CSRF Token mismatch', 'text' => 'Please tryagin later...', 'icon' => 'warning'];
    	}
		
		$email_addr = $this->input->post('email_addr', TRUE);
		$trigger = $this->input->post('trigger', TRUE);
		$random_no = rand(100000, 999999); 
		
		$info = checkCustLogin();
		$email = $this->Common_model->GetDatas('customers', 'fld_email', ['fld_email' => $email_addr]);

		if(empty($info)) {
			if(!empty($email)) {
				$email_id = $email[0]['fld_email'];
			} else {
				$response = ['status' => 400, 'title' => 'Enter a valid email address', 'text' => '', 'icon' => 'warning'];
			}
		} else {
			$email_id = $info['cust_email'];
		}
		
		if(!empty($email_id)) {
			$template = EmailTemplate(['wish_msg' => $random_no]);
			SendEmail($email_id, "", "", 'Your 6 Digit OTP Number', $template);
			if(!empty($email_id)) {
				$this->Common_model->UpdateData('customers', ['fld_otp' => $random_no, 'fld_otp_date' => CURDATETIME], ['fld_email' => $email_id]);
				$response = ['status' => 200, 'title' => 'OTP Sent Successfully!!!', 'text' => '6 Digit OTP Number Sent, Please check your email address.', 'icon' => 'success'];
			}
		}
		echo json_encode($response);
		exit;
	}

	public function validateOTP() {

		if ($this->input->post('csrf-token', TRUE) !== $this->security->get_csrf_hash()) {
        	$response = ['status' => 403, 'title' => 'CSRF Token mismatch', 'text' => 'Please try again later...'];
    	}

		$OTP = trim($this->input->post('otp', TRUE));
		$email_addr = $this->input->post('email_addr', TRUE);    	

    	$result = $this->Common_model->GetDatas('customers', "`fld_email`, `fld_pass`, `fld_otp`", ['fld_email' => $email_addr, 'fld_otp' => $OTP]);

    	$response = (!empty($result)) ? ['status' => 200, 'title' => 'OTP Validated', 'text' => 'OTP Verified Successfully!!!'] : ['status' => 400, 'title' => 'OTP Validated', 'text' => 'Invalid OTP Number'];
    	echo json_encode($response);
    	exit;
	}

	public function change_password() {

		if ($this->input->post('csrf-token', TRUE) !== $this->security->get_csrf_hash()) {
        	$response = ['status' => 403, 'title' => 'CSRF Token mismatch', 'text' => 'Please tryagin later...', 'icon' => 'warning'];
    	}

		$email_addr = trim($this->input->post('email_addr', TRUE));
		$newpass = trim($this->input->post('new', TRUE));
		$confirmpass = trim($this->input->post('confirm', TRUE));
		$info = checkCustLogin();
		if(empty($info)) {
			$email = $this->Common_model->GetDatas('customers', 'fld_email', ['fld_email' => $email_addr]);
			$info['cust_email'] = $email[0]['fld_email'];
		}

		$pass = $this->encryption->encrypt($newpass);
		$result = $this->Common_model->UpdateData('customers', ['fld_pass' => $pass], ['fld_email' => $info['cust_email']]);
		$response = ($result > 0) ? ['status' => 200, 'title' => 'OTP Validated', 'text' => 'Matched Successfully!!!'] : ['status' => 400, 'title' => 'OTP Validated', 'text' => 'Invalid OTP Number'];
		$this->session->unset_userdata('login_cust_info');
		echo json_encode($response);
    	exit;
	}

}