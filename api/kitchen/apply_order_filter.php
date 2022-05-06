<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if(isset($kitchen_id) AND $kitchen_id > 0)
    {
        $fromdate = !empty($fromdate) ? date("Y-m-d", strtotime(str_replace('/', '-',$fromdate))) : "";
        $todate = !empty($todate) ? date("Y-m-d", strtotime(str_replace('/', '-',$todate))) : "";
        $order_number = !empty($order_number) ? $order_number : "";

        $isExist = $db->count("kitchen_order_filters",array("kitchen_id"=>$kitchen_id));
        
        if($isExist <= 0)
        {
            $insert_array = array(
                "kitchen_id"     => $kitchen_id,
                "fromdate"       => $fromdate,
                "todate"         => $todate,
                "order_number"   => $order_number
            );
            
            $db->insert("kitchen_order_filters",$insert_array);
        }else {

            $update_array = array(
                "kitchen_id"     => $kitchen_id,
                "fromdate"       => $fromdate,
                "todate"         => $todate,
                "order_number"   => $order_number
            );

            $db->update("kitchen_order_filters",$update_array,array("kitchen_id"=>$kitchen_id));
        }   
        APIsuccess("Filter applied."); 
    }
    else
    {
        APIError("User not found.");
    }
}
else 
{
	APIError("Token missing.");
}
