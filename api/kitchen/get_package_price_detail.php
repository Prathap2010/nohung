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
            $res = $db->pdoQuery("SELECT p.*, IFNULL((SELECT SUM(price) FROM weeklypackage WHERE packageid = p.id),0) as weekly_package_price FROM packages as p WHERE p.id='".$package_id."' AND p.userid = '".$kitchen_id."'")->result();
        
            if($res)
            {

                $res_week = $db->pdoQuery("SELECT w.id,w.days,w.price FROM weeklypackage as w WHERE w.packageid='".$package_id."'")->results();

                $startday = date("d",strtotime($res['startdate']));
                $startdate = $res['startdate'];
                $firstDay = date("d",strtotime('first day of this month', time()));
                $lastDay = date("d",strtotime('last day of this month', time()));
                
                $remaindays = $lastDay - $startday + 1;
                $temp = $remaindays / 7;
                $weeks = $temp;
                $extradays = $remaindays - (7 * $weeks);

                $montlyactualprice = $res['weekly_package_price'] * $weeks;

                for($i=0; $i < $extradays;$i++){
                    if(!empty($res_week)){
                        $key = array_search($i, array_column($res_week, "days"));
                        if(trim($key)!="" && isset($res_week[$key])){
                            $price = $res_week[$key]['price'];
                            if($price!=""){
                                $montlyactualprice += $price;
                            }
                        }
                    }
                }

                
                
                $return_array = array(
                    "package_id"       =>  $res['id'],
                    "actual_weekly_package"   =>  number_format($res['weekly_package_price'],2,'.',''),
                    "actual_monthly_package"  =>  number_format($montlyactualprice,2,'.',''),
                    "weekly_price"     =>  number_format($res['weeklyprice'],2,'.',''),
                    "monthly_price"    =>  number_format($res['monthlyprice'],2,'.',''),
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
