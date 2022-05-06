<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0){

		$res = $db->pdoQuery("SELECT k.id,k.kitchenname,k.address,k.foodtype,k.fromtime,k.totime
							  FROM favorite_kitchen as fk
							  LEFT JOIN user as k ON(k.id = fk.kitchenid)
	                          WHERE fk.customerid = ".$userid)->results();
		//echo '<pre>';print_r($res);exit;
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$return_array[] = array(
					"id" => $value['id'],
					"kitchenname" => $value['kitchenname'],
					"foodtype" => $value['foodtype'],
					"address" => $value['address'],
					"timing" => date("h:i A",strtotime($value['fromtime'])).' to '.date("h:i A",strtotime($value['totime']))
				);
			}
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Orders not found.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



