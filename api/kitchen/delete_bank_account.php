<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
    if(isset($id) AND $id > 0)
	{

        $checkId = $db->count("kitchenaccount",array("id"=>$id));

        if($checkId > 0)
        {
            $db->delete("kitchenaccount", array('id' => $id));
            
            APIsuccess("Bank account has been deleted successfully.");
        }
        else
        {
            APIError("Invalid id.");
        }

    }
    else
    {
        APIError("Id invalid.");
    }	
}
else 
{
	APIError("Token missing.");
}
