<?php

class Offer_model extends Common_model {

	//put your code here
	public $_table = 'offer';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $_order;

	function __construct() {
		parent::__construct();
	}
	/* public function searchOffer($title){         
		$this->db->select(array('o.id', 'o.title'));
        $this->db->from('offer as o');
        $this->db->like('o.title', $title, 'both');
        $query = $this->db->get();

        return $query->result_array();
	} */
	function getOfferListData(){

		$query = $this->db->select("id, title, description,offercode,discounttype,discount,startdate,enddate,IF(usertype=0,'Admin',(SELECT kitchenname FROM user WHERE id=addedby)) as addedbyname,createddate")
				->from($this->_table)
				->order_by("id","DESC")
				->get();
	
		return $query->result_array();
	}

    function CheckOfferAvailable($offercode,$id='')
    {
        if (isset($id) && $id != '') {
            $query = $this->db->query("SELECT id FROM offer WHERE offercode ='".$offercode."' AND id <> '".$id."'");
        }else{
            $query = $this->db->query("SELECT id FROM offer WHERE offercode ='".$offercode."'");
        }
       
        if($query->num_rows()  > 0){
            return 0;
        }
        else{
            return 1;
        }
	}
	function getOffers($type='live',$where=""){

		$this->db->select("id,title,description,offercode,discounttype,discount,startdate,enddate,IF(usertype=0,'Admin',(SELECT kitchenname FROM user WHERE id=addedby)) as addedbyname,createddate");
		$this->db->from($this->_table);
		/* if(!empty($where)){
			$this->db->where($where);
		} */
		if($type=="live"){
			$this->db->where("(enddate >= CURDATE())".$where);
		}else{
			$this->db->where("(enddate < CURDATE())".$where);
		}
		$this->db->order_by("id","DESC");
		$query = $this->db->get();
	
		return $query->result_array();
	}
	function getOffersdata($type='live',$where=""){

		$this->db->select("id,title,description,offercode,discounttype,discount,startdate,enddate,IF(usertype=0,'Admin',(SELECT kitchenname FROM user WHERE id=addedby)) as addedbyname,createddate");
		$this->db->from($this->_table);
		/* if(!empty($where)){
			$this->db->where($where);
		} */
		if($type=="live"){
			$this->db->where("(enddate >= CURDATE())".$where);
		}else{
			$this->db->where("(enddate < CURDATE())".$where);
		}
		$this->db->order_by("id","DESC");
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	function getOfferDataByID($id){

		$this->db->select("id,title,description,offercode,discounttype,discount,startdate,enddate,IF(usertype=0,'Admin',(SELECT kitchenname FROM user WHERE id=addedby)) as addedbyname,createddate,starttime,endtime,appliesto,minrequirement,usagelimit");
		$this->db->from($this->_table);
		$this->db->where("id=".$id);
		$query = $this->db->get();
	
		return $query->row_array();
	}
	function getOfferDataByOffercode($kitchen_id, $offercode){

		$this->db->select("id,title,description,offercode,discounttype,discount,startdate,enddate,IF(usertype=0,'Admin',(SELECT kitchenname FROM user WHERE id=addedby)) as addedbyname,createddate,starttime,endtime,appliesto,minrequirement,usagelimit,IFNULL((SELECT count(id) FROM orders WHERE couponcode=offercode),0) as countusage");
		$this->db->from($this->_table);
		$this->db->where("(userid=0 OR userid='".$kitchen_id."') AND offercode='".$offercode."'");
		$query = $this->db->get();
	
		return $query->row_array();
	}

	function getKitchenOffers($limit,$offset=0,$PostData="", $count=0){

		if($count == 1){
			$this->db->select("id");
		}else{
			$this->db->select("id,title,description,offercode,discounttype,discount,startdate,enddate,IF(usertype=0,'Admin',(SELECT kitchenname FROM user WHERE id=addedby)) as addedbyname,createddate");
		}
		$this->db->from($this->_table);
		$this->db->where("userid='".$PostData['kitchenid']."'");
		if($PostData['type']=="live"){
			$this->db->where("(enddate >= CURDATE())");
		}else{
			$this->db->where("(enddate < CURDATE())");
		}
		if($PostData['search']!=""){
			$this->db->where("(title LIKE '%".$PostData['search']."%' OR offercode LIKE '%".$PostData['search']."%')");
		}
		
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
	
}
