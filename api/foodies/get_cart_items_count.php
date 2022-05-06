<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT * FROM cart WHERE user_id = '".$user_id."' GROUP BY type,typeid")->results();

        if (count($res) > 0)
		{
            $return_array = array("cart_count"=>count($res));
			
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



