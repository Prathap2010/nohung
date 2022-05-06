<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT * FROM customer_address WHERE user_id = ".$user_id." ORDER BY id DESC ")->results();

		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$return_array[] = array(
					"address" => $value['address'],
				);
			}
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Address not found.");
		}	

	}else{
		APIError("Login is mandatory.");
	}
}
else
{
	APIError("Token missing.");
}



