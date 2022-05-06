<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Foodies_Controller {

    public $viewData = array();

    function __construct() {
        parent::__construct();
        // $this->checkUserSession();
        $this->load->model("User_model","User");
        $this->load->model("Order_model","Order");

        $arrSessionDetails = $this->session->userdata;
        if(isset($arrSessionDetails) && empty($arrSessionDetails[base_url().'FOODIESUSERID'])){
            if($this->uri->segment(2) == "success" || $this->uri->segment(2) == "failure"){
                $PostData = $this->input->post();
                
                if(isset($PostData["udf1"]) && !empty($PostData['udf5'])){
                    $id = str_replace(ORDER_PREFIX, "", $PostData["udf1"]);
                    $query = $this->db->select("d.id,d.user_id,d.amount,d.payment_status,u.kitchenname,u.email,u.mobilenumber,u.address,u.profile_image")
                        ->from("foodies_deposit_amount as d")
                        ->join("user as u","u.id=d.user_id","INNER")
                        ->where("d.id='".$id."'")
                        ->get();
                                    
                    $res = $query->row_array();

                    $userdata = array(
                        base_url().'FOODIESUSERID' => $res['user_id'],
                        base_url().'FOODIESMOBILENO' => $res['mobilenumber'],
                        base_url().'FOODIESFULLNAME' => $res['kitchenname'],
                        base_url().'FOODIESEMAIL' => $res['email'],
                        base_url().'FOODIESPROFILEIMAGE' => $res['profile_image'],
                    );
                    $this->session->set_userdata($userdata);
                }

            }
        }
    }
      
    public function make_deposit_payment($id) {
        
        $id = base64_decode($id);
        ini_set('max_execution_time', 300); 
        $query = $this->db->select("d.id,d.user_id,d.amount,d.payment_status,u.kitchenname,u.email,u.mobilenumber,u.address")
            ->from("foodies_deposit_amount as d")
            ->join("user as u","u.id=d.user_id","INNER")
            ->where("d.id='".$id."'")
            ->get();
                        
        $res = $query->row_array();

        if(!empty($res) && $res['payment_status'] != "success" && $res['amount'] > 0){

            log_message("ERROR", "INIT - ".json_encode($res));
        
            $foodiesid = !is_null($this->session->userdata(base_url().'FOODIESUSERID')) ? $this->session->userdata(base_url().'FOODIESUSERID') : "";

            $PostData['paymentdetail'] = array(
                'key' => PAYU_MERCHANT_KEY,
                'txnid' => substr(hash('sha256', mt_rand() . microtime()), 0, 20),
                'service_provider' => "service_provider",
                'amount' => number_format($res['amount'],2,'.',''),
                'firstname' => $res['kitchenname'],
                'email' => $res['email'],
                'phone' => $res['mobilenumber'],
                'address1' => $res['address'],
                'productinfo' => 'Kitchen',
                'surl' => FRONT_URL.'payment/success',
                'furl' => FRONT_URL.'payment/failure',
                'hash' => '',
                'udf1' => ORDER_PREFIX.$id,
                'udf5' => $foodiesid,
            );
            
            $this->load->view('Payumoneyform', $PostData);
            
        }else{
            redirect(FRONT_URL);
        }
        // print_r($res); exit;
    }
    

    public function success(){
        $PostData = $this->input->post();
        
        // echo "<pre>"; print_r($PostData); exit;
        log_message("ERROR", "Success - ".json_encode($PostData));

        if(!empty($PostData) && $PostData['status'] == "success"){
            
            $amount = $PostData["amount"];
            $txnid = $PostData["txnid"];
            $id = str_replace(ORDER_PREFIX, "", $PostData["udf1"]);
            
            $this->User->_table = "foodies_deposit_amount";
            $this->User->_fields = "*, IFNULL((SELECT wallet FROM user WHERE id=user_id),0) as wallet";
            $this->User->_where = array("id"=>$id);
            $resdata = $this->User->getRecordsById();

            if(!empty($resdata)){

                $data_array = array(
                    "userid" => $resdata['user_id'],
                    "transaction_id" => $txnid,
                    "amount" => $amount,
                    "transaction_status"  => 'success',
                    "payment_type"  => 'deposit',
                    "payment_method" => 'payumoney',
                    "createddate" => date("Y-m-d H:i:s")
                );

                $this->User->_table = "transaction";
                $this->User->Add($data_array);

                $this->User->_table = "user";
                $this->User->_where = array("id"=>$resdata['user_id']);
                $this->User->Edit(array("wallet"=>($resdata['wallet'] + $amount)));

                $this->User->_table = "foodies_deposit_amount";
                $this->User->_where = array("id"=>$id);
                $this->User->Edit(array("payment_status"=>'success'));

                $this->session->set_flashdata('payment_status', 'success');
            }
            
            redirect(FRONT_URL);
        }
    }

    public function failure(){
        $PostData = $this->input->post();
        
        log_message("ERROR", "Failure - ".json_encode($PostData));
        
        if(!empty($PostData) && $PostData['status'] == "failure"){
            $amount = $PostData["amount"];
            $txnid = $PostData["txnid"];
            $id = str_replace(ORDER_PREFIX, "", $PostData["udf1"]);
            
            
            $this->User->_table = "foodies_deposit_amount";
            $this->User->_where = array("id"=>$id);
            $resdata = $this->User->getRecordsById();

            if(!empty($resdata)){

                $data_array = array(
                    "userid" => $resdata['user_id'],
                    "transaction_id" => $txnid,
                    "amount" => $amount,
                    "transaction_status"  => 'failed',
                    "payment_type"  => 'deposit',
                    "payment_method" => 'payumoney',
                    "createddate" => date("Y-m-d H:i:s")
                );

                $this->User->_table = "transaction";
                $this->User->Add($data_array);

                $this->User->_table = "foodies_deposit_amount";
                $this->User->_where = array("id"=>$id);
                $this->User->Edit(array("payment_status"=>'failed'));
            }
            
            $this->session->set_flashdata('payment_status', 'failed');
        }
        redirect(FRONT_URL);
    }

    public function make_order_payment($id) {
        
        $id = base64_decode($id);

        $query = $this->db->select("p.*,u.email,c.card_number,c.valid_thru,c.card_name,c.cvv")
            ->from("temp_foodies_payment_data as p")
            ->join("user as u","u.id=p.user_id","INNER")
            ->join("cards as c","c.id=p.card_id","INNER")
            ->where("p.id='".$id."'")
            ->get();
                        
        $res = $query->row_array();
        
        if(!empty($res) && $res['payment_status'] != "success" && $res['netamount'] > 0 && $res['card_name'] != ""){
            
            $ccnum = $this->general_model->decrypt($res['card_number']);
            $ccvv = $this->general_model->decrypt($res['cvv']);
            // echo "<pre>"; print_r($ccnum); exit;
            if($ccnum=="" && $ccvv==""){
                redirect(FRONT_URL);
            }
            log_message("ERROR", "INIT - ".json_encode($res));
            // $PAYU_URL = 'https://sandboxsecure.payu.in/_payment';
            $PAYU_URL = PAYU_URL . '/_payment';
            
            $PAYU_MERCHANT_KEY = PAYU_MERCHANT_KEY;
            $PAYU_MERCHANT_SALT = PAYU_MERCHANT_SALT;
            
            $PAYU_MERCHANT_KEY = 'gtKFFx';
            $PAYU_MERCHANT_SALT = 'wia56q6O';

            $valid_thru = $this->general_model->decrypt($res['valid_thru']);
            $valid_thru = explode("/",$valid_thru);

            $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            $amount = $res['netamount']; 
            $firstname = $res['customer_name']; 
            $email = $res['email']; 
            $phone = $res['customer_mobileno']; 
            $address = $res['deliveryaddress']; 
            $furl = FRONT_URL.'payment/ord-payment-failure';
            $surl = FRONT_URL.'payment/ord-payment-success';
            $ccexpmon = $valid_thru[0];
            $ccexpyr = $valid_thru[1];
            $ccname = $res["card_name"];
            
            /* $ccnum = "5123456789012346";
            $ccexpmon = "05";
            $ccexpyr = "2022";
            $ccvv = "123";
            $ccname = "Test"; */

            $req = curl_init($PAYU_URL);
            curl_setopt($req, CURLOPT_URL, $PAYU_URL);
            curl_setopt($req, CURLOPT_POST, true); 
            curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
            $headers = array( "Content-Type: application/x-www-form-urlencoded", ); 
            curl_setopt($req, CURLOPT_HTTPHEADER, $headers);

            $hash = strtolower(hash('sha512',$PAYU_MERCHANT_KEY."|".$txnid."|".$amount."|items|".$firstname."|".$email."|".$res['id']."||||||||||".$PAYU_MERCHANT_SALT));


            // $data = "key=".$PAYU_MERCHANT_KEY."&txnid=".$txnid."&amount=".$amount."&firstname=".$firstname."&email=".$email."&udf1=".$res['id']."&phone=".$phone."&productinfo=items&pg=cc&bankcode=cc&surl=".$surl."&furl=".$furl."&service_provider=payu_paisa&address1=".$address."&ccnum=".$ccnum."&ccexpmon=".$ccexpmon."&ccexpyr=".$ccexpyr."&ccvv=".$ccvv."&ccname=".$ccname."&txn_s2s_flow=4&hash=".$hash;


            $data = "key=".$PAYU_MERCHANT_KEY."&txnid=".$txnid."&amount=".$amount."&firstname=".$firstname."&email=".$email."&udf1=".$res['id']."&phone=".$phone."&productinfo=items&pg=cc&bankcode=cc&surl=".$surl."&furl=".$furl."&address1=".$address."&ccnum=".$ccnum."&ccexpmon=".$ccexpmon."&ccexpyr=".$ccexpyr."&ccvv=".$ccvv."&ccname=".$ccname."&hash=".$hash;

            // echo $data; exit;
            curl_setopt($req, CURLOPT_POSTFIELDS, $data);
            $resp = curl_exec($req);
            
            curl_close($req);
            
            if($resp){
                echo $resp;
            }else{
                echo "Some parameters are blank or your card details is incorrect !";
            }
        }else{
            redirect(FRONT_URL);
        }
    }

    public function ord_payment_success(){
        $PostData = $this->input->post();
        
        log_message("ERROR", "Success - ".json_encode($PostData));

        if(!empty($PostData) && $PostData['status'] == "success"){
            
            $amount = $PostData["amount"];
            $txnid = $PostData["txnid"];
            $id = $PostData["udf1"];
            
            $query = $this->db->select("p.*,u.email,c.card_number,c.valid_thru,c.card_name,c.cvv")
                        ->from("temp_foodies_payment_data as p")
                        ->join("user as u","u.id=p.user_id","INNER")
                        ->join("cards as c","c.id=p.card_id","INNER")
                        ->where("p.id='".$id."'")
                        ->get();
            
            $resdata = $query->row_array();

            if(!empty($resdata)){
                
                $this->load->model("Order_model","Order");
                duplicate : $ordernumber = generate_token(8, true);
                $this->Order->_where = array("orderid"=>$ordernumber);
                $Count = $this->Order->CountRecords();

                if($Count == 0){

                    $user_id = $resdata['user_id'];
                    $kitchen_id = $resdata['kitchen_id'];
                    $customer_name = $resdata['customer_name'];
                    $customer_mobileno = $resdata['customer_mobileno'];
                    $orderingforname = $resdata['orderingforname'];
                    $orderingformobileno = $resdata['orderingformobileno'];
                    $deliveryaddress = $resdata['deliveryaddress'];
                    $deliverylatitude = $resdata['deliverylatitude'];
                    $deliverylongitude = $resdata['deliverylongitude'];
                    $orderamount = $resdata['orderamount'];
                    $taxamount = $resdata['taxamount'];
                    $deliverycharge = $resdata['deliverycharge'];
                    $couponcode = $resdata['couponcode'];
                    $couponamount = $resdata['couponamount'];
                    $netamount = $resdata['netamount'];

                    $payment_method = 1;

                    $user = $this->db->query("SELECT u.kitchenname,u.mobilenumber,u.email,u.wallet FROM user as u WHERE u.id = ".$user_id)->row_array();

                    $cart_item = $this->db->query("SELECT c.id,c.kitchen_id,c.user_id,c.type,c.typeid,c.name,c.quantity,c.createddate,c.modifieddate,
                                IF(c.type=2,IFNULL((SELECT image FROM mastermenu WHERE id=c.typeid),''),'') menuimage,

                                IF(c.type=2,
                                    IFNULL((SELECT cuisinetype FROM mastermenu WHERE id=c.typeid),''),
                                    IFNULL((SELECT cuisinetype FROM packages WHERE id=c.typeid),'')
                                ) as cuisinetype,

                                IF(c.type=2,
                                    IFNULL((SELECT itemprice FROM mastermenu WHERE id=c.typeid),0),
                                    IFNULL((SELECT (IF(c.type=0,weeklyprice,monthlyprice) + IFNULL((SELECT SUM(itemprice) FROM mastermenu WHERE id IN (SELECT menuid FROM cart_package_menu_items WHERE cart_id=c.id)),0)) FROM packages WHERE id=c.typeid),0)
                                ) as item_price,

                                CASE 
                                    WHEN c.type=2 THEN 'trial' 
                                    WHEN c.type=1 THEN 'monthly' 
                                    ELSE 'weekly'
                                END as mealtype,

                                c.including_saturday,c.including_sunday,

                                c.delivery_date,c.delivery_fromtime,c.delivery_totime,

                                getDistance(ca.latitude,ca.longitude,k.latitude,k.longitude) as distance
                            
                                FROM cart as c 
                                LEFT JOIN user as k ON k.id = c.kitchen_id
                                LEFT JOIN customer_address as ca ON ca.user_id = c.user_id AND is_delivery = 'y'
                                WHERE c.user_id = '".$user_id."'")->result_array();

                    if (count($cart_item) > 0)
                    {
                        $type_arr = array_column($cart_item, "mealtype");

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

                        $data_array = array(
                            "customerid"  => $user_id,
                            "userid"      => $kitchen_id,
                            "ordertype"   => $ordertype,
                            "packagetype" => $packagetype,  
                            "orderid"     => $ordernumber,
                            "orderdate"   => date('Y-m-d'),
                            "customer_name"      => $customer_name,
                            "customer_mobileno"  => $customer_mobileno,
                            "orderingforname"    => $orderingforname,
                            "orderingformobileno"=> $orderingformobileno,
                            "deliveryaddress"    => $deliveryaddress,
                            "deliverylatitude"   => $deliverylatitude,
                            "deliverylongitude"  => $deliverylongitude,
                            "paymentmethod" => $payment_method,    
                            "orderamount"   => $orderamount,
                            "taxamount"     => $taxamount,
                            "deliverycharge"=> $deliverycharge,
                            "couponcode"    => $couponcode,
                            "couponamount"  => $couponamount,
                            "netamount"     => $netamount,                           
                            "createddate"   => date("Y-m-d H:i:s"),
                            "modifieddate"  => date("Y-m-d H:i:s")
                        );
                        
                        $order_id = $this->Order->Add($data_array);
                        
                        if($order_id){

                            foreach ($cart_item as $key => $value) {
                                
                                $total_amount = 0;
                                if($value['mealtype'] == 'trial'){
                                    $total_amount += ($value['item_price'] * $value['quantity']);
                                }else{
                                    $total_amount += $value['item_price'];
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
                                    "delivery_date"     => $value['delivery_date'],
                                    "delivery_fromtime" => $value['delivery_fromtime'],
                                    "delivery_totime"   => $value['delivery_totime'],
                                    "including_saturday"=> $value['including_saturday'],
                                    "including_sunday"  => $value['including_sunday'],
                                    "status"            => 5
                                );

                                $this->Order->_table = "orderitems";
                                $orderitems_id = $this->Order->Add($insert_array);

                                if($orderitems_id){

                                    if($value['type'] != 2){

                                        $menu_item = $this->db->query("SELECT id,menuid,itemname,qty,IFNULL((SELECT itemprice FROM mastermenu WHERE id=menuid),'') as item_price FROM cart_package_menu_items WHERE cart_id = '".$value['id']."'")->result_array();

                                        if (count($menu_item) > 0){

                                            foreach($menu_item as $val){

                                                $items_array = array(
                                                    "orderitems_id" => $orderitems_id,
                                                    "menuid"        => $val['menuid'],
                                                    "itemname"      => $val['itemname'],
                                                    "qty"           => $val['qty'],
                                                    "price"         => $val['item_price']
                                                );

                                                $this->Order->_table = "order_package_menu_items";
                                                $this->Order->Add($items_array);
                                            }

                                        }

                                        $this->Order->_table = "order_customized_package_item";
                                        $this->Order->Delete(array("userid"=>$user_id,"packageid"=>$value['typeid']));
                                    }
                                }
                            }
                            // Transaction History
                            $transaction_array = array(
                                "userid"            =>  $user_id,
                                "order_id"          =>  $order_id,
                                "order_number"      =>  $ordernumber,
                                "transaction_id"    =>  $txnid,
                                "amount"            =>  $netamount,
                                "transaction_status"=>  'success',
                                "payment_type"      =>  'order',
                                "payment_method"    =>  'payumoney',
                                "createddate"       =>  date("Y-m-d H:i:s"),   
                            );

                            $this->Order->_table = "transaction";
                            $this->Order->Add($transaction_array);

                            $this->Order->_table = "cart_package_menu_items";
                            $this->Order->Delete(array("cart_id IN (SELECT id FROM cart WHERE user_id=".$user_id.")"=>null));

                            $this->Order->_table = "cart";
                            $this->Order->Delete(array("user_id"=>$user_id));

                        }
                    }
                }else{
                    goto duplicate;
                }
                
                $this->User->_table = "temp_foodies_payment_data";
                $this->User->Delete(array("id"=>$id));

                $this->session->set_flashdata('payment_status', 'success');
            }
            
            redirect(FRONT_URL);
        }
    }
    public function ord_payment_failure(){
        $PostData = $this->input->post();
        
        log_message("ERROR", "Failure - ".json_encode($PostData));
        
        if(!empty($PostData) && $PostData['status'] == "failure"){
            $amount = $PostData["amount"];
            $txnid = $PostData["txnid"];
            $id = $PostData["udf1"];
            
            
            $this->User->_table = "temp_foodies_payment_data";
            $this->User->_where = array("id"=>$id);
            $resdata = $this->User->getRecordsById();

            if(!empty($resdata)){

                $this->User->_table = "temp_foodies_payment_data";
                $this->User->Delete(array("id"=>$id));
            }
            
            $this->session->set_flashdata('payment_status', 'failed');
        }
        redirect(FRONT_URL);
    }
}