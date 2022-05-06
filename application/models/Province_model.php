<?php

class Province_model extends Common_model {

	//put your code here
	public $_table = 'province';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	
	function __construct() {
		parent::__construct();
	}
	
	function getProvinceDataByID($ID){
		$query = $this->db->select("id,name,countryid")
							->from($this->_table)
							->where("id", $ID)
							->get();
		
		if ($query->num_rows() == 1) {
			return $query->row_array();
		}else {
			return 0;
		}	
	}
	function getProvinceData($where=array(),$order=array("p.id"=>"DESC")){

		$query = $this->db->select("id,name")
				->from($this->_table." as p")
				->where($where)
				->order_by(key($order),$order[key($order)])
				->get();
		
		return $query->result_array();
	}
}
