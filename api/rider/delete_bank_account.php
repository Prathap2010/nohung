<?php
require_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if ($token == API_TOKEN) {
    if (!empty($user_id) && !empty($account_id)) {
        $checkUserId = $db->count("user", array("id" => $user_id));

        if ($checkUserId > 0) {

            $checkId = $db->count("useraccountdetail", array("id" => $account_id));

            if ($checkId > 0) {
                $db->delete("useraccountdetail", array('id' => $account_id));
                
                APIsuccess("Bank account has been deleted successfully.");
            } else {
                APIError("Invalid account id.");
            }
        } else {
            APIError("Invalid user id.");
        }
    } else {
        APIError("Fill all required fields.");
    }
}
else 
{
	APIError("Token missing.");
}
