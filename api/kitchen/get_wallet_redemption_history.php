<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($kitchen_id) && $kitchen_id > 0){
        
        $res = $db->pdoQuery("SELECT kwp.id,kwp.kitchen_id,kwp.amount,kwp.status,kwp.createddate,kwp.wallet_amount
							  FROM kitchenwithdrawpayment as kwp
							  WHERE kwp.kitchen_id = ".$kitchen_id."
							  ORDER BY kwp.id DESC
							")->results();

        if(!empty($res)){
            foreach($res as $row) {
                
                $return_array[] = array(
                    "amount" => $row['amount'],
                    "status"  => ($row['status']=="pending") ? "Pending" : "Paid",
                    "wallet_amount" => $row['wallet_amount'],
                    "withdrawal_time" => date("d-m-Y h:i A", strtotime($row['createddate'])),
                );
                
            }
        }
            
        APIsuccess("success", $return_array);

    }else{
        APIError("Login is mandatory !");
    }
}
else
{
	APIError("Token missing.");
}



