<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if($kitchen_id > 0 && $menu_id > 0 && $instock != "")
    {
        $checkMenuId = $db->count("mastermenu",array("id"=>$menu_id,"userid"=>$kitchen_id));

        if($checkMenuId > 0)
        {
            $update_array = array("instock"=>$instock,"modifieddate"=>date("Y-m-d H:i:s")); 

            $db->update("mastermenu",$update_array,array("id"=>$menu_id));

            APIsuccess("Item stock updated.");            
        }
        else
        {
            APIError("Invalid menu id.");
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
