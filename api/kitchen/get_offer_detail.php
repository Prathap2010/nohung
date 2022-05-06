<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if(isset($user_id) AND $user_id > 0)
	{
        if(isset($offer_id) && $offer_id != ""){

            $res = $db->pdoQuery("SELECT * FROM offer WHERE userid = '".$user_id."' AND id = '".$offer_id."'")->result();
            
            if(!empty($res))
            {
                $return_array = array(
                    "offer_id"       => $res['id'],
                    "user_id"        => $res['addedby'],
                    "title"          => $res['title'],
                    "offercode"      => $res['offercode'],
                    "discounttype"   => $res['discounttype'],
                    "discount_value" => $res['discount'],
                    "startdate"      => $res['startdate'],
                    "enddate"        => $res['enddate'],
                    "starttime"      => $res['starttime'],
                    "endtime"        => $res['endtime'],
                    "appliesto"      => $res['appliesto'],
                    "minrequirement" => $res['minrequirement'],
                    "usagelimit"     => $res['usagelimit'],
                    "createddate"    => $res['createddate'], 
                );

                APIsuccess("success",$return_array);
            }
            else
            {
                APIError("Offer not found.");
            }
        }else {
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



