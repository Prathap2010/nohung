<?php

class Cart_model extends Common_model {

	//put your code here
	public $_table = 'cart';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $_order;

	function __construct() {
		parent::__construct();
	}
	function getCartItemsByFoodiesID($id){
		
		$query = $this->db->select("c.id,c.kitchen_id,c.user_id,c.type,c.typeid,c.name,c.quantity,c.createddate,c.modifieddate,
									IF(c.type=2,IFNULL((SELECT image FROM mastermenu WHERE id=c.typeid),''),'') menuimage,

									IF(c.type=2,
										IFNULL((SELECT cuisinetype FROM mastermenu WHERE id=c.typeid),''),
										IFNULL((SELECT cuisinetype FROM packages WHERE id=c.typeid),'')
									) as cuisinetype,

									IF(c.type=2,
										IFNULL((SELECT itemprice FROM mastermenu WHERE id=c.typeid),0),
										IFNULL((SELECT (IF(c.type=0,weeklyprice,monthlyprice) + IFNULL((SELECT SUM(itemprice) FROM mastermenu WHERE id IN (SELECT menuid FROM cart_package_menu_items WHERE cart_id=c.id)),0)) FROM packages WHERE id=c.typeid),0)
									) as item_price,

									CASE 
										WHEN c.type=2 THEN 'trial' 
										WHEN c.type=1 THEN 'monthly' 
										ELSE 'weekly'
									END as mealtype,

									c.including_saturday,c.including_sunday,

									c.delivery_date,c.delivery_fromtime,c.delivery_totime")
				->from("cart as c")
				->where('c.user_id="'.$id.'"')
				->get();

		return $query->result_array();
	}
	function getCartItemsofPackageByCartID($cart_id){
		$query = $this->db->select("id,menuid,itemname,qty,IFNULL((SELECT itemprice FROM mastermenu WHERE id=menuid),'') as item_price")
				->from("cart_package_menu_items")
				->where('cart_id="'.$cart_id.'"')
				->get();

		return $query->result_array();
	}
	function getMasterMenuDataById($menuid){
		
		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("id=".$menuid)
				->get();

		return $query->row_array();
	}
	
}
