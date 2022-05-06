<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("Feedback_model","Feedback");
        $this->load->model("User_model","User");
    }

    public function index() {

        $title = "Feedback";

        $this->viewData['page'] = "Feedback";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Feedback";

        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $this->viewData['rating_data'] = $this->Feedback->getKitchenOverallRatings($kitchenid);
        
        $this->kitchen_headerlib->add_javascript("feedback","feedback.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }

    public function get_reviews() {
        $PostData = $this->input->post();
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['kitchen_id'] = $kitchenid;

        $this->viewData['reviews'] = $this->Feedback->getKitchenFeedback(PER_PAGE_FEEDBACK, $offset, $PostData);

        $return['totalrows'] = $this->Feedback->getKitchenFeedback(PER_PAGE_FEEDBACK, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view(KITCHENFOLDER . 'feedback-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }
}