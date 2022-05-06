<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if(isset($kitchen_id) AND $kitchen_id > 0)
    {
        if(isset($menu_id) AND $menu_id > 0)
        {
            $checkMenuId = $db->count("mastermenu",array("id"=>$menu_id,"userid"=>$kitchen_id));

            if($checkMenuId > 0)
            {
                $db->delete("mastermenu",array("id"=>$menu_id));

                APIsuccess("Menu item has been deleted successfully.");
            }
            else
            {
                APIError("Invalid menu id.");
            }
        }
        else
        {
            APIError("Invalid menu id.");
        }
    }
    else
    {
        APIError("Invalid user id.");
    }
}
else 
{
	APIError("Token missing.");
}
