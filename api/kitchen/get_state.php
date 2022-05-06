<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	$res = $db->pdoQuery("SELECT * FROM province WHERE countryid = '101' ORDER BY id ASC ")->results();

	if(count($res) > 0)
	{
		foreach ($res as $key => $value) {
			
			$return_array[] = array(
				"state_id"      => $value['id'],
				"name"          => trim($value['name']),
				"code"          => $value['code'],
			);
		}
		APIsuccess("success",$return_array);
	}
	else
	{
		APIError("State not found.");
	}
}
else
{
	APIError("Token missing.");
}



