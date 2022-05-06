<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{

	if($userid > 0){

		$res = $db->pdoQuery("SELECT DATE(c.createddate) AS createddate,TIME_FORMAT(TIME(c.createddate),'%h:%i %p') AS time,c.msg_type,c.message 
	                      FROM adminmessages as c 
						  LEFT JOIN user as u ON(u.id = c.userid)
						  WHERE c.userid = ".$userid."
						  ORDER BY c.id ASC")->results();
		//print_r($res);exit;
		if(count($res) > 0)
		{
			foreach ($res as $row) {

				if($row['msg_type'] == 'usertoadmin'){
					$row['msg_type'] = 'sent';
				}else{
					$row['msg_type'] = 'received';
				}

				$grouped[] = $row;
			}
			APIsuccess("success",$grouped);
		}
		else
		{
			APIError("Messages not found.");
		}

	}else{
		APIError("Fill all required fields.");
	}	
}
else
{
	APIError("Token missing.");
}



