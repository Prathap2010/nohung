<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	$res = $db->pdoQuery("SELECT * FROM improveoption ORDER BY id ASC ")->results();

	if(count($res) > 0)
	{
		foreach ($res as $key => $value) {
			
			$return_array[] = array(
				"improve_id" => $value['id'],
				"option"     => $value['name'],
			);
		}
		APIsuccess("success",$return_array);
	}
	else
	{
		APIError("Options not found.");
	}	
}
else
{
	APIError("Token missing.");
}



