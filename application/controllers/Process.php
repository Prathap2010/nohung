<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
    }

    public function getCityData(){
		$PostData = $this->input->post();
  
        $this->load->model("City_model","City");
        $cities = $this->City->getCityByProvince($PostData['provinceid']);
		echo json_encode($cities);
	}
}