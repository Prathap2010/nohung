<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public $viewData = array();
	function __construct(){
        parent::__construct();
        $this->viewData = $this->getUserSettings("Dashboard");
        $this->load->model('Dashboard_model',"Dashboard");
		
	}
	public function index(){
		$this->viewData['title'] = "Dashboard";
        $this->viewData['module'] = "Dashboard";
		
		$this->load->model('User_model',"User");
		$this->viewData['totalkitchens'] = $this->User->getUserCount(array("usertype"=>0));
		$this->viewData['totalfoodies'] = $this->User->getUserCount(array("usertype"=>1));
		$this->viewData['totalriders'] = $this->User->getUserCount(array("usertype"=>2));
		
		$this->load->model('Order_model',"Order");
		$this->viewData['totalorders'] = $this->Order->getOrderCount();
		$this->viewData['totalactiveorders'] = $this->Order->getOrderItemsCount(array("((o.ordertype='trial' AND o.status IN (1,3,4,5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,2,5))) AND oi.delivery_date=CURDATE()"=>null));
		$this->viewData['totalcompleteorders'] = $this->Order->getOrderItemsCount(array("((o.ordertype='trial' AND o.status=6) OR (o.ordertype='package' AND o.status=1 AND oi.status=3))"=>null));
		$this->viewData['totalcancelorders'] = $this->Order->getOrderItemsCount(array("((o.ordertype='trial' AND o.status=7) OR (o.ordertype='package' AND o.status=1 AND oi.status=4))"=>null));
		$this->viewData['totalrejectorders'] = $this->Order->getOrderCount(array("status"=>3));

		$this->admin_headerlib->add_javascript("dashboard","pages/dashboard.js");
		$this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
}
