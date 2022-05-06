<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0 && $order_id > 0){

		$res = $db->pdoQuery("SELECT oi.id,oi.order_id,oi.reference_id,oi.item_name,oi.delivery_date,oi.status,oi.mealplan,
							    IF(oi.mealplan=2,(SELECT image FROM mastermenu WHERE id=oi.reference_id),'') as image,

                                oi.delivered_datetime
                              FROM orderitems AS oi
                              INNER JOIN orders as o ON o.id=oi.order_id
						      WHERE o.customerid=".$user_id." AND oi.order_id = ".$order_id."")->results();
		// echo '<pre>';print_r($res);exit;
		if(count($res) > 0)
		{
			foreach ($res as $key => $value) {
				
                if($value['status']==3){
                    if($value['delivered_datetime']!="0000-00-00 00:00:00"){
                        $status = "Delivered at ".date("H:i A",strtotime($value['delivered_datetime']));
                    }else{
                        $status = "Delivered";
                    }
                }else if ($value['status']==4){
                    $status = "Cancelled";
                }else {
                    $status = "To be delivered";
                }
                
                if($value['mealplan'] == 2){
                    
                    
                    $return_array[] = array(
                        "item_name" => $value['item_name'],
                        "image" => $value['image'],
                        "date" => date("d M",strtotime($value['delivery_date'])),
                        "status" => $status
                    );
                }else{

                    $menu_item = $db->pdoQuery("SELECT id,menuid,itemname,qty,price FROM order_package_menu_items WHERE orderitems_id = '".$value['id']."'")->results();
                    
                    $item_name = array();
                    if(count($menu_item) > 0){
                        foreach($menu_item as $item){
                            $item_name[] = /* ($item['qty'] > 0 ? $item['qty']." " : ""). */$item['itemname']; 
                        }
                    }
                    $item_name = implode(" + ", $item_name);

                    $return_array[] = array(
                        "item_name" => $item_name,
                        "image" => $value['image'],
                        "date" => date("d M",strtotime($value['delivery_date'])),
                        "status" => $status
                    );
                }
				
			}
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Orders not found.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



