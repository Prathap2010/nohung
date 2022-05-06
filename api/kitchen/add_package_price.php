<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($kitchen_id) AND $kitchen_id > 0)
	{
        if(isset($package_id) AND $package_id > 0 AND $weekly_price > 0 AND $monthly_price > 0)
        {
            $checkPackageId = $db->count("packages",array("id"=>$package_id,"userid"=>$kitchen_id));

            if($checkPackageId > 0)
            {
                $res = $db->pdoQuery("SELECT * FROM packages as p WHERE p.id='".$package_id."' AND p.userid = '".$kitchen_id."'")->result();
            
                if($res)
                {

                    $update_array = array(
                        "weeklyprice" => $weekly_price,                    
                        "monthlyprice" => $monthly_price,
                        "modifieddate" => date("Y-m-d H:i:s"),
                    );
                    $db->update("packages",$update_array,array("id"=>$package_id));

                    APIsuccess("Package has been created.",$return_array);
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
        }else{
            APIError("Fill all required fields.");
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
