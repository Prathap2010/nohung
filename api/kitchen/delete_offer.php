<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) AND $user_id > 0)
    {
        $checkOfferId = $db->count("offer",array("id"=>$offer_id,"userid"=>$user_id));

        if($checkOfferId > 0)
        {
            $db->delete("offer",array("id"=>$offer_id));

            APIsuccess("Offer has been deleted successfully.");
        }
        else
        {
            APIError("Invalid offer id.");
        }
    }
    else
    {
        APIError("Invalid user id.");
    }
}
else 
{
	APIError("Token missing.");
}
