<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Track_deliveries extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("Order_model","Order");
        $this->load->model("User_model","User");
    }

    public function index() {

        $title = "Track Deliveries";

        $this->viewData['page'] = "Track_deliveries";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Track_deliveries";

        $userid = $this->session->userdata(base_url().'FRONTUSERID');
        
        $this->viewData['active_delivery_orders'] = $this->Order->getKitchenActiveDeliveriesOrders($userid);
        
        $this->viewData['kitchendata'] = $this->User->getUserDataByID($userid);

        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }
}