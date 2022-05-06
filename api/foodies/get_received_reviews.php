<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT r.kitchenname,cf.*,
                                i.name as improve_message

							  FROM customerfeedback as cf
							  LEFT JOIN user as r ON(r.id = cf.riderid) 
                              LEFT JOIN improveoption as i ON(i.id = cf.improveid) 
							  WHERE cf.customerid = ".$user_id."
							  ORDER BY cf.id DESC")->results();
		//echo '<pre>';print_r($res);exit;
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$return_array[] = array(
					"rider_name"            => $value['kitchenname'],
                    "ratting"               => $value['ratting'],
					"review_description"    => $value['improve_message'],
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



