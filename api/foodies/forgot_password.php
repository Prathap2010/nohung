<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if(isset($email) AND $email != "")
	{
		$checkEmail =  $db->count("user",array("email"=>$email));

		if($checkEmail > 0){

			$password = generateRandomString(8);

			$update_array = array(
                "password"  => $password,
				"modifieddate"   => date("Y-m-d H:i:s")
            );

			$userdata = $db->select("user",array('kitchenid','kitchenname'),array('email'=>$email))->result();
			$db->update("user",$update_array,array("email"=>$email));

			$subject = 'Forgot Password';
			$content = '<p>Dear '.$userdata['kitchenname'].',<br />
                <br />
                Your new password is as per below.</p>
                
                <p>The Foodies ID of your account is&nbsp;:&nbsp;<strong>'.$userdata['kitchenid'].'</strong>&nbsp;</p>
                
                <p>The password of your account is&nbsp;: <strong>'.$password.'</strong><br />
                <br />
                &nbsp;</p>
                
                <p><strong>Thanks,</strong>
                <strong>Nohung</strong>';

			send_email($email,$subject,$content);

			APIsuccess("New password send to your email address.");

		}else{
			APIError("Email not exist.");
		}
	}
	else
	{
		APIError("Please enter your email address.");
	}	
}
else
{
	APIError("Token missing.");
}



