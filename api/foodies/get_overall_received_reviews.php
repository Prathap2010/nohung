<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT avg(cf.ratting) as avg_rattings,
									
										count(cf.id) as total_review 

							  FROM customerfeedback as cf
							  LEFT JOIN user as r ON(r.id = cf.riderid) 
							  WHERE cf.customerid = ".$user_id)->results();

		//echo '<pre>';print_r($res);exit;
		$excellent = $db->count("customerfeedback",array("rate"=>"excellent","customerid"=>$user_id));
		$good = $db->count("customerfeedback",array("rate"=>"good","customerid"=>$user_id));
		$average = $db->count("customerfeedback",array("rate"=>"average","customerid"=>$user_id));
		$poor = $db->count("customerfeedback",array("rate"=>"poor","customerid"=>$user_id));
        
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



