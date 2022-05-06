<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Admin_Controller {

	public $viewData = array();
	function __construct() {
		parent::__construct();
		
		$this->viewData = $this->getLoginSettings();
	}
	public function index() {
		$this->viewData['title'] = "Login";
		$this->load->view(ADMINFOLDER.'Login', $this->viewData);
	}
	public function check_login() {
        
        $emailid =  $this->input->get_post('email');
		$password = $this->input->get_post('password');

        $this->load->model('User_model', 'User');
		$Check = $this->User->CheckAdminLogin($emailid,$password);
        $json = array();
		
		if($Check){
			
			$userdata = array(
				base_url().'USERLOGIN' => TRUE,
				base_url().'USERID' => $Check['id'],
				base_url().'USERNAME' => $Check['firstname']." ".$Check['lastname'],
				base_url().'USEREMAIL' => $Check['email'],
				base_url().'USERPROFILE' => $Check['image'],
			);
			$this->session->set_userdata($userdata);
			$json = array('error'=>1);
		}
		else
		{
		    $json = array('error'=>0);
        }
        echo json_encode($json);
	}
}
