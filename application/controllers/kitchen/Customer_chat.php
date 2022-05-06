<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_chat extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("Rider_model","Rider");
    }

    public function index() {

        $title = "Customer Chat";

        $this->viewData['page'] = "Customer_chat";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Customer_chat";

        $this->kitchen_headerlib->add_javascript("customer_chat","customer_chat.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }
    public function get_recent_riders() {
        
        $userid = $this->session->userdata(base_url().'FRONTUSERID');
        $riderslist = $this->Rider->getKitchenRecentRidersList($userid); 

        echo json_encode($riderslist);
    }
    public function get_rider_chat(){
        $PostData = $this->input->post();
        $riderid = trim($PostData['riderid']);
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $this->Rider->unReadKitchenChat($kitchenid,$riderid);

        $this->Rider->_table = "user";
        $rider = $this->Rider->getRiderDataByID($riderid);
        $chat = $this->Rider->getKitchenorRiderChat($kitchenid,$riderid); 

        $return = array(
            "riderid"=>$rider['id'],
            "ridername"=>$rider['kitchenname'],
            "email"=>$rider['email'],
            "mobilenumber"=>$rider['mobilenumber'],
            "chat"=>$chat,
        );
        echo json_encode($return);
    }
    public function add_chat_message() {
        $PostData = $this->input->post();
		$riderid = trim($PostData['riderid']);
		$message = trim($PostData['message']);
        $msg_type = "kitchentofoodies";
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $insertdata = array(
            "msg_type"	=> $msg_type,
            "foodiesid"	=> $riderid,
            "kitchenid"	=> $kitchenid,
            "message"	=> $message,
            "isread"	=> 'n',
            "createddate"=> $this->general_model->getCurrentDateTime()
        );

        $this->Rider->_table = "kitchenmessages";
        $this->Rider->Add($insertdata);

        echo 1;
    }
}