<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Withdraw_payment extends Admin_Controller {

    public $viewData = array();
    
    function __construct() {
        parent::__construct();
        $this->viewData = $this->getUserSettings('Withdraw_payment');
        $this->load->model('Withdraw_payment_model', 'Withdraw_payment');
    }

    public function index() {
        
        $this->viewData['title'] = "Withdraw Payment";
        $this->viewData['module'] = "withdraw_payment/Withdraw_payment";

        $this->viewData['withdrawpaymentdata'] = $this->Withdraw_payment->getWithdrawPaymentList(); 

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
       
        $this->Withdraw_payment->_where = array("id" => $id);
        $this->Withdraw_payment->Edit($updateData);

        echo 1;
	}
}

?>