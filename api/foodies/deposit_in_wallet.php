<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($amount > 0 && $userid > 0 && $transaction_id != ''){

		$data_array = array(
			"userid"      => $userid,
			"transaction_id" => $transaction_id,
			"amount" => $amount,
			"transaction_status"  => 'success',
			"payment_type" => 'deposit',
			"createddate" => date("Y-m-d H:i:s")
		);
		
		$db->insert("transaction",$data_array);

		//update in user wallet
		$db->pdoQuery("update user set wallet = wallet + ".$amount." where id = ".$userid."");
		
		APIsuccess("Amount has been deposit in wallet successfully.");

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



