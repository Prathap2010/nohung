<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0 && $orderid > 0){

		$exist = $db->count("favorite_orders",array("customerid"=>$userid,'orderid'=>$orderid));

		if($exist == 0){
			$data_array = array(
				"customerid"  => $userid,
				"orderid"  => $orderid,
				"createddate"    => date("Y-m-d H:i:s")
			);
			
			$db->insert("favorite_orders",$data_array);
			APIsuccess("Order has been added in favorite.");

		}else{
			APIError("Already added.");
		}

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



