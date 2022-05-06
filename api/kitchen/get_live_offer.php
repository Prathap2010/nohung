<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if(isset($user_id) AND $user_id > 0)
	{
		$res = $db->pdoQuery("SELECT * FROM offer WHERE userid = '".$user_id."' AND enddate >= '".date("Y-m-d")."' ORDER BY id ASC ")->results();
		
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
				$return_array[] = array(
					"offer_id"       => $value['id'],
					"user_id"        => $value['addedby'],
					"title"          => $value['title'],
					"offercode"      => $value['offercode'],
					"discounttype"   => $value['discounttype'],
					"discount_value" => $value['discount'],
					"startdate"      => $value['startdate'],
					"enddate"        => $value['enddate'],
					"starttime"      => $value['starttime'],
					"endtime"        => $value['endtime'],
					"appliesto"      => $value['appliesto'],
					"minrequirement" => $value['minrequirement'],
					"usagelimit"     => $value['usagelimit'],
					"createddate"    => $value['createddate'], 
				);
			}
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Offer not found.");
		}
	}
	else
	{
		APIError("User invalid.");
	}	
}
else
{
	APIError("Token missing.");
}



