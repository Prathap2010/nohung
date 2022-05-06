<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0 && $orderid > 0){

		$exist = $db->count("favorite_orders",array("customerid"=>$userid,'orderid'=>$orderid));

		if($exist > 0){
			
			$db->delete("favorite_orders",array("customerid"=>$userid,'orderid'=>$orderid));
			APIsuccess("Order has been removed from favorite.");

		}else{
			APIError("Invalid request.");
		}

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



