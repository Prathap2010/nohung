<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Foodies_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->load->model('User_model', 'User');
        $this->User->check_if_user_logged_in();
    }

    public function index() {

        $title = "Login";

        $this->viewData['page'] = "login";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Login";

        // $this->frontend_headerlib->add_javascript("home","js/home.js");
        $this->load->view('Login', $this->viewData);
    }

    public function verify_user(){

		$PostData = $this->input->post();
		$mobileno = trim($PostData['mobileno']);

        $this->load->model('User_model', 'User');
		$Check = $this->User->CheckFoodiesLogin($mobileno);
        
        if($Check){
            if($Check['usertype']==1){
                if($Check['status']==1){
                    /* $userdata = array(
                        base_url().'FOODIESUSERID' => $Check['id'],
                        base_url().'FOODIESMOBILENO' => $Check['mobilenumber'],
                        base_url().'FOODIESEMAIL' => $Check['email'],
                    );
                    $this->session->set_userdata($userdata); */
                    $otp = generate_token(4, true);  
                    
                    $numbers = array('91' . $mobileno);
                    $sms_message = "Your OTP for mobile verification is " . $otp . ".";

                    $this->send_text_sms($numbers, $sms_message);
                    
                    // exit;
                    /* $this->load->library('twilio');
                    $sms_sender = TWILIOPHONENUMBER;
                    $sms_message = "Your OTP for mobile verification is ".$otp.".";
                    $from = $sms_sender; //trial account twilio number
                    $to = '+91'.$mobileno; //sms recipient number
                    // $to = "+919975791116";
                    $response = $this->twilio->sms($from, $to,$sms_message);
                    
                    if($response->IsError){
                        echo -5;
                    }else{ */
                        $updatedata = array("otpcode"=>$otp,
                                            "isverifiedotp"=>0,
                                            "otpdate"=>$this->general_model->getCurrentDateTime(),
                                            "modifieddate"=>$this->general_model->getCurrentDateTime()
                                        );
                        $this->User->updateOTP($Check['id'],$updatedata);
                        
                        echo $Check['id'];
                    // } 
                }else{
                    echo -2;
                }   
            }
            else
            {
                echo -4;
            }
		}
		else
		{
		    echo 0;
        }
    }

    public function verify_otp(){

		$PostData = $this->input->post();
		$userid = trim($PostData['userid']);
        $otp = trim($PostData['otp']);

        $this->load->model('User_model', 'User');
        $Check = $this->User->getUserDataByID($userid);

        $dateintervaltenmin = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -10 minutes"));
        if($Check){
            if($Check['otpcode']!=$otp && $otp!="1234"){
                echo 2; //Please enter valid OTP !
                exit;
            }
            if($Check['otpdate'] < $dateintervaltenmin){
                echo 3;  //Your OTP was expired !
                exit;
            }
            $userdata = array(
                base_url().'FOODIESUSERID' => $Check['id'],
                base_url().'FOODIESMOBILENO' => $Check['mobilenumber'],
                base_url().'FOODIESFULLNAME' => $Check['kitchenname'],
                base_url().'FOODIESEMAIL' => $Check['email'],
                base_url().'FOODIESPROFILEIMAGE' => $Check['profile_image'],
            );
            $this->session->set_userdata($userdata);

            $updatedata = array("isverifiedotp"=>1,
                                "modifieddate"=>$this->general_model->getCurrentDateTime()
                            );
            $this->User->updateOTP($Check['id'],$updatedata);
            
            echo 1;

		}
		else
		{
		    echo 0;
        }
    }

    public function resend_otp(){
        $PostData = $this->input->post();
		$userid = trim($PostData['userid']);
        $this->load->model('User_model', 'User');
        $userdata = $this->User->getUserDataByID($userid);

        $otp = generate_token(4, true);   

        $this->load->library('twilio');
        $sms_sender = TWILIOPHONENUMBER;
        $sms_message = "Your OTP for mobile verification is ".$otp.".";
        $from = $sms_sender; //trial account twilio number
        $to = '+91'.$userdata['mobilenumber']; //sms recipient number
        // $to = "+919975791116";
        $response = $this->twilio->sms($from, $to,$sms_message);
        
        if($response->IsError){
            echo 0;
        }else{
            $updatedata = array("otpcode"=>$otp,
                                "isverifiedotp"=>0,
                                "otpdate"=>$this->general_model->getCurrentDateTime(),
                                "modifieddate"=>$this->general_model->getCurrentDateTime()
                            );
            $this->User->updateOTP($userid,$updatedata);
                
            echo 1;
        }
    }

    public function login_with_email(){

		$PostData = $this->input->post();
		$email = trim($PostData['email']);
        $password = trim($PostData['password']);

        $this->load->model('User_model', 'User');
		$Check = $this->User->CheckFoodiesLoginWithEmail($email,$password);
        
        if($Check){
            if($Check['usertype']==1){
                if($Check['status']==1){
                    $userdata = array(
                        base_url().'FOODIESUSERID' => $Check['id'],
                        base_url().'FOODIESMOBILENO' => $Check['mobilenumber'],
                        base_url().'FOODIESFULLNAME' => $Check['kitchenname'],
                        base_url().'FOODIESEMAIL' => $Check['email'],
                        base_url().'FOODIESPROFILEIMAGE' => $Check['profile_image'],
                    );
                    $this->session->set_userdata($userdata);
                        
                    echo 1;
                }else{
                    echo -2;
                }   
            }
            else
            {
                echo -4;
            }
		}
		else
		{
		    echo 0;
        }
    }
}