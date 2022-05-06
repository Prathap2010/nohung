<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($token == API_TOKEN)
{
    if(isset($user_id) AND $user_id > 0)
	{

        $checkUserId = $db->count("user",array("id"=>$user_id));

        if($checkUserId > 0)
        {
            $update_array = array(
                "kitchenname"  => $username,
                "mobilenumber"  => $mobilenumber,
                "address"  => $address
            );

            $db->update("user",$update_array,array("id"=>$user_id));

            APIsuccess("Profile has been updated successfully.");
        }
        else
        {
            APIError("Invalid user id.");
        }

    }
    else
    {
        APIError("Fill all required fields.");
    }	
}
else 
{
	APIError("Token missing.");
}
