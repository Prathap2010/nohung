<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if($user_id > 0){

        $db->pdoQuery("DELETE FROM cart_package_menu_items WHERE cart_id IN (SELECT id FROM cart WHERE user_id='".$user_id."')");

        $db->delete("cart",array('user_id'=>$user_id));

        APIsuccess("Card has been reset.");
    }else{
        APIError("Login is mandatory to reset item in cart !");
    }
}
else
{
	APIError("Token missing.");
}



