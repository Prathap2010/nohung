<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if(isset($kitchen_id) && $kitchen_id > 0){

		$res = $db->pdoQuery("SELECT f.id,f.kitchen_id,f.customer_id,f.rating,f.message,f.foodquality,f.taste,f.quantity,f.createddate,
        u.kitchenname as customername, u.profile_image

							  FROM feedback as f
							  LEFT JOIN user as u ON u.id=f.customer_id
                              WHERE u.status=1 AND u.usertype=1 AND f.kitchen_id='".$kitchen_id."'
							  ORDER BY f.id DESC")->results();
		
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$return_array[] = array(
					"id"         => $value['id'],
                    "customername"=> $value['customername'],
                    "image"      => $value['profile_image'],
                    "rating"     => $value['rating'],
					"message"    => $value['message'],
                    "foodquality"=> $value['foodquality'],
                    "taste"      => $value['taste'],
                    "quantity"   => $value['quantity'],
					"time"       => humanTiming($value['createddate'])
				);
			}
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Review not found.");
		}	

	}else{
		APIError("Invalid kitchen id.");
	}
	
}
else
{
	APIError("Token missing.");
}



