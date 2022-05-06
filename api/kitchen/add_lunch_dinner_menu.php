<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if($kitchen_id > 0 && $cuisinetype != "" && $category != "")
    {
        if(is_array($itemname) && count($itemname) > 0)
        {
            $target_dir = DIR_UPD."menu/";
            if(!is_dir($target_dir)){
                @mkdir($target_dir);
            }
            
            foreach($itemname as $k=>$item_name){

                $itemtype = ($category == "Non Veg") ? 1 : 0;

                if($_FILES['item_image'.($k+1)]['name'] != ''){
                    $name = time();
                    $image = $name."_".$_FILES['item_image'.($k+1)]["name"];
                    $target_file = $target_dir .$image;
                    move_uploaded_file($_FILES['item_image'.($k+1)]["tmp_name"], $target_file);
                }else{
                    $image = "";
                }
                
                $insert_array = array(
                    "userid"        => $kitchen_id,
                    "cuisinetype"   => $cuisinetype,
                    "menutype"      => (!empty($menutype[$k]) ? $menutype[$k] : 1),
                    "itemname"      => $item_name,
                    "itemprice"     => $price[$k],
                    "instock"       => 1,
                    "image"         => $image,
                    "category"      => $category,
                    "itemtype"      => $itemtype,
                    "createddate"   => date("Y-m-d H:i:s"),
                    "modifieddate"  => date("Y-m-d H:i:s")
                ); 

                $db->insert("mastermenu",$insert_array);
            }
        }

        APIsuccess("Lunch & dinner menu item has been added successfully.");            
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
