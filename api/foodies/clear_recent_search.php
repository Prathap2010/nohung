<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0){

		$db->delete("searchhistory",array('userid'=>$userid));
		APIsuccess("Search history has been cleared.");

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



