<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($user_id > 0 && $package_id > 0 && $weekly_package_id > 0 && $menu_items){

        $menuitems = json_decode($menu_items, true);
        
        if(!empty($menuitems)){
            foreach($menuitems as $menu_item){

                $res = $db->pdoQuery("SELECT id,qty,itemprice
                                    FROM order_customized_package_item as o
                                    WHERE o.userid=".$user_id." AND o.packageid=".$package_id." AND o.weeklypackageid=".$weekly_package_id." AND o.menuid=".$menu_item['menu_id'])->result();
                
                if(!empty($res))
                {
                    $update_array = array("qty"=>$menu_item['quantity']);
                    if($menu_item['quantity'] > 0){
                        $db->update('order_customized_package_item',$update_array,array('id'=>$res['id']));
                    }else{
                        $db->delete("order_customized_package_item",array("id"=>$res['id']));
                    }
                }
                else
                {
                    if($menu_item['quantity'] > 0){
                        
                        $insert_array = array("userid"=>$user_id,
                                    "packageid"=>$package_id,
                                    "weeklypackageid"=>$weekly_package_id,
                                    "menuid"=>$menu_item['menu_id'],
                                    "qty"=>$menu_item['quantity'],
                                    "itemprice"=>$menu_item['itemprice']
                                );
            
                        $db->insert("order_customized_package_item", $insert_array);
                    }
                }	
            }
        }
        APIsuccess("Package item customized.",$return_array);
	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



