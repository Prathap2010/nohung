<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if ($_POST['token'] == API_TOKEN) {
	if (isset($state_id) and $state_id > 0) {
		$res = $db->pdoQuery("SELECT * FROM city WHERE stateid = '" . $state_id . "' ORDER BY id ASC ")->results();

		if (count($res) > 0) {
			foreach ($res as $key => $value) {

				$return_array[] = array(
					"city_id"      => $value['id'],
					"name"         => $value['name'],
				);
			}
			APIsuccess("success", $return_array);
		} else {
			APIError("City not found.");
		}
	} else {
		APIError("state id not found.");
	}
} else {
	APIError("Token missing.");
}
