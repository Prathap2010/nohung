<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($id) AND $id > 0)
	{

        $checkId = $db->count("kitchenaccount",array("id"=>$id));

        if($checkId > 0)
        {
            if($account_name != "" && $bank_name != "" && $ifsc_code != "" && $account_number != ""){

                $account_number = encrypt($account_number);
                $ifsc_code = encrypt($ifsc_code);
    
                $update_array = array(
                    "account_name" => $account_name,
                    "bank_name" => $bank_name,
                    "ifsc_code" => $ifsc_code,
                    "account_number" => $account_number,
                );
    
                $db->update("kitchenaccount",$update_array,array("id"=>$id));
    
                APIsuccess("Bank account has been updated successfully.");
            }
            else
            {
                APIError("Fill all required fields.");
            }
        }
        else
        {
            APIError("Invalid id.");
        }

    }
    else
    {
        APIError("Id invalid.");
    }	
}
else 
{
	APIError("Token missing.");
}
