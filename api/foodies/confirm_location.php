<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0 && $location != '' && $pincode != '' && $latitude != '' && $longitude != ''){

		$exist = $db->count("customer_address",array("user_id"=>$userid,"latitude"=>$latitude,"longitude"=>$longitude));

		if($exist == 0){
			$data_array = array(
				"user_id"     => $userid,
				"address"     => $location,
				"pincode"     => $pincode,
				"latitude"    => $latitude,
				"longitude"   => $longitude,
				"is_delivery" => 'y',
				"createddate" => date("Y-m-d H:i:s")
			);
			
			$db->update("customer_address",array('is_delivery'=>'n'),array('user_id'=>$userid));
			$id = $db->insert("customer_address",$data_array)->getLastInsertId();
		}
		
		APIsuccess("Delivery location has been confirmed successfully.");

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



