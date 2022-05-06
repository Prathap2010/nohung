<?php
require_once("../include/config.php");
extract($_REQUEST);

$return_array = array();

if($token == API_TOKEN)
{
    if($userid > 0 && $amount > 0)
	{

        $checkUserId = $db->count("user",array("id"=>$userid));

        if($checkUserId > 0)
        {

            $wallet = $db->select('user',array('wallet'),array('id'=>$userid))->result();

            if($wallet['wallet'] >= $amount){

                $wallet = $wallet['wallet'] - $amount;
                $update_array = array(
                    "wallet"       => $wallet,
                    "modifieddate" => date("Y-m-d H:i:s")
                );
                $db->update("user",$update_array,array('id'=>$userid));

                //Insert in withdraw table
                $insert_array = array(
                    "userid"      => $userid,
                    "amount"      => $amount,
                    "createddate" => date("Y-m-d H:i:s")
                );
                $db->insert("withdrawpayment",$insert_array);

                APIsuccess("Withdrawal request has been sent successfully.");

            }else{

                APIError("You don't have enough balance for withdrawal.");

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
