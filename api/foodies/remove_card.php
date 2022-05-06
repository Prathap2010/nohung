<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0 && $cardid > 0){

		$exist = $db->count("cards",array("userid"=>$userid,'id'=>$cardid));

		if($exist > 0){
			
			$res = $db->pdoQuery("SELECT *
							  FROM cards
							  WHERE id = ".$cardid)->result();

			if($res['image']!=""){
				$target_dir = DIR_UPD."cards/";
				@unlink($target_dir.$res['image']);
			}

			$db->delete("cards",array('id'=>$cardid));
			APIsuccess("Card has been removed.");

		}else{
			APIError("Invalid request.");
		}

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



