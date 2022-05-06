<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0){

		//Get nearby location
		$nearby_location = $db->pdoQuery("SELECT k.kitchenname,o.deliveryaddress,getDistance(k.latitude,k.longitude,r.latitude,r.longitude) as distance,k.id
										  FROM orders as o 
										  LEFT JOIN user as k ON(k.id = o.userid)
										  LEFT JOIN user as r ON(r.id = ".$userid.")
										  HAVING distance >= 5
										  ORDER BY k.id DESC")->results();
		//echo '<pre>';print_r($nearby_location);exit;
		if(count($nearby_location) > 0)
		{
			foreach ($nearby_location as $key => $value) {

				$nearby_location_array[] = array(
					"id" => $value['id'],
					"kitchenname" => $value['kitchenname'],
					"deliveryaddress" => $value['deliveryaddress']
				);
			}
		}else{
			$nearby_location_array[] = 'No nearby location available';
		}

		//Get recent location
		$recent = $db->pdoQuery("SELECT k.id,k.kitchenname,o.deliveryaddress,k.id 
									FROM orders as o
									LEFT JOIN user as k ON(o.customerid = k.id)
									GROUP BY k.id
									ORDER BY k.id DESC
									limit 2")->results();
		//echo '<pre>';print_r($recent);exit;
		if(count($recent) > 0)
		{
			foreach ($recent as $key => $value) {

				$recent_array[] = array(
					"id" => $value['id'],
					"kitchenname" => $value['kitchenname'],
					"deliveryaddress" => $value['deliveryaddress']
				);
			}
		}else{
			$recent_array[] = 'No recent location available';
		}

		$return_array[] = array(
			"nearby_kitchen"  => $nearby_location_array,
			"recent"  => $recent_array
		);
	
		APIsuccess("success",$return_array);	

	}else{
		APIError("Fill all required fields.");
	}
	
}
else
{
	APIError("Token missing.");
}



