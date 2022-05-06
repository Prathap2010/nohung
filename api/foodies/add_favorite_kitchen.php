<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0 && $kitchenid > 0){

		$exist = $db->count("favorite_kitchen",array("customerid"=>$userid,'kitchenid'=>$kitchenid));

		if($exist == 0){
			$data_array = array(
				"customerid"  => $userid,
				"kitchenid"  => $kitchenid,
				"createddate"    => date("Y-m-d H:i:s")
			);
			
			$db->insert("favorite_kitchen",$data_array);
			APIsuccess("Kitchen has been added in favorite.");

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



