<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
    }

    public function index() {

        $title = "Login";

        $this->viewData['page'] = "login";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Login";

        // $this->frontend_headerlib->add_javascript("home","js/home.js");
        $this->load->view(KITCHENFOLDER . 'Login', $this->viewData);
    }

    public function verify_user(){

		$PostData = $this->input->post();
		$kitchenid = trim($PostData['kitchenid']);
		$password = trim($PostData['password']);

        $this->load->model('User_model', 'User');
		$Check = $this->User->CheckUserLogin($kitchenid,$password);

        if($Check){
            if($Check['usertype']==0){
                if($Check['status']==1){
                    if($Check['userstatus']==1){
                    
                        $userdata = array(
                            base_url().'FRONTUSERID' => $Check['id'],
                            base_url().'FRONTKITCHENID' => $Check['kitchenid'],
                            base_url().'FRONTKITCHENNAME' => $Check['kitchenname'],
                            base_url().'FRONTKITCHENADDRESS' => $Check['address'],
                            base_url().'FRONTUSEREMAIL' => $Check['email'],
                            base_url().'FRONTKITCHENPROFILEIMAGE' => $Check['profile_image'],
                        );
                        $this->session->set_userdata($userdata);
                        echo 1;
                    }else{
                        echo 3;
                    }
                }else{
                    echo 2;
                }
            }
            else
            {
                echo 4;
            }
		}
		else
		{
		    echo 0;
        }
    }
}