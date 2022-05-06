<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if($user_id > 0){
        if($kitchen_id != '' && $customer_name != '' && $customer_mobileno != '' && $deliveryaddress != "" && $deliverylatitude != "" && $deliverylongitude != ""){

            duplicate : $ordernumber = generate_random_number(8);
            $exist = $db->count("orders",array("orderid"=>$ordernumber));

            if($exist == 0){

                $user = $db->pdoQuery("SELECT u.kitchenname,u.mobilenumber,u.email,u.wallet FROM user as u WHERE u.id = ".$user_id)->result();

                
                $orderingforname = ($orderingforname != "") ? $orderingforname : $customer_name;
                $orderingformobileno = ($orderingformobileno != "") ? $orderingformobileno : $customer_mobileno;
                
                $amountpay_to_wallet = $transaction_amount = 0;    
                $paymentmethod = !empty($paymentmethod) ? $paymentmethod : 0;
                $payment_method = 0;

                if($payment_by_wallet == 1){
                    if($user['wallet'] <= $netamount){
                        $amountpay_to_wallet = $user['wallet'];    
                    }else if($user['wallet'] > $netamount){
                        $amountpay_to_wallet = $netamount;    
                    }
                }
                
                if($paymentmethod > 0){
                    if($payment_by_wallet == 1){
                        $transaction_amount = $netamount - $amountpay_to_wallet;
                    }else{
                        $transaction_amount = $netamount;
                    }
                    $payment_method = $paymentmethod;
                }

                $cart_item = $db->pdoQuery("SELECT c.id,c.kitchen_id,c.user_id,c.type,c.typeid,c.name,c.quantity,c.createddate,c.modifieddate,
                                IF(c.type=2,IFNULL((SELECT image FROM mastermenu WHERE id=c.typeid),''),'') menuimage,

                                IF(c.type=2,
                                    IFNULL((SELECT cuisinetype FROM mastermenu WHERE id=c.typeid),''),
                                    IFNULL((SELECT cuisinetype FROM packages WHERE id=c.typeid),'')
                                ) as cuisinetype,

                                IF(c.type=2,
                                    IFNULL((SELECT itemprice FROM mastermenu WHERE id=c.typeid),''),
                                    IFNULL((SELECT SUM(itemprice) FROM mastermenu WHERE id IN (SELECT menuid FROM cart_package_menu_items WHERE cart_id=c.id)),'')
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
                                WHERE c.user_id = '".$user_id."'")->results();

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
                    
                    $order_id = $db->insert("orders",$data_array)->getLastInsertId();
                    
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

                            $orderitems_id = $db->insert("orderitems",$insert_array)->getLastInsertId();

                            if($orderitems_id){

                                if($value['type'] != 2){

                                    $menu_item = $db->pdoQuery("SELECT id,menuid,itemname,qty,IFNULL((SELECT itemprice FROM mastermenu WHERE id=menuid),'') as item_price FROM cart_package_menu_items WHERE cart_id = '".$value['id']."'")->results();

                                    if (count($menu_item) > 0){

                                        foreach($menu_item as $val){

                                            $items_array = array(
                                                "orderitems_id" => $orderitems_id,
                                                "menuid"        => $val['menuid'],
                                                "itemname"      => $val['itemname'],
                                                "qty"           => $val['qty'],
                                                "price"         => $val['item_price']
                                            );

                                            $db->insert("order_package_menu_items",$items_array);
                                        }

                                    }

                                    $db->delete("order_customized_package_item",array("userid"=>$user_id,"packageid"=>$value['typeid']));
                                }
                            }
                        }

                        if($payment_by_wallet == 1 && $amountpay_to_wallet > 0){
                            // Wallet History
                            $transaction_array = array(
                                "userid"            =>  $user_id,
                                "order_id"          =>  $order_id,
                                "order_number"      =>  $ordernumber,
                                "transaction_id"    =>  '',
                                "amount"            =>  $amountpay_to_wallet,
                                "transaction_status"=>  'success',
                                "payment_type"      =>  'order',
                                "payment_method"    =>  'wallet',
                                "createddate"       =>  date("Y-m-d H:i:s"),   
                            );

                            $db->insert("transaction",$transaction_array);
                        }
                        if($paymentmethod > 0 && $transaction_amount > 0){
                            // Transaction History
                            $transaction_array = array(
                                "userid"            =>  $user_id,
                                "order_id"          =>  $order_id,
                                "order_number"      =>  $ordernumber,
                                "transaction_id"    =>  $transaction_id,
                                "amount"            =>  $transaction_amount,
                                "transaction_status"=>  'success',
                                "payment_type"      =>  'order',
                                "payment_method"    =>  'payumoney',
                                "createddate"       =>  date("Y-m-d H:i:s"),   
                            );

                            $db->insert("transaction",$transaction_array);
                        }

                        $db->pdoQuery("DELETE FROM cart_package_menu_items WHERE cart_id IN (SELECT id FROM cart WHERE user_id=".$user_id.")");
                        $db->delete("cart",array("user_id"=>$user_id));

                        APIsuccess("Order has been added successfully.");
                    }else{
                        APIError("Order not added.");        
                    }
                }
            }else{
                goto duplicate;
            }
            

        }else{
            APIError("Fill all required fields.");
        }
    }else{
        APIError("Login is mandatory to place an order !");
    }
}
else
{
	APIError("Token missing.");
}
