<?php

class Package_model extends Common_model {

	//put your code here
	public $_table = 'packages';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $_order;

	function __construct() {
		parent::__construct();
	}
	
	function getKitchenPackages($limit,$offset=0,$PostData="", $count=0){

		$this->db->select("*");
		$this->db->from($this->_table);
		$this->db->where("userid='".$PostData['kitchenid']."'");
		$this->db->order_by("id","DESC");
		if($count == 0){
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		
		if($count == 1){
			return $query->num_rows();
		}else{
			return $query->result_array();
		}
	}
	function getPackagesInApp($limit,$userid){

		$this->db->select("*");
		$this->db->from($this->_table);
		$this->db->where("userid='".$userid."'");
		$this->db->order_by("id","DESC");
		if($limit!=-1){
			$this->db->limit($limit,0);
		}
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function getPackageDataById($id){
		
		$query = $this->db->select("*")
				->from($this->_table)
				->where("id=".$id)
				->get();

		return $query->row_array();
	}
	function getWeeklyPackageData($packageid)
	{

		$query = $this->db->select("w.id,w.packageid,w.days,w.menu,w.defailtdishitem,w.price,w.image,
			(SELECT GROUP_CONCAT(itemname SEPARATOR ', ') FROM mastermenu WHERE FIND_IN_SET(id,w.menu)>0) as menuitem")
		->from("weeklypackage as w")
		->where("w.packageid=" . $packageid)
			->get();

		$data = $query->result_array();

		if (!empty($data)) {
			foreach ($data as $k => $row) {
				$query = $this->db->select("wpm.id,wpm.weeklypackageid,wpm.menuid,wpm.itemname,wpm.qty,wpm.price,
						IFNULL(m.itemname,'') as item,
						IF(wpm.qty > 1, CONCAT(wpm.qty,' ',m.itemname), m.itemname) as item_name
						")
				->from("weeklypackagemenu as wpm")
				->join("mastermenu as m", "m.id=wpm.menuid", "LEFT")
				->where("wpm.weeklypackageid=" . $row['id'])
				->get();

				$menuitemdetail = $query->result_array();

				$data[$k]['menuitemdetail'] = $menuitemdetail;

				$data[$k]['menudata'] = $this->getMenuByPackageOrWeeklyPackage($packageid, $row['id']);
			}
		}
		return $data;
	}
	function CheckPackageAvailable($packagename,$id='')
    {
		$USERID = $this->session->userdata(base_url().'FRONTUSERID');
        if (isset($id) && $id != '') {
            $query = $this->db->query("SELECT id FROM packages WHERE userid=".$USERID." AND packagename ='".$packagename."' AND id <> '".$id."'");
        }else{
            $query = $this->db->query("SELECT id FROM packages WHERE userid=".$USERID." AND packagename ='".$packagename."'");
        }
       
        if($query->num_rows()  > 0){
            return 0;
        }
        else{
            return 1;
        }
	}
	function getMenuByPackage($packageid)
	{

		$query = $this->db->select("m.id,m.category,m.userid,m.cuisinetype,m.menutype,p.mealtype,GROUP_CONCAT(DISTINCT m.id) as menu_ids")
				->from("mastermenu as m")
				->join($this->_table . " as p", "p.id=" . $packageid, "INNER")
				->where("m.userid=p.userid AND m.cuisinetype=p.cuisinetype AND (m.menutype=p.mealfor OR m.menutype=IF(p.mealfor!=0,3,0)) AND (m.category='Veg' OR m.category='Non Veg') AND (m.category!=IF(p.mealtype=1,'Veg','Non Veg')) AND (m.itemtype=IF(m.menutype=0,IF(p.mealtype=1,1,0),m.itemtype))")
				->group_by("m.category")
				->order_by("m.id DESC")
				->get();

		$categorydata = $query->result_array();
		// echo $this->db->last_query(); exit;
		$menudata = array();
		if (!empty($categorydata)) {
			foreach ($categorydata as $category) {

				/* $query = $this->db->select("m.id,m.itemname,m.itemprice")
						->from("mastermenu as m")
						->where("m.userid=".$category['userid']." AND m.cuisinetype=".$category['cuisinetype']." AND (m.menutype=".$category['menutype']." OR m.menutype=IF(".$category['menutype']."!=0,3,0)) AND m.category='".$category['category']."' AND (m.itemtype=IF(m.menutype=0 AND ".$category['mealtype']."=1,1,0))")
						->get(); */

				$query = $this->db->select("m.id,m.itemname,m.itemprice")
				->from("mastermenu as m")
				->where("m.id IN (" . $category['menu_ids'] . ")")
				->get();

				$menuitems = $query->result_array();

				$menudata[] = array(
					"category" => $category['category'],
					"menuitems" => $menuitems
				);
			}
		}
		return $menudata;
	}
	function getMenuByPackageOrWeeklyPackage($packageid, $weeklypackageid)
	{

		$query = $this->db->select("m.id,m.category,m.userid,m.cuisinetype,m.menutype,GROUP_CONCAT(DISTINCT m.id) as menu_ids")
		->from("mastermenu as m")
		->join($this->_table . " as p", "p.id=" . $packageid, "INNER")
		->where("m.id IN (SELECT menuid FROM weeklypackagemenu WHERE weeklypackageid=" . $weeklypackageid . ") AND m.userid=p.userid AND m.cuisinetype=p.cuisinetype AND (m.menutype=p.mealfor OR m.menutype=IF(p.mealfor!=0,3,0)) AND (m.category='Veg' OR m.category='Non Veg') AND m.category!=IF(p.mealtype=1,'Veg','Non Veg')")
		->group_by("m.category")
		->order_by("m.id DESC")
			->get();

		$categorydata = $query->result_array();

		$menudata = array();
		if (!empty($categorydata)) {
			foreach ($categorydata as $category) {

				/* $query = $this->db->select("m.id,m.itemname,m.itemprice")
						->from("mastermenu as m")
						->where("m.id IN (SELECT menuid FROM weeklypackagemenu WHERE weeklypackageid=".$weeklypackageid.") AND m.userid=".$category['userid']." AND m.cuisinetype=".$category['cuisinetype']." AND m.menutype=".$category['menutype']." AND m.category='".$category['category']."'")
						->get(); */

				$query = $this->db->select("m.id,m.itemname,m.itemprice")
				->from("mastermenu as m")
				->where("m.id IN (" . $category['menu_ids'] . ")")
				->get();

				$menuitems = $query->result_array();

				$menudata[] = array(
					"category" => $category['category'],
					"menuitems" => $menuitems
				);
			}
		}
		return $menudata;
	}

	function getPackageListInFoodies($limit,$offset=0,$where="", $count=0){

		if($count==1){
			$this->db->select("count(p.id) as total");
		}else{
			$this->db->select("p.id,p.packagename,p.cuisinetype,p.mealtype,p.weeklyplantype,p.monthlyplantype,p.including_saturday,p.including_sunday,p.monthlyprice,p.weeklyprice");
		}
		$this->db->from("packages as p");
		$this->db->join("user as u", "u.id=p.userid", "INNER");
		$this->db->where("u.status=1 AND u.usertype=0");
		if(!empty($where)){
			$this->db->where($where);
		}

		$this->db->order_by("p.id","DESC");
		if($count==0){
			$this->db->limit($limit,$offset);
			$query = $this->db->get();
			
			return $query->result_array();
		}else{
			$query = $this->db->get()->row_array();
		
			return !empty($query['total'])?$query['total']:0;
		}
	}
	function get_package_detail($userid, $packageid){
		
		$query = $this->db->select("p.id,p.packagename,p.cuisinetype,p.mealfor,p.mealtype,p.weeklyplantype,p.monthlyplantype,p.including_saturday,p.including_sunday,p.monthlyprice,p.weeklyprice")
						->from("packages as p")
						->where("p.userid='".$userid."' AND p.id='".$packageid."'")
						->get();

		return $query->row_array(); 
	}
}
