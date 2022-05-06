<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) AND $user_id > 0)
    {
        $checkOfferCode = $db->count("offer",array("offercode"=>$offer_code));

        if($checkOfferCode <= 0)
        {
            $insert_array = array(
                "userid"         => $user_id,
                "addedby"        => $user_id,
                "title"          => $offer_title,
                "offercode"      => $offer_code,
                "discounttype"   => $discount_type,
                "discount"       => $discount_value,
                "startdate"      => $start_date,
                "enddate"        => $end_date,
                "starttime"      => $start_time,
                "endtime"        => $end_time,
                "appliesto"      => $apply_to,
                "minrequirement" => $minimum_requirement,
                "usagelimit"     => $usage_limit,
                "usertype"       => 1,
                "addedby"        => $user_id,
                "createddate"    => date("Y-m-d H:i:s"),
                "modifieddate"   => date("Y-m-d H:i:s"),
            );
            
            $db->insert("offer",$insert_array);

            APIsuccess("Offer has been added successfully.");
        }
        else
        {
            APIError("Offer code already available please enter differance offer code.");
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
