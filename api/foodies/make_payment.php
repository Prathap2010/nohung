<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if($user_id > 0){
        if($kitchen_id != '' && $customer_name != '' && $customer_mobileno != '' && $deliveryaddress != "" && $deliverylatitude != "" && $deliverylongitude != "" && !empty($card_id) && !empty($netamount)){

            $orderingforname = ($orderingforname != "") ? $orderingforname : $customer_name;
            $orderingformobileno = ($orderingformobileno != "") ? $orderingformobileno : $customer_mobileno;
            
            $payment_method = 1;
            
            $cart_item = $db->pdoQuery("SELECT c.id FROM cart as c WHERE c.user_id = '".$user_id."'")->results();

            if (count($cart_item) > 0) {

                $card = $db->pdoQuery("SELECT * FROM cards as c WHERE id = '".$card_id."'")->result();

                if(!empty($card) && $card['card_name']!="" && $card['cvv']!=""){

                    $db->pdoQuery("DELETE FROM temp_foodies_payment_data WHERE user_id = '".$user_id."' AND kitchen_id = '".$kitchen_id."'");
    
                    $data_array = array(
                        "user_id" => $user_id,
                        "kitchen_id" => $kitchen_id,
                        "customer_name"  => $customer_name,
                        "customer_mobileno"  => $customer_mobileno,
                        "orderingforname"  => $orderingforname,
                        "orderingformobileno"  => $orderingformobileno,
                        "deliveryaddress"  => $deliveryaddress,
                        "deliverylatitude" => $deliverylatitude,
                        "deliverylongitude" => $deliverylongitude,
                        "orderamount" => $orderamount,
                        "taxamount" => $taxamount,
                        "deliverycharge" => $deliverycharge,
                        "couponcode"  => $couponcode,
                        "couponamount"  => $couponamount,
                        "netamount"  => $netamount,
                        "card_id"  => $card_id,
                        "payment_status"  => 'pending',
                        "createddate" => date("Y-m-d H:i:s")
                    );
                    
                    $id = $db->insert("temp_foodies_payment_data",$data_array)->getLastInsertId();
                    
                    $return_array['url'] = SITE_URL."payment/make-order-payment/".base64_encode($id);
        
                    APIsuccess("success", $return_array);
                }else{
                    APIError("Add card name, number or cvv details in selected card !");    
                }

            }else{
                APIError("Add atleast one item in cart !");    
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
