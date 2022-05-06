<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
	if($mobilenumber != "")
	{
		$res = $db->select("user", array("*"), array("mobilenumber" => $mobilenumber));
		
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
				//$otpcode = generate_otp(4);
				$otpcode = '1234';
				$update_array = array(
					"otpcode"  => $otpcode,
					"modifieddate"   => date("Y-m-d H:i:s")
				);
				
				$res = array('otpcode'=>$otpcode,'mobilenumber'=>$mobilenumber,"isExistingUser"=>"1");
				$db->update("user",$update_array,array("mobilenumber"=>$mobilenumber));

				APISuccess("Verify your account by enter otp.",$res);
			}
		}else{
			
			$customerid = time();
			$password = generateRandomString(8);

			$insert_array = array(
				"usertype"       => 1,
				"mobilenumber"   => $mobilenumber,
				"kitchenid"      => $customerid,
				"userstatus"     => 1,
				"status"         => 1,
				"createddate"    => date("Y-m-d H:i:s"),
				"modifieddate"   => date("Y-m-d H:i:s"),
				"password"       => $password
			);
			//print_r($insert_array);exit;
			$user_id = $db->insert("user",$insert_array)->getLastInsertId();

			//$otpcode = generate_otp(4);
			$otpcode = '1234';
			$update_array = array(
				"otpcode"  => $otpcode,
				"modifieddate"   => date("Y-m-d H:i:s")
			);
			
			$res = array('otpcode'=>$otpcode,'mobilenumber'=>$mobilenumber, "isExistingUser" => "0");
			$db->update("user",$update_array,array("mobilenumber"=>$mobilenumber));

			APISuccess("Verify your account by enter otp.",$res);

		}
	}else{
		APIError("Fill all required fields.");
	}	
}
else {
	APIError("Token missing.");
}
