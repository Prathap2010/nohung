<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if(isset($kitchen_id) && $kitchen_id > 0){

        if($customer_id > 0 && $rating > 0 && $message != "" && $foodquality != "" && $taste != "" && $quantity != ""){
           
            $insert_array = array(
                "kitchen_id"    => $kitchen_id,
                "customer_id"   => $customer_id,
                "rating"        => $rating,
                "message"       => $message,
                "submittype"    => 1,
                "foodquality"   => $foodquality,
                "taste"         => $taste,
                "quantity"      => $quantity,
                "createddate"   => date("Y-m-d H:i:s"),
                "modifieddate"  => date("Y-m-d H:i:s")
            );
            
            $db->insert("feedback",$insert_array);
            
            APIsuccess("Review has been added successfully.");
            
        }else{
            APIError("Fill all required fields.");
        }
	}else{
		APIError("Invalid kitchen id.");
	}
	
}
else
{
	APIError("Token missing.");
}



