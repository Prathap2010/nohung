<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($kitchen_id) AND $kitchen_id > 0)
	{
        if(!empty($package_id) && !empty($day) && !empty($item_detail))
	    {
            $checkPackageId = $db->count("packages",array("id"=>$package_id,"userid"=>$kitchen_id));
    
            if($checkPackageId > 0)
            {
                // $return_array = json_decode($item_detail, true);
                // APIsuccess("Test", $return_array);
                
                $defaultdishitemid = implode(",", json_decode($defaultdishitem));
                    
                $res_weeklypackage = $db->pdoQuery("SELECT * FROM `weeklypackage` WHERE packageid=".$package_id." AND days='".$day."'")->result();
                // $weekly_package_id = !empty($res_weeklypackage) && empty($weekly_package_id) ? $res_weeklypackage['id'] : $weekly_package_id;

                if(!empty($res_weeklypackage)){

                    $update_array = array(
                        "defailtdishitem"=> $defaultdishitemid
                    );
                    
                    $db->update("weeklypackage",$update_array,array("id"=>$res_weeklypackage['id']));

                    $weeklypackageid = $res_weeklypackage['id'];

                    $db->delete("weeklypackagemenu",array("weeklypackageid"=>$weeklypackageid));

                }else{

                    $insert_array = array(
                        "packageid"      => $package_id,
                        "days"           => $day,
                        "defailtdishitem"=> $defaultdishitemid
                    );
                    
                    $weeklypackageid = $db->insert("weeklypackage",$insert_array)->getLastInsertId();
                    
                }

                $menuitems = json_decode($item_detail, true);
                $price = 0;
                if(!empty($menuitems)){
                    foreach($menuitems as $menu_item){
                        
                        $res_menu = $db->pdoQuery("SELECT * FROM `mastermenu` WHERE id=".$menu_item['menu_id'])->result();
                        
                        $qty = $menu_item['quantity'];
                        $price += $res_menu['itemprice'] * $qty;

                        $insert_menu = array(
                            "weeklypackageid" => $weeklypackageid,
                            "menuid"    => $menu_item['menu_id'],
                            "itemname"  => $res_menu['itemname'],
                            "qty"       => $qty,
                            "price"     => $res_menu['itemprice']
                        );

                        $db->insert("weeklypackagemenu", $insert_menu);
                    }
                }

                $update_array = array("price" => $price);
                
                $db->update("weeklypackage",$update_array,array("id"=>$weeklypackageid));

                APIsuccess("Success", $return_array);
            }
            else
            {
                APIError("Invalid package id.");
            }
        }else{
            APIError("Fill all required fields.");
        }
    }
    else
    {
        APIError("User invalid.");
    }	
}
else 
{
	APIError("Token missing.");
}
