<?php
require_once("../include/config.php");
extract($_REQUEST);

$return_array = array();

if($token == API_TOKEN)
{
    if($kitchen_id > 0 && $message != '')
	{

        $checkKitchenId = $db->count("user",array("id"=>$kitchen_id,"usertype"=>0));

        if($checkKitchenId > 0)
        {
            $data_array = array(
                "msg_type"    => "usertoadmin",
                "userid"      => $kitchen_id,
                "message"     => $message,
                "isread"      => 'n',
                "createddate" => date("Y-m-d H:i:s")
            );

            $db->insert("adminmessages",$data_array);
            
            APIsuccess("Message sent successfully.",$data_array);
        }
        else
        {
            APIError("Invalid kitchen id.");
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
