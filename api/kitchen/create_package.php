<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($kitchen_id > 0 && $package_id > 0){

        $res_pkg = $db->pdoQuery("SELECT * FROM packages as p WHERE p.id = ".$package_id." AND userid = ".$kitchen_id)->result();

        if($res_pkg){

            $update_array = array(
                "weeklyprice" => $weekly_price,                    
                "monthlyprice" => $monthly_price,
                "modifieddate" => date("Y-m-d H:i:s"),
            );
            $db->update("packages",$update_array,array("id"=>$package_id));
            
            if(!empty($day)){

                $target_dir = DIR_UPD."menu/";
                if(!is_dir($target_dir)){
                    @mkdir($target_dir);
                }
                
                foreach($day as $k=>$val){

                    $res = $db->pdoQuery("SELECT * FROM `weeklypackage` WHERE packageid=".$package_id." AND days=".$val)->result();
                    
                    if($_FILES['image'.$val]['name'] != ''){
                        $name = time();
                        $image = $name."_".$_FILES["image".$val]["name"];
                        $target_file = $target_dir .$image;
                        move_uploaded_file($_FILES["image".$val]["tmp_name"], $target_file);
                        
                        if(!empty($res) && $res['image']!=""){
                            @unlink($target_dir.$res['image']);
                        }
                    }else{
                        $image = "";
                    }
                    $defaultdishitemid = implode(",", json_decode($defaultdishitem[$k]));
                    
                    if(!empty($weekly_package_id[$k])){

                        $update_array = array(
                            "defailtdishitem"=> $defaultdishitemid,
                            "image"          => $image
                        );
                        
                        $db->update("weeklypackage",$update_array,array("id"=>$weekly_package_id[$k]));

                        $weeklypackageid = $weekly_package_id[$k];

                        $db->delete("weeklypackagemenu",array("weeklypackageid"=>$weeklypackageid));

                    }else{

                        $insert_array = array(
                            "packageid"      => $package_id,
                            "days"           => $val,
                            "defailtdishitem"=> $defaultdishitemid,
                            "image"          => $image
                        );
                        
                        $weeklypackageid = $db->insert("weeklypackage",$insert_array)->getLastInsertId();
                        
                    }

                    $price = 0;
                    if(!empty($menuitems[$val])){
                        foreach($menuitems[$val] as $menu_item){
                            
                            $res_menu = $db->pdoQuery("SELECT * FROM `mastermenu` WHERE id=".$menu_item['menu_id'])->result();
                            
                            $qty = 0;
                            if($res_menu['category'] == "Bread"){
                                $qty = $menu_item['qty'];
                            } 
                            $price += $res_menu['itemprice'] * ($qty > 0 ? $qty : 1);

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
                    
                }
            }
            APIsuccess("Package has been created.",$return_array);
        }else{
            APIError("Invalid package id !");    
        }
    }else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}