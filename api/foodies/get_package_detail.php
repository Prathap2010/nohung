<?php
include_once("../include/config.php");

extract($_REQUEST);

$return_array = array();

if($_POST['token'] == API_TOKEN)
{
	if($package_id > 0 && $book_type != ""){

		$res = $db->pdoQuery("SELECT p.id,p.userid,p.packagename,p.cuisinetype,p.mealfor,p.mealtype,p.weeklyplantype,p.monthlyplantype,p.including_saturday,p.including_sunday,p.monthlyprice,p.weeklyprice,p.startdate
            FROM packages as p
            WHERE p.id='".$package_id."'")->result();
		
		if($res)
		{
            $iteam_array = array();
            
            $days = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");

            $menus = $db->pdoQuery("select w.id as weeklypackageid,w.days, (SELECT GROUP_CONCAT(wpm.itemname SEPARATOR ', ') FROM weeklypackagemenu as wpm WHERE wpm.weeklypackageid=w.id) AS item_name,
            
            (SELECT GROUP_CONCAT(IF(wpm.qty > 0 AND m.category='Bread', CONCAT(wpm.qty,' ',m.itemname), m.itemname) SEPARATOR ', ') 
                FROM weeklypackagemenu as wpm 
                LEFT JOIN mastermenu as m ON m.id=wpm.menuid
                WHERE wpm.weeklypackageid=w.id) AS menu_item_name,

            (SELECT GROUP_CONCAT(wpm.id) FROM weeklypackagemenu as wpm WHERE wpm.weeklypackageid=w.id) AS menu_item_ids
            
            FROM weeklypackage as w where w.packageid = ".$package_id)->results();
            
            if(!empty($menus)){
                foreach($menus as $val){

                    if($val['days'] >=1 && $val['days'] <= 7){

                        $item_array = array();
                        $catRes = $db->pdoQuery("select m.id,IF(m.menutype=0, IF(m.itemtype=0,'Veg','Non Veg'),m.category) as categoryname,GROUP_CONCAT(DISTINCT wpm.id) as menu_ids          
                                                    FROM weeklypackagemenu as wpm 
                                                    INNER JOIN mastermenu as m ON m.id=wpm.menuid
                                                    where wpm.id IN (" . $val['menu_item_ids'] . ") AND weeklypackageid=". $val['weeklypackageid']."
                                                    GROUP BY m.category
                                                    ORDER BY m.id DESC
                                                ")->results();

                        if (count($catRes) > 0) {

                            foreach ($catRes as $value) {
                                
                                $menuitems = $db->pdoQuery("select m.id as item_id, m.itemname as item_name, IF(wpm.qty > 0, wpm.qty, 1) as item_qty,
                                                    itemprice as item_price           
                                                FROM weeklypackagemenu as wpm 
                                                LEFT JOIN mastermenu as m ON m.id=wpm.menuid
                                                where wpm.id IN (" . $value['menu_ids'] . ")")->results();

                                $item_array[] = array(
                                    "category" => $value['categoryname'],
                                    "menuitems" => $menuitems
                                );
                            }
                        }
                        /* $menuRes = $db->pdoQuery("select m.id as item_id, m.itemname as item_name, IF(wpm.qty > 0, wpm.qty, 1) as item_qty,
                                    itemprice as item_price           
                                FROM weeklypackagemenu as wpm 
                                LEFT JOIN mastermenu as m ON m.id=wpm.menuid
                                where wpm.id IN (". $val['menu_item_ids'].")")->results(); */


                        $iteam_array[] = array(
                            "weekly_package_id" => $val['weeklypackageid'],
                            "days"      => $val['days'],
                            "days_name" => $days[$val['days']],
                            "item_name" => $val['menu_item_name'],
                            "menu_item" => $item_array,
                        );
                        
                    }
                }
            }
            /* if($book_type == "weekly"){

            }else{
                $iteam_array[] = array("startdate"=>$res['startdate'],"enddate"=>date("Y-m-d", strtotime($res['startdate']." +30 days")));
            } */
            $return_array = array(
                "kitchen_id" => $res['userid'],
                "package_id" => $res['id'],
                "package_name" => $res['packagename'],
                "mealfor" => get_menutype($res['mealfor']),
                "mealtype" => ($res['mealtype']==0 ? 'Veg' : 'Non Veg'),
                "cuisinetype" => get_cuisinetype($res['cuisinetype']),
                "price" => ($book_type=='monthly' ? $res['monthlyprice'] : $res['weeklyprice']),
                "package_detail" => $iteam_array
            );
        
			APIsuccess("success",$return_array);
		}
		else
		{
			APIError("Package detail not found.");
		}	

	}else{
		APIError("Fill all required fields.");
	}
}
else
{
	APIError("Token missing.");
}



