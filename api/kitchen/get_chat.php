<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if($kitchen_id > 0){

		$res_admin = $db->pdoQuery("SELECT * FROM admin")->result();

		$res = $db->pdoQuery("SELECT DATE(am.createddate) AS createddate,TIME_FORMAT(TIME(am.createddate),'%h:%i %p') AS time,am.msg_type,am.message 
	                      FROM adminmessages as am 
						  INNER JOIN user as k ON k.id = am.userid AND k.usertype=0 
						  WHERE am.userid = ".$kitchen_id. "
						  ORDER BY am.id ASC")->results();
		// print_r($res);exit;
		$chat = array();
		if(count($res) > 0)
		{
			foreach ($res as $row) {

				if($row['msg_type'] == 'usertoadmin'){
					$row['msg_type'] = 'sent';
				}else{
					$row['msg_type'] = 'received';
				}

				$chat[] = $row;
			}
		}
		if($res_admin['image']!="" && file_exists(PROFILE_PATH. $res_admin['image'])){
			$img = PROFILE.$res_admin['image'];
		}else{
			$img = NOPROFILEIMAGE;
		}
		$return_array = array(
			"admin_name" 	=> $res_admin['firstname']." ". $res_admin['lastname'],
			"admin_email" 	=> $res_admin['email'],
			"admin_image" 	=> $img,
			"chat" 			=> $chat,
		);
		
		APIsuccess("success", $return_array);

	}else{
		APIError("Invalid kitchen id.");
	}	
}
else
{
	APIError("Token missing.");
}



