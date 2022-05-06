<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
	if(isset($_POST['kitchen_id'])   AND $_POST['kitchen_id']   != "" AND
	   isset($_POST['password'])  AND $_POST['password'] != "")
	{
		$res = $db->select("user", array("*"), array("kitchenid" => $kitchen_id, "password" => $password));
		
		if ($res->affectedRows() >= 1) 
		{
			$result = $res->result();

			if ($result['status'] == 0) 
			{
				APIError("Your account deactived");		
			}
			else if ($result['userstatus'] == 0) 
			{
				APIError("Approval pending from admin site.");		
			} 
			else 
			{
				APIsuccess("Login successfully.",$result);
			}
		}
		else
		{
			APIError("Username and password wrong.");		
		}
	}
	else
	{
		APIError("Username and password wrong.");
	}	
}
else {
	APIError("Token missing.");
}
