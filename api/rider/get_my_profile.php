<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT avg(rf.ratting) as avg_rattings,u.kitchenname,u.mobilenumber,u.address,u.wallet 
							  FROM user as u
							  LEFT JOIN riderfeedback as rf ON(u.id = rf.riderid) 
							  WHERE u.id = ".$user_id)->results();
		
		//echo '<pre>';print_r($res);exit;
		
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$return_array[] = array(
					"username" => $value['kitchenname'],
					"avg_rattings" => round($value['avg_rattings']),
					"mobilenumber" => $value['mobilenumber'],
					"address" => $value['address'],
					"total_earning" => $value['wallet']
				);
			}
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Review not found.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
	
}
else
{
	APIError("Token missing.");
}



