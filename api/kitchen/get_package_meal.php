<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($kitchen_id > 0 && $package_id > 0){

        $res_pkg = $db->pdoQuery("SELECT * FROM packages as p WHERE p.id = ".$package_id)->result();

        $res = $db->pdoQuery("SELECT m.id,m.category,m.userid,m.cuisinetype,m.menutype,p.mealtype,GROUP_CONCAT(DISTINCT m.id) as menu_ids
							                FROM mastermenu as m
                              INNER JOIN packages as p ON p.id=".$package_id. "
                              WHERE m.userid=p.userid AND m.cuisinetype=p.cuisinetype AND (m.menutype=p.mealfor OR m.menutype=IF(p.mealfor!=0,3,0)) AND (m.category='Veg' OR m.category='Non Veg') AND (m.category!=IF(p.mealtype=1,'Veg','Non Veg')) AND (m.itemtype=IF(m.menutype=0,IF(p.mealtype=1,1,0),m.itemtype))
                              GROUP BY m.category
                              ORDER BY m.id DESC
                            ")->results();
		
          if(count($res) > 0)
          {
            foreach ($res as $key => $value) {
                    
              /* $menuitems = $db->pdoQuery("SELECT m.id as menu_id,m.itemname,m.itemprice
                                    FROM mastermenu as m
                                    WHERE m.userid=".$value['userid']." AND m.cuisinetype=".$value['cuisinetype']." AND (m.menutype=".$value['menutype']." OR m.menutype=IF(".$value['menutype']."!=0,3,0)) AND m.category='".$value['category']."' AND (m.itemtype=IF(m.menutype=0 AND ".$value['mealtype']."=1,1,0))
                                  ")->results(); */

              $menuitems = $db->pdoQuery("SELECT m.id as menu_id,m.itemname,m.itemprice
                                    FROM mastermenu as m
                                    WHERE m.id IN (" . $value['menu_ids'] . ")
                                  ")->results();

              $value['category'] = ($res_pkg['mealfor']==0)?($res_pkg['mealtype']==0?"Veg":"Non Veg"):$value['category'];

              $return_array[] = array(
                  "category"=>$value['category'],
                  "menuitems" => $menuitems,
              );
            }
            APIsuccess("success",$return_array);
        }else{
            APIError("You need to add items in menu !");    
        }
    }else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}