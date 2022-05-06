<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("Order_model","Order");
        $this->load->model("User_model","User");
    }

    public function index() {

        $title = "Payment";

        $this->viewData['page'] = "Payment";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Payment";

        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $this->viewData['total_earning'] = $this->Order->getKitchenTotalEarning($kitchenid);

        $this->viewData['kitchendata'] = $this->User->getUserDataByID($kitchenid);


        $this->viewData['kitchen_wallet'] = $this->Order->getKitchenWalletBalance($kitchenid);

        $this->viewData['walletdata'] = $this->User->getKitchenWalletData($kitchenid);
        
        $this->User->_table = "kitchenaccount";
        $this->User->_where = array("kitchen_id"=>$kitchenid);
        $CountAccount = $this->User->CountRecords();
        
        $this->viewData['account_available'] = ($CountAccount > 0) ? 1 : 0; 

        $this->kitchen_headerlib->add_javascript("payment","payment.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }
    
    public function load_transaction_history() {
        $PostData = $this->input->post();
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['kitchenid'] = $kitchenid;

        $this->viewData['transaction_history'] = $this->Order->getKitchenTransactionHistory(PER_PAGE_TRANSACTION, $offset, $PostData);

        $return['totalrows'] = $this->Order->getKitchenTransactionHistory(PER_PAGE_TRANSACTION, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view(KITCHENFOLDER . 'transaction-history-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }

    public function add_bank_account() {
        $PostData = $this->input->post();
        $kitchen_id = $this->session->userdata(base_url().'FRONTUSERID');
        $account_name = trim($PostData['account_name']);
		$bank_name = trim($PostData['bank_name']);
        $ifsc_code = trim($PostData['ifsc']);
		$account_number = trim($PostData['account_number']);
        $createddate = $this->general_model->getCurrentDateTime();

        $account_number = $this->general_model->encrypt($account_number);
        $ifsc_code = $this->general_model->encrypt($ifsc_code);

        $this->User->_table = "kitchenaccount";
        $this->User->_where = array("kitchen_id"=>$kitchen_id, "account_number"=>$account_number);
        $Count = $this->User->CountRecords();
        
        if ($Count == 0) {

            $insertdata = array(
                "kitchen_id"=>$kitchen_id,
                "account_name" => $account_name,
                "bank_name" => $bank_name,
                "ifsc_code" => $ifsc_code,
                "account_number" => $account_number,
                "createddate" => $createddate,
                "modifieddate" => $createddate);
            
            $Add = $this->User->Add($insertdata);

            if ($Add) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 2;
        }
    }

    public function send_withdrawal_request() {
        $PostData = $this->input->post();
        $kitchen_id = $this->session->userdata(base_url().'FRONTUSERID');
        $withdrawal_amount = trim($PostData['withdrawal_amount']);

        // $kitchendata = $this->User->getUserDataByID($kitchen_id);
        $kitchen_wallet = $this->Order->getKitchenWalletBalance($kitchen_id);

        if($withdrawal_amount <= $kitchen_wallet){
            $wallet = $kitchen_wallet - $withdrawal_amount;

            /*$update_array = array(
                "wallet"       => $wallet,
                "modifieddate" => date("Y-m-d H:i:s")
            );
            $this->User->_where = array("id"=>$kitchen_id);
            $this->User->Edit($update_array);*/

            $insert_array = array(
                "kitchen_id"  => $kitchen_id,
                "amount"      => $withdrawal_amount,
                "wallet_amount" => $wallet,
                "createddate" => date("Y-m-d H:i:s"),
                "modifieddate" => date("Y-m-d H:i:s")
            );

            $this->User->_table = "kitchenwithdrawpayment";
            $this->User->Add($insert_array);
            
            echo 1;
        }else{
            echo 0;
        }
    }
}