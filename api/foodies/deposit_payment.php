<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($user_id) && $user_id > 0){
        if(isset($amount) && $amount > 0){

            $data_array = array(
                "user_id" => $user_id,
                "amount" => $amount,
                "payment_status"  => 'pending',
                "createddate" => date("Y-m-d H:i:s")
            );
            
            $id = $db->insert("foodies_deposit_amount",$data_array)->getLastInsertId();
            
            $return_array['url'] = SITE_URL."payment/make-deposit-payment/".base64_encode($id);

            APIsuccess("success", $return_array);

        }else{
            APIError("Fill all required fields.");
        }
    }else{
        APIError("Login is mandatory to make a payment !");
    }
}
else
{
	APIError("Token missing.");
}



