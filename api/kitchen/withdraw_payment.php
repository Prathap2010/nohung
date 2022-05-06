<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if($kitchen_id > 0 && $withdraw_amount > 0)
    {

        $check = $db->count("kitchenaccount",array("kitchen_id"=>$kitchen_id));

        if($check > 0)
        {

            $res = $db->pdoQuery("SELECT IFNULL(SUM(oi.total_amount),0) as total
                              FROM orderitems AS oi
							  INNER JOIN orders AS o ON o.id=oi.order_id 
							  WHERE ((o.ordertype='trial' AND o.status=6) OR (o.ordertype='package' AND oi.status=3)) AND o.userid = ".$kitchen_id."
                            ")->result();

            if(!empty($res)){
                $total_earning = number_format($res['total'],2,'.','');
            }else{
                $total_earning = 0;
            }

            $res = $db->pdoQuery("SELECT IFNULL(SUM(kwp.amount),0) as total
                                FROM kitchenwithdrawpayment as kwp
                                WHERE kwp.kitchen_id = ".$kitchen_id."
                                ")->result();

            if(!empty($res)){
                $total_withdraw = number_format($res['total'],2,'.','');
            }else{
                $total_withdraw = 0;
            }

            $wallet_balance = $total_earning - $total_withdraw;
            
            if($withdraw_amount <= $wallet_balance){
                $wallet = $wallet_balance - $withdraw_amount;

                $update_array = array(
                    "wallet"       => $wallet,
                    "modifieddate" => date("Y-m-d H:i:s")
                );
                $db->update("user",$update_array,array('id'=>$kitchen_id));

                //Insert in withdraw table
                $insert_array = array(
                    "kitchen_id"  => $kitchen_id,
                    "amount"      => $withdraw_amount,
                    "wallet_amount" => $wallet,
                    "createddate" => date("Y-m-d H:i:s"),
                    "modifieddate" => date("Y-m-d H:i:s")
                );
                $db->insert("kitchenwithdrawpayment",$insert_array);

                APIsuccess("Withdrawal request has been sent successfully.");

            }else{

                APIError("You don't have enough balance for withdrawal.");

            }
            
        }
        else
        {
            APIError("No any account available for withdrawal.");
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
