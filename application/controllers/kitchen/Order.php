<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("Order_model","Order");
    }

    public function index($tab="") {

        $title = "Order Management";

        $this->viewData['page'] = "Order";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Order";
        $this->viewData['opentab'] = $tab;

        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');
        $PostData['kitchenid'] = $kitchenid;
        
        $where = "o.userid=".$kitchenid;
        $this->viewData['order_history'] = $this->Order->getOrders($where);

        
        $this->viewData['count_active_orders'] = $this->Order->getKitchenActiveOrders(0,0,$PostData,1);

        $where = " AND o.status=0";
        $this->viewData['count_pending_orders'] = $this->Order->getKitchenOrdersCount($kitchenid,$where);
        
        $this->viewData['count_cancelled_orders'] = $this->Order->getKitchenCancelledOrdersCount($kitchenid);
        
        $this->viewData['total_sales'] = $this->Order->getKitchenTotalEarning($kitchenid);

        $tomorrow_date = date("Y-m-d", strtotime("+ 1 day"));
        $where = " AND (oi.delivery_date = '".$tomorrow_date."')";
        $this->viewData['projected_sales_tomorrow'] = $this->Order->getKitchenTotalEarning($kitchenid,$where);
        
        $this->kitchen_headerlib->add_javascript("order","order.js");
        $this->load->view(KITCHENFOLDER . 'template', $this->viewData);
    }
    public function changeorderstatus() {
        $Postdata = $this->input->post();
        $orderid = $Postdata['orderid'];
        $status = $Postdata['status'];
        $ordertype = $Postdata['ordertype'];
        
        $modifieddate = $this->general_model->getCurrentDateTime();

        if($ordertype == "package"){
            $updatedata = array("status"=>$status);

            $this->Order->_table = "orderitems";
            $this->Order->_where = "id=".$orderid;
            $this->Order->Edit($updatedata);
        }else{
            $updatedata = array("status"=>$status,"modifieddate"=>$modifieddate);

            $this->Order->_where = "id=".$orderid;
            $this->Order->Edit($updatedata);
        }
        // $this->Order->_where = ("id=".$orderid);
        // $this->Order->Edit($updatedata);

        echo 1;
    }
    public function load_order_requests() {
        $PostData = $this->input->post();
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['kitchenid'] = $kitchenid;

        $this->viewData['order_requests'] = $this->Order->getOrdersRequests(PER_PAGE_ORDER, $offset, $PostData);

        $return['totalrows'] = $this->Order->getOrdersRequests(PER_PAGE_ORDER, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view(KITCHENFOLDER . 'order-request-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }
    public function load_active_orders() {
        $PostData = $this->input->post();
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['kitchenid'] = $kitchenid;
        
        $this->viewData['active_orders'] = $this->Order->getKitchenActiveOrders(PER_PAGE_ORDER, $offset, $PostData);

        $return['totalrows'] = $this->Order->getKitchenActiveOrders(PER_PAGE_ORDER, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view(KITCHENFOLDER . 'active-orders-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }

    public function load_upcoming_orders() {
        $PostData = $this->input->post();
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['kitchenid'] = $kitchenid;

        $this->viewData['upcoming_orders'] = $this->Order->getKitchenUpcomingOrders(PER_PAGE_ORDER, $offset, $PostData);

        $return['totalrows'] = $this->Order->getKitchenUpcomingOrders(PER_PAGE_ORDER, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view(KITCHENFOLDER . 'upcoming-orders-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }
    public function load_order_history() {
        $PostData = $this->input->post();
        $kitchenid = $this->session->userdata(base_url().'FRONTUSERID');

        $offset = (!isset($PostData['offset']))?0:$PostData['offset'];
        $PostData['kitchenid'] = $kitchenid;

        $this->viewData['order_history'] = $this->Order->getKitchenOrdersHistory(PER_PAGE_ORDER, $offset, $PostData);

        $return['totalrows'] = $this->Order->getKitchenOrdersHistory(PER_PAGE_ORDER, $offset, $PostData, "1");
        
        $return['html'] = $this->load->view(KITCHENFOLDER . 'order-history-ajax-data', $this->viewData, true);

        echo json_encode($return);
    }
    
}