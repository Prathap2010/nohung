<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if($kitchen_id > 0 && $account_name != "" && $bank_name != "" && $ifsc_code != "" && $account_number != "")
    {

        $account_number = encrypt($account_number);
        $ifsc_code = encrypt($ifsc_code);

        $check = $db->count("kitchenaccount",array("kitchen_id"=>$kitchen_id,"account_number"=>$account_number));

        if($check <= 0)
        {
            $insert_array = array(
                "kitchen_id"     => $kitchen_id,
                "account_name"   => $account_name,
                "bank_name"      => $bank_name,
                "ifsc_code"      => $ifsc_code,
                "account_number" => $account_number,
                "createddate"    => date("Y-m-d H:i:s"),
                "modifieddate"   => date("Y-m-d H:i:s"),
            );
            
            $db->insert("kitchenaccount",$insert_array);

            APIsuccess("Account has been added successfully.");
        }
        else
        {
            APIError("Account number already added.");
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
