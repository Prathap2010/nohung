<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) AND $user_id > 0)
    {

        $checkOfferCode = $db->pdoQuery("SELECT id FROM offer WHERE id != '".$offer_id."' AND offercode='".$offer_code."'")->results();
                    
        if(count($checkOfferCode) == 0)
        {
            $update_array = array(
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
                "modifieddate"   => date("Y-m-d H:i:s"),
            );
            
            $db->update("offer",$update_array,array("id"=>$offer_id));
        
            APIsuccess("Offer has been updated successfully.");
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
