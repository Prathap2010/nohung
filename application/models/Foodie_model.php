<?php

class Foodie_model extends Common_model {

	//put your code here
	public $_table = 'user';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $column_order = array(null,'kitchenname','email','mobilenumber','userstatus'); //set column field database for datatable orderable
	public $column_search = array('kitchenname','email','mobilenumber'); //set column field database for datatable searchable 
	public $_order = array('u.id' => 'DESC'); // default order

	function __construct() {
		parent::__construct();
	}
    function CheckEmailAvailable($email, $ID = '') {

		$where = "usertype=1 AND email='".$email."'";
		
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

		$where = "usertype = 1 AND mobilenumber='".$mobilenumber."'";
		
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
    function getFoodieDataByID($ID){
		
        $query = $this->db->select("id,kitchenname,password,email,mobilenumber,profile_image,otpcode,otpdate,isverifiedotp,wallet,status,userstatus,createddate,modifieddate")
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
		
		$this->db->select("id,kitchenname,email,mobilenumber,profile_image,status,userstatus");
		$this->db->from($this->_table." as u");
		$this->db->where("u.usertype=1");

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

}