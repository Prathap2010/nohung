<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT u.kitchenname,rf.* 
							  FROM riderfeedback as rf
							  LEFT JOIN user as u ON(u.id = rf.customerid) 
							  WHERE rf.riderid = ".$user_id."
							  ORDER BY rf.id DESC")->results();
		//echo '<pre>';print_r($res);exit;
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$return_array[] = array(
					"user_name"             => $value['kitchenname'],
					"ratting"               => $value['ratting'],
					"review_description"    => $value['review_description'],
					"time"                  => humanTiming($value['createddate'])
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



