<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($kitchen_id > 0 && $coupon_code != "" && $user_id > 0){
        
		$res = $db->pdoQuery("SELECT id,offercode,discounttype,discount,startdate,enddate,starttime,endtime,usagelimit,
                                IFNULL((SELECT count(id) FROM orders WHERE couponcode=offercode),0) as countusage
							  FROM offer
							  WHERE (userid=0 OR userid='".$kitchen_id."') AND offercode='".$coupon_code."'
                            ")->result();
		
		if(!empty($res))
		{
            if($res['usagelimit'] == 0 || $res['countusage'] < $res['usagelimit']){

                $starttime = date('Y-m-d H:i:s', strtotime($res['startdate']." ".$res['starttime']));
                $endtime = date('Y-m-d H:i:s', strtotime($res['enddate']." ".$res['endtime']));
                $currenttime = date("Y-m-d H:i:s");
    
                if($starttime <= $currenttime && $endtime >= $currenttime){

                    $db->update("cart", array("couponcode" => $coupon_code), array("user_id" => $user_id));
                   
                    APIsuccess("Coupon code applied successfully.");
                }else{
                    APIError("Coupon code expired.");    
                }
            }else{
                APIError("Coupon code usage limit reached.");    
            }
		}
		else
		{
			APIError("Coupon code not valid.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
	
}
else
{
	APIError("Token missing.");
}



