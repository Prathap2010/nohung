<?php
require_once("../include/config.php");
extract($_REQUEST);

$return_array = array();

if($token == API_TOKEN)
{
    if(!empty($user_id) && !empty($account_name) && !empty($account_number) && !empty($bank_name) && !empty($ifsc_code))
    {
        $checkUserId = $db->count("user",array("id"=>$user_id));

        if($checkUserId > 0)
        {
            // $exist = $db->count("useraccountdetail",array("userid"=>$user_id));

            $account_number = encrypt($account_number);
            $ifsc_code = encrypt($ifsc_code);

            $data_array = array(
                "userid"  => $user_id,
                "account_name"  => $account_name,
                "account_number"  => $account_number,
                "bank_name"  => $bank_name,
                "ifsc_code"  => $ifsc_code,
                "createddate"    => date("Y-m-d H:i:s"),
                "modifieddate"    => date("Y-m-d H:i:s")
            );

            /* if($exist > 0){

                $db->update("useraccountdetail",$data_array,array("userid"=>$user_id));

            }else{ */

                $db->insert("useraccountdetail",$data_array);
            // }
            

            APIsuccess("Account detail has been added successfully.");
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
