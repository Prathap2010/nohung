<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if ($_POST['token'] == API_TOKEN) {
	if ($kitchenid > 0) {

		$res = $db->pdoQuery("SELECT u.*,
			(select count(id) from feedback where kitchen_id = " . $kitchenid . ") as total_review,
			(select avg(rating) from feedback where kitchen_id = " . $kitchenid . ") as avg_review,

			IF(IFNULL((SELECT count(id) FROM favorite_kitchen WHERE customerid='" . $customer_id . "' AND kitchenid=u.id),'0')>0,1,0) as is_favourite

			FROM user as u
			WHERE id = " . $kitchenid)->results();

		//echo '<pre>';print_r($res);exit;

		//Get offers
		$date = date('Y-m-d');
		$offers = $db->pdoQuery("SELECT offercode,discounttype,discount FROM offer WHERE (userid = 0 OR userid = " . $kitchenid . ") and startdate <= '" . $date . "' and enddate >= '" . $date . "'")->results();
		//echo '<pre>';print_r($res);exit;
		if (count($offers) > 0) {
			foreach ($offers as $key => $value) {

				$offers_array[] = array(
					"offercode" => $value['offercode'],
					"discounttype" => $value['discounttype'] == 0 ? 'Percentage' : 'Flat',
					"discount" => round($value['discount'])
				);
			}
		} else {
			$offers_array = array();
		}


		$breakfast_menu_array = $lunch_menu_array = $dinner_menu_array = array();
		//Get menu
		if ($meal_plan == 'trial') {

			/* $menutype_where = 'menutype=0';
			if ($meal_for == 1) {
				$menutype_where = '(menutype=1 OR menutype=3)';
			} else if ($meal_for == 2) {
				$menutype_where = '(menutype=2 OR menutype=3)';
			} */

			$menu = $db->pdoQuery("SELECT id,itemname,itemprice,image,cuisinetype,menutype FROM mastermenu WHERE userid = " . $kitchenid . " and (itemtype = '" . $meal_type . "' OR '" . $meal_type . "' = '2') and menutype=0")->results();
			//echo '<pre>';print_r($menu);exit;
			if (count($menu) > 0) {
				foreach ($menu as $key => $value) {

					$breakfast_menu_array[] = array(
						"itemid" => $value['id'],
						"book_type" => 'trial',
						"image" => SITE_UPD . 'menu/' . $value['image'],
						"itemname" => $value['itemname'],
						"itemprice" => $value['itemprice'],
						"cuisinetype" => get_cuisinetype($value['cuisinetype']),
						"including" => ""
					);
				}
			} else {
				// $breakfast_menu_array[] = 'No menu available';
			}

			$menu = $db->pdoQuery("SELECT id,itemname,itemprice,image,cuisinetype,menutype FROM mastermenu WHERE userid = " . $kitchenid . " and (itemtype = '" . $meal_type . "' OR '" . $meal_type . "' = '2') and (menutype=1 OR menutype=3)")->results();
			
			if (count($menu) > 0) {
				foreach ($menu as $key => $value) {

					$lunch_menu_array[] = array(
						"itemid" => $value['id'],
						"book_type" => 'trial',
						"image" => SITE_UPD . 'menu/' . $value['image'],
						"itemname" => $value['itemname'],
						"itemprice" => $value['itemprice'],
						"cuisinetype" => get_cuisinetype($value['cuisinetype']),
						"including" => ""
					);
				}
			} else {
				// $lunch_menu_array[] = 'No menu available';
			}

			$menu = $db->pdoQuery("SELECT id,itemname,itemprice,image,cuisinetype,menutype FROM mastermenu WHERE userid = " . $kitchenid . " and (itemtype = '" . $meal_type . "' OR '" . $meal_type . "' = '2') and (menutype=2 OR menutype=3)")->results();
			
			if (count($menu) > 0) {
				foreach ($menu as $key => $value) {

					$dinner_menu_array[] = array(
						"itemid" => $value['id'],
						"book_type" => 'trial',
						"image" => SITE_UPD . 'menu/' . $value['image'],
						"itemname" => $value['itemname'],
						"itemprice" => $value['itemprice'],
						"cuisinetype" => get_cuisinetype($value['cuisinetype']),
						"including" => ""
					);
				}
			} else {
				// $dinner_menu_array[] = 'No menu available';
			}
		}

		if ($meal_plan == 'weekly') {

			$menu = $db->pdoQuery("SELECT id,packagename,weeklyprice,cuisinetype,including_saturday,including_sunday FROM packages WHERE userid = " . $kitchenid . " and (mealtype = '" . $meal_type . "' OR '" . $meal_type . "' = '2') and mealfor = 0 and weeklyplantype = 1")->results();
			
			if (count($menu) > 0) {

				foreach ($menu as $key => $value) {

					$including = "";
					if ($value['including_saturday'] == 1) {
						$including .= 'Saturday' . ($value['including_sunday'] == 1 ? ", " : "");
					}
					if ($value['including_sunday'] == 1) {
						$including .= 'Sunday';
					}

					$breakfast_menu_array[] = array(
						"itemid" => $value['id'],
						"book_type" => 'weekly',
						"itemname" => $value['packagename'],
						"cuisinetype" => get_cuisinetype($value['cuisinetype']),
						"including" => $including,
						"itemprice" => $value['weeklyprice'],
						"image" => "",
					);
				}
			} else {
				// $breakfast_menu_array[] = 'No menu available';
			}

			$menu = $db->pdoQuery("SELECT id,packagename,weeklyprice,cuisinetype,including_saturday,including_sunday FROM packages WHERE userid = " . $kitchenid . " and (mealtype = '" . $meal_type . "' OR '" . $meal_type . "' = '2') and mealfor = 1 and weeklyplantype = 1")->results();

			if (count($menu) > 0) {

				foreach ($menu as $key => $value) {

					$including = "";
					if ($value['including_saturday'] == 1) {
						$including .= 'Saturday' . ($value['including_sunday'] == 1 ? ", " : "");
					}
					if ($value['including_sunday'] == 1) {
						$including .= 'Sunday';
					}

					$lunch_menu_array[] = array(
						"itemid" => $value['id'],
						"book_type" => 'weekly',
						"itemname" => $value['packagename'],
						"cuisinetype" => get_cuisinetype($value['cuisinetype']),
						"including" => $including,
						"itemprice" => $value['weeklyprice'],
						"image" => "",
					);
				}
			} else {
				// $lunch_menu_array[] = 'No menu available';
			}

			$menu = $db->pdoQuery("SELECT id,packagename,weeklyprice,cuisinetype,including_saturday,including_sunday FROM packages WHERE userid = " . $kitchenid . " and (mealtype = '" . $meal_type . "' OR '" . $meal_type . "' = '2') and mealfor = 2 and weeklyplantype = 1")->results();

			if (count($menu) > 0) {

				foreach ($menu as $key => $value) {

					$including = "";
					if ($value['including_saturday'] == 1) {
						$including .= 'Saturday' . ($value['including_sunday'] == 1 ? ", " : "");
					}
					if ($value['including_sunday'] == 1) {
						$including .= 'Sunday';
					}

					$dinner_menu_array[] = array(
						"itemid" => $value['id'],
						"book_type" => 'weekly',
						"itemname" => $value['packagename'],
						"cuisinetype" => get_cuisinetype($value['cuisinetype']),
						"including" => $including,
						"itemprice" => $value['weeklyprice'],
						"image" => "",
					);
				}
			} else {
				// $dinner_menu_array[] = 'No menu available';
			}
		}

		if ($meal_plan == 'monthly') {

			$menu = $db->pdoQuery("SELECT id,packagename,monthlyprice,cuisinetype,including_saturday,including_sunday FROM packages WHERE userid = " . $kitchenid . " and (mealtype = '" . $meal_type . "' OR '" . $meal_type . "' = '2') and mealfor = 0 and monthlyplantype = 1")->results();
			
			if (count($menu) > 0) {

				foreach ($menu as $key => $value) {

					if ($value['including_saturday'] == 1) {
						$including_saturday = 'Saturday';
					}
					if ($value['including_sunday'] == 1) {
						$including_sunday = 'Sunday';
					}

					$breakfast_menu_array[] = array(
						"itemid" => $value['id'],
						"book_type" => 'monthly',
						"itemname" => $value['packagename'],
						"cuisinetype" => get_cuisinetype($value['cuisinetype']),
						"including" => $including_saturday . ',' . $including_sunday,
						"itemprice" => $value['monthlyprice'],
						"image" => "",
					);
				}
			} else {
				// $breakfast_menu_array[] = 'No menu available';
			}

			$menu = $db->pdoQuery("SELECT id,packagename,monthlyprice,cuisinetype,including_saturday,including_sunday FROM packages WHERE userid = " . $kitchenid . " and (mealtype = '" . $meal_type . "' OR '" . $meal_type . "' = '2') and mealfor = 1 and monthlyplantype = 1")->results();

			if (count($menu) > 0) {

				foreach ($menu as $key => $value) {

					if ($value['including_saturday'] == 1) {
						$including_saturday = 'Saturday';
					}
					if ($value['including_sunday'] == 1) {
						$including_sunday = 'Sunday';
					}

					$lunch_menu_array[] = array(
						"itemid" => $value['id'],
						"book_type" => 'monthly',
						"itemname" => $value['packagename'],
						"cuisinetype" => get_cuisinetype($value['cuisinetype']),
						"including" => $including_saturday . ',' . $including_sunday,
						"itemprice" => $value['monthlyprice'],
						"image" => "",
					);
				}
			} else {
				// $lunch_menu_array[] = 'No menu available';
			}

			$menu = $db->pdoQuery("SELECT id,packagename,monthlyprice,cuisinetype,including_saturday,including_sunday FROM packages WHERE userid = " . $kitchenid . " and (mealtype = '" . $meal_type . "' OR '" . $meal_type . "' = '2') and mealfor = 2 and monthlyplantype = 1")->results();

			if (count($menu) > 0) {

				foreach ($menu as $key => $value) {

					if ($value['including_saturday'] == 1) {
						$including_saturday = 'Saturday';
					}
					if ($value['including_sunday'] == 1) {
						$including_sunday = 'Sunday';
					}

					$dinner_menu_array[] = array(
						"itemid" => $value['id'],
						"book_type" => 'monthly',
						"itemname" => $value['packagename'],
						"cuisinetype" => get_cuisinetype($value['cuisinetype']),
						"including" => $including_saturday . ',' . $including_sunday,
						"itemprice" => $value['monthlyprice'],
						"image" => "",
					);
				}
			} else {
				// $dinner_menu_array[] = 'No menu available';
			}
		}


		if (count($res) > 0) {
			foreach ($res as $key => $value) {

				$time = date('H:i');
				if ($time >= $value['fromtime'] && $time <= $value['totime']) {
					$open_status = 'Open Now';
				} else {
					$open_status = 'Closed';
				}
				$return_array[] = array(
					"kitchen_id" => $value['id'],
					"kitchenname" => $value['kitchenname'],
					"foodtype" => $value['foodtype'],
					"address" => $value['address'],
					"timing" => date("h:i A", strtotime($value['fromtime'])) . ' to ' . date("h:i A", strtotime($value['totime'])),
					"open_status" => $open_status,
					"total_review" => $value['total_review'],
					"avg_review" => round($value['avg_review']),
					"is_favourite" => $value['is_favourite'],
					"offers" => $offers_array,
					"breakfast" => array("menu" => $breakfast_menu_array),
					"lunch" => array("menu" => $lunch_menu_array),
					"dinner" => array("menu" => $dinner_menu_array)
				);
			}
			APIsuccess("success", $return_array);
		} else {
			APIError("Kitchen not found.");
		}
	} else {
		APIError("Fill all required fields.");
	}
} else {
	APIError("Token missing.");
}
