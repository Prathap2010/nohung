<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kitchen_withdraw_payment extends Admin_Controller {

    public $viewData = array();
    
    function __construct() {
        parent::__construct();
        $this->viewData = $this->getUserSettings('Kitchen_withdraw_payment');
        $this->load->model('Kitchen_withdraw_payment_model', 'Kitchen_withdraw_payment');
    }

    public function index() {
        
        $this->viewData['title'] = "Kitchen withdraw Payment";
        $this->viewData['module'] = "withdraw_payment/Kitchen_withdraw_payment";

        $this->viewData['withdrawpaymentdata'] = $this->Kitchen_withdraw_payment->getWithdrawPaymentList(); 

        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    } 

    public function update_status(){
		$PostData = $this->input->post();
        $modifieddate = $this->general_model->getCurrentDateTime();
        
        $id = $PostData['id'];
        $status = $PostData['status'];
        
        $updateData = array(
            'status'=>$status,
            'modifieddate' => $modifieddate
        );  
       
        $this->Kitchen_withdraw_payment->_where = array("id" => $id);
        $this->Kitchen_withdraw_payment->Edit($updateData);

        echo 1;
	}
}

?>