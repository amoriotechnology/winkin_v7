<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public $load, $session, $input;

	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->helper('common_helper');
	}


	public function index() 
	{
		if(!empty(checkCustLogin())) {
			redirect('');
		}
		$data['cmpy_info'] = getSettingData();
		$this->load->view('sign-in', $data);
	}


	public function login_submit() {

		$post = $this->input->post();
		$phone = $post['phone'];
		$pwd = $post['password'];

		if ($this->security->get_csrf_hash() !== $this->security->get_csrf_hash()) {
        	die('CSRF Token mismatch');
    	}

		$result = $this->Common_model->GetDatas('customers', '*', ['fld_phone' => $phone]);

		$response = ['status' => 401, 'data' => ['role' => 0], 'alert_msg' => ['word' => 'Invalid Phone Number']];

		if(!empty($result)) {
			$response = ['status' => 401, 'data' => ['role' => 0], 'alert_msg' => ['word' => 'Invalid Password']];
			if($this->encryption->decrypt($result[0]['fld_pass']) == $pwd) {

				$this->session->set_userdata('login_cust_info', [
				    'cust_id' => $result[0]['fld_id'],
					'cust_name' => $result[0]['fld_name'],
					'cust_phone' => $result[0]['fld_phone'],
					'cust_email' => $result[0]['fld_email'],
					'role' => 'customer'
				]);

				$this->session->set_flashdata('wishes', 'Popup');
				$response = ['status' => 200, 'data' => ['role' => 0], 'alert_msg' => alertMsg('log_suc')];
			}
		}
		echo json_encode($response);
	}

	// Forgot Password

	public function forgot_password()
	{
        $email = $this->input->post('emailaddress');
        $result = $this->Common_model->GetDatas('customers', '*', ['fld_email' => $email]);

        if(empty($result)){
       	    $response = ['status' => 401,'alert_msg' => 'No Records Found'];
        }else{
        	$random_no = rand(100000, 999999);
		    $template = EmailTemplate(['wish_msg' => $random_no]);
		    SendEmail($email_id, "", "", 'Your 6 Digit OTP Number', $template);
		    $this->Common_model->UpdateData('customers', ['fld_otp' => $random_no, 'fld_otp_date' => CURDATETIME], ['fld_email' => $$email]);
        }

        $response = ['status' => 200, 'title' => 'OTP sended Successfully'];

		echo json_encode($response);
		exit;
	}


}