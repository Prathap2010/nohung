<?php
require_once("../include/config.php");

extract($_REQUEST);

if($_POST['token'] == API_TOKEN)
{
    if(isset($kitchen_id) AND $kitchen_id > 0)
	{

        $checkPackageId = $db->count("packages",array("id"=>$package_id,"userid"=>$kitchen_id));

        if($checkPackageId > 0)
        {
            $res = $db->pdoQuery("SELECT * FROM packages WHERE id='".$package_id."' AND userid = '".$kitchen_id."'")->result();
        
            if($res)
            {
                $res_week = $db->pdoQuery("SELECT w.id,w.packageid,w.days,w.menu,w.defailtdishitem,w.price,w.image,
                (SELECT GROUP_CONCAT(itemname SEPARATOR ', ') FROM mastermenu WHERE FIND_IN_SET(id,w.menu)>0) as menuitem FROM weeklypackage as w WHERE w.packageid='".$package_id."'")->results();

                if(!empty($res_week)){
                    foreach($res_week as $k=>$row){
                        $res_menu = $db->pdoQuery("SELECT wpm.id,wpm.weeklypackageid,wpm.menuid,wpm.itemname,wpm.qty,wpm.price,
                                                        IFNULL((SELECT itemname FROM mastermenu WHERE id=wpm.menuid),'') as item,
                                                        IF(wpm.qty > 0, CONCAT(wpm.qty,' ',wpm.itemname), wpm.itemname) as item_name 
                                                        FROM weeklypackagemenu as wpm 
                                                        WHERE wpm.weeklypackageid=".$row['id'])->results();

                        $res_week[$k]['menuitemdetail'] = $res_menu;

                        // $res_week[$k]['menudata'] = $this->getMenuByPackageOrWeeklyPackage($packageid,$row['id']);
                    }
                }

                $days = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");

                $return_week = array();
                for($i=1; $i<=7; $i++) {
                    if (in_array($i, array(1, 2, 3, 4, 5)) || ($res['including_saturday'] == 1 && $i == 6) || ($res['including_sunday'] == 1 && $i == 7)) {

                        $image = $menuitem = "";

                        if(!empty($res_week)){
                            $key = array_search($i, array_column($res_week, "days"));
                            if(trim($key)!="" && isset($res_week[$key])){
                                $image = $res_week[$key]['image'];
                                $menuitem = implode(" + ", array_column($res_week[$key]['menuitemdetail'], "item_name"));
                            }
                        }

                        $return_week[] = array(
                            "day" => $i,
                            "image" => get_menu_image($image),
                            "item_name"  => $menuitem,
                        );
                    }
                }
                $return_array = array(
                    "package_id"        =>  $res['id'],
                    "packagename"       =>  $res['packagename'],
                    "cuisinetype"       =>  get_cuisinetype($res['cuisinetype'])." Meals",
                    "mealtype"          =>  ($res['mealtype']==0) ? "Veg" : "Non Veg",
                    "mealfor"           =>  get_menutype($res['mealfor']),
                    "weekly_detail"     =>  $return_week, 
                );

                APIsuccess("success",$return_array);
            }
            else
            {
                APIError("Package not found.");
            }
        }
        else
        {
            APIError("Invalid package id.");
        }
    }
    else
    {
        APIError("User invalid.");
    }	
}
else 
{
	APIError("Token missing.");
}
