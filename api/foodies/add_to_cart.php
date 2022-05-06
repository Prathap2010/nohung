<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if($user_id > 0){
        if($kitchen_id > 0 && $mealplan != ""){

            if($mealplan == 'trial'){
                $meal_plan = 2;
            }else if($mealplan == 'monthly'){
                $meal_plan = 1;
            }else{
                $meal_plan = 0;
            }
            $res = $db->pdoQuery("SELECT kitchen_id,type FROM cart WHERE user_id = ".$user_id)->results();
            $cart_kitchen_ids = !empty($res)?array_unique(array_column($res, 'kitchen_id')):array();

            $cart_mealtype = !empty($res)?array_column($res, 'type'):array();
            
            if(empty($cart_kitchen_ids) || (!empty($cart_kitchen_ids) && count($cart_kitchen_ids)==1 && $cart_kitchen_ids[0] == $kitchen_id)){
                if((!empty($cart_mealtype) && in_array(2, $cart_mealtype) && $meal_plan!=2)){
                    //while add package
                    APIError("Already added trial meal in cart. Reset your cart for add packages in cart.");    
                }
                if((!empty($cart_mealtype) && (in_array(0, $cart_mealtype) || in_array(1, $cart_mealtype)) && $meal_plan==2)){
                    //while add trial meal
                    APIError("Already added package in cart. Reset your cart for add trial meal in cart.");    
                }
                
                if($meal_plan == 2){
                    $res_menu = $db->pdoQuery("SELECT id,itemname,itemprice FROM mastermenu WHERE userid = ".$kitchen_id." AND id='".$type_id."'")->result();
                    
                    $res_cart = $db->pdoQuery("SELECT id,quantity FROM cart WHERE user_id = ".$user_id." AND type=2 AND typeid='".$type_id."'")->result();
                    if(!empty($res_cart)){
                    
                        if($quantity_type==1){
                            $qty = $res_cart['quantity'] + 1;
                        }else if($quantity_type==2){
                            $qty = $res_cart['quantity'] - 1;
                        }else{
                            $qty = $quantity;
                        }

                        if($qty > 0){

                            $update_array = array(
                                "quantity"      => $qty,
                                "delivery_date" => date("Y-m-d"),
                                "delivery_fromtime" => date("H:i:s"),
                                "delivery_totime"   => '23:59:59',
                                "modifieddate"  => date("Y-m-d H:i:s"),
                            );

                            $db->update('cart',$update_array,array('id'=>$res_cart['id']));

                            APIsuccess("Cart has been updated.");

                        }else{
                            $db->delete("cart",array("id"=>$res_cart['id']));

                            APIsuccess("Item has been deleted.");
                        }
                    }else{
                        
                        $insert_array = array(
                            "kitchen_id"    => $kitchen_id,
                            "user_id"       => $user_id,
                            "type"          => 2,
                            "typeid"        => $type_id,
                            "name"          => $res_menu['itemname'],
                            "quantity"      => $quantity,
                            "price"         => $res_menu['itemprice'],
                            "delivery_date" => date("Y-m-d"),
                            "delivery_fromtime" => date("H:i:s"),
                            "delivery_totime"   => '23:59:59',
                            "createddate"   => date("Y-m-d H:i:s"),
                            "modifieddate"  => date("Y-m-d H:i:s"),
                        );

                        $db->insert("cart", $insert_array);

                        APIsuccess("Item has been added in cart.");
                    }
                }else{
                    
                    $res_cpdt = $db->pdoQuery("SELECT id,delivery_startdate,delivery_enddate,delivery_fromtime,delivery_totime FROM order_customized_package_date_time WHERE userid=".$user_id." AND packageid = ".$type_id)->result();

                    if(!empty($res_cpdt)){

                        $delivery_startdate = !empty($res_cpdt) ? $res_cpdt['delivery_startdate'] : "";
                        $delivery_enddate = !empty($res_cpdt) ? $res_cpdt['delivery_enddate'] : "";
                        
                        $date_array = dateRange($delivery_startdate, $delivery_enddate);
                        
                        $delivery_fromtime = !empty($res_cpdt) ? trim($res_cpdt['delivery_fromtime']) : "";
                        $delivery_totime = !empty($res_cpdt) ? trim($res_cpdt['delivery_totime']) : "";
    
                        $res_pkg = $db->pdoQuery("SELECT id,packagename,including_saturday,including_sunday FROM packages WHERE id = ".$type_id)->result();
    
                        $db->pdoQuery("DELETE FROM cart_package_menu_items WHERE cart_id IN (SELECT id FROM cart WHERE user_id=".$user_id." AND type=".$meal_plan." AND typeid='".$type_id."')");
                        $db->delete("cart",array("user_id"=>$user_id,"type"=>$meal_plan,"typeid"=>$type_id));
                        
                        if(count($date_array) > 0){
                            foreach($date_array as $date){
                                
                                $dayname = date('l', strtotime($date));
                                $days = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
                                $day_index = array_search($dayname, $days);
    
                                $res_weekpkg = $db->pdoQuery("SELECT id,price,image FROM weeklypackage WHERE packageid = ".$type_id." AND days=".$day_index)->result();
    
                                if(!empty($res_weekpkg)){
    
                                    $insert_array = array(
                                        "kitchen_id"        => $kitchen_id,
                                        "user_id"           => $user_id,
                                        "type"              => $meal_plan,
                                        "typeid"            => $type_id,
                                        "weeklypackageid"   => $res_weekpkg['id'],
                                        "name"              => $res_pkg['packagename'],
                                        "price"             => $res_weekpkg['price'],
                                        "delivery_date"     => $date,
                                        "delivery_fromtime" => $delivery_fromtime,
                                        "delivery_totime"   => $delivery_totime,
                                        "including_saturday"=> $res_pkg['including_saturday'],
                                        "including_sunday"  => $res_pkg['including_sunday'],
                                        "createddate"       => date("Y-m-d H:i:s"),
                                        "modifieddate"      => date("Y-m-d H:i:s"),
                                    );
    
                                    $cart_id = $db->insert("cart",$insert_array)->getLastInsertId();
    
                                    if($cart_id){
                                        /* $res_weekpkg_menu = $db->pdoQuery("SELECT id,menuid,itemname,qty,price FROM weeklypackagemenu WHERE weeklypackageid = ".$res_weekpkg['id'])->results();
                                        
                                        if(!empty($res_weekpkg_menu)){
                                            foreach($res_weekpkg_menu as $val){  */
    
                                                $res_extra_item = $db->pdoQuery("SELECT id,userid,packageid,weeklypackageid,menuid,qty,itemprice, (SELECT itemname FROM mastermenu WHERE id=menuid) as itemname
                                                FROM order_customized_package_item 
                                                WHERE userid = ".$user_id." AND packageid = ".$type_id." AND weeklypackageid=".$res_weekpkg['id'])->results(); //." AND menuid=".$val['menuid']

                                        /* $qty = $val['qty'];
                                                if(!empty($res_extra_item)){
                                                    $qty = ($qty == 0) ? ($res_extra_item['qty'] + 1) : ($qty + $res_extra_item['qty']);
                                                } */
                                                if (!empty($res_extra_item)) {
                                                    foreach ($res_extra_item as $val) {
                                                        $items_array = array(
                                                            "cart_id"       => $cart_id,
                                                            "menuid"        => $val['menuid'],
                                                            "itemname"      => $val['itemname'],
                                                            "qty"           => $val['qty'],
                                                            "price"         => $val['itemprice']
                                                        );
            
                                                        $db->insert("cart_package_menu_items",$items_array);
                                                    }
                                                }
                                            /* }
                                        } */
                                    }
                                }
                            }
                        }
                        $db->pdoQuery("DELETE FROM order_customized_package_item WHERE userid=" . $user_id . " AND packageid=" . $type_id);
                        $db->pdoQuery("DELETE FROM order_customized_package_date_time WHERE userid=".$user_id." AND packageid=".$type_id);
    
                        APIsuccess("Item has been added in cart.");
                    }else{
                        APIError("Pease select first delivery date & time !");
                    }
                }
            }else{
                APIError("Your cart contains items from other kitchen. Reset your cart for add items from this kitchen.");
            }
            
        }else{
            APIError("Fill all required fields.");
        }
    }else{
        APIError("Login is mandatory to add item in cart !");
    }
}
else
{
	APIError("Token missing.");
}



