<?php

class Menu_model extends Common_model {

	//put your code here
	public $_table = 'mastermenu';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $_order;

	function __construct() {
		parent::__construct();
	}
	function searchitem($type,$search,$userid){

		$this->db->select("id,itemname as text");
		$this->db->from($this->_table);
		if($type==1){
			$this->db->where("itemname LIKE '%".$search."%'");
		}else{
			$this->db->where("itemname='".$search."'");
		}
		$this->db->where("userid=".$userid."");
		$this->db->group_by("itemname");
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			if($type==1){
				return $query->result_array();
			}else{
				return $query->row_array();
			}
		}else {
			return 0;
		}	
	}
	function getCountUserMasterMenu($userid){
		
		$query = $this->db->select('count(id) as count')
				->from($this->_table)
				->where("userid=".$userid)
				->get()
				->row_array();
		
		return $query['count'];
	}
	function getUserMasterMenu($userid){
		
		$menu=array();
		//South Indian
		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid." AND cuisinetype=0 AND menutype=0 AND itemtype=0")
				->get();

		$menu['southind']['breakfast']['veg'] = $query->result_array();

		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid." AND cuisinetype=0 AND menutype=0 AND itemtype=1")
				->get();

		$menu['southind']['breakfast']['nonveg'] = $query->result_array();

		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid. " AND cuisinetype=0 AND (menutype=1 OR menutype=2 OR menutype=3)")
				->get();

		$lunchdata = $query->result_array();
		$menu['si_lunch'] = $lunchdata;
		$menu['southind']['lunch'] = array();
		if(!empty($lunchdata)){
			foreach($lunchdata as $lunch){
				
				$menu['southind']['lunch'][$lunch['category']][] = $lunch;
			}
		}
		/* $query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid." AND cuisinetype=0 AND menutype=2")
				->get();

		$dinnerdata = $query->result_array();
		$menu['si_dinner'] = $dinnerdata;
		$menu['southind']['dinner'] = array();
		if(!empty($dinnerdata)){
			foreach($dinnerdata as $dinner){
				
				$menu['southind']['dinner'][$dinner['category']][] = $dinner;
			}
		} */

		//North Indian
		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid." AND cuisinetype=1 AND menutype=0 AND itemtype=0")
				->get();

		$menu['northind']['breakfast']['veg'] = $query->result_array();

		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid." AND cuisinetype=1 AND menutype=0 AND itemtype=1")
				->get();

		$menu['northind']['breakfast']['nonveg'] = $query->result_array();

		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid. " AND cuisinetype=1 AND (menutype=1 OR menutype=2 OR menutype=3)")
				->get();

		$lunchdata = $query->result_array();
		$menu['ni_lunch'] = $lunchdata;
		$menu['northind']['lunch'] = array();
		if(!empty($lunchdata)){
			foreach($lunchdata as $lunch){
				
				$menu['northind']['lunch'][$lunch['category']][] = $lunch;
			}
		}
		/* $query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid." AND cuisinetype=1 AND menutype=2")
				->get();

		$dinnerdata = $query->result_array();
		$menu['ni_dinner'] = $dinnerdata;
		$menu['northind']['dinner'] = array();
		if(!empty($dinnerdata)){
			foreach($dinnerdata as $dinner){
				
				$menu['northind']['dinner'][$dinner['category']][] = $dinner;
			}
		} */

		//Other Indian
		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid." AND cuisinetype=2 AND menutype=0 AND itemtype=0")
				->get();

		$menu['otherind']['breakfast']['veg'] = $query->result_array();

		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid." AND cuisinetype=2 AND menutype=0 AND itemtype=1")
				->get();

		$menu['otherind']['breakfast']['nonveg'] = $query->result_array();

		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid. " AND cuisinetype=2 AND (menutype=1 OR menutype=2 OR menutype=3)")
				->get();

		$lunchdata = $query->result_array();
		$menu['oi_lunch'] = $lunchdata;
		$menu['otherind']['lunch'] = array();
		if(!empty($lunchdata)){
			foreach($lunchdata as $lunch){
				
				$menu['otherind']['lunch'][$lunch['category']][] = $lunch;
			}
		}
		/* $query = $this->db->select($this->_fields)
				->from($this->_table)
				->where("userid=".$userid." AND cuisinetype=2 AND menutype=2")
				->get();

		$dinnerdata = $query->result_array();
		$menu['oi_dinner'] = $dinnerdata;
		$menu['otherind']['dinner'] = array();
		if(!empty($dinnerdata)){
			foreach($dinnerdata as $dinner){
				
				$menu['otherind']['dinner'][$dinner['category']][] = $dinner;
			}
		} */
		return $menu;
	}
	function getMasterMenu($where=array()){
		
		$query = $this->db->select($this->_fields)
				->from($this->_table)
				->where($where)
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
