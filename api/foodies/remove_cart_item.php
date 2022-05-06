<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if($user_id > 0){   
        if(isset($cart_id) && $cart_id > 0){
            
            $res = $db->pdoQuery("SELECT * FROM cart WHERE id = '".$cart_id."'")->result();

            $db->pdoQuery("DELETE FROM cart_package_menu_items WHERE cart_id IN (SELECT id FROM cart WHERE user_id='".$user_id."' AND kitchen_id='".$res['kitchen_id']."' AND type='".$res['type']."' AND typeid='".$res['typeid']."')");
    
            $db->delete("cart",array('user_id'=>$user_id,'kitchen_id'=>$res['kitchen_id'],'type'=>$res['type'],'typeid'=>$res['typeid']));
    
            APIsuccess("Card item has been removed.");
        }else{
            APIError("Fill all require fields !");    
        }

    }else{
        APIError("Login is mandatory to reset item in cart !");
    }
}
else
{
	APIError("Token missing.");
}



