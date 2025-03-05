<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

	public $load, $session, $input;

	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->helper('common_helper');
	}


	public function index() {
        $data = [
            'cmpy_info' => getSettingData(),
            'countrycodes' => get_country_codes()
        ];	
		$this->load->view('sign-up', $data);		
	}


	public function signup_validate() {   
    	
        if ($this->security->get_csrf_hash() !== $this->security->get_csrf_hash()) {
            die('CSRF Token mismatch');
        }

        $post = $this->input->post();        
        $encrypted_password = $this->encryption->encrypt($post['password']); 

        $name = ucwords(htmlspecialchars($post['first_name'], ENT_QUOTES, 'UTF-8'));    
        $lname = ucwords(htmlspecialchars($post['last_name'], ENT_QUOTES, 'UTF-8'));
        $phone = htmlspecialchars($post['contact_number'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($post['email'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($post['password'], ENT_QUOTES, 'UTF-8');

        $getuser = $this->Common_model->get_row('customers', array('fld_phone'=>$phone));
        if(!empty($getuser)) {
            echo json_encode([
                'status' => 2,
                'message' => 'Number Exists'
            ]);
            exit;
        }
    
        $prev_id = $this->Common_model->PaginationData('customers', 'fld_custid', NULL, "`fld_id` DESC", 1, 0);
        $cust_id = 'WC1000';

        if(!empty($prev_id)) {
            $cust_id = 'WC'.((float)substr($prev_id[0]['fld_custid'], 2) + 1);
        }

        $values = [
            'fld_custid' => $cust_id,
            'fld_name' => $name,
            'fld_lastname' => $lname,
            'fld_phone' => $phone,
            'fld_email' => $email,
            'fld_pass' => $encrypted_password, 
            'fld_dob' => struDate($post['dob']),
        ];

        $result = $this->Common_model->insert('customers', $values);
        echo json_encode(['status' => $result ? 1 : 0 ]);
        exit;
	}


}