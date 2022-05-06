<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends Foodies_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();

        $this->load->model("User_model","User");
        $this->load->model("Order_model","Order");
        
        $arrSessionDetails = $this->session->userdata;
        if(isset($arrSessionDetails) && empty($arrSessionDetails[base_url().'FOODIESUSERID'])){
            if($this->uri->segment(2) == "payment-success" || $this->uri->segment(2) == "payment-failure"){
                $PostData = $this->input->post();
                log_message("ERROR", "RES - ".json_encode($PostData));
                if(isset($PostData["udf1"])){
                    $orderid = str_replace(ORDER_PREFIX, "", $PostData["udf1"]);
                    $this->Order->_table = "transaction";
                    $this->Order->_where = array("order_id"=>$orderid,"payment_type"=>"order","payment_method"=>"payumoney");
                    $txndata = $this->Order->getRecordsById();

                    $foodiesdata = $this->User->getUserDataByID($txndata['userid']);

                    $userdata = array(
                        base_url().'FOODIESUSERID' => $foodiesdata['id'],
                        base_url().'FOODIESMOBILENO' => $foodiesdata['mobilenumber'],
                        base_url().'FOODIESFULLNAME' => $foodiesdata['kitchenname'],
                        base_url().'FOODIESEMAIL' => $foodiesdata['email'],
                        base_url().'FOODIESPROFILEIMAGE' => $foodiesdata['profile_image'],
                    );
                    $this->session->set_userdata($userdata);
                }

            }
        }
        $this->checkUserSession();
    }

    public function index() {

        $title = "Checkout";

        $this->viewData['page'] = "Checkout";
        $this->viewData['title'] = $title;
        $this->viewData['module'] = "Checkout";
        $this->viewData['headerclass'] = "deliverHeader";
        
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        $this->viewData['foodiesdata'] = $this->User->getUserDataByID($foodiesid);

        $cartdata = $this->getCartItems($foodiesid);
        $kitchen_id = !empty($cartdata)?$cartdata[0]['kitchen_id']:0;
        
        $this->viewData['kitchendata'] = $this->User->getUserDataByID($kitchen_id);
        
        // $this->foodies_headerlib->add_javascript("creditcardValidator","creditcardValidator.js");
        $this->foodies_headerlib->add_javascript("checkout","checkout.js");
        $this->load->view('template', $this->viewData);
    }

    public function check_offer_code() {
        $PostData = $this->input->post();
        $kitchen_id = $PostData['kitchen_id'];
        $offercode = $PostData['offercode'];
        $orderamount = $PostData['orderamount'];
        
        $this->load->model("Offer_model","Offer");
        $Offerdata = $this->Offer->getOfferDataByOffercode($kitchen_id, $offercode);

        $return = array();
        if(!empty($Offerdata)){
            if($Offerdata['usagelimit'] == 0 || $Offerdata['countusage'] < $Offerdata['usagelimit']){
                $starttime = date('Y-m-d H:i:s', strtotime($Offerdata['startdate']." ".$Offerdata['starttime']));
                $endtime = date('Y-m-d H:i:s', strtotime($Offerdata['enddate']." ".$Offerdata['endtime']));
                $currenttime = $this->general_model->getCurrentDateTime();
                
                if($starttime <= $currenttime && $endtime >= $currenttime){

                    $discounttype = $Offerdata['discounttype'];

                    if($discounttype==0){
                        $discountamount = $orderamount * $Offerdata['discount'] / 100;
                    }else{
                        $discountamount = $Offerdata['discount'];
                    }
                    $return = array("type"=>1,"msg"=>"Offer code applied successfully.","discount"=>number_format($discountamount,2,'.',''));
                }else{
                    $return = array("type"=>0,"msg"=>"Offer code expired !");
                }
            }else{
                $return = array("type"=>0,"msg"=>"Offer code usage limit reached !");
            }
        }else{
            $return = array("type"=>0,"msg"=>"Offer code not valid !");
        }
        echo json_encode($return);
    }

    public function place_order() {
        $PostData = $this->input->post();
        
        $wallet_payment_method = isset($PostData['wallet_payment_method'])?1:0;
        $payment_method = isset($PostData['payment_method'])?$PostData['payment_method']:"";
        $deliveryaddress = $PostData['deliveryaddress'];
        $deliverylatitude = $PostData['deliverylatitude'];
        $deliverylongitude = $PostData['deliverylongitude'];
        $orderingforname = $PostData['orderingforname'];
        $orderingformobileno = $PostData['orderingformobileno'];
        $delivery_time = "";
        $transaction_id = ""; 

        $offercode = $PostData['offercode'];
        $tax = $PostData['tax'];
        $tax_amount = $PostData['tax_amount'];
        $delivery_charge = $PostData['delivery_charge'];
        $coupon_ammount = $PostData['coupon_ammount'];
        $netamount = $PostData['sub_total'];
        $orderamount = $netamount - $coupon_ammount - $delivery_charge - $tax_amount;

        $createddate = $this->general_model->getCurrentDateTime();
        $currentdate = $this->general_model->getCurrentDate();
        
        $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');
        $customer_name = $this->session->userdata(base_url().'FOODIESFULLNAME');
        $customer_mobileno = $this->session->userdata(base_url().'FOODIESMOBILENO');
        $kitchen_id = isset($PostData['kitchen_id'][0])?$PostData['kitchen_id'][0]:0;
        $foodiesdata = $this->User->getUserDataByID($foodiesid);

        $amountpay_to_wallet = $transaction_amount = 0;    
        if($wallet_payment_method==1){
            if($foodiesdata['wallet'] <= $netamount){
                $amountpay_to_wallet = $foodiesdata['wallet'];    
            }else if($foodiesdata['wallet'] > $netamount){
                $amountpay_to_wallet = $netamount;    
            }
            $paymentmethod = 0;
        }
        if($payment_method == '1'){
            $paymentmethod = 1; //payumoney

            if($wallet_payment_method == 1){
                $transaction_amount = $netamount - $amountpay_to_wallet;
            }else{
                $transaction_amount = $netamount;
            }
        }else{
            $paymentmethod = 0; //wallet
        }
        $return = array();
        
        $this->load->model("Order_model","Order");
        duplicate : $ordernumber = generate_token(8, true);
        $this->Order->_where = array("orderid"=>$ordernumber);
        $Count = $this->Order->CountRecords();
        
        if($Count == 0){

            $this->load->model("Cart_model","Cart");
            $cart_data = $this->Cart->getCartItemsByFoodiesID($foodiesid);
            
            if(!empty($cart_data)){

                $type_arr = array_column($cart_data, "mealtype");

                $ordertype = in_array("trial", $type_arr) ? 'trial' : 'package';
                $packagetype = "";
                
                if($ordertype=="package"){
                    $weeklypackagetype = in_array("weekly", $type_arr) ? 'weekly' : '';
                    $monthlypackagetype = in_array("monthly", $type_arr) ? 'monthly' : '';
                    if($weeklypackagetype != "" && $monthlypackagetype != ""){
                        $packagetype = "both";
                                }else if($weeklypackagetype == "weekly" && $monthlypackagetype == ""){
                        $packagetype = "weekly";
                    }else if($weeklypackagetype == "" && $monthlypackagetype == "monthly"){
                        $packagetype = "monthly";
                    }
                }

                $insert_array = array(
                    "customerid"    => $foodiesid,
                    "userid"        => $kitchen_id,
                    "ordertype"     => $ordertype,
                    "packagetype"   => $packagetype,  
                    "orderid"       => $ordernumber,
                    "orderdate"     => $currentdate,
                    "customer_name"      => $customer_name,
                    "customer_mobileno"  => $customer_mobileno,
                    "orderingforname"    => $orderingforname,
                    "orderingformobileno"=> $orderingformobileno,
                    "deliveryaddress"    => $deliveryaddress,
                    "deliverylatitude"   => $deliverylatitude,
                    "deliverylongitude"  => $deliverylongitude,                
                    "delivery_time" => $delivery_time,                
                    "paymentmethod" => $paymentmethod,
                    "orderamount"   => $orderamount,
                    "taxamount"     => $tax_amount,
                    "deliverycharge"=> $delivery_charge,
                    "couponcode"    => $offercode,
                    "couponamount"  => $coupon_ammount,
                    "netamount"     => $netamount,               
                    "status"        => 0,
                    "createddate"   => $createddate,   
                    "modifieddate"  => $createddate,   
                );
                
                $order_id = $this->Order->Add($insert_array);
                // $order_id = 13;
                if($order_id){
                    
                    foreach($cart_data as $key => $value) {

                        $total_amount = 0;
                        if($value['mealtype'] == 'trial'){
                            $total_amount += ($value['item_price'] * $value['quantity']);

                            $delivery_date = date("Y-m-d");
                            $delivery_fromtime = date("H:i:s");
                            $delivery_totime = '23:59:59';
                        }else{
                            $total_amount += $value['item_price'];

                            $delivery_date = $value['delivery_date'];
                            $delivery_fromtime = $value['delivery_fromtime'];
                            $delivery_totime = $value['delivery_totime'];
                        }

                        $insert_array = array(
                            "order_id"          => $order_id,
                            "mealplan"          => $value['type'],
                            "reference_id"      => $value['typeid'],
                            "item_name"         => $value['name'],
                            "cuisinetype"       => $value['cuisinetype'],
                            "quantity"          => $value['quantity'],
                            "item_price"        => $value['item_price'],
                            "total_amount"      => $total_amount,
                            "delivery_date"     => $delivery_date,
                            "delivery_fromtime" => $delivery_fromtime,
                            "delivery_totime"   => $delivery_totime,
                            "including_saturday"=> $value['including_saturday'],
                            "including_sunday"  => $value['including_sunday'],
                            "status"            => 5
                        );
                        
                        $this->Order->_table = "orderitems";
                        $orderitems_id = $this->Order->Add($insert_array);

                        if($orderitems_id){

                            if($value['type'] != 2){

                                $menu_item = $this->Cart->getCartItemsofPackageByCartID($value['id']);

                                if (count($menu_item) > 0){

                                    $items_array = array();
                                    foreach($menu_item as $val){

                                        $items_array[]= array(
                                            "orderitems_id" => $orderitems_id,
                                            "menuid"        => $val['menuid'],
                                            "itemname"      => $val['itemname'],
                                            "qty"           => $val['qty'],
                                            "price"         => $val['item_price']
                                        );

                                    }

                                    if(!empty($items_array)){
                                        $this->Order->_table = "order_package_menu_items";
                                        $this->Order->add_batch($items_array);
                                    }
                                }

                                $this->Order->_table = "order_customized_package_item";
                                $this->Order->Delete(array("userid"=>$foodiesid,"packageid"=>$value['typeid']));
                            }
                        
                        }
                    }
                
                    // $this->User->_table = 'cart';
                    // $this->User->Delete(array("user_id"=>$foodiesid));

                    $this->Order->_table = "transaction";

                    if($wallet_payment_method == 1 && $amountpay_to_wallet > 0){
                        // Wallet History
                        $transaction_array = array(
                            "userid"            =>  $foodiesid,
                            "order_id"          =>  $order_id,
                            "order_number"      =>  $ordernumber,
                            "transaction_id"    =>  '',
                            "amount"            =>  $amountpay_to_wallet,
                            "transaction_status"=>  'success',
                            "payment_type"      =>  'order',
                            "payment_method"    =>  'wallet',
                            "createddate"       =>  date("Y-m-d H:i:s"),   
                        );

                        $this->Order->Add($transaction_array);

                        $wallet = ($foodiesdata['wallet'] - $amountpay_to_wallet);
                        $update = array("wallet"=>$wallet);
                        $this->User->Edit($update);                    
                    }
                    if($payment_method == 1 && $transaction_amount > 0){
                        // Transaction History
                        $transaction_array = array(
                            "userid"            =>  $foodiesid,
                            "order_id"          =>  $order_id,
                            "order_number"      =>  $ordernumber,
                            "transaction_id"    =>  $transaction_id,
                            "amount"            =>  $transaction_amount,
                            "transaction_status"=>  'success',
                            "payment_type"      =>  'order',
                            "payment_method"    =>  'payumoney',
                            "createddate"       =>  date("Y-m-d H:i:s"),   
                        );

                        $this->Order->Add($transaction_array);
                    }
                    
                    if($wallet_payment_method==1 && $paymentmethod == 0){
                        $this->load->model("Cart_model","Cart");
                        $this->Cart->_table = "cart_package_menu_items";
                        $this->Cart->Delete("cart_id IN (SELECT id FROM cart WHERE user_id=".$foodiesid.")");

                        $this->Cart->_table = 'cart';
                        $this->Cart->Delete(array("user_id"=>$foodiesid));
                    }
                    $return = array("type"=>1,
                        "msg"=>"Order placed successfully !",
                        "order_id"=>$order_id,
                        "order_number"=>$ordernumber,
                        "netamount"=>$netamount,
                        "customer_name"=>$customer_name,
                        "customer_mobileno"=>$customer_mobileno,
                    );
                }else{
                    $return = array("type"=>0,"msg"=>"Order not placed !");
                }
            }
            echo json_encode($return);
        }else{
            goto duplicate;
        }


    }

    public function payment(){
        $PostData = $this->input->post();

        log_message("ERROR", "INIT - ".json_encode($PostData));
        
        $PostData['paymentdetail'] = array(
            'key' => PAYU_MERCHANT_KEY,
            'txnid' => substr(hash('sha256', mt_rand() . microtime()), 0, 20),
            'service_provider' => "service_provider",
            'amount' => number_format($PostData['amount'],2,'.',''),
            'firstname' => $PostData['firstname'],
            'email' => $PostData['email'],
            'phone' => $PostData['phone'],
            'address1' => $PostData['address1'],
            'productinfo' => 'Kitchen',
            'surl' => FRONT_URL.'checkout/payment-success',
            'furl' => FRONT_URL.'checkout/payment-failure',
            'hash' => '',
            'udf1' => ORDER_PREFIX.$PostData['order_id'],
        );
        
        $this->load->view('Payumoneyform', $PostData);
    }

    public function payment_success(){
        $PostData = $this->input->post();
        
        // echo "<pre>"; print_r($PostData); exit;
        log_message("ERROR", "Success - ".json_encode($PostData));

        if(!empty($PostData) && $PostData['status'] == "success"){
            
            $amount = $PostData["amount"];
            $txnid = $PostData["txnid"];
            $orderid = str_replace(ORDER_PREFIX, "", $PostData["udf1"]);
            
            
            $this->Order->_table = "transaction";
            $this->Order->_where = array("order_id"=>$orderid,"payment_type"=>"order","payment_method"=>"payumoney");
            $txndata = $this->Order->getRecordsById();

            if(!empty($txndata)){
                $this->Order->_where = array("id"=>$txndata['id']);
                $this->Order->Edit(array("transaction_id"=>$txnid,"amount"=>$amount,"transaction_status"=>"success"));
            }

            $foodiesid = $this->session->userdata(base_url().'FOODIESUSERID');

            $this->load->model("Cart_model","Cart");
            $this->Cart->_table = "cart_package_menu_items";
            $this->Cart->Delete("cart_id IN (SELECT id FROM cart WHERE user_id=".$foodiesid.")");

            $this->Cart->_table = 'cart';
            $this->Cart->Delete(array("user_id"=>$foodiesid));
            
            $this->session->set_flashdata('payment_status', 'success');

            redirect(FRONT_URL);
        }
    }

    public function payment_failure(){
        $PostData = $this->input->post();
        
        log_message("ERROR", "Failure - ".json_encode($PostData));

        if(!empty($PostData) && $PostData['status'] == "failure"){
            $amount = $PostData["amount"];
            $txnid = $PostData["txnid"];
            $orderid = str_replace(ORDER_PREFIX, "", $PostData["udf1"]);
            
            
            $this->Order->_table = "transaction";
            $this->Order->_where = array("order_id"=>$orderid,"payment_type"=>"order","payment_method"=>"payumoney");
            $txndata = $this->Order->getRecordsById();

            if(!empty($txndata)){
                /* $this->Order->_where = array("id"=>$txndata['id']);
                $this->Order->Edit(array("transaction_id"=>$txnid,"amount"=>$amount,"transaction_status"=>"failed"));

                $this->Order->_table = "orders";
                $this->Order->_where = array("id"=>$orderid);
                $this->Order->Edit(array("status"=>7));

                $this->Order->_table = "orderitems";
                $this->Order->_where = array("order_id"=>$orderid);
                $this->Order->Edit(array("status"=>4)); */

                $this->Order->_table = "transaction";
                $this->Order->Delete(array("order_id"=>$orderid,"payment_type"=>"order"));
                
                $this->Order->_table = "orderitems";
                $this->Order->Delete(array("order_id"=>$orderid));

                $this->Order->_table = "orders";
                $this->Order->Delete(array("id"=>$orderid));
            }
            
            $this->session->set_flashdata('payment_status', 'failed');
        }
        redirect(FRONT_URL);
    }

}