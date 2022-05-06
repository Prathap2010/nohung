<?php

class Rider_model extends Common_model {

	//put your code here
	public $_table = 'user';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $column_order = array(null,'kitchenname','email','mobilenumber','city','userstatus'); //set column field database for datatable orderable
	public $column_search = array('kitchenname','mobilenumber','email','(IFNULL((SELECT name FROM city WHERE id=u.cityid),""))'); //set column field database for datatable searchable 
	public $_order = array('u.id' => 'DESC'); // default order

	function __construct() {
		parent::__construct();
	}
    function CheckEmailAvailable($email, $ID = '') {

		$where = "usertype=2 AND email='".$email."'";
		
		if (isset($ID) && $ID != '') {
			$query = $this->db->select($this->_fields)
			->from($this->_table)
			->where('id <>',$ID)
			->where($where)
			->get();

		} else {
			$query = $this->db->select($this->_fields)
			->from($this->_table)
			->where($where)
			->get();
		}
		
		return $query->row_array();
	}
	function CheckMobileNumberAvailable($mobilenumber,$ID = '') {

		$where = "usertype = 2 AND mobilenumber='".$mobilenumber."'";
		
		if (isset($ID) && $ID != '') {
			$query = $this->db->select($this->_fields)
			->from($this->_table)
			->where('id <>',$ID)
			->where($where)
			->get();

		} else {
			$query = $this->db->select($this->_fields)
			->from($this->_table)
			->where($where)
			->get();
		}
		
		return $query->row_array();
	}
    function getRiderDataByID($ID){
		
        $query = $this->db->select("id,kitchenname,password,email,mobilenumber,cityid,IFNULL((SELECT name FROM city WHERE id=cityid),'') as city,biketype,youhavelicense,licencefile,rcbookfile,passportfile,idprooffile,otpcode,otpdate,isverifiedotp,wallet,status,userstatus,profile_image,createddate,modifieddate")
                        ->from($this->_table)
                        ->where("id='".$ID."'")
                        ->get();
							
		if ($query->num_rows() == 1) {
			return $query->row_array();
		}else {
			return 0;
		}	
	}

