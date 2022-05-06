<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Admin_Controller {

    public $viewData = array();
    public $Emailformattype ;

    function __construct() {
        parent::__construct();
        $this->viewData = $this->getUserSettings('Order');
        $this->load->model('Order_model', 'Order');
    }

    public function index() {
        
        $this->viewData['title'] = "Order";
        $this->viewData['module'] = "order/Order";

        $this->viewData['orderdata'] = $this->Order->getOrders(); 

        $this->load->view(ADMINFOLDER . 'template', $this->viewData);
    }

    public function view_order($id){

		$this->viewData['title'] = "View Order";
        $this->viewData['module'] = "order/View_order";

        $this->viewData['orderdata'] = $this->Order->getOrderDetailsByID($id);

        $this->load->view(ADMINFOLDER.'template',$this->viewData);
	}
}

?>