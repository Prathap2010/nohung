
<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if ($token == API_TOKEN) 
{
    if (isset($user_id) and $user_id > 0)
    {
        $checkUserId = $db->count("user", array("id" => $user_id));

        if ($checkUserId > 0) {
            $res = $db->pdoQuery("SELECT * FROM useraccountdetail WHERE userid = ". $user_id." ORDER BY id DESC ")->results();

            if(count($res) > 0)
            {
                foreach ($res as $key => $value) {
                    
                    $account_number = decrypt($value['account_number']);
                    $ifsc_code = decrypt($value['ifsc_code']);

                    $return_array[] = array(
                        "account_id" => $value['id'],
                        "account_name" => $value['account_name'],
                        "bank_name" => $value['bank_name'],
                        "ifsc_code" => $ifsc_code,
                        "account_number" => $account_number,
                        "createddate" => date("d-m-Y h:i A", strtotime($value['createddate'])),
                    );
                }
                APIsuccess("success",$return_array);
            }
            else
            {
                APIError("Account not found.");
            }
        } else {
            APIError("Invalid user id.");
        }
	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



