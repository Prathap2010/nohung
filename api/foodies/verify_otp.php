<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
	if($mobilenumber != "")
	{
		$res = $db->select("user", array("*"), array("mobilenumber" => $mobilenumber, "usertype"=>1));
		
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
				$res = $db->select("user", array("*"), array("mobilenumber" => $mobilenumber,'otpcode'=>$otp));
				if ($res->affectedRows() >= 1) {
					
					$result = $res->result();
					APIsuccess("Login successfully.",$result);

				}else{
					APIError("Invalid otp.");
				}
			}
		}else{
			APIError("Invalid mobile number.");		
		}
	}else{
		APIError("Fill all required fields.");
	}	
}
else {
	APIError("Token missing.");
}
