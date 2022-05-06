<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Kitchen_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        $this->checkUserSession();
        $this->load->model("Order_model","Order");
    }

    public function index() {

        $title = "Dashboard";

        $this->viewData['page'] = "Dasboard";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Dasboard";

        $kitchen_id = $this->session->userdata(base_url().'FRONTUSERID');

        $this->viewData['count_active_orders'] = $this->Order->getActiveOrders($kitchen_id,-1,1);

        $where = " AND o.status=0";
        $this->viewData['count_pending_orders'] = $this->Order->getKitchenOrdersCount($kitchen_id,$where);
        
        $this->viewData['count_completed_orders'] = $this->Order->getKitchenCompletedOrdersCount($kitchen_id);
        
        $this->viewData['count_active_deliveries_orders'] = $this->Order->getKitchenActiveDeliveriesOrders($kitchen_id,1);

        $PostData['kitchenid'] = $kitchen_id;
        $this->viewData['count_upcoming_orders'] = $this->Order->getKitchenUpcomingOrders(0, 0, $PostData, 1);

        $this->viewData['count_preparing_orders'] = $this->Order->getKitchenPreparingOrdersCount($kitchen_id);
        
        $this->viewData['count_ready_to_pick_orders'] = $this->Order->getKitchenReadyToPickOrdersCount($kitchen_id);

        $this->viewData['count_out_for_delivery_orders'] = $this->Order->getKitchenOutForDeliveryOrdersCount($kitchen_id);

        $this->viewData['recent_active_orders'] = $this->Order->getActiveOrders($kitchen_id,3);

        $this->kitchen_headerlib->add_javascript("home","home.js");
        $this->load->view(KITCHENFOLDER.'template', $this->viewData);
    }

    public function get_total_sales() {
        $PostData = $this->input->post();
        $year = $PostData['year'];
        $kitchen_id = $this->session->userdata(base_url().'FRONTUSERID');

        $where = " AND YEAR(oi.delivery_date) = ".$year;
        $return_array['total_earning'] = $this->Order->getKitchenTotalEarning($kitchen_id, $where);

        $month = array();
        for($i=1; $i<=12; $i++){
            
            $where = " AND YEAR(oi.delivery_date) = ".$year." AND MONTH(oi.delivery_date) = ".$i;
            $month[] = (float)($this->Order->getKitchenTotalEarning($kitchen_id, $where));
        }

        $return_array['total_earning_in_year'] = $month;

        echo json_encode($return_array);
    }

    public function get_total_earning() {
        $PostData = $this->input->post();
        $year = $PostData['year'];
        $month = $PostData['month'];
        $kitchen_id = $this->session->userdata(base_url().'FRONTUSERID');

        $where = " AND YEAR(oi.delivery_date) = ".$year." AND MONTH(oi.delivery_date) = ".$month;
        $return_array['total_earning'] = $this->Order->getKitchenTotalEarning($kitchen_id, $where);

        $weeks_in_month = $this->weeks_in_month($month, $year);
        
        $total_weekly_earn = array();
        $day = '01';
        for($i=1; $i<=$weeks_in_month; $i++){

            $weeks_number = date("W", strtotime($year.'-'.$month.'-'.$day));
            $week_date = $this->getStartAndEndDate($weeks_number, $year);
            // print_r($week_date); 
            $where = " AND YEAR(oi.delivery_date) = '".$year."' AND MONTH(oi.delivery_date) = '".$month."'  AND (date(oi.delivery_date) BETWEEN '".$week_date['start_date']."' AND '".$week_date['end_date']."')";
            $total_weekly_earn[] = (float)($this->Order->getKitchenTotalEarning($kitchen_id, $where));

            $day += '7';
        }

        $return_array['total_earning_in_month'] = $total_weekly_earn;

        echo json_encode($return_array);
    }
    function weeks_in_month($month, $year) {
        // Start of month
        $start = mktime(0, 0, 0, $month, 1, $year);
        // End of month
        $end = mktime(0, 0, 0, $month, date('t', $start), $year);
        // Start week
        $start_week = date('W', $start);
        // End week
        $end_week = date('W', $end);
       
        if ($end_week < $start_week) { // Month wraps
          return ((52 + $end_week) - $start_week) + 1;
        }
       
        return ($end_week - $start_week) + 1;
    }
    function getStartAndEndDate($week, $year) {
        $dateTime = new DateTime();
        $dateTime->setISODate($year, $week);
        $result['start_date'] = $dateTime->format('Y-m-d');
        $dateTime->modify('+6 days');
        $result['end_date'] = $dateTime->format('Y-m-d');
        return $result;
    }
    
}