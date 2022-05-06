<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{   
    if($name != '' && $email != ''){

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $checkEmail =  $db->count("user",array("email"=>$email));

            if($checkEmail <= 0)
            {
            
				$customerid = time();
				$password = generateRandomString(8);

				$insert_array = array(
					"usertype"       => 1,
					"kitchenname"    => $name,
					"email"          => $email,
					"kitchenid"      => $customerid,
					"userstatus"     => 1,
					"status"         => 1,
					"createddate"    => date("Y-m-d H:i:s"),
					"modifieddate"   => date("Y-m-d H:i:s"),
					"password"       => $password
				);
				//print_r($insert_array);exit;
				$user_id = $db->insert("user",$insert_array)->getLastInsertId();
		
				$insert_array['user_id'] = $user_id;
				APIsuccess("Login successfully.",$insert_array);
                

            }else{
                
				$res = $db->select("user", array("*"), array("email" => $email));
		
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
				}

            }

        }else{
            APIError("Enter valid email address.");
        }
            
    }else{
        APIError("Fill all required fields.");
    }
}else{
	APIError("Token missing.");
}
