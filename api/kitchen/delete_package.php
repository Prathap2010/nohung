<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if(isset($kitchen_id) AND $kitchen_id > 0)
	{

        $checkPackageId = $db->count("packages",array("id"=>$package_id,"userid"=>$kitchen_id));

        if($checkPackageId > 0)
        {
            $res = $db->pdoQuery("SELECT * FROM packages WHERE id='".$package_id."' AND userid = '".$kitchen_id."'")->result();
        
            if($res)
            {
                $db->pdoQuery("DELETE FROM weeklypackagemenu WHERE weeklypackageid IN (SELECT id FROM weeklypackage WHERE packageid='" . $package_id . "')");
                $db->delete("weeklypackage",array("packageid"=>$package_id));
                $db->delete("packages",array("id"=>$package_id));

                APIsuccess("Package has been deleted successfully.");
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
