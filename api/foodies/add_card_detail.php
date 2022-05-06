<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($userid > 0 && $card_name != '' && $card_number != '' && $holder_name != '' && $valid_thru != '' && $cvv != '' && $is_default){

		$target_dir = DIR_UPD."cards/";
		if(!is_dir($target_dir)){
			@mkdir($target_dir);
		}
		$image = "";
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){
			$name = time();
			$image = $name."_".$_FILES['image']["name"];
			$target_file = $target_dir .$image;
			move_uploaded_file($_FILES['image']["tmp_name"], $target_file);
		}
		
		$data_array = array(
			"userid"      => $userid,
			"card_name" => $card_name,
			"card_number" => encrypt($card_number),
			"cvv" => encrypt($cvv),
			"holder_name" => $holder_name,
			"valid_thru"  => encrypt($valid_thru),
			"is_default" => $is_default,
			"image" => $image,
			"created_date" => date("Y-m-d H:i:s")
		);
		
		if($is_default == 'y'){
			$db->update("cards",array('is_default'=>'n'),array('userid'=>$userid));
		}
		$id = $db->insert("cards",$data_array)->getLastInsertId();
		
		APIsuccess("Card has been saved successfully.");

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



