<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
	if($email != "" && $password != "")
	{
		$res = $db->select("user", array("*"), array("email" => $email, "password" => $password));
		
		if ($res->affectedRows() >= 1) 
		{
			$result = $res->result();

			if ($result['status'] == 0) 
			{
				APIError("Your account is not activated");		
			}
			else if ($result['userstatus'] == 0) 
			{
				APIError("Admin side approval is pending.");		
			} 
			else 
			{
				APIsuccess("Login successfully.",$result);
			}
		}else{
			APIError("Invalid email or password.");		
		}
	}else{
		APIError("Fill all required fields.");
	}	
}
else {
	APIError("Token missing.");
}
