<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) AND $user_id > 0)
	{

        $res = $db->pdoQuery("SELECT * FROM packages WHERE userid = '".$user_id."' ORDER BY id DESC")->results();
	
        if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
                
                $return_array[] = array(
					"package_id"        =>  $value['id'],
					"user_id"           =>  $value['userid'],
					"packagename"       =>  $value['packagename'],
					"cuisinetype"       =>  $value['cuisinetype'],
					"mealtype"          =>  $value['mealtype'],
					"mealfor"           =>  $value['mealfor'],
					"weeklyplantype"    =>  $value['weeklyplantype'],
					"monthlyplantype"   =>  $value['monthlyplantype'],
					"startdate"         =>  $value['startdate'],
					"including_saturday"=>  $value['including_saturday'],
					"including_sunday"  =>  $value['including_sunday'],
					"monthlyprice"      =>  $value['monthlyprice'],
					"weeklyprice"       =>  $value['weeklyprice'],
					"createddate"       =>  $value['createddate'], 
				);

            }
            APIsuccess("success",$return_array);
        }
		else
		{
			APIError("Package not found.");
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
