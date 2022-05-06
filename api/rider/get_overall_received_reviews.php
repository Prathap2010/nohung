<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT avg(rf.ratting) as avg_rattings,count(rf.id) as total_review 
							  FROM riderfeedback as rf
							  LEFT JOIN user as u ON(u.id = rf.customerid) 
							  WHERE rf.riderid = ".$user_id)->results();
		//echo '<pre>';print_r($res);exit;
		$excellent = $db->count("riderfeedback",array("rate"=>"excellent","riderid"=>$user_id));
		$good = $db->count("riderfeedback",array("rate"=>"good","riderid"=>$user_id));
		$average = $db->count("riderfeedback",array("rate"=>"average","riderid"=>$user_id));
		$poor = $db->count("riderfeedback",array("rate"=>"poor","riderid"=>$user_id));

		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$return_array[] = array(
					"avg_rattings" => round($value['avg_rattings']),
					"total_review" => $value['total_review'],
					"excellent"    => $excellent,
					"good"         => $good,
					"average"      => $average,
					"poor"         => $poor
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



