<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
    }

    public function index() {

        $title = "Forgot Password";

        $this->viewData['page'] = "Forgot_password";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Forgot_password";

        $this->load->view(KITCHENFOLDER . 'Forgot_password', $this->viewData);
    }

    public function forgot_password(){
        $emailid =  $this->input->get_post('email');  

        $this->load->model('User_model', 'User');
        $this->User->_fields = "id,kitchenname,email,status";
		$this->User->_where = array("email"=>$emailid);
        $Check = $this->User->getRecordsById();

        if($Check){

            $code = $this->general_model->random_strings(8);
            $link = '<a href="'.KITCHEN_URL.'reset-password/'.$code.'">Click hear to reset password.</a>';
            $MessageArr = array("{logo}" => '<a href="'.DOMAIN_URL.'"><img src="'.SETTING.SITE_LOGO.'" style="width:auto;height:60px;"></a>',
								"{kitchenname}" => $Check['kitchenname'],
                                "{resetpasswordlink}" => $link,
								"{sitename}"=>SITE_NAME,
								"{siteemail}"=>SITE_EMAIL,
							);
            $emailtype = array_search("Reset Password", $this->Emailtype);
            
            $this->insertauthverification($Check['id'],$code);
            
            $send = $this->User->sendMail($emailtype, $Check['email'], $MessageArr);
            if($send){
                echo 1;
            }else{
                echo 2;
            }
        }else{
            echo 0;
        }
    }
    public function insertauthverification($id,$code){
		
		$userid = $id;
		$this->load->model('User_model', 'User');
		$this->User->_table = 'authverification';
		$this->User->_fields = '*';
        $this->User->_where = array('userid'=>$id, 'status'=>0);
		$data = $this->User->getRecordsById();

		$createddate = $this->general_model->getCurrentDateTime();
		if(!empty($data)){
			
			$updatedata = array('code'=>$code,
								'createddate'=>$createddate);

			$this->User->_where = array('id'=>$data['id']);
			$this->User->Edit($updatedata);

		}else{
			$insertdata=array('userid'=>$userid,
                            'code'=>$code,
                            'createddate'=>$createddate);

			$this->User->Add($insertdata);
		}
	}
}