<?php

class Withdraw_payment_model extends Common_model {

	//put your code here
	public $_table = 'withdrawpayment';
	public $_fields = "*";
	public $_where = array();
	public $_except_fields = array();
	public $_order;

	function __construct() {
		parent::__construct();
	}
	function getWithdrawPaymentList(){

		$query = $this->db->select("wp.id,wp.userid,wp.amount,wp.status,wp.createddate,
                    IFNULL(u.kitchenname,'') as ridername,
                    IFNULL(u.email,'') as rideremail,
                    IFNULL(u.mobilenumber,'') as ridercontactno
                ")
				->from($this->_table." as wp")
                ->join("user as u","u.id=wp.userid","LEFT")
                ->order_by("wp.id","DESC")
				->get();
	
		return $query->result_array();
	}
	
}
