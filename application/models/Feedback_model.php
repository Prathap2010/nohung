<?php

class Feedback_model extends Common_model {

	//put your code here
	public $_table = 'feedback';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $_order;

	function __construct() {
		parent::__construct();
	}
	function getFeedbackListData(){

		$query = $this->db->select("f.id,f.kitchen_id,f.customer_id,f.rating,f.message,f.createddate,f.modifieddate,IFNULL(c.name,'') as customername,IFNULL(u.kitchenname,'') as kitchenname")
				->from($this->_table." as f")
                ->join("customer as c","c.id=f.customer_id","LEFT")
                ->join("user as u","u.id=f.kitchen_id","LEFT")
				->order_by("f.id","DESC")
				->get();
	
		return $query->result_array();
	}
	
	function getFeedbackDataByID($id){

		$this->db->select("f.id,f.kitchen_id,f.customer_id,f.rating,f.message,f.createddate,f.modifieddate");
		$this->db->from($this->_table." as f");
		$this->db->where("f.id=".$id);
		$query = $this->db->get();
	
		return $query->row_array();
	}

	function getKitchenFeedback($limit,$offset=0,$PostData="", $count=0){

		$this->db->select("f.id,f.kitchen_id,f.customer_id,f.rating,f.message,f.createddate,IFNULL(c.kitchenname,'') as customername,IFNULL(c.profile_image,'') as customerimage,f.foodquality,f.taste,f.quantity");
		$this->db->from($this->_table." as f");
		$this->db->join("user as c","c.id=f.customer_id", "LEFT");
		$this->db->where("f.kitchen_id='".$PostData['kitchen_id']."'"); // AND f.submittype=1
		$this->db->order_by("f.id","DESC");
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

	function getKitchenOverallRatings($kitchen_id) {
		
		$this->db->select("
			IFNULL((SELECT avg(rating) FROM feedback WHERE kitchen_id = k.id),0) as overall_rating,
			IFNULL((SELECT count(id) FROM feedback WHERE kitchen_id = k.id),0) as total_review,
			
			IFNULL((SELECT count(id) FROM feedback WHERE kitchen_id = k.id AND rating=5),0) as excellent,
			IFNULL((SELECT count(id) FROM feedback WHERE kitchen_id = k.id AND rating=4),0) as verygood,
			IFNULL((SELECT count(id) FROM feedback WHERE kitchen_id = k.id AND rating=3),0) as good,
			IFNULL((SELECT count(id) FROM feedback WHERE kitchen_id = k.id AND rating=2),0) as fair,
			IFNULL((SELECT count(id) FROM feedback WHERE kitchen_id = k.id AND rating=1),0) as poor,
		");
		$this->db->from("user as k");
		$this->db->where("k.id='".$kitchen_id."'");
		$query = $this->db->get();

		return $query->row_array();
	}
}
