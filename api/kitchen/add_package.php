<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) AND $user_id > 0)
    {
        $checkPackageName = $db->count("packages",array("packagename"=>$package_name));

        if($checkPackageName <= 0)
        {
            $insert_array = array(
                "userid"            => $user_id,
                "packagename"       => $package_name,
                "cuisinetype"       => $cuisine_type,
                "mealtype"          => $meal_type,
                "mealfor"           => $meal_for,
                "weeklyplantype"    => $weekly_plan_type,
                "monthlyplantype"   => $monthly_plan_type,
                "startdate"         => $start_date,
                "including_saturday"=> $including_saturday,
                "including_sunday"  => $including_sunday,
                "createddate"       => date("Y-m-d H:i:s"),
                "modifieddate"      => date("Y-m-d H:i:s"),
            );
            
            $packageid = $db->insert("packages",$insert_array)->getLastInsertId();
            
            $return_array[] = array("package_id"=>$packageid);

            APIsuccess("Package has been added successfully.", $return_array);
        }
        else
        {
            APIError("Package name already available please enter differance package name.");
        }        
    }
    else
    {
        APIError("User not found.");
    }
}
else 
{
	APIError("Token missing.");
}
