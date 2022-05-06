<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0 && $kitchenid > 0){

		$exist = $db->count("favorite_kitchen",array("customerid"=>$userid,'kitchenid'=>$kitchenid));

		if($exist > 0){
			
			$db->delete("favorite_kitchen",array("customerid"=>$userid,'kitchenid'=>$kitchenid));
			APIsuccess("Kitchen has been removed from favorite.");

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



