<?php

class Order_model extends Common_model {

	//put your code here
	public $_table = 'orders';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $_order;

	function __construct() {
		parent::__construct();
	}

	function getOrderCount($where=array()){
		$this->db->select('o.id');
		$this->db->from($this->_table." as o");
		if(!empty($where)){
			$this->db->where($where);
		}
		$query = $this->db->get();

		return $query->num_rows();
	}
	function getOrderItemsCount($where=array()){
		$this->db->select('o.id');
		$this->db->from($this->_table." as o");
		$this->db->join("orderitems as oi","oi.order_id = o.id","INNER");
		
		if(!empty($where)){
			$this->db->where($where);
		}
		$this->db->group_by("oi.order_id,oi.delivery_date");
		$query = $this->db->get();

		return $query->num_rows();
	}
	
	function getOrders($where="",$limit='-1'){

		$this->db->select("o.id,o.customerid,o.customer_name,o.customer_mobileno,o.deliveryaddress,
			kitchen.kitchenname,o.orderid,o.orderdate,o.orderamount,
			o.netamount,
			o.status,o.createddate, 
			'' as customerimage, netamount,delivery_time,
			o.riderid,
			IFNULL(rider.kitchenname,'') as rider_name,
			IFNULL(rider.mobilenumber,'') as rider_mobileno,
			o.ordertype,o.packagetype
		
		");
		$this->db->from($this->_table." as o");
        $this->db->join("user as foodies","foodies.id=o.customerid","LEFT");
		$this->db->join("user as kitchen","kitchen.id=o.userid","LEFT");
		$this->db->join("user as rider","rider.id=o.riderid","LEFT");

		if($where != ""){
			$this->db->where($where);
		}
		$this->db->order_by("id","DESC");
		if($limit != -1){
			$this->db->limit($limit);
		}
		$query = $this->db->get();
	
		$data = $query->result_array();

		$return_array = array();
		if(count($data) > 0)
		{
			foreach ($data as $key => $value) {
				$trial_order = $weeklyplan = $monthlyplan = "";

				if($value['ordertype'] == "trial"){

					$trial_order = $this->db->query('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->row_array();
					
					$trial_order = $trial_order['item_name'];

					$status = $value['status'];
				}else{

					$query = $this->db->select("id,mealplan,reference_id, 
												(SELECT (CASE 
													WHEN mealfor=0 THEN 'Breakfast' 
													WHEN mealfor=1 THEN 'Lunch' 
													ELSE 'Dinner'
												END) FROM packages WHERE id=reference_id) as plan")
							->from("orderitems")
							->where("order_id = '".$value['id']."'")
							->group_by("mealplan,reference_id")
							->get();
	
					$order_item = $query->result_array();
	
					$order_item_arr = !empty($order_item) ? array_column($order_item, "mealplan") : array();
					
					$keys = array_keys($order_item_arr, "0");
	
					if($keys != "" && !empty($keys)){
						foreach($keys as $key){
							if(isset($order_item[$key])){
								$weeklyplan .= $order_item[$key]['plan'].", ";
							}
						}
					}
					$keys = array_keys($order_item_arr, "1");
	
					if($keys != "" && !empty($keys)){
						foreach($keys as $key){
							if(isset($order_item[$key])){
								$monthlyplan .= $order_item[$key]['plan'].", ";
							}
						}
					}
					if($weeklyplan != ""){
						$weeklyplan = substr($weeklyplan, 0, -2);
					}
					if($monthlyplan != ""){
						$monthlyplan = substr($monthlyplan, 0, -2);
					}

					$status = $value['status'];
				}

				$return_array[] = array_merge($value, array("weekly_plan" => $weeklyplan,"monthly_plan" => $monthlyplan,"trial_orders" => $trial_order,"order_status"=>$status));
			}
		}
		return $return_array;
		
	}

	function getOrderDetailsByID($order_id){

		$this->db->select("o.id,o.customerid,o.customer_name,o.customer_mobileno,o.deliveryaddress,
			kitchen.kitchenname,o.orderid,o.orderdate,o.orderamount,
			o.status,o.createddate, 
			'' as customerimage, netamount,delivery_time,
			o.riderid,
			IFNULL(rider.kitchenname,'') as rider_name,
			IFNULL(rider.mobilenumber,'') as rider_mobileno,
			IFNULL(rider.email,'') as rider_email,
		
			foodies.email as customer_email,o.orderingforname,o.orderingformobileno,

			o.taxamount,o.deliverycharge,o.couponcode,o.couponamount,o.paymentmethod,

			kitchen.mobilenumber as kitchen_mobileno,
			kitchen.email as kitchen_email,
			kitchen.address as kitchen_address,

			tr.transaction_id,tr.amount,tr.transaction_status,tr.payment_method,tr.createddate as transactiondate,
			o.ordertype,o.packagetype
		");
		$this->db->from($this->_table." as o");
        $this->db->join("user as foodies","foodies.id=o.customerid","LEFT");
		$this->db->join("user as kitchen","kitchen.id=o.userid","LEFT");
		$this->db->join("user as rider","rider.id=o.riderid","LEFT");

		$this->db->join("transaction as tr","tr.order_id=o.id","LEFT");
        $this->db->where("o.id=".$order_id);
		$query = $this->db->get();
	
		$orderdata = $query->row_array();

		if(!empty($orderdata)){

			$query = $this->db->select("oi.id,oi.mealplan,oi.reference_id,oi.cuisinetype,oi.quantity,oi.item_price,oi.total_amount,oi.delivery_date,oi.delivery_fromtime,oi.delivery_totime,oi.including_saturday,oi.including_sunday,
							CASE
								WHEN oi.mealplan=0 THEN 'Weekly'
								WHEN oi.mealplan=1 THEN 'Monthly'
								ELSE 'Trial Meal'
							END as mealplanname,

							CASE
								WHEN oi.cuisinetype=0 THEN 'South Indian'
								WHEN oi.cuisinetype=1 THEN 'North Indian'
								ELSE 'Other Indian'
							END as cuisinetypename,

							IF(oi.mealplan=2,oi.item_name,
								IFNULL((SELECT GROUP_CONCAT(itemname ORDER BY itemname ASC SEPARATOR ' + ') AS item_name FROM order_package_menu_items WHERE orderitems_id=oi.id),'')
							) as menu_name,

							oi.status
						")
						->from("orderitems as oi")
						->where("oi.order_id=".$order_id)
						->join("mastermenu as m","oi.mealplan=2 AND m.id=oi.reference_id","LEFT")
						->join("packages as p","oi.mealplan!=2 AND p.id=oi.reference_id","LEFT")
						->get();
		
			$orderdata['orderitems'] = $query->result_array();
		}
		return $orderdata;
	}

	function getFoodiesFavoriteOrders($foodiesid){

		$query = $this->db->select("o.id,o.customerid,o.userid,o.customer_name,o.customer_mobileno,
						o.deliveryaddress,
						kitchen.kitchenname,
						o.orderid,o.orderdate,o.netamount,
						o.status,o.createddate
					")
					  ->from($this->_table." as o")
					  ->join("favorite_orders as fo","fo.orderid=o.id","INNER")
					  ->join("user as kitchen","kitchen.id=o.userid","LEFT")
					  ->where("o.customerid=".$foodiesid)
					  ->order_by("id","DESC")
					  ->get();
	
		return $query->result_array();
	}

	function getOrdersRequests($limit,$offset=0,$PostData="", $count=0){

		$where_search = "";
		if(isset($PostData['search']) && $PostData['search']!=""){
			$where_search .= " AND (o.orderid LIKE '%".$PostData['search']."%' OR o.customer_name LIKE '%".$PostData['search']."%')";
		}
		if($count==1){
			$query = "SELECT count(temp.id) as total";
		}else{
			$query = "SELECT temp.id,temp.customerid,temp.customer_name,temp.customer_mobileno,temp.deliveryaddress,temp.kitchenname,temp.orderid,temp.orderdate,temp.orderamount,temp.netamount,temp.status,temp.createddate,temp.customerimage,temp.delivery_time,temp.riderid,temp.rider_name,temp.rider_mobileno,temp.ordertype,temp.packagetype";
		}
		$query .= " FROM (
						SELECT o.id,o.customerid,o.customer_name,o.customer_mobileno,o.deliveryaddress,
						kitchen.kitchenname,o.orderid,o.orderdate,o.orderamount,
						o.netamount,
						o.status,o.createddate, 
						foodies.profile_image as customerimage, delivery_time,
						o.riderid,
						IFNULL(rider.kitchenname,'') as rider_name,
						IFNULL(rider.mobilenumber,'') as rider_mobileno,
						o.ordertype,o.packagetype
			
						FROM orders AS o
						LEFT JOIN user as foodies ON foodies.id=o.customerid
						LEFT JOIN user as kitchen ON kitchen.id=o.userid
						LEFT JOIN user as rider ON rider.id=o.riderid
						WHERE o.status=0 AND o.userid = '".$PostData['kitchenid']."'
						".$where_search."
					) as temp ";

		$query .= " ORDER BY temp.id DESC";

		if($count==0){
			$query .= " LIMIT ".$offset.",".$limit;
			$query = $this->db->query($query);
			$data = $query->result_array();

			$return_array = array();
			if(count($data) > 0)
			{
				foreach ($data as $key => $value) {
					$trial_order = $weeklyplan = $monthlyplan = "";

					if($value['ordertype'] == "trial"){

						$trial_order = $this->db->query('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->row_array();
						
						$trial_order = $trial_order['item_name'];
					}else{

						$query = $this->db->select("id,mealplan,reference_id, 
													(SELECT (CASE 
														WHEN mealfor=0 THEN 'Breakfast' 
														WHEN mealfor=1 THEN 'Lunch' 
														ELSE 'Dinner'
													END) FROM packages WHERE id=reference_id) as plan")
								->from("orderitems")
								->where("order_id = '".$value['id']."'")
								->group_by("mealplan,reference_id")
								->get();
		
						$order_item = $query->result_array();
		
						$order_item_arr = !empty($order_item) ? array_column($order_item, "mealplan") : array();
						
						$keys = array_keys($order_item_arr, "0");
		
						if($keys != "" && !empty($keys)){
							foreach($keys as $key){
								if(isset($order_item[$key])){
									$weeklyplan .= $order_item[$key]['plan'].", ";
								}
							}
						}
						$keys = array_keys($order_item_arr, "1");
		
						if($keys != "" && !empty($keys)){
							foreach($keys as $key){
								if(isset($order_item[$key])){
									$monthlyplan .= $order_item[$key]['plan'].", ";
								}
							}
						}
						if($weeklyplan != ""){
							$weeklyplan = substr($weeklyplan, 0, -2);
						}
						if($monthlyplan != ""){
							$monthlyplan = substr($monthlyplan, 0, -2);
						}
					}

					$return_array[] = array_merge($value, array("weekly_plan" => $weeklyplan,"monthly_plan" => $monthlyplan,"trial_orders" => $trial_order));
				}
			}
			return $return_array;
		}else{
			$query = $this->db->query($query)->row_array();;
		
			return !empty($query['total'])?$query['total']:0;
		}
	}

	function getKitchenActiveOrders($limit,$offset=0,$PostData="", $count=0){

		$where_search = "";
		if(isset($PostData['search']) && $PostData['search']!=""){
			$where_search .= " AND (o.orderid LIKE '%".$PostData['search']."%' OR o.customer_name LIKE '%".$PostData['search']."%')";
		}
		if($count==1){
			$query = "SELECT count(temp.id) as total";
		}else{
			$query = "SELECT temp.id,temp.orderitemsid,temp.customer_name,temp.customer_mobileno,temp.deliveryaddress,temp.orderid,temp.netamount,temp.status,temp.itemstatus,temp.customerimage,temp.delivery_date,temp.delivery_fromtime,temp.orderdate,temp.ordertype,temp.mealfor,temp.riderid,temp.rider_name,temp.rider_mobileno";
		}
		$query .= " FROM (
						SELECT o.id,oi.id as orderitemsid,o.customer_name,o.customer_mobileno,o.deliveryaddress,
						o.orderid,o.netamount,o.status,oi.status as itemstatus,foodies.profile_image as customerimage,
						oi.delivery_date,oi.delivery_fromtime,o.orderdate,o.ordertype,
						IF(oi.mealplan!=2,(SELECT mealfor FROM packages WHERE id=oi.reference_id),'') as mealfor,
						o.riderid,
						IFNULL(rider.kitchenname,'') as rider_name,
						IFNULL(rider.mobilenumber,'') as rider_mobileno
			
						FROM orders AS o
						INNER JOIN orderitems as oi ON oi.order_id = o.id
						LEFT JOIN user as foodies ON foodies.id=o.customerid
						LEFT JOIN user as rider ON rider.id=o.riderid
						WHERE ((o.ordertype='trial' AND o.status IN (1,3,4,5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,2,5))) AND oi.delivery_date <= CURDATE() AND o.userid = '".$PostData['kitchenid']."'
						".$where_search."
						GROUP BY oi.order_id,oi.delivery_date
					) as temp ";

		$query .= " ORDER BY temp.id DESC";

		if($count==0){
			$query .= " LIMIT ".$offset.",".$limit;
			$query = $this->db->query($query);
			$data = $query->result_array();

			$return_array = array();
			if(count($data) > 0)
			{
				foreach ($data as $key => $value) {
					
					if($value['ordertype'] == "trial"){
	
						$item_name = $this->db->query('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->row_array();
	
						$item_name = $item_name['item_name'];
					}else{
	
						$query = $this->db->select("id,menuid,itemname,qty,price")
								  ->from("order_package_menu_items")
								  ->where("orderitems_id = '".$value['orderitemsid']."'")
								  ->get();
		
						$menu_item = $query->result_array();
	
						$item_name = array();
						if(count($menu_item) > 0){
							foreach($menu_item as $item){
								// $item_name[] = ($item['qty'] > 0 ? $item['qty']." " : "").$item['itemname']; 
								$item_name[] = $item['itemname']; 
							}
						}
						$item_name = implode(" + ", $item_name);
						
					}
					
					$return_array[] = array_merge($value, array("item_name" => $item_name));
				}
			}
			return $return_array;
		}else{
			$query = $this->db->query($query)->row_array();;
		
			return !empty($query['total'])?$query['total']:0;
		}
	}
	function getActiveOrders($kitchenid,$limit='-1',$count=0){

		if($count==1){
			$this->db->select("o.id");
		}else{
			$this->db->select("o.id,oi.id as orderitemsid,o.customer_name,o.customer_mobileno,o.deliveryaddress,
				o.orderid,o.netamount,o.status,oi.status as itemstatus,'' as customerimage,
				oi.delivery_date,oi.delivery_fromtime,o.orderdate,o.ordertype,
				IF(oi.mealplan!=2,(SELECT mealfor FROM packages WHERE id=oi.reference_id),'') as mealfor,
				o.riderid,
				IFNULL(rider.kitchenname,'') as rider_name,
				IFNULL(rider.mobilenumber,'') as rider_mobileno
			");
		}
		$this->db->from($this->_table." as o");
		$this->db->join("orderitems as oi","oi.order_id = o.id", "INNER");
        $this->db->join("user as foodies","foodies.id=o.customerid","LEFT");
		$this->db->join("user as rider","rider.id=o.riderid","LEFT");
		$this->db->where("((o.ordertype='trial' AND o.status IN (1,3,4,5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,2))) AND oi.delivery_date <= CURDATE() AND o.userid = ".$kitchenid);
		$this->db->group_by("oi.order_id,oi.delivery_date");
		if($limit != -1){
			$this->db->limit($limit);
		}
		$query = $this->db->get();

		$data = $query->result_array();
		
		if($count==1){

			return $query->num_rows();
		}else{

			$return_array = array();
			if(count($data) > 0)
			{
				foreach ($data as $key => $value) {
					
					if($value['ordertype'] == "trial"){
	
						$item_name = $this->db->query('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->row_array();
	
						$item_name = $item_name['item_name'];
					}else{
	
						$query = $this->db->select("id,menuid,itemname,qty,price")
								  ->from("order_package_menu_items")
								  ->where("orderitems_id = '".$value['orderitemsid']."'")
								  ->get();
		
						$menu_item = $query->result_array();
	
						$item_name = array();
						if(count($menu_item) > 0){
							foreach($menu_item as $item){
								// $item_name[] = ($item['qty'] > 0 ? $item['qty']." " : "").$item['itemname']; 
								$item_name[] = $item['itemname']; 
							}
						}
						$item_name = implode(" + ", $item_name);
						
					}
					
					$return_array[] = array_merge($value, array("item_name" => $item_name));
				}
			}
			return $return_array;
		}
	}

	function getKitchenUpcomingOrders($limit,$offset=0,$PostData="", $count=0){

		$where_search = "";
		if(isset($PostData['search']) && $PostData['search']!=""){
			$where_search .= " AND (o.orderid LIKE '%".$PostData['search']."%' OR o.customer_name LIKE '%".$PostData['search']."%')";
		}
		if($count==1){
			$query = "SELECT count(temp.id) as total";
		}else{
			$query = "SELECT temp.id,temp.orderitemsid,temp.customer_name,temp.customer_mobileno,temp.deliveryaddress,temp.orderid,temp.netamount,temp.status,temp.itemstatus,temp.customerimage,temp.delivery_date,temp.delivery_fromtime,temp.orderdate,temp.ordertype,temp.mealfor,temp.riderid,temp.rider_name,temp.rider_mobileno";
		}
		$query .= " FROM (
						SELECT o.id,oi.id as orderitemsid,o.customer_name,o.customer_mobileno,o.deliveryaddress,
						o.orderid,o.netamount,o.status,oi.status as itemstatus,foodies.profile_image as customerimage,
						oi.delivery_date,oi.delivery_fromtime,o.orderdate,o.ordertype,
						IF(oi.mealplan!=2,(SELECT mealfor FROM packages WHERE id=oi.reference_id),'') as mealfor,
						o.riderid,
						IFNULL(rider.kitchenname,'') as rider_name,
						IFNULL(rider.mobilenumber,'') as rider_mobileno
			
						FROM orderitems as oi
						INNER JOIN orders AS o ON o.id = oi.order_id
						LEFT JOIN user as foodies ON foodies.id=o.customerid
						LEFT JOIN user as rider ON rider.id=o.riderid
						WHERE ((o.ordertype='trial' AND o.status IN (1,3,4,5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,2,5))) AND oi.delivery_date > CURDATE() AND o.userid = '".$PostData['kitchenid']."'
						".$where_search."
						GROUP BY oi.order_id,oi.delivery_date
						ORDER BY oi.order_id,oi.delivery_date DESC
					) as temp ";

		$query .= " ORDER BY temp.id DESC";

		if($count==0){
			$query .= " LIMIT ".$offset.",".$limit;
			$query = $this->db->query($query);
			$data = $query->result_array();

			$return_array = array();
			if(count($data) > 0)
			{
				foreach ($data as $key => $value) {
					
					if($value['ordertype'] == "trial"){
	
						$item_name = $this->db->query('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->row_array();
	
						$item_name = $item_name['item_name'];
					}else{
	
						$query = $this->db->select("id,menuid,itemname,qty,price")
								  ->from("order_package_menu_items")
								  ->where("orderitems_id = '".$value['orderitemsid']."'")
								  ->get();
		
						$menu_item = $query->result_array();
	
						$item_name = array();
						if(count($menu_item) > 0){
							foreach($menu_item as $item){
								// $item_name[] = ($item['qty'] > 0 ? $item['qty']." " : "").$item['itemname']; 
								$item_name[] = $item['itemname']; 
							}
						}
						$item_name = implode(" + ", $item_name);
						
					}
					
					$return_array[] = array_merge($value, array("item_name" => $item_name));
				}
			}
			return $return_array;
		}else{
			$query = $this->db->query($query)->row_array();;
		
			return !empty($query['total'])?$query['total']:0;
		}
	}

	function getKitchenOrdersHistory($limit,$offset=0,$PostData="", $count=0){
		
		$where_search = "";
		if(isset($PostData['search']) && $PostData['search']!=""){
			$where_search .= " AND (o.orderid LIKE '%".$PostData['search']."%' OR o.customer_name LIKE '%".$PostData['search']."%')";
		}
		if($count==1){
			$query = "SELECT count(temp.id) as total";
		}else{
			$query = "SELECT temp.id,temp.customerid,temp.customer_name,temp.customer_mobileno,temp.deliveryaddress,temp.kitchenname,temp.orderid,temp.orderdate,temp.orderamount,temp.netamount,temp.status,temp.createddate,temp.customerimage,temp.delivery_time,temp.riderid,temp.rider_name,temp.rider_mobileno,temp.ordertype,temp.packagetype";
		}
		$query .= " FROM (
						SELECT o.id,o.customerid,o.customer_name,o.customer_mobileno,o.deliveryaddress,
						kitchen.kitchenname,o.orderid,o.orderdate,o.orderamount,
						o.netamount,
						o.status,o.createddate, 
						foodies.profile_image as customerimage, delivery_time,
						o.riderid,
						IFNULL(rider.kitchenname,'') as rider_name,
						IFNULL(rider.mobilenumber,'') as rider_mobileno,
						o.ordertype,o.packagetype
			
						FROM orders AS o
						LEFT JOIN user as foodies ON foodies.id=o.customerid
						LEFT JOIN user as kitchen ON kitchen.id=o.userid
						LEFT JOIN user as rider ON rider.id=o.riderid
						WHERE o.userid = '".$PostData['kitchenid']."'
						".$where_search."
					) as temp ";

		$query .= " ORDER BY temp.id DESC";

		if($count==0){
			$query .= " LIMIT ".$offset.",".$limit;
			$query = $this->db->query($query);
			$data = $query->result_array();

			$return_array = array();
			if(count($data) > 0)
			{
				foreach ($data as $key => $value) {
					$trial_order = $weeklyplan = $monthlyplan = "";
	
					if($value['ordertype'] == "trial"){
	
						$trial_order = $this->db->query('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->row_array();
						
						$trial_order = $trial_order['item_name'];
	
						$status = $value['status'];
					}else{
	
						$query = $this->db->select("id,mealplan,reference_id, 
													(SELECT (CASE 
														WHEN mealfor=0 THEN 'Breakfast' 
														WHEN mealfor=1 THEN 'Lunch' 
														ELSE 'Dinner'
													END) FROM packages WHERE id=reference_id) as plan")
								->from("orderitems")
								->where("order_id = '".$value['id']."'")
								->group_by("mealplan,reference_id")
								->get();
		
						$order_item = $query->result_array();
		
						$order_item_arr = !empty($order_item) ? array_column($order_item, "mealplan") : array();
						
						$keys = array_keys($order_item_arr, "0");
		
						if($keys != "" && !empty($keys)){
							foreach($keys as $key){
								if(isset($order_item[$key])){
									$weeklyplan .= $order_item[$key]['plan'].", ";
								}
							}
						}
						$keys = array_keys($order_item_arr, "1");
		
						if($keys != "" && !empty($keys)){
							foreach($keys as $key){
								if(isset($order_item[$key])){
									$monthlyplan .= $order_item[$key]['plan'].", ";
								}
							}
						}
						if($weeklyplan != ""){
							$weeklyplan = substr($weeklyplan, 0, -2);
						}
						if($monthlyplan != ""){
							$monthlyplan = substr($monthlyplan, 0, -2);
						}
	
						$status = $value['status'];
					}
	
					$return_array[] = array_merge($value, array("weekly_plan" => $weeklyplan,"monthly_plan" => $monthlyplan,"trial_orders" => $trial_order,"order_status"=>$status));
				}
			}
			return $return_array;
		}else{
			$query = $this->db->query($query)->row_array();;
		
			return !empty($query['total'])?$query['total']:0;
		}
	}

	function getKitchenOrdersCount($kitchenid,$where=''){
		
		$query = $this->db->select("o.id")
						  ->from($this->_table." as o")
						  ->where("o.userid=".$kitchenid.$where)
						  ->get();

		$data = $query->result_array();

		return $query->num_rows();
	}

	function getKitchenCompletedOrdersCount($kitchenid){

		$query = $this->db->select("o.id")
						  ->from("orderitems as oi")
						  ->join("orders AS o", "o.id = oi.order_id", "INNER")
						  ->where("((o.ordertype='trial' AND o.status=6) OR (o.ordertype='package' AND o.status=1 AND oi.status=3)) AND o.userid = ".$kitchenid)
						  ->group_by("oi.order_id,oi.delivery_date")
						  ->get();

		return $query->num_rows();
	}
	function getKitchenCancelledOrdersCount($kitchenid){

		$query = $this->db->select("o.id")
						  ->from("orderitems as oi")
						  ->join("orders AS o", "o.id = oi.order_id", "INNER")
						  ->where("((o.ordertype='trial' AND o.status=7) OR (o.ordertype='package' AND o.status=1 AND oi.status=4)) AND o.userid = ".$kitchenid)
						  ->group_by("oi.order_id,oi.delivery_date")
						  ->get();

		return $query->num_rows();
	}

	function getKitchenActiveDeliveriesOrders($kitchenid,$Count=0){
		
		if($Count == 1){
			$this->db->select("o.id");
		}else{
			$this->db->select("o.id,oi.id as orderitemsid,o.customer_name,o.customer_mobileno,o.deliveryaddress,
				o.deliverylatitude,o.deliverylongitude,
				foodies.profile_image as customerimage,
				o.orderid,oi.delivery_date,o.riderid,
				IFNULL(rider.kitchenname,'') as rider_name,
				IFNULL(rider.mobilenumber,'') as rider_mobileno,
				kitchen.address,kitchen.latitude,kitchen.longitude,

				IF(o.ordertype='trial', o.track_rider_latitude, oi.track_rider_latitude) as rider_latitude,
				IF(o.ordertype='trial', o.track_rider_longitude, oi.track_rider_longitude) as rider_longitude,

				CAST(IFNULL((SELECT AVG(rf.ratting) FROM riderfeedback as rf WHERE rf.riderid=o.riderid),0) AS DECIMAL(2,1)) as rider_rating, 
			");
		}
		$this->db->from("orderitems as oi");
		$this->db->join("orders AS o", "o.id = oi.order_id", "INNER");
		$this->db->join("user as foodies", "foodies.id=o.customerid", "LEFT");
		$this->db->join("user as rider", "rider.id=o.riderid", "LEFT");
		$this->db->join("user as kitchen", "kitchen.id=o.userid", "LEFT");
		$this->db->where("((o.ordertype='trial' AND o.status=5) OR (o.ordertype='package' AND o.status=1 AND oi.status=2)) AND o.userid = ".$kitchenid);
		$this->db->group_by("oi.order_id,oi.delivery_date");
		$query = $this->db->get();

		if($Count == 1){
			return $query->num_rows();
		}else{
			return $query->result_array();
		}
	}

	function getKitchenReadyToPickOrdersCount($kitchenid){

		$query = $this->db->select("o.id")
						  ->from("orderitems as oi")
						  ->join("orders AS o", "o.id = oi.order_id", "INNER")
						  ->where("((o.ordertype='trial' AND o.status=3) OR (o.ordertype='package' AND o.status=1 AND oi.status=0)) AND o.userid = ".$kitchenid)
						  ->group_by("oi.order_id,oi.delivery_date")
						  ->get();

		return $query->num_rows();
	}

	function getKitchenPreparingOrdersCount($kitchenid){

		$query = $this->db->select("o.id")
						  ->from("orderitems as oi")
						  ->join("orders AS o", "o.id = oi.order_id", "INNER")
						  ->where("((o.ordertype='trial' AND o.status=1) OR (o.ordertype='package' AND o.status=1 AND oi.status=5)) AND o.userid = ".$kitchenid)
						  ->group_by("oi.order_id,oi.delivery_date")
						  ->get();

		return $query->num_rows();
	}

	function getKitchenOutForDeliveryOrdersCount($kitchenid){

		$query = $this->db->select("o.id")
						  ->from("orderitems as oi")
						  ->join("orders AS o", "o.id = oi.order_id", "INNER")
						  ->where("((o.ordertype='trial' AND o.status=4) OR (o.ordertype='package' AND o.status=1 AND oi.status=1)) AND o.userid = ".$kitchenid)
						  ->group_by("oi.order_id,oi.delivery_date")
						  ->get();

		return $query->num_rows();
	}


	function getKitchenTotalEarning($kitchenid,$where=""){

		$query = $this->db->select("IFNULL(SUM(oi.total_amount),0) as total")
						  ->from("orderitems AS oi")
						  ->join("orders AS o","o.id=oi.order_id","INNER")
						  ->where("((o.ordertype='trial' AND o.status=6) OR (o.ordertype='package' AND oi.status=3)) AND o.userid = ".$kitchenid.$where)
						  ->get();

		$data = $query->row_array();
		
		if(!empty($data)){
			return number_format($data['total'],2,'.','');
		}else{
			return 0;
		}
	}

	function getKitchenWalletBalance($kitchenid) {

		$total_earning = $this->getKitchenTotalEarning($kitchenid);

		$query = $this->db->select("IFNULL(SUM(kwp.amount),0) as total")
				->from('kitchenwithdrawpayment as kwp')
				->where("kwp.kitchen_id='".$kitchenid."'")
				->get();
				
		$data = $query->row_array();

		if(!empty($data)){
			$total_withdraw = number_format($data['total'],2,'.','');
		}else{
			$total_withdraw = 0;
		}

		$wallet_balance = $total_earning - $total_withdraw;
			
		return number_format($wallet_balance,2,'.','');
	}

	function getKitchenTransactionHistory($limit,$offset=0,$PostData="", $count=0) {
		
		if($count==1){
			$query = "SELECT count(temp.id) as total";
		}else{
			$query = "SELECT temp.id,temp.order_id,temp.order_number,temp.customer_name,temp.customer_mobileno,temp.customerimage,temp.netamount,temp.amount,temp.orderdate,temp.createddate,temp.transaction_status,temp.ordertype,temp.packagetype";
		}
		$query .= " FROM (
						SELECT tr.id,tr.order_id,tr.order_number,o.customer_name,o.customer_mobileno,o.netamount,tr.amount,o.orderdate,tr.createddate,tr.transaction_status,
							o.ordertype,o.packagetype,IFNULL((SELECT profile_image FROM user WHERE id=customerid),'') as customerimage
						FROM transaction AS tr
						INNER JOIN orders as o ON o.id=tr.order_id
						WHERE tr.payment_type='order' AND tr.payment_method='payumoney' AND o.userid = '".$PostData['kitchenid']."'
					) as temp ";

		$query .= " ORDER BY temp.createddate DESC";
		
		if($count==0){
			$query .= " LIMIT ".$offset.",".$limit;
			$query = $this->db->query($query);
			$data = $query->result_array();

			$return_array = array();
			if(count($data) > 0)
			{
				foreach ($data as $key => $value) {
					$trial_order = $weeklyplan = $monthlyplan = "";

					if($value['ordertype'] == "trial"){

						$trial_order = $this->db->query('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['order_id'])->row_array();
						
						$trial_order = $trial_order['item_name'];
					}else{

						$query = $this->db->select("id,mealplan,reference_id, 
													(SELECT (CASE 
														WHEN mealfor=0 THEN 'Breakfast' 
														WHEN mealfor=1 THEN 'Lunch' 
														ELSE 'Dinner'
													END) FROM packages WHERE id=reference_id) as plan")
								->from("orderitems")
								->where("order_id = '".$value['order_id']."'")
								->group_by("mealplan,reference_id")
								->get();
		
						$order_item = $query->result_array();
		
						$order_item_arr = !empty($order_item) ? array_column($order_item, "mealplan") : array();
						
						$keys = array_keys($order_item_arr, "0");
		
						if($keys != "" && !empty($keys)){
							foreach($keys as $key){
								if(isset($order_item[$key])){
									$weeklyplan .= $order_item[$key]['plan'].", ";
								}
							}
						}
						$keys = array_keys($order_item_arr, "1");
		
						if($keys != "" && !empty($keys)){
							foreach($keys as $key){
								if(isset($order_item[$key])){
									$monthlyplan .= $order_item[$key]['plan'].", ";
								}
							}
						}
						if($weeklyplan != ""){
							$weeklyplan = substr($weeklyplan, 0, -2);
						}
						if($monthlyplan != ""){
							$monthlyplan = substr($monthlyplan, 0, -2);
						}
					}

					$return_array[] = array_merge($value, array("weekly_plan" => $weeklyplan,"monthly_plan" => $monthlyplan,"trial_orders" => $trial_order));
				}
			}
			return $return_array;
		}else{
			$query = $this->db->query($query)->row_array();;
		
			return !empty($query['total'])?$query['total']:0;
		}
	}

	function getFoodiesTodayOrder($foodiesid) {
		
		$query = $this->db->select("o.id,oi.id as orderitemsid,o.ordertype,o.packagetype,o.customer_name,o.customer_mobileno,
		o.riderid,
						IFNULL(rider.kitchenname,'') as rider_name,
						IFNULL(rider.mobilenumber,'') as rider_mobileno,
						
						IFNULL(kitchen.kitchenname,'') as kitchen_name,
						IFNULL(kitchen.mobilenumber,'') as kitchen_mobileno,

						")
						  ->from("orderitems as oi")
						  ->join("orders AS o", "o.id = oi.order_id", "INNER")
						  ->join("user AS rider", "rider.id = o.riderid", "LEFT")
						  ->join("user AS kitchen", "kitchen.id = o.userid", "LEFT")
						  ->where("((o.ordertype='trial' AND o.status IN (1,3,4)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,5))) AND oi.delivery_date = CURDATE() AND o.customerid = ".$foodiesid)
						  ->group_by("oi.order_id")
						  ->limit(1)
						  ->get();

		$orderdata = $query->result_array();

		$return_array = $return = array();
		if(!empty($orderdata)){
			foreach($orderdata as $order){

				$meal = array();
				
				$query = $this->db->select("id,mealplan,reference_id,delivery_date,delivery_fromtime,
													(SELECT (CASE 
														WHEN mealfor=0 THEN 'Breakfast' 
														WHEN mealfor=1 THEN 'Lunch' 
														ELSE 'Dinner'
													END) FROM packages WHERE id=reference_id) as plan")
						->from("orderitems")
						->where("id = '".$order['orderitemsid']."'")
						->get();

				$meal = $query->row_array();
				
				if($order['ordertype'] == "package"){
	
					$items = $this->db->query('select GROUP_CONCAT(DISTINCT itemname ORDER BY itemname ASC SEPARATOR " + ") AS itemname FROM order_package_menu_items where orderitems_id = '.$order['orderitemsid'])->row_array();
	
					$meal['item_name'] = $items['itemname'];


					// Current date and time
					$currentdatetime = date("Y-m-d H:i:s");
					$delivery_datetime = date("Y-m-d H:i:s", strtotime($meal['delivery_date']." ".$meal['delivery_fromtime']));
					$timestamp = strtotime($delivery_datetime);
					$time = $timestamp - (1 * 60 * 60);
					$delivery_datetime = date("Y-m-d H:i:s", $time);
					
					$meal['iscancel'] = 0;
					if(strtotime($currentdatetime) < strtotime($delivery_datetime)){
						$meal['iscancel'] = 1;
					
					}
					$meal['cancel_datetime'] = $delivery_datetime;
					$meal['cancel_time'] = date("H:i:s", $time);
	
				}else{
					$trialmenu = $this->db->query('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$order['id'])->row_array();
							
					$meal['item_name'] = $trialmenu['item_name'];			
				}
				$return[] = $meal;
			}
			$return_array = array(
				"orderitemsid"	=> $orderdata[0]['orderitemsid'],
				"ordertype"		=> $orderdata[0]['ordertype'],
				"packagetype"	=> $orderdata[0]['packagetype'],
				"kitchen_mobileno"	=> $orderdata[0]['kitchen_mobileno'],
				"rider_mobileno"	=> $orderdata[0]['rider_mobileno'],
				"meal"			=> $return
			);
		}
		return $return_array;
	}

	function getFoodiesStartedDeliveryOrder($foodiesid) {
		
		$query = $this->db->select("o.id,oi.id as orderitemsid,o.ordertype,o.packagetype,o.customer_name,o.customer_mobileno,
		o.riderid,
						IFNULL(rider.kitchenname,'') as rider_name,
						IFNULL(rider.mobilenumber,'') as rider_mobileno,
						
						IFNULL(kitchen.kitchenname,'') as kitchen_name,
						IFNULL(kitchen.mobilenumber,'') as kitchen_mobileno,

						CAST(IFNULL((SELECT AVG(rf.ratting) FROM riderfeedback as rf WHERE rf.riderid=o.riderid),0) AS DECIMAL(2,1)) as rider_rating, 
						IFNULL((SELECT count(rf.id) FROM riderfeedback as rf WHERE rf.riderid=o.riderid),0) as rider_review, 

						o.track_rider_latitude,o.track_rider_longitude
						")
						  ->from("orderitems as oi")
						  ->join("orders AS o", "o.id = oi.order_id", "INNER")
						  ->join("user AS rider", "rider.id = o.riderid", "LEFT")
						  ->join("user AS kitchen", "kitchen.id = o.userid", "LEFT")
						  ->where("((o.ordertype='trial' AND o.status IN (5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (2))) AND o.customerid = ".$foodiesid)
						  ->limit(1)
						  ->get();

		$order = $query->row_array();

		$return_array = $return = array();
		if(!empty($order)){
			$meal = array();
			
			$query = $this->db->select("id,mealplan,reference_id,delivery_date,delivery_fromtime,
												(SELECT (CASE 
													WHEN mealfor=0 THEN 'Breakfast' 
													WHEN mealfor=1 THEN 'Lunch' 
													ELSE 'Dinner'
												END) FROM packages WHERE id=reference_id) as plan")
					->from("orderitems")
					->where("id = '".$order['orderitemsid']."'")
					->get();

			$meal = $query->row_array();
			
			if($order['ordertype'] == "package"){

				$items = $this->db->query('select GROUP_CONCAT(DISTINCT itemname ORDER BY itemname ASC SEPARATOR " + ") AS itemname FROM order_package_menu_items where orderitems_id = '.$order['orderitemsid'])->row_array();

				$meal['item_name'] = $items['itemname'];


				// Current date and time
				$currentdatetime = date("Y-m-d H:i:s");
				$delivery_datetime = date("Y-m-d H:i:s", strtotime($meal['delivery_date']." ".$meal['delivery_fromtime']));
				$timestamp = strtotime($delivery_datetime);
				$time = $timestamp - (1 * 60 * 60);
				$delivery_datetime = date("Y-m-d H:i:s", $time);
				
				$meal['iscancel'] = 0;
				if(strtotime($currentdatetime) < strtotime($delivery_datetime)){
					$meal['iscancel'] = 1;
				
				}
				$meal['cancel_datetime'] = $delivery_datetime;
				$meal['cancel_time'] = date("H:i:s", $time);

			}else{
				$trialmenu = $this->db->query('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$order['id'])->row_array();
						
				$meal['item_name'] = $trialmenu['item_name'];			
			}
			$return = $meal;
			
			$return_array = array(
				"orderitemsid"	=> $order['orderitemsid'],
				"ordertype"		=> $order['ordertype'],
				"packagetype"	=> $order['packagetype'],
				"kitchen_name"	=> $order['kitchen_name'],
				"kitchen_mobileno"	=> $order['kitchen_mobileno'],
				"rider_name"	=> $order['rider_name'],
				"rider_mobileno"	=> $order['rider_mobileno'],
				"rider_rating"	=> $order['rider_rating'],
				"rider_review"	=> $order['rider_review'],
				"track_rider_latitude"	=> $order['track_rider_latitude'],
				"track_rider_longitude"	=> $order['track_rider_longitude'],
				"meal"			=> $return
			);
		}
		return $return_array;
	}

	function getFoodiesOrdersHistory($limit,$offset=0,$PostData="", $count=0){

		if($count==1){
			$query = "SELECT count(temp.id) as total";
		}else{
			$query = "SELECT temp.id,temp.customerid,temp.customer_name,temp.customer_mobileno,temp.deliveryaddress,temp.kitchenname,temp.orderid,temp.orderdate,temp.orderamount,temp.netamount,temp.status,temp.createddate,temp.customerimage,temp.delivery_time,temp.riderid,temp.rider_name,temp.rider_mobileno,temp.ordertype,temp.packagetype,temp.kitchen_rating,temp.kitchen_review";
		}
		$query .= " FROM (
						SELECT o.id,o.customerid,o.customer_name,o.customer_mobileno,o.deliveryaddress,
						kitchen.kitchenname,o.orderid,o.orderdate,o.orderamount,
						o.netamount,
						o.status,o.createddate, 
						'' as customerimage, delivery_time,
						o.riderid,
						IFNULL(rider.kitchenname,'') as rider_name,
						IFNULL(rider.mobilenumber,'') as rider_mobileno,
						o.ordertype,o.packagetype,

						CAST((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=kitchen.id) AS DECIMAL(2,1)) as kitchen_rating, 
						IFNULL((SELECT count(fd.id) FROM feedback as fd WHERE fd.kitchen_id=kitchen.id),0) as kitchen_review
			
						FROM orders AS o
						LEFT JOIN user as foodies ON foodies.id=o.customerid
						LEFT JOIN user as kitchen ON kitchen.id=o.userid
						LEFT JOIN user as rider ON rider.id=o.riderid
						WHERE o.customerid = '".$PostData['customerid']."'
					) as temp ";

		$query .= " ORDER BY temp.id DESC";

		if($count==0){
			$query .= " LIMIT ".$offset.",".$limit;
			$query = $this->db->query($query);
			$data = $query->result_array();

			$return_array = array();
			if(count($data) > 0)
			{
				foreach ($data as $key => $value) {
					$trial_order = "";
					$package_detail = array();
					
					if($value['ordertype'] == "trial"){
	
						$trial_order = $this->db->query('select GROUP_CONCAT(DISTINCT item_name ORDER BY item_name ASC SEPARATOR " + ") AS item_name FROM orderitems where order_id = '.$value['id'])->row_array();
						
						$trial_order = $trial_order['item_name'];
	
						$status = $value['status'];
					}else{
	
						$query = $this->db->select("oi.id,oi.item_name,
									IF(p.mealtype=0,'Veg','Non Veg') as mealtype,
									(CASE 
										WHEN p.mealfor=0 THEN 'Breakfast' 
										WHEN p.mealfor=1 THEN 'Lunch' 
										ELSE 'Dinner'
									END) as menu,
									(CASE 
										WHEN oi.cuisinetype=0 THEN 'South Indian' 
										WHEN oi.cuisinetype=1 THEN 'North Indian' 
										ELSE 'Other Indian'
									END) as cuisine,
											
									(SELECT delivery_date FROM orderitems WHERE order_id=oi.order_id AND mealplan=oi.mealplan ORDER BY id ASC LIMIT 1) as startdate,
									(SELECT delivery_date FROM orderitems WHERE order_id=oi.order_id AND mealplan=oi.mealplan ORDER BY id DESC LIMIT 1) as enddate,
									oi.mealplan,oi.reference_id
								")
								->from("orderitems as oi")
								->join("packages as p","p.id=oi.reference_id","LEFT")
								->where("oi.mealplan!=2 AND oi.order_id = '".$value['id']."'")
								->group_by("oi.order_id,oi.mealplan,oi.reference_id")
								->get();
		
						$package_detail = $query->result_array();
		
						if(!empty($package_detail)){
							foreach($package_detail as $key => $package){

								$query = $this->db->select("oi.delivery_date,oi.delivery_fromtime,oi.delivery_totime,oi.status,oi.total_amount,
									(SELECT GROUP_CONCAT(DISTINCT itemname ORDER BY itemname ASC SEPARATOR ' + ') AS item_name FROM order_package_menu_items WHERE orderitems_id=oi.id) as dish_item,
									oi.status
								")
										->from("orderitems as oi")
										->where("mealplan=".$package['mealplan']." AND reference_id=".$package['reference_id']." AND oi.order_id = '".$value['id']."'")
										->get();
				
								$package_detail[$key]['daily_pkg_detail'] = $query->result_array();


								// $pkg_array[] = array_merge($package, $daily_pkg_detail);
							}
						}
						
	
						$status = $value['status'];
					}
	
					$return_array[] = array_merge($value, array("package_detail" => $package_detail,"trial_orders" => $trial_order,"order_status"=>$status));
				}
			}
			return $return_array;
		}else{
			$query = $this->db->query($query)->row_array();;
		
			return !empty($query['total'])?$query['total']:0;
		}
	}

	function getFoodiesActiveOrders($limit,$offset=0,$PostData="", $count=0){

		if($count==1){
			$query = "SELECT count(temp.id) as total";
		}else{
			$query = "SELECT temp.id,temp.orderitemsid,temp.customerid,temp.userid,temp.customer_name,temp.customer_mobileno,temp.deliveryaddress,temp.kitchenname,temp.orderid,temp.netamount,temp.status,temp.orderdate,temp.delivery_date";
		}
		$query .= " FROM (
						SELECT o.id,oi.id as orderitemsid,o.customerid,o.userid,o.customer_name,o.customer_mobileno,
						o.deliveryaddress,
						kitchen.kitchenname,
						o.orderid,o.orderdate,o.netamount,
						o.status,o.createddate,oi.delivery_date
			
						FROM orders AS o
						INNER JOIN orderitems as oi ON oi.order_id = o.id
						LEFT JOIN user as foodies ON foodies.id=o.customerid
						LEFT JOIN user as rider ON rider.id=o.riderid
						LEFT JOIN user as kitchen ON kitchen.id=o.userid
						WHERE ((o.ordertype='trial' AND o.status IN (1,3,4,5)) OR (o.ordertype='package' AND o.status=1 AND oi.status IN (0,1,2))) AND oi.delivery_date <= CURDATE() AND o.customerid = '".$PostData['customerid']."'
						GROUP BY oi.order_id,oi.delivery_date
					) as temp ";

		$query .= " ORDER BY temp.id DESC";

		if($count==0){
			$query .= " LIMIT ".$offset.",".$limit;
			$query = $this->db->query($query);
			
			return $query->result_array();
		}else{
			$query = $this->db->query($query)->row_array();;
		
			return !empty($query['total'])?$query['total']:0;
		}
	}
}
