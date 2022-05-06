<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) AND $user_id > 0)
	{

        $checkUserId = $db->count("user",array("id"=>$user_id,"usertype"=>0));

        if($checkUserId > 0)
        {
            $from_time = (strpos($from_time,':')==false)?$from_time.":00:00":$from_time;
            $to_time = (strpos($to_time,':')==false)?$to_time.":00:00":$to_time;

            $update_array = array(
                "firmtype"  => $type_of_firm,
                "foodtype"  => $type_of_food,
                "fromtime"  => trim(date("H:i:s",strtotime($from_time))),
                "totime"    => trim(date("H:i:s",strtotime($to_time))),
                "opendays"  => $open_days,
                "mealtype"  => $type_of_meals,
                "description" => $description
            );

            $db->update("user",$update_array,array("id"=>$user_id));

            APIsuccess("Account has been updated successfully.");
        }
        else
        {
            APIError("Invalid user id.");
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
