<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{   
    if($riderid != '' && $customerid != '' && $orderid != '' && $rate != '' && $improveid != '' && $tip_received != ''){

        $riderId = time();
        $password = generateRandomString(8);

        $exist =  $db->count("customerfeedback",array("riderid"=>$riderid,'customerid'=>$customerid,"orderid"=>$orderid));

        if($exist == 0){

            $insert_array = array(
                "riderid"      => $riderid,
                "customerid"   => $customerid,
                "orderid"      => $orderid,
                "rate"         => $rate,
                "improveid"    => $improveid,
                "tip_received" => $tip_received,
                "createddate"  => date("Y-m-d H:i:s")
            );
            //print_r($insert_array);exit;
            $db->insert("customerfeedback",$insert_array);
            
            APIsuccess("Feedback has been saved successfully.");

        }else{
            APIError("You have already given review.");
        }
            
    }else{
        APIError("Fill all required fields.");
    }
}else{
	APIError("Token missing.");
}
