<?php
require_once("../include/config.php");
extract($_REQUEST);

$return_array = array();

if($token == API_TOKEN)
{
    if(!empty($user_id) &&!empty($account_id) && !empty($account_name) && !empty($account_number) && !empty($bank_name) && !empty($ifsc_code))
    {
        $checkUserId = $db->count("user",array("id"=>$user_id));

        if($checkUserId > 0)
        {
            $checkId = $db->count("useraccountdetail", array("id" => $account_id));

            if ($checkId > 0) {
               
                $account_number = encrypt($account_number);
                $ifsc_code = encrypt($ifsc_code);

                $data_array = array(
                    "account_name"  => $account_name,
                    "account_number"  => $account_number,
                    "bank_name"  => $bank_name,
                    "ifsc_code"  => $ifsc_code,
                    "modifieddate"    => date("Y-m-d H:i:s")
                );

                $db->update("useraccountdetail",$data_array,array("id"=> $account_id));

                APIsuccess("Account detail has been updated successfully.");

            } else {
                APIError("Invalid account id.");
            }
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
