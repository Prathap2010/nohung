<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search_kitchen extends Foodies_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        // $this->checkUserSession();
        $this->load->model("User_model","User");
    }

    public function index() {

        $title = "Search Kitchen";

        $this->viewData['page'] = "Search_kitchen";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Search_kitchen";
        $this->viewData['headerclass'] = "deliverHeader";

        $this->viewData['totalkitchenrecords'] = $this->User->countKitchenFoodList();
        
        if($this->viewData['is_logged_in'] == 1){
            $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
            
            $this->load->model("Order_model","Order");
            $this->viewData['todays_order'] = $this->Order->getFoodiesTodayOrder($foodiesid);

            $this->viewData['order_deliver'] = $this->Order->getFoodiesStartedDeliveryOrder($foodiesid);

            // echo "<pre>";print_r($this->viewData['order_deliver']); exit;
        }

        if(!empty($this->session->flashdata('payment_status'))){
            if($this->session->flashdata('payment_status') == "success"){
                $this->viewData['is_payment_success'] = 1;
            }
            if($this->session->flashdata('payment_status') == "failed"){
                $this->viewData['is_payment_failed'] = 1;
            }
        }
        if (!empty($this->session->userdata(base_url() . 'FOODIESUSERID'))) {
            $this->session->unset_userdata("redirect_url");
        } else {
            if(isset($_GET['mealtpye'])){
                $this->session->set_userdata(array("redirect_url" => FRONT_URL . 'search-kitchen?mealtpye=' . $_GET['mealtpye']));
            }else{
                $this->session->set_userdata(array("redirect_url" => FRONT_URL . 'search-kitchen'));
            }
        }
        $this->foodies_headerlib->add_javascript("moment","moment.js");
        $this->foodies_headerlib->add_javascript("home", "search_kitchen.js");
        $this->load->view('template', $this->viewData);
    }
      
    public function loadkitchendata() {
        $PostData = $this->input->post();
        
        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        $PostData['customer_id'] = !empty($foodiesid) ? $foodiesid : "";
        $kitchendata = $this->User->getKitchenFoodList(PER_PAGE_KITCHEN, $offset, $PostData);
        
        $this->viewData['kitchendata'] = $kitchendata;
        $this->viewData['cust_location'] = $PostData['cust_location'];
        
        $return['totalrows'] = $this->User->getKitchenFoodList(PER_PAGE_KITCHEN, $offset, $PostData, "1");
        
        
        $return['html'] = $this->load->view('kitchen-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }

    public function cancel_meal(){
        $PostData = $this->input->post();

        $query = $this->db->select("id,delivery_date,delivery_fromtime")->from("orderitems")->where("id = '".$PostData['orderitemsid']."'")->get();
        $meal = $query->row_array();

        // Current date and time
        $currentdatetime = date("Y-m-d H:i:s");
        $delivery_datetime = date("Y-m-d H:i:s", strtotime($meal['delivery_date']." ".$meal['delivery_fromtime']));
        $timestamp = strtotime($delivery_datetime);
        $time = $timestamp - (4 * 60 * 60);
        $delivery_datetime = date("Y-m-d H:i:s", $time);
        
        if(strtotime($currentdatetime) < strtotime($delivery_datetime)){

            $this->load->model("Order_model","Order");
            $this->Order->_table = "orderitems";    
            $this->Order->_where = array("id"=>$PostData['orderitemsid']);
            $this->Order->Edit(array("status"=>4));

            echo 1;
        }else{
            echo 0;
        }
                
    }
}