<?php

class User_model extends Common_model {

	//put your code here
	public $_table = 'user';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $column_order = array(null,'kitchenname','kitchenid','email',null,'state','city'); //set column field database for datatable orderable
	public $column_search = array('kitchenname','kitchenid','email','address'); //set column field database for datatable searchable 
	public $_order = array('u.id' => 'DESC'); // default order

	function __construct() {
		parent::__construct();
	}
	function updateOTP($userid,$post){
        
        $this->db->update('user', $post, array("id"=>$userid));
	}
	function resetpassworddata($code){
		$this->load->model('User_model', 'User');
		$this->User->_table = 'authverification';

		$currentdate =  $this->general_model->getCurrentDateTime();
		$this->db->select('id');
	    $this->db->from('authverification');
		$where = "code='".$code."' AND createddate > '".$currentdate."' - INTERVAL 24 HOUR AND status = 0";
		$this->db->where($where);
	    $query = $this->db->get();
		$result = array();

		if($query->num_rows()>0){

			$this->db->select('*');
			$this->db->from('authverification');
			$this->db->where('code',$code);
			$query1 = $this->db->get();
			$result = $query1->row_array();
			return $result;
			
		}else{
			$where = "code ='".$code."' AND createddate < '".$currentdate."' - INTERVAL 24 HOUR";
			$this->User->Delete($where);
			
			return $result;
		}
	}
	public function checkUser($userData = array()){
        if(!empty($userData)){
            //check whether user data already exists in database with same oauth info
            $this->db->select("id");
            $this->db->from($this->_table);
            $this->db->where(array('usertype'=>1,'oauth_provider'=>$userData['oauth_provider'], 'oauth_uid'=>$userData['oauth_uid']));
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();
            
            if($prevCheck > 0){
                $prevResult = $prevQuery->row_array();
                
                //update user data
                $userData['modifieddate'] = date("Y-m-d H:i:s");
                $update = $this->db->update($this->_table, $userData, array('id' => $prevResult['id']));
                
                //get user ID
                $userID = $prevResult['id'];
            }else{
                //insert user data
                $userData['createddate']  = date("Y-m-d H:i:s");
                $userData['modifieddate'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert($this->_table, $userData);
                
                //get user ID
                $userID = $this->db->insert_id();
            }
        }
        
        //return user ID
        return $userID?$userID:FALSE;
    }
	function getUserCount($where=array()){
		$query = $this->db->select('count(id) as count')
			->from($this->_table)
			->where($where)
			->get()->row_array();

		return $query['count'];
	}
	function CheckUserLogin($emailid,$password){
		$query = $this->db->select('*')
			->from('user')
			->where("(kitchenid='".$emailid."')", "", FALSE)
			->where("password", $password)
			->get();
		
		if ($query->num_rows() == 1) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	function CheckFoodiesLogin($mobileno){
		$query = $this->db->select('*')
			->from('user')
			->where("(mobilenumber='".$mobileno."')", "", FALSE)
			->where("usertype", 1)
			->get();
		
		if ($query->num_rows() == 1) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	function CheckAdminLogin($emailid,$password) {

		$query = $this->db->select('*')
			->from('admin')
			->where("(email='".$emailid."')", "", FALSE)
			->where("password", $password)
			->get();
		
		if ($query->num_rows() == 1) {
			return $query->row_array();
		} else {
			return 0;
		}

	}
	function CheckFoodiesLoginWithEmail($emailid,$password){
		$query = $this->db->select('*')
			->from('user')
			->where("(email='".$emailid."')", "", FALSE)
			->where("password", $password)
			->get();
		
		if ($query->num_rows() == 1) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	function CheckKitchenIDAvailable($kitchenid, $ID = ''){
		$where = "kitchenid='".$kitchenid."'";
		
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
	function CheckEmailAvailable($email, $ID = '') {

		$where = "email='".$email."'";
		
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
	function CheckMobileNumberAvailable($mobilenumber,$usertype=0, $ID = '') {

		$where = "usertype = ".$usertype." AND mobilenumber='".$mobilenumber."'";
		
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
	function getUserData($where=array()){

		$query = $this->db->select("id,kitchenname,address,stateid,cityid,IFNULL((SELECT name FROM province WHERE id=stateid),'') as state,IFNULL((SELECT name FROM city WHERE id=cityid),'') as city,status")
				->from($this->_table." as u")
				->where($where)
				->order_by("u.id","DESC")
				->get();
		
		return $query->result_array();
	}
	
	function getUserDataByID($ID){
		$query = $this->db->select("id,kitchenname,kitchenid,password,email,address,stateid,cityid,status,pincode,contactname,role,mobilenumber,kitchencontactnumber,fssailicenceno,expirydate,panno,gstno,menufile,
			firmtype,foodtype,fromtime,totime,opendays,mealtype,
			userstatus,createddate,modifieddate,
			IFNULL((SELECT name FROM province WHERE id=stateid),'') as state,
			IFNULL((SELECT name FROM city WHERE id=cityid),'') as city,otpcode,otpdate,isverifiedotp,
			wallet,latitude,longitude,
			profile_image,description,
			
			CAST(IFNULL((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)),0) AS DECIMAL(2,1)) as averagerating, 

			IFNULL((SELECT id FROM userdocuments WHERE userid=u.id LIMIT 1),'') as documentid,
			IFNULL((SELECT file FROM userdocuments WHERE userid=u.id LIMIT 1),'') as documentfile
		")
		
							->from($this->_table." as u")
							->where("id='".$ID."'")
							->get();
							
		if ($query->num_rows() == 1) {
			return $query->row_array();
		}else {
			return 0;
		}	
	}

	function getCustomerAddress($limit,$offset=0,$PostData="", $count=0){
		
		$this->db->select("ca.id,ca.address,ca.latitude,ca.longitude,ca.is_delivery,ca.createddate,ca.modifieddate");
							
		$this->db->from('customer_address as ca');
		$this->db->where("ca.user_id='".$PostData['customerid']."'");
		$this->db->order_by("ca.id","DESC");
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

	function getUserDocuemnts($userid){
		
		$query = $this->db->select("id,file")
				->from('userdocuments')
				->where("userid='".$userid."'")
				->get();
				
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else {
			return array();
		}
	}
	function getKitchenBankAccounts($userid){
		
		$query = $this->db->select("*")
				->from('kitchenaccount')
				->where("kitchen_id='".$userid."'")
				->get();
				
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else {
			return array();
		}
	}
	
	function getAdminDataByID($ID){
		$query = $this->db->select("id,firstname,lastname,image,email,mobileno,password")
							->from('admin')
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
		// $usertype = isset($_REQUEST['usertype'])?$_REQUEST['usertype']:"0";

		$this->db->select("id,kitchenname,kitchenid,email,address,IFNULL((SELECT name FROM province WHERE id=stateid),'') as state,IFNULL((SELECT name FROM city WHERE id=cityid),'') as city,status,userstatus");
		$this->db->from($this->_table." as u");
		$this->db->where("usertype=0");
		// $this->db->where("(usertype='".$usertype."' OR '".$usertype."'='')");

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
	function getActiveUsersByType($type){
		
		$query = $this->db->select("id,concat(firstname,' ',lastname) as name")
				->from($this->_table." as u")
				->where("status=1 AND usertype=".$type)
				->order_by("u.firstname","ASC")
				->get();
		
		return $query->result_array();
	}
	public function insertauthverification($id,$code){
		
		$userid = $id;
		$this->load->model('User_model', 'User');
		$this->User->_table = 'authverification';
		$this->User->_fields = '*';
        $this->User->_where = array('userid'=>$id, 'status'=>0);
		$data = $this->User->getRecordsById();

		$createddate = $this->general_model->getCurrentDateTime();
		if(!empty($data)){
			
			$updatedata = array('code'=>$code,
								'createddate'=>$createddate);

			$this->User->_where = array('id'=>$data['id']);
			$this->User->Edit($updatedata);

		}else{
			$insertdata=array('userid'=>$userid,
                            'code'=>$code,
                            'createddate'=>$createddate);

			$this->User->Add($insertdata);
		}
	}
	function getKitchenDetails($userid){
		$query = $this->db->select("id,kitchenname,email,password,address,pincode,contactname,role,mobilenumber,kitchencontactnumber,fssailicenceno,expirydate,panno,gstno,
			IFNULL((SELECT name FROM province WHERE id=stateid),'') as state,
			IFNULL((SELECT name FROM city WHERE id=cityid),'') as city,
			firmtype,foodtype,fromtime,totime,opendays,mealtype
		")
		
							->from($this->_table)
							->where("id='".$userid."'")
							->get();
							
		if ($query->num_rows() == 1) {
			return $query->row_array();
		}else {
			return 0;
		}	
	}
	function countKitchenFoodList($search=""){
		$this->db->select("count(m.id) as total");
		$this->db->from("mastermenu as m");
		$this->db->join("user as u", "u.id=m.userid", "INNER");
		$this->db->where("u.status=1 AND u.usertype=0");
		if($search!=""){
			$this->db->where("(u.kitchenname LIKE '%".$search."%' OR m.itemname LIKE '%".$search."%')");
		}

		$query = $this->db->get()->row_array();
		
		return !empty($query['total'])?$query['total']:0;
	}
	function getKitchenFoodList($limit,$offset=0,$PostData="", $count=0, $with_radius=1){

		/* if($count==1){
			$this->db->select("count(m.id) as total");
		}else{
			$this->db->select("m.id,m.userid,u.kitchenid,u.kitchenname,m.itemname,m.itemprice,m.itemdetail,m.image,m.cuisinetype,m.menutype,m.instock,
				CAST((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)) AS DECIMAL(2,1)) as averagerating, 
				(SELECT count(fd.id) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)) as countreview,

				IFNULL((SELECT discount FROM offer WHERE discounttype=0 AND userid=u.id AND enddate >= CURDATE() ORDER BY discount DESC LIMIT 1),'0') as discount
			");
		}
		$this->db->from("mastermenu as m");
		$this->db->join("user as u", "u.id=m.userid", "INNER");
		$this->db->where("u.status=1 AND u.usertype=0");
		if(!empty($where)){
			$this->db->where($where);
		}

		$this->db->order_by("u.id","DESC");
		if($count==0){
			$this->db->limit($limit,$offset);
			$query = $this->db->get();
			
			return $query->result_array();
		}else{
			$query = $this->db->get()->row_array();
		
			return !empty($query['total'])?$query['total']:0;
		} */
		// print_r($PostData); exit;
		$where = " WHERE 1=1";
		if(!empty($PostData)){
			$search_package = '';
			if(isset($PostData['search_kitchen_meals'])){
				$search_package .= " AND (u.kitchenname LIKE '%".$PostData['search_kitchen_meals']. "%' OR 
								u.address LIKE '%".$PostData['search_kitchen_meals']. "%' OR
								p.name LIKE '%".$PostData['search_kitchen_meals']. "%' OR 
								c.name LIKE '%".$PostData['search_kitchen_meals']."%' OR 
								u.pincode LIKE '%".$PostData['search_kitchen_meals']."%' OR
								u.foodtype LIKE '%".$PostData['search_kitchen_meals']. "%' OR
								IF((SELECT count(id) FROM packages WHERE userid=u.id AND (packagename LIKE '%" . $PostData['search_kitchen_meals'] . "%'))>0, 1, 0)=1 OR
								IF((SELECT count(id) FROM mastermenu WHERE userid=u.id AND (itemname LIKE '%" . $PostData['search_kitchen_meals'] . "%'))>0, 1, 0)=1
							)";

				// $search_package .= " AND ";
			}
			if(isset($PostData['itemtype'])){
				if($PostData['itemtype'] != 2){ 
					if($PostData['itemtype']==0){
						$meal_type = "Veg";
					}else{
						$meal_type = "Non Veg";
					}
					$where .= " AND (FIND_IN_SET('".$meal_type."', temp.mealtype)>0)";
				}else{
					$where .= " AND (FIND_IN_SET('Veg', temp.mealtype)>0 OR FIND_IN_SET('Non Veg', temp.mealtype)>0)";
				}
			}
			if(isset($PostData['mealtype']) && $PostData['mealtype'] != ""){
				if($PostData['mealtype'] == 0){ 
					$meal_for = "Breakfast";
				}elseif($PostData['mealtype'] == 1){ 
					$meal_for = "Lunch";    
				}else{
					$meal_for = "Dinner";
				}
				$where .= " AND (FIND_IN_SET('".$meal_for."', temp.mealtype)>0)";
			}
			if($PostData['cuisinetype'] != ""){
				if($PostData['cuisinetype'] == 0){ 
					$cuisine_type = "South Indian Meals";    
				}elseif($PostData['cuisinetype'] == 1){ 
					$cuisine_type = "North Indian Meals";
				}else{
					$cuisine_type = "Diet Meals";
				}
				$where .= " AND (FIND_IN_SET('".$cuisine_type."', temp.foodtype)>0)";
			}
			$wh_plan = "";
			if($PostData['mealplan']!=""){
				if($PostData['mealplan']==0){
					$wh_plan .= " AND IF((SELECT count(id) FROM packages WHERE userid=u.id AND weeklyplantype=1)>0, 1, 0)=1";
				}else if($PostData['mealplan']==1){
					$wh_plan .= " AND IF((SELECT count(id) FROM packages WHERE userid=u.id AND monthlyplantype=1)>0, 1, 0)=1";
				}else{
					$wh_plan .= " AND IF((SELECT count(id) FROM mastermenu WHERE userid=u.id)>0, 1, 0)=1";
				}
			}
			$wh_price = "";
			if($PostData['price'] != ""){
				$wh_price .= " AND 
					(IF((SELECT count(id) FROM mastermenu WHERE userid=u.id AND itemprice BETWEEN '".explode("-",$PostData['price'])[0]."' AND '".explode("-",$PostData['price'])[1]."')>0, 1, 0)=1 OR 
					IF((SELECT count(id) FROM packages WHERE userid=u.id AND weeklyprice BETWEEN '".explode("-",$PostData['price'])[0]."' AND '".explode("-",$PostData['price'])[1]."')>0, 1, 0)=1)";
			}
			if($PostData['rating'] != ""){
				$where .= " AND (temp.averagerating >= '".$PostData['rating']."')";
			}
		}

		
		/* if($count==1){
			$query = "SELECT temp.id";
		}else{ */
			$query = "SELECT temp.id,temp.kitchenid,temp.kitchenname,
					temp.address,temp.provincename,temp.cityname,temp.pincode,
					temp.averagerating,temp.countreview,temp.discount,temp.createddate,temp.foodtype,temp.profile_image,temp.is_favourite,temp.mealtype
				";
		// }
		$query .= " FROM (
						SELECT u.id,u.kitchenid,u.kitchenname,u.address,
						CAST(IFNULL((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)),0) AS DECIMAL(2,1)) as averagerating, 
						(SELECT count(fd.id) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)) as countreview,

						IFNULL((SELECT discount FROM offer WHERE discounttype=0 AND (userid=0 OR userid=u.id) AND enddate >= CURDATE() ORDER BY discount DESC LIMIT 1),'0') as discount,u.createddate,

						p.name as provincename,c.name as cityname,u.pincode,u.foodtype,u.profile_image,

						IF(IFNULL((SELECT count(id) FROM favorite_kitchen WHERE customerid='".$PostData['customer_id']. "' AND kitchenid=u.id),'0')>0,1,0) as is_favourite,

						u.mealtype
						
						FROM user as u
						LEFT JOIN province as p ON p.id=u.stateid
						LEFT JOIN city as c ON c.id=u.cityid
						WHERE u.status=1 AND u.userstatus=1 AND u.usertype=0 
						".$wh_price."
						".$wh_plan."
						".$search_package."
						";

		$query .= " ) as temp ".$where;
		$query .= " ORDER BY temp.createddate DESC";

		if($count==0){
			$query .= " LIMIT ".$offset.",".$limit;
		}
		
		$query = $this->db->query($query);
		$data = $query->result_array();

		$return_array = array();
		foreach($data as $row){

			$total_distance = $distance = $duration = 0;
			if($PostData['cust_location']!="" && $row['address']!=""){
				$distance = json_decode(get_duration_between_two_places($row['address'], $PostData['cust_location'], 'both', 1));
				
				$total_distance = str_replace(",","",$distance->distance);
				$duration = $distance->duration;
				
				$distance = $distance->distance;
			}

			if($with_radius==1){
				if($total_distance <= RADIUS_IN_KM || RADIUS_IN_KM==0){
					$return_array[] = array_merge($row, array('distance'=> $distance, "duration"=> $duration));
				}
			}else{
				$return_array[] = array_merge($row, array('distance' => $distance, "duration" => $duration));
			}
		}

		if ($count == 0) {
			return $return_array;
		}else{
			return count($return_array);
		}
		/* if($count==0){
			$query .= " LIMIT ".$offset.",".$limit;
			$query = $this->db->query($query);
			// echo $this->db->last_query(); exit;
			$data = $query->result_array();

			$return_array = array();
			foreach($data as $row){

				$distance = json_decode(get_duration_between_two_places($row['address'], $PostData['cust_location'], 'both', 1));

				if($distance->distance <= RADIUS_IN_KM){
					$return_array[] = array_merge($row, array('distance'=> $distance->distance, "duration"=>$distance->duration));
				}
			}
			return $return_array;
		}else{
			$query = $this->db->query($query)->row_array();;
		
			return !empty($query['total'])?$query['total']:0;
		} */
	}

	function getKitchenDetailByKitchenID($kitchenid){

		$customerid = !empty($this->session->userdata(base_url().'FOODIESUSERID')) ? $this->session->userdata(base_url().'FOODIESUSERID') : 0;

		$query = $this->db->select("id,kitchenname,email,password,address,pincode,contactname,role,mobilenumber,kitchencontactnumber,fssailicenceno,expirydate,panno,gstno,
			IFNULL((SELECT name FROM province WHERE id=stateid),'') as state,
			IFNULL((SELECT name FROM city WHERE id=cityid),'') as city,
			firmtype,foodtype,fromtime,totime,opendays,mealtype,u.profile_image,

			IFNULL((SELECT count(id) FROM mastermenu WHERE userid=u.id AND cuisinetype=0),0) as issouthindian,
			IFNULL((SELECT count(id) FROM mastermenu WHERE userid=u.id AND cuisinetype=1),0) as isnorthindian,
			IFNULL((SELECT count(id) FROM mastermenu WHERE userid=u.id AND cuisinetype=2),0) as isotherindian,
			
			u.fromtime,u.totime,

			CAST((SELECT AVG(fd.rating) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)) AS DECIMAL(2,1)) as averagerating, 
			IFNULL((SELECT COUNT(fd.id) FROM feedback as fd WHERE fd.kitchen_id=u.id AND fd.customer_id IN (SELECT id FROM user WHERE status=1 AND usertype=1)),0) as totalreview, 

			IF((SELECT count(id) FROM favorite_kitchen WHERE customerid=".$customerid.") > 0, 1, 0) as isfavoritekitchen
		")
		
							->from($this->_table." as u")
							->where("u.kitchenid='".$kitchenid."' AND u.usertype=0 AND u.status=1")
							->get();
							
		if ($query->num_rows() == 1) {
			return $query->row_array();
		}else {
			return 0;
		}	
	}

	function getTrialMealList($limit,$offset=0,$where="", $count=0){

		if($count==1){
			$this->db->select("count(m.id) as total");
		}else{
			$this->db->select("m.id,m.userid,m.itemname,m.itemprice,m.itemdetail,m.image,m.cuisinetype,m.menutype,m.instock");
		}
		$this->db->from("mastermenu as m");
		$this->db->join("user as u", "u.id=m.userid", "INNER");
		$this->db->where("u.status=1 AND u.usertype=0");
		if(!empty($where)){
			$this->db->where($where);
		}

		$this->db->order_by("u.id","DESC");
		if($count==0){
			$this->db->limit($limit,$offset);
			$query = $this->db->get();
			
			return $query->result_array();
		}else{
			$query = $this->db->get()->row_array();
		
			return !empty($query['total'])?$query['total']:0;
		}
	}

	function getReviewsInFoodies($limit,$offset=0,$where="", $count=0){
		if($count==1){
			$this->db->select("count(f.id) as total");
		}else{
			$this->db->select("f.id,f.kitchen_id,f.customer_id,f.rating,f.message,f.foodquality,f.taste,f.quantity,f.createddate,
				u.kitchenname as customername, u.profile_image");
		}
		$this->db->from("feedback as f");
		$this->db->join("user as u", "u.id=f.customer_id", "LEFT");
		$this->db->where("u.status=1 AND u.usertype=1");
		if(!empty($where)){
			$this->db->where($where);
		}

		$this->db->order_by("f.id","DESC");
		if($count==0){
			$this->db->limit($limit,$offset);
			$query = $this->db->get();
			
			return $query->result_array();
		}else{
			$query = $this->db->get()->row_array();
		
			return !empty($query['total'])?$query['total']:0;
		}
	}

	function getFoodiesWalletBalance($foodiesid){
		$query = $this->db->select("
					IFNULL((u.wallet - 
						IFNULL((SELECT SUM(o.netamount) FROM orders as o WHERE o.customerid=u.id AND o.status NOT IN (2,7)),0)
					),0) as amount")
				 ->from("user as u")
				 ->where("u.usertype=1 AND u.id=".$foodiesid)
				 ->get();
				 
		$user = $query->row_array();

		return $user['amount'];
	}

	function getDistance($latitude_1,$longitude_1,$latitude_2,$longitude_2){
		
		$query = $this->db->query("SELECT getDistance('".$latitude_1."','".$longitude_1."','".$latitude_2."','".$longitude_2."') as distance");

		$result = $query->row_array();
		
		return !empty($result['distance'])?$result['distance']:0;

	}

	function getFoodiesCards($customer_id){
		
		$query = $this->db->select("c.id,c.userid,c.card_name,c.card_number,c.holder_name,c.valid_thru,c.image,c.is_default,c.created_date")
							->from('cards as c')
							->where("c.userid='".$customer_id."'")
							->get();
							
		return $query->result_array();
	}
	function getCardDataById($card_id){
		
		$query = $this->db->select("c.id,c.userid,c.card_name,c.card_number,c.holder_name,c.valid_thru,c.image,c.is_default,c.created_date")
							->from('cards as c')
							->where("c.id='".$card_id."'")
							->get();
							
		return $query->row_array();
	}
	function getKitchenWalletData($kitchenid){
		
		$query = $this->db->select("kwp.id,kwp.kitchen_id,kwp.amount,kwp.status,kwp.createddate,kwp.wallet_amount")
				->from('kitchenwithdrawpayment as kwp')
				->where("kwp.kitchen_id='".$kitchenid."'")
				->order_by("kwp.id DESC")
				->get();
				
		return $query->result_array();
	}
	function getKitchenList()
	{

		$query = $this->db->select("id,kitchenname,email,mobilenumber")
		->from($this->_table)
			->where("usertype=0 AND status=1 AND userstatus=1")
			->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return 0;
		}
	}
	function getRecentKitchensList() {

		$query = $this->db->select("k.id,k.kitchenname,k.email,k.mobilenumber,k.profile_image,
			(SELECT count(am.id) FROM adminmessages as am WHERE am.userid=k.id AND am.isread='n' AND am.msg_type='usertoadmin') as new_msg, 
			IFNULL((SELECT am.createddate FROM adminmessages as am WHERE am.userid=k.id ORDER BY id DESC LIMIT 1),'') as time,
			IFNULL((SELECT am.message FROM adminmessages as am WHERE am.userid=k.id ORDER BY id DESC LIMIT 1),'') as lastmsg
		")
			->from($this->_table . " as k")
			->where("k.usertype=0 AND k.status=1 AND k.userstatus=1")
			->order_by("time DESC, k.kitchenname ASC")
			->get();

		if ($query->num_rows() > 0) {
			$data = $query->result_array();

			foreach ($data as $k => $row) {
				if ($row['profile_image'] != "" && file_exists(USER_PROFILE_PATH . $row['profile_image'])) {
					$img = USER_PROFILE. $row['profile_image'];
				} else {
					$img = NOPROFILEIMAGE;
				}
				$data[$k]['profile_image'] = $img;
				if ($row['time'] != "") {
					$data[$k]['time'] = $this->general_model->time_Ago(strtotime($row['time']));
				}
			}

			return $data;
		} else {
			return 0;
		}
	}
	function getKitchenChat($kitchenid) {

		$query = $this->db->select("userid,message,msg_type,createddate")
			->from("adminmessages as am")
			->where("am.userid=" . $kitchenid)
			->order_by("am.id ASC")
			->get();

		if ($query->num_rows() > 0) {
			$data = $query->result_array();

			foreach ($data as $k => $row) {
				$data[$k]['time'] = $this->general_model->time_Ago(strtotime($row['createddate']));
			}

			return $data;
		} else {
			return 0;
		}
	}
	function unReadChat($kitchenid) {
		$this->User->_table = "adminmessages";
		$this->User->_where = array("userid" => $kitchenid, "msg_type" => "usertoadmin");
		$this->User->Edit(array("isread" => "y"));
	}

	function getAdminChatDetail($kitchenid) {

		$query = $this->db->select("a.id,CONCAT(a.firstname,' ',a.lastname) as name,a.email,a.mobileno, a.image,
			(SELECT count(am.id) FROM adminmessages as am WHERE am.userid=".$kitchenid. " AND am.isread='n' AND am.msg_type='admintouser') as new_msg, 
			IFNULL((SELECT am.createddate FROM adminmessages as am WHERE am.userid=" . $kitchenid ." ORDER BY id DESC LIMIT 1),'') as time,
			IFNULL((SELECT am.message FROM adminmessages as am WHERE am.userid=" . $kitchenid . " ORDER BY id DESC LIMIT 1),'') as lastmsg
		")
			->from("admin as a")
			->where("a.id=1")
			->order_by("time DESC, name ASC")
			->get();

		if ($query->num_rows() > 0) {
			$data = $query->row_array();

			if ($data['time'] != "") {
				$data['time'] = $this->general_model->time_Ago(strtotime($data['time']));
			}
			return $data;
		} else {
			return 0;
		}
	}
	function unReadAdminChat($kitchenid) {
		$this->User->_table = "adminmessages";
		$this->User->_where = array("userid" => $kitchenid, "msg_type" => "admintouser");
		$this->User->Edit(array("isread" => "y"));
	}

	function countUnReadMessageForAdmin($usertype = "kitchen") {
		
		$where = "";
		if($usertype=="kitchen"){
			$where .= " AND am.userid IN (SELECT id FROM user WHERE usertype=0 AND userstatus=1 AND status=1)";
		} elseif ($usertype == "rider") {
			$where .= " AND am.userid IN (SELECT id FROM user WHERE usertype=2 AND userstatus=1 AND status=1)";
		}
		$Count = $this->db->select('am.id')
			->from("adminmessages as am")
			->where("am.msg_type='usertoadmin' AND isread='n'". $where)
			->get()
			->result_array();

		return !empty($Count) ? count($Count) : 0;
	}

	function countUnReadMessageForKitchen($kitchenid) {

		$where = " AND am.userid IN (SELECT id FROM user WHERE id=".$kitchenid." AND usertype=0 AND userstatus=1 AND status=1)";

		$Count = $this->db->select('am.id')
						->from("adminmessages as am")
						->where("am.msg_type='admintouser' AND isread='n'" . $where)
						->get()
						->result_array();

		return !empty($Count) ? count($Count) : 0;
	}
	
	function check_if_user_logged_in()
	{
        $user_id = $this->session->userdata(base_url().'FOODIESUSERID');
        $valid_user = false;
        if (isset($user_id) && $user_id > 0)
        {
            $valid_user = true;
        }
        if ($valid_user)
        {
            $user_type = $this->session->userdata(base_url().'USERTYPE');
            if ($user_type == '0')
            {
                redirect(KITCHEN_URL, 'refresh');
            }
            else if ($user_type == '1')
            {
                redirect(FRONT_URL, 'refresh');
            }
            else if ($user_type == '2')
            {
                redirect(RIDER_URL, 'refresh');
            }
        }
	}

}
