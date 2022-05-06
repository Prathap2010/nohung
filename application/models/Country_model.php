<?php

class Country_model extends Common_model {

	//put your code here
	public $_table = 'country';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $_order = "name ASC";

	function __construct() {
		parent::__construct();
	}
    
	function getCountryCount(){
		$query = $this->db->select('count(id) as count')
			->from($this->_table)
			->get()->row_array();

		return $query['count'];
	}
	function getCountryData() {
		$query = $this->db->select("id,sortname,name,phonecode,createddate")
							->from($this->_table)
							->order_by("id","DESC")
							->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}

	}
    
    function getCountrycode() {
		$query = $this->db->select("id,phonecode")
							->from($this->_table)
							->where("phonecode!='' AND phonecode!='+0' AND phonecode!='+00'")
							->group_by("phonecode")
							->order_by("phonecode","ASC")
							->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}

	}

	function getCountryDataByID($id) {
		$query = $this->db->select("id,sortname,name,phonecode")
			->from($this->_table)
			->where("id",$id)
			->get();

		if ($query->num_rows() == 1) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	function getCountry($id=0) {

		$this->db->select("id,name");
		$this->db->from($this->_table);
		if($id!=0){
			$this->db->where("id=".$id);
		}
		$this->db->order_by($this->_order);
	
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
}
