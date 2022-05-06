<?php

class City_model extends Common_model {

	//put your code here
	public $_table = 'city';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();

	function __construct() {
		parent::__construct();
	}
	
	function getCityDataByID($ID){
		$query = $this->db->select("id,name,(SELECT countryid FROM province WHERE id=stateid) as countryid,stateid,(SELECT name FROM province WHERE id=stateid) as state")
							->from($this->_table)
							->where("id", $ID)
							->get();
		
		if ($query->num_rows() == 1) {
			return $query->row_array();
		}else {
			return 0;
		}	
	}

	function getCityByProvince($provinceid){

		$query = $this->db->select("id,name")
								->from($this->_table)
								->where(array("stateid"=>$provinceid))
								->order_by("name ASC")
								->get();
		
		return $query->result_array();
	}
	
	function getCityData($where=array(),$order=array("c.id"=>"DESC")){

		$query = $this->db->select("id,name,IFNULL((select name from province where id=stateid),'') as state,createddate")
				->from($this->_table." as c")
				->where($where)
				->order_by(key($order),$order[key($order)])
				->get();
		
		return $query->result_array();
	}
}
