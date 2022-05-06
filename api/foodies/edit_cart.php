<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if($user_id > 0){
        if($cart_id > 0 && $quantity > 0){
        
            $res_cart = $db->pdoQuery("SELECT id,quantity FROM cart WHERE id=".$cart_id." AND user_id = ".$user_id." AND type=2")->result();
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
                        "quantity"=>$qty,
                        "modifieddate"=>date("Y-m-d H:i:s"),
                    );

                    $db->update('cart',$update_array,array('id'=>$cart_id));

                    APIsuccess("Item quantity has been updated.");

                }else{
                    $db->delete("cart",array("id"=>$cart_id));

                    APIsuccess("Item has been deleted.");
                }
            }else{

                APIsuccess("Item not found.");
            }
            
        }else{
            APIError("Fill all required fields.");
        }
    }else{
        APIError("Login is mandatory to edit item in cart !");
    }
}
else
{
	APIError("Token missing.");
}



