<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Foodies_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        // $this->checkUserSession();
        $this->load->model("User_model","User");
    }

    public function index() {

        $title = "Home";

        $this->viewData['page'] = "Home";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Home";
        $this->viewData['headerclass'] = "deliverHeader";

        $this->viewData['totalkitchenrecords'] = $this->User->countKitchenFoodList();
        
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
            $this->session->set_userdata(array("redirect_url" => FRONT_URL));
        }
        $this->foodies_headerlib->add_javascript("moment","moment.js");
        $this->foodies_headerlib->add_javascript("home","home.js");
        $this->load->view('template', $this->viewData);
    }
    
}