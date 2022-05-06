<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->load->model('User_model', 'User');
    }

    public function index($code) {

        $code = urldecode($code);
		$resetdata = $this->User->resetpassworddata($code);
        
		if(empty($resetdata)){
			redirect('/');
		}else{
			$title = "Reset Password";
    
            $this->viewData['page'] = "reset_password";
            $this->viewData['title'] = $title;
            $this->viewData['module'] = "Reset_password";
    
            $this->viewData['resetdata'] = $resetdata;
            
            $this->load->view(KITCHENFOLDER . 'Reset_password', $this->viewData);
		}
    }
    public function update_password(){
		
		$password = $this->input->get_post('password');
		$userid = $this->input->get_post('userid');
		$authid = $this->input->get_post('authid');

		$this->User->_table = 'user';
		$this->User->_where = array('id'=>$userid);
		$this->User->Edit(array('password'=>$password));

		$this->User->_table = 'authverification';
		$this->User->_where = array('id'=>$authid);
		$this->User->Edit(array('status'=>1));
		
		echo 1;
	}
}