<?php
require_once("../include/config.php");
extract($_REQUEST);

$return_array = array();

if($token == API_TOKEN)
{
    if($userid > 0 && $message != '')
	{

        $checkUserId = $db->count("user",array("id"=>$userid));

        if($checkUserId > 0)
        {
            $data_array = array(
                "msg_type"    => "usertoadmin",
                "userid"      => $userid,
                "message"     => $message,
                "createddate" => date("Y-m-d H:i:s")
            );

            $db->insert("adminmessages",$data_array);
            

            APIsuccess("Message sent successfully.",$data_array);
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
