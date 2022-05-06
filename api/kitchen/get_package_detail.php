<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) AND $user_id > 0)
	{

        $checkPackageId = $db->count("packages",array("id"=>$package_id,"userid"=>$user_id));

        if($checkPackageId > 0)
        {
            $res = $db->pdoQuery("SELECT * FROM packages WHERE id='".$package_id."' AND userid = '".$user_id."'")->result();
        
            if($res)
            {
                $return_array = array(
                    "package_id"        =>  $res['id'],
                    "user_id"           =>  $res['userid'],
                    "packagename"       =>  $res['packagename'],
                    "cuisinetype"       =>  $res['cuisinetype'],
                    "mealtype"          =>  $res['mealtype'],
                    "mealfor"           =>  $res['mealfor'],
                    "weeklyplantype"    =>  $res['weeklyplantype'],
                    "monthlyplantype"   =>  $res['monthlyplantype'],
                    "startdate"         =>  $res['startdate'],
                    "including_saturday"=>  $res['including_saturday'],
                    "including_sunday"  =>  $res['including_sunday'],
                    "monthlyprice"      =>  $res['monthlyprice'],
                    "weeklyprice"       =>  $res['weeklyprice'],
                    "createddate"       =>  $res['createddate'], 
                );

                APIsuccess("success",$return_array);
            }
            else
            {
                APIError("Package not found.");
            }
        }
        else
        {
            APIError("Invalid package id.");
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
