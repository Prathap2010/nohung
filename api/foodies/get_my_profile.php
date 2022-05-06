<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0){

		$res = $db->pdoQuery("SELECT u.kitchenname,u.mobilenumber,u.email,u.wallet ,u.profile_image
							  FROM user as u
							  WHERE u.id = ".$user_id)->results();
		
		//echo '<pre>';print_r($res);exit;
		
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				if ($value['profile_image'] != "") {
					$profile = SITE_UPD . 'profile/' . $value['profile_image'];
				} else {
					$profile = SITE_URL . 'assets/image/userprofile/noimage.png';
				}

				$return_array[] = array(
					"username"     => $value['kitchenname'],
					"email"        => $value['email'],
					"mobilenumber" => $value['mobilenumber'],
					"profile_pic" => $profile,
					"my_wallet"    => $value['wallet']
				);
			}
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("User not found.");
		}	

	}else{
		APIError("Login is mandatory.");
	}
	
}
else
{
	APIError("Token missing.");
}



