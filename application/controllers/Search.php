<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Foodies_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        // $this->checkUserSession();
        $this->load->model("User_model","User");
    }

    public function index($search="") {

        $title = "Search";

        $this->viewData['page'] = "Search";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Search";
        $this->viewData['headerclass'] = "deliverHeader";
        $this->viewData['search_text'] = $search;

        $this->viewData['totalkitchenrecords'] = $this->User->countKitchenFoodList();
       
        if($this->viewData['is_logged_in'] == 1){
            $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
            
            $this->load->model("Order_model","Order");
            $this->viewData['order_deliver'] = $this->Order->getFoodiesStartedDeliveryOrder($foodiesid);

            // echo "<pre>";print_r($this->viewData['order_deliver']); exit;
        }
        if (!empty($this->session->userdata(base_url() . 'FOODIESUSERID'))) {
            $this->session->unset_userdata("redirect_url");
        } else {
            $this->session->set_userdata(array("redirect_url" => FRONT_URL . 'search/'.$search));
        }
        $this->foodies_headerlib->add_javascript("search","search.js");
        $this->load->view('template', $this->viewData);
    }
      
    public function loadkitchendata() {
        $PostData = $this->input->post();
        
        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        $PostData['customer_id'] = !empty($foodiesid) ? $foodiesid : "";
        
        $kitchendata = $this->User->getKitchenFoodList(PER_PAGE_KITCHEN, $offset,$PostData, "0", "2");

        $this->viewData['kitchendata'] = $kitchendata;
        $this->viewData['grid'] = '2';
        $this->viewData['cust_location'] = $PostData['cust_location'];
        
        $return['totalrows'] = $this->User->getKitchenFoodList(PER_PAGE_KITCHEN, $offset, $PostData, "1", "2");
        
        $return['html'] = $this->load->view('kitchen-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }
}