    //LISTING DATA
	function _get_datatables_query(){		
		
		$this->db->select("id,kitchenname,email,mobilenumber,status,userstatus,IFNULL((SELECT name FROM city WHERE id=u.cityid),'') as city");
		$this->db->from($this->_table." as u");
		$this->db->where("u.usertype=2");

		$i = 0;
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order']) && $_POST['order']['0']['column']>0) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->_order)){
			$order = $this->_order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables() {
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
		// echo $this->db->last_query(); exit;
        return $query->result();
	}

	function count_filtered() {
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all() {
		$this->_get_datatables_query();
		return $this->db->count_all_results();
	} 

	function getRiderList(){
		
        $query = $this->db->select("id,kitchenname,email,mobilenumber")
                        ->from($this->_table)
                        ->where("usertype=2 AND status=1 AND userstatus=1")
                        ->get();
							
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else {
			return 0;
		}	
	}

	function getRecentRidersList(){
		
        $query = $this->db->select("r.id,r.kitchenname,r.email,r.mobilenumber,r.profile_image,
			(SELECT count(am.id) FROM adminmessages as am WHERE am.userid=r.id AND am.isread='n' AND am.msg_type='usertoadmin') as new_msg, 
			IFNULL((SELECT am.createddate FROM adminmessages as am WHERE am.userid=r.id ORDER BY id DESC LIMIT 1),'') as time,
			IFNULL((SELECT am.message FROM adminmessages as am WHERE am.userid=r.id ORDER BY id DESC LIMIT 1),'') as lastmsg
		")
                        ->from($this->_table." as r")
						->where("r.usertype=2 AND r.status=1 AND r.userstatus=1")
						->order_by("time DESC, r.kitchenname ASC")
						->get();
							
		if ($query->num_rows() > 0) {
			$data = $query->result_array();

			foreach($data as $k=>$row){
				if ($row['profile_image'] != "" && file_exists(USER_PROFILE_PATH . $row['profile_image'])) {
					$img = USER_PROFILE . $row['profile_image'];
				} else {
					$img = NOPROFILEIMAGE;
				}
				$data[$k]['profile_image'] = $img;
				if($row['time'] != ""){
					$data[$k]['time'] = $this->general_model->time_Ago(strtotime($row['time']));
				}
			}
			
			return $data;
		}else {
			return 0;
		}	
	}
	function getRiderChat($riderid){
		
		$query = $this->db->select("userid,message,msg_type,createddate")
                        ->from("adminmessages as am")
						->where("am.userid=".$riderid)
						->order_by("am.id ASC")
						->get();

		if ($query->num_rows() > 0) {
			$data = $query->result_array();

			foreach($data as $k=>$row){
				$data[$k]['time'] = $this->general_model->humanTiming($row['createddate']);
			}
			
			return $data;
		}else {
			return 0;
		}	
	}
	function unReadChat($riderid){

		$this->Rider->_table = "adminmessages";
		$this->Rider->_where = array("userid"=>$riderid,"msg_type"=>"usertoadmin");
		$this->Rider->Edit(array("isread"=>"y"));
	}

	function unReadKitchenChat($kitchenid,$riderid) {
		
		$this->Rider->_table = "kitchenmessages";
		$this->Rider->_where = array("kitchenid"=>$kitchenid,"foodiesid"=>$riderid,"msg_type"=>"foodiestokitchen");
		$this->Rider->Edit(array("isread"=>"y"));
	}

	function getKitchenRecentRidersList($kitchenid){
		
        $query = $this->db->select("r.id,r.kitchenname,r.email,r.mobilenumber, 
			(SELECT count(km.id) FROM kitchenmessages as km WHERE km.foodiesid=r.id AND km.kitchenid=".$kitchenid." AND km.isread='n' AND km.msg_type='foodiestokitchen') as new_msg, 
			IFNULL((SELECT km.createddate FROM kitchenmessages as km WHERE km.foodiesid=r.id AND km.kitchenid=".$kitchenid." AND km.msg_type='foodiestokitchen' ORDER BY id DESC LIMIT 1),'') as time,
			IFNULL((SELECT km.message FROM kitchenmessages as km WHERE km.foodiesid=r.id AND km.kitchenid=".$kitchenid." AND km.msg_type='foodiestokitchen' ORDER BY id DESC LIMIT 1),'') as lastmsg
		")
                        ->from($this->_table." as r")
						->join("kitchenmessages as km","km.foodiesid=r.id AND km.kitchenid=".$kitchenid,"INNER")
						->where("r.usertype=2 AND r.status=1 AND r.userstatus=1")
						->group_by("km.foodiesid")
						->order_by("time DESC, r.kitchenname ASC")
						->get();
							
		if ($query->num_rows() > 0) {
			$data = $query->result_array();

			foreach($data as $k=>$row){
				if($row['time'] != ""){
					$data[$k]['time'] = $this->general_model->time_Ago(strtotime($row['time']));
				}
			}
			
			return $data;
		}else {
			return 0;
		}	
	}
	function getKitchenorRiderChat($kitchenid,$riderid){
		
		$query = $this->db->select("foodiesid,kitchenid,message,msg_type,createddate")
                        ->from("kitchenmessages as km")
						->where("km.kitchenid=".$kitchenid." AND km.foodiesid=".$riderid)
						->order_by("km.id ASC")
						->get();

		if ($query->num_rows() > 0) {
			$data = $query->result_array();

			foreach($data as $k=>$row){
				$data[$k]['time'] = $this->general_model->humanTiming($row['createddate']);
			}
			
			return $data;
		}else {
			return 0;
		}		
	}
}