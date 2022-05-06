<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if($kitchen_id > 0 && $orderitems_id > 0)
    {
        $res = $db->pdoQuery("SELECT oi.order_id,o.ordertype
                                FROM orderitems as oi
                                INNER JOIN orders AS o ON o.id = oi.order_id
                                WHERE oi.id=".$orderitems_id."
                            ")->result();
                                    
        if($res['ordertype'] == 'trial'){
            $exist =  $db->count("orders",array("status"=>3,'id'=>$res['order_id']));
    
            if($exist == 0){
                //Update order status
                $update_array = array(
                    "status"  => 3,
                    "modifieddate"  => date("Y-m-d H:i:s"),
                );

                $db->update("orders",$update_array,array("id"=>$res['order_id']));
                
                APIsuccess("You have ready to pick this order.");
            }else{
                APIError("This order has been already picked.");
            }
        }else{
            $exist =  $db->count("orderitems",array("status"=>0,'id'=>$orderitems_id));
    
            if($exist == 0){
                //Update order status
                $update_array = array(
                    "status"  => 0
                );

                $db->update("orderitems",$update_array,array("id"=>$orderitems_id));
                
                APIsuccess("You have ready to pick this order.");
            }else{
                APIError("This order has been already picked.");
            }
        }
	}else{
		APIError("Fill all required fields.");
	}	
}
else
{
	APIError("Token missing.");
}